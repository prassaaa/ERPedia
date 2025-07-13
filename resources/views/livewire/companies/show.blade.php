<div>
<div class="company-show">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-left">
                <div class="company-header-info">
                    <div class="company-logo">
                        @if($company->logo)
                            <img src="{{ Storage::url($company->logo) }}" alt="{{ $company->name }}" class="company-header-logo">
                        @else
                            <div class="logo-placeholder">
                                <span class="material-icons">business</span>
                            </div>
                        @endif
                    </div>
                    <div class="company-header-details">
                        <h1 class="page-title">{{ $company->name }}</h1>
                        <p class="page-subtitle">
                            @if($company->code)
                                {{ $company->code }} •
                            @endif
                            {{ $company->industry ?: 'Company' }}
                            @if($company->founded_year)
                                • Founded {{ $company->founded_year }}
                            @endif
                        </p>
                        <div class="company-status">
                            <span class="status-badge status-{{ $company->is_active ? 'active' : 'inactive' }}">
                                {{ $company->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-actions">
                <button wire:click="toggleCompanyStatus"
                        class="btn btn-outline"
                        title="{{ $company->is_active ? 'Deactivate' : 'Activate' }} Company">
                    <span class="material-icons">
                        {{ $company->is_active ? 'toggle_on' : 'toggle_off' }}
                    </span>
                    {{ $company->is_active ? 'Deactivate' : 'Activate' }}
                </button>
                <a href="{{ route('companies.edit', $company) }}" class="btn btn-primary">
                    <span class="material-icons">edit</span>
                    Edit Company
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

    <!-- Content Grid -->
    <div class="content-grid">
        <!-- Left Column -->
        <div class="left-column">
            <!-- Company Information Card -->
            <div class="info-card">
                <div class="card-header">
                    <h3 class="card-title">Company Information</h3>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <label class="info-label">Company Name</label>
                            <span class="info-value">{{ $company->name }}</span>
                        </div>

                        @if($company->code)
                        <div class="info-item">
                            <label class="info-label">Company Code</label>
                            <span class="info-value">{{ $company->code }}</span>
                        </div>
                        @endif

                        @if($company->email)
                        <div class="info-item">
                            <label class="info-label">Email</label>
                            <span class="info-value">
                                <a href="mailto:{{ $company->email }}" class="email-link">{{ $company->email }}</a>
                            </span>
                        </div>
                        @endif

                        @if($company->phone)
                        <div class="info-item">
                            <label class="info-label">Phone</label>
                            <span class="info-value">{{ $company->phone }}</span>
                        </div>
                        @endif

                        @if($company->website)
                        <div class="info-item">
                            <label class="info-label">Website</label>
                            <span class="info-value">
                                <a href="{{ $company->website }}" target="_blank" class="website-link">
                                    {{ parse_url($company->website, PHP_URL_HOST) }}
                                </a>
                            </span>
                        </div>
                        @endif

                        @if($company->industry)
                        <div class="info-item">
                            <label class="info-label">Industry</label>
                            <span class="info-value">{{ $company->industry }}</span>
                        </div>
                        @endif

                        @if($company->founded_year)
                        <div class="info-item">
                            <label class="info-label">Founded Year</label>
                            <span class="info-value">{{ $company->founded_year }}</span>
                        </div>
                        @endif

                        <div class="info-item">
                            <label class="info-label">Status</label>
                            <span class="info-value">
                                <span class="status-badge status-{{ $company->is_active ? 'active' : 'inactive' }}">
                                    {{ $company->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </span>
                        </div>
                    </div>

                    @if($company->description)
                    <div class="description-section">
                        <label class="info-label">Description</label>
                        <p class="company-description">{{ $company->description }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Address Information Card -->
            @if($company->address || $company->city || $company->state || $company->country)
            <div class="info-card">
                <div class="card-header">
                    <h3 class="card-title">Address Information</h3>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        @if($company->address)
                        <div class="info-item info-item-full">
                            <label class="info-label">Address</label>
                            <span class="info-value">{{ $company->address }}</span>
                        </div>
                        @endif

                        @if($company->city)
                        <div class="info-item">
                            <label class="info-label">City</label>
                            <span class="info-value">{{ $company->city }}</span>
                        </div>
                        @endif

                        @if($company->state)
                        <div class="info-item">
                            <label class="info-label">State/Province</label>
                            <span class="info-value">{{ $company->state }}</span>
                        </div>
                        @endif

                        @if($company->country)
                        <div class="info-item">
                            <label class="info-label">Country</label>
                            <span class="info-value">{{ $company->country }}</span>
                        </div>
                        @endif

                        @if($company->postal_code)
                        <div class="info-item">
                            <label class="info-label">Postal Code</label>
                            <span class="info-value">{{ $company->postal_code }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Business Information Card -->
            @if($company->tax_number || $company->registration_number)
            <div class="info-card">
                <div class="card-header">
                    <h3 class="card-title">Business Information</h3>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        @if($company->tax_number)
                        <div class="info-item">
                            <label class="info-label">Tax Number</label>
                            <span class="info-value">{{ $company->tax_number }}</span>
                        </div>
                        @endif

                        @if($company->registration_number)
                        <div class="info-item">
                            <label class="info-label">Registration Number</label>
                            <span class="info-value">{{ $company->registration_number }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column -->
        <div class="right-column">
            <!-- Statistics Card -->
            <div class="stats-card">
                <div class="card-header">
                    <h3 class="card-title">Statistics</h3>
                </div>
                <div class="card-body">
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-icon bg-primary">
                                <span class="material-icons">people</span>
                            </div>
                            <div class="stat-content">
                                <span class="stat-number">{{ $stats['total_employees'] }}</span>
                                <span class="stat-label">Total Employees</span>
                            </div>
                        </div>

                        <div class="stat-item">
                            <div class="stat-icon bg-success">
                                <span class="material-icons">person_check</span>
                            </div>
                            <div class="stat-content">
                                <span class="stat-number">{{ $stats['active_employees'] }}</span>
                                <span class="stat-label">Active Employees</span>
                            </div>
                        </div>

                        <div class="stat-item">
                            <div class="stat-icon bg-info">
                                <span class="material-icons">corporate_fare</span>
                            </div>
                            <div class="stat-content">
                                <span class="stat-number">{{ $stats['total_departments'] }}</span>
                                <span class="stat-label">Total Departments</span>
                            </div>
                        </div>

                        <div class="stat-item">
                            <div class="stat-icon bg-warning">
                                <span class="material-icons">domain</span>
                            </div>
                            <div class="stat-content">
                                <span class="stat-number">{{ $stats['active_departments'] }}</span>
                                <span class="stat-label">Active Departments</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
