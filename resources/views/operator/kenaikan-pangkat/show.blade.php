@extends('layouts.app')
@section('title','Proses Permohonan Kenaikan Pangkat')
@section('content')
<div class="pc-container">
  <div class="pc-content">
    <div class="page-header mb-4">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <div class="page-header-title">
              <h2 class="mb-0 fw-bold">Proses Permohonan</h2>
              <small class="text-muted">Detail & tindakan permohonan kenaikan pangkat</small>
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
              <dt class="col-sm-4">Nama Pegawai</dt>
              <dd class="col-sm-8">{{ $permohonan->pegawai?->user?->name ?? '-' }}</dd>

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
            </dl>
          </div>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-header bg-light">
            <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-file-description me-2"></i>Dokumen Pengajuan</h5>
          </div>
          <div class="card-body">
            <a href="{{ route('operator.kenaikan-pangkat.download',$permohonan->id) }}" class="btn btn-sm btn-outline-primary"><i class="ti ti-download"></i> Unduh Berkas</a>
          </div>
        </div>
      </div>
    </div>

    @if(in_array($permohonan->status,['diajukan','diproses']))
    <div class="card border-0 shadow-sm mt-4">
      <div class="card-header bg-light">
        <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-tool me-2"></i>Tindak Lanjut</h5>
      </div>
      <div class="card-body">
        @if($permohonan->status==='diajukan')
          <form action="{{ route('operator.kenaikan-pangkat.process',$permohonan->id) }}" method="POST" class="mb-4">
            @csrf
            <div class="row g-3 align-items-end">
              <div class="col-md-8">
                <label class="form-label fw-semibold">Catatan Operator</label>
                <textarea name="catatan_operator" class="form-control" rows="2" placeholder="Catatan...">{{ old('catatan_operator',$permohonan->catatan_operator) }}</textarea>
              </div>
              <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary mt-auto btn-sm"><i class="ti ti-player-play"></i> Tandai Diproses</button>
              </div>
            </div>
          </form>
        @endif

        @if($permohonan->status==='diproses')
          <div class="alert alert-info small">Isi form persetujuan di bawah untuk menyetujui kenaikan pangkat.</div>
          <form action="{{ route('operator.kenaikan-pangkat.approve',$permohonan->id) }}" method="POST" enctype="multipart/form-data" class="mb-4 border rounded p-3 bg-light-subtle">
            @csrf
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label fw-semibold">Golongan Baru</label>
                <select name="golongan_baru_id" class="form-select @error('golongan_baru_id') is-invalid @enderror" required>
                  <option value="" disabled selected>Pilih...</option>
                  @foreach(\App\Models\Golongan::orderBy('golongan')->get() as $g)
                    <option value="{{ $g->id }}" @selected(old('golongan_baru_id')==$g->id)>{{ $g->golongan }} - {{ $g->pangkat }}</option>
                  @endforeach
                </select>
                @error('golongan_baru_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-4">
                <label class="form-label fw-semibold">TMT SK</label>
                <input type="date" name="tmt_sk" class="form-control @error('tmt_sk') is-invalid @enderror" required value="{{ old('tmt_sk') }}">
                @error('tmt_sk')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-4">
                <label class="form-label fw-semibold">Tanggal SK</label>
                <input type="date" name="tanggal_sk" class="form-control @error('tanggal_sk') is-invalid @enderror" value="{{ old('tanggal_sk') }}">
                @error('tanggal_sk')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-4">
                <label class="form-label fw-semibold">Nomor SK</label>
                <input type="text" name="nomor_sk" class="form-control @error('nomor_sk') is-invalid @enderror" value="{{ old('nomor_sk') }}">
                @error('nomor_sk')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-4">
                <label class="form-label fw-semibold">Pejabat SK</label>
                <input type="text" name="pejabat_sk" class="form-control @error('pejabat_sk') is-invalid @enderror" value="{{ old('pejabat_sk') }}">
                @error('pejabat_sk')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-2">
                <label class="form-label fw-semibold">MKG Thn</label>
                <input type="number" min="0" name="masa_kerja_golongan_baru_tahun" class="form-control @error('masa_kerja_golongan_baru_tahun') is-invalid @enderror" value="{{ old('masa_kerja_golongan_baru_tahun') }}" required>
                @error('masa_kerja_golongan_baru_tahun')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-2">
                <label class="form-label fw-semibold">MKG Bln</label>
                <input type="number" min="0" max="11" name="masa_kerja_golongan_baru_bulan" class="form-control @error('masa_kerja_golongan_baru_bulan') is-invalid @enderror" value="{{ old('masa_kerja_golongan_baru_bulan') }}" required>
                @error('masa_kerja_golongan_baru_bulan')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                <button type="submit" class="btn btn-success btn-sm"><i class="ti ti-check"></i> Setujui</button>
              </div>
            </div>
          </form>
          <form action="{{ route('operator.kenaikan-pangkat.reject',$permohonan->id) }}" method="POST" class="border rounded p-3 bg-light-subtle">
            @csrf
            <div class="row g-3 align-items-end">
              <div class="col-md-8">
                <label class="form-label fw-semibold">Catatan Penolakan</label>
                <textarea name="catatan_operator" class="form-control" rows="2" placeholder="Alasan penolakan...">{{ old('catatan_operator') }}</textarea>
              </div>
              <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-danger mt-auto btn-sm"><i class="ti ti-x"></i> Tolak</button>
              </div>
            </div>
          </form>
        @endif
      </div>
    </div>
    @endif

    <div class="mt-4 d-flex justify-content-end">
      <a href="{{ route('operator.kenaikan-pangkat.index') }}" class="btn btn-sm btn-outline-secondary"><i class="ti ti-arrow-left"></i> Kembali</a>
    </div>
  </div>
</div>
@endsection
