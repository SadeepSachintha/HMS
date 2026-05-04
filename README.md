# Hotel Management System (HMS)

A comprehensive, full-featured Hotel Management System built on Laravel 12. This application handles everything from public room browsing to internal management of reservations, staff, billing, and reporting.

## Key Features

### 🌟 Premium Public Landing Page
- A visually stunning, modern landing page with a deep navy and gold aesthetic.
- Glassmorphism UI elements, smooth animations, and high-quality hero sections.
- Dynamically displays featured rooms, pricing, and amenities directly from the database.
- Seamless booking flow directing guests to the authentication/dashboard portal.

### 🛎️ Dashboard & Reservations
- Interactive dashboard providing a snapshot of daily operations, occupancy stats, and revenue.
- Comprehensive reservation management (create, update, cancel, and view details).
- Calendar view for tracking upcoming bookings and events.

### 🏨 Guest Portal & Smart Booking
- Dedicated "My Reservations" portal for registered guests.
- Automated Customer profile linkage upon registration.
- Smart booking form with dynamic room availability based on selected check-in and check-out dates.
- Strict data isolation ensuring guests can only access their own reservations and payment history.

### 🛏️ Room & Inventory Management
- Manage Room Types (pricing, descriptions, capacities, and amenities).
- Track individual room statuses (available, booked, maintenance).
- Upload and manage room type image galleries.

### 👥 Customer & Staff Management
- Full CRUD capabilities for customer profiles.
- Role-based access control (Admin, Manager, Staff) for internal personnel.
- Track staff assignments, especially for hosted events.

### 🍽️ Services & Events
- Food Menu management for in-house dining or room service.
- Event tracking and management for banquets, meetings, and conferences, including staff assignment.

### 💳 Billing & Reports
- Generate invoices and process payments.
- Downloadable PDF receipts and invoices.
- Comprehensive reporting (PDF and Excel exports) for revenue, occupancy, and general analytics.

### 📱 Offline-Ready for Demos
- **Localized Assets**: All CSS, JS, and Font files (Bootstrap, FontAwesome, Google Fonts) are hosted locally within the project.
- **No Internet Required**: Perfect for offline demo sessions, ensuring the premium UI and functionality remain intact without external connectivity.

## Technology Stack

- **Backend:** Laravel 12 (PHP 8.2+)
- **Frontend:** Blade Templating, Bootstrap 5, Vanilla CSS (Premium Custom Design)
- **Database:** MySQL
- **Icons & Fonts:** FontAwesome 6 (Local), Google Fonts (Local: Playfair Display & Inter)

## Getting Started

1. Clone the repository and navigate into the directory.
2. Install dependencies:
   ```bash
   composer install
   npm install && npm run build
   ```
3. Copy `.env.example` to `.env` and configure your database settings.
4. Generate the application key:
   ```bash
   php artisan key:generate
   ```
5. Run migrations and seeders (if available):
   ```bash
   php artisan migrate --seed
   ```
6. Start the local development server:
   ```bash
   php artisan serve
   ```
7. Visit `http://localhost:8000` to view the premium landing page, or `http://localhost:8000/login` to access the management portal.

## License

This project is proprietary software. All rights reserved.