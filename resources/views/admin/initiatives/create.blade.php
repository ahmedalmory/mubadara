<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">{{ __('messages.Add Initiative') }}</h2>
            <a href="{{ route('admin.initiatives.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>{{ __('messages.Back') }}
            </a>
        </div>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">{{ __('messages.Initiative') }} {{ __('messages.Information') }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.initiatives.store') }}" method="POST">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">
                                            {{ __('messages.Category') }} <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('category_id') is-invalid @enderror" 
                                                id="category_id" name="category_id" required>
                                            <option value="">{{ __('messages.Select Category') }}</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" 
                                                    {{ (old('category_id') ?? $selectedCategory) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->getLocalizedName() }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                                   value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">
                                                {{ __('messages.Active') }}
                                            </label>
                                        </div>
                                        <small class="form-text text-muted">
                                            {{ __('messages.Active initiatives will be visible to students') }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name_en" class="form-label">
                                            {{ __('messages.Initiative Name') }} (English) <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control @error('name_en') is-invalid @enderror" 
                                               id="name_en" name="name_en" value="{{ old('name_en') }}" required>
                                        @error('name_en')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name_ar" class="form-label">
                                            {{ __('messages.Initiative Name') }} (العربية) <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control @error('name_ar') is-invalid @enderror" 
                                               id="name_ar" name="name_ar" value="{{ old('name_ar') }}" required>
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
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">
                                            {{ __('messages.Start Date') }}
                                        </label>
                                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                               id="start_date" name="start_date" value="{{ old('start_date') }}">
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">
                                            {{ __('messages.End Date') }}
                                        </label>
                                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                               id="end_date" name="end_date" value="{{ old('end_date') }}">
                                        @error('end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.initiatives.index') }}" class="btn btn-secondary">
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
