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
                                <small class="text-muted">Kelola riwayat gaji berkala pegawai</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Riwayat Gaji Berkala -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-file-text me-2"></i>Riwayat Gaji Berkala
                    </h5>
                </div>
                <div class="card-body">
                    <x-table.filter-toolbar
                        placeholder="Cari nama pegawai, NIP, atau nomor SK..."
                        :sort-options="[
                            'id' => 'ID',
                            'tmt_sk' => 'TMT SK',
                            'tanggal_sk' => 'Tanggal SK',
                            'gaji_pokok_baru' => 'Gaji Baru',
                            'status_sk' => 'Status SK',
                            'created_at' => 'Waktu Dibuat',
                        ]"
                        :q="$tableQuery['q'] ?? request('q', '')"
                        :sort="$tableQuery['sort'] ?? request('sort', 'tmt_sk')"
                        :dir="$tableQuery['dir'] ?? request('dir', 'desc')"
                        :per-page="$tableQuery['per_page'] ?? (int) request('per_page', 10)"
                    >
                        <x-slot name="actions">
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-download me-1"></i>Download
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('operator.riwayat_gbks.export', array_merge(request()->query(), ['format' => 'excel'])) }}">Excel</a></li>
                                    <li><a class="dropdown-item" href="{{ route('operator.riwayat_gbks.export', array_merge(request()->query(), ['format' => 'pdf'])) }}">PDF</a></li>
                                </ul>
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.print()">
                                <i class="ti ti-printer me-1"></i>Print
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

                    <div class="table-responsive">
                        @php
                            $currentQuery = request()->query();
                        @endphp
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>
                                        Pegawai
                                        <a href="{{ route('operator.riwayat_gbks.index', array_merge($currentQuery, ['sort' => 'id', 'dir' => 'asc'])) }}" class="text-muted ms-1">
                                            <i class="ti ti-arrow-up f-12"></i>
                                        </a>
                                        <a href="{{ route('operator.riwayat_gbks.index', array_merge($currentQuery, ['sort' => 'id', 'dir' => 'desc'])) }}" class="text-muted ms-1">
                                            <i class="ti ti-arrow-down f-12"></i>
                                        </a>
                                    </th>
                                    <th>Golongan Lama</th>
                                    <th>Golongan Baru</th>
                                    <th>Gaji Lama</th>
                                    <th>
                                        Gaji Baru
                                        <a href="{{ route('operator.riwayat_gbks.index', array_merge($currentQuery, ['sort' => 'gaji_pokok_baru', 'dir' => 'asc'])) }}" class="text-muted ms-1">
                                            <i class="ti ti-arrow-up f-12"></i>
                                        </a>
                                        <a href="{{ route('operator.riwayat_gbks.index', array_merge($currentQuery, ['sort' => 'gaji_pokok_baru', 'dir' => 'desc'])) }}" class="text-muted ms-1">
                                            <i class="ti ti-arrow-down f-12"></i>
                                        </a>
                                    </th>
                                    <th>Masa Kerja</th>
                                    <th>
                                        Status SK
                                        <a href="{{ route('operator.riwayat_gbks.index', array_merge($currentQuery, ['sort' => 'status_sk', 'dir' => 'asc'])) }}" class="text-muted ms-1">
                                            <i class="ti ti-arrow-up f-12"></i>
                                        </a>
                                        <a href="{{ route('operator.riwayat_gbks.index', array_merge($currentQuery, ['sort' => 'status_sk', 'dir' => 'desc'])) }}" class="text-muted ms-1">
                                            <i class="ti ti-arrow-down f-12"></i>
                                        </a>
                                    </th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($riwayats as $riwayat)
                                    <tr>
                                        <td>{{ $riwayat->pegawai->user->name ?? 'Belum Lengkap' }}</td>
                                        <td>{{ $riwayat->golonganLama->golongan ?? '-' }}</td>
                                        <td>{{ $riwayat->golonganBaru->golongan ?? '-' }}</td>
                                        <td>{{ number_format($riwayat->gaji_pokok_lama, 0, ',', '.') }}</td>
                                        <td>{{ number_format($riwayat->gaji_pokok_baru, 0, ',', '.') }}</td>
                                        <td>
                                            Lama: {{ $riwayat->masa_kerja_golongan_lama_tahun }} thn
                                            {{ $riwayat->masa_kerja_golongan_lama_bulan }} bln <br>
                                            Baru: {{ $riwayat->masa_kerja_golongan_baru_tahun }} thn
                                            {{ $riwayat->masa_kerja_golongan_baru_bulan }} bln
                                        </td>
                                        <td>{{ ucfirst($riwayat->status_sk) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('operator.riwayat_gbks.show', $riwayat->id) }}"
                                                class="avtar mx-1 avtar-xs btn-link-secondary" title="Detail">
                                                <i class="ti ti-eye f-20"></i>
                                            </a>
                                            <a href="{{ route('operator.riwayat_gbks.edit', $riwayat->id) }}"
                                                class="avtar mx-1 avtar-xs btn-link-secondary" title="Edit">
                                                <i class="ti ti-edit f-20"></i>
                                            </a>
                                            <form action="{{ route('operator.riwayat_gbks.destroy', $riwayat->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="avtar mx-1 avtar-xs btn-link-secondary border-0 bg-transparent p-0 shadow-none"
                                                    title="Hapus">
                                                    <i class="ti ti-trash f-20"></i>
                                                </button>
                                            </form>
                                            @if ($riwayat->sk_path)
                                                <a href="{{ route('sk.download', $riwayat->id) }}"
                                                    class="avtar mx-1 avtar-xs btn-link-secondary" target="_blank"
                                                    title="Download SK">
                                                    <i class="ti ti-download f-20"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">Tidak ada data riwayat gaji
                                            berkala.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="text-end px-4">
                                                @if($riwayats instanceof \Illuminate\Contracts\Pagination\Paginator)
                                                        <div>{{ $riwayats->withQueryString()->links() }}</div>
                                                @endif
                    </div>
                </div>
            </div>

            <!-- Tombol Kembali -->
            <div class="mt-4 d-flex justify-content-end">
                <a href="{{ route('operator.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>

        </div>
    </div>
@endsection
