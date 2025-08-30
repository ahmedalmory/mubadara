<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">{{ __('messages.My Initiatives') }}</h2>
    </x-slot>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            @forelse($initiatives as $initiative)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-title mb-0">{{ $initiative->getLocalizedName() }}</h6>
                                @if(in_array($initiative->id, $enrolledInitiatives))
                                    <span class="badge bg-success">{{ __('messages.Enrolled') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="card-text text-muted small">
                                <i class="bi bi-tag me-1"></i>{{ $initiative->category->getLocalizedName() }}
                            </p>
                            <p class="card-text">{{ Str::limit($initiative->getLocalizedDescription(), 100) }}</p>
                            
                            <div class="row text-center mb-3">
                                <div class="col-6">
                                    <div class="border-end">
                                        <h6 class="mb-0">{{ $initiative->tasks_count ?? 0 }}</h6>
                                        <small class="text-muted">{{ __('messages.Tasks') }}</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h6 class="mb-0">{{ $initiative->total_points ?? 0 }}</h6>
                                    <small class="text-muted">{{ __('messages.Points') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('student.initiatives.show', $initiative) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye me-1"></i>{{ __('messages.View') }}
                                </a>
                                
                                @if(!in_array($initiative->id, $enrolledInitiatives))
                                    <form action="{{ route('student.initiatives.enroll', $initiative) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="bi bi-plus-circle me-1"></i>{{ __('messages.Enroll') }}
                                        </button>
                                    </form>
                                @else
                                    <span class="text-success">
                                        <i class="bi bi-check-circle me-1"></i>{{ __('messages.Enrolled') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="bi bi-clipboard-x display-1 text-muted"></i>
                        <h5 class="mt-3">{{ __('messages.No initiatives available') }}</h5>
                        <p class="text-muted">{{ __('messages.Check back later for new initiatives') }}</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if($initiatives->hasPages())
            <div class="d-flex justify-content-center">
                {{ $initiatives->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
