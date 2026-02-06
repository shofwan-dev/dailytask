# 🚀 Quick Start Guide - DailyTask

Panduan cepat untuk menjalankan DailyTask dalam 5 menit!

## 📋 Prerequisites

Pastikan sudah terinstall:
- ✅ PHP 8.2 atau lebih tinggi
- ✅ Composer
- ✅ Git (optional)

## ⚡ Quick Setup (Development)

### 1. Clone atau Download Project
```bash
cd c:\laragon\www
# Jika sudah ada folder dailytask, skip step ini
```

### 2. Install Dependencies
```bash
cd dailytask
composer install
```

### 3. Setup Environment
```bash
# Copy file .env.example ke .env
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi WhatsApp API (Optional untuk testing)

Edit file `.env`:
```env
WA_API_KEY=your_actual_api_key
WA_SENDER=628888xxxx
```

> **Note**: Jika belum punya API key, bisa skip dulu. Aplikasi tetap berjalan, hanya fitur WhatsApp yang tidak aktif.

### 5. Setup Database
```bash
# Menggunakan SQLite (sudah default)
php artisan migrate:fresh --seed
```

### 6. Run Application
```bash
php artisan serve
```

Buka browser: **http://localhost:8000**

### 7. Login dengan Demo Account
```
Email: demo@dailytask.com
Password: password
```

## 🎉 Selesai!

Aplikasi sudah berjalan! Sekarang Anda bisa:
- ✅ Lihat dashboard dengan statistik
- ✅ Buat task baru
- ✅ Toggle status task
- ✅ Hapus task

---

## 🧪 Test WhatsApp Integration (Optional)

### 1. Pastikan sudah konfigurasi WA_API_KEY di .env

### 2. Jalankan test script
```bash
php test-whatsapp.php
```

### 3. Masukkan nomor WhatsApp untuk test
```
Enter WhatsApp number to test (format: 628xxx): 628123456789
```

### 4. Cek WhatsApp Anda
Jika berhasil, Anda akan menerima test message.

---

## ⏰ Test Scheduler (Optional)

### 1. Buat task dengan deadline yang sudah lewat
- Login ke aplikasi
- Klik "Tambah Task Baru"
- Set tanggal kemarin atau hari ini dengan jam yang sudah lewat
- Simpan

### 2. Jalankan scheduler manual
```bash
php artisan tasks:send-reminders
```

### 3. Cek output
Anda akan melihat log:
```
🔍 Checking for overdue tasks...
📤 Found 1 overdue task(s). Sending reminders...
📨 Sending reminder to Demo User for task: Your Task Title
✅ Reminder sent successfully!

📊 Summary:
   ✅ Success: 1
   ❌ Failed: 0
```

### 4. Cek WhatsApp
Jika konfigurasi benar, Anda akan menerima reminder.

---

## 🔧 Troubleshooting

### Error: "Class 'Dotenv\Dotenv' not found"
```bash
composer install
```

### Error: "No such file or directory" saat migrate
```bash
# Pastikan di folder yang benar
cd c:\laragon\www\dailytask

# Cek file .env ada
dir .env

# Jika tidak ada, copy dari .env.example
copy .env.example .env
php artisan key:generate
```

### Error: "SQLSTATE[HY000] [2002] Connection refused"
Ubah di `.env`:
```env
DB_CONNECTION=sqlite
```
Kemudian:
```bash
php artisan migrate:fresh --seed
```

### WhatsApp tidak terkirim
1. Cek API key di `.env` sudah benar
2. Cek nomor sender sudah benar (format: 628xxx)
3. Cek nomor penerima sudah benar
4. Test manual: `php test-whatsapp.php`
5. Lihat log: `type storage\logs\laravel.log`

---

## 📱 Akses dari HP/Device Lain

### 1. Cek IP komputer Anda
```bash
ipconfig
```
Cari "IPv4 Address", contoh: `192.168.1.100`

### 2. Jalankan server dengan host
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

### 3. Akses dari HP
Buka browser di HP, ketik:
```
http://192.168.1.100:8000
```

> **Note**: Pastikan HP dan komputer dalam jaringan WiFi yang sama.

---

## 🎨 Customize Theme

Edit `resources/views/layouts/app.blade.php`:

### Ubah warna gradient
```javascript
tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: {
                    500: '#0ea5e9',  // Ubah warna di sini
                    600: '#0284c7',
                }
            }
        }
    }
}
```

### Ubah background gradient
```css
body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    /* Ubah warna gradient di sini */
}
```

---

## 📚 Next Steps

Setelah aplikasi berjalan:

1. **Baca dokumentasi lengkap**: `README.md`
2. **Pelajari API**: `API.md`
3. **Pahami struktur project**: `PROJECT_SUMMARY.md`
4. **Deploy ke production**: Ikuti panduan di `README.md` bagian Deployment

---

## 🆘 Need Help?

- 📖 Baca `README.md` untuk dokumentasi lengkap
- 🐛 Check `storage/logs/laravel.log` untuk error logs
- 💬 Buat issue di GitHub repository

---

**Happy Coding! 🚀**

Dibuat dengan ❤️ menggunakan Laravel & Tailwind CSS
