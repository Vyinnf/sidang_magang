@extends('layouts.app')
@section('title','Detail Riwayat Kenaikan Pangkat')
@section('content')
<div class="pc-container">
  <div class="pc-content">
    <div class="page-header mb-4">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <div class="page-header-title">
              <h2 class="mb-0 fw-bold">Detail Riwayat</h2>
              <small class="text-muted">Rincian SK kenaikan pangkat</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header bg-light">
        <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-file-description me-2"></i>Informasi SK</h5>
      </div>
      <div class="card-body">
        <dl class="row mb-0">
          <dt class="col-sm-4">TMT SK</dt>
          <dd class="col-sm-8">{{ $item->tmt_sk?->format('d F Y') ?? '-' }}</dd>

          <dt class="col-sm-4">Tanggal SK</dt>
          <dd class="col-sm-8">{{ $item->tanggal_sk?->format('d F Y') ?? '-' }}</dd>

          <dt class="col-sm-4">Nomor SK</dt>
          <dd class="col-sm-8">{{ $item->nomor_sk ?? '-' }}</dd>

          <dt class="col-sm-4">Pejabat SK</dt>
          <dd class="col-sm-8">{{ $item->pejabat_sk ?? '-' }}</dd>

          <dt class="col-sm-4">Golongan Lama</dt>
          <dd class="col-sm-8">{{ $item->golonganLama?->golongan ?? '-' }}</dd>

          <dt class="col-sm-4">Golongan Baru</dt>
          <dd class="col-sm-8">{{ $item->golonganBaru?->golongan ?? '-' }}</dd>

          <dt class="col-sm-4">MKG Baru (Tahun/Bulan)</dt>
          <dd class="col-sm-8">{{ $item->masa_kerja_golongan_baru_tahun }}/{{ $item->masa_kerja_golongan_baru_bulan }}</dd>

          <dt class="col-sm-4">Status SK</dt>
          <dd class="col-sm-8">@if($item->status_sk==='lengkap')<span class="badge bg-success">Lengkap</span>@else<span class="badge bg-warning text-dark">Tidak Lengkap</span>@endif</dd>

          @if($item->permohonan)
            <dt class="col-sm-4">Permohonan Asal</dt>
            <dd class="col-sm-8">
              <a href="{{ route('pegawai.permohonan-kenaikan-pangkat.show', $item->permohonan->id) }}" class="text-decoration-none">
                Lihat Permohonan <i class="ti ti-external-link"></i>
              </a>
            </dd>
          @endif
        </dl>
      </div>
    </div>

    <div class="card border-0 shadow-sm">
      <div class="card-header bg-light">
        <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-download me-2"></i>Unduh Dokumen</h5>
      </div>
      <div class="card-body">
        <a href="{{ route('pegawai.riwayat-kenaikan-pangkat.download',$item->id) }}" class="btn btn-sm btn-outline-primary"><i class="ti ti-download"></i> Unduh SK</a>
      </div>
    </div>

    <div class="mt-4 d-flex justify-content-end">
      <a href="{{ route('pegawai.riwayat-kenaikan-pangkat.index') }}" class="btn btn-sm btn-outline-secondary"><i class="ti ti-arrow-left"></i> Kembali</a>
    </div>
  </div>
</div>
@endsection
