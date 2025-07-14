<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth.modern')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $showPassword = false;
    public bool $showPasswordConfirmation = false;
    public bool $acceptTerms = false;

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'acceptTerms' => ['required', 'accepted'],
        ], [
            'name.min' => 'Name must be at least 2 characters.',
            'email.unique' => 'This email address is already registered.',
            'password.confirmed' => 'Password confirmation does not match.',
            'acceptTerms.accepted' => 'You must accept the terms and conditions.',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        
        unset($validated['acceptTerms']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        session()->flash('status', 'Account created successfully! Welcome to ERPedia.');

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
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
    <!-- Page Title -->
    <div class="auth-form-title">Create Account</div>
    <p class="auth-form-subtitle">Join ERPedia and start managing your business</p>

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
            <div>
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif

    <form wire:submit="register" class="auth-form">
        <!-- Full Name -->
        <div class="auth-form-group">
            <label class="auth-form-label" for="name">Full Name</label>
            <div class="auth-input-group">
                <i class="material-icons auth-input-icon">person</i>
                <input type="text"
                       id="name"
                       wire:model="name"
                       class="auth-form-input"
                       placeholder="Enter your full name"
                       required
                       autofocus
                       autocomplete="name">
            </div>
        </div>

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
                       placeholder="Create a strong password"
                       required
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

        <!-- Confirm Password -->
        <div class="auth-form-group">
            <label class="auth-form-label" for="password_confirmation">Confirm Password</label>
            <div class="auth-input-group">
                <i class="material-icons auth-input-icon">lock_outline</i>
                <input type="{{ $showPasswordConfirmation ? 'text' : 'password' }}"
                       id="password_confirmation"
                       wire:model="password_confirmation"
                       class="auth-form-input"
                       placeholder="Confirm your password"
                       required
                       autocomplete="new-password">
                <button type="button"
                        wire:click="togglePasswordConfirmation"
                        class="auth-password-toggle">
                    <i class="material-icons">{{ $showPasswordConfirmation ? 'visibility_off' : 'visibility' }}</i>
                </button>
            </div>
        </div>

        <!-- Terms and Conditions -->
        <div class="auth-checkbox-group" style="margin: 20px 0; align-items: flex-start;">
            <input type="checkbox" id="acceptTerms" wire:model="acceptTerms" class="auth-checkbox" style="margin-top: 2px;">
            <label for="acceptTerms" class="auth-checkbox-label" style="line-height: 1.4;">
                I agree to the 
                <a href="#" class="auth-link">Terms and Conditions</a> 
                and 
                <a href="#" class="auth-link">Privacy Policy</a>
            </label>
        </div>

        <!-- Register Button -->
        <button type="submit" class="auth-btn auth-btn-primary">
            <span wire:loading.remove style="display: flex; align-items: center; gap: 8px;">
                <i class="material-icons" style="font-size: 18px;">person_add</i>
                Create Account
            </span>
            <span wire:loading style="display: none;">
                <div class="loading-spinner-large" style="width: 16px; height: 16px; margin: 0;"></div>
                Creating Account...
            </span>
        </button>
    </form>

    <!-- Login Link -->
    <div class="auth-switch-form">
        <span>Already have an account? </span>
        <a href="{{ route('login') }}" class="auth-link" wire:navigate>Sign In</a>
    </div>
</div>