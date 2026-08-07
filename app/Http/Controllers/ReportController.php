<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\Payment;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\OccupancyReportExport;
use App\Exports\RevenueReportExport;
use App\Exports\ReservationsReportExport;
use App\Exports\FoodSalesReportExport;
use App\Exports\TaxLeviesReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

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
                'report_type' => 'required|in:occupancy,revenue,reservations,food_sales,tax_levies',
                'date_range' => 'required|in:today,yesterday,last_7_days,this_month,last_month,custom',
                'start_date' => 'required_if:date_range,custom|date',
                'end_date' => 'required_if:date_range,custom|date|after_or_equal:start_date',
                'room_type_id' => 'nullable|exists:room_types,id',
            ]);

            $dateRange = $this->getDateRange($request->date_range, $request->start_date, $request->end_date);
            $startDate = $dateRange['start'];
            $endDate = $dateRange['end'];
            $roomTypeId = $request->room_type_id;

            switch ($request->report_type) {
                case 'occupancy':
                    $data = $this->generateOccupancyReport($startDate, $endDate, $roomTypeId);
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
                case 'food_sales':
                    $data = $this->getFoodSalesTableData($startDate, $endDate);
                    $title = 'Food & Beverage Sales Report';
                    break;
                case 'tax_levies':
                    $data = $this->getTaxLeviesTableData($startDate, $endDate);
                    $title = 'Tax & Financial Levies Audit Report';
                    break;
                default:
                    throw new \Exception('Invalid report type');
            }

            $roomTypes = RoomType::all();
            // Return the index view with data and filters
            return view('reports.index', compact('data', 'title', 'startDate', 'endDate', 'roomTypes', 'roomTypeId'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error generating report: ' . $e->getMessage()]);
        }
    }

    public function exportPdf(Request $request)
    {
        try {
            $request->validate([
                'report_type' => 'required|in:occupancy,revenue,reservations,food_sales,tax_levies',
                'from_date' => 'required|date',
                'to_date' => 'required|date|after_or_equal:from_date',
            ]);

            $from = Carbon::parse($request->from_date)->startOfDay();
            $to = Carbon::parse($request->to_date)->endOfDay();
            $type = $request->report_type;

            if ($type === 'occupancy') {
                $data = $this->getOccupancyTableData($from, $to);
                $title = 'Occupancy Report';
            } elseif ($type === 'revenue') {
                $data = $this->getRevenueTableData($from, $to);
                $title = 'Revenue Report';
            } elseif ($type === 'food_sales') {
                $data = $this->getFoodSalesTableData($from, $to);
                $title = 'Food & Beverage Sales Report';
            } elseif ($type === 'tax_levies') {
                $data = $this->getTaxLeviesTableData($from, $to);
                $title = 'Tax & Financial Levies Audit Report';
            } else {
                $data = $this->getReservationsTableData($from, $to);
                $title = 'Reservations Report';
            }

            $pdf = Pdf::loadView('reports.pdf', compact('data', 'title', 'from', 'to'));
            return $pdf->download($title . '_' . $from->format('Y-m-d') . '_to_' . $to->format('Y-m-d') . '.pdf');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error generating PDF: ' . $e->getMessage()]);
        }
    }

    public function exportExcel(Request $request)
    {
        try {
            $request->validate([
                'report_type' => 'required|in:occupancy,revenue,reservations,food_sales,tax_levies',
                'from_date' => 'required|date',
                'to_date' => 'required|date|after_or_equal:from_date',
            ]);

            $from = Carbon::parse($request->from_date)->startOfDay();
            $to = Carbon::parse($request->to_date)->endOfDay();
            $type = $request->report_type;

            if ($type === 'occupancy') {
                $data = $this->getOccupancyTableData($from, $to);
                $export = new OccupancyReportExport($data->toArray());
                $fileName = 'Occupancy_Report_' . $from->format('Ymd') . '_to_' . $to->format('Ymd') . '.xlsx';
            } elseif ($type === 'revenue') {
                $data = $this->getRevenueTableData($from, $to);
                $export = new RevenueReportExport($data['rows']->toArray());
                $fileName = 'Revenue_Report_' . $from->format('Ymd') . '_to_' . $to->format('Ymd') . '.xlsx';
            } elseif ($type === 'food_sales') {
                $data = $this->getFoodSalesTableData($from, $to);
                $export = new FoodSalesReportExport($data['rows']->toArray());
                $fileName = 'Food_Sales_Report_' . $from->format('Ymd') . '_to_' . $to->format('Ymd') . '.xlsx';
            } elseif ($type === 'tax_levies') {
                $data = $this->getTaxLeviesTableData($from, $to);
                $export = new TaxLeviesReportExport($data['rows']->toArray());
                $fileName = 'Tax_Levies_Report_' . $from->format('Ymd') . '_to_' . $to->format('Ymd') . '.xlsx';
            } else {
                $data = $this->getReservationsTableData($from, $to);
                $export = new ReservationsReportExport($data->toArray());
                $fileName = 'Reservations_Report_' . $from->format('Ymd') . '_to_' . $to->format('Ymd') . '.xlsx';
            }

            return Excel::download($export, $fileName);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error generating Excel: ' . $e->getMessage()]);
        }
    }

    public function exportOccupancyExcel(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'room_type_id' => 'nullable|exists:room_types,id',
        ]);
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
        $roomTypeId = $request->room_type_id;
        $data = $this->generateOccupancyReport($startDate, $endDate, $roomTypeId);
        $export = new OccupancyReportExport($data['room_details']->toArray());
        $fileName = 'Occupancy_Report_' . $startDate->format('Ymd') . '_to_' . $endDate->format('Ymd') . '.xlsx';
        return Excel::download($export, $fileName);
    }

    // New AJAX endpoint for dynamic report data
    public function fetchReportData(Request $request)
    {
        try {
            $request->validate([
                'report_type' => 'required|in:occupancy,revenue,reservations,food_sales,tax_levies',
                'from_date' => 'required|date',
                'to_date' => 'required|date|after_or_equal:from_date',
            ]);

            $from = Carbon::parse($request->from_date)->startOfDay();
            $to = Carbon::parse($request->to_date)->endOfDay();
            $type = $request->report_type;

            if ($type === 'occupancy') {
                $data = $this->getOccupancyTableData($from, $to);
            } elseif ($type === 'revenue') {
                $data = $this->getRevenueTableData($from, $to);
            } elseif ($type === 'food_sales') {
                $data = $this->getFoodSalesTableData($from, $to);
            } elseif ($type === 'tax_levies') {
                $data = $this->getTaxLeviesTableData($from, $to);
            } else {
                $data = $this->getReservationsTableData($from, $to);
            }
            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Report fetch error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
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

    private function generateOccupancyReport($startDate, $endDate, $roomTypeId = null)
    {
        $roomQuery = Room::query();
        if ($roomTypeId) {
            $roomQuery->where('room_type_id', $roomTypeId);
        }
        $totalRooms = $roomQuery->count();
        $roomIds = $roomQuery->pluck('id');

        $reservationQuery = Reservation::with(['room', 'room.roomType'])
            ->whereIn('room_id', $roomIds)
            ->where(function($query) use ($startDate, $endDate) {
                $query->where(function($q) use ($startDate, $endDate) {
                    $q->whereBetween('check_in_date', [$startDate, $endDate]);
                })->orWhere(function($q) use ($startDate, $endDate) {
                    $q->whereBetween('check_out_date', [$startDate, $endDate]);
                })->orWhere(function($q) use ($startDate, $endDate) {
                    $q->where('check_in_date', '<=', $startDate)
                      ->where('check_out_date', '>=', $endDate);
                });
            });
        $reservations = $reservationQuery->get();

        $occupiedRoomIds = $reservations->pluck('room_id')->unique();
        $occupiedRooms = $occupiedRoomIds->count();
        $occupancyRate = $totalRooms > 0 ? ($occupiedRooms / $totalRooms) * 100 : 0;

        $roomTypes = RoomType::withCount(['rooms as total_rooms' => function($q) use ($roomIds) {
            $q->whereIn('id', $roomIds);
        }])->get();
        $breakdown = $roomTypes->map(function($type) use ($reservations) {
            $typeRoomIds = $type->rooms->pluck('id');
            $occupied = $reservations->whereIn('room_id', $typeRoomIds)->pluck('room_id')->unique()->count();
            return [
                'room_type' => $type->name,
                'total_rooms' => $type->total_rooms,
                'occupied_rooms' => $occupied,
                'occupancy_rate' => $type->total_rooms > 0 ? round(($occupied / $type->total_rooms) * 100, 2) : 0,
            ];
        });

        $roomDetails = $reservations->map(function($reservation) {
            return [
                'room_no' => $reservation->room->number ?? '',
                'room_type' => $reservation->room->roomType->name ?? '',
                'check_in' => $reservation->check_in_date->format('Y-m-d'),
                'check_out' => $reservation->check_out_date->format('Y-m-d'),
                'status' => 'Occupied',
            ];
        });

        return [
            'total_rooms' => $totalRooms,
            'occupied_rooms' => $occupiedRooms,
            'occupancy_rate' => round($occupancyRate, 2),
            'period' => [
                'start' => $startDate->format('Y-m-d'),
                'end' => $endDate->format('Y-m-d'),
            ],
            'breakdown' => $breakdown,
            'room_details' => $roomDetails,
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

    // Helper for Occupancy Report Table
    private function getOccupancyTableData($from, $to)
    {
        $reservations = Reservation::with('room.roomType')
            ->where(function($query) use ($from, $to) {
                $query->whereBetween('check_in_date', [$from, $to])
                      ->orWhereBetween('check_out_date', [$from, $to])
                      ->orWhere(function($q) use ($from, $to) {
                          $q->where('check_in_date', '<=', $from)
                            ->where('check_out_date', '>=', $to);
                      });
            })
            ->get();
        return $reservations->map(function($r) {
            return [
                'room_no' => $r->room->number ?? '',
                'room_type' => $r->room->roomType->name ?? '',
                'check_in' => $r->check_in_date->format('Y-m-d'),
                'check_out' => $r->check_out_date->format('Y-m-d'),
                'status' => ucfirst(str_replace('_', ' ', $r->status)),
            ];
        });
    }

    /**
     * Map payment method code to display name.
     */
    private function getPaymentMethodDisplayName($code)
    {
        $map = [
            'cash' => 'Cash',
            'credit_card' => 'Credit Card',
            'debit_card' => 'Debit Card',
            'bank_transfer' => 'Bank Transfer',
            'cheque' => 'Cheque',
        ];
        return $map[$code] ?? ucfirst(str_replace('_', ' ', $code));
    }

    // Helper for Revenue Report Table
    private function getRevenueTableData($from, $to)
    {
        $payments = Payment::where('status', 'completed')
            ->whereBetween('payment_date', [$from, $to])
            ->with(['reservation.customer'])
            ->get();
        $rows = $payments->map(function($p) {
            return [
                'payment_id' => $p->id,
                'payment_method' => $this->getPaymentMethodDisplayName($p->payment_method ?? ''),
                'payment_date' => $p->payment_date ? (new \Carbon\Carbon($p->payment_date))->format('Y-m-d') : '',
                'total_amount' => $p->amount,
            ];
        });
        $total = $rows->sum('total_amount');
        return ['rows' => $rows, 'total' => $total];
    }

    // Helper for Reservations Report Table
    private function getReservationsTableData($from, $to)
    {
        $reservations = Reservation::with('customer')
            ->whereBetween('check_in_date', [$from, $to])
            ->get();
        return $reservations->map(function($r) {
            return [
                'customer' => $r->customer->name ?? '',
                'reservation_date' => $r->created_at ? $r->created_at->format('Y-m-d') : '',
                'check_in' => $r->check_in_date->format('Y-m-d'),
                'check_out' => $r->check_out_date->format('Y-m-d'),
                'status' => ucfirst($r->status),
            ];
        });
    }

    // Helper for Food Sales Report Table
    private function getFoodSalesTableData($from, $to)
    {
        $foodNames = \App\Models\FoodItem::pluck('name')->toArray();
        $items = \App\Models\InvoiceItem::whereIn('description', $foodNames)
            ->whereHas('invoice', function($q) use ($from, $to) {
                $q->whereBetween('invoice_date', [$from, $to]);
            })
            ->selectRaw('description as food_item_name, unit_price, sum(quantity) as quantity_sold, sum(quantity * unit_price) as total_sales')
            ->groupBy('description', 'unit_price')
            ->get();

        $rows = $items->map(function($item) {
            return [
                'food_item_name' => $item->food_item_name,
                'unit_price' => (float)$item->unit_price,
                'quantity_sold' => (int)$item->quantity_sold,
                'total_sales' => (float)$item->total_sales,
            ];
        });

        $total = $rows->sum('total_sales');
        return ['rows' => $rows, 'total' => $total];
    }

    // Helper for Tax Levies Report Table
    private function getTaxLeviesTableData($from, $to)
    {
        $invoices = \App\Models\Invoice::whereBetween('invoice_date', [$from, $to])
            ->get();

        $rows = $invoices->map(function($inv) {
            return [
                'invoice_number' => $inv->invoice_number,
                'invoice_date' => $inv->invoice_date ? $inv->invoice_date->format('Y-m-d') : '',
                'base_amount' => $inv->base_amount,
                'service_charge' => $inv->service_charge,
                'sscl_amount' => $inv->sscl_amount,
                'tdl_amount' => $inv->tdl_amount,
                'vat_amount' => $inv->vat_amount,
                'grand_total' => $inv->grand_total
            ];
        });

        $totals = [
            'base_amount' => $rows->sum('base_amount'),
            'service_charge' => $rows->sum('service_charge'),
            'sscl_amount' => $rows->sum('sscl_amount'),
            'tdl_amount' => $rows->sum('tdl_amount'),
            'vat_amount' => $rows->sum('vat_amount'),
            'grand_total' => $rows->sum('grand_total')
        ];

        return ['rows' => $rows, 'totals' => $totals];
    }
}
