<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">{{ $initiative->getLocalizedName() }}</h2>
            <a href="{{ route('student.initiatives.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>{{ __('messages.Back') }}
            </a>
        </div>
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
            <!-- Initiative Details -->
            <div class="col-md-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-info-circle me-2"></i>{{ __('messages.Initiative Details') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6 class="text-muted">{{ __('messages.Category') }}</h6>
                                <span class="badge bg-secondary">{{ $initiative->category->getLocalizedName() }}</span>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">{{ __('messages.Status') }}</h6>
                                @if($isEnrolled)
                                    <span class="badge bg-success">{{ __('messages.Enrolled') }}</span>
                                @else
                                    <span class="badge bg-warning">{{ __('messages.Not Enrolled') }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <h6 class="text-muted">{{ __('messages.Description') }}</h6>
                        <p class="mb-3">{{ $initiative->getLocalizedDescription() ?: __('messages.No description available') }}</p>
                        
                        @if($initiative->start_date || $initiative->end_date)
                            <div class="row">
                                @if($initiative->start_date)
                                    <div class="col-md-6">
                                        <h6 class="text-muted">{{ __('messages.Start Date') }}</h6>
                                        <p class="mb-3">
                                            <i class="bi bi-calendar-event me-1"></i>{{ $initiative->start_date->format('F j, Y') }}
                                        </p>
                                    </div>
                                @endif
                                @if($initiative->end_date)
                                    <div class="col-md-6">
                                        <h6 class="text-muted">{{ __('messages.End Date') }}</h6>
                                        <p class="mb-3">
                                            <i class="bi bi-calendar-x me-1"></i>{{ $initiative->end_date->format('F j, Y') }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if(!$isEnrolled)
                            <div class="mt-3">
                                <form action="{{ route('student.initiatives.enroll', $initiative) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-plus-circle me-1"></i>{{ __('messages.Enroll Now') }}
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Statistics -->
            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-bar-chart me-2"></i>{{ __('messages.Statistics') }}
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col-6">
                                <div class="border-end">
                                    <h3 class="text-primary mb-0">{{ $initiative->tasks->count() }}</h3>
                                    <small class="text-muted">{{ __('messages.Total Tasks') }}</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h3 class="text-warning mb-0">{{ $initiative->tasks->sum('points_value') }}</h3>
                                <small class="text-muted">{{ __('messages.Total Points') }}</small>
                            </div>
                        </div>
                        
                        @if($isEnrolled)
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <div class="border-end">
                                        <h4 class="text-success mb-0">{{ count($completedTasks) }}</h4>
                                        <small class="text-muted">{{ __('messages.Completed') }}</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-info mb-0">{{ $initiative->tasks->count() - count($completedTasks) }}</h4>
                                    <small class="text-muted">{{ __('messages.Remaining') }}</small>
                                </div>
                            </div>
                            
                            @php
                                $progress = $initiative->tasks->count() > 0 ? (count($completedTasks) / $initiative->tasks->count()) * 100 : 0;
                            @endphp
                            <div class="mt-3">
                                <div class="progress">
                                    <div class="progress-bar bg-success" style="width: {{ $progress }}%"></div>
                                </div>
                                <small class="text-muted">{{ round($progress) }}% {{ __('messages.Complete') }}</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks -->
        @if($isEnrolled)
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-list-task me-2"></i>{{ __('messages.Tasks') }} ({{ $initiative->tasks->count() }})
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($initiative->tasks->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($initiative->tasks as $task)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="badge bg-light text-dark me-2">{{ $task->order }}</span>
                                                <h6 class="mb-0 {{ in_array($task->id, $completedTasks) ? 'text-success text-decoration-line-through' : '' }}">
                                                    {{ $task->getLocalizedTitle() }}
                                                </h6>
                                                @if(in_array($task->id, $completedTasks))
                                                    <i class="bi bi-check-circle-fill text-success ms-2"></i>
                                                @endif
                                            </div>
                                            <p class="text-muted mb-2">{{ $task->getLocalizedDescription() }}</p>
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-warning me-2">
                                                    <i class="bi bi-star me-1"></i>{{ $task->points_value }} {{ __('messages.Points') }}
                                                </span>
                                                @if(in_array($task->id, $completedTasks))
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle me-1"></i>{{ __('messages.Completed') }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="bi bi-clock me-1"></i>{{ __('messages.Pending') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-list-task display-4 text-muted"></i>
                            <h6 class="mt-3">{{ __('messages.No tasks available') }}</h6>
                            <p class="text-muted">{{ __('messages.Tasks will be added soon') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-lock display-1 text-muted"></i>
                    <h4 class="mt-3">{{ __('messages.Enrollment Required') }}</h4>
                    <p class="text-muted mb-4">{{ __('messages.You need to enroll to view tasks') }}</p>
                    <form action="{{ route('student.initiatives.enroll', $initiative) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-plus-circle me-2"></i>{{ __('messages.Enroll Now') }}
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
