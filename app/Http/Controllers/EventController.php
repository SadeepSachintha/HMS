<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Customer;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Event::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('location', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Sorting functionality
        $sortBy = $request->get('sort', 'id');
        $sortOrder = $request->get('order', 'desc');

        // Validate sort column
        $allowedSortColumns = ['id', 'name', 'start_date', 'end_date', 'location', 'capacity', 'status', 'created_at'];
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
        return view('events.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|max:255',
            'max_attendees' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'customer_id' => 'required|exists:customers,id',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        Event::create($validated);

        return redirect()->route('events.index')
            ->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        $assignedStaffIds = $event->staff->pluck('id');
        $availableStaff = \App\Models\Staff::whereNotIn('id', $assignedStaffIds)->get();
        return view('events.show', compact('event', 'availableStaff'));
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:scheduled,ongoing,completed,cancelled'
        ]);

        $event->update($validated);

        return redirect()->route('events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully.');
    }

    public function calendar()
    {
        $events = Event::all()->map(function($event) {
            return [
                'id' => $event->id,
                'title' => $event->name,
                'start' => $event->start_time->format('Y-m-d H:i:s'),
                'end' => $event->end_time->format('Y-m-d H:i:s'),
                'location' => $event->location,
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
        $event->staff()->attach($validated['staff_id'], ['role' => $validated['role']]);
        return redirect()->route('events.show', $event)->with('success', 'Staff assigned successfully.');
    }

    public function removeStaff(Event $event, $staffId)
    {
        $event->staff()->detach($staffId);
        return redirect()->route('events.show', $event)->with('success', 'Staff removed successfully.');
    }
}
