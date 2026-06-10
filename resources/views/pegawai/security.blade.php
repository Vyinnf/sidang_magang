@extends('layouts.app')

@section('title', 'Keamanan Akun')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Keamanan Akun</h2>
                                <small class="text-muted">Perbarui email & password Anda</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Card Update Email -->
                <div class="col-lg-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Ubah Email</h5>
                            <form action="{{ route('pegawai.security.updateEmail') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Informasi penting -->
                                <div class="alert alert-info small mb-3">
                                    Pastikan Anda menggunakan <strong>email aktif</strong> agar selalu menerima notifikasi
                                    penting dan pengingat otomatis terkait <strong>kenaikan gaji berkala</strong> Anda.
                                </div>

                                <!-- Email Lama -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email Saat Ini</label>
                                    <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                                </div>

                                <!-- Email Baru -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email Baru</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="Masukkan email baru" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Password Konfirmasi -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Password Saat Ini</label>
                                    <div class="position-relative">
                                        <input type="password" name="password"
                                            class="form-control pe-5 @error('password') is-invalid @enderror"
                                            placeholder="Masukkan password Anda" required>
                                        <button type="button" class="btn btn-link text-muted position-absolute top-50 translate-middle-y p-0 toggle-password-btn" style="right: 0.75rem; width: 2rem; height: 2rem; text-decoration: none;" tabindex="-1" aria-label="Toggle password visibility">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted d-block mt-1">Masukkan password saat ini untuk verifikasi keamanan</small>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <button type="reset" class="btn btn-secondary">
                                        <i class="ti ti-rotate me-1"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti ti-mail me-1"></i> Perbarui Email
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <!-- Card Update Password -->
                <div class="col-lg-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Ubah Password</h5>

                            <form action="{{ route('pegawai.security.updatePassword') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Password Lama -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Password Lama</label>
                                    <div class="position-relative">
                                        <input type="password" name="current_password"
                                            class="form-control pe-5 @error('current_password') is-invalid @enderror" required>
                                        <button type="button" class="btn btn-link text-muted position-absolute top-50 translate-middle-y p-0 toggle-password-btn" style="right: 0.75rem; width: 2rem; height: 2rem; text-decoration: none;" tabindex="-1" aria-label="Toggle password visibility">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                    </div>
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Password Baru -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Password Baru</label>
                                    <div class="position-relative">
                                        <input type="password" name="new_password"
                                            class="form-control pe-5 @error('new_password') is-invalid @enderror" required>
                                        <button type="button" class="btn btn-link text-muted position-absolute top-50 translate-middle-y p-0 toggle-password-btn" style="right: 0.75rem; width: 2rem; height: 2rem; text-decoration: none;" tabindex="-1" aria-label="Toggle password visibility">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                    </div>
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Konfirmasi Password Baru -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                                    <div class="position-relative">
                                        <input type="password" name="new_password_confirmation" class="form-control pe-5" required>
                                        <button type="button" class="btn btn-link text-muted position-absolute top-50 translate-middle-y p-0 toggle-password-btn" style="right: 0.75rem; width: 2rem; height: 2rem; text-decoration: none;" tabindex="-1" aria-label="Toggle password visibility">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <button type="reset" class="btn btn-secondary">
                                        <i class="ti ti-rotate me-1"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti ti-lock me-1"></i> Perbarui Password
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
