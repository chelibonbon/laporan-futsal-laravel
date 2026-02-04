
@php
    $userLevel = auth()->user()->level ?? null;

    $userLevel = auth()->user()->level ?? null;

    $isInstructor = false;
    if ($userLevel == 2 && auth()->user()->guru) {
        $isInstructor = \App\Models\Ekskul::where(
            'instruktur_id',
            auth()->user()->guru->id
        )->exists();
    }


@endphp
<!doctype html>

<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="../assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
        
    <meta name="robots" content="noindex, nofollow" />

    <title>Dashboard - {{ $setting->judul ?? 'Home' }} </title>

<meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="" />

    <!-- Favicon -->
<link rel="icon" type="image/jpg" href="{{ asset('uploads/favicon.jpg') }}">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">



    <!-- Fonts -->

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="../assets/vendor/fonts/iconify-icons.css" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css -->

    <link rel="stylesheet" href="../assets/vendor/libs/node-waves/node-waves.css" />

    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- endbuild -->

    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->

    <script src="../assets/js/config.js"></script>
</head>

<body>
    <!-- jQuery + DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="index.html" class="app-brand-link">
                        <span class="app-brand-logo demo me-1">
                            <span class="text-primary">
                               <img src="{{ asset(!empty($setting->logo) ? 'uploads/' . $setting->logo : 'assets/img/logo-white.png') }}" alt="Logo Cafe" style="width: 50px; height: 50px; object-fit: cover;">

                            </span>
                        </span>
                        <span class="app-brand-text demo menu-text fw-semibold ms-2">{{ $setting->judul ?? 'Home' }}</span>
                    </a>

                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboards -->
      <ul class="menu-inner py-1">

    {{-- DASHBOARD --}}
    <li class="menu-item {{ request()->routeIs('home') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon ri ri-home-smile-line"></i>
            <div>Dashboard</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="menu-link">Home</a>
            </li>
        </ul>
    </li>

  {{-- DATA MASTER --}}
@if(in_array($userLevel, [1,2]))
<li class="menu-item {{ request()->routeIs(
    'users.*','guru.*','siswa.*','jurusan.*','rombel.*','kelas.*',
    'ekskul.*','jadwal.*'
) ? 'active open' : '' }}">

    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon ri ri-layout-2-line"></i>
        <div>Data Master</div>
    </a>

    <ul class="menu-sub">

        {{-- ADMIN (LEVEL 1) --}}
        @if($userLevel == 1)
            <li class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}" class="menu-link">User</a>
            </li>
            <li class="menu-item {{ request()->routeIs('guru.*') ? 'active' : '' }}">
                <a href="{{ route('guru.index') }}" class="menu-link">Guru</a>
            </li>
            <li class="menu-item {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                <a href="{{ route('siswa.index') }}" class="menu-link">Siswa</a>
            </li>
            <li class="menu-item {{ request()->routeIs('jurusan.*') ? 'active' : '' }}">
                <a href="{{ route('jurusan.index') }}" class="menu-link">Jurusan</a>
            </li>
            <li class="menu-item {{ request()->routeIs('rombel.*') ? 'active' : '' }}">
                <a href="{{ route('rombel.index') }}" class="menu-link">Rombel</a>
            </li>
            <li class="menu-item {{ request()->routeIs('kelas.*') ? 'active' : '' }}">
                <a href="{{ route('kelas.index') }}" class="menu-link">Kelas</a>
            </li>
            <li class="menu-item {{ request()->routeIs('ekskul.*') ? 'active' : '' }}">
                <a href="{{ route('ekskul.index') }}" class="menu-link">Ekskul</a>
            </li>
            <li class="menu-item {{ request()->routeIs('jadwal.*') ? 'active' : '' }}">
                <a href="{{ route('jadwal.index') }}" class="menu-link">Jadwal Ekskul</a>
            </li>
        @endif

        {{-- GURU NON INSTRUKTUR --}}
        @if($userLevel == 2 && !$isInstructor)
            <li class="menu-item {{ request()->routeIs('jurusan.*') ? 'active' : '' }}">
                <a href="{{ route('jurusan.index') }}" class="menu-link">Jurusan</a>
            </li>
            <li class="menu-item {{ request()->routeIs('rombel.*') ? 'active' : '' }}">
                <a href="{{ route('rombel.index') }}" class="menu-link">Rombel</a>
            </li>
            <li class="menu-item {{ request()->routeIs('kelas.*') ? 'active' : '' }}">
                <a href="{{ route('kelas.index') }}" class="menu-link">Kelas</a>
            </li>
        @endif

        {{-- GURU INSTRUKTUR --}}
        @if($userLevel == 2 && $isInstructor)
            <li class="menu-item {{ request()->routeIs('ekskul.*') ? 'active' : '' }}">
                <a href="{{ route('ekskul.index') }}" class="menu-link">Ekskul</a>
            </li>
            <li class="menu-item {{ request()->routeIs('jadwal.*') ? 'active' : '' }}">
                <a href="{{ route('jadwal.index') }}" class="menu-link">Jadwal Ekskul</a>
            </li>
        @endif

    </ul>
</li>
@endif


    {{-- DAFTAR --}}
    @if(in_array($userLevel, [1,3]))
    <li class="menu-item {{ request()->routeIs('daftar.ekskul.*') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon ri ri-list-check-2"></i>
            <div>Daftar</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ request()->routeIs('daftar.ekskul') ? 'active' : '' }}">
                <a href="{{ route('daftar.ekskul') }}" class="menu-link">
                    Daftar Ekskul
                </a>
            </li>
            @if(in_array($userLevel, [1,2]))
            <li class="menu-item {{ request()->routeIs('daftar.manage.*') ? 'active' : '' }}">
            <a href="{{ route('daftar.manage') }}" class="menu-link">
                Pendaftaran Ekskul
            </a>
        </li>
        @endif
    </ul>
</li>
@endif
   {{-- ABSENSI --}}
    @if(in_array($userLevel, [1,2]))
    <li class="menu-item {{ request()->routeIs('absensi.*') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon ri ri-list-check-2"></i>
            <div>Absensi</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ request()->routeIs('absensi.index.*') ? 'active' : '' }}">
                <a href="{{ route('absensi.index') }}" class="menu-link">
                    Absensi Ekskul
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('absensi.nilai.*') ? 'active' : '' }}">
                <a href="{{ route('absensi.nilai') }}" class="menu-link">
                    List Nilai
                </a>
            </li>
        </ul>
            <li class="menu-item {{ request()->routeIs('absensi.*') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon ri ri-list-check-2"></i>
            <div>List Ekskul</div>
        </a>
         <ul class="menu-sub">
            <li class="menu-item {{ request()->routeIs('absensi.jadwal.*') ? 'active' : '' }}">
                <a href="{{ route('absensi.jadwal') }}" class="menu-link">
                    Absensi dan Jadwal
                </a>
            </li>
    </ul>
</li>
@endif
    

</ul>



            </aside>
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                            <i class="icon-base ri ri-menu-line icon-md"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">


                        <ul class="navbar-nav flex-row align-items-center ms-md-auto">

                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="../assets/img/avatars/1.png" alt="alt"
                                            class="rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="../assets/img/avatars/1.png" alt="alt"
                                                            class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">John Doe</h6>
                                                    <small class="text-body-secondary">Admin</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider my-1"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="icon-base ri ri-user-line icon-md me-3"></i>
                                            <span>My Profile</span>
                                        </a>
                                    </li>

                                    </li>
                                    <li>
                                        <div class="dropdown-divider my-1"></div>
                                    </li>
                                    <li>
                                        <div class="d-grid px-4 pt-2 pb-1">

           <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button class="btn btn-danger"><i class="ri ri-logout-box-r-line ms-2 ri-xs"></i>Logout</button>
</form>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>
                <div class="content-wrapper" style="background: linear-gradient(to bottom, #6F8EEB, transparent), url('{{ asset('assets/img/backgrounds/dashboard.jpeg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">

                    @yield('content')

                </div>

                <!-- Footer -->
                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-xxl">
                        <div
                            class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                &#169;
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                , made by
                                <a href="https://themeselection.com" target="_blank"
                                    class="footer-link fw-medium">ThemeSelection</a>
                            </div>
                            <div class="d-none d-lg-inline-block">
                                <a href="https://themeselection.com/item/category/admin-templates/" target="_blank"
                                    class="footer-link me-4">Admin Templates</a>

                                <a href="https://themeselection.com/license/" class="footer-link me-4"
                                    target="_blank">License</a>

                                <a href="https://themeselection.com/item/category/bootstrap-templates/"
                                    target="_blank" class="footer-link me-4">Bootstrap Templates</a>
                                <a href="https://demos.themeselection.com/materio-bootstrap-html-admin-template/documentation/"
                                    target="_blank" class="footer-link me-4">Documentation</a>

                                <a href="https://github.com/themeselection/materio-bootstrap-html-admin-template-free/issues"
                                    target="_blank" class="footer-link">Support</a>
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

    <script src="../assets/vendor/libs/jquery/jquery.js"></script>

    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <!-- <script src="../assets/vendor/js/bootstrap.js"></script> -->
    <script src="../assets/vendor/libs/node-waves/node-waves.js"></script>

    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>
    <!-- Page JS -->
    <script src="../assets/js/dashboards-analytics.js"></script>
    <!-- Place this tag before closing body tag for github widget button. -->
    <script async="async" defer="defer" src="https://buttons.github.io/buttons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let timer;
    const timeoutMinutes = 20; // 20 minute
    const timeoutMillis = timeoutMinutes * 60 * 1000;

    function resetTimer() {
        clearTimeout(timer);
        timer = setTimeout(logoutUser, timeoutMillis);
    }
    function logoutUser() {
        // Call logout route via fetch or XMLHttpRequest
        fetch('/logout', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
        }).then(() => {
            // Redirect to login page
            window.location.href = '/login';
        });
    }
    // Listen to user events to reset timer
    window.onload = resetTimer;
    document.onmousemove = resetTimer;
    document.onkeypress = resetTimer;
    document.onclick = resetTimer;
    document.onscroll = resetTimer;
</script>
</body>
</html>