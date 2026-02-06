# 📋 DailyTask - Task & Reminder via WhatsApp

![DailyTask Banner](https://img.shields.io/badge/Laravel-12-red?style=for-the-badge&logo=laravel)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-CSS-38B2AC?style=for-the-badge&logo=tailwind-css)
![WhatsApp](https://img.shields.io/badge/WhatsApp-API-25D366?style=for-the-badge&logo=whatsapp)

Web aplikasi modern untuk manajemen task/to-do list dengan fitur **reminder otomatis via WhatsApp**. Jika task belum selesai sampai deadline, sistem akan otomatis mengirim notifikasi WhatsApp.

## ✨ Fitur Utama

- ✅ **CRUD Task** - Tambah, lihat, update, dan hapus task
- ⏰ **Deadline Management** - Set tanggal dan jam deadline
- 📱 **WhatsApp Reminder** - Notifikasi otomatis via WhatsApp API
- 🎨 **Modern UI** - Design premium dengan Tailwind CSS
- 📊 **Dashboard Stats** - Statistik task (total, pending, completed)
- 🔐 **Authentication** - Login & Register dengan validasi
- 🌙 **Responsive Design** - Mobile-friendly interface
- ⚡ **Real-time Toggle** - Update status task via AJAX

## 🛠️ Tech Stack

### Frontend
- **HTML5** - Struktur halaman
- **Tailwind CSS** - Styling modern (CDN)
- **JavaScript** - Interaksi & AJAX
- **Google Fonts (Inter)** - Typography premium

### Backend
- **Laravel 12** - PHP Framework
- **SQLite/MySQL/PostgreSQL** - Database
- **Laravel Scheduler** - Cron job untuk reminder
- **Guzzle HTTP** - WhatsApp API integration

### Infrastructure
- **VPS Ubuntu 22.04** (production)
- **Nginx** - Web server
- **SSL (Let's Encrypt)** - HTTPS
- **Supervisor** - Queue worker management

## 📦 Instalasi

### Requirements
- PHP >= 8.2
- Composer
- Node.js & NPM (optional, untuk build assets)
- Database: SQLite / MySQL / PostgreSQL

### Langkah Instalasi

1. **Clone Repository**
```bash
git clone <repository-url>
cd dailytask
```

2. **Install Dependencies**
```bash
composer install
```

3. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi Database**

Edit file `.env`:

**Untuk SQLite (Development):**
```env
DB_CONNECTION=sqlite
```

**Untuk MySQL:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dailytask
DB_USERNAME=root
DB_PASSWORD=
```

**Untuk PostgreSQL:**
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=dailytask
DB_USERNAME=postgres
DB_PASSWORD=your_password
DB_PASSWORD=your_password
```

> **📘 PostgreSQL Guide**: Untuk panduan lengkap setup PostgreSQL, lihat [POSTGRESQL.md](POSTGRESQL.md)

5. **Konfigurasi WhatsApp API**

Edit file `.env`:
```env
WA_API_KEY=your_api_key_here
WA_SENDER=628888xxxx
WA_BASE_URL=https://mpwa.xxx.com
```

6. **Run Migration & Seeder**
```bash
php artisan migrate:fresh --seed
```

7. **Start Development Server**
```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://localhost:8000`

### Demo Account
- **Email**: demo@dailytask.com
- **Password**: password

## ⚙️ Konfigurasi Scheduler (Production)

### 1. Setup Cron Job

Tambahkan ke crontab server:
```bash
crontab -e
```

Tambahkan baris berikut:
```cron
* * * * * cd /path/to/dailytask && php artisan schedule:run >> /dev/null 2>&1
```

### 2. Test Scheduler Manually

```bash
# Test command reminder
php artisan tasks:send-reminders

# Lihat scheduled tasks
php artisan schedule:list
```

### 3. Monitoring Logs

```bash
tail -f storage/logs/laravel.log
```

## 🔧 Konfigurasi WhatsApp API

### Endpoint
```
POST https://mpwa.mutekar.com/send-message
```

### Payload
```json
{
  "api_key": "YOUR_API_KEY",
  "sender": "628888xxxx",
  "number": "628123456789",
  "message": "⏰ Reminder Task!\n\nTask: Submit laporan\nDeadline: Hari ini 17:00\n\nSegera dikerjakan ya!",
  "footer": "DailyTask App"
}
```

### Format Nomor WhatsApp
- Format: `628xxx` (tanpa +, tanpa spasi)
- Contoh: `628123456789`

## 📁 Struktur Database

### Tabel: users
| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| name | varchar | Nama user |
| email | varchar | Email (unique) |
| phone_number | varchar | Nomor WA (628xxx) |
| password | varchar | Hashed password |
| created_at | timestamp | |

### Tabel: tasks
| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| user_id | bigint | Foreign key to users |
| title | varchar | Judul task |
| description | text | Deskripsi (nullable) |
| due_date | date | Tanggal deadline |
| due_time | time | Jam deadline |
| status | enum | pending/done |
| wa_notified | boolean | Sudah kirim WA? |
| created_at | timestamp | |

## 🚀 Deployment ke Production

### 1. Setup VPS (Ubuntu 22.04)

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install PHP 8.2
sudo apt install php8.2 php8.2-fpm php8.2-mysql php8.2-sqlite3 php8.2-mbstring php8.2-xml php8.2-curl -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Nginx
sudo apt install nginx -y
```

### 2. Clone & Setup Project

```bash
cd /var/www
git clone <repository-url> dailytask
cd dailytask
composer install --optimize-autoloader --no-dev
cp .env.example .env
php artisan key:generate
```

### 3. Konfigurasi Nginx

Buat file `/etc/nginx/sites-available/dailytask`:

```nginx
server {
    listen 80;
    server_name dailytask.yourdomain.com;
    root /var/www/dailytask/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Enable site:
```bash
sudo ln -s /etc/nginx/sites-available/dailytask /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### 4. Setup SSL (Let's Encrypt)

```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d dailytask.yourdomain.com
```

### 5. Set Permissions

```bash
sudo chown -R www-data:www-data /var/www/dailytask
sudo chmod -R 755 /var/www/dailytask
sudo chmod -R 775 /var/www/dailytask/storage
sudo chmod -R 775 /var/www/dailytask/bootstrap/cache
```

### 6. Setup Cron

```bash
sudo crontab -e -u www-data
```

Tambahkan:
```cron
* * * * * cd /var/www/dailytask && php artisan schedule:run >> /dev/null 2>&1
```

## 📱 Testing WhatsApp Integration

### Manual Test

```bash
php artisan tinker
```

```php
$service = new App\Services\WhatsAppService();
$service->sendMessage('628123456789', 'Test message from DailyTask!', 'DailyTask App');
```

### Test Scheduler

```bash
# Buat task dengan deadline yang sudah lewat
# Kemudian jalankan:
php artisan tasks:send-reminders
```

## 🎨 Customization

### Ubah Warna Theme

Edit `resources/views/layouts/app.blade.php`:

```javascript
tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: {
                    // Ubah warna di sini
                    500: '#0ea5e9',
                    600: '#0284c7',
                    // ...
                }
            }
        }
    }
}
```

### Ubah Interval Reminder

Edit `routes/console.php`:

```php
Schedule::command('tasks:send-reminders')
    ->everyFiveMinutes()  // Ubah dari everyTenMinutes()
    ->withoutOverlapping()
    ->runInBackground();
```

## 🐛 Troubleshooting

### WhatsApp Tidak Terkirim

1. Cek API Key dan Sender di `.env`
2. Cek format nomor WA (harus 628xxx)
3. Lihat log: `tail -f storage/logs/laravel.log`
4. Test manual via Postman

### Scheduler Tidak Jalan

1. Pastikan cron sudah di-setup
2. Cek log cron: `grep CRON /var/log/syslog`
3. Test manual: `php artisan tasks:send-reminders`

### Permission Error

```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

## 📄 License

MIT License - bebas digunakan untuk project pribadi maupun komersial.

## 👨‍💻 Author

Developed with ❤️ by Full Stack Expert

---

## 🎯 Future Enhancements

- [ ] ⏰ Reminder H-1 via WhatsApp
- [ ] 📊 Statistik task (chart)
- [ ] 🔔 Multiple reminder time
- [ ] 📱 Progressive Web App (PWA)
- [ ] 🧠 AI task suggestion
- [ ] 📧 Email notification
- [ ] 🌐 Multi-language support
- [ ] 🎨 Theme customization
- [ ] 📤 Export task to PDF/Excel
- [ ] 👥 Team collaboration

---

**⭐ Jika project ini membantu, jangan lupa kasih star!**
