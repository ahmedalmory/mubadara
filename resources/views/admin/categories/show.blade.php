<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">{{ $category->getLocalizedName() }}</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-pencil me-1"></i>{{ __('messages.Edit') }}
                </a>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>{{ __('messages.Back') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container">
        <!-- Category Details -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-info-circle me-2"></i>{{ __('messages.Category Details') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6 class="text-muted">{{ __('messages.Name') }} (English)</h6>
                                <p class="mb-0">{{ $category->name['en'] ?? __('messages.Not available') }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">{{ __('messages.Name') }} (العربية)</h6>
                                <p class="mb-0">{{ $category->name['ar'] ?? __('messages.Not available') }}</p>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6 class="text-muted">{{ __('messages.Description') }} (English)</h6>
                                <p class="mb-0">{{ $category->description['en'] ?? __('messages.No description available') }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">{{ __('messages.Description') }} (العربية)</h6>
                                <p class="mb-0">{{ $category->description['ar'] ?? __('messages.No description available') }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted">{{ __('messages.Status') }}</h6>
                                @if($category->is_active)
                                    <span class="badge bg-success fs-6">
                                        <i class="bi bi-check-circle me-1"></i>{{ __('messages.Active') }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary fs-6">
                                        <i class="bi bi-x-circle me-1"></i>{{ __('messages.Inactive') }}
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">{{ __('messages.Created') }}</h6>
                                <p class="mb-0">
                                    <i class="bi bi-calendar me-1"></i>{{ $category->created_at->format('F j, Y') }}
                                </p>
                            </div>
                        </div>
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
                    <div class="card-body text-center">
                        <h3 class="text-primary mb-0">{{ $category->initiatives->count() }}</h3>
                        <small class="text-muted">{{ __('messages.Total Initiatives') }}</small>
                        
                        @php
                            $activeInitiatives = $category->initiatives->where('is_active', true)->count();
                            $totalTasks = $category->initiatives->sum(function($initiative) {
                                return $initiative->tasks->count();
                            });
                        @endphp
                        
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <div class="border-end">
                                    <h5 class="text-success mb-0">{{ $activeInitiatives }}</h5>
                                    <small class="text-muted">{{ __('messages.Active') }}</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h5 class="text-warning mb-0">{{ $totalTasks }}</h5>
                                <small class="text-muted">{{ __('messages.Total Tasks') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Initiatives in this Category -->
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clipboard-check me-2"></i>{{ __('messages.Initiatives') }} ({{ $category->initiatives->count() }})
                </h5>
                <a href="{{ route('admin.initiatives.create') }}?category={{ $category->id }}" class="btn btn-success btn-sm">
                    <i class="bi bi-plus-circle me-1"></i>{{ __('messages.Add Initiative') }}
                </a>
            </div>
            <div class="card-body p-0">
                @if($category->initiatives->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('messages.Name') }}</th>
                                    <th>{{ __('messages.Status') }}</th>
                                    <th>{{ __('messages.Tasks') }}</th>
                                    <th>{{ __('messages.Students') }}</th>
                                    <th>{{ __('messages.Dates') }}</th>
                                    <th width="100">{{ __('messages.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($category->initiatives as $initiative)
                                    <tr>
                                        <td>
                                            <div class="fw-medium">{{ $initiative->getLocalizedName() }}</div>
                                            <small class="text-muted">{{ Str::limit($initiative->getLocalizedDescription(), 50) }}</small>
                                        </td>
                                        <td>
                                            @if($initiative->is_active)
                                                <span class="badge bg-success">{{ __('messages.Active') }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ __('messages.Inactive') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $initiative->tasks->count() }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $initiative->enrollments->count() }}</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                @if($initiative->start_date)
                                                    <div><i class="bi bi-calendar-event me-1"></i>{{ $initiative->start_date->format('M j') }}</div>
                                                @endif
                                                @if($initiative->end_date)
                                                    <div><i class="bi bi-calendar-x me-1"></i>{{ $initiative->end_date->format('M j') }}</div>
                                                @endif
                                            </small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.initiatives.show', $initiative) }}" 
                                                   class="btn btn-outline-primary" title="{{ __('messages.View') }}">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.initiatives.edit', $initiative) }}" 
                                                   class="btn btn-outline-success" title="{{ __('messages.Edit') }}">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-clipboard-x display-1 text-muted"></i>
                        <h5 class="mt-3">{{ __('messages.No initiatives in this category') }}</h5>
                        <p class="text-muted">{{ __('messages.Start by adding your first initiative') }}</p>
                        <a href="{{ route('admin.initiatives.create') }}?category={{ $category->id }}" class="btn btn-success">
                            <i class="bi bi-plus-circle me-1"></i>{{ __('messages.Add Initiative') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
