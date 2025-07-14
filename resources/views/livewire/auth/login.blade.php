<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth.modern')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;
    public bool $showPassword = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('These credentials do not match our records.'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Toggle password visibility
     */
    public function togglePassword(): void
    {
        $this->showPassword = !$this->showPassword;
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div>
    <!-- Page Title -->
    <div class="auth-form-title">Welcome Back</div>
    <p class="auth-form-subtitle">Sign in to your ERPedia account</p>

    <!-- Session Status -->
    @if (session('status'))
        <div class="auth-alert auth-alert-success">
            <i class="material-icons">check_circle</i>
            <span>{{ session('status') }}</span>
        </div>
    @endif

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

    <form wire:submit="login" class="auth-form">
        <!-- Email Address -->
        <div class="auth-form-group">
            <label class="auth-form-label" for="email">Email Address</label>
            <div class="auth-input-group">
                <i class="material-icons auth-input-icon">email</i>
                <input type="email"
                       id="email"
                       wire:model="email"
                       class="auth-form-input"
                       placeholder="Enter your email address"
                       required
                       autofocus
                       autocomplete="email">
            </div>
        </div>

        <!-- Password -->
        <div class="auth-form-group">
            <label class="auth-form-label" for="password">Password</label>
            <div class="auth-input-group">
                <i class="material-icons auth-input-icon">lock</i>
                <input type="{{ $showPassword ? 'text' : 'password' }}"
                       id="password"
                       wire:model="password"
                       class="auth-form-input"
                       placeholder="Enter your password"
                       required
                       autocomplete="current-password">
                <button type="button"
                        wire:click="togglePassword"
                        class="auth-password-toggle">
                    <i class="material-icons">{{ $showPassword ? 'visibility_off' : 'visibility' }}</i>
                </button>
            </div>
        </div>

        <!-- Remember Me & Forgot Password -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin: 20px 0;">
            <div class="auth-checkbox-group" style="margin: 0;">
                <input type="checkbox" id="remember" wire:model="remember" class="auth-checkbox">
                <label for="remember" class="auth-checkbox-label">Remember me</label>
            </div>
            
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-link" wire:navigate>
                    Forgot Password?
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <button type="submit" class="auth-btn auth-btn-primary">
            <span wire:loading.remove style="display: flex; align-items: center; gap: 8px;">
                <i class="material-icons" style="font-size: 18px;">login</i>
                Sign In
            </span>
            <span wire:loading style="display: none;">
                <div class="loading-spinner-large" style="width: 16px; height: 16px; margin: 0;"></div>
                Signing In...
            </span>
        </button>
    </form>

    <!-- Register Link -->
    @if (Route::has('register'))
        <div class="auth-switch-form">
            <span>Don't have an account? </span>
            <a href="{{ route('register') }}" class="auth-link" wire:navigate>Create Account</a>
        </div>
    @endif
</div>