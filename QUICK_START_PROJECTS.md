# 🚀 Quick Start - Fitur Project Management

## Langkah Cepat untuk Mulai Menggunakan

### 1. Database Sudah Siap ✅
Migration sudah dijalankan. Tabel `projects` dan kolom `project_id` di `tasks` sudah tersedia.

### 2. Akses Fitur Project

#### Dari Dashboard:
1. Login ke aplikasi
2. Di dashboard, klik tombol **"Kelola Projects"** (warna hijau)
3. Atau scroll ke bawah, lihat section **"Projects Terbaru"**

#### Langsung ke Projects:
- URL: `http://localhost/dailytask/projects`

### 3. Buat Project Pertama

1. Klik **"Tambah Project"**
2. Isi form:
   - **Nama Project**: (wajib) - Contoh: "Website Redesign"
   - **Deskripsi**: (opsional) - Contoh: "Redesign website company"
   - **Status**: Pilih "Aktif"
   - **Tanggal Mulai**: (opsional) - Pilih tanggal
   - **Tanggal Selesai**: (opsional) - Pilih tanggal
3. Klik **"Simpan Project"**

### 4. Tambah Task ke Project

#### Cara 1: Dari Halaman Task
1. Klik **"Tambah Task Baru"** di dashboard
2. Isi judul, deskripsi, tanggal, waktu
3. **Pilih Project** dari dropdown (field baru!)
4. Klik **"Simpan Task"**

#### Cara 2: Dari Detail Project
1. Buka detail project (klik "Lihat Detail")
2. Klik **"Tambah Task"**
3. Project otomatis terpilih
4. Isi form dan simpan

### 5. Lihat Progress Project

#### Di Halaman Projects:
- Setiap card project menampilkan:
  - Progress bar dengan persentase
  - Total tasks, Selesai, Pending
  - Status project

#### Di Dashboard:
- Section "Projects Terbaru" menampilkan:
  - 5 project terbaru
  - Progress masing-masing
  - Quick stats

#### Di Detail Project:
- Progress bar besar
- Stats lengkap
- Daftar semua task

### 6. Update Progress

Progress **otomatis** terupdate saat:
- Task baru ditambahkan
- Task di-mark sebagai "Done"
- Task dihapus

**Tidak perlu manual update!**

### 7. Kelola Project

#### Edit Project:
1. Buka halaman Projects
2. Klik icon **Edit** (pensil) di card project
3. Update informasi
4. Klik "Update Project"

#### Hapus Project:
1. Buka halaman Projects
2. Klik icon **Delete** (tempat sampah) di card project
3. Konfirmasi hapus
4. **Catatan**: Semua task dalam project juga akan terhapus!

### 8. Filter & Organize

#### By Status:
- **Aktif**: Project yang sedang berjalan
- **Selesai**: Project yang sudah completed
- **Ditunda**: Project yang di-hold sementara

#### By Progress:
- Lihat progress bar untuk prioritas
- Project dengan progress rendah mungkin perlu perhatian

## 💡 Tips Penggunaan

### Untuk Produktivitas Maksimal:

1. **Buat Project untuk Setiap Inisiatif Besar**
   - Contoh: "Q1 Marketing", "Product Launch", "Office Move"

2. **Breakdown Project ke Tasks**
   - Setiap project punya multiple tasks
   - Task lebih spesifik dan actionable

3. **Monitor Progress Rutin**
   - Cek dashboard setiap hari
   - Lihat project mana yang stuck

4. **Gunakan Status dengan Bijak**
   - "Aktif" = sedang dikerjakan
   - "Ditunda" = temporarily paused
   - "Selesai" = completed & archived

5. **Set Realistic Deadlines**
   - Gunakan tanggal mulai & selesai
   - Bantu tracking timeline

## 📱 Fitur Bonus

### WhatsApp Reminder
Task dalam project tetap dapat WhatsApp reminder jika overdue!

### Dashboard Summary
Quick overview semua project di satu tempat.

### Responsive Design
Akses dari mobile, tablet, atau desktop - semua responsive!

## 🎯 Use Cases

### Use Case 1: Development Team
```
Project: "Mobile App v2.0"
├── Task: Design UI mockups
├── Task: Setup backend API
├── Task: Implement authentication
├── Task: Testing & QA
└── Task: Deploy to production
```

### Use Case 2: Marketing Team
```
Project: "Product Launch Campaign"
├── Task: Create landing page
├── Task: Prepare social media content
├── Task: Email campaign setup
├── Task: Influencer outreach
└── Task: Analytics tracking
```

### Use Case 3: Personal Projects
```
Project: "Home Renovation"
├── Task: Get contractor quotes
├── Task: Buy materials
├── Task: Paint living room
├── Task: Install new fixtures
└── Task: Final cleanup
```

## ❓ FAQ

**Q: Apakah task harus punya project?**
A: Tidak, task bisa standalone (tanpa project).

**Q: Bisa pindah task ke project lain?**
A: Ya, edit task dan pilih project baru.

**Q: Progress dihitung bagaimana?**
A: (Completed Tasks / Total Tasks) × 100%

**Q: Bisa hapus project tanpa hapus tasks?**
A: Tidak, cascade delete. Task akan ikut terhapus.

**Q: Limit berapa project?**
A: Tidak ada limit, buat sebanyak yang diperlukan.

## 🆘 Troubleshooting

**Problem**: Dropdown project tidak muncul di form task
**Solution**: Pastikan sudah buat minimal 1 project dulu

**Problem**: Progress tidak update
**Solution**: Refresh halaman, progress dihitung real-time

**Problem**: Tidak bisa hapus project
**Solution**: Pastikan Anda owner project tersebut

---

## 🎉 Selamat Menggunakan!

Fitur project management siap digunakan. Mulai organize tasks Anda dengan lebih baik!

**Need Help?** Lihat dokumentasi lengkap di:
- `PROJECT_MANAGEMENT_FEATURE.md` (English)
- `RINGKASAN_PROJECT_MANAGEMENT.md` (Bahasa Indonesia)
