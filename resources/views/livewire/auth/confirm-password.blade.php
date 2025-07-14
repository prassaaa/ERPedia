<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth.modern')] class extends Component {
    public string $password = '';
    public bool $showPassword = false;

    /**
     * Confirm the current user's password.
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Toggle password visibility
     */
    public function togglePassword(): void
    {
        $this->showPassword = !$this->showPassword;
    }
}; ?>

<div>
    <!-- Page Title -->
    <div class="auth-form-title">Confirm Password</div>
    <p class="auth-form-subtitle">Please confirm your password to continue</p>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="auth-alert auth-alert-error">
            <i class="material-icons">error</i>
            <span>
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </span>
        </div>
    @endif

    <form wire:submit="confirmPassword" class="auth-form">
        <!-- Current User Info -->
        <div style="background: var(--gray-50); border-radius: 8px; padding: 16px; margin-bottom: 20px; text-align: center;">
            <div style="display: flex; align-items: center; justify-content: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <span style="color: white; font-weight: 600; font-size: 16px;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                </div>
                <div style="text-align: left;">
                    <div style="font-weight: 600; color: var(--text-primary);">{{ Auth::user()->name }}</div>
                    <div style="font-size: 14px; color: var(--text-secondary);">{{ Auth::user()->email }}</div>
                </div>
            </div>
        </div>

        <!-- Password -->
        <div class="auth-form-group">
            <label class="auth-form-label" for="password">Current Password</label>
            <div class="auth-input-group">
                <i class="material-icons auth-input-icon">lock</i>
                <input type="{{ $showPassword ? 'text' : 'password' }}"
                       id="password"
                       wire:model="password"
                       class="auth-form-input"
                       placeholder="Enter your current password"
                       required
                       autofocus
                       autocomplete="current-password">
                <button type="button"
                        wire:click="togglePassword"
                        class="auth-password-toggle">
                    <i class="material-icons">{{ $showPassword ? 'visibility_off' : 'visibility' }}</i>
                </button>
            </div>
        </div>

        <!-- Confirm Button -->
        <button type="submit" class="auth-btn auth-btn-primary">
            <span wire:loading.remove>
                <i class="material-icons">verified_user</i>
                Confirm Password
            </span>
            <span wire:loading style="display: none;">
                <div class="loading-spinner-large" style="width: 16px; height: 16px; margin: 0;"></div>
                Confirming...
            </span>
        </button>
    </form>

    <!-- Cancel Link -->
    <div class="auth-switch-form">
        <a href="{{ route('dashboard') }}" class="auth-link" wire:navigate>Cancel and Go Back</a>
    </div>

    <!-- Security Info -->
    <div style="margin-top: 24px; padding: 16px; background: rgba(255, 174, 31, 0.1); border-radius: 8px; border: 1px solid rgba(255, 174, 31, 0.3);">
        <h4 style="margin: 0 0 8px 0; font-size: 13px; font-weight: 600; color: #b45309; display: flex; align-items: center; gap: 6px;">
            <i class="material-icons" style="font-size: 16px;">security</i>
            Security Check
        </h4>
        <div style="font-size: 12px; color: #a16207; line-height: 1.4;">
            For your security, we need to confirm your identity before allowing access to sensitive areas.
        </div>
    </div>
</div>