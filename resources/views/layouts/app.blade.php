@php
// Helper functions from original app.blade.php
if (!function_exists('formatRupiah')) {
    function formatRupiah($amount) {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('getStatusBadge')) {
    function getStatusBadge($status) {
        $badges = [
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'confirmed' => '<span class="badge bg-success">Confirmed</span>',
            'rejected' => '<span class="badge bg-danger">Rejected</span>',
            'completed' => '<span class="badge bg-info">Completed</span>',
            'cancelled' => '<span class="badge bg-secondary">Cancelled</span>',
            'aktif' => '<span class="badge bg-success">Aktif</span>',
            'tidak_aktif' => '<span class="badge bg-danger">Tidak Aktif</span>',
            'verified' => '<span class="badge bg-success">Verified</span>',
        ];
        
        return $badges[$status] ?? '<span class="badge bg-secondary">' . ucfirst($status) . '</span>';
    }
}

if (!function_exists('getPaymentBadgeHtml')) {
    function getPaymentBadgeHtml($status) {
        $badges = [
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'verified' => '<span class="badge bg-success">Verified</span>',
            'rejected' => '<span class="badge bg-danger">Rejected</span>'
        ];
        
        return $badges[$status] ?? '<span class="badge bg-secondary">' . ucfirst($status) . '</span>';
    }
}
@endphp

<!DOCTYPE html>
<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="{{ asset('assets/') }}/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $pengaturan->judul ?? config('app.name') }} - @yield('title', 'Dashboard')</title>

    <!-- Favicon -->
    @if(isset($pengaturan->logo) && $pengaturan->logo)
        <link rel="icon" type="image/jpg" href="{{ asset($pengaturan->logo) }}">
    @else
        <link rel="icon" type="image/jpg" href="{{ asset('uploads/favicon.jpg') }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/iconify-icons.css') }}" />
    <!-- Font Awesome 6 (From old layout) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    
    <!-- Select2 CSS (From old layout) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    
    <style>
        /* Preserve some styles if needed */
        .sidebar .nav-link.active {
            /* Adjust active state if needed to match new template */
        }
        /* Fix for Select2 in Bootstrap 5 if needed */
        .select2-container .select2-selection--single {
            height: 38px;
            border: 1px solid #dee2e6;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
    </style>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="{{ url('/') }}" class="app-brand-link">
                        <span class="app-brand-logo demo me-1">
                            @if(isset($pengaturan->logo) && $pengaturan->logo)
                                <img src="{{ asset($pengaturan->logo) }}" alt="Logo" style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <img src="{{ asset('assets/img/logo-white.png') }}" alt="Logo" style="width: 40px; height: 40px; object-fit: cover;">
                            @endif
                        </span>
                        <span class="app-brand-text demo menu-text fw-semibold ms-2">{{ $pengaturan->judul ?? config('app.name') }}</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="ri-menu-fold-line d-block d-xl-none"></i>
                        <i class="ri-arrow-left-s-line d-none d-xl-block ps-2"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" class="menu-link">
                            <i class="menu-icon tf-icons fas fa-tachometer-alt"></i>
                            <div data-i18n="Dashboard">Dashboard</div>
                        </a>
                    </li>

                    <!-- Bookings -->
                    <li class="menu-item {{ request()->routeIs('bookings.*') ? 'active' : '' }}">
                        <a href="{{ route('bookings.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons fas fa-calendar"></i>
                            <div data-i18n="Bookings">
                                @if(Auth::user()->isCustomer())
                                    Booking Saya
                                @elseif(Auth::user()->isManager())
                                    Konfirmasi Booking
                                @else
                                    Semua Booking
                                @endif
                            </div>
                        </a>
                    </li>

                    <!-- Lapangans -->
                    <li class="menu-item {{ request()->routeIs('lapangans.*') ? 'active' : '' }}">
                        <a href="{{ route('lapangans.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons fas fa-map"></i>
                            <div data-i18n="Lapangans">
                                @if(Auth::user()->isCustomer())
                                    Cari Lapangan
                                @else
                                    Kelola Lapangan
                                @endif
                            </div>
                        </a>
                    </li>

                    <!-- Users - hanya admin dan superadmin -->
                    @if(Auth::user()->isAdmin() || Auth::user()->isSuperAdmin())
                        <li class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <a href="{{ route('users.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons fas fa-users"></i>
                                <div data-i18n="Users">Kelola User</div>
                            </a>
                        </li>
                    @endif

                    <!-- Keuangan - manager dan admin -->
                    @if(Auth::user()->isManager() || Auth::user()->isAdmin())
                        <li class="menu-item {{ request()->routeIs('keuangan.*') ? 'active' : '' }}">
                            <a href="{{ route('keuangan.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons fas fa-money-bill-wave"></i>
                                <div data-i18n="Keuangan">Keuangan</div>
                            </a>
                        </li>
                    @endif

                    <!-- Settings - hanya superadmin -->
                    @if(Auth::user()->isSuperAdmin())
                        <li class="menu-header mt-5">
                            <span class="menu-header-text">Settings</span>
                        </li>
                        <li class="menu-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                            <a href="{{ route('settings.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons fas fa-cog"></i>
                                <div data-i18n="Web Setting">Web Setting</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('hakakses.*') ? 'active' : '' }}">
                            <a href="{{ route('users.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons fas fa-user-shield"></i>
                                <div data-i18n="Hak Akses">Hak Akses</div>
                            </a>
                        </li>
                    @endif

                    <!-- Activity Log -->
                    <li class="menu-item {{ request()->routeIs('activities.*') ? 'active' : '' }}">
                        <a href="{{ route('activities.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons fas fa-history"></i>
                            <div data-i18n="Log Activity">Log Activity</div>
                        </a>
                    </li>
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="ri-menu-line ri-24px"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center">
                                <i class="ri-search-line ri-22px me-2"></i>
                                <input type="text" class="form-control border-0 shadow-none" placeholder="Search..." aria-label="Search..." />
                            </div>
                        </div>
                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block">{{ Auth::user()->name ?? 'User' }}</span>
                                                    <small class="text-muted">{{ ucfirst(Auth::user()->role ?? 'Guest') }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="ri-user-line me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="ri-logout-box-r-line me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper" style="background: linear-gradient(to bottom, #6F8EEB, transparent), url('{{ asset('assets/img/backgrounds/dashboard.jpeg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <!-- Flash Messages -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> Silakan periksa kembali input Anda.
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div class="footer-container d-flex align-items-center justify-content-between py-3 flex-md-row flex-column">
                                <div class="mb-2 mb-md-0">
                                    © <script>document.write(new Date().getFullYear());</script>, made with ❤️ by {{ config('app.name') }}
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    
    <!-- Helper Scripts -->
    <script>
        // Format number to Rupiah
        function formatRupiah(amount) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
        }
        
        // Get status badge HTML
        function getStatusBadgeHtml(status) {
            const badges = {
                'pending': '<span class="badge bg-warning">Pending</span>',
                'confirmed': '<span class="badge bg-success">Confirmed</span>',
                'rejected': '<span class="badge bg-danger">Rejected</span>',
                'completed': '<span class="badge bg-info">Completed</span>',
                'cancelled': '<span class="badge bg-secondary">Cancelled</span>',
                'aktif': '<span class="badge bg-success">Aktif</span>',
                'tidak_aktif': '<span class="badge bg-danger">Tidak Aktif</span>',
                'verified': '<span class="badge bg-success">Verified</span>',
            };
            
            return badges[status] || '<span class="badge bg-secondary">' + status.charAt(0).toUpperCase() + status.slice(1) + '</span>';
        }
        
        // Get payment badge HTML
        function getPaymentBadgeHtml(status) {
            const badges = {
                'pending': '<span class="badge bg-warning">Pending</span>',
                'verified': '<span class="badge bg-success">Verified</span>',
                'rejected': '<span class="badge bg-danger">Rejected</span>'
            };
            
            return badges[status] || '<span class="badge bg-secondary">' + status.charAt(0).toUpperCase() + status.slice(1) + '</span>';
        }
    </script>

    @yield('scripts')
</body>
</html>
