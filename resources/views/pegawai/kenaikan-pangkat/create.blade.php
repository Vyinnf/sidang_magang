@extends('layouts.app')
@section('title','Ajukan Kenaikan Pangkat')
@section('content')
<div class="pc-container">
  <div class="pc-content">
    <div class="page-header mb-4">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <div class="page-header-title">
              <h2 class="mb-0 fw-bold">Ajukan Kenaikan Pangkat</h2>
              <small class="text-muted">Lengkapi formulir berikut untuk mengajukan</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card border-0 shadow-sm">
      <div class="card-header bg-light">
        <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-file-upload me-2"></i>Form Pengajuan</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('pegawai.permohonan-kenaikan-pangkat.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">File SK Kenaikan Pangkat (Wajib)</label>
              <input type="file" name="sk_kenaikan_file" class="form-control @error('sk_kenaikan_file') is-invalid @enderror" required>
              @error('sk_kenaikan_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
              <small class="text-muted">Format: pdf/doc/docx, maks 4MB</small>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Catatan Pegawai (Opsional)</label>
              <textarea name="catatan_pegawai" class="form-control @error('catatan_pegawai') is-invalid @enderror" rows="3" placeholder="Tambahkan catatan...">{{ old('catatan_pegawai') }}</textarea>
              @error('catatan_pegawai')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="mt-4 d-flex justify-content-end gap-2">
            <a href="{{ route('pegawai.permohonan-kenaikan-pangkat.index') }}" class="btn btn-outline-secondary btn-sm"><i class="ti ti-arrow-left"></i> Batal</a>
            <button type="reset" class="btn btn-secondary btn-sm"><i class="ti ti-rotate"></i> Reset</button>
            <button type="submit" class="btn btn-primary btn-sm"><i class="ti ti-send"></i> Ajukan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
