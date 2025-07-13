<div>
<div class="product-show">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-left">
                <div class="product-header-info">
                    <div class="product-header-details">
                        <div class="product-breadcrumb">
                            <span class="breadcrumb-item">{{ $product->company->name }}</span>
                            <span class="breadcrumb-separator">
                                <span class="material-icons">chevron_right</span>
                            </span>
                            <span class="breadcrumb-item">{{ $product->category->name }}</span>
                            <span class="breadcrumb-separator">
                                <span class="material-icons">chevron_right</span>
                            </span>
                            <span class="breadcrumb-item current">{{ $product->name }}</span>
                        </div>

                        <h1 class="page-title">{{ $product->name }}</h1>
                        <p class="page-subtitle">
                            SKU: {{ $product->sku }}
                            @if($product->barcode)
                                • Barcode: {{ $product->barcode }}
                            @endif
                        </p>
                        <div class="product-badges">
                            <span class="type-badge type-{{ $product->type }}">
                                {{ ucfirst($product->type) }}
                            </span>
                            <span class="status-badge status-{{ $product->is_active ? 'active' : 'inactive' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-actions">
                <button wire:click="toggleProductStatus"
                        class="btn btn-outline"
                        title="{{ $product->is_active ? 'Deactivate' : 'Activate' }} Product">
                    <span class="material-icons">
                        {{ $product->is_active ? 'toggle_on' : 'toggle_off' }}
                    </span>
                    {{ $product->is_active ? 'Deactivate' : 'Activate' }}
                </button>
                <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">
                    <span class="material-icons">edit</span>
                    Edit Product
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-outline">
                    <span class="material-icons">arrow_back</span>
                    Back to Products
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
            <!-- Product Image -->
            <div class="product-image-card">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="product-image">
                @else
                    <div class="product-image-placeholder">
                        <span class="material-icons">
                            {{ $product->type === 'service' ? 'miscellaneous_services' : 'inventory' }}
                        </span>
                        <p>No Image Available</p>
                    </div>
                @endif
            </div>

            <!-- Product Information Card -->
            <div class="info-card">
                <div class="card-header">
                    <h3 class="card-title">Product Information</h3>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <label class="info-label">Product Name</label>
                            <span class="info-value">{{ $product->name }}</span>
                        </div>

                        <div class="info-item">
                            <label class="info-label">SKU</label>
                            <span class="info-value">{{ $product->sku }}</span>
                        </div>

                        @if($product->barcode)
                        <div class="info-item">
                            <label class="info-label">Barcode</label>
                            <span class="info-value">{{ $product->barcode }}</span>
                        </div>
                        @endif

                        <div class="info-item">
                            <label class="info-label">Type</label>
                            <span class="info-value">
                                <span class="type-badge type-{{ $product->type }}">
                                    {{ ucfirst($product->type) }}
                                </span>
                            </span>
                        </div>

                        <div class="info-item">
                            <label class="info-label">Unit of Measure</label>
                            <span class="info-value">{{ $product->unit_of_measure }}</span>
                        </div>

                        <div class="info-item">
                            <label class="info-label">Company</label>
                            <span class="info-value">{{ $product->company->name }}</span>
                        </div>

                        <div class="info-item">
                            <label class="info-label">Category</label>
                            <span class="info-value">
                                <a href="{{ route('product-categories.show', $product->category) }}" class="category-link">
                                    {{ $product->category->name }}
                                </a>
                            </span>
                        </div>

                        <div class="info-item">
                            <label class="info-label">Status</label>
                            <span class="info-value">
                                <span class="status-badge status-{{ $product->is_active ? 'active' : 'inactive' }}">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </span>
                        </div>
                    </div>

                    @if($product->description)
                    <div class="description-section">
                        <label class="info-label">Description</label>
                        <p class="product-description">{{ $product->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="right-column">
            <!-- Pricing Card -->
            <div class="pricing-card">
                <div class="card-header">
                    <h3 class="card-title">Pricing Information</h3>
                </div>
                <div class="card-body">
                    <div class="pricing-grid">
                        <div class="price-item">
                            <div class="price-label">Cost Price</div>
                            <div class="price-value">${{ number_format($product->cost_price, 2) }}</div>
                        </div>

                        <div class="price-item">
                            <div class="price-label">Selling Price</div>
                            <div class="price-value selling">${{ number_format($product->selling_price, 2) }}</div>
                        </div>

                        @if($product->cost_price > 0)
                        <div class="price-item">
                            <div class="price-label">Profit Margin</div>
                            <div class="price-value margin">{{ number_format($product->profit_margin, 1) }}%</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Inventory Information (for Products) -->
            @if($product->type === 'product' && $product->track_inventory)
            <div class="inventory-card">
                <div class="card-header">
                    <h3 class="card-title">Inventory Information</h3>
                </div>
                <div class="card-body">
                    <div class="inventory-grid">
                        <div class="inventory-item">
                            <div class="inventory-label">Minimum Stock</div>
                            <div class="inventory-value">{{ $product->minimum_stock }}</div>
                        </div>

                        <div class="inventory-item">
                            <div class="inventory-label">Maximum Stock</div>
                            <div class="inventory-value">{{ $product->maximum_stock }}</div>
                        </div>

                        <div class="inventory-item">
                            <div class="inventory-label">Current Stock</div>
                            <div class="inventory-value">{{ $stats['current_stock'] }}</div>
                        </div>

                        <div class="inventory-item">
                            <div class="inventory-label">Available Stock</div>
                            <div class="inventory-value">{{ $stats['available_stock'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Physical Properties (for Products) -->
            @if($product->type === 'product' && ($product->weight || $product->dimensions))
            <div class="physical-card">
                <div class="card-header">
                    <h3 class="card-title">Physical Properties</h3>
                </div>
                <div class="card-body">
                    <div class="physical-grid">
                        @if($product->weight)
                        <div class="physical-item">
                            <div class="physical-label">Weight</div>
                            <div class="physical-value">{{ $product->weight }} kg</div>
                        </div>
                        @endif

                        @if($product->dimensions)
                        <div class="physical-item">
                            <div class="physical-label">Dimensions</div>
                            <div class="physical-value">{{ $product->dimensions }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
</div>
