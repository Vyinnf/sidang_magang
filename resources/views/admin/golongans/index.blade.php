@extends('layouts.app')
@section('title', 'Manajemen Golongan')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Manajemen Golongan</h2>
                                <small class="text-muted">Kelola semua golongan ASN, termasuk pangkat dan jenis ASN</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Daftar Golongan -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-list-check me-2"></i>Daftar Golongan
                    </h5>
                    <a href="{{ route('admin.golongans.create') }}" class="btn btn-primary btn-sm">
                        <i class="ti ti-plus me-1"></i>Tambah Golongan
                    </a>
                </div>

                <div class="card-body">
                    <x-table.filter-toolbar
                        placeholder="Cari golongan atau pangkat..."
                        :sort-options="[
                            'created_at' => 'Waktu Dibuat',
                            'golongan' => 'Golongan',
                            'pangkat' => 'Pangkat',
                            'asn' => 'Jenis ASN',
                        ]"
                        :q="$tableQuery['q'] ?? request('q', '')"
                        :sort="$tableQuery['sort'] ?? request('sort', 'created_at')"
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
                                    <li><a class="dropdown-item" href="{{ route('admin.golongans.export', array_merge(request()->query(), ['format' => 'excel'])) }}">Excel</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.golongans.export', array_merge(request()->query(), ['format' => 'pdf'])) }}">PDF</a></li>
                                </ul>
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.print()">
                                <i class="ti ti-printer me-1"></i>Print
                            </button>
                        </x-slot>

                        <div class="col-md-3">
                            <label class="form-label mb-1">Jenis ASN</label>
                            <select name="asn" class="form-select">
                                <option value="">Semua ASN</option>
                                <option value="PNS" @selected(($asn ?? request('asn')) === 'PNS')>PNS</option>
                                <option value="PPPK" @selected(($asn ?? request('asn')) === 'PPPK')>PPPK</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label mb-1">Dibuat Dari</label>
                            <input type="date" name="from" class="form-control" value="{{ $tableQuery['from'] ?? request('from') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label mb-1">Dibuat Sampai</label>
                            <input type="date" name="to" class="form-control" value="{{ $tableQuery['to'] ?? request('to') }}">
                        </div>
                    </x-table.filter-toolbar>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Golongan</th>
                                    <th>Pangkat</th>
                                    <th>ASN</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($golongans as $golongan)
                                    <tr>
                                        <td>{{ $golongan->id }}</td>
                                        <td>{{ $golongan->golongan }}</td>
                                        <td>{{ $golongan->pangkat ?? '-' }}</td>
                                        <td>{{ $golongan->asn }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.golongans.edit', $golongan->id) }}" title="Edit"
                                                class="avtar mx-1 avtar-xs btn-link-secondary">
                                                <i class="ti ti-edit f-20"></i>
                                            </a>
                                            <form action="{{ route('admin.golongans.destroy', $golongan->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="avtar mx-1 avtar-xs btn-link-secondary border-0 bg-transparent p-0 shadow-none"
                                                    title="Hapus">
                                                    <i class="ti ti-trash f-20"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Tidak ada data golongan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                                        @if($golongans instanceof \Illuminate\Contracts\Pagination\Paginator)
                                    <div>{{ $golongans->withQueryString()->links() }}</div>
                                        @endif
                </div>
            </div>

        </div>
    </div>
@endsection
