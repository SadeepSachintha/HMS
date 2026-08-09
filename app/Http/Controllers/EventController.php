<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Customer;
use App\Models\EventLocation;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Event::with('location_rel');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('location', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Apply status filter if present
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Sorting functionality
        $sortBy = $request->get('sort', 'id');
        $sortOrder = $request->get('order', 'desc');

        // Validate sort column
        $allowedSortColumns = ['id', 'name', 'start_time', 'end_time', 'location', 'max_attendees', 'status', 'created_at'];
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'id';
        }

        // Validate sort order
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc';
        }

        $query->orderBy($sortBy, $sortOrder);

        $events = $query->paginate(10);

        // Preserve search and sort parameters in pagination
        if ($request->has('search')) {
            $events->appends(['search' => $request->search]);
        }
        if ($request->has('status')) {
            $events->appends(['status' => $request->status]);
        }
        if ($request->has('sort')) {
            $events->appends(['sort' => $request->sort]);
        }
        if ($request->has('order')) {
            $events->appends(['order' => $request->order]);
        }

        return view('events.index', compact('events'));
    }

    public function create()
    {
        $customers = Customer::all();
        $staff = \App\Models\Staff::active()->get();
        $locations = EventLocation::active()->get();
        return view('events.create', compact('customers', 'staff', 'locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date|after_or_equal:today',
            'end_time' => 'required|date|after:start_time',
            'location' => 'nullable|string|max:255',
            'location_id' => 'required|exists:event_locations,id',
            'max_attendees' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'customer_id' => 'required|exists:customers,id',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
            'notes' => 'nullable|string',
            'staff_ids' => 'nullable|array',
            'staff_ids.*' => 'exists:staff,id',
            'staff_roles' => 'nullable|array',
        ]);

        // If location_id is provided, use its name as the 'location' string for fallback
        if ($request->location_id) {
            $loc = EventLocation::find($request->location_id);
            $validated['location'] = $loc->name;
        }

        $event = Event::create($validated);

        // Attach staff if provided
        if (!empty($request->staff_ids)) {
            $syncData = [];
            foreach ($request->staff_ids as $index => $staffId) {
                $role = $request->staff_roles[$index] ?? null;
                $syncData[$staffId] = ['role' => $role];
            }
            $event->staff()->sync($syncData);
        }

        return redirect()->route('events.index')
            ->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        $assignedStaffIds = $event->staff->pluck('id');
        $availableStaff = \App\Models\Staff::active()->whereNotIn('id', $assignedStaffIds)->get();
        return view('events.show', compact('event', 'availableStaff'));
    }

    public function edit(Event $event)
    {
        $customers = \App\Models\Customer::all();
        $assignedStaff = $event->staff;
        $locations = EventLocation::active()->get();
        return view('events.edit', compact('event', 'customers', 'assignedStaff', 'locations'));
    }

    public function update(Request $request, Event $event)
    {
        if ($event->invoice) {
            $validated = $request->validate([
                'status' => 'required|in:scheduled,in_progress,completed,cancelled',
                'notes' => 'nullable|string'
            ]);
            $event->update($validated);
        } else {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
                'location' => 'nullable|string|max:255',
                'location_id' => 'required|exists:event_locations,id',
                'max_attendees' => 'nullable|integer|min:1',
                'price' => 'nullable|numeric|min:0',
                'customer_id' => 'required|exists:customers,id',
                'status' => 'required|in:scheduled,in_progress,completed,cancelled',
                'notes' => 'nullable|string'
            ]);

            if ($request->location_id) {
                $loc = EventLocation::find($request->location_id);
                $validated['location'] = $loc->name;
            }

            $event->update($validated);
        }

        return redirect()->route('events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        abort(403, 'Deletion is disabled.');
    }

    public function calendar()
    {
        $events = Event::all()->map(function($event) {
            return [
                'id' => $event->id,
                'title' => $event->name,
                'start' => $event->start_time->format('Y-m-d H:i:s'),
                'end' => $event->end_time->format('Y-m-d H:i:s'),
                'location' => $event->location_rel->name ?? $event->location,
                'status' => $event->status,
                'color' => $this->getEventColor($event->status)
            ];
        });

        return response()->json($events);
    }

    private function getEventColor($status)
    {
        switch ($status) {
            case 'scheduled':
                return '#007bff'; // primary blue
            case 'in_progress':
                return '#ffc107'; // warning yellow
            case 'completed':
                return '#28a745'; // success green
            case 'cancelled':
                return '#dc3545'; // danger red
            default:
                return '#6c757d'; // secondary gray
        }
    }

    public function assignStaff(Request $request, Event $event)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'role' => 'required|string|max:255',
        ]);
        // Only allow assignment if staff is active
        $staff = \App\Models\Staff::active()->find($validated['staff_id']);
        if (!$staff) {
            return redirect()->route('events.show', $event)->with('error', 'Only active staff can be assigned.');
        }
        $event->staff()->attach($validated['staff_id'], ['role' => $validated['role']]);
        return redirect()->route('events.show', $event)->with('success', 'Staff assigned successfully.');
    }

    public function removeStaff(Event $event, $staffId)
    {
        $event->staff()->detach($staffId);
        return redirect()->route('events.show', $event)->with('success', 'Staff removed successfully.');
    }
}
