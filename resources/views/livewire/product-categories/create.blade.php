<div>
<div class="category-create">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-left">
                <h1 class="page-title">Add New Product Category</h1>
                <p class="page-subtitle">Create a new product category with hierarchical structure</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('product-categories.index') }}" class="btn btn-outline">
                    <span class="material-icons">arrow_back</span>
                    Back to Categories
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
    <form wire:submit="save" class="category-form" enctype="multipart/form-data">
        <div class="form-sections">
            <!-- Basic Information -->
            <div class="form-section">
                <div class="section-header">
                    <h3 class="section-title">Basic Information</h3>
                    <p class="section-subtitle">Category's basic details and hierarchical structure</p>
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

                    <!-- Parent Category -->
                    <div class="form-group">
                        <label for="parent_id" class="form-label">Parent Category</label>
                        <select wire:model="parent_id" id="parent_id" class="form-select">
                            <option value="">Root Category (No Parent)</option>
                            @foreach($parentCategories as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                            @endforeach
                        </select>
                        @error('parent_id') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Category Name -->
                    <div class="form-group">
                        <label for="name" class="form-label required">Category Name</label>
                        <input type="text" wire:model="name" id="name" class="form-input"
                               placeholder="Electronics" required>
                        @error('name') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Category Code -->
                    <div class="form-group">
                        <label for="code" class="form-label">Category Code</label>
                        <input type="text" wire:model="code" id="code" class="form-input"
                               placeholder="ELEC">
                        @error('code') <span class="form-error">{{ $message }}</span> @enderror
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

                    <!-- Category Image -->
                    <div class="form-group">
                        <label for="image" class="form-label">Category Image</label>
                        <input type="file" wire:model="image" id="image" class="form-input"
                               accept="image/*">
                        @error('image') <span class="form-error">{{ $message }}</span> @enderror

                        @if ($image)
                            <div class="image-preview-container">
                                <img src="{{ $image->temporaryUrl() }}" class="image-preview" alt="Preview">
                            </div>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="form-group form-group-full">
                        <label for="description" class="form-label">Description</label>
                        <textarea wire:model="description" id="description" class="form-textarea"
                                  placeholder="Brief description of the category" rows="3"></textarea>
                        @error('description') <span class="form-error">{{ $message }}</span> @enderror
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
                    Create Category
                </span>
                <span wire:loading>
                    <span class="material-icons spinning">refresh</span>
                    Creating...
                </span>
            </button>
        </div>
    </form>
</div>
</div>
