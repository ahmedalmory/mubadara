<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">{{ __('messages.Edit Category') }}</h2>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>{{ __('messages.Back') }}
            </a>
        </div>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">{{ __('messages.Edit') }} {{ $category->getLocalizedName() }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name_en" class="form-label">
                                            {{ __('messages.Category Name') }} (English) <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control @error('name_en') is-invalid @enderror" 
                                               id="name_en" name="name_en" 
                                               value="{{ old('name_en', $category->name['en'] ?? '') }}" required>
                                        @error('name_en')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name_ar" class="form-label">
                                            {{ __('messages.Category Name') }} (العربية) <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control @error('name_ar') is-invalid @enderror" 
                                               id="name_ar" name="name_ar" 
                                               value="{{ old('name_ar', $category->name['ar'] ?? '') }}" required>
                                        @error('name_ar')
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
                                                  id="description_en" name="description_en" rows="4">{{ old('description_en', $category->description['en'] ?? '') }}</textarea>
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
                                                  id="description_ar" name="description_ar" rows="4">{{ old('description_ar', $category->description['ar'] ?? '') }}</textarea>
                                        @error('description_ar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                           value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        {{ __('messages.Active') }}
                                    </label>
                                </div>
                                <small class="form-text text-muted">
                                    {{ __('messages.Active categories will be visible to students') }}
                                </small>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                                    {{ __('messages.Cancel') }}
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-1"></i>{{ __('messages.Save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
