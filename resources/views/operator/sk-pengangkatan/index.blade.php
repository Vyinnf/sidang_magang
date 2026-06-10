@extends('layouts.app')

@section('title', 'Daftar SK Pengangkatan')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Daftar SK Pengangkatan</h2>
                                <small class="text-muted">Kelola SK Pengangkatan Pegawai (CPNS/PPPK)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Tabel SK -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-list me-2"></i>Daftar SK
                    </h5>
                </div>
                <div class="card-body">
                    <x-table.filter-toolbar
                        placeholder="Cari nama pegawai, NIP, nomor SK, atau pejabat SK..."
                        :sort-options="[
                            'created_at' => 'Waktu Dibuat',
                            'tanggal_sk' => 'Tanggal SK',
                            'tmt' => 'TMT',
                            'nomor_sk' => 'Nomor SK',
                        ]"
                        :q="$tableQuery['q'] ?? request('q', '')"
                        :sort="$tableQuery['sort'] ?? request('sort', 'created_at')"
                        :dir="$tableQuery['dir'] ?? request('dir', 'desc')"
                        :per-page="$tableQuery['per_page'] ?? (int) request('per_page', 10)"
                    >
                        <div class="col-md-3">
                            <label class="form-label mb-1">Jenis ASN</label>
                            <select name="asn" class="form-select">
                                <option value="">Semua ASN</option>
                                <option value="PNS" @selected(($asn ?? request('asn')) === 'PNS')>PNS</option>
                                <option value="PPPK" @selected(($asn ?? request('asn')) === 'PPPK')>PPPK</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label mb-1">Tanggal SK Dari</label>
                            <input type="date" name="from" class="form-control" value="{{ $tableQuery['from'] ?? request('from') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label mb-1">Tanggal SK Sampai</label>
                            <input type="date" name="to" class="form-control" value="{{ $tableQuery['to'] ?? request('to') }}">
                        </div>
                    </x-table.filter-toolbar>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Pegawai</th>
                                    <th>Nomor SK</th>
                                    <th class="text-center">Tanggal SK</th>
                                    <th class="text-center">TMT</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($skPengangkatan as $index => $sk)
                                    <tr>
                                        <td class="text-center">{{ ($skPengangkatan->firstItem() ?? 0) + $index }}</td>
                                        <td>{{ $sk->pegawai?->user?->name ?? '-' }}</td>
                                        <td>{{ $sk->nomor_sk ?? '-' }}</td>
                                        <td class="text-center">
                                            {{ $sk->tanggal_sk?->format('d F Y') ?? '-' }}
                                        </td>
                                        <td class="text-center">
                                            {{ $sk->tmt?->format('d F Y') ?? '-' }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('operator.sk-pengangkatan.show', $sk->id) }}"
                                                class="avtar mx-1 avtar-xs btn-link-info" title="Detail">
                                                <i class="ti ti-eye f-20"></i>
                                            </a>

                                            <a href="{{ route('operator.sk-pengangkatan.edit', $sk->id) }}"
                                                class="avtar mx-1 avtar-xs btn-link-warning" title="Edit">
                                                <i class="ti ti-edit f-20"></i>
                                            </a>

                                            @if ($sk->sk_path)
                                                <a href="{{ route('operator.sk-pengangkatan.download', $sk->id) }}"
                                                    class="avtar mx-1 avtar-xs btn-link-success" title="Download File SK">
                                                    <i class="ti ti-download f-20"></i>
                                                </a>
                                            @endif

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">
                                            Belum ada data SK Pengangkatan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tombol Kembali -->
            @if($skPengangkatan instanceof \Illuminate\Contracts\Pagination\Paginator)
                    <div>{{ $skPengangkatan->withQueryString()->links() }}</div>
            @endif
            <div class="mt-4 d-flex justify-content-end">
                <a href="{{ route('operator.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
