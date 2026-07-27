# Walkthrough - HMS Feature Enhancements

## 🛎️ 1. Reservation Guest Count Validation

We implemented guest count validations to restrict reservation guests according to room type specifications:
- **Single Room**: Max 1 guest
- **Double Room**: Max 2 guests
- **Deluxe Family Room**: Max 4 guests

### Changes Made
- **[StoreReservationRequest.php](file:///D:/xampp/htdocs/HMS/app/Http/Requests/StoreReservationRequest.php)** / **[UpdateReservationRequest.php](file:///D:/xampp/htdocs/HMS/app/Http/Requests/UpdateReservationRequest.php)**: Added name-based capacity check overrides.
- **[create.blade.php](file:///D:/xampp/htdocs/HMS/resources/views/reservations/create.blade.php)** / **[edit.blade.php](file:///D:/xampp/htdocs/HMS/resources/views/reservations/edit.blade.php)**: Dynamic JavaScript capacity overrides on room selection.
- **[ReservationGuestValidationTest.php](file:///D:/xampp/htdocs/HMS/tests/Feature/ReservationGuestValidationTest.php)**: Created feature tests confirming strict capacity rules.

---

## 💳 2. Immutable Invoices & Payments

To enforce audit trail integrity and prevent accounting discrepancy, edits to **Invoices** and **Payments** have been fully disabled.

### Changes Made

#### Routing & Controllers
- **[web.php](file:///D:/xampp/htdocs/HMS/routes/web.php)**: Removed edit/update routes from the `payments` and `invoices` resource declarations.
- **[InvoiceController.php](file:///D:/xampp/htdocs/HMS/app/Http/Controllers/InvoiceController.php)** / **[PaymentController.php](file:///D:/xampp/htdocs/HMS/app/Http/Controllers/PaymentController.php)**: Added `abort(403, 'Editing ... is disabled.');` to `edit` and `update` actions as a backend security guard.

#### User Interface
- **[invoices/index.blade.php](file:///D:/xampp/htdocs/HMS/resources/views/invoices/index.blade.php)**: Removed the Edit button from the list actions column.
- **[invoices/show.blade.php](file:///D:/xampp/htdocs/HMS/resources/views/invoices/show.blade.php)**: Removed the Edit Invoice button from the header.
- **[payments/index.blade.php](file:///D:/xampp/htdocs/HMS/resources/views/payments/index.blade.php)**: Removed the Edit button from the list actions column.
- **[payments/show.blade.php](file:///D:/xampp/htdocs/HMS/resources/views/payments/show.blade.php)**: Removed the Edit button from the header.

---

## 💵 3. Currency Exchange Retheming & Cleanups

The Currency Converter widget has been visually re-themed to integrate with the dashboard's design system, and the non-functional 7-day trend functionality was removed.

### Changes Made
- **[dashboard.blade.php](file:///D:/xampp/htdocs/HMS/resources/views/dashboard.blade.php)**:
  - Relocated the widget container into the right sidebar column directly below the *Today's Arrivals* section.
  - Set the widget attribute `theme="glass"` to leverage the native glassmorphic background layer.
  - Injected custom CSS variables under `<style>` to override elements with gold variables (`#D4AF37`) and transparent borders.
  - Removed duplicate header markup.
- **[widget.js](file:///D:/xampp/htdocs/HMS/public/js/widget.js)**:
  - Enabled customizable CSS variables (`--converter-title-gradient`, `--converter-result-bg`, `--converter-result-border`, `--converter-focus-shadow`) inside the shadow DOM styling.
  - Updated fallback styles to default to the dark-gold and champagne luxury gradient themes.
  - **Cleanups**: Completely removed the 7-day trend accordion button, trend container, SVG chart, history API fetchers, and all associated helper functions/event-listeners.

---

## 🔔 4. Navbar Alerts System Fixes

We identified and resolved two critical issues preventing alerts from functioning correctly on local XAMPP/subdirectory environments:

### Changes Made
- **[AlertController.php](file:///D:/xampp/htdocs/HMS/app/Http/Controllers/AlertController.php)**: Updated `index()` to detect AJAX requests and return a JSON list of the top 5 alerts rather than always serving the Blade template view (which crashed Javascript parsers).
- **[app.blade.php](file:///D:/xampp/htdocs/HMS/resources/views/layouts/app.blade.php)**: Injected a `<meta name="base-url">` tag containing Laravel's root URL path dynamically.
- **[alerts.js](file:///D:/xampp/htdocs/HMS/public/js/alerts.js)**: Prepend `baseUrl` to all AJAX GET/POST requests (`/alerts`, `/alerts/unread-count`, `/alerts/{id}/mark-as-read`). This ensures AJAX calls correctly map to subdirectories (e.g. `/HMS/public/alerts`) instead of returning `404 Not Found`.
- **[AlertsTest.php](file:///D:/xampp/htdocs/HMS/tests/Feature/AlertsTest.php)**: Implemented automated feature tests confirming Blade vs. JSON formatting, mark-as-read flags, and unread counts.

---

## 🪪 5. Customer NIC / Passport Number Field

We added support for collecting, listing, viewing, and searching by an official guest identification number (NIC or Passport Number).

### Changes Made

#### Database
- **[2026_07_27_100915_add_nic_passport_to_customers_table.php](file:///D:/xampp/htdocs/HMS/database/migrations/2026_07_27_100915_add_nic_passport_to_customers_table.php)**: Added a nullable string column `nic_passport` (up to 50 chars) to the `customers` table.

#### Backend Logic & Validation
- **[Customer.php](file:///D:/xampp/htdocs/HMS/app/Models/Customer.php)**: Whitelisted `nic_passport` in mass assignable `$fillable` fields.
- **[StoreCustomerRequest.php](file:///D:/xampp/htdocs/HMS/app/Http/Requests/StoreCustomerRequest.php)** / **[UpdateCustomerRequest.php](file:///D:/xampp/htdocs/HMS/app/Http/Requests/UpdateCustomerRequest.php)**: Validated `nic_passport` as `nullable|string|max:50`.
- **[CustomerController.php](file:///D:/xampp/htdocs/HMS/app/Http/Controllers/CustomerController.php)**:
  - Whitelisted `nic_passport` as sortable in index queries.
  - Added `->orWhere('nic_passport', 'LIKE', "%{$search}%")` to the search filter.

#### Frontend Views
- **[create.blade.php](file:///D:/xampp/htdocs/HMS/resources/views/customers/create.blade.php)**: Added a new input field labeled "NIC or Passport Number".
- **[edit.blade.php](file:///D:/xampp/htdocs/HMS/resources/views/customers/edit.blade.php)**: Added the edit field populated with existing database values.
- **[show.blade.php](file:///D:/xampp/htdocs/HMS/resources/views/customers/show.blade.php)**: Displayed "NIC / Passport No" in the customer metadata table.
- **[index.blade.php](file:///D:/xampp/htdocs/HMS/resources/views/customers/index.blade.php)**: Added a sortable "NIC / Passport No" column and adjusted column spans.

---

## 🔬 Verification Results

### Automated Tests
Ran the full test suite (including the new `CustomerTest.php` cases):
```bash
php artisan test
```
Output:
```
   PASS  Tests\Feature\CustomerTest
  ✓ customer can be created with nic passport
  ✓ nic passport max length validation
  ✓ customer can be updated
  ✓ searching by nic passport

  Tests:  44 passed
  Time:   3.21s
```
All 44 test cases passed successfully.

### Manual Verification
Confirmed via browser subagent:
- Form fields render correctly and input sanitizations behave as expected.
- Customers can be searched dynamically by their NIC/Passport values.
- Prepopulation and updates work seamlessly.
- Staged screenshot showing customer listing with new ID column:
![Updated Customer List View](file:///C:/Users/Sadeep/.gemini/antigravity-ide/brain/d7d9d918-b5c6-48cc-9b06-88c9a9ab699e/updated_customer_index_1785128482919.png)
