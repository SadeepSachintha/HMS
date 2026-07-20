# Project Handover & Product Deployment Plan: Hotel Management System (HMS)

This document outlines the system configuration, deployment procedures, recent features, and maintenance guidelines required for the production handover and product deployment of the **Hotel Management System (HMS)**.

---

## 1. System Overview & Architecture

The HMS application is a custom hotel and booking management portal designed to handle hotel room reservations, invoicing, services, and staff management.

* **Backend Framework:** Laravel 8.x (PHP 7.3+)
* **Frontend UI:** Blade templates, Vanilla CSS, and custom Bootstrap styling.
* **Database Engine:** MariaDB/MySQL (InnoDB Storage Engine).
* **Local Stack (Development/Staging):** XAMPP v3.3.0 (Apache, MySQL/MariaDB).

---

## 2. Infrastructure & Environment Configuration

### Server Prerequisites
To deploy the application to a production environment, ensure the target server matches the following specification:
* **Operating System:** Linux (Ubuntu 20.04/22.04 LTS recommended) or Windows Server running IIS/XAMPP.
* **Web Server:** Apache or Nginx.
* **PHP Version:** PHP 8.1 or higher (with `mysqli`, `pdo_mysql`, `openssl`, `mbstring`, `xml`, `zip`, and `gd` extensions enabled).
* **Database:** MariaDB (10.4+) or MySQL (8.0+).

### Key Files & Locations
* **Active Workspace:** `d:\xampp\htdocs\HMS`
* **Laravel Config:** `d:\xampp\htdocs\HMS\.env`
* **Database Backups:** `d:\xampp\htdocs\HMS\database\backup`
* **Global Custom CSS:** [admin.css](file:///d:/xampp/htdocs/HMS/public/css/admin.css)
* **Local MySQL Config:** [my.ini](file:///d:/xampp/mysql/bin/my.ini)

---

## 3. Detailed Seeding & Custom Features (Handover Details)

This section summarizes the custom components and business logic systems implemented in the codebase:

### 🌟 Event Locations & Venues Showcase
* **Database column:** Added `image_path` (nullable string) to `event_locations` database table.
* **Controller Upload Logic:** `EventLocationController` validates uploads up to 2MB (supported formats: JPEG, PNG, JPG, GIF, WEBP) and stores them in public directory storage. When a location is edited or deleted, the controller automatically deletes the old image file from the disk to avoid storage leaks.
* **Public Tour Page (`/our-events`):** Accessible via the **Venues** header link. Displays active event venues (Training Room, Rooftop Lounge, Conference Room) with their description, guest capacity, and custom layout image in a responsive card grid.
* **Stock Images Seeding:** Seeded database records and public storage files:
  * **Training Room:** Unsplash Photo ID `1524178232363-1fb2b075b655` (Corporate classroom/seminar layout).
  * **Rooftop Lounge:** Unsplash Photo ID `1560624052-449f5ddf0c31` (Sunset sky bar & pool patio layout).
  * **Conference Room:** Unsplash Photo ID `1431540015161-0bf868a2d407` (Modern corporate boardroom table layout).

### 💳 Booking & Billing Synchronizer
* **Reservation Item Preservation**: When an invoice is created, the primary event/reservation charge details are automatically saved as a separate line item inside the `invoice_items` table.
* **Payment Auto-Sync (Observer)**: The system implements `PaymentObserver` to listen to payment completed status. Completing a cash or card payment automatically:
  1. Sets the linked Invoice status to **`Paid`**.
  2. Sets the associated Reservation status to **`Confirmed`** instantly.
* **Database Bug Fixes**: Removed the redundant and non-existent `paid_amount` column from the payment index layout to prevent database exceptions and whitelisted sort inputs.
* **Removed Cheque Payment Option**: Fully removed the cheque payment method from all UI dropdowns and controller validations system-wide.

### 🚫 Safety Safeguards (Disabled Deletions)
* **Accidental Data Loss Prevention**: Database record deletions have been completely disabled system-wide.
* **Backend Security**: All controller `destroy()` methods return `403 Forbidden` if invoked.
* **Route Protection**: The `destroy` action endpoints are excluded from Laravel's resource route registration.
* **UI Updates**: All delete buttons and forms have been removed from the user interface templates.

### 👤 Role-Based Action Restrictions
* **Admin & Manager Exclusive Creations**: Room, Room Type, Food menu, Event, and Event Location creations are restricted exclusively to the `admin` and `manager` roles. The "Add New" buttons are hidden from `staff` members.
* **Stricter Edit Privileges**: Edits and updates to core reservations, customer records, invoice items, and payment details are restricted to `admin` and `manager` roles.
* **Staff Reports Restriction**: The reports dashboard and sidebar navigation have been completely hidden from the `staff` role. The backend `/reports` routes are restricted strictly to `admin` and `manager` using custom middleware, returning `403 Forbidden` if accessed by staff.

### 🔄 Check-In & Time-Sensitive Auto-Checkout Sync
* **Room Status Auto-Sync**: When a reservation status changes to `checked_in`, the associated room is automatically updated to `occupied`. When changed to `checked_out`, it is reset back to `available`.
* **Time-Sensitive Paid Auto-Checkout**: The custom `AutoCheckOutMiddleware` (integrated in the `web` stack) automatically transitions `checked_in` reservations with a fully paid invoice to `checked_out` on their checkout date, provided the current system time is past the hotel's `check_out_time` (fallback default: `12:00:00`).
* **Strict Guest Count Validation**: Enforces strict occupancy limits per room type both client-side (via dynamic Javascript `max` adjustments in Create/Edit views) and server-side (via custom rules in `StoreReservationRequest` and `UpdateReservationRequest`): Single Room is capped at 1 guest, Double Room at 2 guests, and Deluxe Family Room at 4 guests.

### 📜 System Activity Logging
* **Auditing Database**: Created `activity_logs` table storing timestamp, acting user details, action types (created, updated, deleted, login, logout, failed_login), association target models, description texts, IP addresses, and user agents.
* **Model Observers (`LogsActivity` trait)**: Automatically boots and logs creations, deletions, and updates (specifying modified columns) on all primary models without controller overhead.
* **Authentication Audits**: Listeners log login/logout actions and capture failed login emails.
* **Admin Logs Dashboard**: Provides a searchable/filterable list view of all system activities, restricted strictly to the `admin` role.

---

## 4. Product Deployment Plan

Follow this checklist when deploying the application to your production server:

### Step 1: File Transfer & Permissions
1. Copy the contents of the `HMS` folder to the target server's web root (e.g., `/var/www/html/HMS`).
2. Set ownership permissions so that the webserver user (e.g., `www-data` on Linux) has read and write access:
   ```bash
   sudo chown -R www-data:www-data /var/www/html/HMS
   sudo chmod -R 775 /var/www/html/HMS/storage
   sudo chmod -R 775 /var/www/html/HMS/bootstrap/cache
   ```

### Step 2: Environment Setup
1. Duplicate the `.env.example` file to create a production `.env` file:
   ```bash
   cp .env.example .env
   ```
2. Configure your production database credentials:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://yourdomain.com

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=hms
   DB_USERNAME=production_user
   DB_PASSWORD=production_secure_password
   ```
3. Generate the application encryption key:
   ```bash
   php artisan key:generate
   ```

### Step 3: Database Migration & Seeding
On a fresh installation, run the migrations to create the table structure (including `activity_logs`):
```bash
php artisan migrate --force
```
If you wish to seed the initial roles and administrative credentials, run:
```bash
php artisan db:seed --force
```

### Step 4: Storage Link (Crucial for Venue/Room/Gallery Images)
Create the symbolic link from `public/storage` to `storage/app/public` so uploaded venue and room images are accessible by web browsers:
```bash
php artisan storage:link
```

### Step 5: Optimization & Caching
Prior to launch, clear and rebuild Laravel configurations and route caches for maximum performance:
```bash
php artisan config:cache
```
```bash
php artisan route:cache
```
```bash
php artisan view:cache
```

### Step 6: Verify Deployment Integrity
Execute the automated test suite on the production staging directory to verify compilation and RBAC access parameters:
```bash
php artisan test
```

---

## 5. Maintenance & Disaster Recovery

### Standard Backup Procedure (Cron / Task Scheduler)
Set up a daily automated backup of the MySQL database.
* **Linux Script (`backup.sh`):**
  ```bash
  mysqldump -u production_user -p'password' hms > /backups/hms_$(date +%F).sql
  ```
* **Restore Command:**
  ```bash
  mysql -u production_user -p'password' hms < /backups/hms_backup_file.sql
  ```

### Handling InnoDB Failures
If the database crashes due to sudden power loss or server shut down:
1. Review the error log located at `d:\xampp\mysql\data\mysql_error.log` (or your OS log location).
2. If InnoDB crashes, add `innodb_force_recovery = 1` up to `6` to the `[mysqld]` section of your configuration file to start the database in read-only mode, export your data using `mysqldump`, initialize a clean cluster, and re-import.

### Handling MariaDB Privilege Table Corruption (Incorrect file format 'db')
If the MariaDB service fails to start and logs `Fatal error: Can't open and lock privilege tables: Incorrect file format 'db'` in the `mysql_error.log`:
1. Ensure the MySQL/MariaDB service is fully stopped (terminate any hung `mysqld.exe` processes via Task Manager details tab).
2. Back up the corrupted folder: Rename `D:\xampp\mysql\data\mysql` to `D:\xampp\mysql\data\mysql_corrupted_backup`.
3. Restore from the system backup directory: Copy the folder `D:\xampp\mysql\backup\mysql` to `D:\xampp\mysql\data\mysql`.
4. Restart the MySQL service in XAMPP.
