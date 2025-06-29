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

    public function index(Request $request)
    {
        $query = Room::with('roomType');

        // Search functionality
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

        // Sorting functionality
        $sortBy = $request->get('sort', 'id');
        $sortOrder = $request->get('order', 'desc');

        // Validate sort column
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

        // Preserve search and sort parameters in pagination
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

    public function create()
    {
        $roomTypes = RoomType::all();
        return view('rooms.create', compact('roomTypes'));
    }

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

        // Broadcast the room created event
        broadcast(new RoomEvent($room, 'created'))->toOthers();

        return redirect()->route('rooms.index')
            ->with('success', 'Room created successfully.');
    }

    public function show(Room $room)
    {
        $room->load('roomType');
        return view('rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $roomTypes = RoomType::all();
        return view('rooms.edit', compact('room', 'roomTypes'));
    }

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

        // Broadcast the room updated event
        broadcast(new RoomEvent($room, 'updated'))->toOthers();

        return redirect()->route('rooms.index')
            ->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        // Broadcast the room deleted event before deleting
        broadcast(new RoomEvent($room, 'deleted'))->toOthers();

        $room->delete();

        return redirect()->route('rooms.index')
            ->with('success', 'Room deleted successfully.');
    }
}
