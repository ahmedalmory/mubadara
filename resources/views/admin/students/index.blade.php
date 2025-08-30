<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">{{ __('messages.Students') }}</h2>
    </x-slot>

    <div class="container">
        <!-- Search -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.students.index') }}">
                    <div class="row align-items-end">
                        <div class="col-md-8">
                            <label for="search" class="form-label">{{ __('messages.Search Students') }}</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="{{ __('messages.Search by name or email') }}">
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search me-1"></i>{{ __('messages.Search') }}
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary">
                                        {{ __('messages.Clear') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Students List -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">{{ __('messages.Students') }} ({{ $students->total() }})</h5>
            </div>
            <div class="card-body p-0">
                @if($students->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('messages.Rank') }}</th>
                                    <th>{{ __('messages.Student Name') }}</th>
                                    <th>{{ __('messages.Email') }}</th>
                                    <th>{{ __('messages.Enrollments') }}</th>
                                    <th>{{ __('messages.Completed Tasks') }}</th>
                                    <th>{{ __('messages.Total Points') }}</th>
                                    <th width="100">{{ __('messages.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $index => $student)
                                    <tr>
                                        <td>
                                            @php
                                                $rank = ($students->currentPage() - 1) * $students->perPage() + $index + 1;
                                            @endphp
                                            @if($rank <= 3 && !request('search'))
                                                @if($rank == 1)
                                                    <span class="badge bg-warning fs-6">
                                                        <i class="bi bi-trophy-fill"></i> #{{ $rank }}
                                                    </span>
                                                @elseif($rank == 2)
                                                    <span class="badge bg-secondary fs-6">
                                                        <i class="bi bi-award-fill"></i> #{{ $rank }}
                                                    </span>
                                                @else
                                                    <span class="badge fs-6" style="background-color: #cd7f32; color: white;">
                                                        <i class="bi bi-award"></i> #{{ $rank }}
                                                    </span>
                                                @endif
                                            @else
                                                <span class="badge bg-light text-dark">#{{ $rank }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" 
                                                     style="width: 32px; height: 32px; font-size: 14px;">
                                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                                </div>
                                                <span class="fw-medium">{{ $student->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $student->email }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $student->enrollments_count }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">{{ $student->completed_tasks_count }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">{{ $student->total_points }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.students.show', $student) }}" 
                                               class="btn btn-outline-primary btn-sm" title="{{ __('messages.View') }}">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-people display-1 text-muted"></i>
                        <h5 class="mt-3">{{ __('messages.No students found') }}</h5>
                        @if(request('search'))
                            <p class="text-muted">{{ __('messages.Try a different search term') }}</p>
                        @else
                            <p class="text-muted">{{ __('messages.Students will appear here when they register') }}</p>
                        @endif
                    </div>
                @endif
            </div>
            
            @if($students->hasPages())
                <div class="card-footer bg-white">
                    {{ $students->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
