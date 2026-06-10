<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login | Sistem Gaji Berkala Brida Sumenep</title>
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

    <style>
    /* Sembunyikan icon eye bawaan browser (Edge, IE) */
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear {
        display: none;
    }

    /* Sembunyikan icon eye bawaan Chrome */
    input[type="password"]::-webkit-contacts-auto-fill-button,
    input[type="password"]::-webkit-credentials-auto-fill-button {
        display: none;
    }
</style>
</head>

<body data-pc-preset="preset-10" class="bg-light min-vh-100 d-flex align-items-center justify-content-center">
    <div class="auth-main w-100">
        <div class="auth-wrapper v3 d-flex align-items-center justify-content-center min-vh-100">
            <div class="card shadow rounded bg-white p-4" style="min-width:350px;max-width:400px;width:100%;">
                <div class="auth-header d-flex justify-content-between align-items-center mb-4">
                    <a href="{{ url('/') }}" class="btn btn-link text-muted p-0 d-flex align-items-center gap-2" aria-label="Kembali ke halaman utama">
                        <i class="ti ti-arrow-left"></i>
                        <span class="small">Kembali</span>
                    </a>
                    <a href="/" class="d-inline-block">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" style="max-width: 120px;">
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="mb-4 text-center">
                        <h3 class="fw-bold mb-1">Login</h3>
                        <p class="text-muted small mb-0">Masuk ke akun Anda</p>
                    </div>

                    {{-- Session Error --}}
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    {{-- Login Form --}}
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                                placeholder="Email Address" required autofocus>
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Password</label>
                            <div class="position-relative">
                                <input id="password" type="password" name="password" class="form-control pe-4"
                                    placeholder="Password" required>
                                <button type="button" id="togglePassword"
                                    class="btn btn-link text-muted position-absolute top-50 translate-middle-y p-0"
                                    style="right: 0.75rem; width: 2rem; height: 2rem; text-decoration: none;"
                                    tabindex="-1" aria-label="Toggle password visibility">
                                    <i class="ti ti-eye" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex mt-1 justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input input-primary" type="checkbox" id="remember"
                                    name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted" for="remember">Keep me signed in</label>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
                <div class="auth-footer row mt-4">
                    <div class="col-12 text-center">
                        <p class="m-0 small text-muted">© {{ date('Y') }} DIGAJI — dikembangkan oleh <a
                                href="https://brida.sumenepkab.go.id/" target="_blank"
                                class="text-primary">BRIDA Sumenep</a>.</p>
                    </div>
                    <div class="col-12 text-center mt-2">
                        <p class="m-0 small text-muted">
                            <i class="ti ti-building me-1"></i>
                            Instansi Anda ingin menggunakan DIGAJI? <a
                                href="{{ url('/#contact') }}" class="fw-semibold text-primary">Hubungi kami</a>.
                        </p>
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
    <script src="{{ asset('assets/js/fonts/custom-ant-icon.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var passwordInput = document.getElementById('password');
            var toggleButton = document.getElementById('togglePassword');
            var toggleIcon = document.getElementById('togglePasswordIcon');

            if (passwordInput && toggleButton && toggleIcon) {
                toggleButton.addEventListener('click', function () {
                    var isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    toggleIcon.className = 'ti ' + (isPassword ? 'ti-eye-off' : 'ti-eye');
                });
            }
        });
    </script>
</body>

</html>
