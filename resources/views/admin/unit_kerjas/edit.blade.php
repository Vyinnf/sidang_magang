@extends('layouts.app')
@section('title', 'Edit Unit Kerja')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Edit Unit Kerja</h2>
                                <small class="text-muted">Silakan perbarui informasi unit kerja berikut.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Formulir -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-building me-2"></i>Edit Unit Kerja
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.unit-kerjas.update', $unitKerja->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nama_unit_kerja">Nama Unit Kerja</label>
                                <input type="text" class="form-control @error('nama_unit_kerja') is-invalid @enderror"
                                    id="nama_unit_kerja" name="nama_unit_kerja"
                                    value="{{ old('nama_unit_kerja', $unitKerja->nama_unit_kerja) }}"
                                    placeholder="Masukkan nama unit kerja" required>
                                @error('nama_unit_kerja')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('admin.unit-kerjas.index') }}" class="btn btn-light me-2">
                                <i class="ti ti-arrow-left me-1"></i> Batal
                            </a>
                            <button type="reset" class="btn btn-secondary me-2">
                                <i class="ti ti-rotate me-1"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
