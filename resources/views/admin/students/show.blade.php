<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">{{ $student->name }}</h2>
            <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
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

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Student Info -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-person-circle me-2"></i>{{ __('messages.Student Information') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted">{{ __('messages.Full Name') }}</h6>
                                <p class="mb-3">{{ $student->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">{{ __('messages.Email Address') }}</h6>
                                <p class="mb-3">{{ $student->email }}</p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted">{{ __('messages.Registration Date') }}</h6>
                                <p class="mb-3">
                                    <i class="bi bi-calendar me-1"></i>{{ $student->created_at->format('F j, Y') }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">{{ __('messages.Account Status') }}</h6>
                                <span class="badge bg-success fs-6">
                                    <i class="bi bi-check-circle me-1"></i>{{ __('messages.Active') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-bar-chart me-2"></i>{{ __('messages.Performance') }}
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <h3 class="text-warning mb-0">{{ $student->total_points }}</h3>
                        <small class="text-muted">{{ __('messages.Total Points') }}</small>
                        
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <div class="border-end">
                                    <h5 class="text-primary mb-0">{{ $student->enrollments->count() }}</h5>
                                    <small class="text-muted">{{ __('messages.Enrollments') }}</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h5 class="text-success mb-0">{{ $student->completedTasks->count() }}</h5>
                                <small class="text-muted">{{ __('messages.Completed') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enrolled Initiatives -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clipboard-check me-2"></i>{{ __('messages.Enrolled Initiatives') }} ({{ $enrolledInitiatives->count() }})
                </h5>
            </div>
            <div class="card-body p-0">
                @if($enrolledInitiatives->count() > 0)
                    @foreach($enrolledInitiatives as $enrollment)
                        @php
                            $initiative = $enrollment->initiative;
                            $completedTasks = $student->completedTasks->whereIn('task_id', $initiative->tasks->pluck('id'));
                            $progress = $initiative->tasks->count() > 0 ? ($completedTasks->count() / $initiative->tasks->count()) * 100 : 0;
                        @endphp
                        <div class="border-bottom p-4">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h6 class="mb-1">{{ $initiative->getLocalizedName() }}</h6>
                                    <p class="text-muted mb-2">
                                        <i class="bi bi-tag me-1"></i>{{ $initiative->category->getLocalizedName() }}
                                    </p>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar me-1"></i>{{ __('messages.Enrolled') }}: {{ $enrollment->enrolled_at->format('M j, Y') }}
                                    </small>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <h6 class="mb-1">{{ __('messages.Progress') }}</h6>
                                        <div class="progress mb-2">
                                            <div class="progress-bar bg-success" style="width: {{ $progress }}%"></div>
                                        </div>
                                        <small class="text-muted">{{ $completedTasks->count() }}/{{ $initiative->tasks->count() }} {{ __('messages.Tasks') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="text-center">
                                        <h6 class="mb-1">{{ __('messages.Points') }}</h6>
                                        <span class="badge bg-warning fs-6">{{ $completedTasks->sum('points_awarded') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <a href="{{ route('admin.initiatives.show', $initiative) }}" 
                                       class="btn btn-outline-primary btn-sm" title="{{ __('messages.View Initiative') }}">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Tasks for this initiative -->
                            @if($initiative->tasks->count() > 0)
                                <div class="mt-3">
                                    <h6 class="text-muted mb-2">{{ __('messages.Tasks') }}:</h6>
                                    <div class="row">
                                        @foreach($initiative->tasks as $task)
                                            @php
                                                $isCompleted = $task->isCompletedBy($student->id);
                                                $completion = $task->getCompletionFor($student->id);
                                            @endphp
                                            <div class="col-md-6 mb-2">
                                                <div class="d-flex justify-content-between align-items-center p-2 border rounded {{ $isCompleted ? 'bg-success bg-opacity-10 border-success' : 'bg-light' }}">
                                                    <div>
                                                        <small class="fw-medium {{ $isCompleted ? 'text-success' : '' }}">
                                                            {{ $task->getLocalizedTitle() }}
                                                        </small>
                                                        <br>
                                                        <small class="text-muted">{{ $task->points_value }} {{ __('messages.Points') }}</small>
                                                    </div>
                                                    <div>
                                                        @if($isCompleted)
                                                            <span class="badge bg-success">
                                                                <i class="bi bi-check-circle me-1"></i>{{ $completion->points_awarded }}
                                                            </span>
                                                        @else
                                                            <button class="btn btn-outline-primary btn-sm" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#markCompleteModal{{ $task->id }}">
                                                                <i class="bi bi-check me-1"></i>{{ __('messages.Mark Complete') }}
                                                            </button>

                                                            <!-- Mark Complete Modal -->
                                                            <div class="modal fade" id="markCompleteModal{{ $task->id }}" tabindex="-1">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">{{ __('messages.Mark Task as Complete') }}</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                        </div>
                                                                        <form action="{{ route('admin.tasks.complete', [$task, $student]) }}" method="POST">
                                                                            @csrf
                                                                            <div class="modal-body">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">{{ __('messages.Task') }}</label>
                                                                                    <p class="form-control-plaintext">{{ $task->getLocalizedTitle() }}</p>
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="points_awarded" class="form-label">
                                                                                        {{ __('messages.Points to Award') }} <span class="text-danger">*</span>
                                                                                    </label>
                                                                                    <input type="number" class="form-control" 
                                                                                           name="points_awarded" 
                                                                                           value="{{ $task->points_value }}" 
                                                                                           min="1" max="{{ $task->points_value }}" required>
                                                                                    <small class="form-text text-muted">{{ __('messages.Maximum') }}: {{ $task->points_value }}</small>
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="notes" class="form-label">{{ __('messages.Notes') }}</label>
                                                                                    <textarea class="form-control" name="notes" rows="3" 
                                                                                              placeholder="{{ __('messages.Optional admin notes') }}"></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                                    {{ __('messages.Cancel') }}
                                                                                </button>
                                                                                <button type="submit" class="btn btn-success">
                                                                                    <i class="bi bi-check-circle me-1"></i>{{ __('messages.Mark Complete') }}
                                                                                </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-clipboard-x display-1 text-muted"></i>
                        <h5 class="mt-3">{{ __('messages.No enrollments found') }}</h5>
                        <p class="text-muted">{{ __('messages.This student has not enrolled in any initiatives yet') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
