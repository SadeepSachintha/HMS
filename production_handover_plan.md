# Production Handover Plan: Hotel Management System (HMS)

This document outlines the system configuration, deployment procedures, recent administrative fixes, and maintenance guidelines required for the production handover of the **Hotel Management System (HMS)**.

---

## 1. System Overview & Architecture

The HMS application is a custom hotel and booking management portal designed to handle hotel room reservations, invoicing, services, and staff management.

* **Backend Framework:** Laravel (PHP)
* **Frontend UI:** Blade templates, Vanilla CSS, and custom Bootstrap styling.
* **Database Engine:** MariaDB/MySQL (InnoDB Storage Engine).
* **Local Stack (Development/Staging):** XAMPP v3.3.0 (Apache, MySQL/MariaDB).

---

## 2. Infrastructure & Environment Configuration

### Server Prerequisites
To deploy the application to a production environment, ensure the target server matches the following specification:
* **Operating System:** Linux (Ubuntu 20.04/22.04 LTS recommended) or Windows Server running IIS/XAMPP.
* **Web Server:** Apache or Nginx.
* **PHP Version:** PHP 8.x (with `mysqli`, `pdo_mysql`, `openssl`, `mbstring`, `xml`, and `zip` extensions enabled).
* **Database:** MariaDB (10.4+) or MySQL (8.0+).

### Key Files & Locations
* **Active Workspace:** `d:\xampp\htdocs\HMS`
* **Laravel Config:** `d:\xampp\htdocs\HMS\.env`
* **Database Backups:** `d:\xampp\htdocs\HMS\database\backup`
* **Global Custom CSS:** [admin.css](file:///d:/xampp/htdocs/HMS/public/css/admin.css)
* **Local MySQL Config:** [my.ini](file:///d:/xampp/mysql/bin/my.ini)

---

## 3. Database Management & Synchronization

### Recent Recovery Actions
During staging setup, the MariaDB database encountered log sequence number (LSN) mismatch corruption and a corrupted `multi-master.info` configuration file. The following recovery steps were successfully executed:
1. **Isolated Recovery:** MySQL was booted into safe read-only mode (`innodb_force_recovery = 6`) to bypass corrupted transaction logs.
2. **Safe Backup:** A full database dump was taken using `mysqldump` to [hms_backup_utf8.sql](file:///d:/xampp/htdocs/HMS/scratch/hms_backup_utf8.sql).
3. **Cluster Reset:** The corrupted directory was archived, a clean system database cluster was initialized, and all schemas and records were successfully re-imported.
4. **Theme Fixes:** Select option styles were updated globally in `admin.css` to prevent browser rendering issues (white text on white background inside native select menus).

### Running Database Synchronization
The database contains a synchronization script [sync_db.php](file:///d:/xampp/htdocs/HMS/database/backup/sync_db.php) to sync changes from the source database (`hms_04052026`) to the target production database (`hms`). 

To run a database synchronization safely:
1. **Ensure both databases exist:** The target database (`hms`) and source database (`hms_04052026`) must be active in your MySQL server.
2. **Execution:** Access the script via your web browser at `http://localhost/HMS/database/backup/sync_db.php` or execute it from the CLI:
   ```bash
   php d:\xampp\htdocs\HMS\database\backup\sync_db.php
   ```
3. **Safety Mechanism:** The script disables foreign key checks during import to allow tables to sync in alphabetical order, and truncates target tables before sync to avoid primary/unique key conflicts.

---

## 4. Production Deployment Checklist

Follow these steps when moving the application from XAMPP to a production server:

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
3. Generate the application key:
   ```bash
   php artisan key:generate
   ```

### Step 3: Database Migration & Seeding
On a fresh installation, run the migrations to create the table structure:
```bash
php artisan migrate --force
```

### Step 4: Optimization & Caching
Prior to launch, clear and rebuild Laravel configurations and route caches for maximum performance:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
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
