@extends('layouts.app')
@section('title', 'Dashboard Operator')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Header Section -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Dashboard Operator</h2>
                                <small class="text-muted">Ringkasan unit kerja & permohonan SK gaji berkala</small>
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

            <!-- Welcome Card (Theme) -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm theme-avatar-ring">
                        <div class="card-body d-flex flex-column flex-md-row align-items-md-center py-4">
                            <div class="me-md-4 mb-3 mb-md-0 text-center">
                                @if ($user->profile_photo)
                                    <img src="{{ temp_asset($user->profile_photo) }}" alt="Foto Profil" class="rounded-circle theme-avatar" style="width:90px;height:90px;object-fit:cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=128&color=ffffff" alt="Foto Profil" class="rounded-circle theme-avatar" style="width:90px;height:90px;object-fit:cover;">
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <h4 class="mb-1 fw-semibold">Selamat datang, <span class="fw-bold text-primary">{{ $user->name }}</span></h4>
                                <p class="mb-1 text-muted small"><i class="ti ti-mail me-1"></i>{{ $user->email }}</p>
                                <p class="mb-2 text-muted small d-flex align-items-center"><i class="ti ti-building me-1"></i>{{ $user->unitKerja->nama_unit_kerja ?? 'Unit Kerja Belum Ditentukan' }}</p>
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    <span class="badge badge-soft-primary">{{ strtoupper($user->role) }}</span>
                                </div>
                            </div>
                            <div class="mt-3 mt-md-0 ms-md-auto d-flex gap-2">
                                <a href="{{ route('operator.pegawais.index') }}" class="btn btn-outline-danger btn-sm">
                                    <i class="ti ti-users me-1"></i>Kelola Pegawai
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards Row (Theme) -->
            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="theme-stat-card h-100 d-flex align-items-center">
                        <div class="stat-icon"><i class="ti ti-id"></i></div>
                        <div class="ms-3">
                            <p class="label">TOTAL PEGAWAI</p>
                            <p class="value mb-0">{{ $totalPegawai }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="theme-stat-card h-100 d-flex align-items-center">
                        <div class="stat-icon"><i class="ti ti-file-text"></i></div>
                        <div class="ms-3">
                            <p class="label">PERMOHONAN BARU</p>
                            <p class="value mb-0">{{ $permohonanBaru }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="theme-stat-card h-100 d-flex align-items-center">
                        <div class="stat-icon"><i class="ti ti-clock"></i></div>
                        <div class="ms-3">
                            <p class="label">SEDANG PROSES</p>
                            <p class="value mb-0">{{ $permohonanProses }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="theme-stat-card h-100 d-flex align-items-center">
                        <div class="stat-icon"><i class="ti ti-check"></i></div>
                        <div class="ms-3">
                            <p class="label">DISETUJUI</p>
                            <p class="value mb-0">{{ $permohonanDisetujui }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Access (Theme) -->
            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6 col-xl-4">
                    <a href="{{ route('operator.pegawais.index') }}" class="text-decoration-none">
                        <div class="card quick-access-card h-100 text-center p-3">
                            <div class="stat-icon mx-auto mb-2" style="font-size:1.35rem; width:48px; height:48px;"><i class="ti ti-users"></i></div>
                            <h6 class="fw-bold mb-1">Kelola Pegawai</h6>
                            <p class="small text-muted mb-0">Data pegawai unit kerja</p>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <a href="{{ route('operator.riwayat_gbks.index') }}" class="text-decoration-none">
                        <div class="card quick-access-card h-100 text-center p-3">
                            <div class="stat-icon mx-auto mb-2" style="font-size:1.35rem; width:48px; height:48px;"><i class="ti ti-history"></i></div>
                            <h6 class="fw-bold mb-1">Riwayat Gaji Berkala</h6>
                            <p class="small text-muted mb-0">Status & histori KGB</p>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <a href="{{ route('operator.permohonan-sk.index') }}" class="text-decoration-none">
                        <div class="card quick-access-card h-100 text-center p-3">
                            <div class="stat-icon mx-auto mb-2" style="font-size:1.35rem; width:48px; height:48px;"><i class="ti ti-file-check"></i></div>
                            <h6 class="fw-bold mb-1">Permohonan SK</h6>
                            <p class="small text-muted mb-0">Proses & validasi</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Permohonan SK Terbaru -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 d-flex align-items-center">
                            <i class="ti ti-file-check text-primary me-2 fs-4"></i>
                            <div>
                                <h6 class="mb-0 fw-bold text-dark">Permohonan SK Terbaru</h6>
                                <small class="text-muted">Pegawai di unit kerja Anda</small>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nama Pegawai</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permohonanSk as $permohonan)
                                            <tr>
                                                <td>{{ $permohonan->pegawai->user->name }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $permohonan->status == 'diajukan' ? 'warning' : ($permohonan->status == 'diproses' ? 'info' : ($permohonan->status == 'disetujui' ? 'success' : 'danger')) }}">
                                                        {{ ucfirst($permohonan->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $permohonan->created_at->format('d M Y') }}</td>
                                                <td>
                                                    @if ($permohonan->status === 'diajukan')
                                                        <a href="{{ route('operator.permohonan-sk.show', $permohonan->id) }}"
                                                            class="avtar mx-1 avtar-xs btn-link-warning"
                                                            title="Proses Permohonan">
                                                            <i class="ti ti-settings f-20"></i>
                                                        </a>
                                                    @endif

                                                    @if ($permohonan->status === 'diproses')
                                                        <a href="{{ route('operator.permohonan-sk.process-sk', $permohonan->id) }}"
                                                            class="avtar mx-1 avtar-xs btn-link-secondary"
                                                            title="Lanjutkan Proses Pencetakan SK">
                                                            <i class="ti ti-printer f-20"></i>
                                                        </a>
                                                    @endif

                                                    @if ($permohonan->status === 'disetujui')
                                                        <form
                                                            action="{{ route('operator.permohonan-sk.destroy', $permohonan->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="avtar mx-1 avtar-xs btn-link-secondary border-0 bg-transparent p-0 shadow-none"
                                                                title="Hapus">
                                                                <i class="ti ti-trash f-20"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ($permohonanSk->isEmpty())
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">Belum ada permohonan SK
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
