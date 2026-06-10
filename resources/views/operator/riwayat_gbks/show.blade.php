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
                                <small class="text-muted">Informasi lengkap mengenai riwayat kenaikan gaji berkala
                                    pegawai.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Detail Riwayat -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-file-report me-2"></i> Detail Riwayat Gaji Berkala
                    </h5>
                </div>
                <div class="card-body p-4">

                    {{-- Informasi Pegawai --}}
                    <h6 class="mb-3 fw-bold">Informasi Pegawai</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Pegawai</label>
                            <p class="text-dark">{{ $riwayat->pegawai->user->name ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">NIP</label>
                            <p class="text-dark">{{ $riwayat->pegawai->nip ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Golongan Lama</label>
                            <p class="text-dark">{{ $riwayat->golonganLama->golongan ?? '-' }}
                                ({{ $riwayat->golonganLama->pangkat ?? '-' }})</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Golongan Baru</label>
                            <p class="text-dark">{{ $riwayat->golonganBaru->golongan ?? '-' }}
                                ({{ $riwayat->golonganBaru->pangkat ?? '-' }})</p>
                        </div>
                    </div>

                    <hr class="mt-4 mb-4">

                    {{-- Data SK Lama --}}
                    <h6 class="mb-3 fw-bold">SK Lama</h6>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">TMT SK Lama</label>
                            <p class="text-dark">{{ $riwayat->tmt_sk_lama ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Tanggal SK Lama</label>
                            <p class="text-dark">{{ $riwayat->tanggal_sk_lama ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Nomor SK Lama</label>
                            <p class="text-dark">{{ $riwayat->nomor_sk_lama ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Pejabat SK Lama</label>
                            <p class="text-dark">{{ $riwayat->pejabat_sk_lama ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Gaji Pokok Lama</label>
                            <p class="text-dark">{{ number_format($riwayat->gaji_pokok_lama, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Masa Kerja Lama</label>
                            <p class="text-dark">{{ $riwayat->masa_kerja_golongan_lama_tahun }} Thn
                                {{ $riwayat->masa_kerja_golongan_lama_bulan }} Bln</p>
                        </div>
                    </div>

                    <hr class="mt-4 mb-4">

                    {{-- Data SK Baru --}}
                    <h6 class="mb-3 fw-bold">SK Baru</h6>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">TMT SK Baru</label>
                            <p class="text-dark">{{ $riwayat->tmt_sk ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Tanggal SK Baru</label>
                            <p class="text-dark">{{ $riwayat->tanggal_sk ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Nomor SK Baru</label>
                            <p class="text-dark">{{ $riwayat->nomor_sk ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Pejabat SK Baru</label>
                            <p class="text-dark">{{ $riwayat->pejabat_sk ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Gaji Pokok Baru</label>
                            <p class="text-dark">{{ number_format($riwayat->gaji_pokok_baru, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Masa Kerja Baru</label>
                            <p class="text-dark">{{ $riwayat->masa_kerja_golongan_baru_tahun }} Thn
                                {{ $riwayat->masa_kerja_golongan_baru_bulan }} Bln</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Status SK</label>
                            <p class="text-dark">{{ ucfirst($riwayat->status_sk) }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">File SK</label>
                            @if ($riwayat->sk_path)
                                <a href="{{ route('sk.download', $riwayat->id) }}" target="_blank"
                                    class="btn btn-sm btn-primary">Download SK</a>
                            @else
                                <p class="text-dark">-</p>
                            @endif
                        </div>
                    </div>

                    <!-- Tombol Kembali -->
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('operator.riwayat_gbks.index') }}" class="btn btn-light">
                            <i class="ti ti-arrow-left me-1"></i> Kembali
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
