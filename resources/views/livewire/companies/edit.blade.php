<div class="company-edit">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-left">
                <h1 class="page-title">Edit Company</h1>
                <p class="page-subtitle">Update {{ $company->name }}'s information and settings</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('companies.show', $company) }}" class="btn btn-outline">
                    <span class="material-icons">visibility</span>
                    View Company
                </a>
                <a href="{{ route('companies.index') }}" class="btn btn-outline">
                    <span class="material-icons">arrow_back</span>
                    Back to Companies
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
    <form wire:submit="save" class="company-form">
        <div class="form-sections">
            <!-- Basic Information -->
            <div class="form-section">
                <div class="section-header">
                    <h3 class="section-title">Basic Information</h3>
                    <p class="section-subtitle">Company's basic details and contact information</p>
                </div>

                <div class="form-grid">
                    <!-- Company Name -->
                    <div class="form-group">
                        <label for="name" class="form-label required">Company Name</label>
                        <input type="text" wire:model="name" id="name" class="form-input"
                               placeholder="Acme Corporation" required>
                        @error('name') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Company Code -->
                    <div class="form-group">
                        <label for="code" class="form-label">Company Code</label>
                        <input type="text" wire:model="code" id="code" class="form-input"
                               placeholder="ACME01">
                        @error('code') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" wire:model="email" id="email" class="form-input"
                               placeholder="info@company.com">
                        @error('email') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Phone -->
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" wire:model="phone" id="phone" class="form-input"
                               placeholder="+1234567890">
                        @error('phone') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Website -->
                    <div class="form-group">
                        <label for="website" class="form-label">Website</label>
                        <input type="url" wire:model="website" id="website" class="form-input"
                               placeholder="https://company.com">
                        @error('website') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Industry -->
                    <div class="form-group">
                        <label for="industry" class="form-label">Industry</label>
                        <input type="text" wire:model="industry" id="industry" class="form-input"
                               placeholder="Technology">
                        @error('industry') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Founded Year -->
                    <div class="form-group">
                        <label for="founded_year" class="form-label">Founded Year</label>
                        <input type="number" wire:model="founded_year" id="founded_year" class="form-input"
                               placeholder="2020" min="1800" max="{{ date('Y') }}">
                        @error('founded_year') <span class="form-error">{{ $message }}</span> @enderror
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
                                  placeholder="Brief description of the company" rows="3"></textarea>
                        @error('description') <span class="form-error">{{ $message }}</span> @enderror
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
                    Update Company
                </span>
                <span wire:loading>
                    <span class="material-icons spinning">refresh</span>
                    Updating...
                </span>
            </button>
        </div>
    </form>
</div>
