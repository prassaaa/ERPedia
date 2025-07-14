<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth.modern')] class extends Component {
    #[Locked]
    public string $token = '';
    
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $showPassword = false;
    public bool $showPasswordConfirmation = false;
    public bool $passwordReset = false;

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;
        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            $this->addError('email', __($status));
            return;
        }

        $this->passwordReset = true;
        Session::flash('status', __($status));
    }

    /**
     * Toggle password visibility
     */
    public function togglePassword(): void
    {
        $this->showPassword = !$this->showPassword;
    }

    /**
     * Toggle password confirmation visibility
     */
    public function togglePasswordConfirmation(): void
    {
        $this->showPasswordConfirmation = !$this->showPasswordConfirmation;
    }
}; ?>

<div>
    @if(!$passwordReset)
        <!-- Reset Password Form -->
        <div>
            <!-- Page Title -->
            <div class="auth-form-title">Reset Password</div>
            <p class="auth-form-subtitle">Create a new strong password for your account</p>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="auth-alert auth-alert-error">
                    <i class="material-icons">error</i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form wire:submit="resetPassword" class="auth-form">
                <!-- Email Address (Read-only) -->
                <div class="auth-form-group">
                    <label class="auth-form-label" for="email">Email Address</label>
                    <div class="auth-input-group">
                        <i class="material-icons auth-input-icon">email</i>
                        <input type="email"
                               id="email"
                               wire:model="email"
                               class="auth-form-input"
                               placeholder="Your email address"
                               readonly
                               style="background-color: var(--gray-50); color: var(--text-secondary);">
                    </div>
                </div>

                <!-- New Password -->
                <div class="auth-form-group">
                    <label class="auth-form-label" for="password">New Password</label>
                    <div class="auth-input-group">
                        <i class="material-icons auth-input-icon">lock</i>
                        <input type="{{ $showPassword ? 'text' : 'password' }}"
                               id="password"
                               wire:model="password"
                               class="auth-form-input"
                               placeholder="Create a strong password"
                               required
                               autofocus
                               autocomplete="new-password">
                        <button type="button"
                                wire:click="togglePassword"
                                class="auth-password-toggle">
                            <i class="material-icons">{{ $showPassword ? 'visibility_off' : 'visibility' }}</i>
                        </button>
                    </div>
                    <!-- Password Requirements -->
                    @if($password)
                        <div style="margin-top: 8px; display: flex; flex-wrap: wrap; gap: 8px;">
                            <span class="password-req {{ strlen($password) >= 8 ? 'valid' : '' }}">
                                <i class="material-icons">{{ strlen($password) >= 8 ? 'check' : 'close' }}</i>
                                8+ characters
                            </span>
                            <span class="password-req {{ preg_match('/[A-Z]/', $password) ? 'valid' : '' }}">
                                <i class="material-icons">{{ preg_match('/[A-Z]/', $password) ? 'check' : 'close' }}</i>
                                Uppercase
                            </span>
                            <span class="password-req {{ preg_match('/[a-z]/', $password) ? 'valid' : '' }}">
                                <i class="material-icons">{{ preg_match('/[a-z]/', $password) ? 'check' : 'close' }}</i>
                                Lowercase
                            </span>
                            <span class="password-req {{ preg_match('/[0-9]/', $password) ? 'valid' : '' }}">
                                <i class="material-icons">{{ preg_match('/[0-9]/', $password) ? 'check' : 'close' }}</i>
                                Number
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Confirm New Password -->
                <div class="auth-form-group">
                    <label class="auth-form-label" for="password_confirmation">Confirm New Password</label>
                    <div class="auth-input-group">
                        <i class="material-icons auth-input-icon">lock_outline</i>
                        <input type="{{ $showPasswordConfirmation ? 'text' : 'password' }}"
                               id="password_confirmation"
                               wire:model="password_confirmation"
                               class="auth-form-input"
                               placeholder="Confirm your new password"
                               required
                               autocomplete="new-password">
                        <button type="button"
                                wire:click="togglePasswordConfirmation"
                                class="auth-password-toggle">
                            <i class="material-icons">{{ $showPasswordConfirmation ? 'visibility_off' : 'visibility' }}</i>
                        </button>
                    </div>
                    @if($password_confirmation && $password !== $password_confirmation)
                        <div style="margin-top: 8px; font-size: 12px; color: var(--error-color); display: flex; align-items: center; gap: 4px;">
                            <i class="material-icons" style="font-size: 14px;">error</i>
                            Passwords do not match
                        </div>
                    @elseif($password_confirmation && $password === $password_confirmation)
                        <div style="margin-top: 8px; font-size: 12px; color: var(--success-color); display: flex; align-items: center; gap: 4px;">
                            <i class="material-icons" style="font-size: 14px;">check</i>
                            Passwords match
                        </div>
                    @endif
                </div>

                <!-- Reset Password Button -->
                <button type="submit" class="auth-btn auth-btn-primary">
                    <span wire:loading.remove>
                        <i class="material-icons">lock_reset</i>
                        Reset Password
                    </span>
                    <span wire:loading style="display: none;">
                        <div class="loading-spinner-large" style="width: 16px; height: 16px; margin: 0;"></div>
                        Resetting Password...
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
                    <i class="material-icons" style="font-size: 32px; color: white;">check_circle</i>
                </div>
            </div>

            <!-- Page Title -->
            <div class="auth-form-title">Password Reset Successful!</div>
            <p class="auth-form-subtitle">Your password has been successfully updated</p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="auth-alert auth-alert-success" style="text-align: left;">
                    <i class="material-icons">check_circle</i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Instructions -->
            <div style="background: rgba(19, 222, 185, 0.1); border-radius: 8px; padding: 16px; margin: 20px 0; text-align: left; border: 1px solid rgba(19, 222, 185, 0.3);">
                <h4 style="margin: 0 0 8px 0; font-size: 14px; font-weight: 600; color: #0d9488; display: flex; align-items: center; gap: 6px;">
                    <i class="material-icons" style="font-size: 16px;">security</i>
                    Security Recommendation
                </h4>
                <div style="font-size: 13px; color: #0d9488; line-height: 1.4;">
                    <div>• Your password has been securely updated</div>
                    <div>• You can now sign in with your new password</div>
                    <div>• Keep your password safe and don't share it</div>
                </div>
            </div>

            <!-- Sign In Button -->
            <a href="{{ route('login') }}" class="auth-btn auth-btn-primary" style="text-decoration: none;" wire:navigate>
                <i class="material-icons">login</i>
                Sign In Now
            </a>
        </div>
    @endif

    <!-- Security Notice -->
    <div style="margin-top: 24px; padding: 16px; background: rgba(250, 137, 107, 0.1); border-radius: 8px; border: 1px solid rgba(250, 137, 107, 0.3);">
        <h4 style="margin: 0 0 8px 0; font-size: 13px; font-weight: 600; color: #dc2626; display: flex; align-items: center; gap: 6px;">
            <i class="material-icons" style="font-size: 16px;">security</i>
            Security Notice
        </h4>
        <div style="font-size: 12px; color: #dc2626; line-height: 1.4;">
            <div>• This reset link can only be used once</div>
            <div>• The link expires after 60 minutes</div>
            <div>• Choose a strong, unique password</div>
        </div>
    </div>
</div>