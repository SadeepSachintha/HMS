# 🏨 Hotel Management System (HMS)

A comprehensive, enterprise-grade Hotel Management System built on **Laravel 12**. This application provides a seamless experience for both hotel guests and internal management, featuring a stunning modern UI, premium dark mode aesthetics, and a clean, professionally documented codebase.

---

## 🚀 Key Features

### 🌟 Premium Aesthetics & UX
- **Stunning Landing Page**: A high-end public website with a deep navy and gold aesthetic, featuring glassmorphism, smooth animations, and high-quality hero sections.
- **Standardized Dark Theme**: A unified, high-contrast dark dashboard for administration and staff, ensuring maximum readability and a premium "luxury" feel.
- **Modern Dashboard**: A clean, intuitive management portal for staff and administrators with real-time stats and interactive elements.
- **Responsive Design**: Fully optimized for desktops, tablets, and mobile devices.

### 🛎️ Intelligent Reservation System
- **Smart Booking Flow**: A dynamic booking form that automatically checks room availability based on selected dates.
- **Calendar Management**: Interactive calendar for tracking room occupancy and hosted events at a glance.
- **Case-Insensitive Statuses**: Robust status handling (Pending, Confirmed, Checked-In, etc.) ensures colored badges display correctly regardless of data input format.

### 👤 Advanced Role-Based Management
- **Guest Portal**: A dedicated environment for guests to manage their own bookings, view payment history, and update profiles.
- **Internal Roles**: Granular access control for **Admin**, **Manager**, and **Staff** roles using Spatie Laravel-Permission.
- **Automated Workflows**: Automatic creation of customer profiles upon guest registration and seamless linking of user accounts to customer records.

### 💳 Financials & Reporting
- **Invoicing & Payments**: Professional invoice generation with support for multiple payment methods (Cash, Card, Bank Transfer).
- **PDF Generation**: Downloadable PDF receipts for payments and formal invoices for billing using DomPDF.
- **Analytics**: Comprehensive reporting module with Excel and PDF exports for revenue analysis and occupancy trends.

### 📺 Real-Time Operations
- **Live Updates**: Dashboard statistics and room statuses update in real-time using Laravel broadcasting and Pusher/Reverb events.
- **Notifications & Alerts**: Integrated system notifications for urgent tasks like maintenance requests or new bookings.

### 📱 Offline-Ready Architecture
- **Localized Assets**: All dependencies (Bootstrap 5, FontAwesome 6, Google Fonts, DataTables) are hosted locally within the `public/` directory.
- **Zero Internet Requirement**: Designed to function perfectly in air-gapped or offline environments, making it ideal for on-site deployments and stable local demos.

---

## 🛠️ Technology Stack

- **Framework:** [Laravel 12](https://laravel.com) (PHP 8.2+)
- **Frontend:** Blade Templating, Vanilla CSS (Premium Design System), Bootstrap 5
- **Interactivity:** JavaScript (ES6+), AJAX (Axios/jQuery), FullCalendar 6
- **Database:** MySQL 8.0+ / PostgreSQL
- **Asset Management**: Localized CSS/JS (No CDNs)
- **Exports:** DomPDF (PDF), Laravel Excel (XLSX)
- **Broadcasting:** Laravel Reverb / Pusher (Real-time events)

---

## 📖 Code Quality & Documentation

This codebase is built for maintainability and scalability:
- **Clean Code**: Follows PSR-12 coding standards with descriptive naming and modular design.
- **Professional PHPDoc**: Every Model, Controller, and Service is fully documented with PHPDoc blocks for superior IDE support and developer onboarding.
- **Strict Typing**: Utilizes PHP 8.2 type hinting to ensure code reliability and reduce runtime errors.
- **Optimized Routes**: Routes are logically organized into Public, Authenticated, and Administrative sections.

---

## ⚙️ Getting Started

### Prerequisites
- PHP 8.2 or higher
- Composer 2.0+
- Node.js 18+ & NPM
- MySQL 8.0 or MariaDB

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
   # Configure your database and app settings in .env
   php artisan key:generate
   ```

5. **Database Initialization**:
   ```bash
   php artisan migrate --seed
   ```

6. **Run the Application**:
   ```bash
   php artisan serve
   ```
   Visit `http://localhost:8000` for the landing page or `http://localhost:8000/login` for the portal.

---

## 📄 License

This project is proprietary software. All rights reserved.