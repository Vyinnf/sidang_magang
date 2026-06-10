@extends('layouts.app')
@section('title', 'Panduan Penggunaan Operator')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Panduan Penggunaan (Operator)</h2>
                                <small class="text-muted">Ikhtisar alur kerja & fungsi tiap modul</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-semibold mb-3">1. Konsep Peran & Akses</h5>
                    <p class="mb-2">Aplikasi memiliki tiga peran utama:</p>
                    <ul class="mb-3">
                        <li><strong>Admin</strong>: Kelola master data (User, Unit Kerja, Golongan, Gaji Pokok).</li>
                        <li><strong>Operator</strong>: Memproses permohonan (SK Gaji Berkala & Kenaikan Pangkat), mengelola
                            data pegawai & template SK.</li>
                        <li><strong>Pegawai</strong>: Mengajukan permohonan & melihat riwayat (Gaji Berkala dan Kenaikan
                            Pangkat) serta data pribadi.</li>
                    </ul>

                    <h5 class="fw-semibold mb-3">2. Data Pegawai</h5>
                    <p>Menu <strong>Manajemen Pegawai</strong> digunakan untuk melihat / memperbarui data pegawai. Field
                        penting termasuk <em>Golongan</em>, <em>NIP</em>, dan tanggal yang menjadi dasar siklus SK Gaji
                        Berkala.</p>

                    <h5 class="fw-semibold mb-3">3. SK Pengangkatan</h5>
                    <p>Bagian ini menyimpan dan menampilkan SK awal pengangkatan (CPNS / PPPK). Dokumen ini dapat diunduh
                        kembali dan menjadi referensi dasar status pegawai.</p>

                    <h5 class="fw-semibold mb-3">4. SK Gaji Berkala</h5>
                    <p>Alur umum:</p>
                    <ol class="mb-3">
                        <li><strong>Pegawai</strong> mengajukan permohonan SK Gaji Berkala melalui menu Permohonan.</li>
                        <li><strong>Operator</strong> meninjau permohonan: cek data, dokumen pendukung (jika ada), dan
                            validitas golongan/gaji.</li>
                        <li>Operator melakukan <em>proses</em> & dapat mencetak / mengunduh SK (menggunakan template bila
                            tersedia).</li>
                        <li>Riwayat tersimpan pada modul <strong>Riwayat Gaji Berkala</strong> dan akan memengaruhi tanggal
                            siklus berikutnya.</li>
                    </ol>
                    <p>Kelengkapan SK mencakup: nomor SK, pejabat penandatangan, TMT SK baru & lama, golongan lama → baru,
                        masa kerja & gaji pokok lama → baru.</p>

                    <h5 class="fw-semibold mb-3">5. Kenaikan Pangkat</h5>
                    <p>Modul ini memfasilitasi pengajuan kenaikan pangkat terstruktur:</p>
                    <ol class="mb-3">
                        <li><strong>Pegawai</strong> mengisi formulir permohonan kenaikan pangkat & mengunggah dokumen
                            pendukung.</li>
                        <li><strong>Operator</strong> meninjau (status: diajukan → diproses).</li>
                        <li>Operator dapat <strong>approve</strong> atau <strong>reject</strong> dengan alasan.</li>
                        <li>Riwayat kenaikan pangkat tersimpan terpisah & dapat dilihat di menu Riwayat Pangkat.</li>
                    </ol>

                    <h5 class="fw-semibold mb-3">6. Template SK</h5>
                    <p>Digunakan untuk mengelola file template (misal DOCX) yang akan dipakai ketika mencetak atau
                        menghasilkan SK. Operator dapat mengunggah, memperbarui, atau menghapus template. Template yang
                        benar mempercepat proses penerbitan SK.</p>

                    <div class="alert alert-info small">
                        <strong>Kriteria Template SK yang Dapat Digunakan</strong>
                        <ul class="mt-2 mb-0">
                            <li><strong>Format file:</strong> wajib <code>.docx</code> (bukan .doc, .pdf, atau format lain).
                            </li>
                            <li><strong>Tidak mengandung macro</strong> / fitur keamanan Word yang menghalangi pemrosesan
                                otomatis.</li>
                            <li><strong>Gunakan placeholder</strong> persis sesuai daftar di bawah (case sensitive) agar
                                sistem bisa menggantinya.</li>
                            <li><strong>Placeholder ditulis dengan sintaks</strong> <code>${nama_placeholder}</code>
                                (standar PhpWord TemplateProcessor).</li>
                            <li>Hindari pemformatan rumit (nested table kompleks) di sekitar placeholder untuk meminimalkan
                                risiko salah render.</li>
                            <li>Jika ingin baris otomatis hilang saat nilai kosong, letakkan placeholder sendirian dalam
                                paragraf (Word akan menyisakan baris kosong jika ada teks lain).</li>
                        </ul>
                        <hr class="my-2">
                        <p class="mb-1"><strong>Daftar placeholder yang saat ini didukung:</strong></p>
                        <div class="row g-2 small">
                            <div class="col-md-4">
                                <ul class="mb-0">
                                    <li><code>${nama}</code></li>
                                    <li><code>${tanggal_lahir}</code></li>
                                    <li><code>${nip}</code></li>
                                    <li><code>${pangkat}</code></li>
                                    <li><code>${golongan}</code></li>
                                    <li><code>${jabatan}</code></li>
                                    <li><code>${unit_kerja}</code></li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <ul class="mb-0">
                                    <li><code>${nomor_sk_lama}</code></li>
                                    <li><code>${tanggal_sk_lama}</code></li>
                                    <li><code>${tmt_lama}</code></li>
                                    <li><code>${pejabat_sk_lama}</code></li>
                                    <li><code>${gaji_lama}</code></li>
                                    <li><code>${gaji_baru}</code></li>
                                    <li><code>${tmt_baru}</code></li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <ul class="mb-0">
                                    <li><code>${mkg_lama_tahun}</code></li>
                                    <li><code>${mkg_lama_bulan}</code></li>
                                    <li><code>${mkg_baru_tahun}</code></li>
                                    <li><code>${mkg_baru_bulan}</code></li>
                                </ul>
                            </div>
                        </div>
                        <p class="mt-2 mb-1"><strong>Contoh Penggunaan di Word:</strong></p>
                        <pre class="bg-light p-2 small mb-0">Nomor SK Lama : ${nomor_sk_lama}
Nama Pegawai   : ${nama}
NIP            : ${nip}
Golongan/Pangkat : ${golongan} / ${pangkat}
Gaji Lama      : Rp ${gaji_lama}
Gaji Baru      : Rp ${gaji_baru}
TMT Baru       : ${tmt_baru}</pre>
                    </div>

                    <h5 class="fw-semibold mb-3">7. Riwayat (Audit)</h5>
                    <p>Dua jenis riwayat utama:</p>
                    <ul class="mb-3">
                        <li><strong>Riwayat Gaji Berkala</strong>: Mencatat setiap perubahan gaji berkala dengan referensi
                            golongan & masa kerja.</li>
                        <li><strong>Riwayat Pangkat</strong>: Mencatat hasil akhir permohonan kenaikan pangkat.</li>
                    </ul>
                    <p>Keduanya membantu pelacakan perjalanan karier & validasi historis.</p>

                    <h5 class="fw-semibold mb-3">8. Status Permohonan</h5>
                    <p>Status yang umum digunakan (SK Gaji Berkala & Kenaikan Pangkat):</p>
                    <ul class="mb-3">
                        <li><span class="badge bg-secondary">diajukan</span>: Baru dibuat pegawai.</li>
                        <li><span class="badge bg-info">diproses</span>: Sedang ditinjau operator.</li>
                        <li><span class="badge bg-success">disetujui / disetujui (pangkat)</span>: Telah disahkan.</li>
                        <li><span class="badge bg-danger">ditolak</span>: Tidak disetujui (biasanya dengan alasan).</li>
                    </ul>

                    <h5 class="fw-semibold mb-3">9. Best Practice Operator</h5>
                    <ul class="mb-3">
                        <li>Periksa konsistensi golongan & masa kerja sebelum approve.</li>
                        <li>Pastikan template SK terbaru sebelum memproses banyak permohonan.</li>
                        <li>Gunakan riwayat untuk validasi klaim pegawai.</li>
                        <li>Selesaikan permohonan status <em>diajukan</em> secara berkala agar tidak menumpuk.</li>
                    </ul>

                    <h5 class="fw-semibold mb-3">10. Fitur Mendatang (Rencana)</h5>
                    <ul class="mb-0 text-muted small">
                        <li>Pengingat otomatis kenaikan gaji berkala via email.</li>
                        <li>Notifikasi in-app & log aktivitas.</li>
                        <li>Dashboard analitik (grafik tren permohonan).</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection
