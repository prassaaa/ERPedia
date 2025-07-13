<div>
<!-- Page Header -->
<div class="page-header">
    <div class="header-content">
        <div class="header-left">
            <h1 class="page-title">Department Management</h1>
            <p class="page-subtitle">Manage departments and organizational structure</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('departments.create') }}" class="btn btn-primary">
                <span class="material-icons">add</span>
                Add Department
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
                       placeholder="Search by name, code, or description...">
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

        <!-- Status Filter -->
        <div class="filter-item">
            <label class="filter-label">Status</label>
            <select wire:model.live="status_filter" class="filter-select">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
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

<!-- Departments Table -->
<div class="table-container">
    <div class="table-header">
        <h3 class="table-title">Departments ({{ $departments->total() }})</h3>
    </div>

    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th wire:click="sortBy('name')" class="sortable">
                        Name
                        @if($sortField === 'name')
                            <span class="material-icons sort-icon">
                                {{ $sortDirection === 'asc' ? 'keyboard_arrow_up' : 'keyboard_arrow_down' }}
                            </span>
                        @endif
                    </th>
                    <th wire:click="sortBy('code')" class="sortable">
                        Code
                        @if($sortField === 'code')
                            <span class="material-icons sort-icon">
                                {{ $sortDirection === 'asc' ? 'keyboard_arrow_up' : 'keyboard_arrow_down' }}
                            </span>
                        @endif
                    </th>
                    <th>Company</th>
                    <th>Parent Department</th>
                    <th>Employees</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departments as $department)
                    <tr>
                        <td>
                            <div class="department-info">
                                <span class="department-name">{{ $department->name }}</span>
                                @if($department->description)
                                    <span class="department-description">{{ Str::limit($department->description, 50) }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($department->code)
                                <span class="department-code">{{ $department->code }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="company-name">{{ $department->company->name }}</span>
                        </td>
                        <td>
                            @if($department->parent)
                                <span class="parent-department">{{ $department->parent->name }}</span>
                            @else
                                <span class="text-muted">Root Department</span>
                            @endif
                        </td>
                        <td>
                            <span class="employee-count">{{ $department->users_count }}</span>
                        </td>
                        <td>
                            <span class="status-badge status-{{ $department->is_active ? 'active' : 'inactive' }}">
                                {{ $department->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('departments.show', $department) }}"
                                   class="btn btn-sm btn-outline"
                                   title="View Details">
                                    <span class="material-icons">visibility</span>
                                </a>

                                <a href="{{ route('departments.edit', $department) }}"
                                   class="btn btn-sm btn-outline"
                                   title="Edit Department">
                                    <span class="material-icons">edit</span>
                                </a>

                                <button wire:click="toggleDepartmentStatus({{ $department->id }})"
                                        class="btn btn-sm btn-outline"
                                        title="{{ $department->is_active ? 'Deactivate' : 'Activate' }} Department">
                                    <span class="material-icons">
                                        {{ $department->is_active ? 'toggle_on' : 'toggle_off' }}
                                    </span>
                                </button>

                                <button wire:click="deleteDepartment({{ $department->id }})"
                                        class="btn btn-sm btn-outline btn-danger"
                                        title="Delete Department"
                                        onclick="return confirm('Are you sure you want to delete this department?')">
                                    <span class="material-icons">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-state">
                            <div class="empty-content">
                                <span class="material-icons empty-icon">corporate_fare</span>
                                <h3>No departments found</h3>
                                <p>No departments match your current filters.</p>
                                <a href="{{ route('departments.create') }}" class="btn btn-primary">
                                    Add First Department
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($departments->hasPages())
        <div class="pagination-wrapper">
            {{ $departments->links() }}
        </div>
    @endif
</div>
</div>
