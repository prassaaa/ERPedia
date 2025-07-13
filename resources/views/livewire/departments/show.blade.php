<div>
<div class="department-show">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-left">
                <div class="department-header-info">
                    <div class="department-header-details">
                        <!-- Breadcrumb -->
                        <div class="department-breadcrumb">
                            @foreach($hierarchy as $index => $dept)
                                @if($index > 0)
                                    <span class="breadcrumb-separator">
                                        <span class="material-icons">chevron_right</span>
                                    </span>
                                @endif
                                <span class="breadcrumb-item {{ $dept->id === $department->id ? 'current' : '' }}">
                                    {{ $dept->name }}
                                </span>
                            @endforeach
                        </div>

                        <h1 class="page-title">{{ $department->name }}</h1>
                        <p class="page-subtitle">
                            {{ $department->company->name }}
                            @if($department->code)
                                • {{ $department->code }}
                            @endif
                            @if($department->location)
                                • {{ $department->location }}
                            @endif
                        </p>
                        <div class="department-status">
                            <span class="status-badge status-{{ $department->is_active ? 'active' : 'inactive' }}">
                                {{ $department->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-actions">
                <button wire:click="toggleDepartmentStatus"
                        class="btn btn-outline"
                        title="{{ $department->is_active ? 'Deactivate' : 'Activate' }} Department">
                    <span class="material-icons">
                        {{ $department->is_active ? 'toggle_on' : 'toggle_off' }}
                    </span>
                    {{ $department->is_active ? 'Deactivate' : 'Activate' }}
                </button>
                <a href="{{ route('departments.edit', $department) }}" class="btn btn-primary">
                    <span class="material-icons">edit</span>
                    Edit Department
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

    <!-- Content Grid -->
    <div class="content-grid">
        <!-- Left Column -->
        <div class="left-column">
            <!-- Department Information Card -->
            <div class="info-card">
                <div class="card-header">
                    <h3 class="card-title">Department Information</h3>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <label class="info-label">Department Name</label>
                            <span class="info-value">{{ $department->name }}</span>
                        </div>

                        @if($department->code)
                        <div class="info-item">
                            <label class="info-label">Department Code</label>
                            <span class="info-value">{{ $department->code }}</span>
                        </div>
                        @endif

                        <div class="info-item">
                            <label class="info-label">Company</label>
                            <span class="info-value">{{ $department->company->name }}</span>
                        </div>

                        <div class="info-item">
                            <label class="info-label">Parent Department</label>
                            <span class="info-value">
                                @if($department->parent)
                                    <a href="{{ route('departments.show', $department->parent) }}" class="parent-link">
                                        {{ $department->parent->name }}
                                    </a>
                                @else
                                    <span class="text-muted">Root Department</span>
                                @endif
                            </span>
                        </div>

                        @if($department->manager)
                        <div class="info-item">
                            <label class="info-label">Manager</label>
                            <span class="info-value">
                                <a href="{{ route('users.show', $department->manager) }}" class="manager-link">
                                    {{ $department->manager->name }}
                                </a>
                            </span>
                        </div>
                        @endif

                        <div class="info-item">
                            <label class="info-label">Status</label>
                            <span class="info-value">
                                <span class="status-badge status-{{ $department->is_active ? 'active' : 'inactive' }}">
                                    {{ $department->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </span>
                        </div>
                    </div>

                    @if($department->description)
                    <div class="description-section">
                        <label class="info-label">Description</label>
                        <p class="department-description">{{ $department->description }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Contact Information Card -->
            @if($department->email || $department->phone || $department->location)
            <div class="info-card">
                <div class="card-header">
                    <h3 class="card-title">Contact Information</h3>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        @if($department->email)
                        <div class="info-item">
                            <label class="info-label">Email</label>
                            <span class="info-value">
                                <a href="mailto:{{ $department->email }}" class="email-link">{{ $department->email }}</a>
                            </span>
                        </div>
                        @endif

                        @if($department->phone)
                        <div class="info-item">
                            <label class="info-label">Phone</label>
                            <span class="info-value">{{ $department->phone }}</span>
                        </div>
                        @endif

                        @if($department->location)
                        <div class="info-item info-item-full">
                            <label class="info-label">Location</label>
                            <span class="info-value">{{ $department->location }}</span>
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
                                <span class="stat-number">{{ $stats['child_departments'] }}</span>
                                <span class="stat-label">Sub Departments</span>
                            </div>
                        </div>

                        <div class="stat-item">
                            <div class="stat-icon bg-warning">
                                <span class="material-icons">domain</span>
                            </div>
                            <div class="stat-content">
                                <span class="stat-number">{{ $stats['active_children'] }}</span>
                                <span class="stat-label">Active Sub Depts</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
