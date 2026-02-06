# Setup Cronjob untuk WhatsApp Reminder

## 📋 Penjelasan

Aplikasi DailyTask menggunakan **Laravel Scheduler** untuk mengirim reminder WhatsApp otomatis setiap 10 menit. Scheduler akan mengecek task yang sudah melewati deadline dan belum selesai, lalu mengirim notifikasi WhatsApp.

## ⚙️ Konfigurasi yang Sudah Ada

### 1. **Command Artisan**
File: `app/Console/Commands/SendTaskReminders.php`

Command ini akan:
- ✅ Cek task yang overdue (melewati deadline)
- ✅ Cek task yang belum di-notifikasi (`wa_notified = false`)
- ✅ Kirim reminder WhatsApp ke user
- ✅ Update flag `wa_notified = true` setelah berhasil kirim

**Manual Run** (untuk testing):
```bash
php artisan tasks:send-reminders
```

### 2. **Laravel Scheduler**
File: `routes/console.php`

Schedule sudah dikonfigurasi untuk menjalankan command setiap 10 menit:
```php
Schedule::command('tasks:send-reminders')
    ->everyTenMinutes()
    ->withoutOverlapping()
    ->runInBackground();
```

## 🚀 Setup Cronjob di Server

### **Linux/Ubuntu Server** (Recommended)

1. **Edit Crontab**:
```bash
crontab -e
```

2. **Tambahkan Baris Ini**:
```bash
* * * * * cd /www/wwwroot/webanda.com && php artisan schedule:run >> /dev/null 2>&1
```

**Penjelasan**:
- `* * * * *` = Jalankan setiap menit
- Laravel scheduler akan menentukan command mana yang perlu dijalankan
- `>> /dev/null 2>&1` = Suppress output (opsional)

3. **Verifikasi Crontab**:
```bash
crontab -l
```

### **Alternative: Systemd Timer** (Modern Linux)

1. **Buat Service File**:
```bash
sudo nano /etc/systemd/system/laravel-scheduler.service
```

Content:
```ini
[Unit]
Description=Laravel Scheduler

[Service]
Type=oneshot
User=www-data
WorkingDirectory=/www/wwwroot/task.mutekar.com
ExecStart=/usr/bin/php artisan schedule:run

[Install]
WantedBy=multi-user.target
```

2. **Buat Timer File**:
```bash
sudo nano /etc/systemd/system/laravel-scheduler.timer
```

Content:
```ini
[Unit]
Description=Laravel Scheduler Timer

[Timer]
OnBootSec=1min
OnUnitActiveSec=1min

[Install]
WantedBy=timers.target
```

3. **Enable & Start**:
```bash
sudo systemctl enable laravel-scheduler.timer
sudo systemctl start laravel-scheduler.timer
sudo systemctl status laravel-scheduler.timer
```

### **Windows Server** (Task Scheduler)

1. Buka **Task Scheduler**
2. Create Basic Task:
   - Name: `Laravel Scheduler`
   - Trigger: **Daily** at 00:00
   - Action: **Start a Program**
   - Program: `C:\php\php.exe`
   - Arguments: `artisan schedule:run`
   - Start in: `C:\www\task.mutekar.com`
3. Edit Task → Triggers → Advanced:
   - Repeat task every: **1 minute**
   - Duration: **Indefinitely**

## 🧪 Testing Cronjob

### 1. **Test Manual Command**:
```bash
cd /www/wwwroot/task.mutekar.com
php artisan tasks:send-reminders
```

Output yang diharapkan:
```
🔍 Checking for overdue tasks...
📤 Found 2 overdue task(s). Sending reminders...
📨 Sending reminder to John Doe for task: Submit Report
✅ Reminder sent successfully!
📨 Sending reminder to Jane Smith for task: Meeting Preparation
✅ Reminder sent successfully!

📊 Summary:
   ✅ Success: 2
   ❌ Failed: 0
```

### 2. **Test Scheduler**:
```bash
php artisan schedule:list
```

Output:
```
  0 * * * *  php artisan tasks:send-reminders ............... Next Due: 10 minutes from now
```

### 3. **Test Cronjob**:
Tunggu 1-2 menit, lalu cek log:
```bash
tail -f storage/logs/laravel.log
```

## 📊 Monitoring

### **Check Scheduler Status**:
```bash
php artisan schedule:list
```

### **Check Last Run**:
```bash
php artisan schedule:test
```

### **Manual Trigger** (untuk testing):
```bash
php artisan schedule:work
# Ini akan run scheduler setiap menit (untuk development)
```

### **Check Logs**:
```bash
tail -f storage/logs/laravel.log | grep "WhatsApp"
```

## ⚠️ Troubleshooting

### **Cronjob tidak jalan**:
1. Cek permission:
```bash
chmod -R 755 /www/wwwroot/task.mutekar.com
```

2. Cek PHP path:
```bash
which php
# Gunakan full path di crontab jika perlu
```

3. Cek crontab user:
```bash
# Pastikan run sebagai user yang benar (www-data atau user aplikasi)
sudo crontab -u www-data -e
```

### **Reminder tidak terkirim**:
1. Cek WhatsApp Gateway config di database/settings
2. Cek log error:
```bash
tail -f storage/logs/laravel.log
```

3. Test manual:
```bash
php artisan tinker
```
```php
$service = app(\App\Services\WhatsAppService::class);
$service->sendMessage('628123456789', 'Test message');
```

## 📝 Catatan Penting

1. **Frequency**: Scheduler berjalan setiap 10 menit (bisa diubah di `routes/console.php`)
2. **Overlap Prevention**: `withoutOverlapping()` mencegah command berjalan bersamaan
3. **Background**: `runInBackground()` agar tidak block scheduler lain
4. **Notification Flag**: Task yang sudah di-notifikasi tidak akan dikirim lagi (`wa_notified = true`)

## 🔧 Kustomisasi

### **Ubah Frequency**:
Edit `routes/console.php`:
```php
// Setiap 5 menit
Schedule::command('tasks:send-reminders')->everyFiveMinutes();

// Setiap jam
Schedule::command('tasks:send-reminders')->hourly();

// Setiap hari jam 9 pagi
Schedule::command('tasks:send-reminders')->dailyAt('09:00');
```

### **Tambah Logging**:
```php
Schedule::command('tasks:send-reminders')
    ->everyTenMinutes()
    ->appendOutputTo(storage_path('logs/scheduler.log'));
```

## ✅ Checklist Setup

- [ ] Command `tasks:send-reminders` sudah ada
- [ ] Schedule sudah dikonfigurasi di `routes/console.php`
- [ ] Cronjob sudah ditambahkan di server (`crontab -e`)
- [ ] WhatsApp Gateway sudah dikonfigurasi (API Key, Sender, Base URL)
- [ ] Test manual command berhasil
- [ ] Test scheduler berhasil
- [ ] Monitor log untuk memastikan berjalan otomatis

---

**Setelah setup cronjob, reminder WhatsApp akan otomatis terkirim setiap 10 menit untuk task yang overdue!** 🚀
