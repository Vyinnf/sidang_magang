# Digitalisasi Gaji Berkala (DIGAJI)

DIGAJI adalah aplikasi internal berbasis Laravel untuk mendigitalisasi proses Kenaikan Gaji Berkala (KGB) dan dokumen kepegawaian terkait. Proyek ini mendukung alur kerja multi-peran (admin, operator, pegawai), pengelolaan data pegawai, pengajuan dan pemrosesan SK, pengelolaan template SK, serta pengingat otomatis KGB melalui notifikasi email dan database.

## ✨ Fitur Utama

-   Autentikasi & Notifikasi

    -   Login/Logout; daftar notifikasi, tandai terbaca/semua terbaca.
    -   Notifikasi Reminder KGB terkirim via database dan email (antrian/queue didukung).

-   Manajemen Peran & Akses (Role-Based Access)

    -   Admin: `admin/*`
    -   Operator: `operator/*`
    -   Pegawai: `pegawai/*`
    -   Middleware `role:{admin|operator|pegawai}` memastikan akses sesuai peran.

-   Admin

    -   Dashboard admin.
    -   Master data: Unit Kerja, Golongan, Matriks Gaji (CRUD).
    -   Manajemen User (CRUD) dan relasi ke Unit Kerja.
    -   Kotak Masuk Pesan Kontak: lihat/detail/hapus.
    -   Halaman panduan admin.

-   Operator

    -   Dashboard operator.
    -   Manajemen Pegawai (CRUD), termasuk rute khusus pembuatan data pegawai lama.
    -   Riwayat KGB: lihat/edit/hapus, unduh SK.
    -   Permohonan SK (GBK): daftar, detail, proses, cetak SK (DOCX), unduh, hapus.
    -   SK Pengangkatan: lihat/edit, unduh.
    -   Template SK GBK: unggah/kelola template, unduh.
    -   Kenaikan Pangkat: daftar/detail, proses, approve/reject, unduh SK.
    -   Riwayat Kenaikan Pangkat: daftar/detail, unduh.
    -   Instan GBK: proses cepat dan cetak SK.
    -   Halaman panduan operator.

-   Pegawai

    -   Dashboard pegawai.
    -   Profil: lihat/ubah data, unggah foto profil, ganti email/kata sandi.
    -   Riwayat KGB: daftar/detail, edit ringkas, unduh SK.
    -   Permohonan SK (GBK): buat pengajuan, lihat status, unduh SK.
    -   Pengajuan Kenaikan Pangkat: buat pengajuan, lihat status, unduh SK.
    -   Riwayat Kenaikan Pangkat: daftar/detail, unduh.
    -   Detail gaji dan riwayat gaji.
    -   Halaman panduan pegawai.

-   Pengingat Otomatis KGB (Scheduler)

    -   Perintah terjadwal harian pukul 07:00: `reminder:kgb`.
    -   Jendela pengingat: H-30, H-7, H-1 dari tanggal TMT berikutnya (`tanggal_kenaikan_gaji_berkala_berikutnya`).
    -   Idempotensi: log pengiriman di tabel `reminder_gaji_logs` mencegah duplikasi.
    -   Dapat dijalankan sebagai dry-run untuk uji coba.

-   Penyimpanan Dokumen Privat

    -   Penyimpanan dokumen di `storage/app/private` (disk `local`).
    -   Struktur folder per Unit Kerja dan User untuk: foto profil, SK GBK, SK Pengangkatan, SK Kenaikan Pangkat, Template SK.
    -   Layanan `FileStorageService` untuk unggah/unduh/akses/hapus dokumen.

-   Pembuatan Dokumen SK (DOCX)

    -   Menggunakan `phpoffice/phpword` untuk komposisi SK dari template.

-   Form Kontak Publik
    -   Endpoint publik untuk mengirim pesan ke admin (kotak masuk admin).

## 🧩 Teknologi & Arsitektur

-   Framework: Laravel 12 (PHP >= 8.2)
-   Database: SQLite (default) — dapat diganti MySQL/PostgreSQL
-   Frontend bundler: Vite
-   Queue: Database queue (opsional, direkomendasikan untuk email/notifikasi)
-   Notifikasi: Database + Email (MailView: `emails.reminder_kgb`)
-   Penyimpanan: Disk `local` diarahkan ke `storage/app/private`
-   Library dokumen: `phpoffice/phpword`

Komponen penting:

-   Middleware `RoleMiddleware` untuk pembatasan akses berbasis peran.
-   Command `reminder:kgb` (kelas `App\Console\Commands\KirimReminderKGB`).
-   Scheduler harian di `App\Console\Kernel` (`dailyAt('07:00')`).
-   Service `App\Services\FileStorageService` untuk manajemen file privat.

## 🗺️ Rute Utama (Ringkas)

-   Publik: `/` (landing), `POST /contact` (form kontak)
-   Auth: `GET/POST /login`, `POST /logout`
-   Notifikasi: `GET /notifications`, `POST /notifications/mark-all-read`, `POST /notifications/{id}/mark-read`
-   Admin (prefix `admin/`): dashboard, CRUD Unit Kerja, Golongan, Gaji, Users, Panduan, Pesan Kontak
-   Operator (prefix `operator/`): Pegawai, Riwayat GBK, Permohonan SK, SK Pengangkatan, Template SK, Kenaikan Pangkat, Riwayat Kenaikan Pangkat, Instan GBK, Panduan
-   Pegawai (prefix `pegawai/`): Dashboard, Profil, Riwayat GBK, Permohonan SK, Pengajuan & Riwayat Kenaikan Pangkat, Keamanan

## 🧪 Pengujian Manual Reminder KGB

Panduan lengkap tersedia di `docs/testing-kgb.md` (dry-run, idempotensi, multi pegawai, queue, feature flag, dll.).

## ⚙️ Persyaratan Sistem

-   PHP 8.2+
-   Composer 2.x
-   Node.js 18+ dan npm 9+
-   SQLite (atau MySQL/PostgreSQL jika dikonfigurasi)

## 🚀 Setup Cepat (Windows PowerShell)

1. Clone dan masuk ke folder proyek

```powershell
git clone <repo-url> digaji; cd digaji
```

2. Instal dependency PHP dan Node

```powershell
composer install
npm install
```

3. Salin .env dan set kunci aplikasi

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

4. Konfigurasi database (default SQLite)

```powershell
New-Item -ItemType File -Path .\database\database.sqlite -Force | Out-Null
```

Di file `.env` pastikan set:

```
APP_NAME=DIGAJI
APP_URL=http://localhost
APP_LOCALE=id
APP_FALLBACK_LOCALE=id

DB_CONNECTION=sqlite
QUEUE_CONNECTION=database
FILESYSTEM_DISK=local
REMINDER_KGB_ENABLED=true

# Konfigurasi email (wajib untuk kirim notifikasi email)
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=youruser
MAIL_PASSWORD=yourpass
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@example.com
MAIL_FROM_NAME="DIGAJI"
```

5. Migrasi database dan buat symlink storage publik (opsional)

```powershell
php artisan migrate
php artisan storage:link
```

6. Jalankan aplikasi (opsi A: manual)

```powershell
php artisan serve
npm run dev
```

Opsi B (otomatis, paralel):

```powershell
composer run dev
```

Perintah di atas akan menjalankan server, queue listener, live logs, dan Vite secara bersamaan.

## ⏰ Menjalankan Reminder KGB

-   Jalankan sekali untuk uji coba (dry-run):

```powershell
php artisan reminder:kgb --dry-run
```

-   Jalankan pengiriman nyata (idempotent/logged):

```powershell
php artisan reminder:kgb
```

-   Menjalankan scheduler secara kontinu (opsi pengembangan):

```powershell
php artisan schedule:work
```

Catatan: Di produksi, jalankan scheduler via OS scheduler (mis. cron/Task Scheduler) setiap menit agar job harian dieksekusi tepat waktu.

## 🧰 Antrian (Queue)

Proyek ini sudah menyertakan migrasi tabel jobs (database queue). Untuk memproses email/notifikasi secara asynchronous jalankan worker:

```powershell
php artisan queue:work
```

Opsional: gunakan `composer run dev` agar worker berjalan otomatis bersama server.

## 🗂️ Penyimpanan Dokumen Privat

-   Disk `local` diarahkan ke `storage/app/private` (lihat `config/filesystems.php`).
-   Akses unduhan difasilitasi melalui service `FileStorageService` dan rute terproteksi.
-   Tipe folder yang didukung: `profile`, `sk-gbk`, `sk-pengangkatan`, `template-sk-gbk`, `sk-kenaikan-pangkat`.

## 👤 Peran & Alur

-   Admin menyiapkan master data (Unit Kerja, Golongan, Gaji) dan pengguna.
-   Operator mengelola data pegawai, memproses permohonan SK/kenaikan pangkat, mengelola template SK, dan mencetak/unduh SK.
-   Pegawai memperbarui profil, mengajukan permohonan SK/kenaikan pangkat, melihat riwayat, dan mengunduh dokumen.
-   Sistem mengirim reminder KGB secara otomatis pada H-30/H-7/H-1 (email + notifikasi dalam aplikasi).

## 🧪 Testing

-   Jalankan seluruh test:

```powershell
php artisan test
```

-   Panduan uji Reminder KGB: `docs/testing-kgb.md`.

## 🔐 Keamanan & Privasi

-   Dokumen hanya disajikan melalui rute terautentikasi; berkas tersimpan di direktori privat.
-   Notifikasi email memanfaatkan pengaturan SMTP yang Anda sediakan.

## 📝 Lisensi

Proyek ini menggunakan lisensi MIT. Lihat berkas lisensi jika tersedia atau sesuaikan sesuai kebutuhan organisasi Anda.

## 🙌 Kontribusi

Kontribusi sangat dihargai. Gunakan standar Laravel (Pint untuk styling), buat PR dengan deskripsi jelas, dan tambahkan test untuk perubahan yang memengaruhi perilaku publik.

—

Jika ada pertanyaan atau butuh bantuan, silakan buka issue atau hubungi tim pengembang internal.

Catatan tambahan: Untuk mengubah zona waktu aplikasi, sesuaikan nilai `'timezone'` di `config/app.php` (misal `Asia/Jakarta`).
