<div class="companies-index">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-left">
                <h1 class="page-title">Company Management</h1>
                <p class="page-subtitle">Manage companies and their information</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('companies.create') }}" class="btn btn-primary">
                    <span class="material-icons">add</span>
                    Add Company
                </a>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
        <div class="filters-grid">
            <!-- Search -->
            <div class="filter-item">
                <label class="filter-label">Search</label>
                <div class="search-input-wrapper">
                    <span class="material-icons search-icon">search</span>
                    <input type="text"
                           wire:model.live.debounce.300ms="search"
                           class="search-input"
                           placeholder="Search by name, code, email, or website...">
                </div>
            </div>

            <!-- Status Filter -->
            <div class="filter-item">
                <label class="filter-label">Status</label>
                <select wire:model.live="status_filter" class="filter-select">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <!-- Country Filter -->
            <div class="filter-item">
                <label class="filter-label">Country</label>
                <select wire:model.live="country_filter" class="filter-select">
                    <option value="">All Countries</option>
                    @foreach($countries as $country)
                        <option value="{{ $country }}">{{ $country }}</option>
                    @endforeach
                </select>
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

    <!-- Companies Grid -->
    <div class="companies-container">
        <div class="companies-header">
            <h3 class="companies-title">Companies ({{ $companies->total() }})</h3>
        </div>

        <div class="companies-grid">
            @forelse($companies as $company)
                <div class="company-card">
                    <div class="company-header">
                        <div class="company-logo">
                            @if($company->logo)
                                <img src="{{ Storage::url($company->logo) }}" alt="{{ $company->name }}" class="logo-image">
                            @else
                                <div class="logo-placeholder">
                                    <span class="material-icons">business</span>
                                </div>
                            @endif
                        </div>
                        <div class="company-status">
                            <span class="status-badge status-{{ $company->is_active ? 'active' : 'inactive' }}">
                                {{ $company->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>

                    <div class="company-body">
                        <h4 class="company-name">{{ $company->name }}</h4>
                        <p class="company-code">{{ $company->code }}</p>

                        @if($company->description)
                            <p class="company-description">{{ Str::limit($company->description, 100) }}</p>
                        @endif

                        <div class="company-info">
                            @if($company->email)
                                <div class="info-item">
                                    <span class="material-icons">email</span>
                                    <span>{{ $company->email }}</span>
                                </div>
                            @endif

                            @if($company->phone)
                                <div class="info-item">
                                    <span class="material-icons">phone</span>
                                    <span>{{ $company->phone }}</span>
                                </div>
                            @endif

                            @if($company->website)
                                <div class="info-item">
                                    <span class="material-icons">language</span>
                                    <a href="{{ $company->website }}" target="_blank" class="website-link">
                                        {{ parse_url($company->website, PHP_URL_HOST) }}
                                    </a>
                                </div>
                            @endif

                            @if($company->city && $company->country)
                                <div class="info-item">
                                    <span class="material-icons">location_on</span>
                                    <span>{{ $company->city }}, {{ $company->country }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="company-stats">
                            <div class="stat-item">
                                <span class="stat-number">{{ $company->users_count }}</span>
                                <span class="stat-label">Employees</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">{{ $company->departments_count }}</span>
                                <span class="stat-label">Departments</span>
                            </div>
                        </div>
                    </div>

                    <div class="company-actions">
                        <a href="{{ route('companies.show', $company) }}"
                           class="btn btn-sm btn-outline"
                           title="View Details">
                            <span class="material-icons">visibility</span>
                        </a>

                        <a href="{{ route('companies.edit', $company) }}"
                           class="btn btn-sm btn-outline"
                           title="Edit Company">
                            <span class="material-icons">edit</span>
                        </a>

                        <button wire:click="toggleCompanyStatus({{ $company->id }})"
                                class="btn btn-sm btn-outline"
                                title="{{ $company->is_active ? 'Deactivate' : 'Activate' }} Company">
                            <span class="material-icons">
                                {{ $company->is_active ? 'toggle_on' : 'toggle_off' }}
                            </span>
                        </button>

                        <button wire:click="deleteCompany({{ $company->id }})"
                                class="btn btn-sm btn-outline btn-danger"
                                title="Delete Company"
                                onclick="return confirm('Are you sure you want to delete this company?')">
                            <span class="material-icons">delete</span>
                        </button>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-content">
                        <span class="material-icons empty-icon">business</span>
                        <h3>No companies found</h3>
                        <p>No companies match your current filters.</p>
                        <a href="{{ route('companies.create') }}" class="btn btn-primary">
                            Add First Company
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($companies->hasPages())
            <div class="pagination-wrapper">
                {{ $companies->links() }}
            </div>
        @endif
    </div>
</div>
