@extends('layouts.app')

@section('title', 'Edit Profil Pegawai')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Edit Profil</h2>
                                <small class="text-muted">Perbarui informasi pribadi Anda</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Profile Card -->
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <!-- Foto -->
                            <div class="mb-3">
                                @if ($user->profile_photo)
                                    <img src="{{ route('pegawai.profile.view-photo', $user->id) }}"
                                        class="rounded-circle shadow-sm mb-2"
                                        style="width: 130px; height: 130px; object-fit: cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name ?? 'Pegawai') }}&size=130&background=6c757d&color=ffffff"
                                        class="rounded-circle shadow-sm mb-2" style="width: 130px; height: 130px;">
                                @endif
                            </div>

                            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                            <span class="badge bg-primary px-3 py-1 mb-3">{{ ucfirst($user->role ?? 'pegawai') }}</span>

                            <div class="text-muted small">Unggah foto baru untuk mengganti foto profil</div>
                        </div>
                    </div>
                </div>

                <!-- Form Edit -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <form action="{{ route('pegawai.profile.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Nama -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $user->name) }}">
                                </div>

                                <!-- Tempat Lahir -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control"
                                        value="{{ old('tempat_lahir', $user->pegawai->tempat_lahir ?? '') }}">
                                </div>

                                <!-- Tanggal Lahir -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control"
                                        value="{{ old('tanggal_lahir', $user->pegawai->tanggal_lahir ? $user->pegawai->tanggal_lahir->format('Y-m-d') : '') }}">
                                </div>

                                <!-- Foto -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Foto Profil</label>
                                    <input type="file" name="profile_photo" class="form-control">
                                    <small class="text-muted">Format: JPG, PNG. Max: 2MB</small>
                                </div>

                                <!-- Actions -->
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('pegawai.profile.index') }}" class="btn btn-light me-2">
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

        </div>
    </div>
@endsection
