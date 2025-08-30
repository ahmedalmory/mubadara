<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label for="current_password" class="form-label">{{ __('messages.Current Password') }}</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input id="current_password" name="current_password" type="password" 
                           class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                           autocomplete="current-password">
                </div>
                @error('current_password', 'updatePassword')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="password" class="form-label">{{ __('messages.New Password') }}</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                    <input id="password" name="password" type="password" 
                           class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                           autocomplete="new-password">
                </div>
                @error('password', 'updatePassword')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">{{ __('messages.Confirm Password') }}</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                    <input id="password_confirmation" name="password_confirmation" type="password" 
                           class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                           autocomplete="new-password">
                </div>
                @error('password_confirmation', 'updatePassword')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-warning">
            <i class="bi bi-shield-check me-1"></i>{{ __('messages.Update Password') }}
        </button>
    </div>
</form>
