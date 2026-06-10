@extends('layouts.app')

@section('title', 'Daftar Permohonan SK')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Daftar Permohonan SK</h2>
                                <small class="text-muted">Kelola permohonan SK dari seluruh pegawai</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Tabel Permohonan -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-list me-2"></i>Daftar Permohonan
                    </h5>
                    {{-- Tidak ada tombol tambah di sini karena ini adalah halaman operator --}}
                </div>
                <div class="card-body">
                    <x-table.filter-toolbar
                        placeholder="Cari nama pegawai atau NIP..."
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

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Pegawai</th>
                                    <th class="text-center">Tanggal Pengajuan</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Catatan Operator</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($permohonanSk as $index => $permohonan)
                                    <tr>
                                        <td class="text-center">{{ ($permohonanSk->firstItem() ?? 0) + $index }}</td>
                                        <td>{{ $permohonan->pegawai?->user?->name ?? '-' }}</td>
                                        <td class="text-center">
                                            {{ $permohonan->tanggal_pengajuan?->format('d F Y') ?? '-' }}</td>
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
                                            {{-- Mengarahkan ke halaman detail dan proses operator --}}
                                            @if ($permohonan->status === 'diajukan')
                                                <a href="{{ route('operator.permohonan-sk.show', $permohonan->id) }}"
                                                    class="avtar mx-1 avtar-xs btn-link-warning" title="Proses Permohonan">
                                                    <i class="ti ti-edit-circle f-20"></i>
                                                </a>
                                            @endif

                                            @if ($permohonan->status === 'diproses')
                                                <a href="{{ route('operator.permohonan-sk.process-sk', $permohonan->id) }}"
                                                    class="avtar mx-1 avtar-xs btn-link-secondary"
                                                    title="Lanjutkan Proses Pencetakan SK">
                                                    <i class="ti ti-printer f-20"></i>
                                                </a>
                                            @endif

                                            @if ($permohonan->status === 'disetujui' && $riwayat = $permohonan->pegawai->riwayatGbks()->latest()->first())
                                                <a href="{{ route('operator.permohonan-sk.download', $riwayat->id) }}"
                                                    class="avtar mx-1 avtar-xs btn-link-secondary" title="Unduh SK">
                                                    <i class="ti ti-download f-20"></i>
                                                </a>
                                            @endif

                                            @if ($permohonan->status === 'disetujui' || $permohonan->status === 'ditolak')
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
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Tidak ada permohonan SK yang perlu
                                            diproses.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tombol Kembali -->
            @if($permohonanSk instanceof \Illuminate\Contracts\Pagination\Paginator)
                    <div>{{ $permohonanSk->withQueryString()->links() }}</div>
            @endif
            <div class="mt-4 d-flex justify-content-end">
                <a href="{{ route('operator.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
