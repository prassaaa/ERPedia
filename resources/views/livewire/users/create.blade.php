<div class="user-create">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-left">
                <h1 class="page-title">Add New Employee</h1>
                <p class="page-subtitle">Create a new employee account with all necessary information</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('users.index') }}" class="btn btn-outline">
                    <span class="material-icons">arrow_back</span>
                    Back to Employees
                </a>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="alert alert-success">
            <span class="material-icons">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-error">
            <span class="material-icons">error</span>
            {{ session('error') }}
        </div>
    @endif

    <!-- Form -->
    <form wire:submit="save" class="user-form">
        <div class="form-sections">
            <!-- Basic Information -->
            <div class="form-section">
                <div class="section-header">
                    <h3 class="section-title">Basic Information</h3>
                    <p class="section-subtitle">Employee's basic details and contact information</p>
                </div>

                <div class="form-grid">
                    <!-- Company -->
                    <div class="form-group">
                        <label for="company_id" class="form-label required">Company</label>
                        <select wire:model.live="company_id" id="company_id" class="form-select">
                            <option value="">Select Company</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                        @error('company_id') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Department -->
                    <div class="form-group">
                        <label for="department_id" class="form-label">Department</label>
                        <select wire:model="department_id" id="department_id" class="form-select">
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Employee ID -->
                    <div class="form-group">
                        <label for="employee_id" class="form-label">Employee ID</label>
                        <input type="text" wire:model="employee_id" id="employee_id" class="form-input"
                               placeholder="Leave empty to auto-generate">
                        @error('employee_id') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Name -->
                    <div class="form-group">
                        <label for="name" class="form-label required">Display Name</label>
                        <input type="text" wire:model="name" id="name" class="form-input"
                               placeholder="John Doe" required>
                        @error('name') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- First Name -->
                    <div class="form-group">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" wire:model="first_name" id="first_name" class="form-input"
                               placeholder="John">
                        @error('first_name') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Last Name -->
                    <div class="form-group">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" wire:model="last_name" id="last_name" class="form-input"
                               placeholder="Doe">
                        @error('last_name') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label required">Email</label>
                        <input type="email" wire:model="email" id="email" class="form-input"
                               placeholder="john.doe@company.com" required>
                        @error('email') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Phone -->
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" wire:model="phone" id="phone" class="form-input"
                               placeholder="+1234567890">
                        @error('phone') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Authentication -->
            <div class="form-section">
                <div class="section-header">
                    <h3 class="section-title">Authentication & Role</h3>
                    <p class="section-subtitle">Login credentials and system access</p>
                </div>

                <div class="form-grid">
                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label required">Password</label>
                        <input type="password" wire:model="password" id="password" class="form-input"
                               placeholder="Minimum 8 characters" required>
                        @error('password') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label required">Confirm Password</label>
                        <input type="password" wire:model="password_confirmation" id="password_confirmation" class="form-input"
                               placeholder="Confirm password" required>
                        @error('password_confirmation') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Role -->
                    <div class="form-group">
                        <label for="role" class="form-label required">Role</label>
                        <select wire:model="role" id="role" class="form-select" required>
                            @foreach($roles as $roleOption)
                                <option value="{{ $roleOption->name }}">{{ ucfirst($roleOption->name) }}</option>
                            @endforeach
                        </select>
                        @error('role') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <button type="button" onclick="history.back()" class="btn btn-outline">
                Cancel
            </button>
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                <span wire:loading.remove>
                    <span class="material-icons">save</span>
                    Create Employee
                </span>
                <span wire:loading>
                    <span class="material-icons spinning">refresh</span>
                    Creating...
                </span>
            </button>
        </div>
    </form>
</div>
