<div class="users-index">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-left">
                <h1 class="page-title">Employee Management</h1>
                <p class="page-subtitle">Manage your company employees and their information</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    <span class="material-icons">add</span>
                    Add Employee
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
                           placeholder="Search by name, email, or employee ID...">
                </div>
            </div>

            <!-- Company Filter -->
            <div class="filter-item">
                <label class="filter-label">Company</label>
                <select wire:model.live="company_filter" class="filter-select">
                    <option value="">All Companies</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Department Filter -->
            <div class="filter-item">
                <label class="filter-label">Department</label>
                <select wire:model.live="department_filter" class="filter-select">
                    <option value="">All Departments</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div class="filter-item">
                <label class="filter-label">Status</label>
                <select wire:model.live="status_filter" class="filter-select">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="terminated">Terminated</option>
                    <option value="resigned">Resigned</option>
                </select>
            </div>

            <!-- Employment Type Filter -->
            <div class="filter-item">
                <label class="filter-label">Employment Type</label>
                <select wire:model.live="employment_type_filter" class="filter-select">
                    <option value="">All Types</option>
                    <option value="full_time">Full Time</option>
                    <option value="part_time">Part Time</option>
                    <option value="contract">Contract</option>
                    <option value="intern">Intern</option>
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

    <!-- Users Table -->
    <div class="table-container">
        <div class="table-header">
            <h3 class="table-title">Employees ({{ $users->total() }})</h3>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th wire:click="sortBy('employee_id')" class="sortable">
                            Employee ID
                            @if($sortField === 'employee_id')
                                <span class="material-icons sort-icon">
                                    {{ $sortDirection === 'asc' ? 'keyboard_arrow_up' : 'keyboard_arrow_down' }}
                                </span>
                            @endif
                        </th>
                        <th wire:click="sortBy('name')" class="sortable">
                            Name
                            @if($sortField === 'name')
                                <span class="material-icons sort-icon">
                                    {{ $sortDirection === 'asc' ? 'keyboard_arrow_up' : 'keyboard_arrow_down' }}
                                </span>
                            @endif
                        </th>
                        <th wire:click="sortBy('email')" class="sortable">
                            Email
                            @if($sortField === 'email')
                                <span class="material-icons sort-icon">
                                    {{ $sortDirection === 'asc' ? 'keyboard_arrow_up' : 'keyboard_arrow_down' }}
                                </span>
                            @endif
                        </th>
                        <th>Department</th>
                        <th>Employment Type</th>
                        <th>Status</th>
                        <th wire:click="sortBy('hire_date')" class="sortable">
                            Hire Date
                            @if($sortField === 'hire_date')
                                <span class="material-icons sort-icon">
                                    {{ $sortDirection === 'asc' ? 'keyboard_arrow_up' : 'keyboard_arrow_down' }}
                                </span>
                            @endif
                        </th>
                        <th class="actions-column">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <span class="employee-id">{{ $user->employee_id }}</span>
                            </td>
                            <td>
                                <div class="user-info">
                                    <img src="{{ $user->avatar ?? asset('assets/images/profile/user-1.jpg') }}"
                                         alt="{{ $user->name }}"
                                         class="user-avatar">
                                    <div class="user-details">
                                        <span class="user-name">{{ $user->name }}</span>
                                        @if($user->first_name && $user->last_name)
                                            <span class="user-full-name">{{ $user->first_name }} {{ $user->last_name }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="user-email">{{ $user->email }}</span>
                            </td>
                            <td>
                                @if($user->department)
                                    <span class="department-name">{{ $user->department->name }}</span>
                                @else
                                    <span class="text-muted">No Department</span>
                                @endif
                            </td>
                            <td>
                                <span class="employment-type employment-type-{{ $user->employment_type }}">
                                    {{ ucfirst(str_replace('_', ' ', $user->employment_type)) }}
                                </span>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $user->employment_status }}">
                                    {{ ucfirst($user->employment_status) }}
                                </span>
                            </td>
                            <td>
                                @if($user->hire_date)
                                    <span class="hire-date">{{ $user->hire_date->format('M d, Y') }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="actions-column">
                                <div class="action-buttons">
                                    <a href="{{ route('users.show', $user) }}"
                                       class="btn btn-sm btn-outline"
                                       title="View Details">
                                        <span class="material-icons">visibility</span>
                                    </a>

                                    <a href="{{ route('users.edit', $user) }}"
                                       class="btn btn-sm btn-outline"
                                       title="Edit User">
                                        <span class="material-icons">edit</span>
                                    </a>

                                    <button wire:click="toggleUserStatus({{ $user->id }})"
                                            class="btn btn-sm btn-outline"
                                            title="{{ $user->is_active ? 'Deactivate' : 'Activate' }} User">
                                        <span class="material-icons">
                                            {{ $user->is_active ? 'toggle_on' : 'toggle_off' }}
                                        </span>
                                    </button>

                                    @if($user->id !== auth()->id())
                                        <button wire:click="deleteUser({{ $user->id }})"
                                                class="btn btn-sm btn-outline btn-danger"
                                                title="Delete User"
                                                onclick="return confirm('Are you sure you want to delete this user?')">
                                            <span class="material-icons">delete</span>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty-state">
                                <div class="empty-content">
                                    <span class="material-icons empty-icon">people</span>
                                    <h3>No employees found</h3>
                                    <p>No employees match your current filters.</p>
                                    <a href="{{ route('users.create') }}" class="btn btn-primary">
                                        Add First Employee
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="pagination-wrapper">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
