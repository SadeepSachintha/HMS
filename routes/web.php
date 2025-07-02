<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\FoodItemController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AlertController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard Route
Route::get('/', function () {
    return redirect()->route('dashboard');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/refresh-stats', [DashboardController::class, 'refreshStats'])->name('dashboard.refresh-stats');
Route::get('/dashboard/occupancy', [DashboardController::class, 'getOccupancyStats'])->name('dashboard.occupancy');
Route::get('/dashboard/revenue', [DashboardController::class, 'getRevenueStats'])->name('dashboard.revenue');
Route::get('/dashboard/charts', [DashboardController::class, 'getChartData'])->name('dashboard.charts');

// Reservations Routes
Route::get('/reservations/calendar', [ReservationController::class, 'calendar'])->name('reservations.calendar');
Route::get('/reservations/events', [ReservationController::class, 'events'])->name('reservations.events');
Route::get('/reservations/{reservation}/details', [ReservationController::class, 'details'])->name('reservations.details');
Route::resource('reservations', ReservationController::class);

// Customers Routes
Route::resource('customers', CustomerController::class);

// Rooms Routes
Route::resource('rooms', RoomController::class);
Route::resource('room-types', RoomTypeController::class);
Route::delete('/room-types/images/{id}', [RoomTypeController::class, 'deleteImage'])->name('room-types.images.destroy');

// Food Menu Routes
Route::resource('food-items', FoodItemController::class);

// Events Routes
Route::resource('events', EventController::class);
Route::get('/events/calendar', [EventController::class, 'calendar'])->name('events.calendar');

// Event staff assignment routes
Route::post('/events/{event}/staff/assign', [App\Http\Controllers\EventController::class, 'assignStaff'])->name('events.staff.assign');
Route::delete('/events/{event}/staff/{staff}/remove', [App\Http\Controllers\EventController::class, 'removeStaff'])->name('events.staff.remove');

// Staff Routes
Route::resource('staff', StaffController::class);

// Billing & Payments Routes
Route::resource('payments', PaymentController::class);
Route::resource('invoices', InvoiceController::class);
Route::get('invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');

// Test route for debugging reports
Route::get('/test-reports', function() {
    try {
        $totalRooms = \App\Models\Room::count();
        $totalReservations = \App\Models\Reservation::count();
        $totalPayments = \App\Models\Payment::count();

        return response()->json([
            'success' => true,
            'data' => [
                'total_rooms' => $totalRooms,
                'total_reservations' => $totalReservations,
                'total_payments' => $totalPayments,
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
});

// Reports Routes
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
Route::post('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export-pdf');
Route::get('/reports/occupancy/export-excel', [ReportController::class, 'exportOccupancyExcel'])->name('reports.occupancy.export-excel');

// Settings Routes
Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount']);
    Route::get('/notifications/latest', [NotificationController::class, 'getLatest']);
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);
});

// Alert routes
Route::middleware('auth')->group(function () {
    Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
    Route::post('/alerts/{alert}/mark-as-read', [AlertController::class, 'markAsRead'])->name('alerts.mark-as-read');
    Route::post('/alerts/mark-all-as-read', [AlertController::class, 'markAllAsRead'])->name('alerts.mark-all-as-read');
    Route::delete('/alerts/{alert}', [AlertController::class, 'destroy'])->name('alerts.destroy');
    Route::get('/alerts/unread-count', [AlertController::class, 'getUnreadCount'])->name('alerts.unread-count');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
