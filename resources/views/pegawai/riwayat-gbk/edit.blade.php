@extends('layouts.app')

@section('title', 'Lengkapi Gaji Berkala')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Lengkapi Gaji Berkala</h2>
                                <small class="text-muted">Isi detail SK terbaru Anda</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('pegawai.riwayat-gbk.update', $riwayat->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="ti ti-file-text me-2"></i>Data Riwayat Gaji Berkala
                        </h5>
                    </div>
                    <div class="card-body">

                        {{-- SK Lama --}}
                        <h6 class="fw-bold mb-3">Data SK Lama</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">TMT SK Lama</label>
                                {{-- Menggunakan nullsafe operator di sini --}}
                                <input type="text" class="form-control"
                                    value="{{ $riwayat->tmt_sk_lama?->format('d F Y') ?? '-' }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal SK Lama</label>
                                {{-- Menggunakan nullsafe operator di sini --}}
                                <input type="text" class="form-control"
                                    value="{{ $riwayat->tanggal_sk_lama?->format('d F Y') ?? '-' }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor SK Lama</label>
                                <input type="text" class="form-control" value="{{ $riwayat->nomor_sk_lama }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pejabat SK Lama</label>
                                <input type="text" class="form-control" value="{{ $riwayat->pejabat_sk_lama }}" readonly>
                            </div>
                        </div>

                        <hr>

                        {{-- SK Baru --}}
                        <h6 class="fw-bold mb-3">Data SK Baru</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">TMT SK</label>
                                {{-- Menggunakan nullsafe operator --}}
                                <input type="text" class="form-control"
                                    value="{{ $riwayat->tmt_sk?->format('d F Y') ?? '-' }}" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tanggal_sk" class="form-label fw-semibold">Tanggal SK</label>
                                <input type="date" name="tanggal_sk" id="tanggal_sk"
                                    class="form-control @error('tanggal_sk') is-invalid @enderror" {{-- Menggunakan nullsafe operator --}}
                                    value="{{ old('tanggal_sk', $riwayat->tanggal_sk?->format('Y-m-d')) }}">
                                @error('tanggal_sk')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nomor_sk" class="form-label fw-semibold">Nomor SK</label>
                                <input type="text" name="nomor_sk" id="nomor_sk"
                                    class="form-control @error('nomor_sk') is-invalid @enderror"
                                    value="{{ old('nomor_sk', $riwayat->nomor_sk) }}">
                                @error('nomor_sk')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="pejabat_sk" class="form-label fw-semibold">Pejabat SK</label>
                                <input type="text" name="pejabat_sk" id="pejabat_sk"
                                    class="form-control @error('pejabat_sk') is-invalid @enderror"
                                    value="{{ old('pejabat_sk', $riwayat->pejabat_sk) }}">
                                @error('pejabat_sk')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        {{-- Info Gaji --}}
                        <h6 class="fw-bold mb-3">Informasi Gaji</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Golongan Lama</label>
                                <input type="text" class="form-control"
                                    value="{{ $riwayat->golonganLama?->golongan ?? '-' }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gaji Pokok Lama</label>
                                <input type="text" class="form-control"
                                    value="Rp {{ number_format($riwayat->gaji_pokok_lama, 0, ',', '.') }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Golongan Baru</label>
                                <input type="text" class="form-control"
                                    value="{{ $riwayat->golonganBaru?->golongan ?? '-' }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gaji Pokok Baru</label>
                                <input type="text" class="form-control"
                                    value="Rp {{ number_format($riwayat->gaji_pokok_baru, 0, ',', '.') }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('pegawai.riwayat-gbk.index') }}" class="btn btn-light me-2">
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
@endsection
