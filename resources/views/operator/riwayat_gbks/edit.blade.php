@extends('layouts.app')
@section('title', 'Edit Riwayat Gaji Berkala')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Edit Riwayat Gaji Berkala</h2>
                                <small class="text-muted">Silakan perbarui data riwayat gaji berkala pegawai.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Form -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-cash me-2"></i> Edit Riwayat Gaji Berkala
                    </h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('operator.riwayat_gbks.update', $riwayat->id) }}" method="POST">
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
                                <select name="pegawai_id" class="form-select @error('pegawai_id') is-invalid @enderror"
                                    required>
                                    <option value="">Pilih Pegawai</option>
                                    @foreach ($pegawais as $pegawai)
                                        <option value="{{ $pegawai->id }}"
                                            {{ old('pegawai_id', $riwayat->pegawai_id) == $pegawai->id ? 'selected' : '' }}>
                                            {{ $pegawai->user->name ?? $pegawai->nip }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pegawai_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="mt-4 mb-4">

                        {{-- Bagian 2: SK Lama --}}
                        <h6 class="mb-3 fw-bold">SK Lama</h6>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">TMT SK Lama</label>
                                <input type="date" class="form-control @error('tmt_sk_lama') is-invalid @enderror"
                                    name="tmt_sk_lama"
                                    value="{{ old('tmt_sk_lama', optional($riwayat)->tmt_sk_lama ? \Carbon\Carbon::parse($riwayat->tmt_sk_lama)->format('Y-m-d') : '') }}">
                                @error('tmt_sk_lama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Tanggal SK Lama</label>
                                <input type="date" class="form-control @error('tanggal_sk_lama') is-invalid @enderror"
                                    name="tanggal_sk_lama"
                                    value="{{ old('tanggal_sk_lama', optional($riwayat)->tanggal_sk_lama ? \Carbon\Carbon::parse($riwayat->tanggal_sk_lama)->format('Y-m-d') : '') }}">
                                @error('tanggal_sk_lama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Nomor SK Lama</label>
                                <input type="text" class="form-control @error('nomor_sk_lama') is-invalid @enderror"
                                    name="nomor_sk_lama" value="{{ old('nomor_sk_lama', $riwayat->nomor_sk_lama) }}">
                                @error('nomor_sk_lama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Pejabat SK Lama</label>
                                <input type="text" class="form-control @error('pejabat_sk_lama') is-invalid @enderror"
                                    name="pejabat_sk_lama" value="{{ old('pejabat_sk_lama', $riwayat->pejabat_sk_lama) }}">
                                @error('pejabat_sk_lama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <h6 class="mb-3 fw-bold">Golongan & Gaji Lama</h6>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Golongan Lama <span class="text-danger">*</span></label>
                                <select name="golongan_lama_id"
                                    class="form-select @error('golongan_lama_id') is-invalid @enderror" required>
                                    <option value="">Pilih Golongan Lama</option>
                                    @foreach ($golongans as $golongan)
                                        <option value="{{ $golongan->id }}"
                                            {{ old('golongan_lama_id', $riwayat->golongan_lama_id) == $golongan->id ? 'selected' : '' }}>
                                            {{ $golongan->golongan }} ({{ $golongan->pangkat }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('golongan_lama_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Masa Kerja Lama (Tahun)</label>
                                <input type="number" class="form-control" name="masa_kerja_golongan_lama_tahun"
                                    value="{{ old('masa_kerja_golongan_lama_tahun', $riwayat->masa_kerja_golongan_lama_tahun) }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Masa Kerja Lama (Bulan)</label>
                                <input type="number" class="form-control" name="masa_kerja_golongan_lama_bulan"
                                    value="{{ old('masa_kerja_golongan_lama_bulan', $riwayat->masa_kerja_golongan_lama_bulan) }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Gaji Pokok Lama</label>
                                <input type="number" class="form-control" name="gaji_pokok_lama"
                                    value="{{ old('gaji_pokok_lama', $riwayat->gaji_pokok_lama) }}">
                            </div>
                        </div>

                        <hr class="mt-4 mb-4">

                        {{-- Bagian 3: SK Baru & Golongan Baru --}}
                        <h6 class="mb-3 fw-bold">SK Baru & Golongan Baru</h6>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">TMT SK Baru</label>
                                <input type="date" class="form-control @error('tmt_sk') is-invalid @enderror"
                                    name="tmt_sk"
                                    value="{{ old('tmt_sk', optional($riwayat)->tmt_sk ? \Carbon\Carbon::parse($riwayat->tmt_sk)->format('Y-m-d') : '') }}">
                                @error('tmt_sk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Tanggal SK Baru</label>
                                <input type="date" class="form-control @error('tanggal_sk') is-invalid @enderror"
                                    name="tanggal_sk"
                                    value="{{ old('tanggal_sk', optional($riwayat)->tanggal_sk ? \Carbon\Carbon::parse($riwayat->tanggal_sk)->format('Y-m-d') : '') }}">
                                @error('tanggal_sk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Nomor SK Baru</label>
                                <input type="text" class="form-control @error('nomor_sk') is-invalid @enderror"
                                    name="nomor_sk" value="{{ old('nomor_sk', $riwayat->nomor_sk) }}">
                                @error('nomor_sk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Pejabat SK Baru</label>
                                <input type="text" class="form-control @error('pejabat_sk') is-invalid @enderror"
                                    name="pejabat_sk" value="{{ old('pejabat_sk', $riwayat->pejabat_sk) }}">
                                @error('pejabat_sk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Golongan Baru <span class="text-danger">*</span></label>
                                <select name="golongan_baru_id"
                                    class="form-select @error('golongan_baru_id') is-invalid @enderror" required>
                                    <option value="">Pilih Golongan Baru</option>
                                    @foreach ($golongans as $golongan)
                                        <option value="{{ $golongan->id }}"
                                            {{ old('golongan_baru_id', $riwayat->golongan_baru_id) == $golongan->id ? 'selected' : '' }}>
                                            {{ $golongan->golongan }} ({{ $golongan->pangkat }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('golongan_baru_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Masa Kerja Baru (Tahun)</label>
                                <input type="number" class="form-control" name="masa_kerja_golongan_baru_tahun"
                                    value="{{ old('masa_kerja_golongan_baru_tahun', $riwayat->masa_kerja_golongan_baru_tahun) }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Masa Kerja Baru (Bulan)</label>
                                <input type="number" class="form-control" name="masa_kerja_golongan_baru_bulan"
                                    value="{{ old('masa_kerja_golongan_baru_bulan', $riwayat->masa_kerja_golongan_baru_bulan) }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Gaji Pokok Baru</label>
                                <input type="number" class="form-control" name="gaji_pokok_baru"
                                    value="{{ old('gaji_pokok_baru', $riwayat->gaji_pokok_baru) }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Status SK</label>
                                <select name="status_sk" class="form-select">
                                    <option value="lengkap"
                                        {{ old('status_sk', $riwayat->status_sk) == 'lengkap' ? 'selected' : '' }}>Lengkap
                                    </option>
                                    <option value="tidak_lengkap"
                                        {{ old('status_sk', $riwayat->status_sk) == 'tidak_lengkap' ? 'selected' : '' }}>
                                        Tidak Lengkap</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('operator.riwayat_gbks.index') }}" class="btn btn-light me-2">
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
