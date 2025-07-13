@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="dashboard-container">
    @livewire('products.show', ['product' => $product])
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
/* Product Show/Detail Styles - Extends dashboard.css */
.product-show {
    padding: 0;
}

.product-header-info {
    display: flex;
    align-items: flex-start;
    gap: 20px;
}

.product-header-details {
    flex: 1;
}

/* Breadcrumb */
.product-breadcrumb {
    display: flex;
    align-items: center;
    gap: 4px;
    margin-bottom: 8px;
    font-size: 12px;
    color: var(--text-secondary);
}

.breadcrumb-separator {
    display: flex;
    align-items: center;
}

.breadcrumb-separator .material-icons {
    font-size: 14px;
}

.breadcrumb-item {
    font-weight: 500;
}

.breadcrumb-item.current {
    color: var(--primary-color);
    font-weight: 600;
}

.product-badges {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-top: 8px;
}

.type-badge {
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.type-product {
    background: rgba(34, 197, 94, 0.2);
    color: #16a34a;
}

.type-service {
    background: rgba(59, 130, 246, 0.2);
    color: #2563eb;
}

/* Content Grid */
.content-grid {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 24px;
}

.left-column, .right-column {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

/* Product Image Card */
.product-image-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border: 1px solid var(--border-color);
    overflow: hidden;
    padding: 24px;
    text-align: center;
}

.product-image {
    width: 100%;
    max-width: 300px;
    height: 300px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid var(--border-color);
}

.product-image-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 300px;
    background: var(--light-color);
    border-radius: 8px;
    color: var(--text-secondary);
}

.product-image-placeholder .material-icons {
    font-size: 64px;
    margin-bottom: 12px;
}

.product-image-placeholder p {
    margin: 0;
    font-size: 14px;
}

/* Cards */
.info-card, .pricing-card, .inventory-card, .physical-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.card-header {
    padding: 20px 24px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-title {
    font-size: 18px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
}

.card-body {
    padding: 24px;
}

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.info-label {
    font-size: 12px;
    font-weight: 600;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    font-size: 14px;
    color: var(--text-primary);
    font-weight: 500;
}

.category-link {
    color: var(--primary-color);
    text-decoration: none;
}

.category-link:hover {
    text-decoration: underline;
}

/* Description Section */
.description-section {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid var(--border-color);
}

.product-description {
    font-size: 14px;
    color: var(--text-primary);
    line-height: 1.6;
    margin: 8px 0 0;
}

/* Pricing Grid */
.pricing-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 20px;
}

.price-item {
    text-align: center;
    padding: 16px;
    background: var(--light-color);
    border-radius: 8px;
}

.price-label {
    font-size: 12px;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.price-value {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-primary);
}

.price-value.selling {
    color: var(--success-color);
}

.price-value.margin {
    color: var(--primary-color);
}

/* Inventory Grid */
.inventory-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 16px;
}

.inventory-item {
    text-align: center;
    padding: 16px;
    background: rgba(59, 130, 246, 0.1);
    border-radius: 8px;
}

.inventory-label {
    font-size: 11px;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.inventory-value {
    font-size: 18px;
    font-weight: 700;
    color: var(--primary-color);
}

/* Physical Grid */
.physical-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 16px;
}

.physical-item {
    text-align: center;
    padding: 16px;
    background: rgba(34, 197, 94, 0.1);
    border-radius: 8px;
}

.physical-label {
    font-size: 11px;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.physical-value {
    font-size: 16px;
    font-weight: 600;
    color: var(--success-color);
}

/* Responsive */
@media (max-width: 1024px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
    
    .pricing-grid, .inventory-grid {
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
    }
}

@media (max-width: 768px) {
    .product-header-info {
        flex-direction: column;
        gap: 16px;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .pricing-grid, .inventory-grid, .physical-grid {
        grid-template-columns: 1fr;
    }
    
    .product-breadcrumb {
        flex-wrap: wrap;
    }
    
    .product-image {
        height: 200px;
    }
    
    .product-image-placeholder {
        height: 200px;
    }
}

@media (max-width: 480px) {
    .card-body {
        padding: 16px;
    }
    
    .card-header {
        padding: 16px;
    }
    
    .breadcrumb-item {
        font-size: 11px;
    }
}
</style>
@endpush
