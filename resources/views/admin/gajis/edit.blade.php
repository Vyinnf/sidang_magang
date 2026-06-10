@extends('layouts.app')
@section('title', 'Edit Gaji Pokok')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Edit Gaji Pokok</h2>
                                <small class="text-muted">Silakan perbarui informasi gaji pokok berikut.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Formulir -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-wallet me-2"></i>Edit Gaji Pokok
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.gajis.update', $gaji->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="golongan_id">Golongan <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('golongan_id') is-invalid @enderror" id="golongan_id"
                                    name="golongan_id" required>
                                    <option value="">Pilih Golongan</option>
                                    @foreach ($golongans as $golongan)
                                        <option value="{{ $golongan->id }}"
                                            {{ old('golongan_id', $gaji->golongan_id) == $golongan->id ? 'selected' : '' }}>
                                            {{ $golongan->golongan }} ({{ $golongan->pangkat }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('golongan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="masa_kerja">Masa Kerja (Tahun) <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('masa_kerja') is-invalid @enderror"
                                    id="masa_kerja" name="masa_kerja" value="{{ old('masa_kerja', $gaji->masa_kerja) }}"
                                    placeholder="Contoh: 0, 1, 2, dst." min="0" required>
                                @error('masa_kerja')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="asn">Jenis ASN <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('asn') is-invalid @enderror" id="asn" name="asn"
                                    required>
                                    <option value="">Pilih Jenis ASN</option>
                                    <option value="PNS" {{ old('asn', $gaji->asn) == 'PNS' ? 'selected' : '' }}>PNS
                                    </option>
                                    <option value="PPPK" {{ old('asn', $gaji->asn) == 'PPPK' ? 'selected' : '' }}>PPPK
                                    </option>
                                </select>
                                @error('asn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="gaji_pokok">Gaji Pokok (Rp) <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('gaji_pokok') is-invalid @enderror"
                                    id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok', $gaji->gaji_pokok) }}"
                                    placeholder="Contoh: 2500000" min="0" required>
                                @error('gaji_pokok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('admin.gajis.index') }}" class="btn btn-light me-2">
                                <i class="ti ti-arrow-left me-1"></i> Batal
                            </a>
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
