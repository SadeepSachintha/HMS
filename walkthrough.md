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

## 🤵 6. Staff NIC Management & Guest Self-Registration

We expanded NIC validation and storage to cover hotel employees, and updated the public guest sign-up form to automatically capture contact details and identity fields.

### Changes Made

#### Database Schema
- **[2026_07_27_152625_add_nic_to_staff_table.php](file:///D:/xampp/htdocs/HMS/database/migrations/2026_07_27_152625_add_nic_to_staff_table.php)**: Added a unique `nic` column (max 50 chars) to the `staff` table.

#### Staff Logic & Views
- **[Staff.php](file:///D:/xampp/htdocs/HMS/app/Models/Staff.php)**: Whitelisted `nic` in mass-assignable fillable attributes.
- **[StaffController.php](file:///D:/xampp/htdocs/HMS/app/Http/Controllers/StaffController.php)**: Integrated unique constraints, search filters, and query sort whitelisting for employee NICs.
- **[Staff views](file:///D:/xampp/htdocs/HMS/resources/views/staff/)**: Integrated the **NIC Number** inputs and column displays inside staff create, edit, show, and index list templates.

#### Guest Self-Registration
- **[RegisterController.php](file:///D:/xampp/htdocs/HMS/app/Http/Controllers/Auth/RegisterController.php)**: Updated registration validations to collect `phone` and `nic_passport` parameters, automatically generating/mapping the associated `Customer` row upon user creation.
- **[register.blade.php](file:///D:/xampp/htdocs/HMS/resources/views/auth/register.blade.php)**: Injected public registration input forms for Phone and NIC/Passport.

---

## 🔬 Verification Results

### Automated Tests
Ran the full test suite (including the new `CustomerTest.php` and `StaffNicTest.php` cases):
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

   PASS  Tests\Feature\StaffNicTest
  ✓ staff can be created with nic
  ✓ staff nic must be unique
  ✓ guest can register with phone and nic

  Tests:  47 passed
  Time:   4.13s
```
All 47 test cases passed successfully.

### Manual Verification
Confirmed via browser subagent:
- Form fields render correctly and input sanitizations behave as expected.
- Customers and staff can be searched dynamically by their NIC values.
- Guest registration automatically populates customer profile metrics.
- Verified search query showing staff listing:
![Staff search query view](C:/Users/Sadeep/.gemini/antigravity-ide/brain/d7d9d918-b5c6-48cc-9b06-88c9a9ab699e/staff_search_bob_1785146605948.png)
- Verified guest session redirection view:
![Guest registration success](C:/Users/Sadeep/.gemini/antigravity-ide/brain/d7d9d918-b5c6-48cc-9b06-88c9a9ab699e/guest_register_success_1785146689384.png)


---

## 7. Navbar Dropdown Toggling & Explicit Sign Out Action

We resolved dropdown expansion issues on layout pages that load complex components (like Pusher real-time elements, Chart.js, and the currency converter shadow DOM).

### Changes Made
- **[app.blade.php](file:///D:/xampp/htdocs/HMS/resources/views/layouts/app.blade.php)**:
  - Reverted `.dropdown-user` class to `dropdown` for styling mapping consistency.
  - Replaced the dynamic translator variable `{{ __('Logout') }}` with explicit sign-out FontAwesome icon and hardcoded "Logout" label.
  - Injected custom delegated click handlers on `document` targeting dropdown selectors to bypass script bubbles conflict.
  - Relocated and commented out (`{{-- ... --}}`) the Guest Pulse AI link to hide it from the sidebar navigation.

---

## 📄 8. Download Invoice / Receipt PDF Button

We added a prominent action button to download the PDF invoice/receipt directly from the invoice details view.

### Changes Made
- **[invoices/show.blade.php](file:///D:/xampp/htdocs/HMS/resources/views/invoices/show.blade.php)**: Added a dynamic button next to the Invoice header that links to `invoices.download`. If the invoice status is `paid`, the button labels itself **Download Receipt**; otherwise, it displays **Download Invoice**.

---

## 🚫 9. Restricting Record Payment on Cancelled & Refunded Invoices

To ensure accounting safety, we restricted recording new payments on cancelled or refunded invoices.

### Changes Made
- **[invoices/show.blade.php](file:///D:/xampp/htdocs/HMS/resources/views/invoices/show.blade.php)**: Updated the **Record Payment** button display conditional checks to hide the button when the invoice status is either `paid` or `cancelled`.

---

## 🔍 10. Correct Invoice and Event Index Sorting Parameters

We resolved database `Unknown column` QueryExceptions triggered when sorting tables by columns that did not match database fields.

### Changes Made
- **[InvoiceController.php](file:///D:/xampp/htdocs/HMS/app/Http/Controllers/InvoiceController.php)** / **[invoices/index.blade.php](file:///D:/xampp/htdocs/HMS/resources/views/invoices/index.blade.php)**: Corrected whitelist and view templates sorting parameters from `issue_date` and `total` to `invoice_date` and `total_amount`.
- **[EventController.php](file:///D:/xampp/htdocs/HMS/app/Http/Controllers/EventController.php)** / **[events/index.blade.php](file:///D:/xampp/htdocs/HMS/resources/views/events/index.blade.php)**: Corrected sorting whitelists and parameters from `start_date`, `end_date`, and `capacity` to `start_time`, `end_time`, and `max_attendees`.

---

## 🍽️ 11. Remove Category Column from Food Menu

Hided the Category column in the Food Menu list view to simplify visual aesthetics.

### Changes Made
- **[food-items/index.blade.php](file:///D:/xampp/htdocs/HMS/resources/views/food-items/index.blade.php)**: Removed the Category column `<th>` header and the matching `<td>` item category table cells, and updated the empty list colspan helper layout span from `5` to `4`.

---

## 🧾 12. Add Status Column to PDF Invoices / Receipts

Injected payment status information directly into downloaded PDF invoices and receipts to show when a payment is failed or refunded.

### Changes Made
- **[invoices/pdf.blade.php](file:///D:/xampp/htdocs/HMS/resources/views/invoices/pdf.blade.php)**: Added a **Status** column inside the **Payment History** table, rendering colored status badges (`success`, `warning`, `danger`, `info`) and adjusting table spans.

---

## 🛎️ 13. Allow Invoicing Active and Concluded Stays

Fixed an issue where checked-in or checked-out reservations could not be selected when generating new invoices.

### Changes Made
- **[InvoiceController.php](file:///D:/xampp/htdocs/HMS/app/Http/Controllers/InvoiceController.php)**: Expanded the reservations query to include active and concluded guest stays in the selectable dropdown menu:
  ```php
  ->whereIn('status', ['pending', 'confirmed', 'checked_in', 'checked_out'])
  ```

---

## ⏰ 14. Auto-Checkout Concluded Paid Reservations

We updated the automatic check-out engine to checkout stays that ended even if they were not explicitly moved to `checked_in` status.

### Changes Made
- **[AutoCheckOutMiddleware.php](file:///D:/xampp/htdocs/HMS/app/Http/Middleware/AutoCheckOutMiddleware.php)**: Expanded the query check to verify dates and payments for both `checked_in` and `confirmed` reservations:
  ```php
  ->whereIn('status', ['checked_in', 'confirmed'])
  ```
