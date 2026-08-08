# Viva Live Coding Cheat Sheet & Offline Reference Guide

This reference sheet is designed to help you during your physical offline viva session. Use it to answer questions about the system architecture, explain validation logics, or quickly make live coding modifications.

---

## 1. Routing & Access Control ([web.php](file:///D:/xampp/htdocs/HMS/routes/web.php))

### How to Register a New Endpoint
1. **Authenticated Users (All Roles)**: Add inside `Route::middleware(['auth'])->group(...)`.
2. **Staff, Managers, and Admins**: Add inside `Route::middleware(['auth', 'role:admin,manager,staff'])->group(...)`.
3. **Admin and Manager Only**: Add inside `Route::middleware(['auth', 'role:admin,manager'])->group(...)`.
4. **Admin Only**: Add inside `Route::middleware(['auth', 'role:admin'])->group(...)`.

### Live Coding Snippet: Registering a route
```php
// Example: Add a new custom profile GET route inside the authenticated group
Route::get('/profile/view', [UserController::class, 'viewProfile'])->name('profile.view');
```

---

## 2. Dynamic View Controls (Blade Templates)

You can hide or show buttons and text in Blade files based on the authenticated user's role:

```html
<!-- Check if user is Admin or Manager -->
@if(auth()->user()->isAdmin() || auth()->user()->isManager())
    <button class="btn btn-primary">Edit Resource</button>
@endif

<!-- Check if user is specifically Admin -->
@if(auth()->user()->isAdmin())
    <a href="{{ route('activity-logs.index') }}">View Activity Logs</a>
@endif
```

---

## 3. Disabling Deletions & Immutability (Safety Guard)

### Disabling Deletions
For models where delete operations are disabled (Reservations, Customers, etc.):
1. **Route Level**: The `destroy` action is omitted from resources.
2. **Controller Level**: Inside controller `destroy` methods, `abort(403, 'Deletion is disabled.');` is returned.
3. **UI Level**: Delete buttons and forms are removed from views.

### Immutable Invoices & Payments (Discrepancy Prevention)
To preserve the financial trail, edit and update actions are entirely disabled for both Invoices and Payments:
1. **Routes**: `edit` and `update` endpoints are removed from `/routes/web.php`.
2. **Controllers**: In [InvoiceController.php](file:///D:/xampp/htdocs/HMS/app/Http/Controllers/InvoiceController.php) and [PaymentController.php](file:///D:/xampp/htdocs/HMS/app/Http/Controllers/PaymentController.php), the `edit` and `update` actions are guarded:
   ```php
   public function edit(Invoice $invoice) {
       abort(403, 'Editing invoices is disabled.');
   }
   public function update(Request $request, Invoice $invoice) {
       abort(403, 'Updating invoices is disabled.');
   }
   ```
3. **UI Link purges**: Edit buttons and options have been completely removed from index/detail view templates.

---

## 4. System Activity Logging

### How to Track a New Model
If asked to add activity tracking to a new model (e.g. `Inventory`):
1. Open the model file (e.g. `app/Models/Inventory.php`).
2. Import the trait at the top:
   ```php
   use App\Traits\LogsActivity;
   ```
3. Register the trait inside the class:
   ```php
   class Inventory extends Model
   {
       use LogsActivity; // Automatically logs creations, updates, and deletions
   }
   ```

### How Authentication Events are Tracked
Auth event tracking is registered inside `app/Providers/EventServiceProvider.php` inside the `boot()` method. It listens to Laravel's default Auth events:
* `Illuminate\Auth\Events\Login`
* `Illuminate\Auth\Events\Logout`
* `Illuminate\Auth\Events\Failed`

---

## 5. Offline Currency Conversion API

The Currency Exchange widget is 100% offline-friendly and zero-dependency, powered by a local Laravel controller.

### Backend Conversion Logic
File: [CurrencyApiController.php](file:///D:/xampp/htdocs/HMS/app/Http/Controllers/CurrencyApiController.php)
- Hardcoded exchange rates for 17 major currencies relative to **1 USD**.
- Calculations are processed on-the-fly inside the controller.
- **Request validations**: Enforces base/target code length (3 chars) and positive numeric amounts:
  ```php
  $request->validate([
      'base' => 'required|string|size:3',
      'target' => 'required|string|size:3',
      'amount' => 'required|numeric|min:0',
  ]);
  ```
- Route registration inside [api.php](file:///D:/xampp/htdocs/HMS/routes/api.php):
  ```php
  Route::get('/convert', [CurrencyApiController::class, 'convert']);
  ```

### Dashboard Widget Re-Theme & Purge
- Widget file path: [widget.js](file:///D:/xampp/htdocs/HMS/public/js/widget.js) (Shadow DOM element).
- Purged all non-functional 7-day trend SVG charts, accordion toggles, history loaders, and accordion containers.
- Rethemed using gold variables (`#D4AF37`) inside custom CSS properties overriding the converter container in [dashboard.blade.php](file:///D:/xampp/htdocs/HMS/resources/views/dashboard.blade.php).

---

## 6. Navbar Alerts & Notification Subdirectory Fixes

The alerts and notifications dropdown was corrected to work under subdirectory root-paths (e.g., `/HMS/public/`) without returning `404 Not Found`.

### Base URL configuration
- In the HTML head of [app.blade.php](file:///D:/xampp/htdocs/HMS/resources/views/layouts/app.blade.php):
  ```html
  <meta name="base-url" content="{{ url('/') }}">
  ```
- JS files retrieve this prefix to resolve endpoints correctly:
  ```javascript
  const baseUrl = $('meta[name="base-url"]').attr('content') || '';
  $.get(baseUrl + '/alerts/unread-count', function(response) { ... });
  ```

### AJAX JSON Formats vs. Blade Views
In [AlertController.php](file:///D:/xampp/htdocs/HMS/app/Http/Controllers/AlertController.php), the `index()` action handles requests dynamically:
- Returns JSON for AJAX calls (rendered inside navbar dropdown).
- Serves the Blade view for direct HTML index page loads.
  ```php
  public function index(Request $request)
  {
      $alertsQuery = auth()->user()->alerts()->latest();
      if ($request->ajax() || $request->wantsJson()) {
          return response()->json($alertsQuery->take(5)->get());
      }
      $alerts = $alertsQuery->paginate(10);
      return view('alerts.index', compact('alerts'));
  }
  ```

---

## 7. Room Status Auto-Sync & Paid Auto-Checkout

### How the Status Sync Works
- Handled in [ReservationObserver.php](file:///D:/xampp/htdocs/HMS/app/Observers/ReservationObserver.php).
- During `created` and `updated` events of the `Reservation` model:
  - If status becomes `checked_in` -> room status is updated to `occupied`.
  - If status becomes `checked_out` -> room status is updated to `available`.

### How the Auto-Checkout Middleware Works
- Implemented in [AutoCheckOutMiddleware.php](file:///D:/xampp/htdocs/HMS/app/Http/Middleware/AutoCheckOutMiddleware.php).
- Registered globally in `web` group inside [Kernel.php](file:///D:/xampp/htdocs/HMS/app/Http/Kernel.php).
- On each web request, it finds all checked-in reservations whose checkout date is <= today.
- If checkout is today, it verifies if the current time is past check-out time (default is `12:00:00`).
- If it is past check-out time, and the invoice status is `paid`, it automatically changes the reservation status to `checked_out`.
- This triggers the observer to release the room as `available` instantly.

---

## 8. Strict Guest Count Validation

### How the Validation Works
- **Server-Side Constraints**: Evaluated in both [StoreReservationRequest.php](file:///D:/xampp/htdocs/HMS/app/Http/Requests/StoreReservationRequest.php) and [UpdateReservationRequest.php](file:///D:/xampp/htdocs/HMS/app/Http/Requests/UpdateReservationRequest.php). The custom closures enforce name-based overrides on the `number_of_guests` field (Single Room = 1, Double Room = 2, Deluxe Family Room = 4).
- **Client-Side Restrictions**: Managed in JavaScript inside both the [Create](file:///D:/xampp/htdocs/HMS/resources/views/reservations/create.blade.php) and [Edit](file:///D:/xampp/htdocs/HMS/resources/views/reservations/edit.blade.php) views. Selecting a room dynamically sets the HTML `max` attribute of the guest count input and auto-caps values that exceed the limit.

---

## 9. Customer Identity Validation & Searches (`nic_passport`)

### Schema & Validation
- Nullable string column in `customers` table, max 50 characters.
- Validated via:
  ```php
  'nic_passport' => 'nullable|string|max:50'
  ```

### Search Logic & White-listing
- Searched in [CustomerController.php](file:///D:/xampp/htdocs/HMS/app/Http/Controllers/CustomerController.php) via `orWhere('nic_passport', 'LIKE', "%{$search}%")`.
- Sort query whitelist:
  ```php
  $allowedSortColumns = ['id', 'name', 'email', 'phone', 'nic_passport', 'created_at'];
  ```
- Form fields are populated under inputs labeled **NIC or Passport Number** in `create.blade.php` and `edit.blade.php`.

---

## 10. Quick Commands Reference (Offline Shell)

Run these commands inside your project root (`d:\xampp\htdocs\HMS`):

```bash
# Run the entire automated test suite (verifies all permissions and validations)
php artisan test

# Run a specific test class (faster)
php artisan test --filter=CustomerTest
php artisan test --filter=ReservationGuestValidationTest
php artisan test --filter=ImmutableInvoicePaymentTest
php artisan test --filter=AlertsTest
php artisan test --filter=CurrencyApiTest

# Re-run database migrations (if database changes are made)
php artisan migrate

# Roll back the latest migration
php artisan migrate:rollback

# Enter Laravel interactive terminal to run manual PHP code (Tinker)
php artisan tinker
```


---

## 11. Navbar Dropdown Toggling & Explicit Sign Out Action

### Why the custom toggle handler is used
In the HMS portal layout (app.blade.php), we use a custom delegated jQuery click listener to toggle `.dropdown-menu` expand states:
```javascript
$(document).on('click', '#navbarDropdown, #alertsDropdown', function(e) {
    e.preventDefault();
    e.stopPropagation();
    const $dropdown = $(this).parent();
    const $menu = $(this).next('.dropdown-menu');
    $('.dropdown').not($dropdown).removeClass('show');
    $('.dropdown-menu').not($menu).removeClass('show');
    $dropdown.toggleClass('show');
    $menu.toggleClass('show');
});
```
This is necessary because third-party components loaded on the Dashboard page (like Pusher real-time elements, Chart.js, and the currency converter's Shadow DOM boundaries) intercept document bubble events, occasionally breaking Bootstrap's default auto-initialization.

### Explicit Sign-Out Icon & Label
To prevent empty translator variables (`{{ __('Logout') }}`) from rendering invisible links, we use a hardcoded translation fallback with FontAwesome icons:
```html
<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="fas fa-sign-out-alt me-2"></i>Logout
</a>
```

---

## 12. Guest Pulse AI Link Commenting & Relocation

- **Relocation**: The Guest Pulse AI sidebar link is placed at the bottom of the sidebar element list.
- **Commenting**: To prevent presentation errors when the local Guest Pulse Node server (port `8000`) is offline, the link has been wrapped inside Blade comments:
  ```html
  {{-- 
  @role('admin,manager')
  <li>
      <a href="http://127.0.0.1:8000/?user_name={{ urlencode(auth()->user()->name) }}&user_role={{ urlencode(auth()->user()->role) }}" target="_blank">
          <i class="fas fa-heart-pulse"></i>
          <span>Guest Pulse AI</span>
      </a>
  </li>
  @endrole
  --}}
  ```
  *To restore the link post-presentation, simply remove the `{{--` and `--}}` wrapping tags.*

---

## 13. Query Sort Keys Mismatches (Database vs. Whitelists)

If users encounter a database QueryException when sorting table views (e.g. unknown column exceptions):
1. Check the controller's `$allowedSortColumns` whitelist.
2. Ensure the whitelisted column names match the actual database schema rather than the presentation fields:
   * **Invoices**: Whitelist `invoice_date` and `total_amount` instead of `issue_date` and `total`.
   * **Events**: Whitelist `start_time`, `end_time`, and `max_attendees` instead of `start_date`, `end_date`, and `capacity`.

---

## 14. Checked-in and Checked-out Reservation Invoicing

To allow creating invoices for active guests or checked-out guests whose invoices have not been finalized:
1. Open the [InvoiceController.php](file:///D:/xampp/htdocs/HMS/app/Http/Controllers/InvoiceController.php).
2. Inside `create()`, the query fetching reservations must allow the `checked_in` and `checked_out` status:
   ```php
   $reservations = \App\Models\Reservation::with(['customer', 'room.roomType'])
       ->whereIn('status', ['pending', 'confirmed', 'checked_in', 'checked_out'])
       ->whereDoesntHave('invoice')
       ->get();
   ```

---

## 15. Paid Reservations Auto-Checkout Automation

The automatic check-out engine running in the background ([AutoCheckOutMiddleware.php](file:///D:/xampp/htdocs/HMS/app/Http/Middleware/AutoCheckOutMiddleware.php)) releases stays automatically:
1. It queries paid reservations whose stay period has concluded.
2. It targets both **`checked_in`** and **`confirmed`** reservations, ensuring guest stays that ended are automatically marked as `checked_out` even if staff neglected to check them in manually:
   ```php
   $reservations = Reservation::whereIn('status', ['checked_in', 'confirmed'])
       ->whereDate('check_out_date', '<=', now()->toDateString())
       ->get();
   ```

---

## 16. Expanded Reports & Analytics (F&B Sales & Tax Levies Auditing)

### How F&B Sales queries work
Queries the `invoice_items` where description matches names in the `food_items` table:
```php
$foodNames = \App\Models\FoodItem::pluck('name')->toArray();
$items = \App\Models\InvoiceItem::whereIn('description', $foodNames)
    ->whereHas('invoice', function($q) use ($from, $to) {
        $q->whereBetween('invoice_date', [$from, $to]);
    })
    ->selectRaw('description as food_item_name, unit_price, sum(quantity) as quantity_sold, sum(quantity * unit_price) as total_sales')
    ->groupBy('description', 'unit_price')
    ->get();
```

### How Tax Levies Audit queries work
Gathers all invoice tax columns (`base_amount`, `service_charge`, `sscl_amount`, `tdl_amount`, `vat_amount`, `grand_total`) and computes sum totals to render columns-wise aggregates in Datatables footer.

---

## 17. Guest Invoice Payments Restriction

Since online transactions are disabled, the Pay credit card button (invoice list) and Record Payment button (invoice details page) are restricted:
1. **Blade logic**: Wrap them in `@if(!auth()->user()->isGuest()) ... @endif`.
2. **Result**: Hides payment triggers completely for Guest roles while keeping them active for hotel Staff, Managers, and Admins.

---

## 18. Real-time Guest Booking Alerts & Layout Styling Fixes

### How Booking Alerts work
Alerts are generated in the `created` hook of [ReservationObserver.php](file:///D:/xampp/htdocs/HMS/app/Observers/ReservationObserver.php):
```php
private function notifyStaff(Reservation $reservation): void
{
    $creator = auth()->user();
    $isGuestCreated = $creator && $creator->isGuest();
    
    $title = $isGuestCreated ? 'New Guest Booking' : 'New Booking Registered';
    $customerName = $reservation->customer->name ?? 'Guest';
    $roomNumber = $reservation->room->number ?? 'TBD';
    
    $message = $isGuestCreated 
        ? "Guest {$customerName} has booked Room {$roomNumber}."
        : "Staff member " . ($creator->name ?? 'System') . " registered a booking for {$customerName} in Room {$roomNumber}.";

    $staffUsers = \App\Models\User::whereIn('role', ['admin', 'manager', 'staff'])->get();
    foreach ($staffUsers as $user) {
        \App\Models\Alert::create([
            'user_id' => $user->id,
            'title' => $title,
            'message' => $message,
            'type' => 'info',
            'link' => route('reservations.show', $reservation),
            'is_read' => false
        ]);
    }
}
```

### Layout Styling Fixes
To prevent dropdown menu clipping, overlay conflicts, and wrapping issues inside the navbar dropdown:
1. **Z-Index**: Set `.navbar { z-index: 1050 !important; }` to overlay on top of cards and page content elements.
2. **Alignment**: Set `.navbar .dropdown-menu-end { right: 0 !important; left: auto !important; }` to keep the menu aligned on screen.
3. **Text Wrapping**: Set `.alerts-dropdown .dropdown-item { white-space: normal !important; }` to force long alert descriptions to wrap onto multiple lines.

---

## 19. Route Wildcard Priority Fix (Create Rooms/Events 404 Resolution)

### The Problem
Laravel evaluates routes in order of registration. Because split resource groups registered read-only access (containing `rooms/{room}` wildcard show mapping) *before* restricted actions (containing static `rooms/create`), Laravel matched requests for `rooms/create` with the `rooms/{room}` wildcard route. 
Since `"create"` is not a valid room identifier, Route Model Binding threw a `ModelNotFoundException`, returning a `404 | NOT FOUND` response instead of loading the form.

### The Fix
Reordered route registration in `routes/web.php` to define operational/creation actions first:
```php
// Restricted operational resources (Register first to evaluate static `/create` first)
Route::middleware(['role:admin,manager'])->group(function () {
    Route::resource('rooms', RoomController::class)->except(['index', 'show', 'destroy']);
    Route::resource('events', EventController::class)->except(['index', 'show', 'destroy']);
    ...
});

// Common read-only resources (Register second)
Route::resource('rooms', RoomController::class)->only(['index', 'show']);
Route::resource('events', EventController::class)->only(['index', 'show']);
```
This solves all wildcard collision 404s cleanly and maintains the exact same security/access policies.

---

## 20. Editable Invoice Quantity & Dynamic Total Price Calculation

### The Problem
During invoice creation (`/invoices/create`), the main charge input representing the primary service (e.g. event pricing or reservation nights) was locked using the `readonly` attribute on the quantity field. Therefore, users could not adjust quantities (e.g. specifying the number of event attendees or billable segments) or recalculate the invoice subtotal.

### The Fix
1. Removed `readonly` from `<input class="main-charge-quantity">` inside `create.blade.php`.
2. Added an input event listener to automatically compute the row's total and update the parent invoice subtotal and taxes:
```javascript
// Calculate main charge total
$(document).on('input', '.main-charge-quantity, .main-charge-unit-price', function() {
    const quantity = parseFloat($('.main-charge-quantity').val()) || 0;
    const unitPrice = parseFloat($('.main-charge-unit-price').val()) || 0;
```


---

## 11. Navbar Dropdown Toggling & Explicit Sign Out Action

### Why the custom toggle handler is used
In the HMS portal layout (app.blade.php), we use a custom delegated jQuery click listener to toggle `.dropdown-menu` expand states:
```javascript
$(document).on('click', '#navbarDropdown, #alertsDropdown', function(e) {
    e.preventDefault();
    e.stopPropagation();
    const $dropdown = $(this).parent();
    const $menu = $(this).next('.dropdown-menu');
    $('.dropdown').not($dropdown).removeClass('show');
    $('.dropdown-menu').not($menu).removeClass('show');
    $dropdown.toggleClass('show');
    $menu.toggleClass('show');
});
```
This is necessary because third-party components loaded on the Dashboard page (like Pusher real-time elements, Chart.js, and the currency converter's Shadow DOM boundaries) intercept document bubble events, occasionally breaking Bootstrap's default auto-initialization.

### Explicit Sign-Out Icon & Label
To prevent empty translator variables (`{{ __('Logout') }}`) from rendering invisible links, we use a hardcoded translation fallback with FontAwesome icons:
```html
<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="fas fa-sign-out-alt me-2"></i>Logout
</a>
```

---

## 12. Guest Pulse AI Link Commenting & Relocation

- **Relocation**: The Guest Pulse AI sidebar link is placed at the bottom of the sidebar element list.
- **Commenting**: To prevent presentation errors when the local Guest Pulse Node server (port `8000`) is offline, the link has been wrapped inside Blade comments:
  ```html
  {{-- 
  @role('admin,manager')
  <li>
      <a href="http://127.0.0.1:8000/?user_name={{ urlencode(auth()->user()->name) }}&user_role={{ urlencode(auth()->user()->role) }}" target="_blank">
          <i class="fas fa-heart-pulse"></i>
          <span>Guest Pulse AI</span>
      </a>
  </li>
  @endrole
  --}}
  ```
  *To restore the link post-presentation, simply remove the `{{--` and `--}}` wrapping tags.*

---

## 13. Query Sort Keys Mismatches (Database vs. Whitelists)

If users encounter a database QueryException when sorting table views (e.g. unknown column exceptions):
1. Check the controller's `$allowedSortColumns` whitelist.
2. Ensure the whitelisted column names match the actual database schema rather than the presentation fields:
   * **Invoices**: Whitelist `invoice_date` and `total_amount` instead of `issue_date` and `total`.
   * **Events**: Whitelist `start_time`, `end_time`, and `max_attendees` instead of `start_date`, `end_date`, and `capacity`.

---

## 14. Checked-in and Checked-out Reservation Invoicing

To allow creating invoices for active guests or checked-out guests whose invoices have not been finalized:
1. Open the [InvoiceController.php](file:///D:/xampp/htdocs/HMS/app/Http/Controllers/InvoiceController.php).
2. Inside `create()`, the query fetching reservations must allow the `checked_in` and `checked_out` status:
   ```php
   $reservations = \App\Models\Reservation::with(['customer', 'room.roomType'])
       ->whereIn('status', ['pending', 'confirmed', 'checked_in', 'checked_out'])
       ->whereDoesntHave('invoice')
       ->get();
   ```

---

## 15. Paid Reservations Auto-Checkout Automation

The automatic check-out engine running in the background ([AutoCheckOutMiddleware.php](file:///D:/xampp/htdocs/HMS/app/Http/Middleware/AutoCheckOutMiddleware.php)) releases stays automatically:
1. It queries paid reservations whose stay period has concluded.
2. It targets both **`checked_in`** and **`confirmed`** reservations, ensuring guest stays that ended are automatically marked as `checked_out` even if staff neglected to check them in manually:
   ```php
   $reservations = Reservation::whereIn('status', ['checked_in', 'confirmed'])
       ->whereDate('check_out_date', '<=', now()->toDateString())
       ->get();
   ```

---

## 16. Expanded Reports & Analytics (F&B Sales & Tax Levies Auditing)

### How F&B Sales queries work
Queries the `invoice_items` where description matches names in the `food_items` table:
```php
$foodNames = \App\Models\FoodItem::pluck('name')->toArray();
$items = \App\Models\InvoiceItem::whereIn('description', $foodNames)
    ->whereHas('invoice', function($q) use ($from, $to) {
        $q->whereBetween('invoice_date', [$from, $to]);
    })
    ->selectRaw('description as food_item_name, unit_price, sum(quantity) as quantity_sold, sum(quantity * unit_price) as total_sales')
    ->groupBy('description', 'unit_price')
    ->get();
```

### How Tax Levies Audit queries work
Gathers all invoice tax columns (`base_amount`, `service_charge`, `sscl_amount`, `tdl_amount`, `vat_amount`, `grand_total`) and computes sum totals to render columns-wise aggregates in Datatables footer.

---

## 17. Guest Invoice Payments Restriction

Since online transactions are disabled, the Pay credit card button (invoice list) and Record Payment button (invoice details page) are restricted:
1. **Blade logic**: Wrap them in `@if(!auth()->user()->isGuest()) ... @endif`.
2. **Result**: Hides payment triggers completely for Guest roles while keeping them active for hotel Staff, Managers, and Admins.

---

## 18. Real-time Guest Booking Alerts & Layout Styling Fixes

### How Booking Alerts work
Alerts are generated in the `created` hook of [ReservationObserver.php](file:///D:/xampp/htdocs/HMS/app/Observers/ReservationObserver.php):
```php
private function notifyStaff(Reservation $reservation): void
{
    $creator = auth()->user();
    $isGuestCreated = $creator && $creator->isGuest();
    
    $title = $isGuestCreated ? 'New Guest Booking' : 'New Booking Registered';
    $customerName = $reservation->customer->name ?? 'Guest';
    $roomNumber = $reservation->room->number ?? 'TBD';
    
    $message = $isGuestCreated 
        ? "Guest {$customerName} has booked Room {$roomNumber}."
        : "Staff member " . ($creator->name ?? 'System') . " registered a booking for {$customerName} in Room {$roomNumber}.";

    $staffUsers = \App\Models\User::whereIn('role', ['admin', 'manager', 'staff'])->get();
    foreach ($staffUsers as $user) {
        \App\Models\Alert::create([
            'user_id' => $user->id,
            'title' => $title,
            'message' => $message,
            'type' => 'info',
            'link' => route('reservations.show', $reservation),
            'is_read' => false
        ]);
    }
}
```

### Layout Styling Fixes
To prevent dropdown menu clipping, overlay conflicts, and wrapping issues inside the navbar dropdown:
1. **Z-Index**: Set `.navbar { z-index: 1050 !important; }` to overlay on top of cards and page content elements.
2. **Alignment**: Set `.navbar .dropdown-menu-end { right: 0 !important; left: auto !important; }` to keep the menu aligned on screen.
3. **Text Wrapping**: Set `.alerts-dropdown .dropdown-item { white-space: normal !important; }` to force long alert descriptions to wrap onto multiple lines.

---

## 19. Route Wildcard Priority Fix (Create Rooms/Events 404 Resolution)

### The Problem
Laravel evaluates routes in order of registration. Because split resource groups registered read-only access (containing `rooms/{room}` wildcard show mapping) *before* restricted actions (containing static `rooms/create`), Laravel matched requests for `rooms/create` with the `rooms/{room}` wildcard route. 
Since `"create"` is not a valid room identifier, Route Model Binding threw a `ModelNotFoundException`, returning a `404 | NOT FOUND` response instead of loading the form.

### The Fix
Reordered route registration in `routes/web.php` to define operational/creation actions first:
```php
// Restricted operational resources (Register first to evaluate static `/create` first)
Route::middleware(['role:admin,manager'])->group(function () {
    Route::resource('rooms', RoomController::class)->except(['index', 'show', 'destroy']);
    Route::resource('events', EventController::class)->except(['index', 'show', 'destroy']);
    ...
});

// Common read-only resources (Register second)
Route::resource('rooms', RoomController::class)->only(['index', 'show']);
Route::resource('events', EventController::class)->only(['index', 'show']);
```
This solves all wildcard collision 404s cleanly and maintains the exact same security/access policies.

---

## 20. Editable Invoice Quantity & Dynamic Total Price Calculation

### The Problem
During invoice creation (`/invoices/create`), the main charge input representing the primary service (e.g. event pricing or reservation nights) was locked using the `readonly` attribute on the quantity field. Therefore, users could not adjust quantities (e.g. specifying the number of event attendees or billable segments) or recalculate the invoice subtotal.

### The Fix
1. Removed `readonly` from `<input class="main-charge-quantity">` inside `create.blade.php`.
2. Added an input event listener to automatically compute the row's total and update the parent invoice subtotal and taxes:
```javascript
$(document).on('input', '.main-charge-quantity, .main-charge-unit-price', function() {
    const quantity = parseFloat($('.main-charge-quantity').val()) || 0;
    const unitPrice = parseFloat($('.main-charge-unit-price').val()) || 0;
    const total = quantity * unitPrice;
    $('.main-charge-total').val(total.toFixed(2));
    updateTotals();
});
```
This enables flexible quantity overrides for primary charges while automatically computing correct tax valuations (`SSCL`, `VAT`, etc.).

---

## 21. Event Creation Back-Date & End-Time Prevention

### Backend Validation
Added the `after_or_equal:today` validator to the `start_time` field during event creation inside the `store` method of `EventController`:
```php
'start_time' => 'required|date|after_or_equal:today',
```

### Frontend UI Lockout & Enforced End-Time
1. Set the HTML `min` attribute on the `start_time` input inside `create.blade.php` to target the current datetime:
```html
min="{{ date('Y-m-d\TH:i') }}"
```
This forces browser calendar controls to lock out and grey out all dates before the current day/time.
2. Added Javascript change/input listeners in event create and edit forms: when the start time is modified, it dynamically updates the `min` constraint on the end time and corrects the end time to match the start time if it falls prior to it.

---

## 22. Unified Validation Error Displays on All Forms

### The Problem
When HTML5 input tags contain the `required` attribute, the browser intercepts form submission and displays a native bubble tooltip for the *first* empty field only. This prevents the request from reaching the Laravel backend to evaluate other fields, making it impossible for the user to see all validation errors simultaneously.

### The Fix
1. Added the `novalidate` attribute to the `<form>` tag of all creation and modification views across the system:
```html
<form action="..." method="POST" novalidate>
```
2. Injected a global jQuery required field validator script in `app.blade.php`:
```javascript
$(document).on('submit', 'form[novalidate]', function(e) {
    let isValid = true;
    $(this).find('.dynamic-feedback').remove();
    $(this).find('.is-invalid').removeClass('is-invalid');

    $(this).find('input[required], select[required], textarea[required]').each(function() {
        let $el = $(this);
        if ($el.prop('disabled') || !$el.is(':visible')) return;
        
        let val = $el.val();
        if (val === null || val === undefined || String(val).trim() === '') {
            isValid = false;
            $el.addClass('is-invalid');
            let $parent = $el.parent();
            let $feedback = $('<div class="invalid-feedback dynamic-feedback">This field is required.</div>');
            $el.after($feedback);
            $feedback.show();
        }
    });

    if (!isValid) {
        e.preventDefault();
        e.stopPropagation();
        $('html, body').animate({ scrollTop: $('.is-invalid').first().offset().top - 100 }, 200);
        $('.is-invalid').first().focus();
    }
});
```
This intercepts form submission client-side to instantly flag all missing required fields concurrently with dynamic feedback styles before sending the request to the server.

---

## 23. Industry-Standard Refactoring: Staff-User Relationship

### The Problem
Previously, a `Staff` record's `user_id` field pointed to the ID of the administrator/manager who registered the staff member in the system. Consequently, there was no direct linking relationship between a staff member's profile details and their actual login user account, forcing the system to match them via email addresses.

### The Fix
Refactored the relationship to match standard enterprise software architectures (where a staff record points to their own login credentials account):
1. **User Model**: Added the 1:1 inverse relationship method inside `User.php`:
   ```php
   public function staff() {
       return $this->hasOne(Staff::class);
   }
   ```
2. **Controller store() logic**: Modified the creation hook so that registering a new staff member automatically checks if a login account exists for their email. If not, it creates a new `User` account (`role => 'staff'` by default, status active, default password `'password'`) and stores its ID on the staff record's `user_id`.
3. **Controller update() logic**: Updates to a staff member's profile automatically synchronize their login `User` record (name, email, and role) in real-time.
4. **Seeders**: Updated `StaffSeeder` to seed unique User records for each staff profile.
5. **Testing**: Modified `StaffManagementTest` to assert that creating a staff record generates and links a personal User account with matching IDs.

---

## 24. Bi-Directional Access & Employment Status Synchronization

### The Problem
- `User` accounts have a boolean `status` representing whether their login is active or disabled.
- `Staff` profiles have an enum `status` (`'active'`, `'inactive'`, `'on_leave'`) representing their operational employment status.
- Modifying one status in the administrative control panels previously left the other unchanged, causing security/integrity issues (e.g. disabling a user account but leaving the staff member marked active).

### The Fix
Implemented bi-directional status synchronization across the `StaffController` and `UserController`:
1. **Staff to User Sync (`StaffController.php`)**:
   - Creating a staff member as `'inactive'` creates their `User` login account as `status => false` (disabled).
   - Updating a staff member to `'inactive'` disables their linked login account.
   - Updating a staff member to `'active'` or `'on_leave'` enables their login account (`status => true`).
2. **User to Staff Sync (`UserController.php`)**:
   - Toggling/updating a user status to disabled (`status => false`) automatically updates their employee `Staff` status to `'inactive'`.
   - Toggling/updating a user status to active (`status => true`) automatically updates their employee `Staff` status to `'active'` (only if currently `'inactive'`, keeping `'on_leave'` unchanged).

---

## 25. User Management Status Filtering Dropdown

### The Problem
While `Staff Management` supported filtering employees by status (`Active`, `Inactive`, `On Leave`), the `User Management` panel only supported text searching. Administrators could not filter user accounts by active/inactive status.

### The Fix
Implemented a status filter dropdown in User Management matching the style and functionality of the Staff Management dashboard:
1. **Controller index() query**:
   - Updates `UserController.php` to check the `status` query string.
   - Adds query constraint `status => true` for `'active'` and `status => false` for `'inactive'`.
   - Preserves filter parameters in pagination using `$users->appends(...)`.
2. **Blade view**:
   - Integrates `<select name="status">` inside the index search form containing `All Status`, `Active`, and `Inactive`.
   - Adds a jQuery listener at the end of `index.blade.php` to automatically submit the form when the status selection changes.
3. **Testing**:
   - Created `UserManagementTest.php` feature tests verifying keyword search and status dropdown query filters.
