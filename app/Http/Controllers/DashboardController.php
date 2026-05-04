<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Customer;
use App\Models\Payment;
use App\Events\DashboardStatsEvent;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $stats = $this->getStats();
        return view('dashboard', compact('stats'));
    }

    /**
     * Calculate and return dashboard statistics.
     * 
     * @param \Illuminate\Http\Request|null $request
     * @return array
     */
    public function getStats(Request $request = null)
    {
        $dateRange = $this->getDateRange($request ? $request->get('date_range', 'today') : 'today');

        // Calculate occupancy rate for the given date range
        $totalRooms = Room::count();
        $occupiedRooms = Reservation::where('status', 'confirmed')
            ->where(function($query) use ($dateRange) {
                $query->whereBetween('check_in_date', [$dateRange['start'], $dateRange['end']])
                    ->orWhereBetween('check_out_date', [$dateRange['start'], $dateRange['end']]);
            })->count();

        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100, 1) : 0;

        // Calculate current month's revenue (completed payments)
        $revenue = Payment::where('status', 'completed')
            ->whereBetween('payment_date', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])
            ->sum('amount');

        // Calculate previous month's revenue for trend analysis
        $lastMonthRevenue = Payment::where('status', 'completed')
            ->whereBetween('payment_date', [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth()
            ])
            ->sum('amount');

        // Fetch last week's occupancy for trend comparison
        $lastWeekOccupancy = $this->getOccupancyForPeriod(
            Carbon::now()->subWeek()->startOfDay(),
            Carbon::now()->subWeek()->endOfDay()
        );

        // Calculate percentage changes (trends)
        $occupancyChange = $lastWeekOccupancy > 0 ?
            round((($occupancyRate - $lastWeekOccupancy) / $lastWeekOccupancy) * 100, 1) : 0;

        $revenueChange = $lastMonthRevenue > 0 ?
            round((($revenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1) : 0;

        // Room Status Breakdown
        $roomStatusCounts = [
            'available' => Room::where('status', 'available')->count(),
            'occupied' => Room::where('status', 'occupied')->count(),
            'maintenance' => Room::where('status', 'maintenance')->count(),
            'dirty' => Room::where('is_clean', false)->count(),
        ];

        // Recent Reservations
        $recentReservations = Reservation::with(['customer', 'room.roomType'])
            ->latest()
            ->take(5)
            ->get();

        // Upcoming Arrivals (Today)
        $upcomingArrivals = Reservation::with(['customer', 'room'])
            ->whereDate('check_in_date', Carbon::today())
            ->where('status', 'confirmed')
            ->get();

        // Monthly Revenue Data (Last 6 Months)
        $monthlyRevenueData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlyRevenueData[] = [
                'month' => $month->format('M'),
                'amount' => Payment::where('status', 'completed')
                    ->whereBetween('payment_date', [$month->startOfMonth()->copy(), $month->endOfMonth()->copy()])
                    ->sum('amount')
            ];
        }

        // Occupancy Trend Data (Last 7 Days)
        $occupancyTrendData = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i);
            $occupancyTrendData[] = [
                'day' => $day->format('D'),
                'rate' => $this->getOccupancyForPeriod($day->startOfDay()->copy(), $day->endOfDay()->copy())
            ];
        }

        $stats = [
            'occupancy_rate' => $occupancyRate,
            'occupancy_change' => $occupancyChange,
            'revenue' => (float)$revenue,
            'revenue_change' => $revenueChange,
            'total_rooms' => $totalRooms,
            'occupied_rooms' => $occupiedRooms,
            'room_status' => $roomStatusCounts,
            'recent_reservations' => $recentReservations,
            'upcoming_arrivals' => $upcomingArrivals,
            'revenue_chart' => $monthlyRevenueData,
            'occupancy_chart' => $occupancyTrendData,
            'date_range' => [
                'start' => Carbon::now()->startOfMonth()->format('Y-m-d'),
                'end' => Carbon::now()->endOfMonth()->format('Y-m-d')
            ]
        ];

        // Broadcast stats update to all connected clients for real-time dashboard feel
        if ($request && $request->ajax()) {
            broadcast(new DashboardStatsEvent($stats))->toOthers();
        }

        return $stats;
    }

    /**
     * Refresh dashboard stats via AJAX.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshStats(Request $request)
    {
        return response()->json($this->getStats($request));
    }

    /**
     * Helper to resolve common date range strings to start/end dates.
     * 
     * @param string $range
     * @return array
     */
    private function getDateRange($range)
    {
        switch ($range) {
            case 'today':
                return [
                    'start' => Carbon::today(),
                    'end' => Carbon::today()->endOfDay(),
                ];
            case 'yesterday':
                return [
                    'start' => Carbon::yesterday(),
                    'end' => Carbon::yesterday()->endOfDay(),
                ];
            case 'last_7_days':
                return [
                    'start' => Carbon::now()->subDays(7)->startOfDay(),
                    'end' => Carbon::now()->endOfDay(),
                ];
            case 'this_month':
                return [
                    'start' => Carbon::now()->startOfMonth(),
                    'end' => Carbon::now()->endOfMonth(),
                ];
            case 'last_month':
                return [
                    'start' => Carbon::now()->subMonth()->startOfMonth(),
                    'end' => Carbon::now()->subMonth()->endOfMonth(),
                ];
            default:
                return [
                    'start' => Carbon::today(),
                    'end' => Carbon::today()->endOfDay(),
                ];
        }
    }

    /**
     * Helper to calculate occupancy for a specific date period.
     * 
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     * @return float
     */
    private function getOccupancyForPeriod($start, $end)
    {
        $totalRooms = Room::count();
        $occupiedRooms = Reservation::where(function($query) use ($start, $end) {
            $query->whereBetween('check_in_date', [$start, $end])
                ->orWhereBetween('check_out_date', [$start, $end]);
        })->count();

        return $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100, 2) : 0;
    }
}
