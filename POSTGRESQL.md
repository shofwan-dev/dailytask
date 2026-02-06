# 🐘 PostgreSQL Setup Guide - DailyTask

Panduan lengkap untuk menggunakan PostgreSQL sebagai database DailyTask.

## ✅ Ya, DailyTask Sudah Support PostgreSQL!

Laravel mendukung PostgreSQL secara native, jadi DailyTask bisa menggunakan:
- ✅ **SQLite** - Untuk development/testing
- ✅ **MySQL** - Untuk production
- ✅ **PostgreSQL** - Untuk production (recommended untuk scalability)

---

## 🚀 Quick Setup (Windows/Laragon)

### 1. Install PostgreSQL Extension untuk PHP

Edit `php.ini` (di Laragon: Menu > PHP > php.ini):

```ini
# Uncomment baris berikut:
extension=pdo_pgsql
extension=pgsql
```

Restart Apache/Nginx setelah edit.

### 2. Install PostgreSQL Server

**Download & Install:**
- Download dari: https://www.postgresql.org/download/windows/
- Install dengan default settings
- Set password untuk user `postgres`

**Atau via Laragon:**
- Laragon biasanya sudah include PostgreSQL
- Klik Menu > PostgreSQL > Start

### 3. Buat Database

**Via pgAdmin (GUI):**
1. Buka pgAdmin
2. Connect ke server (password: yang Anda set saat install)
3. Klik kanan "Databases" > Create > Database
4. Nama: `dailytask`
5. Save

**Via Command Line:**
```bash
# Login ke PostgreSQL
psql -U postgres

# Buat database
CREATE DATABASE dailytask;

# Buat user khusus (optional)
CREATE USER dailytask_user WITH PASSWORD 'your_password';
GRANT ALL PRIVILEGES ON DATABASE dailytask TO dailytask_user;

# Exit
\q
```

### 4. Update .env

Edit `c:\laragon\www\dailytask\.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=dailytask
DB_USERNAME=postgres
DB_PASSWORD=your_password

# Atau jika pakai user khusus:
# DB_USERNAME=dailytask_user
# DB_PASSWORD=your_password
```

### 5. Clear Config & Run Migration

```bash
cd c:\laragon\www\dailytask

# Clear cache
php artisan config:clear

# Run migration
php artisan migrate:fresh --seed
```

### 6. Test Aplikasi

```bash
php artisan serve
```

Buka: http://127.0.0.1:8000

---

## 🐧 Setup di Ubuntu/VPS

### 1. Install PostgreSQL

```bash
# Update system
sudo apt update

# Install PostgreSQL
sudo apt install -y postgresql postgresql-contrib

# Start service
sudo systemctl start postgresql
sudo systemctl enable postgresql

# Check status
sudo systemctl status postgresql
```

### 2. Install PHP PostgreSQL Extension

```bash
sudo apt install -y php8.2-pgsql

# Restart PHP-FPM
sudo systemctl restart php8.2-fpm
```

### 3. Create Database & User

```bash
# Switch to postgres user
sudo -u postgres psql

# Create database
CREATE DATABASE dailytask;

# Create user
CREATE USER dailytask_user WITH PASSWORD 'strong_password_here';

# Grant privileges
GRANT ALL PRIVILEGES ON DATABASE dailytask TO dailytask_user;

# Exit
\q
```

### 4. Configure Laravel

Edit `/var/www/dailytask/.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=dailytask
DB_USERNAME=dailytask_user
DB_PASSWORD=strong_password_here
```

### 5. Run Migrations

```bash
cd /var/www/dailytask

php artisan config:clear
php artisan migrate:fresh --seed
```

---

## 🔧 Troubleshooting

### Error: "could not find driver"

**Solusi:**
```bash
# Check apakah extension sudah aktif
php -m | grep pgsql

# Jika tidak ada, install:
# Windows: Edit php.ini, uncomment extension=pdo_pgsql
# Linux: sudo apt install php8.2-pgsql

# Restart server
```

### Error: "FATAL: password authentication failed"

**Solusi:**
1. Cek password di `.env` sudah benar
2. Cek user exists:
   ```bash
   sudo -u postgres psql
   \du  # List users
   ```
3. Reset password:
   ```sql
   ALTER USER dailytask_user WITH PASSWORD 'new_password';
   ```

### Error: "FATAL: database does not exist"

**Solusi:**
```bash
# Buat database
sudo -u postgres psql
CREATE DATABASE dailytask;
\q
```

### Error: "Connection refused"

**Solusi:**
1. Cek PostgreSQL running:
   ```bash
   sudo systemctl status postgresql
   ```
2. Cek port 5432 terbuka:
   ```bash
   sudo netstat -plnt | grep 5432
   ```
3. Cek `pg_hba.conf` allow local connections:
   ```bash
   sudo nano /etc/postgresql/*/main/pg_hba.conf
   # Pastikan ada baris:
   # local   all             all                                     md5
   ```

---

## 🎯 Keuntungan PostgreSQL

### vs SQLite
- ✅ Better performance untuk production
- ✅ Support concurrent writes
- ✅ Advanced features (JSON, full-text search)
- ✅ Better data integrity

### vs MySQL
- ✅ Better compliance dengan SQL standards
- ✅ Advanced data types (JSON, Array, UUID)
- ✅ Better handling untuk complex queries
- ✅ MVCC (Multi-Version Concurrency Control)

---

## 📊 Performance Tips

### 1. Indexing

Migrations sudah include foreign key indexes, tapi bisa tambahkan:

```php
// database/migrations/add_indexes.php
Schema::table('tasks', function (Blueprint $table) {
    $table->index('status');
    $table->index('due_date');
    $table->index(['user_id', 'status']);
});
```

### 2. Connection Pooling

Edit `config/database.php`:

```php
'pgsql' => [
    'driver' => 'pgsql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '5432'),
    'database' => env('DB_DATABASE', 'forge'),
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => 'utf8',
    'prefix' => '',
    'prefix_indexes' => true,
    'schema' => 'public',
    'sslmode' => 'prefer',
    
    // Connection pooling
    'options' => [
        PDO::ATTR_PERSISTENT => true,
    ],
],
```

### 3. Query Optimization

```php
// Use eager loading
$tasks = Task::with('user')->get();

// Use select to limit columns
$tasks = Task::select('id', 'title', 'status')->get();

// Use pagination
$tasks = Task::paginate(20);
```

---

## 🔒 Security Best Practices

### 1. Strong Password

```bash
# Generate strong password
openssl rand -base64 32
```

### 2. Restrict Access

Edit `/etc/postgresql/*/main/pg_hba.conf`:

```conf
# Only allow localhost
host    dailytask    dailytask_user    127.0.0.1/32    md5
```

### 3. SSL Connection (Production)

```env
DB_SSLMODE=require
```

---

## 📱 Backup & Restore

### Backup Database

```bash
# Full backup
pg_dump -U dailytask_user dailytask > backup.sql

# Compressed backup
pg_dump -U dailytask_user dailytask | gzip > backup.sql.gz

# Backup with timestamp
pg_dump -U dailytask_user dailytask > backup_$(date +%Y%m%d_%H%M%S).sql
```

### Restore Database

```bash
# Restore from backup
psql -U dailytask_user dailytask < backup.sql

# Restore from compressed
gunzip -c backup.sql.gz | psql -U dailytask_user dailytask
```

### Automated Backup (Cron)

```bash
# Edit crontab
crontab -e

# Add daily backup at 2 AM
0 2 * * * pg_dump -U dailytask_user dailytask | gzip > /backups/dailytask_$(date +\%Y\%m\%d).sql.gz
```

---

## 🧪 Testing Connection

### Via PHP

```bash
cd c:\laragon\www\dailytask
php artisan tinker
```

```php
// Test connection
DB::connection()->getPdo();

// Run query
DB::select('SELECT version()');

// Check tables
DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public'");
```

### Via psql

```bash
# Connect
psql -U dailytask_user -d dailytask -h 127.0.0.1

# List tables
\dt

# Describe table
\d tasks

# Run query
SELECT * FROM users LIMIT 5;

# Exit
\q
```

---

## 📚 Useful PostgreSQL Commands

```sql
-- List databases
\l

-- List users
\du

-- Connect to database
\c dailytask

-- List tables
\dt

-- Describe table
\d tasks

-- Show table size
SELECT pg_size_pretty(pg_total_relation_size('tasks'));

-- Show database size
SELECT pg_size_pretty(pg_database_size('dailytask'));

-- Show active connections
SELECT * FROM pg_stat_activity WHERE datname = 'dailytask';

-- Kill connection
SELECT pg_terminate_backend(pid) FROM pg_stat_activity WHERE datname = 'dailytask' AND pid <> pg_backend_pid();
```

---

## 🎓 Resources

### Official Documentation
- PostgreSQL: https://www.postgresql.org/docs/
- Laravel Database: https://laravel.com/docs/database
- pgAdmin: https://www.pgadmin.org/

### Tools
- **pgAdmin** - GUI management tool
- **DBeaver** - Universal database tool
- **TablePlus** - Modern database GUI

---

## ✅ Summary

PostgreSQL sudah **fully supported** di DailyTask! 

**Langkah singkat:**
1. Install PostgreSQL server
2. Install PHP pgsql extension
3. Buat database
4. Update `.env` dengan `DB_CONNECTION=pgsql`
5. Run `php artisan migrate:fresh --seed`
6. Done! 🎉

**Rekomendasi:**
- Development: SQLite (simple, no setup)
- Production: PostgreSQL (scalable, feature-rich)

---

**Need help?** Check troubleshooting section atau buka issue di GitHub repository.
