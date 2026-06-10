@extends('layouts.app')
@section('title', 'Tambah Golongan Baru')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Tambah Golongan Baru</h2>
                                <small class="text-muted">Silakan lengkapi formulir berikut untuk menambahkan golongan
                                    baru.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Formulir -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-list-check me-2"></i>Tambah Golongan
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.golongans.store') }}" method="POST">
                        @csrf

                        <div class="text-muted small mb-3">
                            Keterangan: <span class="text-danger">*</span> Wajib diisi
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="golongan">Golongan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('golongan') is-invalid @enderror"
                                    id="golongan" name="golongan" value="{{ old('golongan') }}" placeholder="Contoh: III/a"
                                    required>
                                @error('golongan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="pangkat">Pangkat</label>
                                <input type="text" class="form-control @error('pangkat') is-invalid @enderror"
                                    id="pangkat" name="pangkat" value="{{ old('pangkat') }}"
                                    placeholder="Contoh: Penata Muda">
                                @error('pangkat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="asn">Jenis ASN <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('asn') is-invalid @enderror" id="asn" name="asn"
                                    required>
                                    <option value="">Pilih Jenis ASN</option>
                                    <option value="PNS" {{ old('asn') == 'PNS' ? 'selected' : '' }}>PNS</option>
                                    <option value="PPPK" {{ old('asn') == 'PPPK' ? 'selected' : '' }}>PPPK</option>
                                </select>
                                @error('asn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('admin.golongans.index') }}" class="btn btn-light me-2">
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
