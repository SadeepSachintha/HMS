<?php

namespace App\Http\Controllers;

use App\Models\EventLocation;
use Illuminate\Http\Request;

class EventLocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $locations = EventLocation::paginate(10);
        return view('event-locations.index', compact('locations'));
    }

    public function create()
    {
        return view('event-locations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        EventLocation::create($validated);

        return redirect()->route('event-locations.index')
            ->with('success', 'Location created successfully.');
    }

    public function show(EventLocation $eventLocation)
    {
        $eventLocation->load('events');
        return view('event-locations.show', compact('eventLocation'));
    }

    public function edit(EventLocation $eventLocation)
    {
        return view('event-locations.edit', compact('eventLocation'));
    }

    public function update(Request $request, EventLocation $eventLocation)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $eventLocation->update($validated);

        return redirect()->route('event-locations.index')
            ->with('success', 'Location updated successfully.');
    }

    public function destroy(EventLocation $eventLocation)
    {
        if ($eventLocation->events()->count() > 0) {
            return redirect()->route('event-locations.index')
                ->with('error', 'Cannot delete location as it has assigned events.');
        }

        $eventLocation->delete();

        return redirect()->route('event-locations.index')
            ->with('success', 'Location deleted successfully.');
    }
}
