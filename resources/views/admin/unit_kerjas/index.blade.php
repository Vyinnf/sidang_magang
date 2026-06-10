@extends('layouts.app')
@section('title', 'Manajemen Unit Kerja')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Manajemen Unit Kerja</h2>
                                <small class="text-muted">Kelola semua unit kerja yang ada dalam sistem</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Daftar Unit Kerja -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-building me-2"></i>Daftar Unit Kerja
                    </h5>
                    <a href="{{ route('admin.unit-kerjas.create') }}" class="btn btn-primary btn-sm">
                        <i class="ti ti-plus me-1"></i>Tambah Unit Kerja
                    </a>
                </div>

                <div class="card-body">
                    <x-table.filter-toolbar
                        placeholder="Cari nama unit kerja..."
                        :sort-options="[
                            'created_at' => 'Waktu Dibuat',
                            'id' => 'ID',
                            'nama_unit_kerja' => 'Nama Unit Kerja',
                        ]"
                        :q="$tableQuery['q'] ?? request('q', '')"
                        :sort="$tableQuery['sort'] ?? request('sort', 'created_at')"
                        :dir="$tableQuery['dir'] ?? request('dir', 'desc')"
                        :per-page="$tableQuery['per_page'] ?? (int) request('per_page', 10)"
                    >
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
                                    <th>Nama Unit Kerja</th>
                                    <th>Dibuat Pada</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($unitKerjas as $unitKerja)
                                    <tr>
                                        <td>{{ $unitKerja->id }}</td>
                                        <td>{{ $unitKerja->nama_unit_kerja }}</td>
                                        <td>{{ $unitKerja->created_at->format('d M Y H:i') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.unit-kerjas.edit', $unitKerja->id) }}" title="Edit"
                                                class="avtar mx-1 avtar-xs btn-link-secondary">
                                                <i class="ti ti-edit f-20"></i>
                                            </a>
                                            <form action="{{ route('admin.unit-kerjas.destroy', $unitKerja->id) }}"
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
                                        <td colspan="4" class="text-center text-muted">Tidak ada data unit kerja.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                                        @if($unitKerjas instanceof \Illuminate\Contracts\Pagination\Paginator)
                                    <div>{{ $unitKerjas->withQueryString()->links() }}</div>
                                        @endif
                </div>
            </div>

        </div>
    </div>
@endsection
