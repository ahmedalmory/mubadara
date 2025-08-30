<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">{{ $initiative->getLocalizedName() }}</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.initiatives.tasks.create', $initiative) }}" class="btn btn-success btn-sm">
                    <i class="bi bi-plus-circle me-1"></i>{{ __('messages.Add Task') }}
                </a>
                <a href="{{ route('admin.initiatives.edit', $initiative) }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-pencil me-1"></i>{{ __('messages.Edit') }}
                </a>
                <a href="{{ route('admin.initiatives.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>{{ __('messages.Back') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container">
        <!-- Initiative Details -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-info-circle me-2"></i>{{ __('messages.Initiative Details') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted">{{ __('messages.Category') }}</h6>
                                <p class="mb-3">
                                    <span class="badge bg-secondary">{{ $initiative->category->getLocalizedName() }}</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">{{ __('messages.Status') }}</h6>
                                <p class="mb-3">
                                    @if($initiative->is_active)
                                        <span class="badge bg-success">{{ __('messages.Active') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ __('messages.Inactive') }}</span>
                                    @endif
                                </p>
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
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-bar-chart me-2"></i>{{ __('messages.Statistics') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <h3 class="text-primary mb-0">{{ $initiative->tasks->count() }}</h3>
                                    <small class="text-muted">{{ __('messages.Tasks') }}</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h3 class="text-success mb-0">{{ $initiative->enrollments->count() }}</h3>
                                <small class="text-muted">{{ __('messages.Enrolled Students') }}</small>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <h4 class="text-warning mb-0">{{ $initiative->tasks->sum('points_value') }}</h4>
                            <small class="text-muted">{{ __('messages.Total Points') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bi bi-list-task me-2"></i>{{ __('messages.Tasks') }} ({{ $initiative->tasks->count() }})
                </h5>
                <a href="{{ route('admin.initiatives.tasks.create', $initiative) }}" class="btn btn-success btn-sm">
                    <i class="bi bi-plus-circle me-1"></i>{{ __('messages.Add Task') }}
                </a>
            </div>
            <div class="card-body p-0">
                @if($initiative->tasks->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('messages.Order') }}</th>
                                    <th>{{ __('messages.Task Name') }}</th>
                                    <th>{{ __('messages.Points') }}</th>
                                    <th>{{ __('messages.Status') }}</th>
                                    <th>{{ __('messages.Completed') }}</th>
                                    <th width="150">{{ __('messages.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($initiative->tasks as $task)
                                    <tr>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $task->order }}</span>
                                        </td>
                                        <td>
                                            <div class="fw-medium">{{ $task->getLocalizedTitle() }}</div>
                                            <small class="text-muted">{{ Str::limit($task->getLocalizedDescription(), 50) }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">{{ $task->points_value }}</span>
                                        </td>
                                        <td>
                                            @if($task->status == 'active')
                                                <span class="badge bg-success">{{ __('messages.Active') }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ __('messages.Inactive') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $task->completions->count() }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.initiatives.tasks.edit', [$initiative, $task]) }}" 
                                                   class="btn btn-outline-success" title="{{ __('messages.Edit') }}">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.initiatives.tasks.destroy', [$initiative, $task]) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" 
                                                            title="{{ __('messages.Delete') }}"
                                                            onclick="return confirm('{{ __('messages.Are you sure?') }}')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-list-task display-4 text-muted"></i>
                        <h6 class="mt-3">{{ __('messages.No tasks available') }}</h6>
                        <p class="text-muted">{{ __('messages.Add tasks to this initiative') }}</p>
                        <a href="{{ route('admin.initiatives.tasks.create', $initiative) }}" class="btn btn-success">
                            <i class="bi bi-plus-circle me-1"></i>{{ __('messages.Add Task') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Enrolled Students -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-people me-2"></i>{{ __('messages.Enrolled Students') }} ({{ $initiative->enrollments->count() }})
                </h5>
            </div>
            <div class="card-body p-0">
                @if($initiative->enrollments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('messages.Student Name') }}</th>
                                    <th>{{ __('messages.Email') }}</th>
                                    <th>{{ __('messages.Enrolled Date') }}</th>
                                    <th>{{ __('messages.Completed Tasks') }}</th>
                                    <th>{{ __('messages.Points Earned') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($initiative->enrollments as $enrollment)
                                    @php
                                        $completedTasks = $enrollment->user->completedTasks()
                                            ->whereIn('task_id', $initiative->tasks->pluck('id'))
                                            ->count();
                                        $pointsEarned = $enrollment->user->completedTasks()
                                            ->whereIn('task_id', $initiative->tasks->pluck('id'))
                                            ->sum('points_awarded');
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" 
                                                     style="width: 32px; height: 32px; font-size: 14px;">
                                                    {{ strtoupper(substr($enrollment->user->name, 0, 1)) }}
                                                </div>
                                                {{ $enrollment->user->name }}
                                            </div>
                                        </td>
                                        <td>{{ $enrollment->user->email }}</td>
                                        <td>{{ $enrollment->enrolled_at->format('M j, Y') }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $completedTasks }}/{{ $initiative->tasks->count() }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">{{ $pointsEarned }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-people display-4 text-muted"></i>
                        <h6 class="mt-3">{{ __('messages.No enrolled students') }}</h6>
                        <p class="text-muted">{{ __('messages.Students will appear here when they enroll') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
