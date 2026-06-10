@extends('layouts.app')
@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Manajemen Pengguna</h2>
                                <small class="text-muted">Kelola semua pengguna sistem, termasuk role dan unit kerja</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Daftar Pengguna -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-users me-2"></i>Daftar Pengguna
                    </h5>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                        <i class="ti ti-plus me-1"></i>Tambah Pengguna
                    </a>
                </div>

                <div class="card-body">
                    <x-table.filter-toolbar
                        placeholder="Cari nama atau email..."
                        :sort-options="[
                            'created_at' => 'Waktu Dibuat',
                            'name' => 'Nama',
                            'email' => 'Email',
                            'role' => 'Role',
                        ]"
                        :q="$tableQuery['q'] ?? request('q', '')"
                        :sort="$tableQuery['sort'] ?? request('sort', 'created_at')"
                        :dir="$tableQuery['dir'] ?? request('dir', 'desc')"
                        :per-page="$tableQuery['per_page'] ?? (int) request('per_page', 10)"
                    >
                        <div class="col-md-3">
                            <label class="form-label mb-1">Role</label>
                            <select name="role" class="form-select">
                                <option value="">Semua Role</option>
                                <option value="admin" @selected(($role ?? request('role')) === 'admin')>Admin</option>
                                <option value="operator" @selected(($role ?? request('role')) === 'operator')>Operator</option>
                                <option value="pegawai" @selected(($role ?? request('role')) === 'pegawai')>Pegawai</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label mb-1">Unit Kerja</label>
                            <select name="unit_kerja_id" class="form-select">
                                <option value="">Semua Unit Kerja</option>
                                @foreach (($unitKerjas ?? collect()) as $uk)
                                    <option value="{{ $uk->id }}" @selected((string) ($unitKerjaId ?? request('unit_kerja_id')) === (string) $uk->id)>
                                        {{ $uk->nama_unit_kerja }}
                                    </option>
                                @endforeach
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
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Unit Kerja</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge bg-primary text-white">{{ ucfirst($user->role) }}</span>
                                        </td>
                                        <td>{{ $user->unitKerja->nama_unit_kerja ?? '-' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.users.show', $user->id) }}" title="Detail"
                                                class="avtar mx-1 avtar-xs btn-link-secondary">
                                                <i class="ti ti-eye f-20"></i>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user->id) }}" title="Edit"
                                                class="avtar mx-1 avtar-xs btn-link-secondary">
                                                <i class="ti ti-edit f-20"></i>
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
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
                                        <td colspan="6" class="text-center text-muted">Tidak ada data pengguna.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                                        @if($users instanceof \Illuminate\Contracts\Pagination\Paginator)
                                    <div>{{ $users->withQueryString()->links() }}</div>
                                        @endif
                </div>
            </div>

        </div>
    </div>
@endsection
