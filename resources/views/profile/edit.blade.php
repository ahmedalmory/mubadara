<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">{{ __('messages.Profile') }}</h2>
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" 
                     style="width: 40px; height: 40px; font-size: 18px;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="fw-medium">{{ auth()->user()->name }}</div>
                    <small class="text-muted">
                        @if(auth()->user()->isAdmin())
                            <i class="bi bi-shield-check me-1"></i>{{ __('messages.Administrator') }}
                        @else
                            <i class="bi bi-person me-1"></i>{{ __('messages.Student') }}
                        @endif
                    </small>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="container">
        @if (session('status') === 'profile-updated')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ __('messages.Profile updated successfully') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('status') === 'password-updated')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ __('messages.Password updated successfully') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <!-- Profile Information -->
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-person-circle me-2"></i>{{ __('messages.Profile Information') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-4">{{ __('messages.Update your account profile information and email address') }}</p>
                        
                        <form method="post" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">{{ __('messages.Name') }}</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input id="name" name="name" type="text" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   value="{{ old('name', $user->name) }}" required autofocus>
                                        </div>
                                        @error('name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">{{ __('messages.Email') }}</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                            <input id="email" name="email" type="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   value="{{ old('email', $user->email) }}" required>
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div class="alert alert-warning" role="alert">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    {{ __('messages.Your email address is unverified') }}
                                    <button form="send-verification" class="btn btn-link p-0 text-decoration-underline">
                                        {{ __('messages.Click here to re-send the verification email') }}
                                    </button>
                                </div>

                                @if (session('status') === 'verification-link-sent')
                                    <div class="alert alert-success" role="alert">
                                        <i class="bi bi-check-circle me-2"></i>
                                        {{ __('messages.A new verification link has been sent to your email address') }}
                                    </div>
                                @endif
                            @endif

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>{{ __('messages.Save') }}
                                </button>
                            </div>
                        </form>

                        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                            @csrf
                        </form>
                    </div>
                </div>

                <!-- Update Password -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-warning text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-shield-lock me-2"></i>{{ __('messages.Update Password') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-4">{{ __('messages.Ensure your account is using a long, random password to stay secure') }}</p>
                        
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="card shadow-sm border-danger">
                    <div class="card-header bg-danger text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ __('messages.Delete Account') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-4">{{ __('messages.Once your account is deleted, all of its resources and data will be permanently deleted') }}</p>
                        
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

            <!-- User Stats Sidebar -->
            @if(auth()->user()->isStudent())
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-bar-chart me-2"></i>{{ __('messages.Your Stats') }}
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col-6">
                                <div class="border-end">
                                    <h3 class="text-primary mb-0">{{ auth()->user()->enrollments->count() }}</h3>
                                    <small class="text-muted">{{ __('messages.Enrollments') }}</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h3 class="text-success mb-0">{{ auth()->user()->completedTasks->count() }}</h3>
                                <small class="text-muted">{{ __('messages.Completed') }}</small>
                            </div>
                        </div>
                        
                        <hr>
                        <div class="text-center">
                            <h2 class="text-warning mb-0">{{ auth()->user()->total_points }}</h2>
                            <small class="text-muted">{{ __('messages.Total Points') }}</small>
                        </div>

                        @php
                            $userRank = \App\Models\User::where('role', 'student')
                                ->where('total_points', '>', auth()->user()->total_points)
                                ->count() + 1;
                        @endphp
                        
                        <div class="mt-3">
                            <span class="badge bg-warning fs-6">
                                <i class="bi bi-trophy me-1"></i>#{{ $userRank }} {{ __('messages.Rank') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-link-45deg me-2"></i>{{ __('messages.Quick Links') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('student.initiatives.index') }}" class="btn btn-outline-primary">
                                <i class="bi bi-clipboard-check me-2"></i>{{ __('messages.My Initiatives') }}
                            </a>
                            <a href="{{ route('student.rankings') }}" class="btn btn-outline-success">
                                <i class="bi bi-trophy me-2"></i>{{ __('messages.Rankings') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
