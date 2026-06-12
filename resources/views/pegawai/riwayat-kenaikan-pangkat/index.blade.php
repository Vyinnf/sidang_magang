@extends('layouts.app')
@section('title', 'Riwayat Kenaikan Pangkat')
@section('content')
<div class="pc-container">
  <div class="pc-content">
    <div class="page-header mb-4">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <div class="page-header-title">
              <h2 class="mb-0 fw-bold">Riwayat Kenaikan Pangkat</h2>
              <small class="text-muted">Catatan seluruh SK kenaikan pangkat yang telah disetujui</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card border-0 shadow-sm">
      <div class="card-header bg-light">
        <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-history me-2"></i>Data Riwayat</h5>
      </div>
      <div class="card-body">
        <x-table.filter-toolbar placeholder="Cari nomor SK atau pejabat SK..." :sort-options="[
                        'tmt_sk' => 'TMT SK',
                        'tanggal_sk' => 'Tanggal SK',
                        'status_sk' => 'Status SK',
                        'created_at' => 'Waktu Dibuat',
                    ]" :q="$tableQuery['q'] ?? request('q', '')"
          :sort="$tableQuery['sort'] ?? request('sort', 'tmt_sk')" :dir="$tableQuery['dir'] ?? request('dir', 'desc')"
          :per-page="$tableQuery['per_page'] ?? (int) request('per_page', 10)">
          <x-slot name="actions">
            <div class="btn-group" role="group">
              <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                <i class="ti ti-download me-1"></i> Unduh
              </button>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item"
                    href="{{ route('pegawai.riwayat-kenaikan-pangkat.export', array_merge(request()->query(), ['format' => 'excel'])) }}">
                    <i class="ti ti-file-spreadsheet me-2"></i> Excel
                  </a>
                </li>
                <li>
                  <a class="dropdown-item"
                    href="{{ route('pegawai.riwayat-kenaikan-pangkat.export', array_merge(request()->query(), ['format' => 'pdf'])) }}">
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
              <option value="lengkap" @selected(($statusSk ?? request('status_sk'))==='lengkap' )>Lengkap</option>
              <option value="tidak_lengkap" @selected(($statusSk ?? request('status_sk'))==='tidak_lengkap' )>Tidak
                Lengkap</option>
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
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th class="text-center">No</th>
                <th>TMT</th>
                <th>Golongan Lama</th>
                <th>Golongan Baru</th>
                <th>MKG Baru (Thn/Bln)</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($riwayats as $i => $r)
              <tr>
                <td class="text-center">{{ ($riwayats->firstItem() ?? 0) + $i }}</td>
                <td>{{ $r->tmt_sk?->format('d F Y') ?? '-' }}</td>
                <td>{{ $r->golonganLama?->golongan ?? '-' }}</td>
                <td>{{ $r->golonganBaru?->golongan ?? '-' }}</td>
                <td>{{ $r->masa_kerja_golongan_baru_tahun }}/{{ $r->masa_kerja_golongan_baru_bulan }}
                </td>
                <td>
                  @if ($r->status_sk === 'lengkap')
                  <span class="badge bg-success">Lengkap</span>@else<span class="badge bg-warning text-dark">Tidak
                    Lengkap</span>
                  @endif
                </td>
                <td class="text-center">
                  <a href="{{ route('pegawai.riwayat-kenaikan-pangkat.show', $r->id) }}"
                    class="avtar avtar-xs btn-link-secondary" title="Detail"><i class="ti ti-eye f-20"></i></a>
                  <a href="{{ route('pegawai.riwayat-kenaikan-pangkat.download', $r->id) }}"
                    class="avtar avtar-xs btn-link-secondary" title="Unduh"><i class="ti ti-download f-20"></i></a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center text-muted">Belum ada riwayat.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
    @if ($riwayats instanceof \Illuminate\Contracts\Pagination\Paginator)
    <div>{{ $riwayats->withQueryString()->links() }}</div>
    @endif
    <div class="mt-4 d-flex justify-content-end">
      <a href="{{ route('pegawai.dashboard') }}" class="btn btn-sm btn-outline-secondary"><i
          class="ti ti-arrow-left"></i> Kembali</a>
    </div>
  </div>
</div>
@endsection