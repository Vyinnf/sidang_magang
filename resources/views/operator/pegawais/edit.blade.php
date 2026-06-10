@extends('layouts.app')
@section('title', 'Edit Pegawai')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Edit Pegawai</h2>
                                <small class="text-muted">Silakan perbarui data pegawai sesuai kebutuhan.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Form -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-user-exclamation me-2"></i> Edit Pegawai
                    </h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('operator.pegawais.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Bagian 1: Informasi Akun --}}
                        <h6 class="mb-3 fw-bold">Informasi Akun</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="mt-4 mb-4">

                        {{-- Bagian 2: Data Pokok Kepegawaian --}}
                        <h6 class="mb-3 fw-bold">Data Pokok Kepegawaian</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nip" class="form-label">NIP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nip" name="nip"
                                    value="{{ old('nip', $user->pegawai->nip ?? '') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="asn" class="form-label">Jenis ASN <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('asn') is-invalid @enderror" id="asn" name="asn"
                                    required>
                                    <option value="">Pilih Jenis ASN</option>
                                    <option value="PNS"
                                        {{ old('asn', $user->pegawai->asn ?? '') == 'PNS' ? 'selected' : '' }}>PNS</option>
                                    <option value="PPPK"
                                        {{ old('asn', $user->pegawai->asn ?? '') == 'PPPK' ? 'selected' : '' }}>PPPK
                                    </option>
                                </select>
                                @error('asn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input type="text" class="form-control @error('jabatan') is-invalid @enderror"
                                    id="jabatan" name="jabatan"
                                    value="{{ old('jabatan', $user->pegawai->jabatan ?? '') }}">
                                @error('jabatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                    id="tempat_lahir" name="tempat_lahir"
                                    value="{{ old('tempat_lahir', $user->pegawai->tempat_lahir ?? '') }}">
                                @error('tempat_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    id="tanggal_lahir" name="tanggal_lahir"
                                    value="{{ old('tanggal_lahir', optional($user->pegawai)->tanggal_lahir ? \Carbon\Carbon::parse($user->pegawai->tanggal_lahir)->format('Y-m-d') : '') }}">
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="golongan_id" class="form-label">Golongan <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('golongan_id') is-invalid @enderror" id="golongan_id"
                                    name="golongan_id" required>
                                    <option value="">Pilih Golongan</option>
                                    @foreach ($golongans as $golongan)
                                        <option value="{{ $golongan->id }}"
                                            {{ old('golongan_id', $user->pegawai->golongan_id ?? '') == $golongan->id ? 'selected' : '' }}>
                                            {{ $golongan->golongan }} ({{ $golongan->pangkat }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('golongan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="unit_kerja_id" class="form-label">Unit Kerja <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    value="{{ $user->unitKerja->nama_unit_kerja ?? '' }}" readonly>
                                <input type="hidden" name="unit_kerja_id" value="{{ $user->unit_kerja_id }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('operator.pegawais.index') }}" class="btn btn-light me-2">
                                <i class="ti ti-arrow-left me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
