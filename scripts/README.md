# Developer Utilities & Test Scripts

Folder ini berisi script utilitas manual untuk developer saat pengujian lokal:

- `php scripts/test-whatsapp.php` : Melakukan pengujian kirim pesan ke nomor WhatsApp via terminal.
- `php scripts/check_tasks.php` : Menampilkan ringkasan status semua task dan deadline di database.
- `php scripts/create_test_task.php` : Membuat sample task dengan status overdue untuk menguji notifikasi WhatsApp.

> **Catatan Keamanan:** File-file ini sengaja ditempatkan di dalam folder `scripts/` (terpisah dari document root) agar tidak dapat diakses atau dieksekusi secara publik via browser.
