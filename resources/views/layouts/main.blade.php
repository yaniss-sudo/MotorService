<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ServiceMotor') - YZ Service Motor</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    @stack('styles')
</head>
<body>

<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<!-- SIDEBAR KIRI -->
<aside class="app-sidebar" id="appSidebar">
    <div class="sidebar-header">
        <a class="sidebar-brand" href="{{ Route::has('dashboard') ? route('dashboard') : route('pelanggan.index') }}">
            <img src="{{ asset('favicon.png') }}" alt="Logo">
            <div class="sidebar-brand-text">
                <span class="sidebar-brand-title">ServiceMotor</span>
                <span class="sidebar-brand-sub">Sistem Bengkel</span>
            </div>
        </a>

        <button type="button" class="sidebar-close-btn" id="sidebarClose" aria-label="Tutup menu">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <nav class="sidebar-nav">
        @if(Route::has('dashboard'))
            <div class="sidebar-section-label">Ringkasan</div>
            <a class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                <span>Dashboard</span>
            </a>
        @endif

        <div class="sidebar-section-label">Operasional Bengkel</div>

        <a class="sidebar-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}" href="{{ route('pelanggan.index') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span>Pelanggan</span>
        </a>

        <a class="sidebar-link {{ request()->routeIs('kendaraan.*') ? 'active' : '' }}" href="{{ route('kendaraan.index') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="5.5" cy="17.5" r="3.5"></circle>
                <circle cx="18.5" cy="17.5" r="3.5"></circle>
                <path d="M15 6a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-3 11.5V14l-3-3 4-3 2 3h2"></path>
            </svg>
            <span>Kendaraan</span>
        </a>

        <a class="sidebar-link {{ request()->routeIs('daftar-service.*') ? 'active' : '' }}" href="{{ route('daftar-service.index') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                <line x1="9" y1="12" x2="15" y2="12"></line>
                <line x1="9" y1="16" x2="13" y2="16"></line>
            </svg>
            <span>Daftar Service</span>
        </a>

        <a class="sidebar-link {{ request()->routeIs('data-service.*') ? 'active' : '' }}" href="{{ route('data-service.index') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
            </svg>
            <span>Data Service</span>
        </a>

        <a class="sidebar-link {{ request()->routeIs('pembayaran.*') ? 'active' : '' }}" href="{{ route('pembayaran.index') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                <line x1="1" y1="10" x2="23" y2="10"></line>
            </svg>
            <span>Pembayaran</span>
        </a>
    </nav>

    @auth
    <div class="sidebar-footer">
        <a href="{{ Route::has('profile.edit') ? route('profile.edit') : '#' }}" class="user-pill w-100 justify-content-between">
            <span class="text-truncate">{{ auth()->user()->name }}</span>
            <span class="role-tag">{{ auth()->user()->role }}</span>
        </a>

        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="btn-logout w-100 d-flex align-items-center justify-content-center gap-2">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
    @endauth
</aside>

<!-- AREA KONTEN UTAMA -->
<div class="app-main">
    <!-- TOPBAR MOBILE -->
    <header class="mobile-topbar">
        <a class="sidebar-brand" href="{{ Route::has('dashboard') ? route('dashboard') : route('pelanggan.index') }}">
            <img src="{{ asset('favicon.png') }}" alt="Logo" style="width: 28px; height: 28px;">
            <span class="sidebar-brand-title" style="font-size: 0.98rem;">ServiceMotor</span>
        </a>

        <button type="button" class="btn btn-secondary btn-sm d-inline-flex align-items-center gap-1" id="sidebarOpen" aria-label="Buka menu">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
            <span>Menu</span>
        </button>
    </header>

    <main class="main-container">
        @if(session('success'))
            <div class="alert alert-custom-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-custom-danger mb-4" role="alert">
                <strong class="d-block mb-1">Data belum valid:</strong>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar = document.getElementById('appSidebar');
    const backdrop = document.getElementById('sidebarBackdrop');
    const openBtn = document.getElementById('sidebarOpen');
    const closeBtn = document.getElementById('sidebarClose');

    function openSidebar() {
        sidebar?.classList.add('is-open');
        backdrop?.classList.add('is-visible');
    }

    function closeSidebar() {
        sidebar?.classList.remove('is-open');
        backdrop?.classList.remove('is-visible');
    }

    openBtn?.addEventListener('click', openSidebar);
    closeBtn?.addEventListener('click', closeSidebar);
    backdrop?.addEventListener('click', closeSidebar);
</script>
@stack('scripts')
</body>
</html>
