@extends('layouts.app')
@section('title', 'Manajemen Gaji Pokok')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Manajemen Gaji Pokok</h2>
                                <small class="text-muted">Kelola semua gaji pokok berdasarkan golongan, masa kerja, dan jenis
                                    ASN</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Daftar Gaji Pokok -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-cash me-2"></i>Daftar Gaji Pokok
                    </h5>
                    <a href="{{ route('admin.gajis.create') }}" class="btn btn-primary btn-sm">
                        <i class="ti ti-plus me-1"></i>Tambah Gaji Pokok
                    </a>
                </div>

                <div class="card-body">
                    <x-table.filter-toolbar
                        placeholder="Cari golongan atau pangkat..."
                        :sort-options="[
                            'id' => 'ID',
                            'created_at' => 'Waktu Dibuat',
                            'golongan_id' => 'Golongan',
                            'masa_kerja' => 'Masa Kerja',
                            'asn' => 'Jenis ASN',
                            'gaji_pokok' => 'Gaji Pokok',
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
                                    <li><a class="dropdown-item" href="{{ route('admin.gajis.export', array_merge(request()->query(), ['format' => 'excel'])) }}">Excel</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.gajis.export', array_merge(request()->query(), ['format' => 'pdf'])) }}">PDF</a></li>
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
                            <label class="form-label mb-1">Golongan</label>
                            <select name="golongan_id" class="form-select">
                                <option value="">Semua Golongan</option>
                                @foreach (($golongans ?? collect()) as $golongan)
                                    <option value="{{ $golongan->id }}" @selected((string) ($golonganId ?? request('golongan_id')) === (string) $golongan->id)>
                                        {{ $golongan->golongan }}{{ $golongan->pangkat ? ' - ' . $golongan->pangkat : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label mb-1">Masa Kerja Min</label>
                            <input type="number" min="0" max="32" name="masa_kerja_min" class="form-control" value="{{ $masaKerjaMin ?? request('masa_kerja_min') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label mb-1">Masa Kerja Max</label>
                            <input type="number" min="0" max="32" name="masa_kerja_max" class="form-control" value="{{ $masaKerjaMax ?? request('masa_kerja_max') }}">
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
                                        ID
                                        <a href="{{ route('admin.gajis.index', array_merge($currentQuery, ['sort' => 'id', 'dir' => 'asc'])) }}" class="text-muted ms-1">
                                            <i class="ti ti-arrow-up f-12"></i>
                                        </a>
                                        <a href="{{ route('admin.gajis.index', array_merge($currentQuery, ['sort' => 'id', 'dir' => 'desc'])) }}" class="text-muted ms-1">
                                            <i class="ti ti-arrow-down f-12"></i>
                                        </a>
                                    </th>
                                    <th>
                                        Golongan
                                        <a href="{{ route('admin.gajis.index', array_merge($currentQuery, ['sort' => 'golongan_id', 'dir' => 'asc'])) }}" class="text-muted ms-1">
                                            <i class="ti ti-arrow-up f-12"></i>
                                        </a>
                                        <a href="{{ route('admin.gajis.index', array_merge($currentQuery, ['sort' => 'golongan_id', 'dir' => 'desc'])) }}" class="text-muted ms-1">
                                            <i class="ti ti-arrow-down f-12"></i>
                                        </a>
                                    </th>
                                    <th>
                                        Masa Kerja (Tahun)
                                        <a href="{{ route('admin.gajis.index', array_merge($currentQuery, ['sort' => 'masa_kerja', 'dir' => 'asc'])) }}" class="text-muted ms-1">
                                            <i class="ti ti-arrow-up f-12"></i>
                                        </a>
                                        <a href="{{ route('admin.gajis.index', array_merge($currentQuery, ['sort' => 'masa_kerja', 'dir' => 'desc'])) }}" class="text-muted ms-1">
                                            <i class="ti ti-arrow-down f-12"></i>
                                        </a>
                                    </th>
                                    <th>
                                        Jenis ASN
                                        <a href="{{ route('admin.gajis.index', array_merge($currentQuery, ['sort' => 'asn', 'dir' => 'asc'])) }}" class="text-muted ms-1">
                                            <i class="ti ti-arrow-up f-12"></i>
                                        </a>
                                        <a href="{{ route('admin.gajis.index', array_merge($currentQuery, ['sort' => 'asn', 'dir' => 'desc'])) }}" class="text-muted ms-1">
                                            <i class="ti ti-arrow-down f-12"></i>
                                        </a>
                                    </th>
                                    <th>
                                        Gaji Pokok
                                        <a href="{{ route('admin.gajis.index', array_merge($currentQuery, ['sort' => 'gaji_pokok', 'dir' => 'asc'])) }}" class="text-muted ms-1">
                                            <i class="ti ti-arrow-up f-12"></i>
                                        </a>
                                        <a href="{{ route('admin.gajis.index', array_merge($currentQuery, ['sort' => 'gaji_pokok', 'dir' => 'desc'])) }}" class="text-muted ms-1">
                                            <i class="ti ti-arrow-down f-12"></i>
                                        </a>
                                    </th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($gajis as $gaji)
                                    <tr>
                                        <td>{{ $gaji->id }}</td>
                                        <td>{{ $gaji->golongan->golongan }}</td>
                                        <td>{{ $gaji->masa_kerja }}</td>
                                        <td>{{ $gaji->asn }}</td>
                                        <td>Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.gajis.edit', $gaji->id) }}" title="Edit"
                                                class="avtar mx-1 avtar-xs btn-link-secondary">
                                                <i class="ti ti-edit f-20"></i>
                                            </a>
                                            <form action="{{ route('admin.gajis.destroy', $gaji->id) }}" method="POST"
                                                class="d-inline">
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
                                        <td colspan="6" class="text-center text-muted">Tidak ada data gaji pokok.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                                        @if($gajis instanceof \Illuminate\Contracts\Pagination\Paginator)
                                    <div>{{ $gajis->withQueryString()->links() }}</div>
                                        @endif
                </div>
            </div>

        </div>
    </div>
@endsection
