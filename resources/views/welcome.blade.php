<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ __('messages.Mubadara') }} - {{ __('messages.Student Initiative Management System') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @if(app()->getLocale() == 'ar')
            <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        @endif

        <!-- Bootstrap CSS -->
        @if(app()->getLocale() == 'ar')
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
        @else
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        @endif
        
        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

        <style>
            body {
                font-family: {{ app()->getLocale() == 'ar' ? "'Cairo', sans-serif" : "'Figtree', sans-serif" }};
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
            }
            .hero-section {
                min-height: 100vh;
                display: flex;
                align-items: center;
            }
            .feature-card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                backdrop-filter: blur(10px);
                background: rgba(255, 255, 255, 0.95);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
            .feature-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            }
            .language-switcher {
                position: absolute;
                top: 20px;
                {{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 20px;
                z-index: 1000;
            }
            .hero-content {
                color: white;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            }
        </style>
    </head>
    <body>
        <!-- Language Switcher -->
        <div class="language-switcher">
            <div class="dropdown">
                <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-globe"></i>
                    {{ app()->getLocale() == 'ar' ? 'العربية' : 'English' }}
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">English</a></li>
                    <li><a class="dropdown-item" href="{{ route('lang.switch', 'ar') }}">العربية</a></li>
                </ul>
            </div>
        </div>

        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="hero-content">
                            <h1 class="display-4 fw-bold mb-4">
                                <i class="bi bi-lightbulb-fill text-warning me-3"></i>
                                {{ __('messages.Mubadara') }}
                            </h1>
                            <h2 class="h4 mb-4 opacity-90">{{ __('messages.Student Initiative Management System') }}</h2>
                            <p class="lead mb-5">
                                @if(app()->getLocale() == 'ar')
                                    منصة شاملة لإدارة مبادرات الطلاب وتتبع الإنجازات وتحفيز التفوق الأكاديمي والمجتمعي
                                @else
                                    A comprehensive platform for managing student initiatives, tracking achievements, and fostering academic and community excellence
                                @endif
                            </p>
                            
                            @if (Route::has('login'))
                                <div class="d-flex gap-3 mb-5">
                                    @auth
                                        <a href="{{ url('/dashboard') }}" class="btn btn-warning btn-lg px-4">
                                            <i class="bi bi-house-door me-2"></i>{{ __('messages.Dashboard') }}
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-light btn-lg px-4">
                                            <i class="bi bi-box-arrow-in-right me-2"></i>{{ __('messages.Login') }}
                                        </a>
                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">
                                                <i class="bi bi-person-plus me-2"></i>{{ __('messages.Register') }}
                                            </a>
                                        @endif
                                    @endauth
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="text-center">
                            <i class="bi bi-trophy-fill text-warning" style="font-size: 15rem; opacity: 0.8;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-5" style="background: rgba(255, 255, 255, 0.1);">
            <div class="container">
                <div class="row text-center mb-5">
                    <div class="col-12">
                        <h2 class="text-white display-6 fw-bold">
                            @if(app()->getLocale() == 'ar')
                                المميزات الرئيسية
                            @else
                                Key Features
                            @endif
                        </h2>
                    </div>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="card feature-card h-100 border-0 rounded-4">
                            <div class="card-body text-center p-4">
                                <i class="bi bi-people-fill text-primary mb-3" style="font-size: 3rem;"></i>
                                <h5 class="card-title">
                                    @if(app()->getLocale() == 'ar')
                                        للطلاب
                                    @else
                                        For Students
                                    @endif
                                </h5>
                                <p class="card-text text-muted">
                                    @if(app()->getLocale() == 'ar')
                                        انضم للمبادرات، أكمل المهام، واكسب النقاط لتصبح من المتصدرين
                                    @else
                                        Join initiatives, complete tasks, and earn points to become a top performer
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-3">
                        <div class="card feature-card h-100 border-0 rounded-4">
                            <div class="card-body text-center p-4">
                                <i class="bi bi-gear-fill text-warning mb-3" style="font-size: 3rem;"></i>
                                <h5 class="card-title">
                                    @if(app()->getLocale() == 'ar')
                                        للمديرين
                                    @else
                                        For Administrators
                                    @endif
                                </h5>
                                <p class="card-text text-muted">
                                    @if(app()->getLocale() == 'ar')
                                        أنشئ المبادرات، أضف المهام، وتابع تقدم الطلاب بسهولة
                                    @else
                                        Create initiatives, add tasks, and track student progress effortlessly
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-3">
                        <div class="card feature-card h-100 border-0 rounded-4">
                            <div class="card-body text-center p-4">
                                <i class="bi bi-award text-success mb-3" style="font-size: 3rem;"></i>
                                <h5 class="card-title">
                                    @if(app()->getLocale() == 'ar')
                                        نظام التحفيز
                                    @else
                                        Motivation System
                                    @endif
                                </h5>
                                <p class="card-text text-muted">
                                    @if(app()->getLocale() == 'ar')
                                        نظام نقاط وترتيب تنافسي يحفز الطلاب على المشاركة والإنجاز
                                    @else
                                        Competitive points and ranking system that motivates student participation
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-3">
                        <div class="card feature-card h-100 border-0 rounded-4">
                            <div class="card-body text-center p-4">
                                <i class="bi bi-graph-up text-info mb-3" style="font-size: 3rem;"></i>
                                <h5 class="card-title">
                                    @if(app()->getLocale() == 'ar')
                                        تتبع التقدم
                                    @else
                                        Progress Tracking
                                    @endif
                                </h5>
                                <p class="card-text text-muted">
                                    @if(app()->getLocale() == 'ar')
                                        تتبع مفصل لتقدم كل طالب وإنجازاته في المبادرات المختلفة
                                    @else
                                        Detailed tracking of each student's progress and achievements across initiatives
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <!-- Footer -->
        <footer class="py-4 text-center text-white-50">
            <div class="container">
                <p class="mb-0">
                    &copy; {{ date('Y') }} {{ __('messages.Mubadara') }} - 
                    @if(app()->getLocale() == 'ar')
                        نظام إدارة مبادرات الطلاب
                    @else
                        Student Initiative Management System
                    @endif
                </p>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
