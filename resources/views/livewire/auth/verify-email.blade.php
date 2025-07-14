<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth.modern')] class extends Component {
    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<div>
    <!-- Page Title -->
    <div class="auth-form-title">Verify Your Email</div>
    <p class="auth-form-subtitle">We need to verify your email address before you can continue</p>

    <!-- User Info -->
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

    <!-- Status Messages -->
    @if (session('status') == 'verification-link-sent')
        <div class="auth-alert auth-alert-success">
            <i class="material-icons">check_circle</i>
            <span>A new verification link has been sent to your email address.</span>
        </div>
    @endif

    <!-- Instructions -->
    <div style="background: rgba(73, 190, 255, 0.1); border-radius: 8px; padding: 16px; margin: 20px 0; text-align: left; border: 1px solid rgba(73, 190, 255, 0.3);">
        <h4 style="margin: 0 0 8px 0; font-size: 14px; font-weight: 600; color: #0284c7; display: flex; align-items: center; gap: 6px;">
            <i class="material-icons" style="font-size: 16px;">email</i>
            Check Your Email
        </h4>
        <div style="font-size: 13px; color: #0284c7; line-height: 1.4;">
            <div>1. Check your email inbox (and spam folder)</div>
            <div>2. Click the verification link in the email</div>
            <div>3. Return here to continue</div>
            <div>4. If you don't see the email, request a new one below</div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div style="display: flex; gap: 12px; margin-bottom: 20px;">
        <button wire:click="sendVerification" class="auth-btn auth-btn-primary" style="flex: 1;">
            <span wire:loading.remove>
                <i class="material-icons">send</i>
                Resend Verification Email
            </span>
            <span wire:loading style="display: none;">
                <div class="loading-spinner-large" style="width: 16px; height: 16px; margin: 0;"></div>
                Sending...
            </span>
        </button>
    </div>

    <!-- Logout Option -->
    <form method="POST" action="{{ route('logout') }}" style="text-align: center;">
        @csrf
        <button type="submit" class="auth-btn auth-btn-secondary">
            <i class="material-icons">logout</i>
            Sign Out
        </button>
    </form>

    <!-- Help Section -->
    <div style="margin-top: 24px; padding: 16px; background: rgba(255, 174, 31, 0.1); border-radius: 8px; border: 1px solid rgba(255, 174, 31, 0.3);">
        <h4 style="margin: 0 0 8px 0; font-size: 13px; font-weight: 600; color: #b45309; display: flex; align-items: center; gap: 6px;">
            <i class="material-icons" style="font-size: 16px;">help</i>
            Need Help?
        </h4>
        <div style="font-size: 12px; color: #a16207; line-height: 1.4;">
            <div>• Check your spam or junk folder</div>
            <div>• Make sure the email address is correct</div>
            <div>• The verification link may take a few minutes to arrive</div>
            <div>• Contact support if you continue having issues</div>
        </div>
    </div>

    <!-- Security Notice -->
    <div style="margin-top: 16px; padding: 16px; background: rgba(19, 222, 185, 0.1); border-radius: 8px; border: 1px solid rgba(19, 222, 185, 0.3);">
        <h4 style="margin: 0 0 8px 0; font-size: 13px; font-weight: 600; color: #0d9488; display: flex; align-items: center; gap: 6px;">
            <i class="material-icons" style="font-size: 16px;">verified</i>
            Why Verify?
        </h4>
        <div style="font-size: 12px; color: #0d9488; line-height: 1.4;">
            Email verification helps us ensure account security and enables important notifications about your ERPedia account.
        </div>
    </div>
</div>

<script>
    // Auto-refresh when email is verified
    let checkVerificationInterval;
    
    document.addEventListener('DOMContentLoaded', function() {
        checkVerificationInterval = setInterval(function() {
            fetch('{{ route('verification.check') }}', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.verified) {
                    clearInterval(checkVerificationInterval);
                    window.location.href = '{{ route('dashboard') }}';
                }
            })
            .catch(error => {
                console.log('Verification check failed:', error);
            });
        }, 5000);
    });
    
    window.addEventListener('beforeunload', function() {
        if (checkVerificationInterval) {
            clearInterval(checkVerificationInterval);
        }
    });
</script>