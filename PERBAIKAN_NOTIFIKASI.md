# 🔧 Perbaikan Notifikasi WhatsApp - DailyTask

## 📋 Diagnosis Masalah

Setelah investigasi, ditemukan **2 masalah utama**:

### 1. ❌ **Task dengan deadline 05:00 AM sudah tidak ada di database**
   - Task tersebut kemungkinan sudah dihapus atau statusnya sudah berubah menjadi "done"
   - Saat ini hanya ada 1 task di database dengan status "done"

### 2. ❌ **Windows Task Scheduler tidak berjalan**
   - Laravel Scheduler memerlukan cronjob/task scheduler untuk berjalan otomatis
   - Saat ini TIDAK ADA task scheduler yang menjalankan `php artisan schedule:run`
   - Ini adalah **PENYEBAB UTAMA** notifikasi tidak terkirim otomatis

## ✅ Sistem Notifikasi Sudah Bekerja

**GOOD NEWS**: Sistem notifikasi WhatsApp **SUDAH BERFUNGSI DENGAN BAIK!**

Test yang dilakukan:
```
✅ Test task dibuat dengan deadline 1 jam yang lalu
✅ Command php artisan tasks:send-reminders berhasil mendeteksi task overdue
✅ Notifikasi WhatsApp berhasil terkirim
✅ Flag wa_notified berhasil di-update
```

Output test:
```
🔍 Checking for overdue tasks...
⏰ Current time: 2026-02-06 23:19:16
📋 Total pending tasks (not notified): 1
   - Task #12: Test Notifikasi Overdue - 23:19:11
     Due: 2026-02-06 22:19:00 | Overdue: YES ✅
📤 Found 1 overdue task(s). Sending reminders...
📨 Sending reminder to Demo User for task: Test Notifikasi Overdue - 23:19:11
✅ Reminder sent successfully!
```

## 🛠️ Solusi: Setup Windows Task Scheduler

Untuk membuat notifikasi berjalan otomatis, Anda perlu setup Windows Task Scheduler.

### **Cara 1: Menggunakan Script PowerShell (RECOMMENDED)**

1. **Buka PowerShell sebagai Administrator**
   - Klik kanan pada Start Menu
   - Pilih "Windows PowerShell (Admin)" atau "Terminal (Admin)"

2. **Jalankan script setup**
   ```powershell
   cd C:\laragon\www\dailytask
   .\setup-scheduler.ps1
   ```

3. **Verifikasi task berhasil dibuat**
   ```powershell
   Get-ScheduledTask -TaskName "Laravel DailyTask Scheduler"
   ```

### **Cara 2: Manual Setup (Alternatif)**

Jika script PowerShell tidak berhasil, setup manual:

1. **Buka Task Scheduler**
   - Tekan `Win + R`
   - Ketik `taskschd.msc`
   - Tekan Enter

2. **Create Basic Task**
   - Klik "Create Basic Task" di panel kanan
   - Name: `Laravel DailyTask Scheduler`
   - Description: `Menjalankan Laravel Scheduler untuk DailyTask`
   - Klik Next

3. **Trigger**
   - Pilih: **Daily**
   - Start: **Hari ini, jam 00:00**
   - Klik Next

4. **Action**
   - Pilih: **Start a program**
   - Program/script: `C:\laragon\bin\php\php-8.2.12\php.exe`
   - Add arguments: `artisan schedule:run`
   - Start in: `C:\laragon\www\dailytask`
   - Klik Next → Finish

5. **Edit Trigger untuk Repeat**
   - Klik kanan pada task yang baru dibuat
   - Pilih "Properties"
   - Tab "Triggers" → Klik "Edit"
   - Centang "Repeat task every"
   - Pilih: **1 minute**
   - For a duration of: **Indefinitely**
   - Klik OK

6. **Edit Settings**
   - Tab "Settings"
   - Centang: "Allow task to be run on demand"
   - Centang: "Run task as soon as possible after a scheduled start is missed"
   - Centang: "If the task fails, restart every: 1 minute"
   - Klik OK

## 🧪 Testing

### **Test 1: Manual Command**
```bash
cd C:\laragon\www\dailytask
php artisan tasks:send-reminders
```

Output yang diharapkan:
```
🔍 Checking for overdue tasks...
⏰ Current time: 2026-02-07 06:15:00
📋 Total pending tasks (not notified): 0
✅ No overdue tasks found.
```

### **Test 2: Buat Task Overdue**
```bash
php create_test_task.php
php artisan tasks:send-reminders
```

Output yang diharapkan:
```
📤 Found 1 overdue task(s). Sending reminders...
✅ Reminder sent successfully!
```

### **Test 3: Verifikasi Task Scheduler**
```powershell
Get-ScheduledTask -TaskName "Laravel DailyTask Scheduler" | Format-List TaskName, State, LastRunTime, NextRunTime
```

Output yang diharapkan:
```
TaskName    : Laravel DailyTask Scheduler
State       : Ready
LastRunTime : 2026-02-07 06:15:00
NextRunTime : 2026-02-07 06:16:00
```

## 📊 Cara Kerja Sistem

1. **Windows Task Scheduler** menjalankan `php artisan schedule:run` setiap 1 menit
2. **Laravel Scheduler** (di `routes/console.php`) mengecek jadwal yang terdaftar
3. Command `tasks:send-reminders` dijalankan **setiap 10 menit**
4. Command mengecek task yang:
   - Status: **pending** (belum selesai)
   - Deadline: **sudah lewat** (overdue)
   - Belum di-notifikasi: **wa_notified = false**
5. Jika ada task yang memenuhi kriteria, kirim notifikasi WhatsApp
6. Update flag `wa_notified = true` agar tidak kirim ulang

## ⏰ Timeline Notifikasi

Contoh: Task dengan deadline **05:00 AM**

```
05:00 AM ← Deadline task
05:10 AM ← Cronjob cek (task overdue, KIRIM NOTIFIKASI ✅)
05:20 AM ← Cronjob cek (sudah di-notifikasi, SKIP)
05:30 AM ← Cronjob cek (sudah di-notifikasi, SKIP)
...
```

**Notifikasi hanya dikirim 1 kali** pada jam **05:10 AM** (10 menit setelah deadline).

## 🔍 Monitoring

### **Cek Status Task Scheduler**
```powershell
Get-ScheduledTask -TaskName "Laravel DailyTask Scheduler"
```

### **Cek Log Laravel**
```bash
tail -f storage/logs/laravel.log
```

### **Cek Task di Database**
```bash
php check_tasks.php
```

## ⚠️ Troubleshooting

### **Notifikasi tidak terkirim**

1. **Cek apakah Task Scheduler berjalan**
   ```powershell
   Get-ScheduledTask -TaskName "Laravel DailyTask Scheduler" | Select-Object State, LastRunTime
   ```
   - State harus: **Ready**
   - LastRunTime harus update setiap menit

2. **Cek apakah ada task overdue**
   ```bash
   php check_tasks.php
   ```

3. **Test manual command**
   ```bash
   php artisan tasks:send-reminders
   ```

4. **Cek konfigurasi WhatsApp Gateway**
   - Login ke aplikasi
   - Settings → WhatsApp Gateway
   - Pastikan API Key, Base URL, dan Sender sudah benar

### **Task Scheduler tidak berjalan**

1. **Cek apakah task ada**
   ```powershell
   Get-ScheduledTask | Where-Object {$_.TaskName -like "*Laravel*"}
   ```

2. **Cek path PHP**
   - Buka Task Scheduler GUI
   - Klik kanan task → Properties
   - Tab "Actions" → Edit
   - Pastikan path PHP benar: `C:\laragon\bin\php\php-8.2.12\php.exe`

3. **Cek working directory**
   - Harus: `C:\laragon\www\dailytask`

4. **Run task manually**
   - Klik kanan task → Run
   - Cek apakah ada error

## 📝 Catatan Penting

1. **Frekuensi**: Notifikasi dicek setiap **10 menit**
2. **Sekali kirim**: Setiap task **hanya di-notifikasi 1 kali**
3. **Kondisi**: Hanya task **pending** dan **overdue** yang di-notifikasi
4. **Penerima**: Nomor yang dikonfigurasi di **Settings → WhatsApp Gateway**

## ✅ Checklist

- [x] Sistem notifikasi sudah berfungsi (test berhasil)
- [ ] Windows Task Scheduler sudah dibuat
- [ ] Task Scheduler berjalan setiap menit
- [ ] Laravel Scheduler menjalankan command setiap 10 menit
- [ ] Notifikasi WhatsApp terkirim untuk task overdue

---

## 🎯 Kesimpulan

**Masalah**: Task dengan deadline 05:00 AM tidak mendapat notifikasi karena:
1. Task sudah tidak ada di database (kemungkinan dihapus/diselesaikan)
2. Windows Task Scheduler tidak berjalan (cronjob tidak aktif)

**Solusi**: 
1. ✅ Sistem notifikasi sudah bekerja dengan baik
2. ⚠️ **PERLU SETUP** Windows Task Scheduler untuk menjalankan otomatis

**Next Step**:
1. Jalankan script `setup-scheduler.ps1` sebagai Administrator
2. Atau setup manual via Task Scheduler GUI
3. Verifikasi task scheduler berjalan
4. Buat task baru dengan deadline yang akan datang untuk testing

---

**Setelah setup Task Scheduler, notifikasi WhatsApp akan otomatis terkirim setiap 10 menit untuk task yang overdue!** 🚀
