@extends('layouts.app')

@section('title', 'Detail Riwayat Gaji Berkala')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Detail Riwayat Gaji Berkala</h2>
                                <small class="text-muted">Informasi detail SK dan perubahan gaji</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Detail -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="ti ti-file-text me-2"></i>Detail SK
                        </h5>
                        <span class="ms-3">
                            @if ($riwayat->status_sk === 'lengkap')
                                <span class="badge bg-success">Lengkap</span>
                            @else
                                <span class="badge bg-secondary">Tidak Lengkap</span>
                            @endif
                        </span>
                    </div>

                    @if ($riwayat->sk_path)
                        <a href="{{ route('pegawai.permohonan-sk.download', $riwayat->id) }}" target="_blank"
                            class="btn btn-sm btn-outline-primary">
                            <i class="ti ti-file"></i> Download SK
                        </a>
                    @else
                        <span class="text-muted small">Tidak ada file SK yang tersimpan.</span>
                    @endif
                </div>


                <div class="card-body">
                    <div class="row g-3">

                        <!-- SK Baru -->
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-2">SK Baru</h6>
                            <p class="mb-1"><strong>Nomor SK:</strong> {{ $riwayat->nomor_sk ?? '-' }}</p>
                            <p class="mb-1"><strong>Tanggal SK:</strong>
                                {{ $riwayat->tanggal_sk?->format('d F Y') ?? '-' }}</p>
                            <p class="mb-1"><strong>TMT SK:</strong> {{ $riwayat->tmt_sk?->format('d F Y') ?? '-' }}</p>
                            <p class="mb-1"><strong>Pejabat SK:</strong> {{ $riwayat->pejabat_sk ?? '-' }}</p>
                        </div>

                        <!-- SK Lama -->
                        <div class="col-md-6">
                            <h6 class="fw-bold text-secondary mb-2">SK Lama</h6>
                            <p class="mb-1"><strong>Nomor SK:</strong> {{ $riwayat->nomor_sk_lama ?? '-' }}</p>
                            <p class="mb-1"><strong>Tanggal SK:</strong>
                                {{ $riwayat->tanggal_sk_lama?->format('d F Y') ?? '-' }}</p>
                            <p class="mb-1"><strong>TMT SK:</strong> {{ $riwayat->tmt_sk_lama?->format('d F Y') ?? '-' }}
                            </p>
                            <p class="mb-1"><strong>Pejabat SK:</strong> {{ $riwayat->pejabat_sk_lama ?? '-' }}</p>
                        </div>

                        <!-- Perbandingan Gaji -->
                        <div class="col-12 mt-3">
                            <h6 class="fw-bold text-dark mb-2">Perubahan Gaji</h6>
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th></th>
                                        <th>Golongan</th>
                                        <th>Masa Kerja</th>
                                        <th>Gaji Pokok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="badge bg-secondary">Lama</span></td>
                                        <td>{{ $riwayat->golonganLama->golongan ?? '-' }}</td>
                                        <td>{{ $riwayat->masa_kerja_golongan_lama_tahun }} Thn
                                            {{ $riwayat->masa_kerja_golongan_lama_bulan }} Bln
                                        </td>
                                        <td>Rp {{ number_format($riwayat->gaji_pokok_lama, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge bg-primary">Baru</span></td>
                                        <td>{{ $riwayat->golonganBaru->golongan ?? '-' }}</td>
                                        <td>{{ $riwayat->masa_kerja_golongan_baru_tahun }} Thn
                                            {{ $riwayat->masa_kerja_golongan_baru_bulan }} Bln
                                        </td>
                                        <td>Rp {{ number_format($riwayat->gaji_pokok_baru, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-4 d-flex justify-content-end">
                <a href="{{ route('pegawai.riwayat-gbk.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>

        </div>
    </div>
@endsection
