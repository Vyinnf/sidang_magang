# Testing Manual Reminder KGB

## Data Preparation

-   Pastikan ada minimal 1 user role pegawai dengan relasi pegawai (kolom `tanggal_kenaikan_gaji_berkala_berikutnya` tidak null).
-   Catat ID pegawai dan email user terkait.

## Skenario 1: Window 30 Hari (Dry Run)

1. Set kolom `tanggal_kenaikan_gaji_berkala_berikutnya` ke tanggal = today + 30.
2. Jalankan: `php artisan reminder:kgb --dry-run`.
3. EXPECT: Output berisi `[DRY] Akan kirim reminder ... window 30`.

## Skenario 2: Kirim Nyata & Idempotensi

1. Jalankan: `php artisan reminder:kgb`.
2. EXPECT: Output total dikirim minimal 1.
3. Jalankan ulang command sama.
4. EXPECT: Total dikirim 0 (log mencegah duplikasi).
5. Cek DB: `reminder_gaji_logs` terdapat baris dengan window=30.
6. Cek DB: `notifications` ada baris type `App\\Notifications\\KenaikanGajiBerkalaReminder`.

## Skenario 3: Window 7 Hari

1. Ubah tanggal ke today + 7.
2. Jalankan dry-run -> harus muncul window 7.
3. Jalankan kirim -> log baru (window=7) tercatat.

## Skenario 4: Window 1 Hari

Ulangi pola seperti 7 hari dengan today + 1.

## Skenario 5: Multi Pegawai

1. Set 2 pegawai berbeda ke tanggal TMT sama 30 hari lagi.
2. Jalankan command -> keduanya harus menerima (2 log baru, 2 notifications).

## Skenario 6: Feature Flag Off

1. Set `.env` `REMINDER_KGB_ENABLED=false`.
2. Jalankan `php artisan config:clear`.
3. Jalankan command -> EXPECT: pesan dinonaktifkan, tidak ada pengiriman.

## Skenario 7: Queue (Async)

1. Set `.env` `QUEUE_CONNECTION=database`.
2. Jalankan migrasi queue (sudah ada jobs table).
3. Jalankan `php artisan queue:work` di terminal terpisah.
4. Jalankan `php artisan reminder:kgb`.
5. EXPECT: Job masuk queue, email dikirim oleh worker.

## Skenario 8: Konkurensi (Race Condition) Simulasi Manual

1. Jalankan dua terminal hampir bersamaan: `php artisan reminder:kgb`.
2. EXPECT: Bisa jadi 1 log insert sukses, lainnya skip karena unique constraint (jika duplicate attempt). Tidak terjadi double notifikasi.

## Skenario 9: Validasi Data Hilang

1. Set salah satu pegawai `tanggal_kenaikan_gaji_berkala_berikutnya` null.
2. Jalankan command -> Pegawai tersebut di-skip (tidak error).

## Skenario 10: Observasi Notifikasi Database

Buat halaman (opsional) menampilkan `$user->notifications` untuk memverifikasi konten `data` termasuk field window_hari.

## Catatan

-   Command tidak mengubah tanggal TMT, hanya membaca dan mengirim.
-   Bila diperlukan resend manual, hapus baris terkait di `reminder_gaji_logs` lalu jalankan lagi.
