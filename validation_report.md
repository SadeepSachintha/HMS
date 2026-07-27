# HMS System Validations Audit Report

This report documents the status and configuration of all input, model, and business logic validations within the Hotel Management System.

---

## 🪪 1. Customer Identification & Details

| Attribute | Validation Rule | Backend Implementation | Frontend UI Behavior | Status |
| :--- | :--- | :--- | :--- | :--- |
| **Name** | Required, String, Max 255 chars | `StoreCustomerRequest` / `UpdateCustomerRequest` | HTML5 `required` attribute. | 🟢 Active |
| **Email** | Nullable, Email format, Unique database constraint | `unique:customers,email` (ignoring current ID on updates) | Validates email syntax. | 🟢 Active |
| **Phone** | Required, International phone format with country code | Regex `regex:/^\+(?:[0-9] ?){6,14}[0-9]$/` | Custom JavaScript forces `+` prefix and strips invalid characters. | 🟢 Active |
| **NIC / Passport** | Nullable, String, Max 50 chars | `nullable|string|max:50` | Text input, optional, displays in details view. | 🟢 Active |

---

## 🛎️ 2. Reservations & Occupancy Controls

| Attribute | Validation Rule | Backend Implementation | Frontend UI Behavior | Status |
| :--- | :--- | :--- | :--- | :--- |
| **Customer ID** | Required, must exist in database | `exists:customers,id` | Dropdown select. | 🟢 Active |
| **Room ID** | Required, must exist in database | `exists:rooms,id` | Dynamic AJAX-populated select based on availability dates. | 🟢 Active |
| **Dates** | Check-out must occur after Check-in; duration max 14 days | `after:check_in_date`, custom diff check | Custom JS auto-sets minimum checkout dates. | 🟢 Active |
| **Guest Occupancy** | Enforces room-specific limits: Single (1), Double (2), Deluxe Family (4) | Custom validator closure in `Store/UpdateReservationRequest` querying DB RoomType | JS dynamically caps input `max` and updates value on room selection. | 🟢 Active |

---

## 💳 3. Financial Trail Integrity (Immutability)

| Component | Validation Rule | Backend Implementation | UI Representation | Status |
| :--- | :--- | :--- | :--- | :--- |
| **Invoices** | Fully immutable once generated | Edits blocked on controller level with `abort(403)` | All edit links, routes, and buttons are hidden. | 🟢 Active |
| **Payments** | Fully immutable once logged | Edits blocked on controller level with `abort(403)` | All edit links, routes, and buttons are hidden. | 🟢 Active |

---

## 💵 4. Offline Currency API Request constraints

| Parameter | Validation Rule | Backend Implementation | UI Representation | Status |
| :--- | :--- | :--- | :--- | :--- |
| **Base Currency** | Required, 3 characters | `base => 'required|string|size:3'` | Dropdown select menu | 🟢 Active |
| **Target Currency** | Required, 3 characters | `target => 'required|string|size:3'` | Dropdown select menu | 🟢 Active |
| **Amount** | Required, numeric, non-negative | `amount => 'required|numeric|min:0'` | Dynamic float validation | 🟢 Active |
| **Currency Support**| Matches whitelisted offline currencies | `array_key_exists` check; returns `400 Bad Request` | Dropdown constraints | 🟢 Active |

---

## 🔬 Automated Testing Summary

All validation rules are covered by automated unit/feature tests:
* **`CustomerTest`**: Validates creation, updates, max character length restrictions, and query searching.
* **`ReservationGuestValidationTest`**: Verifies Single (1), Double (2), and Deluxe Family (4) capacity check failures.
* **`ImmutableInvoicePaymentTest`**: Validates that edit/update requests to Invoices/Payments trigger a `403 Forbidden` response.
* **`CurrencyApiTest`**: Validates correct parameters, input restrictions, and error formats.

**Test Execution Results:**
- **Total Tests Run**: 44
- **Passed**: 44
- **Failed**: 0
- **Time**: 3.21 seconds
