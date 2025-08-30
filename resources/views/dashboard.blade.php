<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">{{ __('messages.Dashboard') }}</h2>
    </x-slot>

    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-check-circle-fill text-success display-1 mb-3"></i>
                <h4 class="text-success">{{ __('messages.You\'re logged in!') }}</h4>
                <p class="text-muted">{{ __('messages.Welcome to Mubadara') }}</p>
                
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">
                        <i class="bi bi-gear me-2"></i>{{ __('messages.Go to Admin Panel') }}
                    </a>
                @else
                    <a href="{{ route('student.initiatives.index') }}" class="btn btn-primary">
                        <i class="bi bi-clipboard-check me-2"></i>{{ __('messages.Browse Initiatives') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
