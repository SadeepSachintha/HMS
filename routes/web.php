<?php

// =========================================================================

// ROUTE CONFIGURATION & ENDPOINT ACCESS CONTROL POLICY:

// - Universal authenticated endpoints are registered under Route::middleware(['auth'])

// - Admin exclusive routes are registered under Route::middleware(['auth', 'role:admin'])

// - Admin and Manager operational routes are registered under Route::middleware(['auth', 'role:admin,manager'])

// - Standard resource controller mappings automatically register index, create, store, show, edit, update, and destroy actions.

// =========================================================================

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\{

    DashboardController,

    ReservationController,

    CustomerController,

    RoomController,

    RoomTypeController,

    FoodItemController,

    EventController,

    StaffController,

    PaymentController,

    InvoiceController,

    ReportController,

    NotificationController,

    AlertController,

    WebsiteController,

    HomeController,

    UserController,

    EventLocationController,

    SettingsController,

    ActivityLogController

};

use App\Http\Controllers\Auth\LoginController;

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

// =========================================================================

// Public Routes

// =========================================================================

Route::get('/', [WebsiteController::class, 'index'])->name('website.home');

Route::get('/menu', [WebsiteController::class, 'menu'])->name('website.menu');

Route::get('/our-events', [WebsiteController::class, 'events'])->name('website.events');

// =========================================================================

// Authentication Routes

// =========================================================================

Auth::routes();

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Redirect for default home route

Route::get('/home', [HomeController::class, 'index'])->name('home');

// =========================================================================

// Authenticated Routes (Common)

// =========================================================================

Route::middleware(['auth'])->group(function () {

    

    // Dashboard & Stats

    Route::middleware(['role:admin,manager,staff'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/dashboard/refresh-stats', [DashboardController::class, 'refreshStats'])->name('dashboard.refresh-stats');

        Route::get('/dashboard/occupancy', [DashboardController::class, 'getOccupancyStats'])->name('dashboard.occupancy');

        Route::get('/dashboard/revenue', [DashboardController::class, 'getRevenueStats'])->name('dashboard.revenue');

        Route::get('/dashboard/charts', [DashboardController::class, 'getChartData'])->name('dashboard.charts');

    });

    // Notifications System

    Route::prefix('notifications')->group(function () {

        Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');

        Route::get('/unread-count', [NotificationController::class, 'getUnreadCount']);

        Route::get('/latest', [NotificationController::class, 'getLatest']);

        Route::post('/{id}/mark-as-read', [NotificationController::class, 'markAsRead']);

        Route::post('/mark-all-as-read', [NotificationController::class, 'markAllAsRead']);

        Route::delete('/{id}', [NotificationController::class, 'destroy']);

    });

    // Alerts System

    // Common/Guest Accessible Resources

    Route::get('reservations/available-rooms', [ReservationController::class, 'availableRooms'])->name('reservations.available-rooms');

    Route::resource('reservations', ReservationController::class)->only(['index', 'show', 'create', 'store']);

    Route::get('invoices/create', [InvoiceController::class, 'create'])->name('invoices.create')->middleware('role:admin,manager,staff');

    Route::post('invoices', [InvoiceController::class, 'store'])->name('invoices.store')->middleware('role:admin,manager,staff');

    Route::resource('invoices', InvoiceController::class)->only(['index', 'show']);

    Route::get('invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');

    Route::prefix('alerts')->group(function () {

        Route::get('/', [AlertController::class, 'index'])->name('alerts.index');

        Route::post('/{alert}/mark-as-read', [AlertController::class, 'markAsRead'])->name('alerts.mark-as-read');

        Route::post('/mark-all-as-read', [AlertController::class, 'markAllAsRead'])->name('alerts.mark-all-as-read');

        Route::delete('/{alert}', [AlertController::class, 'destroy'])->name('alerts.destroy');

        Route::get('/unread-count', [AlertController::class, 'getUnreadCount'])->name('alerts.unread-count');

    });

});

// =========================================================================

// Core Business Logic (Staff/Manager/Admin)

// =========================================================================

Route::middleware(['auth', 'role:admin,manager,staff'])->group(function () {

    // Reservations

    Route::prefix('reservations')->group(function () {

        

        Route::get('/calendar', [ReservationController::class, 'calendar'])->name('reservations.calendar');

        Route::get('/events', [ReservationController::class, 'events'])->name('reservations.events');

        Route::get('/{reservation}/details', [ReservationController::class, 'details'])->name('reservations.details');

    });

    

    // Inventory & Facility Management (Read-only for staff)

    Route::resource('customers', CustomerController::class)->only(['index', 'show', 'create', 'store']);

    Route::resource('rooms', RoomController::class)->only(['index', 'show']);

    Route::resource('room-types', RoomTypeController::class)->only(['index', 'show']);

    Route::resource('food-items', FoodItemController::class)->only(['index', 'show']);

    Route::resource('event-locations', EventLocationController::class)->only(['index', 'show']);

    // Events Management (Read-only for staff)

    Route::resource('events', EventController::class)->only(['index', 'show']);

    Route::get('/events/calendar', [EventController::class, 'calendar'])->name('events.calendar');

    // Financials: Payments & Invoices

    Route::resource('payments', PaymentController::class)->only(['index', 'show', 'create', 'store']);

    Route::get('payments/{payment}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');

    

    

    

    // Staff Directory (View Only)

    Route::get('staff', [StaffController::class, 'index'])->name('staff.index');

    // =========================================================================

    // Admin & Manager Only Operational Actions (Creations & Edits)

    // =========================================================================

    Route::middleware(['role:admin,manager'])->group(function () {

        // Edit & Update for common creations

        Route::resource('reservations', ReservationController::class)->only(['edit', 'update']);

        Route::resource('customers', CustomerController::class)->only(['edit', 'update']);

        Route::resource('payments', PaymentController::class)->only(['edit', 'update']);

        Route::resource('invoices', InvoiceController::class)->only(['edit', 'update']);

        Route::put('invoices/{invoice}/update-status-notes', [InvoiceController::class, 'updateStatusNotes'])->name('invoices.update-status-notes');

        // Full CRUD (excluding index/show and destroy) for restricted items

        Route::resource('rooms', RoomController::class)->except(['index', 'show', 'destroy']);

        Route::resource('room-types', RoomTypeController::class)->except(['index', 'show', 'destroy']);

        Route::resource('food-items', FoodItemController::class)->except(['index', 'show', 'destroy']);

        Route::resource('event-locations', EventLocationController::class)->except(['index', 'show', 'destroy']);

        Route::resource('events', EventController::class)->except(['index', 'show', 'destroy']);

        Route::post('/events/{event}/staff/assign', [EventController::class, 'assignStaff'])->name('events.staff.assign');

        Route::delete('/events/{event}/staff/{staff}/remove', [EventController::class, 'removeStaff'])->name('events.staff.remove');

    });

    // Invoice Creation for staff

});

// =========================================================================

// Administrative & Management (Admin/Manager Only)

// =========================================================================

Route::middleware(['auth', 'role:admin,manager'])->group(function () {

    

    

    // Staff Human Resources (Excluding Destroy)

    Route::get('staff/create', [StaffController::class, 'create'])->name('staff.create');

    Route::post('staff', [StaffController::class, 'store'])->name('staff.store');

    Route::get('staff/{staff}', [StaffController::class, 'show'])->name('staff.show');

    Route::get('staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');

    Route::put('staff/{staff}', [StaffController::class, 'update'])->name('staff.update');

    

    // Reports

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

        Route::prefix('reports')->group(function () {

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

            Route::get('/', [ReportController::class, 'index'])->name('reports.index');

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

            Route::post('/fetch-data', [ReportController::class, 'fetchReportData'])->name('reports.fetch-data');

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

            Route::post('/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export-pdf');

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

            Route::get('/export-excel', [ReportController::class, 'exportExcel'])->name('reports.export-excel');

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

        });

});

Route::middleware(['auth', 'role:admin'])->group(function () {

    // User Account Management (Admin Only)

    Route::resource('users', UserController::class)->except(['destroy']);

    Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');

    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // System Settings (Admin Only)

    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');

    Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

});

