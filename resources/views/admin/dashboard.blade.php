@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Header Section -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Dashboard Admin</h2>
                                <small class="text-muted">Ringkasan data & status sistem</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (!empty($wordConversionHealthMessage))
                <div class="alert alert-warning border-0 shadow-sm" role="alert">
                    <div class="fw-semibold mb-1">Peringatan Sistem Konversi Dokumen</div>
                    <div>{{ $wordConversionHealthMessage }}</div>
                </div>
            @endif

            <!-- Welcome Card (Refactored Theme) -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm theme-avatar-ring">
                        <div class="card-body d-flex flex-column flex-md-row align-items-md-center py-4">
                            <div class="me-md-4 mb-3 mb-md-0 text-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(optional($user)->name ?? 'Admin') }}&size=128&color=ffffff"
                                     alt="Foto Admin" class="rounded-circle theme-avatar" style="width:90px;height:90px;object-fit:cover;">
                            </div>
                            <div class="flex-grow-1">
                                <h4 class="mb-1 fw-semibold">Selamat datang, <span class="fw-bold text-primary">{{ optional($user)->name ?? 'Admin' }}</span></h4>
                                <p class="mb-1 text-muted small d-flex align-items-center"><i class="ti ti-mail me-1"></i>{{ optional($user)->email ?? '-' }}</p>
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    <span class="badge badge-soft-primary">{{ strtoupper(optional($user)->role ?? 'ADMIN') }}</span>
                                </div>
                            </div>
                            <div class="ms-md-auto mt-3 mt-md-0 d-flex gap-2">
                                {{-- Placeholder future actions --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards Row (Theme) -->
            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="theme-stat-card h-100 d-flex align-items-center">
                        <div class="stat-icon"><i class="ti ti-users"></i></div>
                        <div class="ms-3">
                            <p class="label">TOTAL USER</p>
                            <p class="value mb-0">{{ $totalUsers ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="theme-stat-card h-100 d-flex align-items-center">
                        <div class="stat-icon"><i class="ti ti-currency-dollar"></i></div>
                        <div class="ms-3">
                            <p class="label">TOTAL PEGAWAI</p>
                            <p class="value mb-0">{{ $totalPegawai ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="theme-stat-card h-100 d-flex align-items-center">
                        <div class="stat-icon"><i class="ti ti-briefcase"></i></div>
                        <div class="ms-3">
                            <p class="label">GOLONGAN</p>
                            <p class="value mb-0">{{ $totalGolongan ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="theme-stat-card h-100 d-flex align-items-center">
                        <div class="stat-icon"><i class="ti ti-building"></i></div>
                        <div class="ms-3">
                            <p class="label">UNIT KERJA</p>
                            <p class="value mb-0">{{ $totalUnitKerja ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Access Cards (Theme) -->
            <div class="row g-3">
                <div class="col-12 col-sm-6 col-xl-3">
                    <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                        <div class="card quick-access-card h-100 text-center p-3">
                            <div class="stat-icon mx-auto mb-2" style="font-size:1.4rem; width:48px; height:48px;"><i class="ti ti-users"></i></div>
                            <h6 class="fw-bold mb-1">Manage User</h6>
                            <p class="small text-muted mb-0">Tambah / Edit / Hapus User</p>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <a href="{{ route('admin.gajis.index') }}" class="text-decoration-none">
                        <div class="card quick-access-card h-100 text-center p-3">
                            <div class="stat-icon mx-auto mb-2" style="font-size:1.4rem; width:48px; height:48px;"><i class="ti ti-currency-dollar"></i></div>
                            <h6 class="fw-bold mb-1">Manage Gaji</h6>
                            <p class="small text-muted mb-0">CRUD Master Gaji</p>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <a href="{{ route('admin.golongans.index') }}" class="text-decoration-none">
                        <div class="card quick-access-card h-100 text-center p-3">
                            <div class="stat-icon mx-auto mb-2" style="font-size:1.4rem; width:48px; height:48px;"><i class="ti ti-briefcase"></i></div>
                            <h6 class="fw-bold mb-1">Manage Golongan</h6>
                            <p class="small text-muted mb-0">CRUD Golongan PNS/PPPK</p>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <a href="{{ route('admin.unit-kerjas.index') }}" class="text-decoration-none">
                        <div class="card quick-access-card h-100 text-center p-3">
                            <div class="stat-icon mx-auto mb-2" style="font-size:1.4rem; width:48px; height:48px;"><i class="ti ti-building"></i></div>
                            <h6 class="fw-bold mb-1">Manage Unit Kerja</h6>
                            <p class="small text-muted mb-0">CRUD Unit Kerja Pegawai</p>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <a href="{{ route('admin.contact-messages.index') }}" class="text-decoration-none">
                        <div class="card quick-access-card h-100 text-center p-3 position-relative">
                            <div class="stat-icon mx-auto mb-2" style="font-size:1.4rem; width:48px; height:48px;"><i class="ti ti-mail"></i></div>
                            <h6 class="fw-bold mb-1">Pesan Kontak</h6>
                            <p class="small text-muted mb-0">Kotak masuk dari formulir landing</p>
                            @if(isset($unreadContactMessages) && $unreadContactMessages > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $unreadContactMessages }}
                                </span>
                            @endif
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection
