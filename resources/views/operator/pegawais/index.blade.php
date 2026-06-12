@extends('layouts.app')
@section('title', 'Daftar Pegawai')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Daftar Pegawai</h2>
                                <small class="text-muted">Kelola data pegawai di unit kerja ini</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Daftar Pegawai -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-users me-2"></i>Daftar Pegawai
                    </h5>
                    <!-- Tombol Dropdown untuk Tambah Pegawai -->
                    <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="ti ti-plus me-1"></i>
                            Tambah Pegawai
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('operator.pegawais.create') }}">Pegawai Baru</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('operator.pegawais.createLama') }}">Pegawai Lama</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <x-table.filter-toolbar
                        placeholder="Cari nama, email, NIP, atau jabatan..."
                        :sort-options="[
                            'id' => 'ID',
                            'created_at' => 'Waktu Dibuat',
                            'name' => 'Nama Pegawai',
                            'email' => 'Email',
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
                                    <li><a class="dropdown-item" href="{{ route('operator.pegawais.export', array_merge(request()->query(), ['format' => 'excel'])) }}">Excel</a></li>
                                    <li><a class="dropdown-item" href="{{ route('operator.pegawais.export', array_merge(request()->query(), ['format' => 'pdf'])) }}">PDF</a></li>
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
                        <div class="col-md-4">
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
                    </x-table.filter-toolbar>

                    <div class="table-responsive">
                        @php
                            $currentQuery = request()->query();
                        @endphp
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>
                                        NIP
                                        <a href="{{ route('operator.pegawais.index', array_merge($currentQuery, ['sort' => 'id', 'dir' => 'asc'])) }}" class="text-muted ms-1">
                                            <i class="ti ti-arrow-up f-12"></i>
                                        </a>
                                        <a href="{{ route('operator.pegawais.index', array_merge($currentQuery, ['sort' => 'id', 'dir' => 'desc'])) }}" class="text-muted ms-1">
                                            <i class="ti ti-arrow-down f-12"></i>
                                        </a>
                                    </th>
                                    <th>
                                        Nama Lengkap
                                        <a href="{{ route('operator.pegawais.index', array_merge($currentQuery, ['sort' => 'name', 'dir' => 'asc'])) }}" class="text-muted ms-1">
                                            <i class="ti ti-arrow-up f-12"></i>
                                        </a>
                                        <a href="{{ route('operator.pegawais.index', array_merge($currentQuery, ['sort' => 'name', 'dir' => 'desc'])) }}" class="text-muted ms-1">
                                            <i class="ti ti-arrow-down f-12"></i>
                                        </a>
                                    </th>
                                    <th>
                                        Jabatan
                                        <a href="{{ route('operator.pegawais.index', array_merge($currentQuery, ['sort' => 'email', 'dir' => 'asc'])) }}" class="text-muted ms-1">
                                            <i class="ti ti-arrow-up f-12"></i>
                                        </a>
                                        <a href="{{ route('operator.pegawais.index', array_merge($currentQuery, ['sort' => 'email', 'dir' => 'desc'])) }}" class="text-muted ms-1">
                                            <i class="ti ti-arrow-down f-12"></i>
                                        </a>
                                    </th>
                                    <th>Jenis ASN</th>
                                    <th>Golongan</th>
                                    <th>Pangkat</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $user->pegawai->nip ?? 'Belum Lengkap' }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->pegawai->jabatan ?? 'Belum Lengkap' }}</td>
                                        <td>{{ $user->pegawai->asn ?? 'Belum Lengkap' }}</td>
                                        <td>{{ $user->pegawai->golongan->golongan ?? 'Belum Lengkap' }}</td>
                                        <td>{{ $user->pegawai->golongan->pangkat ?? 'Belum Lengkap' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('operator.pegawais.show', $user->id) }}"
                                                class="avtar mx-1 avtar-xs btn-link-secondary" title="Detail">
                                                <i class="ti ti-eye f-20"></i>
                                            </a>
                                            <a href="{{ route('operator.pegawais.edit', $user->id) }}"
                                                class="avtar mx-1 avtar-xs btn-link-secondary" title="Edit">
                                                <i class="ti ti-edit f-20"></i>
                                            </a>
                                            <form action="{{ route('operator.pegawais.destroy', $user->id) }}"
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
                                        <td colspan="7" class="text-center text-muted">Tidak ada data pengguna pegawai di
                                            unit kerja ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end px-4">
                        @if($users instanceof \Illuminate\Contracts\Pagination\Paginator)
                                <div>{{ $users->withQueryString()->links() }}</div>
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
