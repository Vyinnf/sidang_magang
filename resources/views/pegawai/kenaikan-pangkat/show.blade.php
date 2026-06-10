@extends('layouts.app')
@section('title','Detail Permohonan Kenaikan Pangkat')
@section('content')
<div class="pc-container">
  <div class="pc-content">
    <div class="page-header mb-4">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <div class="page-header-title">
              <h2 class="mb-0 fw-bold">Detail Permohonan</h2>
              <small class="text-muted">Informasi lengkap permohonan kenaikan pangkat</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-header bg-light">
            <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-info-circle me-2"></i>Data Permohonan</h5>
          </div>
          <div class="card-body">
            <dl class="row mb-0">
              <dt class="col-sm-4">Tanggal Pengajuan</dt>
              <dd class="col-sm-8">{{ $permohonan->tanggal_pengajuan?->format('d F Y') ?? '-' }}</dd>

              <dt class="col-sm-4">Status</dt>
              <dd class="col-sm-8">
                @switch($permohonan->status)
                  @case('disetujui') <span class="badge bg-success">Disetujui</span> @break
                  @case('ditolak') <span class="badge bg-danger">Ditolak</span> @break
                  @case('diproses') <span class="badge bg-primary">Diproses</span> @break
                  @default <span class="badge bg-warning text-dark">Diajukan</span>
                @endswitch
              </dd>

              <dt class="col-sm-4">Catatan Pegawai</dt>
              <dd class="col-sm-8">{{ $permohonan->catatan_pegawai ?? '-' }}</dd>

              <dt class="col-sm-4">Catatan Operator</dt>
              <dd class="col-sm-8">{{ $permohonan->catatan_operator ?? '-' }}</dd>

              @if($permohonan->riwayat)
                <dt class="col-sm-4">Riwayat SK</dt>
                <dd class="col-sm-8">
                  <a href="{{ route('pegawai.riwayat-kenaikan-pangkat.show', $permohonan->riwayat->id) }}" class="text-decoration-none">
                    Lihat SK Final <i class="ti ti-external-link"></i>
                  </a>
                </dd>
              @endif
            </dl>
          </div>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-header bg-light">
            <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-file-description me-2"></i>Dokumen</h5>
          </div>
          <div class="card-body">
            <p class="mb-2 fw-semibold">File SK Pengajuan:</p>
            <a href="{{ route('pegawai.permohonan-kenaikan-pangkat.download', $permohonan->id) }}" class="btn btn-sm btn-outline-primary">
              <i class="ti ti-download"></i> Unduh Berkas
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-4 d-flex justify-content-end">
      <a href="{{ route('pegawai.permohonan-kenaikan-pangkat.index') }}" class="btn btn-sm btn-outline-secondary"><i class="ti ti-arrow-left"></i> Kembali</a>
    </div>
  </div>
</div>
@endsection
