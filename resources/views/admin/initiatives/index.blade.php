<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">{{ __('messages.Initiatives') }}</h2>
            <a href="{{ route('admin.initiatives.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>{{ __('messages.Add Initiative') }}
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

        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">{{ __('messages.Initiatives') }} ({{ $initiatives->total() }})</h5>
            </div>
            <div class="card-body p-0">
                @if($initiatives->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('messages.Name') }}</th>
                                    <th>{{ __('messages.Category') }}</th>
                                    <th>{{ __('messages.Status') }}</th>
                                    <th>{{ __('messages.Tasks') }}</th>
                                    <th>{{ __('messages.Students') }}</th>
                                    <th>{{ __('messages.Dates') }}</th>
                                    <th width="150">{{ __('messages.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($initiatives as $initiative)
                                    <tr>
                                        <td>
                                            <div class="fw-medium">{{ $initiative->getLocalizedName() }}</div>
                                            <small class="text-muted">
                                                @if(app()->getLocale() == 'en')
                                                    {{ $initiative->name['ar'] ?? '' }}
                                                @else
                                                    {{ $initiative->name['en'] ?? '' }}
                                                @endif
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $initiative->category->getLocalizedName() }}</span>
                                        </td>
                                        <td>
                                            @if($initiative->is_active)
                                                <span class="badge bg-success">{{ __('messages.Active') }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ __('messages.Inactive') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $initiative->tasks_count ?? 0 }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $initiative->enrollments_count ?? 0 }}</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                @if($initiative->start_date)
                                                    <div><i class="bi bi-calendar-event me-1"></i>{{ $initiative->start_date->format('Y-m-d') }}</div>
                                                @endif
                                                @if($initiative->end_date)
                                                    <div><i class="bi bi-calendar-x me-1"></i>{{ $initiative->end_date->format('Y-m-d') }}</div>
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
                                                <form action="{{ route('admin.initiatives.destroy', $initiative) }}" 
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
                    <div class="text-center py-5">
                        <i class="bi bi-clipboard-x display-1 text-muted"></i>
                        <h5 class="mt-3">{{ __('messages.No data available') }}</h5>
                        <p class="text-muted">{{ __('messages.Start by adding your first initiative') }}</p>
                        <a href="{{ route('admin.initiatives.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>{{ __('messages.Add Initiative') }}
                        </a>
                    </div>
                @endif
            </div>
            
            @if($initiatives->hasPages())
                <div class="card-footer bg-white">
                    {{ $initiatives->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
