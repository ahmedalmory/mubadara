<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">{{ __('messages.Add Task') }} - {{ $initiative->getLocalizedName() }}</h2>
            <a href="{{ route('admin.initiatives.show', $initiative) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>{{ __('messages.Back') }}
            </a>
        </div>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">{{ __('messages.Task') }} {{ __('messages.Information') }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.initiatives.tasks.store', $initiative) }}" method="POST">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title_en" class="form-label">
                                            {{ __('messages.Task Name') }} (English) <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control @error('title_en') is-invalid @enderror" 
                                               id="title_en" name="title_en" value="{{ old('title_en') }}" required>
                                        @error('title_en')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title_ar" class="form-label">
                                            {{ __('messages.Task Name') }} (العربية) <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control @error('title_ar') is-invalid @enderror" 
                                               id="title_ar" name="title_ar" value="{{ old('title_ar') }}" required>
                                        @error('title_ar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="description_en" class="form-label">
                                            {{ __('messages.Description') }} (English)
                                        </label>
                                        <textarea class="form-control @error('description_en') is-invalid @enderror" 
                                                  id="description_en" name="description_en" rows="4">{{ old('description_en') }}</textarea>
                                        @error('description_en')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="description_ar" class="form-label">
                                            {{ __('messages.Description') }} (العربية)
                                        </label>
                                        <textarea class="form-control @error('description_ar') is-invalid @enderror" 
                                                  id="description_ar" name="description_ar" rows="4">{{ old('description_ar') }}</textarea>
                                        @error('description_ar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="points_value" class="form-label">
                                            {{ __('messages.Points Value') }} <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" class="form-control @error('points_value') is-invalid @enderror" 
                                               id="points_value" name="points_value" value="{{ old('points_value', 10) }}" 
                                               min="1" required>
                                        @error('points_value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="order" class="form-label">
                                            {{ __('messages.Order') }} <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                               id="order" name="order" value="{{ old('order', $initiative->tasks()->max('order') + 1) }}" 
                                               min="1" required>
                                        @error('order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">{{ __('messages.Task display order') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">
                                            {{ __('messages.Status') }} <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('status') is-invalid @enderror" 
                                                id="status" name="status" required>
                                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                                                {{ __('messages.Active') }}
                                            </option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                                {{ __('messages.Inactive') }}
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.initiatives.show', $initiative) }}" class="btn btn-secondary">
                                    {{ __('messages.Cancel') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>{{ __('messages.Create') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
