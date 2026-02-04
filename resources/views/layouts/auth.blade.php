<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('assets/') }}/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $pengaturan->judul ?? config('app.name') }} - @yield('title', 'Auth')</title>

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    
    <style>
      /* Custom Input Styles matched to login.blade.php */
      .form-control {
        border: 1px solid #ced4da !important;
        border-radius: 10px !important;
        color: #495057 !important;
        padding-right: 40px; 
      }
      
      .form-control:focus {
        border-color: #4370f5 !important;
        box-shadow: none !important;
        outline: none;
      }

      input::placeholder {
        color: #b0b0b0 !important;
      }

      .card {
         box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.1);
      }
    </style>
</head>

<body style="background: linear-gradient(to bottom, #ffffff 0%, rgba(255,255,255,0) 100%), url('{{ asset('assets/img/backgrounds/blue-bg.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <!-- Content -->
    <div class="position-relative">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-6 mx-4">
                <!-- Register Card -->
                <div class="card p-sm-7 p-2" style="background-color: rgba(244, 245, 255, 0.75); border-radius: 20px; backdrop-filter: blur(5px);">
                    <div class="card-body mt-1">
                        <!-- Logo -->
                        <div class="text-center mb-4">
                            @if(isset($pengaturan->logo) && $pengaturan->logo)
                                <img src="{{ asset($pengaturan->logo) }}" alt="Logo" style="height: 60px; width: 60px; object-fit: cover; border-radius: 12px; margin-bottom: 15px;">
                            @else
                                <img src="{{ asset('assets/img/logo-white.png') }}" alt="Logo" style="height: 60px; width: 60px; object-fit: cover; border-radius: 12px; margin-bottom: 15px;">
                            @endif
                            <h3 class="text-dark">{{ $pengaturan->judul ?? config('app.name') }}</h3>
                        </div>

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
                                <strong>Error!</strong>
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
                </div>
                <!-- Register Card -->
                <img src="{{ asset('assets/img/illustrations/tree-3.png') }}" alt="auth-tree" class="authentication-image-object-left d-none d-lg-block">
                <img src="{{ asset('assets/img/illustrations/auth-basic-mask-light.png') }}" class="authentication-image d-none d-lg-block" alt="triangle-bg">
                <img src="{{ asset('assets/img/illustrations/tree.png') }}" alt="auth-tree" class="authentication-image-object-right d-none d-lg-block">
            </div>
        </div>
    </div>
    <!-- / Content -->

    <!-- Core JS -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    @yield('scripts')
</body>
</html>
