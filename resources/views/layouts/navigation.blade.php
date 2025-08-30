<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand fw-bold text-primary" href="{{ route('dashboard') }}">
            <i class="bi bi-lightbulb-fill me-2"></i>{{ __('messages.Mubadara') }}
        </a>

        <!-- Toggle button for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Navigation Links -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-house-door me-1"></i>{{ __('messages.Dashboard') }}
                    </a>
                </li>
                
                @if(auth()->check() && auth()->user()->role === 'admin')
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-gear me-1"></i>{{ __('messages.Admin Panel') }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}">
                            <i class="bi bi-tags me-2"></i>{{ __('messages.Categories') }}
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.initiatives.index') }}">
                            <i class="bi bi-clipboard-check me-2"></i>{{ __('messages.Initiatives') }}
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.students.index') }}">
                            <i class="bi bi-people me-2"></i>{{ __('messages.Students') }}
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.rankings') }}">
                            <i class="bi bi-trophy me-2"></i>{{ __('messages.Rankings') }}
                        </a></li>
                    </ul>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('student.initiatives*') ? 'active' : '' }}" href="{{ route('student.initiatives.index') }}">
                        <i class="bi bi-clipboard-check me-1"></i>{{ __('messages.My Initiatives') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('student.rankings') ? 'active' : '' }}" href="{{ route('student.rankings') }}">
                        <i class="bi bi-trophy me-1"></i>{{ __('messages.Rankings') }}
                    </a>
                </li>
                @endif
            </ul>

            <!-- Right Side Navigation -->
            <ul class="navbar-nav">
                <!-- Language Switcher -->
                <li class="nav-item dropdown language-switcher me-3">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-globe"></i>
                        <span class="d-none d-md-inline ms-1">
                            {{ app()->getLocale() == 'ar' ? 'العربية' : 'English' }}
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">
                            <i class="bi bi-flag me-2"></i>English
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('lang.switch', 'ar') }}">
                            <i class="bi bi-flag me-2"></i>العربية
                        </a></li>
                    </ul>
                </li>

                <!-- User Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 14px;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person me-2"></i>{{ __('messages.Profile') }}
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>{{ __('messages.Log Out') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
