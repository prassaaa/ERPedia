<div>
<!-- Page Header -->
<div class="page-header">
    <div class="header-content">
        <div class="header-left">
            <h1 class="page-title">Product Categories</h1>
            <p class="page-subtitle">Manage product categories and hierarchical structure</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('product-categories.create') }}" class="btn btn-primary">
                <span class="material-icons">add</span>
                Add Category
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

<!-- Categories Grid -->
<div class="categories-container">
    <div class="categories-header">
        <h3 class="categories-title">Categories ({{ $categories->total() }})</h3>
    </div>

    <div class="categories-grid">
        @forelse($categories as $category)
            <div class="category-card">
                <div class="category-header">
                    <div class="category-image">
                        @if($category->image)
                            <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="image-preview">
                        @else
                            <div class="image-placeholder">
                                <span class="material-icons">category</span>
                            </div>
                        @endif
                    </div>
                    <div class="category-status">
                        <span class="status-badge status-{{ $category->is_active ? 'active' : 'inactive' }}">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>

                <div class="category-body">
                    <h4 class="category-name">{{ $category->name }}</h4>
                    @if($category->code)
                        <p class="category-code">{{ $category->code }}</p>
                    @endif

                    @if($category->description)
                        <p class="category-description">{{ Str::limit($category->description, 100) }}</p>
                    @endif

                    <div class="category-info">
                        <div class="info-item">
                            <span class="material-icons">business</span>
                            <span>{{ $category->company->name }}</span>
                        </div>

                        @if($category->parent)
                            <div class="info-item">
                                <span class="material-icons">folder</span>
                                <span>{{ $category->parent->name }}</span>
                            </div>
                        @else
                            <div class="info-item">
                                <span class="material-icons">folder_open</span>
                                <span>Root Category</span>
                            </div>
                        @endif
                    </div>

                    <div class="category-stats">
                        <div class="stat-item">
                            <span class="stat-number">{{ $category->products_count }}</span>
                            <span class="stat-label">Products</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">{{ $category->children_count }}</span>
                            <span class="stat-label">Sub Categories</span>
                        </div>
                    </div>
                </div>

                <div class="category-actions">
                    <a href="{{ route('product-categories.show', $category) }}"
                       class="btn btn-sm btn-outline"
                       title="View Details">
                        <span class="material-icons">visibility</span>
                    </a>

                    <a href="{{ route('product-categories.edit', $category) }}"
                       class="btn btn-sm btn-outline"
                       title="Edit Category">
                        <span class="material-icons">edit</span>
                    </a>

                    <button wire:click="toggleCategoryStatus({{ $category->id }})"
                            class="btn btn-sm btn-outline"
                            title="{{ $category->is_active ? 'Deactivate' : 'Activate' }} Category">
                        <span class="material-icons">
                            {{ $category->is_active ? 'toggle_on' : 'toggle_off' }}
                        </span>
                    </button>

                    <button wire:click="deleteCategory({{ $category->id }})"
                            class="btn btn-sm btn-outline btn-danger"
                            title="Delete Category"
                            onclick="return confirm('Are you sure you want to delete this category?')">
                        <span class="material-icons">delete</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-content">
                    <span class="material-icons empty-icon">category</span>
                    <h3>No categories found</h3>
                    <p>No categories match your current filters.</p>
                    <a href="{{ route('product-categories.create') }}" class="btn btn-primary">
                        Add First Category
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($categories->hasPages())
        <div class="pagination-wrapper">
            {{ $categories->links() }}
        </div>
    @endif
</div>
</div>
