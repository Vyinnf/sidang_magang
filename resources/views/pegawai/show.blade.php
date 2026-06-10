@extends('layouts.pegawai')

@section('title', 'Profil Pegawai')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Profil Pegawai</h2>
                                <small class="text-muted">Detail informasi data pegawai</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Profile Card -->
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <!-- Foto -->
                            <div class="mb-3">
                                @if ($user->profile_photo)
                                    <img src="{{ asset('storage/' . $user->profile_photo) }}"
                                        class="rounded-circle shadow-sm"
                                        style="width: 130px; height: 130px; object-fit: cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name ?? 'Pegawai') }}&size=130&background=6c757d&color=ffffff"
                                        class="rounded-circle shadow-sm" style="width: 130px; height: 130px;">
                                @endif
                            </div>

                            <!-- Nama & Role -->
                            <h4 class="fw-bold mb-1">{{ $user->name ?? 'Nama Tidak Tersedia' }}</h4>
                            <span class="badge bg-primary px-3 py-1 mb-3">{{ ucfirst($user->role ?? 'pegawai') }}</span>

                            <!-- Quick Info -->
                            <div class="d-flex justify-content-around border-top pt-3 mt-3">
                                <div>
                                    <p class="text-muted small mb-1">NIP</p>
                                    <h6 class="fw-semibold mb-0">{{ $user->pegawai->nip ?? '-' }}</h6>
                                </div>
                                <div>
                                    <p class="text-muted small mb-1">Golongan</p>
                                    <h6 class="fw-semibold mb-0">{{ $user->pegawai->golongan->golongan ?? '-' }}</h6>
                                </div>
                            </div>

                            <!-- Action -->
                            <div class="mt-4">
                                <a href="{{ route('pegawai.edit') }}" class="btn btn-sm btn-primary me-2">
                                    <i class="ti ti-edit"></i> Edit Profil
                                </a>
                                <a href="{{ route('pegawai.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="ti ti-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Information -->
                <div class="col-lg-8">
                    <!-- Informasi Personal -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 fw-bold text-dark">
                                <i class="ti ti-user-circle me-2"></i>Informasi Personal
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="text-muted small">Nama Lengkap</label>
                                    <p class="fw-semibold mb-0">{{ $user->name ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Email</label>
                                    <p class="fw-semibold mb-0">{{ $user->email ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Tempat Lahir</label>
                                    <p class="fw-semibold mb-0">{{ $user->pegawai->tempat_lahir ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Tanggal Lahir</label>
                                    <p class="fw-semibold mb-0">
                                        {{ $user->pegawai->tanggal_lahir ? $user->pegawai->tanggal_lahir->format('d F Y') : '-' }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Jabatan</label>
                                    <p class="fw-semibold mb-0">{{ $user->pegawai->jabatan ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Unit Kerja</label>
                                    <p class="fw-semibold mb-0">{{ $user->unitKerja->nama_unit_kerja ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Kepegawaian -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 fw-bold text-dark">
                                <i class="ti ti-briefcase me-2"></i>Informasi Kepegawaian
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="text-muted small">NIP</label>
                                    <p class="fw-semibold mb-0">{{ $user->pegawai->nip ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Status ASN</label>
                                    @if ($user->pegawai && $user->pegawai->asn)
                                        <p class="fw-semibold mb-0">
                                            {{ $user->pegawai->asn }}
                                        </p>
                                    @else
                                        <p class="fw-semibold mb-0">-</p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Golongan</label>
                                    <p class="fw-semibold mb-0">{{ $user->pegawai->golongan->golongan ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">TMT CPNS/PPPK</label>
                                    <p class="fw-semibold mb-0">
                                        {{ $user->pegawai->tmt_cpns_pppk ? $user->pegawai->tmt_cpns_pppk->format('d F Y') : '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Masa Kerja -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 fw-bold text-dark">
                                <i class="ti ti-calendar me-2"></i>Masa Kerja
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                @if ($user->pegawai && $user->pegawai->riwayatGbks()->latest()->first())
                                    <div class="col-md-6">
                                        <label class="text-muted small">Masa Kerja Golongan Terakhir</label>
                                        <p class="fw-semibold mb-0">
                                            {{ $user->pegawai->riwayatGbks()->latest()->first()->masa_kerja_golongan_baru_tahun ?? 0 }}
                                            Tahun
                                            {{ $user->pegawai->riwayatGbks()->latest()->first()->masa_kerja_golongan_baru_bulan ?? 0 }}
                                            Bulan
                                        </p>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <label class="text-muted small">Masa Kerja Pra PNS</label>
                                    <p class="fw-semibold mb-0">
                                        {{ $user->pegawai->tahun_masa_kerja_pra_pns ?? 0 }} Tahun
                                        {{ $user->pegawai->bulan_masa_kerja_pra_pns ?? 0 }} Bulan
                                    </p>
                                </div>
                                <div class="col-12">
                                    <label class="text-muted small">Tanggal Kenaikan Gaji Berkala Berikutnya</label>
                                    <p class="fw-semibold mb-0">
                                        @if ($user->pegawai && $user->pegawai->tanggal_kenaikan_gaji_berkala_berikutnya)
                                            {{ $user->pegawai->tanggal_kenaikan_gaji_berkala_berikutnya->format('d F Y') }}
                                            <span class="text-muted small">
                                                ({{ $user->pegawai->tanggal_kenaikan_gaji_berkala_berikutnya->diffForHumans() }})
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- End col-lg-8 -->
            </div>
        </div>
    </div>
@endsection
