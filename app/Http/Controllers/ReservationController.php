<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Customer;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Reservation::with(['room', 'customer']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('customer', function($customerQuery) use ($search) {
                    $customerQuery->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('room', function($roomQuery) use ($search) {
                    $roomQuery->where('number', 'LIKE', "%{$search}%");
                })
                ->orWhere('check_in_date', 'LIKE', "%{$search}%")
                ->orWhere('check_out_date', 'LIKE', "%{$search}%");
            });
        }

        // Sorting functionality
        $sortBy = $request->get('sort', 'id');
        $sortOrder = $request->get('order', 'desc');

        // Validate sort column
        $allowedSortColumns = ['id', 'check_in_date', 'check_out_date', 'number_of_guests', 'status', 'created_at'];
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'id';
        }

        // Validate sort order
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc';
        }

        $query->orderBy($sortBy, $sortOrder);

        $reservations = $query->paginate(10);

        // Preserve search and sort parameters in pagination
        if ($request->has('search')) {
            $reservations->appends(['search' => $request->search]);
        }
        if ($request->has('sort')) {
            $reservations->appends(['sort' => $request->sort]);
        }
        if ($request->has('order')) {
            $reservations->appends(['order' => $request->order]);
        }

        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $rooms = Room::with('roomType')
            ->where('status', 'available')
            ->orderBy('number')
            ->get();
        return view('reservations.create', compact('customers', 'rooms'));
    }

    public function store(StoreReservationRequest $request)
    {
        $validated = $request->validated();

        // Convert dates to proper format
        $validated['check_in_date'] = date('Y-m-d', strtotime($validated['check_in_date']));
        $validated['check_out_date'] = date('Y-m-d', strtotime($validated['check_out_date']));

        Reservation::create($validated);

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation created successfully.');
    }

    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $customers = Customer::orderBy('name')->get();
        $rooms = Room::with('roomType')->orderBy('number')->get();
        return view('reservations.edit', compact('reservation', 'customers', 'rooms'));
    }

    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        $validated = $request->validated();

        $reservation->update($validated);

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation updated successfully.');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation deleted successfully.');
    }

    public function calendar()
    {
        $rooms = Room::with('roomType')->orderBy('number')->get();
        return view('reservations.calendar', compact('rooms'));
    }

    public function events(Request $request)
    {
        $query = Reservation::with(['room.roomType', 'customer'])
            ->where('status', '!=', 'cancelled');

        if ($request->has('room_id')) {
            $query->where('room_id', $request->room_id);
        }

        $reservations = $query->get();

        return $reservations->map(function ($reservation) {
            $statusColors = [
                'pending' => '#ffc107',    // warning yellow
                'confirmed' => '#28a745',  // success green
                'checked_in' => '#17a2b8', // info blue
                'checked_out' => '#6c757d', // secondary gray
                'cancelled' => '#dc3545'   // danger red
            ];

            return [
                'id' => $reservation->id,
                'title' => 'Room ' . $reservation->room->number . ' - ' . $reservation->customer->name,
                'start' => $reservation->check_in_date,
                'end' => $reservation->check_out_date,
                'color' => $statusColors[$reservation->status] ?? '#6c757d',
                'room_number' => $reservation->room->number,
                'customer_name' => $reservation->customer->name,
                'status' => $reservation->status
            ];
        });
    }

    public function details(Reservation $reservation)
    {
        return $reservation->load(['room.roomType', 'customer']);
    }
}
