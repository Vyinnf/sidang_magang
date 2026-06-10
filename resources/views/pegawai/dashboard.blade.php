@extends('layouts.app')
@section('title', 'Dashboard Pegawai')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Header Section -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Dashboard Pegawai</h2>
                                <small class="text-muted">Ringkasan informasi pegawai & status gaji berkala</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Welcome Card (Theme) -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm theme-avatar-ring">
                        <div class="card-body d-flex flex-column flex-md-row align-items-md-center py-4">
                            <div class="me-md-4 mb-3 mb-md-0 text-center">
                                @if (optional($user)->profile_photo)
                                    <img src="{{ route('pegawai.profile.view-photo', $user->id) }}" alt="Foto Profil" class="rounded-circle theme-avatar" style="width:90px;height:90px;object-fit:cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(optional($user)->name ?? 'User') }}&size=128&color=ffffff" alt="Foto Profil" class="rounded-circle theme-avatar" style="width:90px;height:90px;object-fit:cover;">
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <h4 class="mb-1 fw-semibold">Selamat datang, <span class="fw-bold text-primary">{{ optional($user)->name ?? 'User' }}</span></h4>
                                <p class="mb-1 text-muted small"><i class="ti ti-mail me-1"></i>{{ optional($user)->email ?? '-' }}</p>
                                <p class="mb-2 text-muted small d-flex align-items-center"><i class="ti ti-building me-1"></i>{{ optional(optional($user)->unitKerja)->nama_unit_kerja ?? 'Unit Kerja Belum Ditentukan' }}</p>
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    <span class="badge badge-soft-primary">{{ strtoupper(optional($user)->role ?? 'GUEST') }}</span>
                                    @if (optional($user)->pegawai)
                                        <span class="badge bg-success-subtle text-success fw-semibold">{{ optional($user->pegawai)->asn ?? '-' }}</span>
                                        @if (optional($user->pegawai)->golongan)
                                            <span class="badge bg-secondary-subtle text-secondary fw-semibold">{{ optional($user->pegawai->golongan)->golongan ?? '-' }}</span>
                                        @endif
                                        @if (optional($user->pegawai)->jabatan)
                                            <span class="badge bg-warning-subtle text-warning fw-semibold">{{ optional($user->pegawai)->jabatan ?? '-' }}</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="mt-3 mt-md-0 ms-md-auto d-flex gap-2">
                                <a href="{{ route('pegawai.profile.index') }}" class="btn btn-outline-danger btn-sm"><i class="ti ti-user me-1"></i>Lihat Profil</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards Row (Theme) -->
            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="theme-stat-card h-100 d-flex align-items-center">
                        <div class="stat-icon"><i class="ti ti-id"></i></div>
                        <div class="ms-3">
                            <p class="label">NIP</p>
                            <p class="value mb-0 fs-5">{{ optional(optional($user)->pegawai)->nip ?? 'Belum Ada' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="theme-stat-card h-100 d-flex align-items-center">
                        <div class="stat-icon"><i class="ti ti-calendar"></i></div>
                        <div class="ms-3">
                            <p class="label">TMT CPNS/PPPK</p>
                            <p class="value mb-0" style="font-size:1rem;">
                                @if (optional($user->pegawai)->skCpnsPppk->tmt)
                                    {{ \Carbon\Carbon::parse(optional($user->pegawai)->skCpnsPppk->tmt)->format('d M Y') }}
                                @else
                                    Belum Ada
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="theme-stat-card h-100 d-flex align-items-center">
                        <div class="stat-icon"><i class="ti ti-briefcase"></i></div>
                        <div class="ms-3">
                            <p class="label">JABATAN</p>
                            <p class="value mb-0" style="font-size:1rem;">{{ optional($user->pegawai)->jabatan ?? 'Belum Ada' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="theme-stat-card h-100 d-flex align-items-center">
                        <div class="stat-icon"><i class="ti ti-clock"></i></div>
                        <div class="ms-3">
                            <p class="label">MASA KERJA PRA</p>
                            <p class="value mb-0" style="font-size:1rem;">
                                {{ optional($user->pegawai)->skCpnsPppk->tahun_masa_kerja_pra_pengangkatan ?? 0 }} th
                                {{ optional($user->pegawai)->skCpnsPppk->bulan_masa_kerja_pra_pengangkatan ?? 0 }} bln
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Row -->
            <div class="row align-items-stretch">
                {{-- Card 1: Gaji Saat Ini --}}
                @php
                    $riwayatTerakhir = optional(optional($user)->pegawai)->riwayatGbks()->latest()->first();
                @endphp
                <div class="col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-header bg-white border-0 d-flex align-items-center">
                            <i class="ti ti-currency-dollar text-primary me-2 fs-4"></i>
                            <div>
                                <h6 class="mb-0 fw-bold text-dark">Gaji Saat Ini</h6>
                                <small class="text-muted">Informasi gaji berkala terkini</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0 d-flex justify-content-between align-items-center border-0">
                                    <div>
                                        <span class="text-muted small">Gaji Pokok</span>
                                        <p class="mb-0 fw-semibold">Rp
                                            @if ($riwayatTerakhir)
                                                {{ number_format(optional($riwayatTerakhir)->gaji_pokok_baru ?? 0, 0, ',', '.') }}
                                            @else
                                                {{ number_format(optional($user->pegawai->skCpnsPppk)->gaji_pokok ?? 0, 0, ',', '.') }}
                                            @endif
                                        </p>
                                    </div>
                                </li>
                                <li class="list-group-item px-0 border-0">
                                    <span class="text-muted small">KGB Terakhir</span>
                                    <p class="mb-0">
                                        {{ optional(optional($riwayatTerakhir)->tmt_sk)->format('d F Y') ?? '-' }}
                                    </p>
                                </li>
                            </ul>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-end">
                            <a href="{{ route('pegawai.riwayat-gbk.index') }}" class="btn btn-sm btn-outline-primary">
                                <i class="ti ti-history me-1"></i>Lihat Riwayat
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Reminder KGB --}}
                <div class="col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-header bg-white border-0 d-flex align-items-center">
                            <i class="ti ti-bell-ringing text-danger me-2 fs-4"></i>
                            <div>
                                <h6 class="mb-0 fw-bold text-danger">Reminder KGB</h6>
                                <small class="text-muted">Jatuh tempo kenaikan berkala</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <p class="mb-2">Kenaikan Gaji Berkala Anda <strong>seharusnya dilakukan pada:</strong>
                                </p>
                                <div class="bg-danger-subtle border border-danger rounded p-3 text-center">
                                    <h5 class="text-danger mb-1">
                                        @if (optional($user->pegawai)->tanggal_kenaikan_gaji_berkala_berikutnya)
                                            {{ \Carbon\Carbon::parse(optional($user->pegawai)->tanggal_kenaikan_gaji_berkala_berikutnya)->format('d F Y') }}
                                        @else
                                            Belum Ditentukan
                                        @endif
                                    </h5>
                                    <small class="text-danger d-flex align-items-center justify-content-center">
                                        @if (optional($user->pegawai)->tanggal_kenaikan_gaji_berkala_berikutnya)
                                            @php
                                                $tanggalKGB = \Carbon\Carbon::parse(
                                                    optional($user->pegawai)->tanggal_kenaikan_gaji_berkala_berikutnya,
                                                );
                                                $sekarang = \Carbon\Carbon::now();
                                                $selisih = round($sekarang->diffInDays($tanggalKGB, false));
                                            @endphp

                                            @if ($selisih < 0)
                                                <i class="ti ti-clock-exclamation me-2"></i>
                                                <div>
                                                    <strong>Peringatan:</strong> Sudah lewat {{ abs($selisih) }} hari!
                                                </div>
                                            @else
                                                <i class="ti ti-clock me-2"></i>
                                                <div>
                                                    <strong>Perhatian:</strong> Jatuh tempo dalam {{ $selisih }} hari
                                                    lagi.
                                                </div>
                                            @endif
                                        @endif
                                    </small>
                                </div>
                            </div>

                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0 d-flex justify-content-between border-0">
                                    <span class="text-muted small">Status KGB</span>
                                    @if (optional($user->pegawai)->tanggal_kenaikan_gaji_berkala_berikutnya)
                                        @php
                                            $tanggalKGB = \Carbon\Carbon::parse(
                                                optional($user->pegawai)->tanggal_kenaikan_gaji_berkala_berikutnya,
                                            );
                                            $sekarang = \Carbon\Carbon::now();
                                            $selisih = $sekarang->diffInDays($tanggalKGB, false);
                                        @endphp
                                        @if ($selisih < 0)
                                            <span class="badge bg-danger">Lewat Tempo</span>
                                        @elseif($selisih <= 30)
                                            <span class="badge bg-warning text-dark">Segera</span>
                                        @else
                                            <span class="badge bg-success">Normal</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">Belum Ada Jadwal</span>
                                    @endif
                                </li>
                                <li class="list-group-item px-0 d-flex justify-content-between border-0">
                                    <span class="text-muted small">Hari Ini</span>
                                    <span class="fw-semibold">{{ \Carbon\Carbon::now()->format('d F Y') }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-end">
                            @php
                                $permohonanSkTerakhir = optional($riwayatTerakhir)->permohonanSk;
                            @endphp
                            @if ($permohonanSkTerakhir)
                                <a href="{{ route('pegawai.permohonan-sk.show', $permohonanSkTerakhir->id) }}"
                                    class="btn btn-sm btn-info text-white">
                                    <i class="ti ti-info-circle me-1"></i> Lihat Status Permohonan
                                </a>
                            @else
                                <a href="{{ route('pegawai.permohonan-sk.create') }}" class="btn btn-sm btn-danger">
                                    <i class="ti ti-file-plus me-1"></i> Ajukan Permohonan SK
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status SK Gaji Berkala Terakhir -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 d-flex align-items-center">
                            <i class="ti ti-file-check text-primary me-2 fs-4"></i>
                            <div>
                                <h6 class="mb-0 fw-bold text-dark">Status SK Gaji Berkala Terakhir</h6>
                                <small class="text-muted">Keterangan SK KGB terbaru</small>
                            </div>
                        </div>
                        <div class="card-body text-center">

                            @if ($riwayatTerakhir)
                                @if (optional($riwayatTerakhir)->status_sk == 'lengkap')
                                    <div class="mb-3">
                                        <span class="badge bg-success-subtle text-success px-4 py-2 fs-6">
                                            <i class="ti ti-check me-1"></i> SK Lengkap
                                        </span>
                                    </div>
                                    <p class="text-muted small">SK terakhir sudah lengkap.</p>
                                @else
                                    <div class="mb-3">
                                        <span class="badge bg-warning-subtle text-warning px-4 py-2 fs-6">
                                            <i class="ti ti-alert-triangle me-1"></i> SK Tidak Lengkap
                                        </span>
                                    </div>
                                    <p class="text-muted small mb-3">Harap lengkapi dokumen SK KGB</p>
                                    <a href="{{ route('pegawai.riwayat-gbk.edit', optional($riwayatTerakhir)->id) }}"
                                        class="btn btn-sm btn-primary px-3">
                                        <i class="ti ti-edit me-1"></i> Lengkapi SK
                                    </a>
                                @endif
                            @else
                                <div class="py-3">
                                    <i class="ti ti-file-x text-muted fs-1 mb-2"></i>
                                    <h6 class="text-muted fw-semibold">Belum Ada Riwayat KGB</h6>
                                    <p class="text-muted small mb-0">Status SK akan muncul setelah ada riwayat KGB.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
