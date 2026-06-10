<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>@yield('title')</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
        content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
    <meta name="keywords"
        content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
    <meta name="author" content="CodedThemes">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- [Favicon] icon -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        id="main-font-link">
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
<!-- [Head] end -->
<!-- [Body] Start -->

<body @if (session('success')) data-success-message="{{ session('success') }}" @endif
    @if (session('error')) data-error-message="{{ session('error') }}" @endif
    @if (session('warning')) data-warning-message="{{ session('warning') }}" @endif
    data-pc-direction="ltr" data-pc-theme="light" data-pc-preset="preset-10">

    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ Sidebar Menu ] start -->
    <nav class="pc-sidebar">
        <div class="navbar-wrapper">
            <div class="text-center py-4">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="img-fluid logo-lg mx-auto"
                    style="max-height: 60px;">
            </div>
            @include('layouts.sidebar')
        </div>
    </nav>
    <!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
    <header class="pc-header">
        <div class="header-wrapper"><!-- [Mobile Media Block] start -->
            <div class="me-auto pc-mob-drp">
                <ul class="list-unstyled"><!-- ======= Menu collapse Icon ===== -->
                    <li class="pc-h-item pc-sidebar-collapse">
                        <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="pc-h-item pc-sidebar-popup">
                        <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                </ul>
            </div><!-- [Mobile Media Block end] -->
            <div class="ms-auto">
                <ul class="list-unstyled">
                    <li class="dropdown pc-h-item" id="nav-notification-wrapper">
                        @php
                            $unreadCount = 0;
                            if (auth()->check()) {
                                try {
                                    $unreadCount = auth()->user()->unreadNotifications()->count();
                                } catch (\Throwable $e) {
                                    $unreadCount = 0; // fallback diam-diam
                                }
                            }
                        @endphp
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                           role="button" aria-haspopup="false" aria-expanded="false" id="notificationDropdown"
                           data-refresh="true">
                            <i class="ti ti-bell"></i>
                            <span class="badge bg-{{ $unreadCount ? 'danger' : 'secondary' }} pc-h-badge" id="notif-badge">{{ $unreadCount }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown" aria-labelledby="notificationDropdown">
                            <div class="dropdown-header d-flex align-items-center justify-content-between">
                                <h5 class="m-0">Notifikasi</h5>
                                <button class="pc-head-link bg-transparent border-0 p-0" id="markAllReadBtn" title="Tandai semua sudah dibaca">
                                    <i class="ti ti-circle-check text-success"></i>
                                </button>
                            </div>
                            <div class="dropdown-divider"></div>
                            <div class="dropdown-header px-0 text-wrap header-notification-scroll position-relative"
                                 style="max-height: calc(100vh - 215px)" data-simplebar>
                                <div class="p-0" id="notif-list-container">
                                    <div class="text-center py-4 small text-muted" id="notif-loading">Memuat...</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    {{-- Profile --}}
                    @php
                        $user = auth()->user();
                    @endphp
                    <li class="dropdown pc-h-item header-user-profile">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside"
                            aria-expanded="false">
                            <img src="https://ui-avatars.com/api/?name={{ isset($user) ? urlencode($user->name) : 'Pegawai' }}&size=40"
                                alt="user-image" class="user-avtar">
                            <span>{{ isset($user) ? $user->name : 'Pegawai' }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                            <div class="dropdown-header">
                                <div class="d-flex mb-1">
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">{{ isset($user) ? $user->name : 'Pegawai' }}</h6>
                                        <span>{{ isset($user) ? $user->email : '' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-content" id="mysrpTabContent">
                                <div class="tab-pane fade show active" id="drp-tab-1" role="tabpanel"
                                    aria-labelledby="drp-t1" tabindex="0">
                                    @if (isset($user) && $user->role === 'pegawai')
                                        <a href="{{ route('pegawai.profile.index') }}" class="dropdown-item"><i
                                                class="ti ti-user"></i> <span>Profil</span>
                                        </a>
                                    @endif
                                    <a href="{{ route(auth()->user()->role . '.security.index') }}" class="dropdown-item"><i
                                            class="ti ti-user"></i> <span>Keamanan Akun</span>
                                    </a>
                                    <form action="{{ route('logout') }}" method="POST" class="dropdown-item">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-start p-0 m-0"
                                            style="width: 100%;">
                                            <i class="ti ti-power"></i> <span>Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                    {{-- End Profile --}}
                </ul>
            </div>
        </div>
    </header>

    @yield('content')


    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
            <div class="row">
                <div class="col-sm my-1">
                    <p class="m-0"> © 2025 DIGAJI — dikembangkan oleh <a
                            href="https://brida.sumenepkab.go.id/" target="_blank">BRIDA Sumenep</a>.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    {{-- toasts --}}

    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080;">
        <div id="crudToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto" id="toastHeader"></strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toastBody">
            </div>
        </div>
    </div>

    {{-- Required Js --}}
    <script src="{{ asset('assets') }}/js/plugins/popper.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/simplebar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap.min.js"></script>
    <script src="{{ asset('assets') }}/js/fonts/custom-font.js"></script>
    <script src="{{ asset('assets') }}/js/pcoded.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/feather.min.js"></script>

    {{-- Script kustom --}}
    <script src="{{ asset('js/notifications.js') }}"></script>
    <script src="{{ asset('js/confirmations.js') }}"></script>
    <script>
        // Inisialisasi tema & layout konsisten
        layout_change('light');
    </script>
    <script>
        change_box_container('false');
    </script>
    <script>
        layout_rtl_change('false');
    </script>
    <script>
        // Ambil preferensi preset dari localStorage jika ada, default ke preset-10 (merah)
        (function(){
            var saved = localStorage.getItem('pc-preset') || 'preset-10';
            preset_change(saved);
            // Ekspos helper global agar bisa dipanggil dari UI toggle nanti
            window.setPreset = function(p){
                preset_change(p);
                localStorage.setItem('pc-preset', p);
            };
        })();
    </script>
    <script>
        font_change("Public-Sans");
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Handle password visibility toggle for all elements
            document.querySelectorAll('.toggle-password-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    var container = this.closest('.position-relative');
                    if (!container) return;
                    var input = container.querySelector('input');
                    var icon = this.querySelector('i');
                    if (input && icon) {
                        var isPassword = input.getAttribute('type') === 'password';
                        input.setAttribute('type', isPassword ? 'text' : 'password');
                        
                        // Update icon classes
                        if (isPassword) {
                            icon.classList.remove('ti-eye');
                            icon.classList.add('ti-eye-off');
                        } else {
                            icon.classList.remove('ti-eye-off');
                            icon.classList.add('ti-eye');
                        }
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>
<!-- [Body] end -->

</html>
