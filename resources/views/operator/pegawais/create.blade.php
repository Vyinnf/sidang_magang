@extends('layouts.app')

@if (request()->routeIs('operator.pegawais.createLama'))
    @section('title', 'Tambah Pegawai (Pernah Menerima Gaji Berkala)')
@elseif (request()->routeIs('operator.pegawais.create'))
    @section('title', 'Tambah Pegawai (Belum Pernah Menerima Gaji Berkala)')
@else
    @section('title', 'Tambah Pegawai')
@endif

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Tambah Pegawai</h2>
                                <small class="text-muted">Silakan lengkapi formulir berikut untuk menambahkan data
                                    pegawai baru.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Formulir -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-user-plus me-2"></i>
                        @if (request()->routeIs('operator.pegawais.createLama'))
                            Tambah Pegawai (Pernah Menerima Gaji Berkala)
                        @elseif (request()->routeIs('operator.pegawais.create'))
                            Tambah Pegawai (Belum Pernah Menerima Gaji Berkala)
                        @else
                            Tambah Pegawai
                        @endif
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('operator.pegawais.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="text-muted small mb-3">
                            Keterangan: <span class="text-danger">*</span> Wajib diisi
                        </div>

                        <input type="hidden" name="tipe" value="{{ request()->routeIs('operator.pegawais.createLama') ? 'lama' : 'baru' }}">

                        {{-- Bagian 1: Informasi Akun --}}
                        <h6 class="mb-3 fw-bold">Informasi Akun</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="name">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <input type="password" class="form-control pe-5 @error('password') is-invalid @enderror"
                                        id="password" name="password" required>
                                    <button type="button" class="btn btn-link text-muted position-absolute top-50 translate-middle-y p-0 toggle-password-btn" style="right: 0.75rem; width: 2rem; height: 2rem; text-decoration: none;" tabindex="-1" aria-label="Toggle password visibility">
                                        <i class="ti ti-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="password_confirmation">Konfirmasi Password <span
                                        class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <input type="password" class="form-control pe-5" id="password_confirmation"
                                        name="password_confirmation" required>
                                    <button type="button" class="btn btn-link text-muted position-absolute top-50 translate-middle-y p-0 toggle-password-btn" style="right: 0.75rem; width: 2rem; height: 2rem; text-decoration: none;" tabindex="-1" aria-label="Toggle password visibility">
                                        <i class="ti ti-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <hr class="mt-4 mb-4">

                        {{-- Bagian 2: Data Pokok Kepegawaian --}}
                        <h6 class="mb-3 fw-bold">Data Pokok Kepegawaian</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nip">NIP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip"
                                    name="nip" value="{{ old('nip') }}" required>
                                @error('nip')
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
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="jabatan">Jabatan</label>
                                <input type="text" class="form-control @error('jabatan') is-invalid @enderror"
                                    id="jabatan" name="jabatan" value="{{ old('jabatan') }}">
                                @error('jabatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tempat_lahir">Tempat Lahir</label>
                                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                    id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}">
                                @error('tempat_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="golongan_id">Golongan <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('golongan_id') is-invalid @enderror" id="golongan_id"
                                    name="golongan_id" required>
                                    <option value="">Pilih Golongan</option>
                                    @foreach ($golongans as $golongan)
                                        <option value="{{ $golongan->id }}"
                                            {{ old('golongan_id') == $golongan->id ? 'selected' : '' }}>
                                            {{ $golongan->golongan }} ({{ $golongan->pangkat }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('golongan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="mt-4 mb-4">
                        <h6 class="mb-3 fw-bold">SK CPNS / PPPK</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nomor_sk_pengangkatan">Nomor SK</label>
                                <input type="text" class="form-control" id="nomor_sk_pengangkatan"
                                    name="nomor_sk_pengangkatan" value="{{ old('nomor_sk_pengangkatan') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tanggal_sk_pengangkatan">Tanggal SK</label>
                                <input type="date" class="form-control" id="tanggal_sk_pengangkatan"
                                    name="tanggal_sk_pengangkatan" value="{{ old('tanggal_sk_pengangkatan') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tmt_sk_pengangkatan">TMT SK</label>
                                <input type="date" class="form-control" id="tmt_sk_pengangkatan"
                                    name="tmt_sk_pengangkatan" value="{{ old('tmt_sk_pengangkatan') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="pejabat_sk_pengangkatan">Pejabat Penetap</label>
                                <input type="text" class="form-control" id="pejabat_sk_pengangkatan"
                                    name="pejabat_sk_pengangkatan" value="{{ old('pejabat_sk_pengangkatan') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="golongan_id_pengangkatan">Golongan Awal</label>
                                <select class="form-select" id="golongan_id_pengangkatan"
                                    name="golongan_id_pengangkatan">
                                    <option value="">Pilih Golongan</option>
                                    @foreach ($golongans as $golongan)
                                        <option value="{{ $golongan->id }}"
                                            {{ old('golongan_id_pengangkatan') == $golongan->id ? 'selected' : '' }}>
                                            {{ $golongan->golongan }} ({{ $golongan->pangkat }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="tahun_masa_kerja_pra_pengangkatan">Masa Kerja Pra
                                    Pengangkatan
                                    (Tahun)</label>
                                <input type="number" class="form-control" id="tahun_masa_kerja_pra_pengangkatan"
                                    name="tahun_masa_kerja_pra_pengangkatan"
                                    value="{{ old('tahun_masa_kerja_pra_pengangkatan') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="bulan_masa_kerja_pra_pengangkatan">Masa Kerja Pra
                                    Pengangkatan
                                    (Bulan)</label>
                                <input type="number" class="form-control" id="bulan_masa_kerja_pra_pengangkatan"
                                    name="bulan_masa_kerja_pra_pengangkatan"
                                    value="{{ old('bulan_masa_kerja_pra_pengangkatan') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="file_sk_pengangkatan">Upload File SK</label>
                                <input type="file" class="form-control" id="file_sk_pengangkatan"
                                    name="file_sk_pengangkatan" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted">Format: PDF, JPG, atau PNG (max 2MB)</small>
                            </div>

                            @if (!empty($pegawai->file_sk_pengangkatan))
                                <div class="col-md-6 mb-3 d-flex align-items-end">
                                    <a href="{{ app(\App\Services\FileStorageService::class)->signedUrl($pegawai->file_sk_pengangkatan, 10) }}"
                                        target="_blank" class="btn btn-outline-primary">
                                        Lihat File SK
                                    </a>
                                </div>
                            @endif
                        </div>

                        {{-- Bagian 4: Data Riwayat Gaji Berkala --}}
                        @if (request()->routeIs('operator.pegawais.createLama'))
                            <hr class="mt-4 mb-4">
                            <h6 class="mb-3 fw-bold">Data Riwayat Gaji Berkala</h6>
                            <div class="row">
                                {{-- SK Lama --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="nomor_sk">Nomor SK</label>
                                    <input type="text" class="form-control" id="nomor_sk" name="nomor_sk"
                                        value="{{ old('nomor_sk') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="tanggal_sk">Tanggal SK</label>
                                    <input type="date" class="form-control" id="tanggal_sk" name="tanggal_sk"
                                        value="{{ old('tanggal_sk') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="tmt_sk">TMT SK</label>
                                    <input type="date" class="form-control" id="tmt_sk" name="tmt_sk"
                                        value="{{ old('tmt_sk') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="pejabat_sk">Pejabat SK</label>
                                    <input type="text" class="form-control" id="pejabat_sk" name="pejabat_sk"
                                        value="{{ old('pejabat_sk') }}">
                                </div>
                                {{-- Golongan Lama --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="golongan_sk_id">Dalam Golongan</label>
                                    <select class="form-select" id="golongan_sk_id" name="golongan_sk_id">
                                        <option value="">Dalam Golongan</option>
                                        @foreach ($golongans as $golongan)
                                            <option value="{{ $golongan->id }}"
                                                {{ old('golongan_id') == $golongan->id ? 'selected' : '' }}>
                                                {{ $golongan->golongan }} ({{ $golongan->pangkat }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="masa_kerja_golongan_tahun">Masa Kerja Golongan
                                        (Tahun)</label>
                                    <input type="number" class="form-control" id="masa_kerja_golongan_tahun"
                                        name="masa_kerja_golongan_tahun" value="{{ old('masa_kerja_golongan_tahun') }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="masa_kerja_golongan_bulan">Masa Kerja Golongan
                                        (Bulan)</label>
                                    <input type="number" class="form-control" id="masa_kerja_golongan_bulan"
                                        name="masa_kerja_golongan_bulan" value="{{ old('masa_kerja_golongan_bulan') }}">
                                </div>
                            </div>
                        @endif

                        {{-- Input tersembunyi untuk unit_kerja_id --}}
                        <input type="hidden" name="unit_kerja_id" value="{{ $unitKerja->id }}">

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('operator.pegawais.index') }}" class="btn btn-light me-2">
                                <i class="ti ti-arrow-left me-1"></i> Batal
                            </a>
                            <button type="reset" class="btn btn-secondary me-2">
                                <i class="ti ti-rotate me-1"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i> Simpan Pegawai
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
