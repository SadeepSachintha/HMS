# 🏨 Hotel Management System (HMS)

A comprehensive, enterprise-grade Hotel Management System built on **Laravel 12**. Designed for both hotel guests and internal management, the system features a premium dark-mode UI with deep navy & gold aesthetics, a rich feature set, and a fully offline-capable architecture.

---

## 🚀 Key Features

### 🌟 Premium Aesthetics & UX
- **Stunning Landing Page** — High-end public website with glassmorphism, smooth animations, and hero sections using the deep navy & gold design language.
- **Unified Dark Theme** — All admin/staff dashboards use a consistent, high-contrast dark theme for maximum readability and a luxury feel.
- **Scoped Module Stylesheets** — Per-module CSS files (e.g., `events.css`) allow targeted visual customizations without polluting the global design system.
- **Collapsible Sidebar Navigation** — Grouped into logical categories: *Front Office*, *Room Management*, *Services*, *Billing*, and *Administration*.
- **Premium Analytics Dashboard** — Glassmorphism cards, real-time stat widgets, and interactive Chart.js visualizations for revenue, occupancy, and reservations.
- **Responsive Design** — Fully optimized for desktops, tablets, and mobile devices.

### 🛎️ Front Office & Reservations
- **Smart Booking Flow** — Dynamic form checks real-time room availability based on selected check-in and check-out dates via AJAX.
- **Guest Portal** — Registered guests can view and manage their own reservations and invoice history.
- **Status Management** — Robust status handling (Pending → Confirmed → Checked-In → Checked-Out → Cancelled) with colored badge indicators.
- **Automated Customer Profiles** — A customer record is automatically created and linked to a user account upon guest registration via email.

### 🎭 Event & Facility Management
- **Event Scheduling** — Full CRUD for hotel-hosted events: name, description, start/end times, pricing, attendee limits, and status.
- **Location Management** — Dedicated `EventLocation` entity for managing hotel facilities (Conference Halls, Training Rooms, Lounges, etc.) with bidirectional linking to events.
- **Staff Assignment** — Assign internal staff members to events with custom role descriptions.
- **Event Detail View** — Scoped dark-theme table layout preserving rich-text formatting (newlines, spaces) in descriptions and notes.

### 👤 Role-Based Access Control
| Role | Access |
|---|---|
| **Admin** | Full system access — all modules, reports, user management |
| **Manager** | All operational modules and reports |
| **Staff** | Reservations, customers, rooms, events, food, billing |
| **Guest** | My Reservations, My Invoices only |

- Powered by **Spatie Laravel-Permission**.
- Middleware-protected routes per role group.

### 💳 Billing & Financials
- **Automated Invoicing** — Invoices are auto-generated via a Laravel Observer when a reservation is confirmed; zero manual billing overhead.
- **Full Payment Policy** — Enforces full invoice settlement in a single transaction (no partial payments).
- **Payment Methods** — Cash, Card, Bank Transfer, and Cheque supported with manual payment recording.
- **Invoice Status Sync** — Invoice status automatically updates to *Paid* when payment is recorded.
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
| `invoices` | Auto-generated invoices per confirmed reservation |
| `invoice_items` | Line items composing each invoice |
| `payments` | Payment records against invoices |
| `staff` | Internal staff profiles linked to user accounts |
| `alerts` | System alert records for the notification panel |
| `system_notifications` | Broadcast notification log |
| `settings` | Application configuration key-value store |
| `sessions` | Database-backed session management |

---

## 🛠️ Technology Stack

| Layer | Technology |
|---|---|
| **Framework** | Laravel 12 (PHP 8.2+) |
| **Templating** | Blade |
| **Styling** | Vanilla CSS Design System (admin.css + module-scoped CSS), Bootstrap 5 |
| **Visualizations** | Chart.js 4.4+ |
| **Interactivity** | JavaScript (ES6+), jQuery, AJAX |
| **Calendar** | FullCalendar 6 |
| **Database** | MySQL 8.0+ / MariaDB |
| **Auth & Roles** | Laravel Breeze + Spatie Laravel-Permission |
| **PDF Export** | DomPDF (barryvdh/laravel-dompdf) |
| **Excel Export** | Laravel Excel (maatwebsite/excel) |
| **Asset Strategy** | Fully localized — no CDN dependencies |
| **Testing Framework** | PHPUnit (Laravel Feature Tests) |

---

## 📁 Project Structure (Key Directories)

```
HMS/
├── app/
│   ├── Http/Controllers/       # 19 resource controllers
│   ├── Models/                 # 16 Eloquent models
│   └── Observers/              # Invoice auto-generation observer
├── database/
│   ├── migrations/             # 25 migration files
│   └── seeders/                # Role, permission, and demo data seeders
├── public/
│   └── css/
│       ├── admin.css           # Global dark theme design system
│       ├── style.css           # Base layout and structural styles
│       ├── events.css          # Scoped styles for the Events module
│       └── website.css         # Public landing page styles
├── resources/views/
│   ├── layouts/app.blade.php   # Main authenticated layout
│   ├── events/                 # Event CRUD views
│   ├── reservations/           # Reservation CRUD views
│   └── ...                     # All other module views
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
   git clone <repository-url>
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
- **Route Precedence Verification**: Protects against routing conflicts (e.g., ensuring resource creation routes are not intercepted by wildcards).

### Running Tests
To run the full test suite, use the standard Artisan command:
```bash
php artisan test
```

For more focused testing:
```bash
# Run only Role-Based Access tests
php artisan test tests/Feature/RoleAccessTest.php

# Run only Staff Management tests
php artisan test tests/Feature/StaffManagementTest.php
```

The testing environment is pre-configured to use an **in-memory SQLite database**, ensuring tests run fast and do not affect your production or development data.

---

## 📄 License

This project is proprietary software. All rights reserved.