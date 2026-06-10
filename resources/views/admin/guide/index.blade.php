@extends('layouts.app')
@section('title', 'Panduan Penggunaan Admin')
@section('content')
<div class="pc-container">
  <div class="pc-content">
    <div class="page-header mb-4">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <div class="page-header-title">
              <h2 class="mb-0 fw-bold">Panduan Penggunaan (Admin)</h2>
              <small class="text-muted">Tanggung jawab & alur kerja peran Admin</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
      <div class="card-body">
        <h5 class="fw-semibold mb-3">1. Peran Admin</h5>
        <p>Admin bertugas memastikan seluruh master data dan otorisasi pengguna valid. Admin tidak memproses permohonan harian, namun memastikan operator & pegawai dapat menjalankan alur tanpa kendala.</p>

        <h5 class="fw-semibold mb-3">2. Manajemen Pengguna</h5>
        <ul class="mb-3">
          <li>Buat akun baru (role: <em>pegawai</em> atau <em>operator</em>).</li>
          <li>Reset atau ubah email pengguna jika diperlukan.</li>
          <li>Nonaktifkan (hapus) akun yang sudah tidak digunakan.</li>
        </ul>

        <h5 class="fw-semibold mb-3">3. Unit Kerja</h5>
        <p>Pastikan daftar Unit Kerja mutakhir. Data ini dipakai untuk pengelompokan pegawai dan memudahkan monitoring beban kerja operator.</p>

        <h5 class="fw-semibold mb-3">4. Golongan</h5>
        <p>Kelola golongan sesuai regulasi. Perubahan golongan memengaruhi validasi kenaikan gaji berkala dan kenaikan pangkat.</p>

        <h5 class="fw-semibold mb-3">5. Gaji Pokok</h5>
        <p>Master gaji pokok menjadi referensi saat operator memproses SK Gaji Berkala. Perbarui sesuai ketentuan terbaru agar SK yang diterbitkan akurat.</p>

        <h5 class="fw-semibold mb-3">6. Pengawasan Proses</h5>
        <ul class="mb-3">
          <li>Pantau volume permohonan (diajukan vs diproses vs disetujui).</li>
          <li>Koordinasikan dengan operator jika terjadi penumpukan status <em>diajukan</em>.</li>
          <li>Cek keseragaman format SK (melalui template yang dipakai operator).</li>
        </ul>

        <h5 class="fw-semibold mb-3">7. Integritas Data</h5>
        <ul class="mb-3">
          <li>Hindari penghapusan massal tanpa evaluasi.</li>
          <li>Pastikan setiap pegawai memiliki relasi user yang benar.</li>
          <li>Audit riwayat secara berkala (ketidakwajaran lonjakan gaji/pangkat).</li>
        </ul>

        <h5 class="fw-semibold mb-3">8. Status Permohonan (Referensi)</h5>
        <ul class="mb-3">
          <li><span class="badge bg-secondary">diajukan</span>: Baru masuk.</li>
          <li><span class="badge bg-info">diproses</span>: Ditangani operator.</li>
          <li><span class="badge bg-success">disetujui</span>: Final & terekam di riwayat.</li>
          <li><span class="badge bg-danger">ditolak</span>: Ditolak (biasanya disertai catatan).</li>
        </ul>

        <h5 class="fw-semibold mb-3">9. Rencana Pengembangan (Preview)</h5>
        <ul class="mb-0 text-muted small">
          <li>Log aktivitas & audit trail lanjutan.</li>
          <li>Ringkasan statistik permohonan per unit kerja.</li>
          <li>Pengingat otomatis kenaikan gaji berkala.</li>
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection
