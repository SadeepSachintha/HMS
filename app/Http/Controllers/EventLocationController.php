<?php

namespace App\Http\Controllers;

use App\Models\EventLocation;
use Illuminate\Http\Request;

/**
 * Class EventLocationController
 * 
 * Manages the facilities, rooms, halls, and venues available for hotel events.
 * Provides standard CRUD actions and filters for active locations.
 * 
 * @package App\Http\Controllers
 */
class EventLocationController extends Controller
{
    /**
     * Create a new controller instance.
     * Requires authentication middleware for all endpoints.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a paginated list of all event locations.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $locations = EventLocation::paginate(10);
        return view('event-locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new event location.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('event-locations.create');
    }

    /**
     * Store a newly created event location in database storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Display details of a specific event location including its assigned events.
     *
     * @param  \App\Models\EventLocation  $eventLocation
     * @return \Illuminate\View\View
     */
    public function show(EventLocation $eventLocation)
    {
        // Eager load assigned events to show schedule or past events in details view
        $eventLocation->load('events');
        return view('event-locations.show', compact('eventLocation'));
    }

    /**
     * Show the form for editing an existing event location.
     *
     * @param  \App\Models\EventLocation  $eventLocation
     * @return \Illuminate\View\View
     */
    public function edit(EventLocation $eventLocation)
    {
        return view('event-locations.edit', compact('eventLocation'));
    }

    /**
     * Update the specified event location details in database storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventLocation  $eventLocation
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Remove the specified event location from storage.
     * Prevents deletion if there are any events scheduled at the location.
     *
     * @param  \App\Models\EventLocation  $eventLocation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(EventLocation $eventLocation)
    {
        // Integrity check: prevent deletion of locations containing events
        if ($eventLocation->events()->count() > 0) {
            return redirect()->route('event-locations.index')
                ->with('error', 'Cannot delete location as it has assigned events.');
        }

        $eventLocation->delete();

        return redirect()->route('event-locations.index')
            ->with('success', 'Location deleted successfully.');
    }
}
