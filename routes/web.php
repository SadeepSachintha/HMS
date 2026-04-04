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
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/refresh-stats', [DashboardController::class, 'refreshStats'])->name('dashboard.refresh-stats');
    Route::get('/dashboard/occupancy', [DashboardController::class, 'getOccupancyStats'])->name('dashboard.occupancy');
    Route::get('/dashboard/revenue', [DashboardController::class, 'getRevenueStats'])->name('dashboard.revenue');
    Route::get('/dashboard/charts', [DashboardController::class, 'getChartData'])->name('dashboard.charts');
});
// Example: Admin-only routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Place admin-only routes here
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    // e.g., Route::resource('staff', StaffController::class);
});

// Example: Manager and Admin routes
Route::middleware(['auth', 'role:admin,manager'])->group(function () {
    // Place routes accessible by admin and manager here
    // Route::get('/manager/reports', [ReportController::class, 'index'])->name('manager.reports');
    Route::resource('staff', StaffController::class);
});

// Example: Staff, Manager, and Admin routes
Route::middleware(['auth', 'role:admin,manager,staff'])->group(function () {
    // Place routes accessible by all staff, manager, and admin here
    Route::get('/staff/alerts', [AlertController::class, 'index'])->name('staff.alerts');
});

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
// Only manager and admin can create/edit staff
Route::middleware(['auth', 'role:admin,manager'])->group(function () {
    Route::get('staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::post('staff', [StaffController::class, 'store'])->name('staff.store');
    Route::get('staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
    Route::put('staff/{staff}', [StaffController::class, 'update'])->name('staff.update');
});
// All staff, manager, and admin can view staff list and details
Route::middleware(['auth', 'role:admin,manager,staff'])->group(function () {
    Route::get('staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('staff/{staff}', [StaffController::class, 'show'])->name('staff.show');
});

// Billing & Payments Routes
Route::resource('payments', PaymentController::class);
Route::get('payments/{payment}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');
Route::resource('invoices', InvoiceController::class);
Route::put('invoices/{invoice}/update-status-notes', [InvoiceController::class, 'updateStatusNotes'])->name('invoices.update-status-notes');
Route::get('invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');

// Reports: Main page and AJAX data (admin, manager, staff)
Route::middleware(['auth', 'role:admin,manager,staff'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/fetch-data', [ReportController::class, 'fetchReportData'])->name('reports.fetch-data');
    Route::post('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export-pdf');
    Route::get('/reports/export-excel', [ReportController::class, 'exportExcel'])->name('reports.export-excel');
});

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

// User Management (admin,manager only)
Route::middleware(['auth', 'role:admin,manager'])->group(function () {
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::post('users/{user}/reset-password', [App\Http\Controllers\UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::post('users/{user}/toggle-status', [App\Http\Controllers\UserController::class, 'toggleStatus'])->name('users.toggle-status');
});
