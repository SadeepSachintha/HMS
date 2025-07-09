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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $stats = $this->getStats();
        return view('dashboard', compact('stats'));
    }

    public function getStats(Request $request = null)
    {
        $dateRange = $this->getDateRange($request ? $request->get('date_range', 'today') : 'today');

        // Calculate occupancy rate
        $totalRooms = Room::count();
        $occupiedRooms = Reservation::where(function($query) use ($dateRange) {
            $query->whereBetween('check_in_date', [$dateRange['start'], $dateRange['end']])
                ->orWhereBetween('check_out_date', [$dateRange['start'], $dateRange['end']]);
        })->count();

        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100, 2) : 0;

        // Calculate revenue for this month
        $revenue = Payment::where('status', 'completed')
            ->whereBetween('payment_date', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])
            ->sum('amount');

        // Calculate last month's revenue
        $lastMonthRevenue = Payment::where('status', 'completed')
            ->whereBetween('payment_date', [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth()
            ])
            ->sum('amount');

        // Calculate trends
        $lastWeekOccupancy = $this->getOccupancyForPeriod(
            Carbon::now()->subWeek()->startOfDay(),
            Carbon::now()->subWeek()->endOfDay()
        );

        $yesterdayRevenue = Payment::where('status', 'completed')
            ->whereBetween('payment_date', [
                Carbon::yesterday()->startOfDay(),
                Carbon::yesterday()->endOfDay()
            ])
            ->sum('amount');

        // Calculate changes
        $occupancyChange = $lastWeekOccupancy > 0 ?
            round((($occupancyRate - $lastWeekOccupancy) / $lastWeekOccupancy) * 100, 2) : 0;

        $revenueChange = $lastMonthRevenue > 0 ?
            round((($revenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 2) : 0;

        $stats = [
            'occupancy_rate' => $occupancyRate,
            'occupancy_change' => $occupancyChange,
            'revenue' => $revenue,
            'revenue_change' => $revenueChange,
            'total_rooms' => $totalRooms,
            'occupied_rooms' => $occupiedRooms,
            'date_range' => [
                'start' => Carbon::now()->startOfMonth()->format('Y-m-d'),
                'end' => Carbon::now()->endOfMonth()->format('Y-m-d')
            ]
        ];

        // Broadcast the stats update if this is an AJAX request
        if ($request && $request->ajax()) {
            broadcast(new DashboardStatsEvent($stats))->toOthers();
        }

        return $stats;
    }

    public function refreshStats(Request $request)
    {
        return response()->json($this->getStats($request));
    }

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
