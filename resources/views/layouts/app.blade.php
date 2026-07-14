<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Inventory App</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 240px;
            --sidebar-bg: #1e2a3a;
            --sidebar-hover: rgba(255, 255, 255, 0.06);
            --sidebar-active: #2d6a4f;
            --topbar-height: 60px;
        }

        body {
            background-color: #f4f6f9;
        }

        /* ---- SIDEBAR ---- */
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            color: #fff;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: width .25s ease;
        }

        .sidebar-brand {
            padding: 0 20px;
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            font-size: 1.1rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 10px 0;
        }

        .sidebar-nav .nav-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #7f8c8d;
            padding: 18px 20px 6px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 20px;
            color: #cbd5e1;
            text-decoration: none;
            font-size: .9rem;
            border-left: 3px solid transparent;
            transition: background .15s, color .15s;
        }

        .sidebar-nav a:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }

        .sidebar-nav a.active {
            background: var(--sidebar-hover);
            color: #fff;
            border-left-color: #52b788;
            font-weight: 600;
        }

        .sidebar-nav a i {
            font-size: 1rem;
            width: 18px;
            text-align: center;
        }

        /* ---- MAIN ---- */
        #main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ---- TOPBAR ---- */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 999;
            height: var(--topbar-height);
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            padding: 0 24px;
            justify-content: space-between;
        }

        .topbar-title {
            font-weight: 600;
            font-size: 1.05rem;
            color: #1e2a3a;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: .88rem;
        }

        /* ---- CONTENT ---- */
        .content-area {
            padding: 28px 28px;
            flex: 1;
        }

        /* ---- CARD ---- */
        .card {
            border: none;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .07);
            border-radius: 10px;
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #f0f0f0;
            font-weight: 600;
        }

        /* ---- STAT CARDS ---- */
        .stat-card {
            border-radius: 12px;
            padding: 22px 24px;
            color: #fff;
        }

        .stat-card .stat-label {
            font-size: .78rem;
            opacity: .8;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .stat-card .stat-icon {
            font-size: 2.2rem;
            opacity: .25;
        }

        /* ---- TABLE ---- */
        .table th {
            font-size: .8rem;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #6c757d;
            border-top: none;
        }

        .table td {
            vertical-align: middle;
        }

        /* ---- BADGE ---- */
        .stock-ok {
            background: #d1fae5;
            color: #065f46;
        }

        .stock-low {
            background: #fee2e2;
            color: #991b1b;
        }

        /* ---- FOOTER ---- */
        .main-footer {
            padding: 14px 28px;
            font-size: .8rem;
            color: #aaa;
            border-top: 1px solid #e9ecef;
        }

        /* ---- ITEM THUMBNAIL ---- */
        .item-thumb {
            width: 44px;
            height: 44px;
            object-fit: cover;
            border-radius: 8px;
            background: #f0f0f0;
        }

        .item-thumb-placeholder {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #adb5bd;
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- SIDEBAR --}}
    <nav id="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-boxes me-2"></i> Inventory
        </div>
        <div class="sidebar-nav">
            <div class="nav-label">Menu</div>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('items.index') }}" class="{{ request()->routeIs('items.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i> Data Barang
            </a>
            <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> Kategori
            </a>
            <a href="{{ route('suppliers.index') }}" class="{{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                <i class="bi bi-truck"></i> Supplier
            </a>
            <a href="{{ route('excel.import') }}" class="{{ request()->routeIs('excel.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-excel"></i> Excel
            </a>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <div id="main-content">
        <header class="topbar">
            <span class="topbar-title">@yield('title', 'Dashboard')</span>
            <div class="topbar-user">
                <i class="bi bi-person-circle fs-5"></i>
                <span>{{ session('admin_full_name') }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger"
                        onclick="return confirm('Yakin ingin logout?')">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </header>

        <div class="content-area">
            {{-- Flash messages --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>

        <footer class="main-footer">
            &copy; {{ date('Y') }} Sistem Pengelolaan Barang — Laravel 12
        </footer>
    </div>

    {{-- Bootstrap 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
