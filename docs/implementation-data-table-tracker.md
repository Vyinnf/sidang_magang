# Tracker Implementasi Pengelolaan Data Tabel

Dokumen ini dipakai untuk melacak progres implementasi fitur pengelolaan data pada seluruh halaman index yang memiliki tabel.

## Aturan Umum (Standar Wajib)

Setiap halaman index tabel harus memiliki:

-   Pencarian keyword server-side (`q`)
-   Filter domain (`status`, `role`, `asn`, dll sesuai modul)
-   Sorting (`sort`, `dir`) dengan whitelist kolom
-   Pilihan jumlah data per halaman (`per_page`: 10/25/50/100)
-   Pagination yang mempertahankan query (`withQueryString()`)
-   Tombol reset filter
-   Validasi input filter/sort/per_page
-   Empty-state yang informatif

## Definisi Selesai (DoD)

Suatu task dianggap selesai jika:

1. Controller `index()` sudah mendukung query param standar.
2. View index memiliki toolbar filter + reset.
3. Sort aman dengan whitelist kolom (tanpa raw input langsung ke `orderBy`).
4. Pagination mempertahankan parameter filter.
5. Minimal 1 skenario pencarian + 1 skenario filter tervalidasi manual.

## Parameter Standar

-   `q`: keyword pencarian
-   `sort`: kolom sort
-   `dir`: `asc|desc`
-   `per_page`: `10|25|50|100`
-   `from`: tanggal awal (opsional)
-   `to`: tanggal akhir (opsional)

Parameter domain (opsional sesuai modul):

-   `status`
-   `role`
-   `unit_kerja_id`
-   `asn`
-   `golongan_id`

## Backlog Implementasi

### Phase 1 - Fondasi

-   [x] Tetapkan standar query tabel (helper/trait/request pattern)
-   [x] Desain UI filter reusable (partial Blade)

### Phase 2 - Operator (prioritas utama)

-   [x] Operator: Permohonan SK
-   [x] Operator: Daftar Pegawai
-   [x] Operator: Riwayat GBK
-   [x] Operator: Kenaikan Pangkat
-   [x] Operator: SK Pengangkatan
-   [x] Operator: Riwayat Kenaikan Pangkat

### Phase 3 - Admin

-   [ ] Admin: Users
-   [ ] Admin: Gaji
-   [ ] Admin: Unit Kerja
-   [ ] Admin: Golongan
-   [ ] Admin: Contact Messages (extend filter + search)

### Phase 4 - Pegawai

-   [ ] Pegawai: Permohonan SK
-   [ ] Pegawai: Riwayat GBK
-   [ ] Pegawai: Permohonan Kenaikan Pangkat
-   [ ] Pegawai: Riwayat Kenaikan Pangkat

### Phase 5 - Fitur Lanjutan

-   [ ] Export CSV per modul (mengikuti filter aktif)
-   [ ] Bulk action aman (minimal untuk status/hapus data yang memenuhi syarat)
-   [ ] Optimasi index database untuk kolom yang sering difilter/disort

### Phase 6 - QA & Dokumentasi

-   [ ] Testing regresi dan UAT
-   [ ] Dokumentasi penggunaan filter per modul
-   [ ] Handover ke tim

## Matriks Kebutuhan per Halaman

### Operator - Permohonan SK

-   Search: nama pegawai
-   Filter: status, tanggal pengajuan (`from`-`to`)
-   Sort: tanggal pengajuan, status

### Operator - Daftar Pegawai

-   Search: nama, NIP, jabatan
-   Filter: ASN, golongan
-   Sort: nama, golongan, tanggal dibuat

### Operator - Riwayat GBK

-   Search: nama, nomor SK
-   Filter: status SK, rentang TMT
-   Sort: TMT SK, tanggal SK, gaji baru

### Operator - Kenaikan Pangkat

-   Search: nama pegawai
-   Filter: status, tanggal pengajuan
-   Sort: tanggal pengajuan, status

### Operator - SK Pengangkatan

-   Search: nama pegawai, NIP, nomor SK, pejabat SK
-   Filter: ASN, rentang tanggal SK
-   Sort: tanggal SK, TMT, nomor SK

### Operator - Riwayat Kenaikan Pangkat

-   Search: nama pegawai, NIP, nomor SK
-   Filter: status SK, rentang TMT
-   Sort: TMT SK, tanggal SK, status SK

### Admin - Users

-   Search: nama, email
-   Filter: role, unit kerja
-   Sort: nama, role, created_at

### Admin - Gaji

-   Search: golongan
-   Filter: ASN, golongan, masa kerja (range)
-   Sort: golongan, masa kerja, gaji pokok

### Admin - Unit Kerja

-   Search: nama unit kerja
-   Sort: nama unit kerja

### Admin - Golongan

-   Search: golongan, pangkat
-   Filter: ASN
-   Sort: golongan, pangkat

### Pegawai - Permohonan SK

-   Filter: status, tanggal pengajuan
-   Sort: tanggal pengajuan

### Pegawai - Riwayat GBK

-   Search: nomor SK
-   Filter: status SK, rentang TMT
-   Sort: TMT SK, tanggal SK

### Pegawai - Permohonan Kenaikan Pangkat

-   Filter: status, tanggal pengajuan
-   Sort: tanggal pengajuan

### Pegawai - Riwayat Kenaikan Pangkat

-   Filter: status SK, rentang tanggal
-   Sort: TMT SK, tanggal SK

## Catatan Implementasi

-   Prioritaskan modul operator terlebih dahulu karena volume kerja harian tertinggi.
-   Gunakan satu pola query agar mudah maintain.
-   Pastikan semua query relation tetap menggunakan eager loading untuk menghindari N+1.
