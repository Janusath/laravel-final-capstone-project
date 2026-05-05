<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=0"
    />
    <title>Preskool - Forgot Password</title>

    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" />

    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap"
      rel="stylesheet"
    />

    <link
      rel="stylesheet"
      href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}"
    />

    <link rel="stylesheet" href="{{ asset('assets/plugins/feather/feather.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/icons/flags/flags.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
  </head>
  <body>
    <div class="main-wrapper login-body">
      <div class="login-wrapper">
        <div class="container">
          <div class="loginbox">
            <div class="login-left">
              <img class="img-fluid" src="{{ asset('assets/img/login.png') }}" alt="Logo" />
            </div>
            <div class="login-right">
              <div class="login-right-wrap">
                <h1>Reset Password</h1>
                <p class="account-subtitle">Let Us Help You</p>

                <form method="POST" action="{{ route('password.email') }}">
                  @csrf

                  @if (session('status'))
                    <div class="alert alert-success" role="alert">
                      {{ session('status') }}
                    </div>
                  @endif

                  <div class="form-group">
                    <label>Enter your registered email address <span class="login-danger">*</span></label>
                    <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus />
                    <span class="profile-views"><i class="fas fa-envelope"></i></span>
                    @error('email')
                      <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                  </div>

                  <div class="form-group">
                    <button class="btn btn-primary btn-block" type="submit">
                      Reset My Password
                    </button>
                  </div>

                  <div class="form-group mb-0">
                    <a href="{{ route('login') }}" class="btn btn-primary primary-reset btn-block">
                      Back to Login
                    </a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>



<!-- <x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> -->
