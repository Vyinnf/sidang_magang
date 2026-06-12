@extends('layouts.app')

@section('title', 'Riwayat Gaji Berkala')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Riwayat Gaji Berkala</h2>
                                <small class="text-muted">Daftar riwayat kenaikan gaji pegawai</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Riwayat -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-history me-2"></i>Riwayat Gaji
                    </h5>
                </div>
                <div class="card-body">
                    <x-table.filter-toolbar
                        placeholder="Cari nomor SK atau pejabat SK..."
                        :sort-options="[
                            'id' => 'ID',
                            'tmt_sk' => 'TMT SK',
                            'tanggal_sk' => 'Tanggal SK',
                            'status_sk' => 'Status SK',
                            'created_at' => 'Waktu Dibuat',
                        ]"
                        :q="$tableQuery['q'] ?? request('q', '')"
                        :sort="$tableQuery['sort'] ?? request('sort', 'tmt_sk')"
                        :dir="$tableQuery['dir'] ?? request('dir', 'desc')"
                        :per-page="$tableQuery['per_page'] ?? (int) request('per_page', 10)"
                    >
                        <x-slot name="actions">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="ti ti-download me-1"></i> Unduh
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('pegawai.riwayat-gbk.export', array_merge(request()->query(), ['format' => 'excel'])) }}">
                                            <i class="ti ti-file-spreadsheet me-2"></i> Excel
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('pegawai.riwayat-gbk.export', array_merge(request()->query(), ['format' => 'pdf'])) }}">
                                            <i class="ti ti-file-pdf me-2"></i> PDF
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                                <i class="ti ti-printer me-1"></i> Cetak
                            </button>
                        </x-slot>
                        <div class="col-md-3">
                            <label class="form-label mb-1">Status SK</label>
                            <select name="status_sk" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="lengkap" @selected(($statusSk ?? request('status_sk')) === 'lengkap')>Lengkap</option>
                                <option value="tidak_lengkap" @selected(($statusSk ?? request('status_sk')) === 'tidak_lengkap')>Tidak Lengkap</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label mb-1">TMT Dari</label>
                            <input type="date" name="from" class="form-control" value="{{ $tableQuery['from'] ?? request('from') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label mb-1">TMT Sampai</label>
                            <input type="date" name="to" class="form-control" value="{{ $tableQuery['to'] ?? request('to') }}">
                        </div>
                    </x-table.filter-toolbar>

                    @if ($riwayatGbks->isEmpty())
                        <p class="text-muted text-center">Belum ada riwayat gaji berkala yang tercatat.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">
                                            <a href="{{ route('pegawai.riwayat-gbk.index', array_merge(request()->query(), ['sort' => 'tmt_sk', 'dir' => request('dir') === 'asc' && request('sort') === 'tmt_sk' ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark">
                                                TMT SK
                                                @if (request('sort') === 'tmt_sk')
                                                    <i class="ti ti-arrow-{{ request('dir') === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="text-center">Nomor SK</th>
                                        <th class="text-center">Tanggal SK</th>
                                        <th class="text-center">
                                            <a href="{{ route('pegawai.riwayat-gbk.index', array_merge(request()->query(), ['sort' => 'status_sk', 'dir' => request('dir') === 'asc' && request('sort') === 'status_sk' ? 'desc' : 'asc'])) }}" class="text-decoration-none text-dark">
                                                Status SK
                                                @if (request('sort') === 'status_sk')
                                                    <i class="ti ti-arrow-{{ request('dir') === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($riwayatGbks as $index => $riwayat)
                                        <tr>
                                            <td class="text-center">{{ ($riwayatGbks->firstItem() ?? 0) + $index }}</td>
                                            <td class="text-center">{{ $riwayat->tmt_sk->format('d F Y') ?? '-' }}</td>
                                            <td class="text-center">{{ $riwayat->nomor_sk ?? '-' }}</td>
                                            <td class="text-center">
                                                {{ $riwayat->tanggal_sk ? \Carbon\Carbon::parse($riwayat->tanggal_sk)->format('d F Y') : '-' }}
                                            </td>
                                            <td class="text-center">
                                                @if ($riwayat->status_sk === 'lengkap')
                                                    <span class="badge bg-success">Lengkap</span>
                                                @elseif ($riwayat->status_sk === 'tidak_lengkap')
                                                    <span class="badge bg-secondary">Tidak Lengkap</span>
                                                @else
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('pegawai.riwayat-gbk.show', $riwayat->id) }}"
                                                    class="avtar mx-1 avtar-xs btn-link-secondary" title="Detail">
                                                    <i class="ti ti-eye f-20"></i>
                                                </a>
                                                @if ($riwayat->sk_path)
                                                    <a href="{{ route('pegawai.riwayat-gbk.download', $riwayat->id) }}"
                                                        class="avtar mx-1 avtar-xs btn-link-secondary" title="Unduh SK">
                                                        <i class="ti ti-download f-20"></i>
                                                    </a>
                                                @endif
                                                @if ($riwayat->status_sk === 'tidak_lengkap')
                                                    <a href="{{ route('pegawai.riwayat-gbk.edit', $riwayat->id) }}"
                                                        class="avtar mx-1 avtar-xs btn-link-warning" title="Lengkapi SK">
                                                        <i class="ti ti-edit f-20"></i>
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
            </div>

            <!-- Tombol Aksi -->
            @if($riwayatGbks instanceof \Illuminate\Contracts\Pagination\Paginator)
                    <div>{{ $riwayatGbks->withQueryString()->links() }}</div>
            @endif
            <div class="mt-4 d-flex justify-content-end">
                <a href="{{ route('pegawai.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>

        </div>
    </div>
@endsection
