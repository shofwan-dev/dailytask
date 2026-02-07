# 🚨 QUICK FIX - Notifikasi WhatsApp Tidak Terkirim

## ❌ Masalah
Task dengan deadline 05:00 AM tidak mendapat notifikasi WhatsApp sampai sekarang (06:15 AM).

## 🔍 Penyebab
1. ~~**Timezone server salah (UTC)**~~ ✅ **SUDAH DIPERBAIKI!**
   - Sebelumnya: Server menggunakan UTC (beda 7 jam dengan Asia/Jakarta)
   - Sekarang: Server sudah menggunakan Asia/Jakarta
2. **Windows Task Scheduler tidak berjalan** - Ini yang masih perlu diperbaiki!

## ✅ Solusi Cepat

### **Langkah 1: Setup Task Scheduler (WAJIB)**

**Pilih salah satu cara:**

#### **Cara A: Menggunakan Batch Script (TERMUDAH)**
1. Klik kanan file `setup-scheduler.bat`
2. Pilih **"Run as administrator"**
3. Ikuti instruksi di layar
4. Selesai! ✅

#### **Cara B: Manual via GUI**
1. Tekan `Win + R`, ketik `taskschd.msc`, Enter
2. Klik "Create Basic Task"
3. Name: `Laravel DailyTask Scheduler`
4. Trigger: Daily, jam 00:00
5. Action: Start a program
   - Program: `C:\laragon\bin\php\php-8.2.12\php.exe`
   - Arguments: `artisan schedule:run`
   - Start in: `C:\laragon\www\dailytask`
6. Klik kanan task → Properties → Triggers → Edit
7. Centang "Repeat task every: **1 minute**"
8. For a duration of: **Indefinitely**
9. OK → OK

### **Langkah 2: Verifikasi**

Buka PowerShell dan jalankan:
```powershell
Get-ScheduledTask -TaskName "Laravel DailyTask Scheduler"
```

Harus muncul task dengan State: **Ready**

### **Langkah 3: Test**

Buat task baru dengan deadline yang sudah lewat:
```bash
cd C:\laragon\www\dailytask
php create_test_task.php
```

Tunggu 10 menit, notifikasi WhatsApp akan terkirim otomatis!

Atau test manual:
```bash
php artisan tasks:send-reminders
```

## 📊 Cara Kerja

```
Windows Task Scheduler (setiap 1 menit)
    ↓
Laravel Scheduler (routes/console.php)
    ↓
Command: tasks:send-reminders (setiap 10 menit)
    ↓
Cek task overdue & belum di-notifikasi
    ↓
Kirim WhatsApp ✅
```

## ⏰ Timeline Notifikasi

Task dengan deadline **05:00 AM**:
- **05:00** - Deadline
- **05:10** - Notifikasi terkirim ✅ (10 menit setelah deadline)
- **05:20** - Skip (sudah di-notifikasi)
- **05:30** - Skip (sudah di-notifikasi)

**Notifikasi hanya dikirim 1 kali per task!**

## 🔧 Troubleshooting

### Notifikasi masih tidak terkirim?

1. **Cek Task Scheduler berjalan:**
   ```powershell
   Get-ScheduledTask -TaskName "Laravel DailyTask Scheduler" | Select State, LastRunTime
   ```
   State harus: **Ready**, LastRunTime harus update setiap menit

2. **Cek ada task overdue:**
   ```bash
   php check_tasks.php
   ```

3. **Test manual:**
   ```bash
   php artisan tasks:send-reminders
   ```

4. **Cek konfigurasi WhatsApp:**
   - Login ke aplikasi
   - Settings → WhatsApp Gateway
   - Pastikan API Key dan Base URL benar

## 📝 Catatan

- ✅ Sistem notifikasi **SUDAH BEKERJA** (test berhasil)
- ⚠️ Yang kurang: **Task Scheduler** untuk menjalankan otomatis
- 🎯 Setelah setup Task Scheduler, notifikasi akan otomatis terkirim setiap 10 menit

---

**Untuk dokumentasi lengkap, lihat: `PERBAIKAN_NOTIFIKASI.md`**
