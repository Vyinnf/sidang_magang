<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DIGAJI</title>

    <!-- ======= Google Font =======-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&amp;display=swap" rel="stylesheet">
    <!-- End Google Font-->

    <!-- ======= Styles =======-->
    <link href="{{ asset('assets/vendors/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/bootstrap-icons/font/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/glightbox/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/aos/aos.css') }}" rel="stylesheet">
    <!-- End Styles-->

    <!-- ======= Theme Style =======-->
    <link href="{{ asset('assets/css/landing-utama.css') }}" rel="stylesheet">
    <!-- End Theme Style-->

</head>

<body class="overflow-x-hidden">


    <!-- ======= Site Wrap =======-->
    <div class="site-wrap overflow-x-hidden">
        <!-- ======= Header =======-->
    <header class="fbs__net-navbar navbar navbar-expand-lg dark" aria-label="DIGAJI navigation">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2 py-2" href="#home">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="DIGAJI" style="height:50px;width:auto;" class="d-inline-block align-middle">
                </a>
                <button class="navbar-toggler border-0 shadow-none p-2 ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#landingMainNav" aria-controls="landingMainNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="d-flex align-items-center justify-content-center" style="width:34px;height:34px;">
                        <i class="bi bi-list" style="font-size:1.8rem;"></i>
                    </span>
                </button>
                <div class="collapse navbar-collapse" id="landingMainNav">
                    <ul class="navbar-nav ms-lg-4 mb-3 mb-lg-0 align-items-lg-center">
                        <li class="nav-item"><a class="nav-link scroll-link active" href="#home">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link scroll-link" href="#about">Tentang</a></li>
                        <li class="nav-item"><a class="nav-link scroll-link" href="#features">Fitur</a></li>
                        <li class="nav-item"><a class="nav-link scroll-link" href="#services">Panduan</a></li>
                        <li class="nav-item"><a class="nav-link scroll-link" href="#contact">Kontak & Konsultasi</a></li>
                    </ul>
                    <div class="ms-lg-auto d-flex pt-2 pt-lg-0 auth-cta">
                        @auth
                            @php($role = auth()->user()->role)
                            @php($dashboardRoute = match($role) {
                                'admin' => route('admin.dashboard'),
                                'operator' => route('operator.dashboard'),
                                'pegawai' => route('pegawai.dashboard'),
                                default => route('loginForm'),
                            })
                            <a class="btn btn-primary py-2 px-3" href="{{ $dashboardRoute }}">Dashboard</a>
                        @else
                            <a class="btn btn-primary py-2 px-3" href="{{ route('loginForm') }}">Login</a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>
        <!-- End Header-->

        <!-- ======= Main =======-->
        <main>

            <!-- ======= Hero (Redesigned) =======-->
            <section class="hero__v6 hero-redesign section d-flex align-items-center" id="home" aria-label="Pengantar Sistem DIGAJI">
                <div class="container px-3 px-md-4">
                    <div class="row align-items-center g-4 g-lg-5">
                        <div class="col-lg-6 text-center mt-5 mt-lg-0" data-aos="fade-left" data-aos-delay="100">
                            <div class="hero-illustration mx-auto" aria-hidden="true">
                                <svg viewBox="0 0 520 420" role="img" aria-labelledby="heroIllustrationTitle" focusable="false" class="w-100 hero-visual-svg">
                                    <title id="heroIllustrationTitle">Visual alur otomatisasi dan penerbitan SK</title>
                                    <defs>
                                        <linearGradient id="gradPanel" x1="0" y1="0" x2="1" y2="1">
                                            <stop offset="0%" stop-color="#ffffff" />
                                            <stop offset="100%" stop-color="#f8f8f8" />
                                        </linearGradient>
                                        <linearGradient id="gradPrimary" x1="0" y1="0" x2="1" y2="1">
                                            <stop offset="0%" stop-color="#ab0000" />
                                            <stop offset="100%" stop-color="#d22" />
                                        </linearGradient>
                                        <filter id="shadow-sm-1" x="-20%" y="-20%" width="140%" height="140%">
                                            <feDropShadow dx="0" dy="4" stdDeviation="6" flood-color="#000" flood-opacity="0.08" />
                                        </filter>
                                    </defs>
                                    <rect x="40" y="40" rx="18" ry="18" width="330" height="240" fill="url(#gradPanel)" stroke="#ececec" filter="url(#shadow-sm-1)" />
                                    <rect x="70" y="80" width="130" height="14" rx="7" fill="#ddd" />
                                    <rect x="70" y="105" width="220" height="10" rx="5" fill="#eee" />
                                    <g class="floating-1">
                                        <rect x="400" y="60" width="110" height="70" rx="14" fill="#fff" stroke="#f0f0f0" filter="url(#shadow-sm-1)" />
                                        <rect x="420" y="80" width="70" height="10" rx="5" fill="#e6e6e6" />
                                        <rect x="420" y="98" width="50" height="8" rx="4" fill="#f0f0f0" />
                                    </g>
                                    <g class="floating-2">
                                        <rect x="380" y="160" width="125" height="90" rx="16" fill="#fff" stroke="#f0f0f0" filter="url(#shadow-sm-1)" />
                                        <rect x="400" y="182" width="80" height="12" rx="6" fill="#e6e6e6" />
                                        <rect x="400" y="205" width="60" height="8" rx="4" fill="#f0f0f0" />
                                        <circle cx="435" cy="230" r="10" fill="url(#gradPrimary)" opacity="0.85" />
                                    </g>
                                    <g class="timeline" stroke="#ab0000" stroke-width="3" stroke-linecap="round">
                                        <line x1="120" y1="170" x2="120" y2="315" stroke="#f1c0c0" stroke-width="8" />
                                        <circle cx="120" cy="185" r="18" fill="#fff" stroke="#ab0000" stroke-width="3" />
                                        <circle cx="120" cy="245" r="18" fill="#fff" stroke="#ab0000" stroke-width="3" />
                                        <circle cx="120" cy="305" r="18" fill="#ab0000" />
                                        <text x="150" y="190" font-size="13" fill="#555">Ajukan</text>
                                        <text x="150" y="250" font-size="13" fill="#555">Diproses</text>
                                        <text x="150" y="310" font-size="13" fill="#ab0000" font-weight="600">Selesai</text>
                                    </g>
                                    <g class="floating-3">
                                        <rect x="200" y="270" width="160" height="120" rx="14" fill="#fff" stroke="#e8e8e8" filter="url(#shadow-sm-1)" />
                                        <rect x="220" y="295" width="110" height="10" rx="5" fill="#ececec" />
                                        <rect x="220" y="315" width="80" height="8" rx="4" fill="#f0f0f0" />
                                        <rect x="220" y="333" width="90" height="8" rx="4" fill="#f0f0f0" />
                                        <circle cx="345" cy="365" r="18" fill="url(#gradPrimary)" />
                                        <text x="330" y="370" font-size="9" fill="#fff" font-weight="600">SK</text>
                                    </g>
                                </svg>
                            </div>
                        </div>
                        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="0">
                            <span class="badge-platform">Platform Resmi BRIDA Kabupaten Sumenep</span>
                            <h1 class="display-5 fw-bold hero-headline mt-3 mb-3">Digitalisasi Gaji Berkala &<br class="d-none d-md-inline"> Kenaikan Pangkat ASN</h1>
                            <p class="lead text-muted mb-4 pe-lg-4">DIGAJI mempercepat penerbitan SK Gaji Berkala & Kenaikan Pangkat secara <strong>efisien, akurat, dan transparan</strong> dengan riwayat terintegrasi.</p>
                            <div class="mb-4">
                                <p class="mb-0 small text-muted">Silakan <a href="{{ route('loginForm') }}" class="text-primary">login terlebih dahulu</a> jika ingin menggunakan sistem.</p>
                            </div>
                            <ul class="mini-benefits list-unstyled d-flex flex-wrap gap-3 mb-4" aria-label="Keunggulan Utama">
                                <li><i class="bi bi-check-circle-fill" aria-hidden="true"></i> Otomatis & Tertata</li>
                                <li><i class="bi bi-check-circle-fill" aria-hidden="true"></i> Riwayat Lengkap</li>
                                <li><i class="bi bi-check-circle-fill" aria-hidden="true"></i> Skalabel & Aman</li>
                            </ul>
                            <div class="d-flex align-items-center gap-3 small text-muted" aria-label="Status dan Dukungan">
                                <span class="fw-semibold"><i class="bi bi-shield-lock me-1 text-primary" aria-hidden="true"></i>Data Dilindungi</span>
                                <span class="vr"></span>
                                <span><i class="bi bi-building me-1 text-primary" aria-hidden="true"></i>Didukung BRIDA</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Hero Redesigned -->

            <!-- ======= About =======-->
            <section class="about__v4 section" id="about">
                <div class="container px-3 px-md-4">
                    <div class="row">
                        <div class="row justify-content-end">
                            <div class="col-md-11 mb-4 mb-md-0"><span class="subtitle text-uppercase mb-3"
                                    data-aos="fade-up" data-aos-delay="0">Tentang Sistem Gaji Berkala</span>
                                <h2 class="mb-4" data-aos="fade-up" data-aos-delay="100">Sistem Gaji Berkala BRIDA
                                    Sumenep</h2>
                                <div data-aos="fade-up" data-aos-delay="200">
                                    <p>Sistem Gaji Berkala adalah aplikasi resmi BRIDA Kabupaten Sumenep
                                        yang dirancang untuk mempermudah proses pengelolaan data Aparatur Sipil Negara
                                        (ASN),
                                        perhitungan masa kerja, serta penerbitan Surat Kenaikan Gaji Berkala (KGB).</p>
                                    <p>Dengan sistem ini, seluruh proses menjadi lebih <b>efisien, akurat,
                                            transparan,</b>
                                        dan mengurangi potensi kesalahan manual. ASN dapat memantau informasi gaji
                                        berkala
                                        dengan lebih mudah dan cepat.</p>
                                </div>
                                <h4 class="small fw-bold mt-4 mb-3" data-aos="fade-up" data-aos-delay="300">
                                    Prinsip Utama</h4>
                                <ul class="d-flex flex-row flex-wrap list-unstyled gap-3 features" data-aos="fade-up"
                                    data-aos-delay="400">
                                    <li class="d-flex align-items-center gap-2"><span
                                            class="icon rounded-circle text-center"><i
                                                class="bi bi-check"></i></span><span class="text">Efisiensi</span>
                                    </li>
                                    <li class="d-flex align-items-center gap-2"><span
                                            class="icon rounded-circle text-center"><i
                                                class="bi bi-check"></i></span><span class="text">Akurasi</span>
                                    </li>
                                    <li class="d-flex align-items-center gap-2"><span
                                            class="icon rounded-circle text-center"><i
                                                class="bi bi-check"></i></span><span
                                            class="text">Transparansi</span></li>
                                    <li class="d-flex align-items-center gap-2"><span
                                            class="icon rounded-circle text-center"><i
                                                class="bi bi-check"></i></span><span class="text">Kemudahan
                                            Akses</span></li>
                                    <li class="d-flex align-items-center gap-2"><span
                                            class="icon rounded-circle text-center"><i
                                                class="bi bi-check"></i></span><span
                                            class="text">Profesionalisme</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End About-->

            <!-- ======= Feature Summary (Refreshed) =======-->
            <section class="section features__v2" id="features">
                <div class="container px-3 px-md-4">
                    <div class="row mb-5 text-center">
                        <div class="col-lg-10 mx-auto" data-aos="fade-up">
                            <span class="subtitle text-uppercase mb-3">Ringkasan Fitur</span>
                            <h2 class="fw-bold mb-3">Fitur Inti DIGAJI</h2>
                            <p class="text-muted mb-0">Empat fondasi utama yang mempercepat layanan kepegawaian & dokumen strategis ASN.</p>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="0">
                            <div class="lp-feature-card h-100 p-4 text-center">
                                <div class="icon-wrapper mb-3"><i class="bi bi-journal-check"></i></div>
                                <h6 class="fw-semibold mb-2">SK Gaji Berkala</h6>
                                <p class="small text-muted mb-0">Pemrosesan & penyimpanan SK otomatis dengan riwayat tersusun.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                            <div class="lp-feature-card h-100 p-4 text-center">
                                <div class="icon-wrapper mb-3"><i class="bi bi-arrow-up-circle"></i></div>
                                <h6 class="fw-semibold mb-2">Kenaikan Pangkat</h6>
                                <p class="small text-muted mb-0">Alur pengajuan & persetujuan terstruktur & terdokumentasi.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                            <div class="lp-feature-card h-100 p-4 text-center">
                                <div class="icon-wrapper mb-3"><i class="bi bi-archive"></i></div>
                                <h6 class="fw-semibold mb-2">Riwayat Terintegrasi</h6>
                                <p class="small text-muted mb-0">Audit lengkap perjalanan gaji & pangkat pegawai.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                            <div class="lp-feature-card h-100 p-4 text-center">
                                <div class="icon-wrapper mb-3"><i class="bi bi-file-earmark-text"></i></div>
                                <h6 class="fw-semibold mb-2">Template SK</h6>
                                <p class="small text-muted mb-0">Dokumen konsisten, cepat digenerasi & siap diunduh.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Feature Summary -->

            <!-- ======= Value Proposition =======-->
            <section class="section value-prop" id="value">
                <div class="container">
                    <div class="row mb-5 text-center">
                        <div class="col-lg-9 mx-auto" data-aos="fade-up">
                            <span class="subtitle text-uppercase mb-3">Mengapa Memilih</span>
                            <h2 class="fw-bold mb-3">Kenapa DIGAJI Penting</h2>
                            <p class="text-muted mb-0">Dirancang khusus kebutuhan BRIDA: robust, aman, dan siap dikembangkan lebih jauh.</p>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="0">
                            <div class="value-card h-100 p-4">
                                <div class="vc-icon mb-3"><i class="bi bi-speedometer2"></i></div>
                                <h6 class="fw-semibold mb-2">Lebih Cepat</h6>
                                <p class="small text-muted mb-0">Pengurangan pekerjaan manual & duplikasi input.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                            <div class="value-card h-100 p-4">
                                <div class="vc-icon mb-3"><i class="bi bi-shield-check"></i></div>
                                <h6 class="fw-semibold mb-2">Akurat & Konsisten</h6>
                                <p class="small text-muted mb-0">Data terhubung antar modul mengurangi kesalahan.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                            <div class="value-card h-100 p-4">
                                <div class="vc-icon mb-3"><i class="bi bi-clock-history"></i></div>
                                <h6 class="fw-semibold mb-2">Jejak Penuh</h6>
                                <p class="small text-muted mb-0">Riwayat terarsip rapi untuk audit & evaluasi.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                            <div class="value-card h-100 p-4">
                                <div class="vc-icon mb-3"><i class="bi bi-layers"></i></div>
                                <h6 class="fw-semibold mb-2">Skalabel</h6>
                                <p class="small text-muted mb-0">Mudah ditambah fitur (notifikasi, analitik, dsb).</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Value Proposition -->

            <!-- ======= Services =======-->
            <section class="section services__v3 process-flow" id="services">
                <div class="container">
                    <div class="row mb-5">
                        <div class="col-md-8 mx-auto text-center"><span class="subtitle text-uppercase mb-3"
                                data-aos="fade-up" data-aos-delay="0">Alur Singkat</span>
                            <h2 class="mb-3" data-aos="fade-up" data-aos-delay="100">Cara Kerja DIGAJI</h2>
                            <p class="text-muted" data-aos="fade-up" data-aos-delay="150">Empat langkah inti yang menyederhanakan pengelolaan gaji berkala & kenaikan pangkat.</p>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
                            <div
                                class="service-card p-4 rounded-4 h-100 d-flex flex-column justify-content-between gap-5">
                                <div><span class="icon mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 64 64"
                                            style="enable-background:new 0 0 512 512" xml:space="preserve">
                                            <g>
                                                <path
                                                    d="M38.972 31.507a7.01 7.01 0 0 0-4.32-12.487H23.604a3.001 3.001 0 0 0-2.998 2.998v19.988a3.001 3.001 0 0 0 2.998 2.998h12.8c7.723-.104 9.639-10.635 2.568-13.497zm-16.367-9.49a1 1 0 0 1 1-.999h11.047a4.997 4.997 0 1 1 0 9.994H22.605zm13.798 20.988H23.604a1 1 0 0 1-.999-1v-8.994h13.798a4.997 4.997 0 0 1 0 9.994z"
                                                    fill="currentColor" opacity="1" data-original="#000000">
                                                </path>
                                                <path
                                                    d="M51.798 12.238a27.71 27.71 0 0 0-3.132-2.708 1 1 0 0 0-1.186 1.609 25.317 25.317 0 0 1 2.162 1.82l-2.117 2.117A22.896 22.896 0 0 0 33.002 9.05V6.057a25.425 25.425 0 0 1 11.2 3.02 1 1 0 0 0 .946-1.761C26.702-2.634 3.907 11.036 4.02 32.012c-.31 15.036 12.945 28.294 27.983 27.983 24.827-.03 37.332-30.174 19.795-47.757zm-.734 2.126a25.768 25.768 0 0 1 6.899 16.648h-3A22.896 22.896 0 0 0 48.94 16.49zm-38.123 0 2.118 2.117A22.815 22.815 0 0 0 9.05 31.012H6.043a25.768 25.768 0 0 1 6.898-16.648zM6.043 33.01h2.999a22.896 22.896 0 0 0 6.025 14.524L12.94 49.66A25.768 25.768 0 0 1 6.043 33.01zm24.96 24.96a25.768 25.768 0 0 1-16.648-6.898l2.125-2.125a22.896 22.896 0 0 0 14.523 6.025zm-19.988-25.96a20.892 20.892 0 0 1 11.64-18.784 1 1 0 0 0-.892-1.788 23.283 23.283 0 0 0-5.294 3.626l-2.114-2.114a25.768 25.768 0 0 1 16.648-6.9v3.01a22.7 22.7 0 0 0-5.356.865 1 1 0 0 0 .558 1.918c13.1-3.976 26.996 6.454 26.785 20.168-1.15 27.836-40.823 27.84-41.975 0zm21.987 25.96v-2.998a22.896 22.896 0 0 0 14.523-6.025l2.125 2.125a25.768 25.768 0 0 1-16.648 6.899zm18.062-8.311-2.125-2.125a22.896 22.896 0 0 0 6.024-14.524h3a25.768 25.768 0 0 1-6.9 16.649z"
                                                    fill="currentColor" opacity="1" data-original="#000000">
                                                </path>
                                            </g>
                                        </svg></span>
                                    <h3 class="fs-5 mb-3">Masuk & Akses</h3>
                                    <p class="mb-4">Login dan lihat ringkasan gaji berkala, pangkat & status permohonan terbaru.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                            <div
                                class="service-card p-4 rounded-4 h-100 d-flex flex-column justify-content-between gap-5">
                                <div><span class="icon mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 64 64"
                                            style="enable-background:new 0 0 512 512" xml:space="preserve">
                                            <g>
                                                <path
                                                    d="M32.322 22.446a1.276 1.276 0 1 1-1.225 1.632 1 1 0 0 0-1.921.556 3.29 3.29 0 0 0 2.146 2.202v.352a1 1 0 0 0 2 0v-.363a3.272 3.272 0 0 0-1-6.38A1.276 1.276 0 1 1 33.57 18.9a1 1 0 0 0 1.956-.418 3.287 3.287 0 0 0-2.204-2.423c.082-.687-.226-1.374-1-1.385-.78.016-1.08.697-1 1.392a3.272 3.272 0 0 0 1 6.38z"
                                                    fill="currentColor" opacity="1" data-original="#000000">
                                                </path>
                                                <path
                                                    d="M59 47.487h-1.81v-27.61a5.223 5.223 0 0 0-5-5.409h-3.71a1 1 0 0 0 0 2h3.71a3.228 3.228 0 0 1 3 3.41v27.609H26.03a1.013 1.013 0 0 0-.996 1.02 34.358 34.358 0 0 0 1.49 3.57 2 2 0 0 0 1.828 1.188h7.296a2 2 0 0 0 1.828-1.188l1.149-2.589L58 49.487v2.74a2.823 2.823 0 0 1-2.82 2.82H8.82A2.823 2.823 0 0 1 6 52.227v-2.74h16.03a1 1 0 0 0 0-2H8.81v-27.61a3.228 3.228 0 0 1 3-3.41h6.89c-3.535 9.154 3.658 19.594 13.63 19.48 11.076.08 18.127-12.336 12.587-21.706a14.54 14.54 0 0 0-25.162-.073 1.646 1.646 0 0 1-.163.299H11.81a5.223 5.223 0 0 0-5 5.41v27.61H5a1 1 0 0 0-1 1v3.74a4.825 4.825 0 0 0 4.82 4.82h46.36a4.825 4.825 0 0 0 4.82-4.82v-3.74a1 1 0 0 0-1-1zm-23.352 3.778h-7.296l-.788-1.775h8.872zm-4.332-17.37a12.517 12.517 0 0 1-9.29-5.372l2.072-1.196a10.137 10.137 0 0 0 7.218 4.188zm2 .001v-2.38a10.12 10.12 0 0 0 7.224-4.178l2.073 1.197a12.5 12.5 0 0 1-9.297 5.361zm11.521-12.471A12.435 12.435 0 0 1 43.61 26.8l-2.064-1.192a10.127 10.127 0 0 0 .008-8.344l2.064-1.192a12.412 12.412 0 0 1 1.22 5.353zM33.33 8.967a12.503 12.503 0 0 1 9.295 5.37l-2.073 1.196a10.124 10.124 0 0 0-7.222-4.187zm7.129 12.458a8.144 8.144 0 0 1-8.13 8.14c-10.794-.446-10.804-15.824 0-16.27a8.138 8.138 0 0 1 8.13 8.13zM31.329 8.966v2.38a10.138 10.138 0 0 0-7.226 4.177l-2.073-1.196a12.518 12.518 0 0 1 9.3-5.36zm-10.295 7.095 2.064 1.192a10.022 10.022 0 0 0-.003 8.343l-2.064 1.192a12.473 12.473 0 0 1 .003-10.727z"
                                                    fill="currentColor" opacity="1" data-original="#000000">
                                                </path>
                                            </g>
                                        </svg></span>
                                    <h3 class="fs-5 mb-3">Ajukan & Proses</h3>
                                    <p class="mb-4">Pegawai mengajukan SK Gaji Berkala atau Kenaikan Pangkat. Operator meninjau & memproses.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                            <div
                                class="service-card p-4 rounded-4 h-100 d-flex flex-column justify-content-between gap-5">
                                <div><span class="icon mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 64 64"
                                            style="enable-background:new 0 0 512 512" xml:space="preserve">
                                            <g>
                                                <path
                                                    d="m57.936 58.647-4.47-11.871a9.542 9.542 0 0 0-5.914-5.693l-7.659-2.609-1.944-2.116v-2.62a13.043 13.043 0 0 0 4.739-5.175 14.256 14.256 0 0 0 3.237.14 2.909 2.909 0 0 0 2.905-2.906v-5.382a2.895 2.895 0 0 0-1.495-2.523 13.84 13.84 0 0 0-2.807-7.777 1 1 0 0 0-1.597 1.205 11.879 11.879 0 0 1 2.386 6.19c-.012-.01-2.017.036-1.987-.023-4.064-11.113-18.668-11.126-22.702.024h-1.875c.73-9.938 13.556-14.987 21.539-8.81a1 1 0 0 0 1.196-1.605c-9.394-7.24-24.311-1.02-24.754 10.758a2.895 2.895 0 0 0-1.566 2.561v5.382a2.909 2.909 0 0 0 2.905 2.906c.4-.042 2.932.115 3.213-.122a12.843 12.843 0 0 0 4.542 5.038v2.757l-1.825 2.184-7.553 2.521a9.547 9.547 0 0 0-5.917 5.695l-4.47 11.871a1.008 1.008 0 0 0 .935 1.352H49.97a1 1 0 0 0 0-2H36.123l-2.985-7.876 2.014-2.491 2.009 1.746a1.007 1.007 0 0 0 1.643-.594l1.322-8.118 6.785 2.312a7.549 7.549 0 0 1 4.682 4.504L55.555 58H53.97a1 1 0 0 0 0 2H57a1.007 1.007 0 0 0 .936-1.353zm-13.77-39.136h1.759a.906.906 0 0 1 .905.904v5.382a.906.906 0 0 1-.905.906h-1.759zm-24.334 7.192h-1.759a.906.906 0 0 1-.905-.906v-5.382a.906.906 0 0 1 .905-.904h1.76s.038 5.959 0 7.192zm12.146-15.6a10.16 10.16 0 0 1 9.15 6.288L38.85 18.43a4.677 4.677 0 0 1-4.986-.747 6.633 6.633 0 0 0-7.78-.736l-3.91 2.325c1.2-4.704 5.135-8.169 9.803-8.169zM21.832 23.168V21.8l5.273-3.133a4.632 4.632 0 0 1 5.433.51 6.72 6.72 0 0 0 7.15 1.07l2.098-.957a12.113 12.113 0 0 1 .38 2.98c-.464 14.245-18.826 15.065-20.334.9zM35.95 34.706v1.718l-3.968 5.464-4.153-5.473v-1.78a11.242 11.242 0 0 0 8.12.071zm-9.164 3.643 3.852 5.075-3.771 3.28-1.206-7.008zM8.444 58l3.96-10.516a7.551 7.551 0 0 1 4.681-4.505l6.724-2.245 1.387 8.06a1.007 1.007 0 0 0 1.641.585l2.01-1.746 2.013 2.491L27.875 58zm25.54 0h-3.97L32 52.763zm-1.985-9.65-1.642-2.03 1.642-1.428 1.642 1.427zm5.12-1.658-3.772-3.28 3.693-5.085 1.224 1.332z"
                                                    fill="currentColor" opacity="1" data-original="currentColor">
                                                </path>
                                            </g>
                                        </svg></span>
                                    <h3 class="fs-5 mb-3">Generate Dokumen</h3>
                                    <p class="mb-4">SK diterbitkan dari template, dapat diunduh & otomatis masuk riwayat.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
                            <div
                                class="service-card p-4 rounded-4 h-100 d-flex flex-column justify-content-between gap-5">
                                <div><span class="icon mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 64 64"
                                            style="enable-background:new 0 0 512 512" xml:space="preserve">
                                            <g>
                                                <path
                                                    d="M50.327 4H25.168a6.007 6.007 0 0 0-6 6v5.11h-8.375a3.154 3.154 0 0 0-3.12 3.18v5.47a1 1 0 0 0 .724.961 3.204 3.204 0 0 1 0 6.097 1 1 0 0 0-.724.962v5.49a3.154 3.154 0 0 0 3.12 3.18H34.5c-2.147 8.057 9.408 12.135 12.77 4.441a1 1 0 0 0-1.841-.779 4.778 4.778 0 1 1-4.403-6.636c1.039-.159 2.453 1.082 3.063-.225.449-1.37-1.383-1.598-2.336-1.734V31.8a1 1 0 0 0-.72-.96 3.21 3.21 0 0 1 0-6.11 1 1 0 0 0 .72-.96v-5.48a3.154 3.154 0 0 0-3.12-3.18H21.168V10a4.004 4.004 0 0 1 4-4h3.21l1.24 3.066a3.982 3.982 0 0 0 3.708 2.503h8.826a3.984 3.984 0 0 0 3.71-2.503L47.1 6h3.228a4.004 4.004 0 0 1 4 4v1.6a1 1 0 0 0 2 0V10a6.007 6.007 0 0 0-6-6ZM38.633 17.11a1.153 1.153 0 0 1 1.12 1.18v4.792a5.234 5.234 0 0 0 0 9.405V35.6a6.789 6.789 0 0 0-4.333 2.85H10.793a1.153 1.153 0 0 1-1.12-1.18v-4.8a5.232 5.232 0 0 0 0-9.401V18.29a1.153 1.153 0 0 1 1.12-1.18Zm5.375-8.793a1.994 1.994 0 0 1-1.856 1.252h-8.826a1.991 1.991 0 0 1-1.854-1.252l-.934-2.312H44.94Z"
                                                    fill="currentColor" opacity="1" data-original="#000000">
                                                </path>
                                                <path
                                                    d="M55.327 14.6a1 1 0 0 0-1 1V54a4.004 4.004 0 0 1-4 4H25.168a4.004 4.004 0 0 1-4-4V43.45a1 1 0 0 0-2 0V54a6.007 6.007 0 0 0 6 6h25.16a6.007 6.007 0 0 0 6-6V15.6a1 1 0 0 0-1-1Z"
                                                    fill="currentColor" opacity="1" data-original="#000000">
                                                </path>
                                                <path
                                                    d="M41.185 54.52a1 1 0 0 0 0-2h-6.891a1 1 0 0 0 0 2ZM24.713 28.383a.853.853 0 1 1-.835 1.028.998.998 0 0 0-1.184-.775c-1.765.61-.18 2.94 1.017 3.265-.271 1.919 2.27 1.926 2-.003a2.852 2.852 0 0 0-.998-5.515.851.851 0 1 1 .821-1.084 1 1 0 0 0 1.926-.54 2.857 2.857 0 0 0-1.749-1.893v-.518a1 1 0 0 0-2 0v.521a2.852 2.852 0 0 0 1.002 5.514Z"
                                                    fill="currentColor" opacity="1" data-original="#000000">
                                                </path>
                                                <path
                                                    d="M24.713 36.43a9.092 9.092 0 0 0 9.082-9.082c-.499-12.047-17.666-12.045-18.163 0a9.092 9.092 0 0 0 9.08 9.082Zm0-16.163a7.09 7.09 0 0 1 7.082 7.081c-.371 9.388-13.793 9.387-14.163 0a7.09 7.09 0 0 1 7.08-7.081ZM46.413 37.53l-4.757 4.757-1.68-1.68a1 1 0 0 0-1.413 1.415l2.386 2.386a1 1 0 0 0 1.414 0l5.464-5.464a1 1 0 0 0-1.414-1.414Z"
                                                    fill="currentColor" opacity="1" data-original="#000000">
                                                </path>
                                            </g>
                                        </svg></span>
                                    <h3 class="fs-5 mb-3">Tracking & Audit</h3>
                                    <p class="mb-4">Semua perubahan tercatat rapi: bisa ditinjau kembali kapan saja.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="500">
                            <div
                                class="service-card p-4 rounded-4 h-100 d-flex flex-column justify-content-between gap-5">
                                <div><span class="icon mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 64 64"
                                            style="enable-background:new 0 0 512 512" xml:space="preserve">
                                            <g>
                                                <path
                                                    d="M49.754 34.379a1.001 1.001 0 0 0-1.238-.682c-1.769.767.123 2.972 1.275 3.302a1 1 0 1 0 2-.024 3.075 3.075 0 0 0-1-5.975 1.078 1.078 0 1 1 1.053-1.306 1 1 0 0 0 1.187.77c1.894-.7-.034-3.134-1.24-3.463a1 1 0 1 0-2 .024 3.075 3.075 0 0 0 1 5.975 1.079 1.079 0 1 1-1.037 1.379z"
                                                    fill="currentColor" opacity="1" data-original="#000000">
                                                </path>
                                                <path
                                                    d="M58.589 27.13a1 1 0 0 0-1.694 1.062 7.174 7.174 0 1 1-2.549-2.453 1 1 0 1 0 .992-1.736 9.2 9.2 0 1 0-4.545 17.195c7.082.128 11.668-8.14 7.796-14.068z"
                                                    fill="currentColor" opacity="1" data-original="#000000">
                                                </path>
                                                <path
                                                    d="M6 32.149a15.682 15.682 0 0 1 .671-4.507h6.53a35.936 35.936 0 0 0 0 8.995H6.67A15.558 15.558 0 0 1 6 32.15zm1.413 6.487h6.1a19.912 19.912 0 0 0 3.43 8.446 15.69 15.69 0 0 1-9.53-8.446zm8.118 0h12.29c-2.589 12.171-9.703 12.166-12.29 0zM16.844 8.31H38.91a8.42 8.42 0 0 1 8.4 8.106l-2.018-2.018a1 1 0 0 0-1.414 1.414l3.74 3.74a1 1 0 0 0 1.414 0l3.74-3.74a1 1 0 0 0-1.413-1.414l-2.048 2.047A10.421 10.421 0 0 0 38.911 6.31H16.844a1 1 0 0 0 0 2zM50.105 44.448a1 1 0 0 0-1.413 0l-3.74 3.74a1 1 0 1 0 1.413 1.414l2.018-2.018a8.419 8.419 0 0 1-8.4 8.107H17.916a1 1 0 0 0 0 2h22.067a10.42 10.42 0 0 0 10.401-10.136l2.048 2.047a1 1 0 0 0 1.413-1.414z"
                                                    fill="currentColor" opacity="1" data-original="#000000">
                                                </path>
                                                <path
                                                    d="M35.719 21.413a1 1 0 0 0-1.586 1.218 15.554 15.554 0 0 1 1.806 3.012h-6.1a19.93 19.93 0 0 0-3.417-8.42 15.637 15.637 0 0 1 5.012 2.652 1 1 0 0 0 1.245-1.565 17.676 17.676 0 1 0-11.002 31.51c14.511.067 22.936-16.94 14.042-28.407zm.966 6.23a15.507 15.507 0 0 1 .001 8.994h-6.533a35.942 35.942 0 0 0-.001-8.995zM29.84 38.635h6.102a15.688 15.688 0 0 1-9.534 8.447 19.91 19.91 0 0 0 3.432-8.447zm-1.402-6.491a34.461 34.461 0 0 1-.292 4.492h-12.94a34.731 34.731 0 0 1 .001-8.995h12.938a34.461 34.461 0 0 1 .293 4.503zm-6.812-15.67c2.533-.006 5.021 3.488 6.193 9.168H15.535c1.138-5.63 3.672-9.12 6.092-9.168zm-4.683.734a19.903 19.903 0 0 0-3.429 8.434H7.417a15.707 15.707 0 0 1 9.527-8.434z"
                                                    fill="currentColor" opacity="1" data-original="#000000">
                                                </path>
                                            </g>
                                        </svg></span>
                                    <h3 class="fs-5 mb-3">Pengingat</h3>
                                    <p class="mb-4">Pengingat jadwal kenaikan gaji & notifikasi progres permohonan.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="600">
                            <div
                                class="service-card p-4 rounded-4 h-100 d-flex flex-column justify-content-between gap-5">
                                <div><span class="icon mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 64 64"
                                            style="enable-background:new 0 0 512 512" xml:space="preserve">
                                            <g>
                                                <path
                                                    d="M49.5 4H24.34a6.007 6.007 0 0 0-6 6v5.29a1 1 0 0 0 2 0V10a4.005 4.005 0 0 1 4-4h3.218l1.237 3.066a3.984 3.984 0 0 0 3.71 2.503h8.826a3.984 3.984 0 0 0 3.71-2.503L46.277 6H49.5a4.004 4.004 0 0 1 4 4v44a4.004 4.004 0 0 1-4 4H24.34a4.005 4.005 0 0 1-4-4V39.42h11.8a6.774 6.774 0 0 0 12.998 2.159 1 1 0 0 0-1.842-.78 4.778 4.778 0 1 1-2.638-6.3 1 1 0 0 0 1.298-.56c.446-1.634-1.965-1.701-3.062-1.776a6.785 6.785 0 0 0-6.6 5.257H13.502a3.003 3.003 0 0 1-3-3v-7.932h27.4v2.672a1 1 0 0 0 2 0v-5.87a5.006 5.006 0 0 0-5-5H13.5a5.006 5.006 0 0 0-5 5c.007 1.424-.005 9.521 0 11.13a5.006 5.006 0 0 0 5 5h4.84V54a6.007 6.007 0 0 0 6 6H49.5a6.007 6.007 0 0 0 6-6V10a6.007 6.007 0 0 0-6-6zm-6.314 4.317a1.994 1.994 0 0 1-1.855 1.252h-8.827a1.992 1.992 0 0 1-1.854-1.252l-.934-2.312H44.12zM10.501 23.29a3.003 3.003 0 0 1 3-3h21.4a3.003 3.003 0 0 1 3 3v1.198H10.5z"
                                                    fill="currentColor" opacity="1" data-original="#000000">
                                                </path>
                                                <path
                                                    d="M33.472 52.52a1 1 0 0 0 0 2h6.89a1 1 0 0 0 0-2zM37.844 37.294a1 1 0 0 0-1.414 1.415l2.387 2.387a1 1 0 0 0 1.414 0l5.464-5.465a1 1 0 0 0-1.414-1.414l-4.757 4.757zM13.29 33.143a1 1 0 0 0 0 2h2.45a1 1 0 0 0 0-2z"
                                                    fill="currentColor" opacity="1" data-original="#000000">
                                                </path>
                                            </g>
                                        </svg></span>
                                    <h3 class="fs-5 mb-3">Bantuan</h3>
                                    <p class="mb-4">Tim siap membantu apabila terjadi kendala operasional.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Services-->

            <!-- ======= FAQ =======-->
            <section class="section faq__v2" id="faq-DIGAJI">
                <div class="container">
                    <div class="row mb-4">
                        <div class="col-md-6 col-lg-7 mx-auto text-center">
                            <span class="subtitle text-uppercase mb-3" data-aos="fade-up"
                                data-aos-delay="0">FAQ</span>
                            <h2 class="h2 fw-bold mb-3" data-aos="fade-up" data-aos-delay="0">Pertanyaan Umum Seputar
                                DIGAJI Sumenep</h2>
                            <p data-aos="fade-up" data-aos-delay="100">
                                Temukan jawaban atas pertanyaan paling umum tentang Sistem Informasi Gagas Inovasi dan
                                Layanan DIGAJI Sumenep.
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mx-auto" data-aos="fade-up" data-aos-delay="200">
                            <div class="faq-content">
                                <div class="accordion custom-accordion" id="accordionFaqsEBergaji">

                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-aboutEBergaji" aria-expanded="true"
                                                aria-controls="panelsStayOpen-aboutEBergaji">
                                                Apa itu DIGAJI Sumenep dan untuk siapa?
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-aboutEBergaji" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <p><strong>DIGAJI</strong> adalah sebuah sistem informasi berbasis
                                                    web yang dikembangkan oleh Badan Riset dan Inovasi Daerah (BRIDA)
                                                    Kabupaten Sumenep. Platform ini bertujuan menjadi jembatan antara
                                                    BRIDA dengan masyarakat, akademisi, dan instansi lain dalam hal
                                                    riset, inovasi, dan layanan publik.</p>
                                                <p>Sistem ini dapat digunakan oleh:</p>
                                                <ul>
                                                    <li>Masyarakat umum yang ingin mengetahui program dan hasil riset
                                                        BRIDA.</li>
                                                    <li>Akademisi dan peneliti yang ingin mengajukan proposal riset atau
                                                        berkolaborasi.</li>
                                                    <li>Instansi pemerintah atau swasta yang membutuhkan data atau hasil
                                                        riset.</li>
                                                    <li>Pelaku UMKM yang mencari inovasi untuk mengembangkan produknya.
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-registration" aria-expanded="false"
                                                aria-controls="panelsStayOpen-registration">
                                                Bagaimana cara mendaftar atau masuk ke DIGAJI?
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-registration" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                Anda bisa mendaftar dengan mengklik tombol "Daftar" di halaman utama.
                                                Isi data diri Anda dengan lengkap dan benar. Setelah pendaftaran
                                                berhasil, Anda dapat masuk menggunakan akun yang sudah dibuat.
                                                Jika Anda lupa kata sandi, gunakan fitur "Lupa Kata Sandi". Masukkan
                                                alamat email yang terdaftar, dan sistem akan mengirimkan tautan untuk
                                                mengatur ulang kata sandi Anda.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-proposal"
                                                aria-expanded="false" aria-controls="panelsStayOpen-proposal">
                                                Bagaimana cara mengajukan dan melacak status proposal riset?
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-proposal" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                Untuk mengajukan proposal riset:
                                                <ol>
                                                    <li>Masuk ke akun Anda.</li>
                                                    <li>Pilih menu "Pengajuan Proposal Riset".</li>
                                                    <li>Isi formulir pengajuan dengan informasi yang diperlukan (judul,
                                                        latar belakang, metodologi, anggaran).</li>
                                                    <li>Unggah dokumen proposal Anda dalam format yang ditentukan
                                                        (biasanya PDF).</li>
                                                    <li>Klik "Kirim" untuk menyelesaikan pengajuan. Anda akan menerima
                                                        notifikasi status proposal Anda melalui email.</li>
                                                </ol>
                                                Anda bisa melacak status proposal melalui menu "Riwayat Pengajuan" di
                                                akun Anda. Statusnya akan diperbarui secara berkala, mulai dari
                                                "Menunggu Verifikasi", "Sedang Ditinjau", hingga "Diterima" atau
                                                "Ditolak".
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-support"
                                                aria-expanded="false" aria-controls="panelsStayOpen-support">
                                                Bagaimana saya bisa mendapatkan dukungan atau bantuan lebih lanjut?
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-support" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                Kami menyediakan panduan penggunaan digital yang dapat diunduh di menu
                                                "Panduan Pengguna" atau "Bantuan" di situs web DIGAJI.
                                                Anda juga dapat menghubungi tim dukungan kami melalui fitur "Hubungi
                                                Kami" yang tersedia di situs web, mengirimkan email ke alamat yang
                                                tercantum, atau menghubungi nomor telepon yang tersedia di halaman
                                                tersebut.
                                                <br><br>
                                                Penggunaan platform DIGAJI untuk pendaftaran dan pengajuan
                                                proposal riset pada umumnya tidak dikenakan biaya. Namun, untuk program
                                                atau layanan tertentu, mungkin akan ada ketentuan yang berlaku dan akan
                                                diinformasikan secara jelas.
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End FAQ-->

            <!-- ======= Contact =======-->
            <section class="section contact__v2" id="contact" aria-labelledby="contactHeading">
                <div class="container">
                    <div class="row mb-5">
                        <div class="col-md-6 col-lg-7 mx-auto text-center">
                            <span class="subtitle text-uppercase mb-3" data-aos="fade-up"
                                data-aos-delay="0">Kontak & Konsultasi</span>
                            <h2 id="contactHeading" class="h2 fw-bold mb-3" data-aos="fade-up" data-aos-delay="0">Hubungi Kami</h2>
                            <p data-aos="fade-up" data-aos-delay="100">
                                Jika Anda memiliki pertanyaan, saran, ingin berkolaborasi, atau jika instansi Anda ingin mengajukan permohonan agar dapat menggunakan sistem DIGAJI, jangan ragu untuk menghubungi kami melalui formulir atau informasi kontak di bawah.
                            </p>
                        </div>
                    </div>
                    <div class="row g-4 align-items-start">
                        <div class="col-md-6">
                            <ul class="list-unstyled d-flex flex-column gap-4 info-stack mb-0">
                                <li class="contact-item d-flex align-items-start gap-3" data-aos="fade-up" data-aos-delay="0">
                                    <div class="icon flex-shrink-0"><i class="bi bi-telephone" aria-hidden="true"></i></div>
                                    <div>
                                        <span class="d-block fw-semibold small text-uppercase text-muted">Telepon</span>
                                        <a href="tel:+623289912345" class="stretched-link d-inline-block fw-bold text-decoration-none" aria-label="Telepon BRIDA di nomor 0328 9912345">(0328) 9912345</a>
                                    </div>
                                </li>
                                <li class="contact-item d-flex align-items-start gap-3" data-aos="fade-up" data-aos-delay="100">
                                    <div class="icon flex-shrink-0"><i class="bi bi-send" aria-hidden="true"></i></div>
                                    <div>
                                        <span class="d-block fw-semibold small text-uppercase text-muted">Email</span>
                                        <a href="mailto:brida@sumenep.go.id" class="d-inline-block fw-bold text-decoration-none" aria-label="Kirim email ke brida@sumenep.go.id">brida@sumenep.go.id</a>
                                    </div>
                                </li>
                                <li class="contact-item d-flex align-items-start gap-3" data-aos="fade-up" data-aos-delay="200">
                                    <div class="icon flex-shrink-0"><i class="bi bi-geo-alt" aria-hidden="true"></i></div>
                                    <div>
                                        <span class="d-block fw-semibold small text-uppercase text-muted">Alamat</span>
                                        <address class="fw-bold mb-0 small lh-sm pe-4">
                                            Jl. Raya Sumenep-Pamekasan No. 123<br>
                                            Sumenep, Jawa Timur 69416<br>
                                            Indonesia
                                        </address>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <div class="form-wrapper card border-0 shadow-sm p-4" data-aos="fade-up" data-aos-delay="300">
                                {{-- Alert sukses dari session --}}
                                @if(session('success'))
                                    <div class="mt-0 mb-3 alert alert-success" role="alert" aria-live="polite">{{ session('success') }}</div>
                                @endif
                                {{-- Alert error validasi --}}
                                @if($errors->any())
                                    <div class="mt-0 mb-3 alert alert-danger" role="alert" aria-live="assertive">
                                        <ul class="mb-0 ps-3">
                                            @foreach($errors->all() as $err)
                                                <li>{{ $err }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form id="contactForm" action="{{ route('contact.store') }}" method="POST" novalidate aria-describedby="contactFormDesc" role="form">
                                    @csrf
                                    <p id="contactFormDesc" class="visually-hidden">Formulir untuk mengirim pesan ke tim BRIDA. Semua kolom kecuali subjek wajib diisi.</p>
                                    <div class="mb-3">
                                        <label class="mb-2 fw-medium" for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" required aria-required="true" autocomplete="name" placeholder="Nama Anda" value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="mb-2 fw-medium" for="email">Email <span class="text-danger">*</span></label>
                                        <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" required aria-required="true" autocomplete="email" placeholder="email@contoh.com" value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="mb-2 fw-medium" for="subject">Subjek</label>
                                        <input class="form-control @error('subject') is-invalid @enderror" id="subject" type="text" name="subject" maxlength="120" placeholder="(Opsional)" value="{{ old('subject') }}">
                                        @error('subject')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="mb-2 fw-medium" for="message">Pesan Anda <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" required aria-required="true" minlength="10" placeholder="Tulis pesan atau pertanyaan Anda...">{{ old('message') }}</textarea>
                                        <small class="form-text text-muted">Minimal 10 karakter.</small>
                                        <small class="form-text text-muted">Keterangan: Bintang Merah = Wajib Diisi</small>
                                        @error('message')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button class="btn btn-primary fw-semibold px-4" type="submit">Kirim Pesan</button>
                                </form>

                                {{-- Pesan sukses/gagal kini ditangani via session flash dari server --}}
                                <div class="contact-message-list mt-5">
                                    <h4 class="fw-bold mb-4">Pesan Pengguna</h4>

                                    @forelse($messages as $msg)
                                        <div class="message-card mb-3 d-flex align-items-start gap-3 p-3 rounded-4">
                                            <div class="avatar flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle text-white fw-bold">
                                                {{ strtoupper(substr($msg->name, 0, 1)) }}
                                            </div>

                                            <div class="flex-grow-1">
                                                <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 mb-2">
                                                    <strong>{{ $msg->name }}</strong>
                                                    <small class="text-muted">{{ $msg->created_at->diffForHumans() }}</small>
                                                </div>

                                                @if($msg->subject)
                                                    <div class="fw-semibold text-primary mb-1">{{ $msg->subject }}</div>
                                                @endif

                                                <div class="text-muted">{{ $msg->message }}</div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="alert alert-info mb-0">Belum ada pesan yang dikirim.</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Contact-->

            <!-- ======= Footer =======-->
            <footer class="bg-light border-top py-4 mt-5">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                            <span class="fw-semibold text-primary">DIGAJI</span>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="text-muted small">
                                &copy; <span id="footerYear">{{ date('Y') }}</span>
                                DIGAJI — dikembangkan oleh
                                <a href="https://brida.sumenepkab.go.id/" target="_blank" rel="noopener" class="fw-semibold text-primary">BRIDA Sumenep</a>.
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <script>
                // Fallback for year if JS is enabled
                const fy = document.getElementById('footerYear');
                if (fy) fy.textContent = new Date().getFullYear();
            </script>
            <!-- End Footer-->

        </main>
    </div>

    <!-- ======= Back to Top =======-->
    <button id="back-to-top"><i class="bi bi-arrow-up-short"></i></button>
    <!-- End Back to top-->

    <!-- ======= Javascripts =======-->
    <script src="{{ asset('assets/vendors/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/gsap/gsap.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/isotope/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/glightbox/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendors/purecounter/purecounter.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/send_email.js') }}"></script>
    <!-- End JavaScripts-->
</body>

</html>
