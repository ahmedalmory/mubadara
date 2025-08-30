<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">{{ __('messages.Categories') }}</h2>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>{{ __('messages.Add Category') }}
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
                <h5 class="card-title mb-0">{{ __('messages.Categories') }} ({{ $categories->total() }})</h5>
            </div>
            <div class="card-body p-0">
                @if($categories->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('messages.Name') }}</th>
                                    <th>{{ __('messages.Description') }}</th>
                                    <th>{{ __('messages.Status') }}</th>
                                    <th>{{ __('messages.Initiatives') }}</th>
                                    <th width="150">{{ __('messages.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>
                                            <div class="fw-medium">{{ $category->getLocalizedName() }}</div>
                                            <small class="text-muted">
                                                @if(app()->getLocale() == 'en')
                                                    {{ $category->name['ar'] ?? '' }}
                                                @else
                                                    {{ $category->name['en'] ?? '' }}
                                                @endif
                                            </small>
                                        </td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 300px;">
                                                {{ $category->getLocalizedDescription() }}
                                            </div>
                                        </td>
                                        <td>
                                            @if($category->is_active)
                                                <span class="badge bg-success">{{ __('messages.Active') }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ __('messages.Inactive') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $category->initiatives_count ?? 0 }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.categories.show', $category) }}" 
                                                   class="btn btn-outline-primary" title="{{ __('messages.View') }}">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.categories.edit', $category) }}" 
                                                   class="btn btn-outline-success" title="{{ __('messages.Edit') }}">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.categories.destroy', $category) }}" 
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
                        <i class="bi bi-folder-x display-1 text-muted"></i>
                        <h5 class="mt-3">{{ __('messages.No data available') }}</h5>
                        <p class="text-muted">{{ __('messages.Start by adding your first category') }}</p>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>{{ __('messages.Add Category') }}
                        </a>
                    </div>
                @endif
            </div>
            
            @if($categories->hasPages())
                <div class="card-footer bg-white">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
