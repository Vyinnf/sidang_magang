@extends('layouts.app')
@section('title', 'Detail SK Pengangkatan')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Detail SK Pengangkatan</h2>
                                <small class="text-muted">Informasi lengkap mengenai SK pengangkatan pegawai
                                    (CPNS/PPPK).</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Detail SK Pengangkatan -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-file-invoice me-2"></i> Detail SK Pengangkatan
                    </h5>
                </div>
                <div class="card-body p-4">

                    {{-- Informasi Pegawai --}}
                    <h6 class="mb-3 fw-bold">Informasi Pegawai</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Pegawai</label>
                            <p class="text-dark">{{ $skPengangkatan->pegawai?->user?->name ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">NIP</label>
                            <p class="text-dark">{{ $skPengangkatan->pegawai?->nip ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Golongan</label>
                            <p class="text-dark">{{ $skPengangkatan->golongan?->golongan ?? '-' }}
                                ({{ $skPengangkatan->golongan?->pangkat ?? '-' }})</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Pejabat SK</label>
                            <p class="text-dark">{{ $skPengangkatan->pejabat_sk ?? '-' }}</p>
                        </div>
                    </div>

                    <hr class="mt-4 mb-4">

                    {{-- Informasi SK --}}
                    <h6 class="mb-3 fw-bold">Informasi SK Pengangkatan</h6>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Nomor SK</label>
                            <p class="text-dark">{{ $skPengangkatan->nomor_sk ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Tanggal SK</label>
                            <p class="text-dark">{{ $skPengangkatan->tanggal_sk?->format('d F Y') ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">TMT</label>
                            <p class="text-dark">{{ $skPengangkatan->tmt?->format('d F Y') ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Gaji Pokok</label>
                            <p class="text-dark">
                                {{ $skPengangkatan->gaji_pokok ? 'Rp ' . number_format($skPengangkatan->gaji_pokok, 0, ',', '.') : '-' }}
                            </p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Masa Kerja Pra Pengangkatan</label>
                            <p class="text-dark">
                                {{ $skPengangkatan->tahun_masa_kerja_pra_pengangkatan ?? 0 }} Thn
                                {{ $skPengangkatan->bulan_masa_kerja_pra_pengangkatan ?? 0 }} Bln
                            </p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">File SK</label>
                            @if ($skPengangkatan->sk_path)
                                <a href="{{ route('operator.sk-pengangkatan.download', $skPengangkatan->id) }}" target="_blank"
                                    class="btn btn-sm btn-primary">Download SK</a>
                            @else
                                <p class="text-dark">-</p>
                            @endif
                        </div>
                    </div>

                    <!-- Tombol Kembali -->
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('operator.sk-pengangkatan.index') }}" class="btn btn-light">
                            <i class="ti ti-arrow-left me-1"></i> Kembali
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
