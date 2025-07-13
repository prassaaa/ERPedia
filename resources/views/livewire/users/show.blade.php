<div>
<div class="user-show">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-left">
                <div class="user-header-info">
                    <img src="{{ $user->avatar ? Storage::url($user->avatar) : asset('assets/images/profile/user-1.jpg') }}"
                         alt="{{ $user->name }}"
                         class="user-header-avatar">
                    <div class="user-header-details">
                        <h1 class="page-title">{{ $user->name }}</h1>
                        <p class="page-subtitle">
                            {{ $user->getRoleNames()->first() ? ucfirst($user->getRoleNames()->first()) : 'Employee' }}
                            @if($user->department)
                                • {{ $user->department->name }}
                            @endif
                            @if($user->company)
                                • {{ $user->company->name }}
                            @endif
                        </p>
                        <div class="user-status">
                            <span class="status-badge status-{{ $user->employment_status }}">
                                {{ ucfirst($user->employment_status) }}
                            </span>
                            <span class="employment-type employment-type-{{ $user->employment_type }}">
                                {{ ucfirst(str_replace('_', ' ', $user->employment_type)) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-actions">
                <button wire:click="toggleUserStatus"
                        class="btn btn-outline"
                        title="{{ $user->is_active ? 'Deactivate' : 'Activate' }} User">
                    <span class="material-icons">
                        {{ $user->is_active ? 'toggle_on' : 'toggle_off' }}
                    </span>
                    {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                </button>
                <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
                    <span class="material-icons">edit</span>
                    Edit Employee
                </a>
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

    <!-- Content Grid -->
    <div class="content-grid">
        <!-- Left Column -->
        <div class="left-column">
            <!-- Personal Information Card -->
            <div class="info-card">
                <div class="card-header">
                    <h3 class="card-title">Personal Information</h3>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <label class="info-label">Employee ID</label>
                            <span class="info-value">{{ $user->employee_id ?: 'Not assigned' }}</span>
                        </div>

                        <div class="info-item">
                            <label class="info-label">Full Name</label>
                            <span class="info-value">
                                @if($user->first_name && $user->last_name)
                                    {{ $user->first_name }} {{ $user->last_name }}
                                @else
                                    {{ $user->name }}
                                @endif
                            </span>
                        </div>

                        <div class="info-item">
                            <label class="info-label">Email</label>
                            <span class="info-value">
                                <a href="mailto:{{ $user->email }}" class="email-link">{{ $user->email }}</a>
                            </span>
                        </div>

                        <div class="info-item">
                            <label class="info-label">Phone</label>
                            <span class="info-value">{{ $user->phone ?: 'Not provided' }}</span>
                        </div>

                        <div class="info-item">
                            <label class="info-label">Birth Date</label>
                            <span class="info-value">
                                {{ $user->birth_date ? $user->birth_date->format('M d, Y') : 'Not provided' }}
                            </span>
                        </div>

                        <div class="info-item">
                            <label class="info-label">Gender</label>
                            <span class="info-value">{{ $user->gender ? ucfirst($user->gender) : 'Not specified' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employment Information Card -->
            <div class="info-card">
                <div class="card-header">
                    <h3 class="card-title">Employment Information</h3>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <label class="info-label">Hire Date</label>
                            <span class="info-value">
                                {{ $user->hire_date ? $user->hire_date->format('M d, Y') : 'Not provided' }}
                            </span>
                        </div>

                        <div class="info-item">
                            <label class="info-label">Years of Service</label>
                            <span class="info-value">{{ $stats['years_of_service'] }} years</span>
                        </div>

                        <div class="info-item">
                            <label class="info-label">Employment Status</label>
                            <span class="info-value">
                                <span class="status-badge status-{{ $user->employment_status }}">
                                    {{ ucfirst($user->employment_status) }}
                                </span>
                            </span>
                        </div>

                        <div class="info-item">
                            <label class="info-label">Employment Type</label>
                            <span class="info-value">
                                <span class="employment-type employment-type-{{ $user->employment_type }}">
                                    {{ ucfirst(str_replace('_', ' ', $user->employment_type)) }}
                                </span>
                            </span>
                        </div>

                        <div class="info-item">
                            <label class="info-label">Department</label>
                            <span class="info-value">{{ $user->department->name ?? 'Not assigned' }}</span>
                        </div>

                        <div class="info-item">
                            <label class="info-label">Company</label>
                            <span class="info-value">{{ $user->company->name ?? 'Not assigned' }}</span>
                        </div>

                        @if($user->salary)
                        <div class="info-item">
                            <label class="info-label">Salary</label>
                            <span class="info-value">${{ number_format($user->salary, 2) }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
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
                                <span class="material-icons">event_available</span>
                            </div>
                            <div class="stat-content">
                                <span class="stat-number">{{ $stats['total_leave_requests'] }}</span>
                                <span class="stat-label">Total Leave Requests</span>
                            </div>
                        </div>

                        <div class="stat-item">
                            <div class="stat-icon bg-success">
                                <span class="material-icons">check_circle</span>
                            </div>
                            <div class="stat-content">
                                <span class="stat-number">{{ $stats['approved_leaves'] }}</span>
                                <span class="stat-label">Approved Leaves</span>
                            </div>
                        </div>

                        <div class="stat-item">
                            <div class="stat-icon bg-warning">
                                <span class="material-icons">pending</span>
                            </div>
                            <div class="stat-content">
                                <span class="stat-number">{{ $stats['pending_leaves'] }}</span>
                                <span class="stat-label">Pending Leaves</span>
                            </div>
                        </div>

                        <div class="stat-item">
                            <div class="stat-icon bg-info">
                                <span class="material-icons">work</span>
                            </div>
                            <div class="stat-content">
                                <span class="stat-number">{{ $stats['years_of_service'] }}</span>
                                <span class="stat-label">Years of Service</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
