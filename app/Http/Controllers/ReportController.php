<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('reports.index');
    }

    public function generate(Request $request)
    {
        try {
            $request->validate([
                'report_type' => 'required|in:occupancy,revenue,reservations',
                'date_range' => 'required|in:today,yesterday,last_7_days,this_month,last_month,custom',
                'start_date' => 'required_if:date_range,custom|date',
                'end_date' => 'required_if:date_range,custom|date|after_or_equal:start_date',
            ]);

            $dateRange = $this->getDateRange($request->date_range, $request->start_date, $request->end_date);
            $startDate = $dateRange['start'];
            $endDate = $dateRange['end'];

            switch ($request->report_type) {
                case 'occupancy':
                    $data = $this->generateOccupancyReport($startDate, $endDate);
                    $title = 'Occupancy Report';
                    break;
                case 'revenue':
                    $data = $this->generateRevenueReport($startDate, $endDate);
                    $title = 'Revenue Report';
                    break;
                case 'reservations':
                    $data = $this->generateReservationsReport($startDate, $endDate);
                    $title = 'Reservations Report';
                    break;
                default:
                    throw new \Exception('Invalid report type');
            }

            return view('reports.show', compact('data', 'title', 'startDate', 'endDate'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error generating report: ' . $e->getMessage()]);
        }
    }

    public function exportPdf(Request $request)
    {
        try {
            $request->validate([
                'report_type' => 'required|in:occupancy,revenue,reservations',
                'date_range' => 'required|in:today,yesterday,last_7_days,this_month,last_month,custom',
                'start_date' => 'required_if:date_range,custom|date',
                'end_date' => 'required_if:date_range,custom|date|after_or_equal:start_date',
            ]);

            $dateRange = $this->getDateRange($request->date_range, $request->start_date, $request->end_date);
            $startDate = $dateRange['start'];
            $endDate = $dateRange['end'];

            switch ($request->report_type) {
                case 'occupancy':
                    $data = $this->generateOccupancyReport($startDate, $endDate);
                    $title = 'Occupancy Report';
                    break;
                case 'revenue':
                    $data = $this->generateRevenueReport($startDate, $endDate);
                    $title = 'Revenue Report';
                    break;
                case 'reservations':
                    $data = $this->generateReservationsReport($startDate, $endDate);
                    $title = 'Reservations Report';
                    break;
                default:
                    throw new \Exception('Invalid report type');
            }

            $pdf = \PDF::loadView('reports.pdf', compact('data', 'title', 'startDate', 'endDate'));
            return $pdf->download($title . '_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d') . '.pdf');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error generating PDF: ' . $e->getMessage()]);
        }
    }

    private function getDateRange($range, $customStart = null, $customEnd = null)
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
            case 'custom':
                return [
                    'start' => Carbon::parse($customStart)->startOfDay(),
                    'end' => Carbon::parse($customEnd)->endOfDay(),
                ];
            default:
                return [
                    'start' => Carbon::today(),
                    'end' => Carbon::today()->endOfDay(),
                ];
        }
    }

    private function generateOccupancyReport($startDate, $endDate)
    {
        $totalRooms = Room::count();

        // Count rooms that have reservations overlapping with the date range
        $occupiedRooms = Reservation::where(function($query) use ($startDate, $endDate) {
            $query->where(function($q) use ($startDate, $endDate) {
                // Reservations that start within the range
                $q->whereBetween('check_in_date', [$startDate, $endDate]);
            })->orWhere(function($q) use ($startDate, $endDate) {
                // Reservations that end within the range
                $q->whereBetween('check_out_date', [$startDate, $endDate]);
            })->orWhere(function($q) use ($startDate, $endDate) {
                // Reservations that span the entire range
                $q->where('check_in_date', '<=', $startDate)
                  ->where('check_out_date', '>=', $endDate);
            });
        })->distinct('room_id')->count('room_id');

        $occupancyRate = $totalRooms > 0 ? ($occupiedRooms / $totalRooms) * 100 : 0;

        return [
            'total_rooms' => $totalRooms,
            'occupied_rooms' => $occupiedRooms,
            'occupancy_rate' => round($occupancyRate, 2),
            'period' => [
                'start' => $startDate->format('Y-m-d'),
                'end' => $endDate->format('Y-m-d'),
            ],
        ];
    }

    private function generateRevenueReport($startDate, $endDate)
    {
        $payments = Payment::whereBetween('payment_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->get();

        $totalRevenue = $payments->sum('amount');
        $paymentCount = $payments->count();
        $averageRevenue = $paymentCount > 0 ? $totalRevenue / $paymentCount : 0;

        return [
            'total_revenue' => $totalRevenue,
            'average_revenue' => round($averageRevenue, 2),
            'payment_count' => $paymentCount,
            'period' => [
                'start' => $startDate->format('Y-m-d'),
                'end' => $endDate->format('Y-m-d'),
            ],
        ];
    }

    private function generateReservationsReport($startDate, $endDate)
    {
        $reservations = Reservation::with(['room', 'customer'])
            ->whereBetween('check_in_date', [$startDate, $endDate])
            ->get();

        return [
            'total_reservations' => $reservations->count(),
            'reservations' => $reservations,
            'period' => [
                'start' => $startDate->format('Y-m-d'),
                'end' => $endDate->format('Y-m-d'),
            ],
        ];
    }
}
