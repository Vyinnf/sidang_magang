@extends('layouts.app')
@section('title', 'Detail Pengguna')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Detail Pengguna</h2>
                                <small class="text-muted">Informasi lengkap mengenai data pengguna terpilih.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Detail Pengguna -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-user me-2"></i> Detail Pengguna
                    </h5>
                </div>
                <div class="card-body p-4">

                    {{-- Informasi Akun --}}
                    <h6 class="mb-3 fw-bold">Informasi Akun</h6>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <p class="text-dark">{{ $user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <p class="text-dark">{{ $user->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Role</label>
                            <p class="text-dark">{{ ucfirst($user->role) }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Unit Kerja</label>
                            <p class="text-dark">{{ $user->unitKerja?->nama_unit_kerja ?? '-' }}</p>
                        </div>
                    </div>

                    <hr class="mt-4 mb-4">

                    {{-- Data Kepegawaian --}}
                    <h6 class="mb-3 fw-bold">Data Kepegawaian</h6>
                    @if ($user->pegawai)
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">NIP</label>
                                <p class="text-dark">{{ $user->pegawai->nip }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jenis ASN</label>
                                <p class="text-dark">{{ $user->pegawai->asn }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tempat, Tanggal Lahir</label>
                                <p class="text-dark">
                                    {{ ($user->pegawai->tempat_lahir ?? '-') . ', ' . ($user->pegawai->tanggal_lahir ? \Carbon\Carbon::parse($user->pegawai->tanggal_lahir)->translatedFormat('d F Y') : '-') }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Golongan</label>
                                <p class="text-dark">
                                    {{ $user->pegawai->golongan?->golongan ?? '-' }}
                                    ({{ $user->pegawai->golongan?->pangkat ?? '-' }})
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">TMT CPNS/PPPK</label>
                                <p class="text-dark">
                                    {{ $user->pegawai->skCpnsPppk->tmt ? \Carbon\Carbon::parse($user->pegawai->skCpnsPppk->tmt)->translatedFormat('d F Y') : '-' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Masa Kerja Pra-PNS</label>
                                <p class="text-dark">
                                    {{ $user->pegawai->skCpnsPppk->tahun_masa_kerja_pra_pengangkatan ?? 0 }} tahun,
                                    {{ $user->pegawai->skCpnsPppk->bulan_masa_kerja_pra_pengangkatan ?? 0 }} bulan
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">KGB Berikutnya</label>
                                <p class="text-dark">
                                    {{ $user->pegawai->tanggal_kenaikan_gaji_berkala_berikutnya ? \Carbon\Carbon::parse($user->pegawai->tanggal_kenaikan_gaji_berkala_berikutnya)->translatedFormat('d F Y') : '-' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">SK KGB Terakhir</label>
                                <p class="text-dark">
                                    @php
                                        $latestKgb = $user->pegawai?->riwayatGbks()->latest()->first();
                                    @endphp

                                    TMT:
                                    {{ $latestKgb?->tmt_sk ? \Carbon\Carbon::parse($latestKgb->tmt_sk)->translatedFormat('d F Y') : '-' }}<br>
                                    Tanggal SK:
                                    {{ $latestKgb?->tanggal_sk ? \Carbon\Carbon::parse($latestKgb->tanggal_sk)->translatedFormat('d F Y') : '-' }}<br>
                                    Nomor SK: {{ $latestKgb?->nomor_sk ?? '-' }}<br>
                                    Pejabat: {{ $latestKgb?->pejabat_sk ?? '-' }}
                                </p>
                            </div>
                        @else
                            <p class="text-muted">Pengguna ini belum memiliki data kepegawaian.</p>
                    @endif

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-light me-2">
                            <i class="ti ti-arrow-left me-1"></i> Kembali
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
