@extends('layouts.app')
@section('title', 'Edit SK Pengangkatan')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Edit SK Pengangkatan</h2>
                                <small class="text-muted">Silakan perbarui data SK pengangkatan pegawai (CPNS/PPPK).</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Form -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-file-description me-2"></i> Edit SK Pengangkatan
                    </h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('operator.sk-pengangkatan.update', $skPengangkatan->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="text-muted small mb-3">
                            Keterangan: <span class="text-danger">*</span> Wajib diisi
                        </div>

                        {{-- Bagian 1: Data Pegawai --}}
                        <h6 class="mb-3 fw-bold">Data Pegawai</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pegawai <span class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    value="{{ $skPengangkatan->pegawai->user->name ?? $skPengangkatan->pegawai->nip }}"
                                    readonly>
                                <input type="hidden" name="pegawai_id" value="{{ $skPengangkatan->pegawai->id }}">
                            </div>
                        </div>


                        <hr class="mt-4 mb-4">

                        {{-- Bagian 2: Informasi SK --}}
                        <h6 class="mb-3 fw-bold">Informasi SK</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Nomor SK</label>
                                <input type="text" class="form-control @error('nomor_sk') is-invalid @enderror"
                                    name="nomor_sk" value="{{ old('nomor_sk', $skPengangkatan->nomor_sk) }}">
                                @error('nomor_sk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tanggal SK</label>
                                <input type="date" class="form-control @error('tanggal_sk') is-invalid @enderror"
                                    name="tanggal_sk"
                                    value="{{ old('tanggal_sk', optional($skPengangkatan->tanggal_sk)->format('Y-m-d')) }}">
                                @error('tanggal_sk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">TMT</label>
                                <input type="date" class="form-control @error('tmt') is-invalid @enderror" name="tmt"
                                    value="{{ old('tmt', optional($skPengangkatan->tmt)->format('Y-m-d')) }}">
                                @error('tmt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pejabat SK</label>
                                <input type="text" class="form-control @error('pejabat_sk') is-invalid @enderror"
                                    name="pejabat_sk" value="{{ old('pejabat_sk', $skPengangkatan->pejabat_sk) }}">
                                @error('pejabat_sk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <h6 class="mb-3 fw-bold">Golongan & Gaji</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Golongan <span class="text-danger">*</span></label>
                                <select name="golongan_id" class="form-select @error('golongan_id') is-invalid @enderror"
                                    required>
                                    <option value="">Pilih Golongan</option>
                                    @foreach ($golongans as $golongan)
                                        <option value="{{ $golongan->id }}"
                                            {{ old('golongan_id', $skPengangkatan->golongan_id) == $golongan->id ? 'selected' : '' }}>
                                            {{ $golongan->golongan }} ({{ $golongan->pangkat }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('golongan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Gaji Pokok</label>
                                <input type="number" class="form-control" name="gaji_pokok"
                                    value="{{ old('gaji_pokok', $skPengangkatan->gaji_pokok) }}">
                            </div>
                        </div>

                        <h6 class="mb-3 fw-bold">Masa Kerja Pra Pengangkatan</h6>
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Tahun</label>
                                <input type="number" class="form-control" name="tahun_masa_kerja_pra_pengangkatan"
                                    value="{{ old('tahun_masa_kerja_pra_pengangkatan', $skPengangkatan->tahun_masa_kerja_pra_pengangkatan) }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Bulan</label>
                                <input type="number" class="form-control" name="bulan_masa_kerja_pra_pengangkatan"
                                    value="{{ old('bulan_masa_kerja_pra_pengangkatan', $skPengangkatan->bulan_masa_kerja_pra_pengangkatan) }}">
                            </div>
                        </div>

                        <!-- Upload SK -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Upload SK</label>
                            <input type="file" name="sk_path"
                                class="form-control @error('sk_path') is-invalid @enderror">
                            <small class="text-muted">Format: PDF, JPG, PNG. Max: 2MB</small>

                            {{-- Jika sudah ada file SK tersimpan --}}
                            @if (!empty($skPengangkatan->sk_path))
                                <div class="mt-2">
                                    <small class="text-muted">File saat ini:
                                        <a href="{{ route('operator.sk-pengangkatan.download', $skPengangkatan->id) }}" target="_blank">Lihat
                                            SK</a>
                                    </small>
                                </div>
                            @endif

                            {{-- Validasi error --}}
                            @error('sk_path')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('operator.sk-pengangkatan.index') }}" class="btn btn-light me-2">
                                <i class="ti ti-arrow-left me-1"></i> Batal
                            </a>
                            <button type="reset" class="btn btn-secondary me-2">
                                <i class="ti ti-rotate me-1"></i> Reset
                            </button>
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
