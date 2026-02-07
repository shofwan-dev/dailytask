# 📱 Kapan Notifikasi WhatsApp Berjalan?

## 🎯 Konsep Dasar

Notifikasi WhatsApp **HANYA** dikirim untuk task yang:
1. ✅ Status: **Pending** (belum selesai)
2. ✅ Deadline: **Sudah lewat** (overdue)
3. ✅ Belum pernah di-notifikasi (`wa_notified = false`)

## ⏰ Timeline Notifikasi

### **Contoh 1: Task Overdue - Notifikasi Terkirim**

**Skenario**:
- Sekarang: **Kamis, 6 Feb 2026 - 23:50**
- Task dibuat dengan deadline: **Kamis, 6 Feb 2026 - 17:00**
- Status: **Pending**

**Timeline**:
```
17:00 ← Deadline task
17:10 ← Cronjob cek (belum overdue, karena masih dalam toleransi)
17:20 ← Cronjob cek (task overdue, KIRIM NOTIFIKASI ✅)
17:30 ← Cronjob cek (task sudah di-notifikasi, SKIP)
17:40 ← Cronjob cek (task sudah di-notifikasi, SKIP)
...
23:50 ← Sekarang (task tetap pending, tapi sudah di-notifikasi, SKIP)
```

**Hasil**: Notifikasi **HANYA DIKIRIM 1 KALI** pada jam 17:20 (10 menit setelah deadline).

---

### **Contoh 2: Task Selesai Tepat Waktu - Tidak Ada Notifikasi**

**Skenario**:
- Sekarang: **Kamis, 6 Feb 2026 - 23:50**
- Task dibuat dengan deadline: **Kamis, 6 Feb 2026 - 17:00**
- User menyelesaikan task jam **16:45** (sebelum deadline)
- Status: **Done**

**Timeline**:
```
16:45 ← User klik "Selesai" (status = done)
17:00 ← Deadline task
17:10 ← Cronjob cek (status = done, SKIP ❌)
17:20 ← Cronjob cek (status = done, SKIP ❌)
...
23:50 ← Sekarang
```

**Hasil**: **TIDAK ADA NOTIFIKASI** karena task sudah selesai sebelum deadline.

---

### **Contoh 3: Task Diselesaikan Setelah Overdue**

**Skenario**:
- Sekarang: **Kamis, 6 Feb 2026 - 23:50**
- Task dibuat dengan deadline: **Kamis, 6 Feb 2026 - 17:00**
- Notifikasi terkirim jam **17:10**
- User menyelesaikan task jam **18:30** (terlambat)
- Status: **Done**

**Timeline**:
```
17:00 ← Deadline task
17:10 ← Cronjob cek (overdue, KIRIM NOTIFIKASI ✅)
17:20 ← Cronjob cek (sudah di-notifikasi, SKIP)
18:30 ← User klik "Selesai" (status = done)
18:40 ← Cronjob cek (status = done, SKIP ❌)
...
23:50 ← Sekarang
```

**Hasil**: Notifikasi **DIKIRIM 1 KALI** pada jam 17:10. Setelah task selesai, tidak ada notifikasi lagi.

---

### **Contoh 4: Task dengan Deadline Besok - Belum Ada Notifikasi**

**Skenario**:
- Sekarang: **Kamis, 6 Feb 2026 - 23:50**
- Task dibuat dengan deadline: **Jumat, 7 Feb 2026 - 10:00**
- Status: **Pending**

**Timeline**:
```
23:50 ← Sekarang (deadline belum lewat, SKIP ❌)
00:00 ← Cronjob cek (deadline belum lewat, SKIP ❌)
00:10 ← Cronjob cek (deadline belum lewat, SKIP ❌)
...
09:50 ← Cronjob cek (deadline belum lewat, SKIP ❌)
10:00 ← Deadline task
10:10 ← Cronjob cek (overdue, KIRIM NOTIFIKASI ✅)
```

**Hasil**: Notifikasi akan dikirim **besok jam 10:10** (10 menit setelah deadline).

---

### **Contoh 5: Multiple Tasks Overdue**

**Skenario**:
- Sekarang: **Kamis, 6 Feb 2026 - 23:50**
- Task A: Deadline **17:00** (pending, belum notified)
- Task B: Deadline **20:00** (pending, belum notified)
- Task C: Deadline **22:00** (pending, belum notified)

**Timeline**:
```
17:10 ← Cronjob: Task A overdue, KIRIM NOTIFIKASI A ✅
20:10 ← Cronjob: Task B overdue, KIRIM NOTIFIKASI B ✅
22:10 ← Cronjob: Task C overdue, KIRIM NOTIFIKASI C ✅
23:50 ← Sekarang (semua task sudah di-notifikasi, SKIP)
```

**Hasil**: 3 notifikasi terkirim, masing-masing 10 menit setelah deadline.

---

## 📊 Tabel Kondisi Notifikasi

| Kondisi | Status Task | Deadline | wa_notified | Notifikasi? |
|---------|-------------|----------|-------------|-------------|
| Task baru dibuat | Pending | Besok 10:00 | false | ❌ Belum (deadline belum lewat) |
| Deadline lewat 10 menit | Pending | Kemarin 17:00 | false | ✅ **KIRIM SEKARANG** |
| Sudah di-notifikasi | Pending | Kemarin 17:00 | true | ❌ Tidak (sudah pernah kirim) |
| Task selesai tepat waktu | Done | Tadi 17:00 | false | ❌ Tidak (status done) |
| Task selesai terlambat | Done | Kemarin 17:00 | true | ❌ Tidak (status done) |
| Deadline hari ini jam 18:00 | Pending | Hari ini 18:00 | false | ❌ Belum (sekarang jam 15:00) |

---

## 🕐 Interval Pengecekan

Cronjob berjalan **setiap 10 menit**:
```
00:00, 00:10, 00:20, 00:30, 00:40, 00:50
01:00, 01:10, 01:20, 01:30, 01:40, 01:50
...
23:00, 23:10, 23:20, 23:30, 23:40, 23:50
```

**Contoh**:
- Deadline: **17:05**
- Pengecekan terdekat: **17:10**
- Notifikasi terkirim: **17:10** (5 menit setelah deadline)

**Catatan**: Notifikasi bisa terkirim **0-10 menit** setelah deadline, tergantung waktu cronjob terdekat.

---

## 📱 Format Pesan WhatsApp

Ketika notifikasi terkirim, pesan yang dikirim:

```
⏰ *Reminder Task!*

👤 *User:* Nama User
📋 *Task:* Judul Task
📅 *Deadline:* 06/02/2026 17:00

📝 *Deskripsi:* Detail task (jika ada)

Segera dikerjakan ya! 🚀

---
DailyTask App
```

---

## 🔄 Siklus Lengkap Task

```
1. User buat task
   ↓
2. Deadline belum lewat → Cronjob SKIP
   ↓
3. Deadline lewat → Task jadi OVERDUE
   ↓
4. Cronjob cek (menit ke-0, 10, 20, 30, 40, 50)
   ↓
5. Task overdue & belum notified → KIRIM NOTIFIKASI ✅
   ↓
6. Update wa_notified = true
   ↓
7. Cronjob berikutnya → SKIP (sudah notified)
   ↓
8. User selesaikan task → Status = Done
   ↓
9. Cronjob berikutnya → SKIP (status done)
```

---

## 🧪 Testing Notifikasi

### **Test 1: Buat Task Overdue**

```bash
php artisan tinker
```

```php
// Buat task dengan deadline 1 jam yang lalu
$user = \App\Models\User::first();

\App\Models\Task::create([
    'user_id' => $user->id,
    'title' => 'Test Notifikasi Overdue',
    'description' => 'Testing reminder system',
    'due_date' => now()->subHour()->toDateString(),
    'due_time' => now()->subHour()->format('H:i'),
    'status' => 'pending',
    'wa_notified' => false
]);

exit
```

```bash
# Jalankan command
php artisan tasks:send-reminders
```

**Output yang diharapkan**:
```
🔍 Checking for overdue tasks...
⏰ Current time: 2026-02-06 23:50:00
📋 Total pending tasks (not notified): 1
   - Task #9: Test Notifikasi Overdue
     Due: 2026-02-06 22:50:00 | Overdue: YES ✅
📤 Found 1 overdue task(s). Sending reminders...
📨 Sending reminder to [Nomor Penerima] for task: Test Notifikasi Overdue
✅ Reminder sent successfully!

📊 Summary:
   ✅ Success: 1
   ❌ Failed: 0
```

### **Test 2: Task Belum Overdue**

```bash
php artisan tinker
```

```php
// Buat task dengan deadline besok
$user = \App\Models\User::first();

\App\Models\Task::create([
    'user_id' => $user->id,
    'title' => 'Test Task Besok',
    'description' => 'Deadline besok',
    'due_date' => now()->addDay()->toDateString(),
    'due_time' => '10:00',
    'status' => 'pending',
    'wa_notified' => false
]);

exit
```

```bash
# Jalankan command
php artisan tasks:send-reminders
```

**Output yang diharapkan**:
```
🔍 Checking for overdue tasks...
⏰ Current time: 2026-02-06 23:50:00
📋 Total pending tasks (not notified): 1
   - Task #10: Test Task Besok
     Due: 2026-02-07 10:00:00 | Overdue: NO ❌
✅ No overdue tasks found.
```

---

## 📝 Kesimpulan

**Notifikasi WhatsApp akan terkirim ketika**:
1. ✅ Task status **Pending** (belum selesai)
2. ✅ Deadline **sudah lewat** (overdue)
3. ✅ **Belum pernah** di-notifikasi sebelumnya
4. ✅ Cronjob berjalan (setiap 10 menit)

**Notifikasi TIDAK akan terkirim jika**:
- ❌ Deadline belum lewat
- ❌ Task sudah selesai (status = done)
- ❌ Sudah pernah di-notifikasi sebelumnya
- ❌ Cronjob tidak aktif

**Frekuensi**: **1 kali per task** (tidak berulang)

**Penerima**: Nomor yang dikonfigurasi di **Settings → WhatsApp Gateway → Nomor Penerima Notifikasi**

---

**💡 Tips**: Untuk reminder berkala (misalnya setiap hari), Anda perlu membuat task baru setiap hari atau mengembangkan fitur recurring task.
