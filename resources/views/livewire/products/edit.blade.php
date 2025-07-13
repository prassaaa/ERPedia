<div>
<div class="product-edit">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-left">
                <h1 class="page-title">Edit Product</h1>
                <p class="page-subtitle">Update {{ $product->name }}'s information and specifications</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('products.show', $product) }}" class="btn btn-outline">
                    <span class="material-icons">visibility</span>
                    View Product
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

    @if (session()->has('error'))
        <div class="alert alert-error">
            <span class="material-icons">error</span>
            {{ session('error') }}
        </div>
    @endif

    <!-- Form -->
    <form wire:submit="save" class="product-form" enctype="multipart/form-data">
        <div class="form-sections">
            <!-- Basic Information -->
            <div class="form-section">
                <div class="section-header">
                    <h3 class="section-title">Basic Information</h3>
                    <p class="section-subtitle">Product's basic details and categorization</p>
                </div>

                <div class="form-grid">
                    <!-- Company -->
                    <div class="form-group">
                        <label for="company_id" class="form-label required">Company</label>
                        <select wire:model.live="company_id" id="company_id" class="form-select" required>
                            <option value="">Select Company</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                        @error('company_id') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Category -->
                    <div class="form-group">
                        <label for="category_id" class="form-label required">Category</label>
                        <select wire:model="category_id" id="category_id" class="form-select" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Product Name -->
                    <div class="form-group">
                        <label for="name" class="form-label required">Product Name</label>
                        <input type="text" wire:model="name" id="name" class="form-input"
                               placeholder="iPhone 15 Pro" required>
                        @error('name') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- SKU -->
                    <div class="form-group">
                        <label for="sku" class="form-label required">SKU</label>
                        <input type="text" wire:model="sku" id="sku" class="form-input"
                               placeholder="IPH15PRO001" required>
                        @error('sku') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Barcode -->
                    <div class="form-group">
                        <label for="barcode" class="form-label">Barcode</label>
                        <input type="text" wire:model="barcode" id="barcode" class="form-input"
                               placeholder="1234567890123">
                        @error('barcode') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Type -->
                    <div class="form-group">
                        <label for="type" class="form-label required">Type</label>
                        <select wire:model.live="type" id="type" class="form-select" required>
                            <option value="product">Physical Product</option>
                            <option value="service">Service</option>
                        </select>
                        @error('type') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Unit of Measure -->
                    <div class="form-group">
                        <label for="unit_of_measure" class="form-label required">Unit of Measure</label>
                        <select wire:model="unit_of_measure" id="unit_of_measure" class="form-select" required>
                            <option value="pcs">Pieces (pcs)</option>
                            <option value="kg">Kilogram (kg)</option>
                            <option value="g">Gram (g)</option>
                            <option value="l">Liter (l)</option>
                            <option value="ml">Milliliter (ml)</option>
                            <option value="m">Meter (m)</option>
                            <option value="cm">Centimeter (cm)</option>
                            <option value="box">Box</option>
                            <option value="pack">Pack</option>
                            <option value="set">Set</option>
                            <option value="hour">Hour</option>
                            <option value="day">Day</option>
                        </select>
                        @error('unit_of_measure') <span class="form-error">{{ $message }}</span> @enderror
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
                                  placeholder="Detailed product description" rows="3"></textarea>
                        @error('description') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Pricing Information -->
            <div class="form-section">
                <div class="section-header">
                    <h3 class="section-title">Pricing Information</h3>
                    <p class="section-subtitle">Cost and selling price details</p>
                </div>

                <div class="form-grid">
                    <!-- Cost Price -->
                    <div class="form-group">
                        <label for="cost_price" class="form-label required">Cost Price</label>
                        <div class="input-group">
                            <span class="input-prefix">$</span>
                            <input type="number" wire:model="cost_price" id="cost_price" class="form-input"
                                   placeholder="0.00" step="0.01" min="0" required>
                        </div>
                        @error('cost_price') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Selling Price -->
                    <div class="form-group">
                        <label for="selling_price" class="form-label required">Selling Price</label>
                        <div class="input-group">
                            <span class="input-prefix">$</span>
                            <input type="number" wire:model="selling_price" id="selling_price" class="form-input"
                                   placeholder="0.00" step="0.01" min="0" required>
                        </div>
                        @error('selling_price') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Profit Margin (Calculated) -->
                    @if($cost_price > 0 && $selling_price > 0)
                        <div class="form-group">
                            <label class="form-label">Profit Margin</label>
                            <div class="calculated-field">
                                <span class="calculated-value">
                                    {{ number_format((($selling_price - $cost_price) / $cost_price) * 100, 2) }}%
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Inventory Management -->
            @if($type === 'product')
                <div class="form-section">
                    <div class="section-header">
                        <h3 class="section-title">Inventory Management</h3>
                        <p class="section-subtitle">Stock levels and inventory tracking</p>
                    </div>

                    <div class="form-grid">
                        <!-- Track Inventory -->
                        <div class="form-group form-group-full">
                            <label class="checkbox-label">
                                <input type="checkbox" wire:model="track_inventory" class="form-checkbox">
                                <span class="checkbox-text">Track inventory for this product</span>
                            </label>
                            @error('track_inventory') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        @if($track_inventory)
                            <!-- Minimum Stock -->
                            <div class="form-group">
                                <label for="minimum_stock" class="form-label required">Minimum Stock</label>
                                <input type="number" wire:model="minimum_stock" id="minimum_stock" class="form-input"
                                       placeholder="0" min="0" required>
                                @error('minimum_stock') <span class="form-error">{{ $message }}</span> @enderror
                            </div>

                            <!-- Maximum Stock -->
                            <div class="form-group">
                                <label for="maximum_stock" class="form-label required">Maximum Stock</label>
                                <input type="number" wire:model="maximum_stock" id="maximum_stock" class="form-input"
                                       placeholder="0" min="0" required>
                                @error('maximum_stock') <span class="form-error">{{ $message }}</span> @enderror
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Physical Properties -->
                <div class="form-section">
                    <div class="section-header">
                        <h3 class="section-title">Physical Properties</h3>
                        <p class="section-subtitle">Weight, dimensions, and physical characteristics</p>
                    </div>

                    <div class="form-grid">
                        <!-- Weight -->
                        <div class="form-group">
                            <label for="weight" class="form-label">Weight</label>
                            <div class="input-group">
                                <input type="number" wire:model="weight" id="weight" class="form-input"
                                       placeholder="0.00" step="0.01" min="0">
                                <span class="input-suffix">kg</span>
                            </div>
                            @error('weight') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Dimensions -->
                        <div class="form-group">
                            <label for="dimensions" class="form-label">Dimensions</label>
                            <input type="text" wire:model="dimensions" id="dimensions" class="form-input"
                                   placeholder="L x W x H (cm)">
                            @error('dimensions') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            @endif

            <!-- Product Image -->
            <div class="form-section">
                <div class="section-header">
                    <h3 class="section-title">Product Image</h3>
                    <p class="section-subtitle">Upload product image for better identification</p>
                </div>

                <div class="form-grid">
                    <!-- Current Image -->
                    @if($existing_image)
                        <div class="form-group">
                            <label class="form-label">Current Image</label>
                            <div class="current-image-container">
                                <img src="{{ Storage::url($existing_image) }}" class="current-image" alt="Current Product Image">
                            </div>
                        </div>
                    @endif

                    <!-- Image Upload -->
                    <div class="form-group {{ $existing_image ? '' : 'form-group-full' }}">
                        <label for="image" class="form-label">{{ $existing_image ? 'Replace Image' : 'Product Image' }}</label>
                        <input type="file" wire:model="image" id="image" class="form-input"
                               accept="image/*">
                        @error('image') <span class="form-error">{{ $message }}</span> @enderror

                        @if ($image)
                            <div class="image-preview-container">
                                <img src="{{ $image->temporaryUrl() }}" class="image-preview" alt="Preview">
                            </div>
                        @endif
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
                    Update Product
                </span>
                <span wire:loading>
                    <span class="material-icons spinning">refresh</span>
                    Updating...
                </span>
            </button>
        </div>
    </form>
</div>
</div>
