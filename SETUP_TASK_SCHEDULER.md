# 🚀 PANDUAN SETUP WINDOWS TASK SCHEDULER

## ⚠️ PENTING: Jalankan sebagai Administrator!

Ikuti langkah-langkah berikut dengan teliti:

---

## 📋 LANGKAH 1: Jalankan Script Setup

### **Cara Termudah (Recommended):**

1. **Buka File Explorer**
   - Buka folder: `C:\laragon\www\dailytask`

2. **Cari file:** `setup-scheduler.bat`

3. **Klik kanan** pada file `setup-scheduler.bat`

4. Pilih: **"Run as administrator"**
   
   ![Run as Administrator](https://i.imgur.com/example.png)

5. Jika muncul UAC prompt (User Account Control), klik **"Yes"**

6. **Tunggu proses selesai**
   - Jika berhasil, akan muncul pesan:
     ```
     [SUCCESS] Task Scheduler berhasil dibuat!
     ```

7. **Tekan tombol apapun** untuk menutup window

---

## 📋 LANGKAH 2: Verifikasi Task Scheduler

### **Cara 1: Via PowerShell**

1. Buka PowerShell (tidak perlu Administrator)

2. Jalankan command:
   ```powershell
   Get-ScheduledTask -TaskName "Laravel DailyTask Scheduler"
   ```

3. Output yang diharapkan:
   ```
   TaskName                       State
   --------                       -----
   Laravel DailyTask Scheduler    Ready
   ```

### **Cara 2: Via Task Scheduler GUI**

1. Tekan `Win + R`

2. Ketik: `taskschd.msc`

3. Tekan Enter

4. Di panel kiri, klik: **Task Scheduler Library**

5. Cari task dengan nama: **"Laravel DailyTask Scheduler"**

6. Klik kanan → **Properties**

7. Verifikasi:
   - **General Tab:**
     - Name: `Laravel DailyTask Scheduler`
     - Run whether user is logged on or not: ✅
   
   - **Triggers Tab:**
     - Daily, Repeat every 1 minute
   
   - **Actions Tab:**
     - Program: `C:\laragon\bin\php\php-8.2.12\php.exe`
     - Arguments: `artisan schedule:run`
     - Start in: `C:\laragon\www\dailytask`

---

## 📋 LANGKAH 3: Test Manual

### **Test 1: Run Task Manually**

1. Buka Task Scheduler (`taskschd.msc`)

2. Klik kanan pada **"Laravel DailyTask Scheduler"**

3. Pilih: **"Run"**

4. Task akan berjalan sekali

5. Cek status di kolom **"Last Run Time"** - harus update ke waktu sekarang

### **Test 2: Test Notifikasi**

1. Buka PowerShell atau Command Prompt

2. Jalankan:
   ```bash
   cd C:\laragon\www\dailytask
   php create_test_task.php
   ```

3. Tunggu 1-2 menit (sampai Task Scheduler berjalan)

4. Atau test manual:
   ```bash
   php artisan tasks:send-reminders
   ```

5. Cek WhatsApp - notifikasi harus terkirim! ✅

---

## 📋 LANGKAH 4: Monitor Task Scheduler

### **Cek Status Real-time:**

```powershell
Get-ScheduledTask -TaskName "Laravel DailyTask Scheduler" | Format-List TaskName, State, LastRunTime, NextRunTime
```

Output:
```
TaskName    : Laravel DailyTask Scheduler
State       : Ready
LastRunTime : 2026-02-07 06:30:00
NextRunTime : 2026-02-07 06:31:00
```

### **Cek History:**

1. Buka Task Scheduler GUI

2. Klik pada task **"Laravel DailyTask Scheduler"**

3. Tab bawah: **"History"**

4. Lihat log eksekusi task

---

## ⚠️ TROUBLESHOOTING

### **Problem 1: Script gagal - "Access Denied"**

**Solusi:**
- Pastikan menjalankan sebagai Administrator
- Klik kanan → "Run as administrator"

### **Problem 2: PHP path tidak ditemukan**

**Solusi:**
1. Buka file `setup-scheduler.bat` dengan Notepad
2. Edit baris ke-14:
   ```batch
   set PHP_PATH=C:\laragon\bin\php\php-8.2.12\php.exe
   ```
3. Sesuaikan dengan versi PHP Anda
4. Simpan dan jalankan ulang

### **Problem 3: Task tidak berjalan otomatis**

**Solusi:**
1. Buka Task Scheduler GUI
2. Klik kanan task → Properties
3. Tab "Settings":
   - ✅ Allow task to be run on demand
   - ✅ Run task as soon as possible after scheduled start is missed
   - ✅ If the task fails, restart every: 1 minute
4. Tab "Triggers" → Edit:
   - ✅ Enabled
   - Repeat task every: **1 minute**
   - For a duration of: **Indefinitely**
5. OK → OK

### **Problem 4: Task berjalan tapi notifikasi tidak terkirim**

**Solusi:**
1. Cek konfigurasi WhatsApp Gateway:
   ```bash
   php artisan tinker
   ```
   ```php
   $settings = \App\Models\Setting::first();
   echo "API Key: " . $settings->wa_api_key . "\n";
   echo "Sender: " . $settings->wa_sender . "\n";
   echo "Base URL: " . $settings->wa_base_url . "\n";
   exit
   ```

2. Test manual WhatsApp:
   ```bash
   php test-whatsapp.php
   ```

3. Cek log Laravel:
   ```bash
   tail -f storage/logs/laravel.log
   ```

---

## ✅ CHECKLIST FINAL

Setelah setup, pastikan semua ini ✅:

- [ ] Task Scheduler berhasil dibuat
- [ ] State: **Ready**
- [ ] LastRunTime update setiap menit
- [ ] Test manual task berhasil
- [ ] Test notifikasi berhasil terkirim
- [ ] WhatsApp Gateway dikonfigurasi dengan benar

---

## 🎯 HASIL AKHIR

Setelah setup berhasil:

1. **Task Scheduler berjalan otomatis setiap 1 menit**
2. **Laravel Scheduler mengecek jadwal**
3. **Command `tasks:send-reminders` berjalan setiap 10 menit**
4. **Notifikasi WhatsApp terkirim otomatis untuk task overdue**

### **Timeline Notifikasi:**

```
Task dengan deadline 14:00:
14:00 - Deadline
14:01 - Task Scheduler run (cek jadwal)
14:02 - Task Scheduler run (cek jadwal)
...
14:10 - Task Scheduler run → Laravel Scheduler → tasks:send-reminders
        → Deteksi task overdue → KIRIM NOTIFIKASI ✅
14:11 - Task Scheduler run (cek jadwal)
14:12 - Task Scheduler run (cek jadwal)
...
14:20 - Task Scheduler run → Laravel Scheduler → tasks:send-reminders
        → Task sudah di-notifikasi → SKIP
```

**Notifikasi terkirim 1 kali pada menit ke-10 setelah deadline!**

---

## 📞 BANTUAN

Jika masih ada masalah:

1. Cek file: `TIMEZONE_FIXED.md` - Dokumentasi perbaikan timezone
2. Cek file: `PERBAIKAN_NOTIFIKASI.md` - Dokumentasi lengkap
3. Cek file: `CRONJOB_SETUP.md` - Panduan cronjob detail

---

**Good luck!** 🚀
