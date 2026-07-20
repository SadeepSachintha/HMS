# Viva Live Coding Cheat Sheet & Offline Reference Guide

This reference sheet is designed to help you during your physical offline viva session. Use it to answer questions about the system architecture or quickly make live coding modifications.

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

## 3. Disabling Deletions (Safety Guard)

If asked about why deletions are blocked or how it is implemented:
1. **Route Level**: The `destroy` action has been omitted from all resource declarations (e.g. using `except(['destroy'])` or listing specific actions in `only(...)`).
2. **Controller Level**: Inside every model resource controller (e.g., `ReservationController`), the `destroy` method returns `abort(403, 'Deletion is disabled.');`.
3. **UI Level**: All delete buttons and forms have been removed from Blade views.

---

## 4. System Activity Logging

### How to Track a New Model
If you are asked to add activity tracking to any new model (e.g., a new `Inventory` model):
1. Open the model file (e.g. `app/Models/Inventory.php`).
2. Import the trait at the top of the file:
   ```php
   use App\Traits\LogsActivity;
   ```
3. Register the trait inside the class:
   ```php
   class Inventory extends Model
   {
       use LogsActivity;
   }
   ```
Eloquent will automatically log creations, updates, and deletions for this model, including identifying which fields were modified.

### How Authentication Events are Tracked
Auth event tracking is registered inside `app/Providers/EventServiceProvider.php` inside the `boot()` method. It listens to Laravel's default Auth events:
* `Illuminate\Auth\Events\Login`
* `Illuminate\Auth\Events\Logout`
* `Illuminate\Auth\Events\Failed`

---

## 5. Quick Commands Reference (Offline Shell)

Run these commands inside your project root (`d:\xampp\htdocs\HMS`):

```bash
# Run the entire automated test suite (verifies all permissions and operations)
php artisan test

# Run a specific test class (faster)
php artisan test --filter=ActivityLogTest
php artisan test --filter=RoleAccessTest

# Re-run database migrations (if database changes are made)
php artisan migrate

# Roll back the latest migration
php artisan migrate:rollback

# Enter Laravel interactive terminal to run manual PHP code (Tinker)
php artisan tinker
```

---

## 6. Room Status Auto-Sync & Paid Auto-Checkout

### How the Status Sync Works
- Handled in [ReservationObserver.php](file:///D:/xampp/htdocs/HMS/app/Observers/ReservationObserver.php).
- During `created` and `updated` events of the `Reservation` model:
  - If status becomes `checked_in` -> room status is updated to `occupied`.
  - If status becomes `checked_out` -> room status is updated to `available`.

### How the Auto-Checkout Middleware Works
- Implemented in [AutoCheckOutMiddleware.php](file:///D:/xampp/htdocs/HMS/app/Http/Middleware/AutoCheckOutMiddleware.php).
- Registered globally in `web` group inside [Kernel.php](file:///D:/xampp/htdocs/HMS/app/Http/Kernel.php).
- On each web request, it finds all checked-in reservations whose checkout date is <= today.
- If checkout is today, it verifies if the current time is past the hotel's check-out time (default fallback is `12:00:00`).
- If it is past the check-out time, and the invoice status is `paid`, it automatically changes the reservation status to `checked_out`.
- This triggers the observer to release the room as `available` instantly.

### Quick Tinker Verification Commands
```php
// Check for auto-checkout status in Tinker:
(new App\Http\Middleware\AutoCheckOutMiddleware())->handle(request(), function() {});
```

---

## 7. Strict Guest Count Validation

### How the Validation Works
- **Server-Side Constraints**: Evaluated in both [StoreReservationRequest.php](file:///D:/xampp/htdocs/HMS/app/Http/Requests/StoreReservationRequest.php) and [UpdateReservationRequest.php](file:///D:/xampp/htdocs/HMS/app/Http/Requests/UpdateReservationRequest.php). The custom closures enforce name-based overrides on the `number_of_guests` field (Single Room = 1, Double Room = 2, Deluxe Family Room = 4).
- **Client-Side Restrictions**: Managed in JavaScript inside both the [Create](file:///D:/xampp/htdocs/HMS/resources/views/reservations/create.blade.php) and [Edit](file:///D:/xampp/htdocs/HMS/resources/views/reservations/edit.blade.php) views. Selecting a room dynamically sets the HTML `max` attribute of the guest count input and auto-caps values that exceed the limit.

### Quick Testing Commands
```bash
# Run only guest capacity validation tests
php artisan test --filter=ReservationGuestValidationTest
```
