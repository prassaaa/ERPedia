<div>
<!-- Page Header -->
<div class="page-header">
    <div class="header-content">
        <div class="header-left">
            <h1 class="page-title">Products</h1>
            <p class="page-subtitle">Manage your product catalog and inventory</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <span class="material-icons">add</span>
                Add Product
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
                       placeholder="Search by name, SKU, barcode...">
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

        <!-- Category Filter -->
        <div class="filter-item">
            <label class="filter-label">Category</label>
            <select wire:model.live="category_filter" class="filter-select">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Type Filter -->
        <div class="filter-item">
            <label class="filter-label">Type</label>
            <select wire:model.live="type_filter" class="filter-select">
                <option value="">All Types</option>
                <option value="product">Product</option>
                <option value="service">Service</option>
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

<!-- Products Grid -->
<div class="products-container">
    <div class="products-header">
        <h3 class="products-title">Products ({{ $products->total() }})</h3>
    </div>

    <div class="products-grid">
        @forelse($products as $product)
            <div class="product-card">
                <div class="product-header">
                    <div class="product-image">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="image-preview">
                        @else
                            <div class="image-placeholder">
                                <span class="material-icons">
                                    {{ $product->type === 'service' ? 'miscellaneous_services' : 'inventory' }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="product-badges">
                        <span class="type-badge type-{{ $product->type }}">
                            {{ ucfirst($product->type) }}
                        </span>
                        <span class="status-badge status-{{ $product->is_active ? 'active' : 'inactive' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>

                <div class="product-body">
                    <h4 class="product-name">{{ $product->name }}</h4>
                    <p class="product-sku">SKU: {{ $product->sku }}</p>

                    @if($product->description)
                        <p class="product-description">{{ Str::limit($product->description, 80) }}</p>
                    @endif

                    <div class="product-info">
                        <div class="info-item">
                            <span class="material-icons">business</span>
                            <span>{{ $product->company->name }}</span>
                        </div>

                        <div class="info-item">
                            <span class="material-icons">category</span>
                            <span>{{ $product->category->name }}</span>
                        </div>

                        @if($product->barcode)
                            <div class="info-item">
                                <span class="material-icons">qr_code</span>
                                <span>{{ $product->barcode }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="product-pricing">
                        <div class="price-item">
                            <span class="price-label">Cost</span>
                            <span class="price-value">${{ number_format($product->cost_price, 2) }}</span>
                        </div>
                        <div class="price-item">
                            <span class="price-label">Selling</span>
                            <span class="price-value selling">${{ number_format($product->selling_price, 2) }}</span>
                        </div>
                        @if($product->cost_price > 0)
                            <div class="price-item">
                                <span class="price-label">Margin</span>
                                <span class="price-value margin">{{ number_format($product->profit_margin, 1) }}%</span>
                            </div>
                        @endif
                    </div>

                    @if($product->track_inventory)
                        <div class="product-stock">
                            <div class="stock-info">
                                <span class="stock-label">Min Stock:</span>
                                <span class="stock-value">{{ $product->minimum_stock }}</span>
                            </div>
                            <div class="stock-info">
                                <span class="stock-label">Max Stock:</span>
                                <span class="stock-value">{{ $product->maximum_stock }}</span>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="product-actions">
                    <a href="{{ route('products.show', $product) }}"
                       class="btn btn-sm btn-outline"
                       title="View Details">
                        <span class="material-icons">visibility</span>
                    </a>

                    <a href="{{ route('products.edit', $product) }}"
                       class="btn btn-sm btn-outline"
                       title="Edit Product">
                        <span class="material-icons">edit</span>
                    </a>

                    <button wire:click="toggleProductStatus({{ $product->id }})"
                            class="btn btn-sm btn-outline"
                            title="{{ $product->is_active ? 'Deactivate' : 'Activate' }} Product">
                        <span class="material-icons">
                            {{ $product->is_active ? 'toggle_on' : 'toggle_off' }}
                        </span>
                    </button>

                    <button wire:click="deleteProduct({{ $product->id }})"
                            class="btn btn-sm btn-outline btn-danger"
                            title="Delete Product"
                            onclick="return confirm('Are you sure you want to delete this product?')">
                        <span class="material-icons">delete</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-content">
                    <span class="material-icons empty-icon">inventory</span>
                    <h3>No products found</h3>
                    <p>No products match your current filters.</p>
                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        Add First Product
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="pagination-wrapper">
            {{ $products->links() }}
        </div>
    @endif
</div>
</div>
