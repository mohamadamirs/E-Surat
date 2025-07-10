<aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-expand">
    <!-- Brand Logo -->
    <a href="{{ route(Auth::user()->getDashboard()) }}" class="brand-link">
        @if (Auth::user()->profile_photo_path)
            {{-- Tambahkan class "brand-image" --}}
            <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}"
                class="brand-image img-circle  elevation-4">
        @else
            {{-- Jika tidak ada foto, bisa tampilkan logo default aplikasi --}}
            <img src="{{ asset('images/profile.svg') }}" alt="Logo E-Surat" type="image/svg+xml"
                class="brand-image img-circle elevation-4">
        @endif
        {{-- Tambahkan class "brand-text" --}}
        <span class="brand-text font-weight-bold">E-Surat</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user  -->
        <div class="user-panel mt-3 mb-3 d-flex">

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">

                    {{-- MENU UNTUK SEMUA USER --}}
                    <li class="nav-item">
                        <a href="{{ route(Auth::user()->getDashboard()) }}"
                            class="nav-link {{ request()->is('*dashboard*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    {{-- MENU KHUSUS ADMIN --}}
                    @if (Auth::user())

                        {{-- 1. MENU UNTUK ADMIN --}}
                        @if (Auth::user()->role == 'admin')
                            <li class="nav-header">PENGELOLAAN</li>
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}"
                                    class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-users-cog"></i>
                                    <p>Kelola Pengguna</p>
                                </a>
                            </li>
                            <li class="nav-header">PENGATURAN</li>
                            <li class="nav-item">
                                <a href="{{ route('profile.show') }}"
                                    class="nav-link {{ request()->is('profile*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-cogs"></i>
                                    <p>Profil</p>
                                </a>
                            </li>
                        @endif

                        {{-- MENU UNTUK kepala --}}
                        @if (Auth::user()->role == 'kepala')
                            <li class="nav-header">SUPERVISOR</li>
                            <li class="nav-item">
                                <a href="{{ route('kepala.validasi.index') }}"
                                    class="nav-link {{ request()->routeIs('kepala.validasi.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-check-double"></i>
                                    <p>Disposisi Surat</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('kepala.surat-keluar.index') }}"
                                    class="nav-link {{ request()->routeIs('kepala.surat-keluar.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-paper-plane"></i>
                                    <p>Lihat Surat Keluar</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('kepala.riwayat.index') }}"
                                    class="nav-link {{ request()->routeIs('kepala.riwayat.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-history"></i>
                                    <p>Riwayat Validasi</p>
                                </a>
                            </li>
                            <li class="nav-header">PENGATURAN</li>
                            <li class="nav-item">
                                <a href="{{ route('profile.show') }}"
                                    class="nav-link {{ request()->is('profile*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-cogs"></i>
                                    <p>Profil</p>
                                </a>
                            </li>
                        @endif

                        {{-- MENU UNTUK Sekretaris --}}
                        @if (Auth::user()->role == 'sekretaris')
                            <li class="nav-header">SEKRETARIS</li>
                            <li class="nav-item">
                                <a href="{{ route('sekretaris.surat-masuk.index') }}"
                                    class="nav-link {{ request()->is('sekretaris/surat-masuk*') ? 'active' : '' }}">
                                    <i class="nav-icon far fa-envelope-open"></i>
                                    <p>Kelola Surat Masuk</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('sekretaris.surat-keluar.index') }}"
                                    class="nav-link {{ request()->is('sekretaris/surat-keluar*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-envelope"></i>
                                    <p>Kelola Surat Keluar</p>
                                </a>
                            </li>
                            <li class="nav-header">PENGATURAN</li>
                            <li class="nav-item">
                                <a href="{{ route('profile.show') }}"
                                    class="nav-link {{ request()->is('profile*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-cogs"></i>
                                    <p>Profil</p>
                                </a>
                            </li>
                        @endif

                    @endif
                    {{-- AKHIR DARI LOGIKA ROLE --}}

                </ul>
            </nav>
            {{-- NAVIGASI --}}
        </div>
        {{-- SIDEBAR --}}
</aside>
