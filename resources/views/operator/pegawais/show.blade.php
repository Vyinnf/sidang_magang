@extends('layouts.app')
@section('title', 'Detail Pegawai')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Detail Pegawai</h2>
                                <small class="text-muted">Informasi lengkap mengenai data pegawai terpilih.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Detail Pegawai -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-id me-2"></i> Detail Pegawai
                    </h5>
                </div>
                <div class="card-body p-4">

                    {{-- Informasi Akun --}}
                    <h6 class="mb-3 fw-bold">Informasi Akun</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <p class="text-dark">{{ $user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <p class="text-dark">{{ $user->email }}</p>
                        </div>
                    </div>

                    <hr class="mt-4 mb-4">

                    {{-- Data Pokok Kepegawaian --}}
                    <h6 class="mb-3 fw-bold">Data Pokok Kepegawaian</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">NIP</label>
                            <p class="text-dark">{{ $user->pegawai?->nip ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jenis ASN</label>
                            <p class="text-dark">{{ $user->pegawai?->asn ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jabatan</label>
                            <p class="text-dark">{{ $user->pegawai?->jabatan ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tempat, Tanggal Lahir</label>
                            <p class="text-dark">
                                {{ ($user->pegawai?->tempat_lahir ?? '-') . ', ' . ($user->pegawai?->tanggal_lahir ? \Carbon\Carbon::parse($user->pegawai->tanggal_lahir)->translatedFormat('d F Y') : '-') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Unit Kerja</label>
                            <p class="text-dark">{{ $user->unitKerja?->nama_unit_kerja ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Golongan</label>
                            <p class="text-dark">
                                {{ $user->pegawai?->golongan?->golongan ?? '-' }}
                                ({{ $user->pegawai?->golongan?->pangkat ?? '-' }})
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal KGB Berikutnya</label>
                            <p class="text-dark">
                                {{ $user->pegawai?->tanggal_kenaikan_gaji_berkala_berikutnya ? \Carbon\Carbon::parse($user->pegawai->tanggal_kenaikan_gaji_berkala_berikutnya)->translatedFormat('d F Y') : '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('operator.pegawais.index') }}" class="btn btn-light me-2">
                            <i class="ti ti-arrow-left me-1"></i> Kembali
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
