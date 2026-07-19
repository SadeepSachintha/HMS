<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use App\Events\RoomEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the rooms.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Room::with('roomType');

        // Apply search filters if present
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('number', 'LIKE', "%{$search}%")
                  ->orWhere('floor', 'LIKE', "%{$search}%")
                  ->orWhereHas('roomType', function($typeQuery) use ($search) {
                      $typeQuery->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Handle sorting parameters
        $sortBy = $request->get('sort', 'id');
        $sortOrder = $request->get('order', 'desc');

        // Validate sort column against whitelist
        $allowedSortColumns = ['id', 'number', 'floor', 'status', 'created_at'];
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'id';
        }

        // Validate sort order
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc';
        }

        $query->orderBy($sortBy, $sortOrder);

        $rooms = $query->paginate(10);

        // Preserve search and sort parameters in pagination links
        if ($request->has('search')) {
            $rooms->appends(['search' => $request->search]);
        }
        if ($request->has('sort')) {
            $rooms->appends(['sort' => $request->sort]);
        }
        if ($request->has('order')) {
            $rooms->appends(['order' => $request->order]);
        }

        return view('rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new room.
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roomTypes = RoomType::all();
        return view('rooms.create', compact('roomTypes'));
    }

    /**
     * Store a newly created room in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:10|unique:rooms',
            'room_type_id' => 'required|exists:room_types,id',
            'floor' => 'required|string',
            'status' => 'required|in:available,occupied,maintenance',
            'notes' => 'nullable|string|max:1000'
        ]);

        $room = Room::create($validated);

        // Broadcast the room created event for real-time dashboard updates
        broadcast(new RoomEvent($room, 'created'))->toOthers();

        return redirect()->route('rooms.index')
            ->with('success', 'Room created successfully.');
    }

    /**
     * Display the specified room.
     * 
     * @param \App\Models\Room $room
     * @return \Illuminate\View\View
     */
    public function show(Room $room)
    {
        $room->load('roomType');
        return view('rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified room.
     * 
     * @param \App\Models\Room $room
     * @return \Illuminate\View\View
     */
    public function edit(Room $room)
    {
        $roomTypes = RoomType::all();
        return view('rooms.edit', compact('room', 'roomTypes'));
    }

    /**
     * Update the specified room in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Room $room
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:10|unique:rooms,number,' . $room->id,
            'room_type_id' => 'required|exists:room_types,id',
            'floor' => 'required|integer',
            'status' => 'required|in:available,occupied,maintenance',
            'notes' => 'nullable|string|max:1000'
        ]);

        $room->update($validated);

        // Broadcast the room updated event for real-time dashboard updates
        broadcast(new RoomEvent($room, 'updated'))->toOthers();

        return redirect()->route('rooms.index')
            ->with('success', 'Room updated successfully.');
    }

    /**
     * Remove the specified room from storage.
     * 
     * @param \App\Models\Room $room
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Room $room)
    {
        abort(403, 'Deletion is disabled.');
    }
}
