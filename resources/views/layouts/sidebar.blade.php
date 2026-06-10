<div class="navbar-content">
    <ul class="pc-navbar pc-trigger">

        @switch(Auth::user()->role)
            {{-- Admin --}}
            @case('admin')
                <li class="pc-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-home"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>
                <li class="pc-item pc-caption">
                    <label>Manajemen Data</label>
                </li>
                <li class="pc-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Pengguna</span>
                    </a>
                </li>
                <li class="pc-item {{ request()->routeIs('admin.unit-kerjas*') ? 'active' : '' }}">
                    <a href="{{ route('admin.unit-kerjas.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-building"></i></span>
                        <span class="pc-mtext">Unit Kerja</span>
                    </a>
                </li>
                <li class="pc-item pc-caption">
                    <label>Data Master </label>
                </li>
                <li class="pc-item {{ request()->routeIs('admin.golongans*') ? 'active' : '' }}">
                    <a href="{{ route('admin.golongans.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-git-fork"></i></span>
                        <span class="pc-mtext">Golongan</span>
                    </a>
                </li>
                <li class="pc-item {{ request()->routeIs('admin.gajis*') ? 'active' : '' }}">
                    <a href="{{ route('admin.gajis.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-currency-dollar"></i></span>
                        <span class="pc-mtext">Gaji Pokok</span>
                    </a>
                </li>
                <li class="pc-item pc-caption">
                    <label>Lainnya</label>
                </li>
                <li class="pc-item {{ request()->routeIs('admin.contact-messages*') ? 'active' : '' }}">
                    <a href="{{ route('admin.contact-messages.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-mail"></i></span>
                        <span class="pc-mtext">Pesan Kontak</span>
                    </a>
                </li>
                <li class="pc-item {{ request()->routeIs('admin.panduan') ? 'active' : '' }}">
                    <a href="{{ route('admin.panduan') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-help"></i></span>
                        <span class="pc-mtext">Panduan Penggunaan</span>
                    </a>
                </li>
            @break

            {{-- Operator --}}
            @case('operator')
                <li class="pc-item {{ request()->routeIs('operator.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('operator.dashboard') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-home"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                <!-- Section Pegawai -->
                <li class="pc-item pc-caption">
                    <label>Data Pegawai</label>
                </li>
                <li class="pc-item {{ request()->routeIs('operator.pegawais*') ? 'active' : '' }}">
                    <a href="{{ route('operator.pegawais.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Manajemen Pegawai</span>
                    </a>
                </li>
                <li class="pc-item {{ request()->routeIs('operator.sk-pengangkatan*') ? 'active' : '' }}">
                    <a href="{{ route('operator.sk-pengangkatan.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-id"></i></span>
                        <span class="pc-mtext">SK Pengangkatan</span>
                    </a>
                </li>
                <li class="pc-item {{ request()->routeIs('operator.riwayat_gbks*') ? 'active' : '' }}">
                    <a href="{{ route('operator.riwayat_gbks.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-history"></i></span>
                        <span class="pc-mtext">Riwayat Gaji Berkala</span>
                    </a>
                </li>
                <li class="pc-item {{ request()->routeIs('operator.riwayat-kenaikan-pangkat.*') ? 'active' : '' }}">
                    <a href="{{ route('operator.riwayat-kenaikan-pangkat.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-stairs-up"></i></span>
                        <span class="pc-mtext">Riwayat Pangkat</span>
                    </a>
                </li>
                <!-- Section Permohonan -->
                <li class="pc-item pc-caption">
                    <label>Permohonan</label>
                </li>
                <li class="pc-item {{ request()->routeIs('operator.permohonan-sk*') ? 'active' : '' }}">
                    <a href="{{ route('operator.permohonan-sk.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-file-text"></i></span>
                        <span class="pc-mtext">SK Gaji Berkala</span>
                    </a>
                </li>
                <li class="pc-item {{ request()->routeIs('operator.kenaikan-pangkat.*') ? 'active' : '' }}">
                    <a href="{{ route('operator.kenaikan-pangkat.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-arrow-bar-up"></i></span>
                        <span class="pc-mtext">Kenaikan Pangkat</span>
                    </a>
                </li>
                <li class="pc-item pc-caption">
                    <label>Lainnya</label>
                </li>
                <li class="pc-item {{ request()->routeIs('operator.instan-gbk*') ? 'active' : '' }}">
                    <a href="{{ route('operator.instan-gbk.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-file-invoice"></i></span>
                        <span class="pc-mtext">Instan SK GBK</span>
                    </a>
                </li>
                <li class="pc-item {{ request()->routeIs('operator.template-sk*') ? 'active' : '' }}">
                    <a href="{{ route('operator.template-sk.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-file-upload"></i></span>
                        <span class="pc-mtext">Template SK</span>
                    </a>
                </li>
                <li class="pc-item {{ request()->routeIs('operator.panduan') ? 'active' : '' }}">
                    <a href="{{ route('operator.panduan') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-help"></i></span>
                        <span class="pc-mtext">Panduan Penggunaan</span>
                    </a>
                </li>
            @break

            {{-- Pegawai --}}
            @case('pegawai')
                <!-- Dashboard -->
                <li class="pc-item {{ request()->routeIs('pegawai.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('pegawai.dashboard') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-home"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                <!-- Layanan Pegawai -->
                <li class="pc-item pc-caption">
                    <label>Data Pegawai</label>
                </li>
                <li class="pc-item {{ request()->routeIs('pegawai.profile*') ? 'active' : '' }}">
                    <a href="{{ route('pegawai.profile.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-user"></i></span>
                        <span class="pc-mtext">Data Pribadi</span>
                    </a>
                </li>
                <li class="pc-item {{ request()->routeIs('pegawai.riwayat-gbk*') ? 'active' : '' }}">
                    <a href="{{ route('pegawai.riwayat-gbk.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-history"></i></span>
                        <span class="pc-mtext">Riwayat Gaji Berkala</span>
                    </a>
                </li>
                <li class="pc-item {{ request()->routeIs('pegawai.riwayat-kenaikan-pangkat.*') ? 'active' : '' }}">
                    <a href="{{ route('pegawai.riwayat-kenaikan-pangkat.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-stairs-up"></i></span>
                        <span class="pc-mtext">Riwayat Pangkat</span>
                    </a>
                </li>

                <!-- Permohonan -->
                <li class="pc-item pc-caption">
                    <label>Permohonan</label>
                </li>
                <li class="pc-item {{ request()->routeIs('pegawai.permohonan-sk*') ? 'active' : '' }}">
                    <a href="{{ route('pegawai.permohonan-sk.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-file-text"></i></span>
                        <span class="pc-mtext">SK Gaji Berkala</span>
                    </a>
                </li>
                <li class="pc-item {{ request()->routeIs('pegawai.permohonan-kenaikan-pangkat.*') ? 'active' : '' }}">
                    <a href="{{ route('pegawai.permohonan-kenaikan-pangkat.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-arrow-bar-up"></i></span>
                        <span class="pc-mtext">Kenaikan Pangkat</span>
                    </a>
                </li>

                <!-- Lainnya -->
                <li class="pc-item pc-caption">
                    <label>Lainnya</label>
                </li>
                <li class="pc-item {{ request()->routeIs('pegawai.security.*') ? 'active' : '' }}">
                    <a href="{{ route('pegawai.security.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-lock"></i></span>
                        <span class="pc-mtext">Keamanan Akun</span>
                    </a>
                </li>
                <li class="pc-item {{ request()->routeIs('pegawai.panduan') ? 'active' : '' }}">
                    <a href="{{ route('pegawai.panduan') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-help"></i></span>
                        <span class="pc-mtext">Panduan Penggunaan</span>
                    </a>
                </li>
            @break

            @default
        @endswitch

    </ul>
</div>
