<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth.modern')] class extends Component {
    public string $email = '';
    public bool $emailSent = false;

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
        ]);

        $status = Password::sendResetLink($this->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            $this->emailSent = true;
            session()->flash('status', 'We have sent a password reset link to your email address.');
        } else {
            $this->emailSent = true;
            session()->flash('status', 'If an account with that email exists, we have sent a password reset link.');
        }
    }

    /**
     * Reset form and allow resending
     */
    public function resetForm(): void
    {
        $this->emailSent = false;
        $this->email = '';
        session()->forget('status');
    }
}; ?>

<div>
    @if(!$emailSent)
        <!-- Initial Form -->
        <div>
            <!-- Page Title -->
            <div class="auth-form-title">Forgot Password?</div>
            <p class="auth-form-subtitle">Enter your email address and we'll send you a reset link</p>

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

            <form wire:submit="sendPasswordResetLink" class="auth-form">
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
                    <div style="margin-top: 8px; font-size: 13px; color: var(--text-secondary);">
                        Enter the email address associated with your ERPedia account
                    </div>
                </div>

                <!-- Send Reset Link Button -->
                <button type="submit" class="auth-btn auth-btn-primary">
                    <span wire:loading.remove style="display: flex; align-items: center; gap: 8px;">
                        <i class="material-icons" style="font-size: 18px;">send</i>
                        Send Reset Link
                    </span>
                    <span wire:loading style="display: none;">
                        <div class="loading-spinner-large" style="width: 16px; height: 16px; margin: 0;"></div>
                        Sending...
                    </span>
                </button>
            </form>

            <!-- Back to Login -->
            <div class="auth-switch-form">
                <span>Remember your password? </span>
                <a href="{{ route('login') }}" class="auth-link" wire:navigate>Back to Sign In</a>
            </div>
        </div>
    @else
        <!-- Success State -->
        <div style="text-align: center;">
            <!-- Success Icon -->
            <div style="margin-bottom: 20px;">
                <div style="width: 64px; height: 64px; background: var(--success-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                    <i class="material-icons" style="font-size: 32px; color: white;">mark_email_read</i>
                </div>
            </div>

            <!-- Page Title -->
            <div class="auth-form-title">Check Your Email</div>
            <p class="auth-form-subtitle">We've sent a password reset link to<br><strong>{{ $email }}</strong></p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="auth-alert auth-alert-success" style="text-align: left;">
                    <i class="material-icons">check_circle</i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Instructions -->
            <div style="background: var(--gray-50); border-radius: 8px; padding: 16px; margin: 20px 0; text-align: left;">
                <h4 style="margin: 0 0 8px 0; font-size: 14px; font-weight: 600; color: var(--text-primary); display: flex; align-items: center; gap: 6px;">
                    <i class="material-icons" style="font-size: 16px;">info</i>
                    Next Steps
                </h4>
                <div style="font-size: 13px; color: var(--text-secondary); line-height: 1.4;">
                    <div>1. Check your email inbox (and spam folder)</div>
                    <div>2. Click the reset link in the email</div>
                    <div>3. Create a new password</div>
                    <div>4. Sign in with your new password</div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 12px; margin-bottom: 20px;">
                <button wire:click="resetForm" class="auth-btn auth-btn-secondary" style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="material-icons" style="font-size: 18px;">refresh</i>
                    Try Different Email
                </button>
                <a href="{{ route('login') }}" class="auth-btn auth-btn-primary" style="flex: 1; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;" wire:navigate>
                    <i class="material-icons" style="font-size: 18px;">login</i>
                    Back to Sign In
                </a>
            </div>
        </div>
    @endif

    <!-- Help Section -->
    <div style="margin-top: 24px; padding: 16px; background: rgba(255, 174, 31, 0.1); border-radius: 8px; border: 1px solid rgba(255, 174, 31, 0.3);">
        <h4 style="margin: 0 0 8px 0; font-size: 13px; font-weight: 600; color: #b45309; display: flex; align-items: center; gap: 6px;">
            <i class="material-icons" style="font-size: 16px;">help</i>
            Need Help?
        </h4>
        <div style="font-size: 12px; color: #a16207; line-height: 1.4;">
            <div>• Check your spam or junk folder</div>
            <div>• Make sure you entered the correct email address</div>
            <div>• The reset link expires in 60 minutes</div>
            <div>• Contact support if you continue having issues</div>
        </div>
    </div>
</div>