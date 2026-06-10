@extends('layouts.app')
@section('title', 'Panduan Penggunaan Pegawai')
@section('content')
<div class="pc-container">
  <div class="pc-content">
    <div class="page-header mb-4">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <div class="page-header-title">
              <h2 class="mb-0 fw-bold">Panduan Penggunaan (Pegawai)</h2>
              <small class="text-muted">Cara menggunakan layanan & memantau karier</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
      <div class="card-body">
        <h5 class="fw-semibold mb-3">1. Dashboard</h5>
        <p>Menampilkan ringkasan riwayat gaji berkala, status pengajuan, dan informasi penting lain terkait jadwal.</p>

        <h5 class="fw-semibold mb-3">2. Data Pribadi</h5>
        <p>Periksa & perbarui data (NIP, jabatan, tempat & tanggal lahir). Pastikan akurat karena menjadi dasar pencetakan SK & validasi permohonan.</p>

        <h5 class="fw-semibold mb-3">3. Riwayat Gaji Berkala</h5>
        <p>Menampilkan daftar SK Gaji Berkala yang telah diterbitkan. Gunakan untuk memastikan perhitungan berikutnya benar.</p>

        <h5 class="fw-semibold mb-3">4. Mengajukan SK Gaji Berkala</h5>
        <ol class="mb-3">
          <li>Buka menu <strong>Permohonan &gt; SK Gaji Berkala</strong>.</li>
          <li>Isi data yang diminta (pastikan data personal sudah benar).</li>
          <li>Kirim permohonan dan pantau status (diajukan → diproses → disetujui / ditolak).</li>
          <li>Setelah disetujui, SK dapat diunduh dan akan masuk ke riwayat.</li>
        </ol>

        <h5 class="fw-semibold mb-3">5. Permohonan Kenaikan Pangkat</h5>
        <ol class="mb-3">
          <li>Buka menu <strong>Permohonan &gt; Kenaikan Pangkat</strong>.</li>
          <li>Unggah dokumen pendukung (format sesuai ketentuan).</li>
          <li>Pantau status sampai disetujui.</li>
          <li>Hasil akhir tercatat di Riwayat Pangkat.</li>
        </ol>

        <h5 class="fw-semibold mb-3">6. Riwayat Pangkat</h5>
        <p>Mencatat setiap perubahan pangkat resmi. Berguna untuk melihat progres karier & evaluasi masa kerja.</p>

        <h5 class="fw-semibold mb-3">7. Keamanan Akun</h5>
        <ul class="mb-3">
          <li>Ganti password berkala.</li>
          <li>Pastikan email aktif (untuk penerimaan notifikasi mendatang).</li>
          <li>Jaga kerahasiaan kredensial.</li>
        </ul>

        <h5 class="fw-semibold mb-3">8. Status Permohonan (Referensi)</h5>
        <ul class="mb-3">
          <li><span class="badge bg-secondary">diajukan</span>: Baru dikirim.</li>
          <li><span class="badge bg-info">diproses</span>: Ditinjau operator.</li>
          <li><span class="badge bg-success">disetujui</span>: Selesai, dokumen dapat diunduh.</li>
          <li><span class="badge bg-danger">ditolak</span>: Tidak diterima (perbaiki & ajukan ulang bila memungkinkan).</li>
        </ul>

        <h5 class="fw-semibold mb-3">9. Tips</h5>
        <ul class="mb-3">
          <li>Pastikan data profil lengkap sebelum mengajukan.</li>
          <li>Pantau tanggal siklus gaji berkala (akan ada fitur pengingat).</li>
          <li>Simpan salinan SK penting.</li>
        </ul>

        <h5 class="fw-semibold mb-3">10. Fitur Mendatang</h5>
        <ul class="mb-0 text-muted small">
          <li>Pengingat email gaji berkala.</li>
          <li>Notifikasi di dalam aplikasi.</li>
          <li>Riwayat aktivitas login.</li>
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection
