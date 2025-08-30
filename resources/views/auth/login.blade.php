<x-guest-layout>
    <div class="text-center mb-4">
        <h4 class="fw-bold text-primary">{{ __('messages.Login') }}</h4>
        <p class="text-muted">{{ __('messages.Welcome back to Mubadara') }}</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('messages.Email') }}</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                       name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            </div>
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">{{ __('messages.Password') }}</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                       name="password" required autocomplete="current-password">
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                <label class="form-check-label" for="remember_me">
                    {{ __('messages.Remember Me') }}
                </label>
            </div>
        </div>

        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-box-arrow-in-right me-2"></i>{{ __('messages.Login') }}
            </button>
        </div>

        <div class="text-center">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-decoration-none">
                    {{ __('messages.Forgot Password') }}?
                </a>
            @endif
        </div>

        @if (Route::has('register'))
            <hr>
            <div class="text-center">
                <p class="mb-0">{{ __('messages.Don\'t have an account?') }}</p>
                <a href="{{ route('register') }}" class="btn btn-outline-primary">
                    <i class="bi bi-person-plus me-2"></i>{{ __('messages.Register') }}
                </a>
            </div>
        @endif
    </form>
</x-guest-layout>
