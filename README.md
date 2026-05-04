# 🏨 Hotel Management System (HMS)

A comprehensive, enterprise-grade Hotel Management System built on **Laravel 12**. This application provides a seamless experience for both hotel guests and internal management, featuring a stunning modern UI and a clean, professionally documented codebase.

---

## 🚀 Key Features

### 🌟 Premium Aesthetics & UX
- **Stunning Landing Page**: A high-end public website with a deep navy and gold aesthetic, featuring glassmorphism, smooth animations, and high-quality hero sections.
- **Modern Dashboard**: A clean, intuitive management portal for staff and administrators with real-time stats and interactive elements.
- **Responsive Design**: Fully optimized for desktops, tablets, and mobile devices.

### 🛎️ Intelligent Reservation System
- **Smart Booking Flow**: A dynamic booking form that automatically checks room availability based on selected dates.
- **Calendar Management**: Interactive calendar for tracking room occupancy and hosted events at a glance.
- **Status Tracking**: Real-time status updates for reservations (Pending, Confirmed, Checked-In, Checked-Out, Cancelled).

### 👤 Advanced Role-Based Management
- **Guest Portal**: A dedicated environment for guests to manage their own bookings, view payment history, and update profiles.
- **Internal Roles**: granular access control for **Admin**, **Manager**, and **Staff** roles.
- **Automated Workflows**: Automatic creation of customer profiles upon guest registration.

### 💳 Financials & Reporting
- **Invoicing & Payments**: Professional invoice generation with support for multiple payment methods (Cash, Card, Bank Transfer).
- **PDF Generation**: Downloadable PDF receipts for payments and formal invoices for billing.
- **Analytics**: Comprehensive reporting module with Excel and PDF exports for revenue analysis and occupancy trends.

### 📺 Real-Time Operations
- **Live Updates**: Dashboard statistics and room statuses update in real-time using Laravel broadcasting events.
- **Notifications & Alerts**: Integrated system notifications and alerts for staff to handle urgent tasks.

### 📱 Offline-Ready Architecture
- **Localized Assets**: All dependencies (Bootstrap, FontAwesome, Google Fonts, DataTables) are hosted locally.
- **Zero Internet Requirement**: Designed to function perfectly in offline environments, making it ideal for on-site demos and local deployments.

---

## 🛠️ Technology Stack

- **Framework:** [Laravel 12](https://laravel.com) (PHP 8.2+)
- **Frontend:** Blade Templating, Vanilla CSS (Premium Design), Bootstrap 5
- **Interactivity:** JavaScript (ES6+), AJAX (jQuery/Axios), FullCalendar
- **Database:** MySQL / PostgreSQL
- **Exports:** DomPDF (PDF), Laravel Excel (XLSX)
- **Broadcasting:** Laravel Reverb / Pusher (Real-time events)

---

## 📖 Code Quality & Documentation

This codebase is built for maintainability and scalability:
- **Clean Code**: Follows PSR-12 coding standards with descriptive naming and modular design.
- **Professional PHPDoc**: Every Model, Controller, and Service is fully documented with PHPDoc blocks for superior IDE support and developer onboarding.
- **Optimized Routes**: Routes are logically organized into Public, Authenticated, and Administrative sections.
- **Robust Validation**: Uses Laravel Form Requests for clean, decoupled validation logic.

---

## ⚙️ Getting Started

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL

### Installation
1. **Clone & Navigate**:
   ```bash
   git clone <repository-url>
   cd HMS
   ```
2. **Install Dependencies**:
   ```bash
   composer install
   npm install && npm run build
   ```
3. **Environment Setup**:
   ```bash
   cp .env.example .env
   # Configure your database in .env
   php artisan key:generate
   ```
4. **Database Initialization**:
   ```bash
   php artisan migrate --seed
   ```
5. **Run the Application**:
   ```bash
   php artisan serve
   ```
   Visit `http://localhost:8000` for the landing page or `http://localhost:8000/login` for the portal.

---

## 📄 License

This project is proprietary software. All rights reserved.