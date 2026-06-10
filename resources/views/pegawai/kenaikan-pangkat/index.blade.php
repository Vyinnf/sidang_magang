@extends('layouts.app')
@section('title','Permohonan Kenaikan Pangkat')
@section('content')
<div class="pc-container">
  <div class="pc-content">
    <div class="page-header mb-4">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <div class="page-header-title">
              <h2 class="mb-0 fw-bold">Permohonan Kenaikan Pangkat</h2>
              <small class="text-muted">Daftar semua permohonan kenaikan pangkat Anda</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-list me-2"></i>Riwayat Permohonan</h5>
        <a href="{{ route('pegawai.permohonan-kenaikan-pangkat.create') }}" class="btn btn-sm btn-primary">
          <i class="ti ti-plus"></i> Ajukan Baru
        </a>
      </div>
      <div class="card-body">
        <x-table.filter-toolbar
          placeholder="Cari catatan pengajuan atau catatan operator..."
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
                <th>Tanggal Pengajuan</th>
                <th>Status</th>
                <th>Catatan Operator</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($permohonans as $i => $p)
                <tr>
                  <td class="text-center">{{ ($permohonans->firstItem() ?? 0) + $i }}</td>
                  <td>{{ $p->tanggal_pengajuan?->format('d F Y') }}</td>
                  <td>
                    @switch($p->status)
                      @case('disetujui') <span class="badge bg-success">Disetujui</span> @break
                      @case('ditolak') <span class="badge bg-danger">Ditolak</span> @break
                      @case('diproses') <span class="badge bg-primary">Diproses</span> @break
                      @default <span class="badge bg-warning text-dark">Diajukan</span>
                    @endswitch
                  </td>
                  <td>{{ $p->catatan_operator ?? '-' }}</td>
                  <td class="text-center">
                    <a href="{{ route('pegawai.permohonan-kenaikan-pangkat.show',$p->id) }}" class="avtar avtar-xs btn-link-secondary" title="Detail"><i class="ti ti-eye f-20"></i></a>
                    <a href="{{ route('pegawai.permohonan-kenaikan-pangkat.download',$p->id) }}" class="avtar avtar-xs btn-link-secondary" title="Unduh Berkas"><i class="ti ti-download f-20"></i></a>
                  </td>
                </tr>
              @empty
                <tr><td colspan="5" class="text-center text-muted">Belum ada permohonan.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    @if($permohonans instanceof \Illuminate\Contracts\Pagination\Paginator)
        <div>
          {{ $permohonans->withQueryString()->links() }}
        </div>
    @endif

    <div class="mt-4 d-flex justify-content-end">
      <a href="{{ route('pegawai.dashboard') }}" class="btn btn-sm btn-outline-secondary"><i class="ti ti-arrow-left"></i> Kembali</a>
    </div>
  </div>
</div>
@endsection
