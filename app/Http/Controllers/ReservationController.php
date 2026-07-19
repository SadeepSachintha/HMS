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

    /**
     * Display a listing of the reservations.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Reservation::with(['room', 'customer']);

        // Filter results for guest users to only show their own reservations
        if (auth()->user()->isGuest()) {
            $query->whereHas('customer', function($q) {
                $q->where('email', auth()->user()->email);
            });
        }

        // Apply search filters if present
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

        // Handle sorting parameters
        $sortBy = $request->get('sort', 'id');
        $sortOrder = $request->get('order', 'desc');

        // Validate sort column against whitelist
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

        // Preserve search and sort parameters in pagination links
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

    /**
     * Show the form for creating a new reservation.
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $guestCustomer = null;
        
        // If the user is a guest, ensure they have a customer profile and restrict view
        if (auth()->user()->isGuest()) {
            $guestCustomer = Customer::firstOrCreate(
                ['email' => auth()->user()->email],
                ['name' => auth()->user()->name]
            );
            $customers = collect([$guestCustomer]);
        }
        
        $rooms = Room::with('roomType')
            ->where('status', 'available')
            ->orderBy('number')
            ->get();
            
        return view('reservations.create', compact('customers', 'rooms', 'guestCustomer'));
    }

    /**
     * Store a newly created reservation in storage.
     * 
     * @param \App\Http\Requests\StoreReservationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreReservationRequest $request)
    {
        $validated = $request->validated();

        // Enforce guest user creates reservations only for themselves
        if (auth()->user()->isGuest()) {
            $guestCustomer = Customer::firstOrCreate(
                ['email' => auth()->user()->email],
                ['name' => auth()->user()->name]
            );
            $validated['customer_id'] = $guestCustomer->id;
            $validated['status'] = 'pending';
        }

        // Ensure dates are in the correct database format (YYYY-MM-DD)
        $validated['check_in_date'] = date('Y-m-d', strtotime($validated['check_in_date']));
        $validated['check_out_date'] = date('Y-m-d', strtotime($validated['check_out_date']));

        Reservation::create($validated);

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation created successfully.');
    }

    /**
     * Display the specified reservation.
     * 
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\View\View
     */
    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified reservation.
     * 
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\View\View
     */
    public function edit(Reservation $reservation)
    {
        // Prevent guests from editing other customers' reservations
        if (auth()->user()->isGuest() && $reservation->customer->email !== auth()->user()->email) {
            abort(403);
        }

        $customers = Customer::orderBy('name')->get();
        $rooms = Room::with('roomType')->orderBy('number')->get();
        return view('reservations.edit', compact('reservation', 'customers', 'rooms'));
    }

    /**
     * Update the specified reservation in storage.
     * 
     * @param \App\Http\Requests\UpdateReservationRequest $request
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        $validated = $request->validated();

        $reservation->update($validated);

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation updated successfully.');
    }

    /**
     * Remove the specified reservation from storage.
     * 
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Reservation $reservation)
    {
        abort(403, 'Deletion is disabled.');
    }

    /**
     * Show the reservation calendar view.
     * 
     * @return \Illuminate\View\View
     */
    public function calendar()
    {
        $rooms = Room::with('roomType')->orderBy('number')->get();
        return view('reservations.calendar', compact('rooms'));
    }

    /**
     * Fetch reservation events for the calendar (FullCalendar compatible).
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Collection
     */
    public function events(Request $request)
    {
        $query = Reservation::with(['room.roomType', 'customer'])
            ->where('status', '!=', 'cancelled');

        // Optional filter by specific room
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

    /**
     * Fetch details of a specific reservation via AJAX.
     * 
     * @param \App\Models\Reservation $reservation
     * @return \App\Models\Reservation
     */
    public function details(Reservation $reservation)
    {
        if (auth()->user()->isGuest() && $reservation->customer->email !== auth()->user()->email) {
            abort(403);
        }
        return $reservation->load(['room.roomType', 'customer']);
    }

    /**
     * Check for available rooms within a date range via AJAX.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function availableRooms(Request $request)
    {
        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $checkIn = date('Y-m-d', strtotime($request->check_in));
        $checkOut = date('Y-m-d', strtotime($request->check_out));

        // Identify rooms that have overlapping reservations for the requested dates
        $bookedRoomIds = Reservation::where('status', '!=', 'cancelled')
            ->where(function($query) use ($checkIn, $checkOut) {
                $query->where(function($q) use ($checkIn, $checkOut) {
                    $q->where('check_in_date', '<', $checkOut)
                      ->where('check_out_date', '>', $checkIn);
                });
            })
            ->pluck('room_id');

        // Fetch rooms that are both marked 'available' and not in the booked list
        $rooms = Room::with('roomType')
            ->where('status', 'available')
            ->whereNotIn('id', $bookedRoomIds)
            ->orderBy('number')
            ->get();

        return response()->json($rooms);
    }
}
