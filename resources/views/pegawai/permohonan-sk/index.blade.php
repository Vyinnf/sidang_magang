@extends('layouts.app')

@section('title', 'Permohonan SK')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Permohonan SK</h2>
                                <small class="text-muted">Daftar permohonan SK yang Anda ajukan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Permohonan SK -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-history me-2"></i>Daftar Permohonan
                    </h5>
                    <!-- Tombol untuk mengajukan permohonan baru -->
                    @if ($canAjukanPermohonan)
                        <a href="{{ route('pegawai.permohonan-sk.create') }}" class="btn btn-primary btn-sm">
                            <i class="ti ti-plus"></i><span class="d-none d-sm-inline ms-1"> Ajukan Permohonan</span>
                        </a>
                    @else
                        <button type="button" class="btn btn-secondary btn-sm" disabled>
                            <i class="ti ti-clock"></i><span class="d-none d-sm-inline ms-1"> Belum Bisa Ajukan</span>
                        </button>
                    @endif
                </div>
                <div class="card-body">
                    <div class="alert {{ $canAjukanPermohonan ? 'alert-success' : 'alert-warning' }} border-0 shadow-sm" role="alert">
                        <div class="fw-semibold mb-1">Status Kelayakan Pengajuan</div>
                        <div>{{ $infoPengajuan }}</div>
                        @if ($tanggalKgbBerikutnya)
                            <small class="d-block mt-1 text-muted">Tanggal KGB Berikutnya: {{ $tanggalKgbBerikutnya->translatedFormat('d F Y') }}</small>
                        @endif
                    </div>

                    <x-table.filter-toolbar
                        placeholder="Cari catatan pengajuan atau catatan operator..."
                        :sort-options="[
                            'created_at' => 'Waktu Dibuat',
                            'tanggal_pengajuan' => 'Tanggal Pengajuan',
                            'status' => 'Status',
                        ]"
                        :q="$tableQuery['q'] ?? request('q', '')"
                        :sort="$tableQuery['sort'] ?? request('sort', 'created_at')"
                        :dir="$tableQuery['dir'] ?? request('dir', 'desc')"
                        :per-page="$tableQuery['per_page'] ?? (int) request('per_page', 10)"
                    >
                        <div class="col-md-3">
                            <label class="form-label mb-1">Status</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="diajukan" @selected(($status ?? request('status')) === 'diajukan')>Diajukan</option>
                                <option value="diproses" @selected(($status ?? request('status')) === 'diproses')>Diproses</option>
                                <option value="disetujui" @selected(($status ?? request('status')) === 'disetujui')>Disetujui</option>
                                <option value="ditolak" @selected(($status ?? request('status')) === 'ditolak')>Ditolak</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label mb-1">Tanggal Dari</label>
                            <input type="date" name="from" class="form-control" value="{{ $tableQuery['from'] ?? request('from') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label mb-1">Tanggal Sampai</label>
                            <input type="date" name="to" class="form-control" value="{{ $tableQuery['to'] ?? request('to') }}">
                        </div>
                    </x-table.filter-toolbar>

                    @if ($permohonanSks->isEmpty())
                        <p class="text-muted text-center">Anda belum memiliki riwayat permohonan SK.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Tanggal Pengajuan</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Catatan</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permohonanSks as $index => $permohonan)
                                        <tr>
                                            <td class="text-center">{{ ($permohonanSks->firstItem() ?? 0) + $index }}</td>
                                            <td class="text-center">{{ $permohonan->tanggal_pengajuan->format('d F Y') }}
                                            </td>
                                            <td class="text-center">
                                                @if ($permohonan->status === 'disetujui')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @elseif ($permohonan->status === 'ditolak')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @elseif ($permohonan->status === 'diproses')
                                                    <span class="badge bg-primary">Diproses</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Diajukan</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $permohonan->catatan_operator ?? '-' }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('pegawai.permohonan-sk.show', $permohonan->id) }}"
                                                    class="avtar mx-1 avtar-xs btn-link-secondary" title="Detail">
                                                    <i class="ti ti-eye f-20"></i>
                                                </a>
                                                @php
                                                    $riwayat = $permohonan->pegawai->riwayatGbks()->latest()->first();
                                                @endphp

                                                @if ($permohonan->status === 'disetujui' && $riwayat)
                                                    <a href="{{ route('pegawai.permohonan-sk.download', $riwayat->id) }}"
                                                        class="avtar mx-1 avtar-xs btn-link-secondary" title="Unduh SK">
                                                        <i class="ti ti-download f-20"></i>
                                                    </a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                @if($permohonanSks instanceof \Illuminate\Contracts\Pagination\Paginator)
                        <div>
                            {{ $permohonanSks->withQueryString()->links() }}
                        </div>
                @endif
            </div>

            <!-- Tombol Kembali -->
            <div class="mt-4 d-flex justify-content-end">
                <a href="{{ route('pegawai.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>

        </div>
    </div>
@endsection
