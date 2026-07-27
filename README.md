# 🏨 Hotel Management System (HMS)



A comprehensive, enterprise-grade Hotel Management System built on **Laravel 8**. Designed for both hotel guests and internal management, the system features a premium dark-mode UI with deep navy & gold aesthetics, a rich feature set, and a fully offline-capable architecture.



---



## 🚀 Key Features



### 🌟 Premium Aesthetics & UX

- **Unified Premium Header System** — All administrative modules feature a standardized top-aligned header with gold titles, integrated search, and primary action buttons for a cohesive, high-end feel.

- **Gold Design Language** — Consistent use of the `#D4AF37` gold secondary color for typography, icons, and primary UI elements to reinforce the luxury brand identity.

- **Stunning Landing Page** — High-end public website with glassmorphism, smooth animations, and hero sections using the deep navy & gold design language.

- **Unified Dark Theme** — All admin/staff dashboards use a consistent, high-contrast dark theme for maximum readability and a luxury feel.

- **Scoped Module Stylesheets** — Per-module CSS files (e.g., `events.css`) allow targeted visual customizations without polluting the global design system.

- **Standardized Data Interaction** — Globally standardized table layouts and row interactions with high-contrast, dark-theme compatible hover highlights.

- **Responsive Design** — Fully optimized for desktops, tablets, and mobile devices.



### 🛎️ Front Office & Reservations

- **Smart Booking Flow** — Dynamic form checks real-time room availability based on selected check-in and check-out dates via AJAX.

- **Guest Portal** — Registered guests can view and manage their own reservations and invoice history.

- **Status Management** — Robust status handling (Pending → Confirmed → Checked-In → Checked-Out → Cancelled) with colored badge indicators.

- **Reservation ID Tracking** — Every booking is assigned a unique tracking ID (e.g., `#RES-00042`) for precise operational management.

- **Automated Customer Profiles** — A customer record is automatically created and linked to a user account upon guest registration via email.
- **Room Status Auto-Sync** — Automatically synchronizes the physical/housekeeping status of a room based on reservation status (updates room to `occupied` when reservation is `checked_in`, and back to `available` when `checked_out`).
- **Time-Sensitive Paid Auto-Checkout** — Runs background checks via a custom middleware. On the scheduled check-out date, once the hotel's checkout time (default: 12:00 PM) has passed, any checked-in reservation with a fully paid invoice is automatically checked out, releasing the room as available.
- **Strict Guest Count Validation** — Enforces strict occupancy limits per room type both client-side and server-side: Single Room is capped at 1 guest, Double Room at 2 guests, and Deluxe Family Room at 4 guests.
- **Guest Identity Tracking** — Supports collecting, viewing, and searching by an official National Identity Card (NIC) or Passport number.
- **Guest Self-Registration Form** — Automatically collects contact numbers and NIC/Passport numbers during sign-up, instantly creating customer profile links.



### 🎭 Event & Facility Management

- **Event Scheduling** — Full CRUD for hotel-hosted events: name, description, start/end times, pricing, attendee limits, and status.

- **Location Management** — Dedicated `EventLocation` entity for managing hotel facilities (Conference Room, Training Room, Rooftop Lounge, etc.) with bidirectional linking to events.

- **Venue Image Uploads** — Administrative support for uploading, updating, and deleting location banner/room layouts.

- **Public Venues Showcase** — Dedicated public `/our-events` (Venues) route displays active event locations with high-quality layouts, description texts, and guest capacities.

- **Staff Assignment** — Assign internal staff members to events with custom role descriptions.

- **Event Detail View** — Scoped dark-theme table layout preserving rich-text formatting (newlines, spaces) in descriptions and notes.



### 👤 Role-Based Access Control (RBAC) & Safety

| Role | Access |

|---|---|

| **Admin** | Full system access — all modules, reports, user management, and system logs |

| **Manager** | Operational management — all operations, reports, creation/modification of core hotel setup |

| **Staff** | Daily operations — views lists/records, creates reservations, customers, invoices, and payments |

| **Guest** | Self-service — My Reservations, My Invoices only |



- **Custom Role Middleware** — Secures route endpoints based on custom middleware verification.

- **Safety Actions (Disabled Deletions)** — Resource deletion is completely disabled system-wide (on route definition, controller aborts, and layout UI actions) for all core models (users, reservations, customers, rooms, room types, food, locations, events, invoices, and payments) to prevent accidental data loss.

- **Creation & Modification Restrictions**:

  - Only **Admin** and **Manager** roles can create new items for Rooms, Room Types, Food Menus, Events, and Event Locations.

  - Only **Admin** and **Manager** roles can edit/modify Reservations and Customers.

  - **Financial Immutability**: Modifying or editing generated Invoices or recorded Payments is disabled system-wide for all roles to preserve accounting integrity.
  - **Staff NIC Field**: Ensures every internal employee's profile is recorded with their unique NIC (with validation checks for Sri Lankan format standards).



### 📜 System Activity Logging

- **Trait-based Model Auditing** — Core models utilize a shared `LogsActivity` trait to automatically hook Eloquent actions (`created`, `updated`, `deleted`) and log them (including a listing of specifically modified field names).

- **Authentication Logging** — Automatic tracking of successful logins, logouts, and failed login attempts.

- **Protected Admin Logs Dashboard** — A secure dashboard restricted exclusively to the **Admin** role supporting full-text search, action-type dropdown filtering, and date filtering. Includes IP address and browser User-Agent auditing.
- **Excel Export** — Allows administrators to export the filtered set of activity log search results directly to `.xlsx` Excel spreadsheets for local archiving and offline auditing.



### 💳 Billing & Financials

- **Automated Invoicing** — Invoices are auto-generated via a Laravel Observer when a reservation is confirmed; zero manual billing overhead.

- **Customizable Taxes & Levies** — Dynamic, customizable tax percentages (Service Charge, SSCL, TDL, VAT) configurable via the Admin Settings screen. The system calculates client-side breakdowns during creation and stores detailed itemized amounts on save.

- **Reservation Item Preservation** — The primary event/reservation charge details are automatically created and saved as a distinct invoice item on invoice generation.

- **Full Payment Policy** — Enforces full invoice settlement in a single transaction (no partial payments).

- **Payment Methods** — Cash, Card, and Bank Transfer supported with manual payment recording.

- **Invoice Status Sync** — Invoice status automatically updates to *Paid* when payment is recorded.

- **Automated Status Synchronization** — Recording a payment as completed triggers an automatic transition of the linked invoice to `paid` and the associated reservation to `confirmed`.

- **Quick Payment Workflow** — Integrated "Record Payment" actions directly within the reservation list for instant invoice settlement.

- **PDF Receipts** — Instant generation via DomPDF.

- **Excel Reports** — Export data to `.xlsx` via Laravel Excel.



### 📊 Reporting & Analytics

- **Occupancy Reports** — Track room utilization over custom date ranges.

- **Revenue Reports** — Detailed revenue breakdown by date range.

- **Reservation Reports** — Booking trends and volume insights.

- **Glassmorphism Report UI** — Interactive report selector with real-time loading feedback.

- **Chart.js Visualizations** — Revenue and occupancy trend charts embedded directly in the dashboard.



### 🔔 Alerts & Notifications

- **In-App Alerts** — Bell icon in the navbar with a live unread count badge.

- **Session Timeout Warning** — Inactivity modal warns 1 minute before automatic logout (14-minute idle threshold).

- **Auto-Dismissing Flash Messages** — Success, error, warning, and info banners auto-dismiss after 3 seconds.



### 📱 Offline-Ready Architecture

- **Zero CDN Dependencies** — All assets (Bootstrap 5, Chart.js, FontAwesome 6, Google Fonts, DataTables, SweetAlert2) are locally hosted in `public/`.

- **Air-Gap Friendly** — Fully functional in offline environments, ideal for on-site hotel deployments and demos.



### 📝 Code Quality & Documentation

- **Strict PHPDoc Standard** — All controllers, models, observers, middlewares, and services follow standardized PHPDoc blocks with parameter type annotations, return types, and class summaries.

- **Robust Model Autocomplete** — Models include detailed property declarations (`@property`) for enhanced IDE integration and static analysis.

- **Detailed Inline Logic Comments** — Complex database workflows (like constraints in event locations or status hooks in payment observers) are thoroughly documented inline.



---



## 🗄️ Database Schema



| Table | Description |

|---|---|

| `users` | Authentication, roles (admin/manager/staff/guest), and status |

| `customers` | Guest profiles linked to users by email |

| `room_types` | Room categories with pricing and amenity details |

| `room_type_images` | Gallery images per room type |

| `rooms` | Individual room inventory with status tracking |

| `reservations` | Bookings linking customers and rooms with date ranges |

| `events` | Hotel-hosted events with pricing and attendee caps |

| `event_locations` | Named hotel facilities/venues |

| `event_staff` | Pivot table linking staff to events with custom roles |

| `food_items` | Hotel restaurant/room-service menu items |

| `invoices` | Invoices containing calculated detailed tax amount breakdowns and status tracking |

| `invoice_items` | Line items composing each invoice |

| `payments` | Payment records against invoices |

| `staff` | Internal staff profiles linked to user accounts |

| `alerts` | System alert records for the notification panel |

| `system_notifications` | Broadcast notification log |

| `settings` | Global hotel details, times, notification switches, and customizable tax rates |

| `sessions` | Database-backed session management |

| `activity_logs` | System activity logs documenting timestamp, action, model ID, description, IP, and browser meta |



---



## 🛠️ Technology Stack



| Layer | Technology |

|---|---|

| **Framework** | Laravel 8 (PHP 7.3+) |

| **Templating** | Blade |

| **Styling** | Vanilla CSS Design System (admin.css + module-scoped CSS), Bootstrap 5 |

| **Visualizations** | Chart.js 4.4+ |

| **Interactivity** | JavaScript (ES6+), jQuery, AJAX |

| **Calendar** | FullCalendar 6 |

| **Database** | MySQL 8.0+ / MariaDB |

| **Auth & Roles** | Laravel UI (Bootstrap) + Custom Role Middleware |

| **PDF Export** | DomPDF (barryvdh/laravel-dompdf) |

| **Excel Export** | Laravel Excel (maatwebsite/excel) |

| **Asset Strategy** | Fully localized — no CDN dependencies |

| **Testing Framework** | PHPUnit (Laravel Feature Tests) |



---



## 📁 Project Structure (Key Directories)



```

HMS/

├── app/

│   ├── Http/Controllers/       # 20 controllers (including ActivityLogController)

│   ├── Models/                 # 17 Eloquent models (including ActivityLog)

│   ├── Observers/              # Invoice auto-generation observer

│   └── Traits/                 # Helper traits (including LogsActivity)

├── database/

│   ├── migrations/             # 29 migration files

│   └── seeders/                # Role, permission, and demo data seeders

├── public/

│   └── css/

│       ├── admin.css           # Global dark theme design system

│       ├── style.css           # Base layout and structural styles

│       ├── events.css          # Scoped styles for the Events module

│       └── website.css         # Public landing page styles

├── resources/views/

│   ├── layouts/app.blade.php   # Main authenticated layout

│   ├── activity-logs/          # Logs dashboard view

│   ├── events/                 # Event CRUD views

│   ├── reservations/           # Reservation CRUD views

│   └── ...                     # All other views

└── routes/web.php              # All application routes

```



---



## ⚙️ Getting Started



### Prerequisites

- PHP 8.2 or higher

- Composer 2.0+

- Node.js 18+ & NPM

- MySQL 8.0+ or MariaDB



### Installation



1. **Clone & Navigate**:

   ```bash

   git clone https://github.com/SadeepSachintha/HMS.git

   cd HMS

   ```



2. **Install PHP Dependencies**:

   ```bash

   composer install

   ```



3. **Install Frontend Dependencies**:

   ```bash

   npm install

   npm run build

   ```



4. **Environment Setup**:

   ```bash

   cp .env.example .env

   # Configure your database credentials in .env

   php artisan key:generate

   ```



5. **Database Initialization**:

   ```bash

   php artisan migrate --seed

   ```



6. **Storage Link** (for room type images):

   ```bash

   php artisan storage:link

   ```



7. **Run the Application**:

   ```bash

   php artisan serve

   ```



   - **Landing Page:** `http://localhost:8000`

   - **Admin Portal:** `http://localhost:8000/login`



### XAMPP (Local Dev)

   If using XAMPP, place the project in `htdocs/HMS` and access via:

   - `http://localhost/HMS/public`



---



## 🔑 Default Credentials (after seeding)



| Role | Email | Password |

|---|---|---|

| Admin | admin@hms.com | password |

| Manager | manager@hms.com | password |

| Staff | staff@hms.com | password |



---



## 🧪 Automated Testing



The system includes a comprehensive automated test suite built with **Laravel Feature Tests** to ensure security and stability.



### Key Test Coverage

- **Role-Based Access Control (RBAC)**: Verifies that Admin, Manager, Staff, and Guest roles can only access their authorized components.

- **Component Integrity**: Ensures that core modules (Reservations, Rooms, Events, Users, etc.) load correctly for authorized users.

- **Safety Actions (Disabled Deletions)**: Assures database deletion calls are rejected.

- **Activity Logging Audits**: Asserts creation, modification, and logins write to log records.

- **Route Precedence Verification**: Protects against routing conflicts.



### Running Tests

To run the full test suite, use the standard Artisan command:

```bash

php artisan test

```



For more focused testing:

```bash

# Run only Activity Logging tests

php artisan test tests/Feature/ActivityLogTest.php



# Run only Role-Based Access tests

php artisan test tests/Feature/RoleAccessTest.php



# Run only Staff Management tests

php artisan test tests/Feature/StaffManagementTest.php

```



The testing environment is pre-configured to use an **in-memory SQLite database**, ensuring tests run fast and do not affect your production or development data.



---



## 📄 License



This project is proprietary software. All rights reserved.