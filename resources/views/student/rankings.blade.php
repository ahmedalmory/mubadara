<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">{{ __('messages.Leaderboard') }}</h2>
    </x-slot>

    <div class="container">
        <!-- Current User Stats -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <div class="rounded-circle bg-white text-primary d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 60px; height: 60px; font-size: 24px; font-weight: bold;">
                            {{ strtoupper(substr($currentUser->name, 0, 1)) }}
                        </div>
                        <h5 class="mb-1">{{ $currentUser->name }}</h5>
                        <p class="mb-0 opacity-75">{{ __('messages.Your Stats') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end border-white border-opacity-25">
                                    <h3 class="mb-0">#{{ $userRank }}</h3>
                                    <small>{{ __('messages.Your Rank') }}</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h3 class="mb-0">{{ $currentUser->total_points }}</h3>
                                <small>{{ __('messages.Your Points') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leaderboard -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-trophy me-2"></i>{{ __('messages.Top Students') }}
                </h5>
            </div>
            <div class="card-body p-0">
                @if($topStudents->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="80">{{ __('messages.Rank') }}</th>
                                    <th>{{ __('messages.Student Name') }}</th>
                                    <th>{{ __('messages.Initiatives') }}</th>
                                    <th>{{ __('messages.Completed Tasks') }}</th>
                                    <th>{{ __('messages.Total Points') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topStudents as $index => $student)
                                    <tr class="{{ $student->id == $currentUser->id ? 'table-primary' : '' }}">
                                        <td>
                                            @if($index < 3)
                                                @if($index == 0)
                                                    <span class="badge bg-warning fs-6">
                                                        <i class="bi bi-trophy-fill"></i> #{{ $index + 1 }}
                                                    </span>
                                                @elseif($index == 1)
                                                    <span class="badge bg-secondary fs-6">
                                                        <i class="bi bi-award-fill"></i> #{{ $index + 1 }}
                                                    </span>
                                                @else
                                                    <span class="badge fs-6" style="background-color: #cd7f32; color: white;">
                                                        <i class="bi bi-award"></i> #{{ $index + 1 }}
                                                    </span>
                                                @endif
                                            @else
                                                <span class="badge bg-light text-dark">#{{ $index + 1 }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" 
                                                     style="width: 32px; height: 32px; font-size: 14px;">
                                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                                </div>
                                                <span class="fw-medium {{ $student->id == $currentUser->id ? 'text-primary' : '' }}">
                                                    {{ $student->name }}
                                                    @if($student->id == $currentUser->id)
                                                        <small class="text-primary">({{ __('messages.You') }})</small>
                                                    @endif
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $student->enrollments_count }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">{{ $student->completed_tasks_count }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning fs-6">{{ $student->total_points }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-trophy display-1 text-muted"></i>
                        <h5 class="mt-3">{{ __('messages.No rankings available') }}</h5>
                        <p class="text-muted">{{ __('messages.Complete tasks to appear on the leaderboard') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
