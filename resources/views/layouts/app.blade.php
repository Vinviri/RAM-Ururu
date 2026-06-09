<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - RAM Ururu</title>
    <meta name="description" content="@yield('description', 'Sistem Persediaan Barang Toko RAM Ururu')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-body">
    {{-- Sidebar --}}
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 7h-4a2 2 0 0 0-2 2v.5"/>
                    <path d="M14 9.5V12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v1"/>
                    <path d="M20 7v10a2 2 0 0 1-2 2H10a2 2 0 0 1-2-2v-1"/>
                    <path d="M6 6h4"/><path d="M6 10h2"/>
                    <path d="M12 16h4"/><path d="M12 20h2"/>
                </svg>
            </div>
            <div class="sidebar-brand">
                <h2>RAM Ururu</h2>
                <span>Inventory System</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav-list">
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" id="nav-dashboard">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/>
                            <rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- Master Data (Dropdown) --}}
                <li class="nav-item nav-dropdown {{ request()->routeIs('kategori.*', 'barang.*', 'pengguna.*') ? 'open' : '' }}">
                    <a href="#" class="nav-link nav-toggle" id="nav-master-data">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <ellipse cx="12" cy="5" rx="9" ry="3"/>
                            <path d="M3 5V19A9 3 0 0 0 21 19V5"/>
                            <path d="M3 12A9 3 0 0 0 21 12"/>
                        </svg>
                        <span>Master Data</span>
                        <svg class="dropdown-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </a>
                    <ul class="nav-submenu">
                        <li>
                            <a href="{{ route('kategori.index') }}" class="nav-sublink {{ request()->routeIs('kategori.*') ? 'active' : '' }}" id="nav-kategori">
                                <span class="submenu-dot"></span>Kategori Barang
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('barang.index') }}" class="nav-sublink {{ request()->routeIs('barang.*') ? 'active' : '' }}" id="nav-barang">
                                <span class="submenu-dot"></span>Daftar Barang
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pengguna.index') }}" class="nav-sublink {{ request()->routeIs('pengguna.*') ? 'active' : '' }}" id="nav-pengguna">
                                <span class="submenu-dot"></span>Manajemen Pengguna
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Persediaan Barang (Dropdown) --}}
                <li class="nav-item nav-dropdown {{ request()->routeIs('persediaan.*') ? 'open' : '' }}">
                    <a href="#" class="nav-link nav-toggle" id="nav-persediaan">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m7.5 4.27 9 5.15"/>
                            <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                            <path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/>
                        </svg>
                        <span>Persediaan Barang</span>
                        <svg class="dropdown-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </a>
                    <ul class="nav-submenu">
                        <li>
                            <a href="{{ route('persediaan.stok') }}" class="nav-sublink {{ request()->routeIs('persediaan.stok') ? 'active' : '' }}" id="nav-stok">
                                <span class="submenu-dot"></span>Data Stok
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('persediaan.masuk.create') }}" class="nav-sublink {{ request()->routeIs('persediaan.masuk.*') ? 'active' : '' }}" id="nav-masuk">
                                <span class="submenu-dot"></span>Barang Masuk
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('persediaan.keluar.create') }}" class="nav-sublink {{ request()->routeIs('persediaan.keluar.*') ? 'active' : '' }}" id="nav-keluar">
                                <span class="submenu-dot"></span>Barang Keluar
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Laporan --}}
                <li class="nav-item">
                    <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}" id="nav-laporan">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/>
                            <path d="M14 2v4a2 2 0 0 0 2 2h4"/>
                            <path d="M10 18V12"/><path d="M14 18v-3"/>
                        </svg>
                        <span>Laporan</span>
                    </a>
                </li>
            </ul>
        </nav>

        {{-- Sidebar Footer --}}
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="submit" class="nav-link logout-btn" id="btn-logout">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Sidebar Overlay (Mobile) --}}
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    {{-- Main Content --}}
    <main class="main-content" id="main-content">
        {{-- Floating Header --}}
        <header class="top-header" id="top-header">
            <div class="header-left">
                <button class="sidebar-toggle" id="sidebar-toggle" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="4" x2="20" y1="12" y2="12"/>
                        <line x1="4" x2="20" y1="6" y2="6"/>
                        <line x1="4" x2="20" y1="18" y2="18"/>
                    </svg>
                </button>
                <div class="page-info">
                    <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                    <p class="page-breadcrumb">@yield('breadcrumb', 'Beranda')</p>
                </div>
            </div>
            <div class="header-right">
                <div class="header-user">
                    <div class="user-info">
                        <span class="user-name">{{ Auth::user()->nama_admin }}</span>
                        <span class="user-role">Administrator</span>
                    </div>
                    <div class="user-avatar" id="user-avatar">
                        {{ strtoupper(substr(Auth::user()->nama_admin, 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <div class="content-wrapper">
            @yield('content')
        </div>
    </main>

    {{-- Toast Container --}}
    <div class="toast-container" id="toast-container">
        @if(session('success'))
            <div class="toast toast-success" id="toast-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="toast toast-error" id="toast-error">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/>
                    <line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif
    </div>

    @stack('scripts')
</body>
</html>
