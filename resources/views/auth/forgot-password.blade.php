<!DOCTYPE html>
<html lang="en">

<head>
    <title>Lupa Password | Sistem Gaji Berkala Brida Sumenep</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">
</head>

<body data-pc-preset="preset-10" class="bg-light min-vh-100 d-flex align-items-center justify-content-center">
    <div class="auth-main w-100">
        <div class="auth-wrapper v3 d-flex align-items-center justify-content-center min-vh-100">
            <div class="card shadow rounded bg-white p-4" style="min-width:350px;max-width:400px;width:100%;">
                <div class="auth-header d-flex justify-content-between align-items-center mb-4">
                    <a href="{{ route('loginForm') }}" class="btn btn-link text-muted p-0 d-flex align-items-center gap-2" aria-label="Kembali ke halaman login">
                        <i class="ti ti-arrow-left"></i>
                        <span class="small">Login</span>
                    </a>
                    <a href="/" class="d-inline-block">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" style="max-width: 120px;">
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="mb-4 text-center">
                        <h3 class="fw-bold mb-1">Lupa Password</h3>
                        <p class="text-muted small mb-0">Masukkan email Anda untuk melakukan reset password</p>
                    </div>

                    {{-- Session Status / Alerts --}}
                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif
                    @if (session('reset_url'))
                        <div class="alert alert-info border border-info mb-3">
                            <strong class="d-block mb-1">Simulasi Reset Link</strong>
                            <p class="small text-muted mb-2">Gunakan tombol simulasi di bawah untuk melanjutkan tanpa setup email:</p>
                            <a href="{{ session('reset_url') }}" class="btn btn-sm btn-info text-white w-100"><i class="ti ti-link me-1"></i> Simulasi Klik Link Reset</a>
                        </div>
                    @endif

                    {{-- Forgot Password Form --}}
                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                                placeholder="Email Address" required autofocus>
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex mt-4 gap-2">
                            <button type="submit" class="btn btn-primary w-100">Kirim Link Reset</button>
                        </div>
                    </form>
                </div>
                <div class="auth-footer row mt-4">
                    <div class="col-12 text-center">
                        <p class="m-0 small text-muted">© {{ date('Y') }} DIGAJI — dikembangkan oleh <a
                                href="https://brida.sumenepkab.go.id/" target="_blank"
                                class="text-primary">BRIDA Sumenep</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.js') }}"></script>
</body>

</html>
