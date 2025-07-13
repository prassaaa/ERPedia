<div>
<div class="department-edit">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-left">
                <h1 class="page-title">Edit Department</h1>
                <p class="page-subtitle">Update {{ $department->name }}'s information and settings</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('departments.show', $department) }}" class="btn btn-outline">
                    <span class="material-icons">visibility</span>
                    View Department
                </a>
                <a href="{{ route('departments.index') }}" class="btn btn-outline">
                    <span class="material-icons">arrow_back</span>
                    Back to Departments
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
    <form wire:submit="save" class="department-form">
        <div class="form-sections">
            <!-- Basic Information -->
            <div class="form-section">
                <div class="section-header">
                    <h3 class="section-title">Basic Information</h3>
                    <p class="section-subtitle">Department's basic details and organizational structure</p>
                </div>

                <div class="form-grid">
                    <!-- Company -->
                    <div class="form-group">
                        <label for="company_id" class="form-label required">Company</label>
                        <select wire:model.live="company_id" id="company_id" class="form-select" required>
                            <option value="">Select Company</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                        @error('company_id') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Parent Department -->
                    <div class="form-group">
                        <label for="parent_id" class="form-label">Parent Department</label>
                        <select wire:model="parent_id" id="parent_id" class="form-select">
                            <option value="">Root Department (No Parent)</option>
                            @foreach($parentDepartments as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                            @endforeach
                        </select>
                        @error('parent_id') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Department Name -->
                    <div class="form-group">
                        <label for="name" class="form-label required">Department Name</label>
                        <input type="text" wire:model="name" id="name" class="form-input"
                               placeholder="Human Resources" required>
                        @error('name') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Department Code -->
                    <div class="form-group">
                        <label for="code" class="form-label">Department Code</label>
                        <input type="text" wire:model="code" id="code" class="form-input"
                               placeholder="HR">
                        @error('code') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Manager -->
                    <div class="form-group">
                        <label for="manager_id" class="form-label">Department Manager</label>
                        <select wire:model="manager_id" id="manager_id" class="form-select">
                            <option value="">Select Manager</option>
                            @foreach($managers as $manager)
                                <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                            @endforeach
                        </select>
                        @error('manager_id') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label for="is_active" class="form-label">Status</label>
                        <select wire:model="is_active" id="is_active" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        @error('is_active') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-group form-group-full">
                        <label for="description" class="form-label">Description</label>
                        <textarea wire:model="description" id="description" class="form-textarea"
                                  placeholder="Brief description of the department" rows="3"></textarea>
                        @error('description') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="form-section">
                <div class="section-header">
                    <h3 class="section-title">Contact Information</h3>
                    <p class="section-subtitle">Department's contact details and location</p>
                </div>

                <div class="form-grid">
                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" wire:model="email" id="email" class="form-input"
                               placeholder="hr@company.com">
                        @error('email') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Phone -->
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" wire:model="phone" id="phone" class="form-input"
                               placeholder="+1234567890">
                        @error('phone') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Location -->
                    <div class="form-group form-group-full">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" wire:model="location" id="location" class="form-input"
                               placeholder="Building A, Floor 2">
                        @error('location') <span class="form-error">{{ $message }}</span> @enderror
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
                    Update Department
                </span>
                <span wire:loading>
                    <span class="material-icons spinning">refresh</span>
                    Updating...
                </span>
            </button>
        </div>
    </form>
</div>
</div>
