<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />

    <title>Login - {{ $pengaturan->judul ?? 'POS System' }}</title>

    <!-- Favicon -->
    @if($pengaturan->logo)
        <link rel="icon" type="image/jpg" href="{{ asset($pengaturan->logo) }}">
    @else
        <link rel="icon" type="image/jpg" href="{{ asset('uploads/favicon.jpg') }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:wght@400;600;700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="../assets/vendor/fonts/iconify-icons.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />
    <!-- CDN for Remix Icons (since referenced in script) -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <style>
      /* Custom Input Styles */
      .form-control {
        border: 1px solid #ced4da !important;
        border-radius: 10px !important;
        color: #495057 !important;
        padding-right: 40px; /* Space for eye icon */
      }
      
      .form-control:focus {
        border-color: #4370f5 !important;
        box-shadow: none !important;
        outline: none;
      }

      input::placeholder {
        color: #b0b0b0 !important;
      }

      .password-wrapper {
        position: relative;
      }

      .toggle-password {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
        z-index: 10;
      }
      
      .card {
         box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.1);
      }
    </style>

    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>
  </head>

  <body style="background: linear-gradient(to bottom, #ffffff 0%, rgba(255,255,255,0) 100%), url('{{ asset('assets/img/backgrounds/blue-bg.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="position-relative">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-6 mx-4">
          <!-- Changed background to white, text to dark -->
          <div class="card p-sm-7 p-2" style="background-color: rgba(244, 245, 255, 0.75); border-radius: 20px; backdrop-filter: blur(5px);">

            <div class="card-body mt-1">
              <!-- Logo and App Name -->
              <div class="text-center mb-4">
                @if($pengaturan->logo)
                  <img src="{{ asset($pengaturan->logo) }}" alt="Logo" style="height: 60px; width: 60px; object-fit: cover; border-radius: 12px; margin-bottom: 15px;">
                @endif
                <h3 class="text-dark">{{ $pengaturan->judul ?? 'POS System' }}</h3>
              </div>
              
              <h4 class="mb-4 text-center text-dark">LOGIN to {{ $pengaturan->judul ?? 'Home' }}</h4>
              <p class="mb-5 text-center text-muted">Please sign-in to your account and start the adventure</p>

              <!-- Laravel Login Form -->
              <form method="POST" action="{{ route('login') }}" class="mb-5">
                @csrf

                <div class="mb-4">
                  <label for="email" class="form-label text-dark">Email</label>
                  <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
                  @error('email') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                  <label for="password" class="form-label text-dark">Password</label>
                  <div class="password-wrapper">
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                    <i id="togglePassword" class="ri-eye-off-line toggle-password"></i>
                  </div>
                  @error('password') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4 d-flex justify-content-between align-items-center">
                  <div class="form-check mb-0">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember-me" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label text-muted" for="remember-me"> Remember Me </label>
                  </div>
                </div>

                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100 rounded-pill" type="submit" style="background-color: #7989ffff; border-color: #7989ffff;">Login</button>
                </div>
              </form>
                <div class="text-center">
    <span class="text-muted">Belum punya akun?</span>
    <a href="{{ route('register') }}" class="fw-semibold">
        Daftar di sini
    </a>
</div>
            </div>
          </div>

          <script>
            document.addEventListener('DOMContentLoaded', function () {
              const togglePassword = document.querySelector('#togglePassword');
              const passwordInput = document.querySelector('#password');

              if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function () {
                  const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                  passwordInput.setAttribute('type', type);
                  
                  // Toggle icon class
                  if (type === 'text') {
                    this.classList.remove('ri-eye-off-line');
                    this.classList.add('ri-eye-line');
                  } else {
                    this.classList.remove('ri-eye-line');
                    this.classList.add('ri-eye-off-line');
                  }
                });
              }
            });
          </script>

        </div>
      </div>
    </div>
  </body>
</html>
