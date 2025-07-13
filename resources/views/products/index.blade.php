@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="dashboard-container">
    @livewire('products.index')
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
/* Products Grid Styles - Extends dashboard.css */
.products-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.products-header {
    padding: 20px 24px;
    border-bottom: 1px solid var(--border-color);
}

.products-title {
    font-size: 18px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 24px;
    padding: 24px;
}

/* Product Card */
.product-card {
    background: white;
    border: 1px solid var(--border-color);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.2s ease;
}

.product-card:hover {
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.product-header {
    position: relative;
    height: 140px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-image {
    width: 80px;
    height: 80px;
    border-radius: 12px;
    overflow: hidden;
    background: rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
}

.image-preview {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-placeholder {
    color: white;
    font-size: 32px;
}

.product-badges {
    position: absolute;
    top: 12px;
    right: 12px;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.type-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 10px;
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

.product-body {
    padding: 20px;
}

.product-name {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 4px;
}

.product-sku {
    font-size: 12px;
    color: var(--text-secondary);
    font-weight: 500;
    margin: 0 0 8px;
    text-transform: uppercase;
}

.product-description {
    font-size: 14px;
    color: var(--text-secondary);
    line-height: 1.5;
    margin: 0 0 16px;
}

.product-info {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-bottom: 16px;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: var(--text-secondary);
}

.info-item .material-icons {
    font-size: 16px;
}

/* Pricing */
.product-pricing {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
    gap: 12px;
    margin-bottom: 16px;
    padding: 12px;
    background: var(--light-color);
    border-radius: 8px;
}

.price-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.price-label {
    font-size: 10px;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 2px;
}

.price-value {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
}

.price-value.selling {
    color: var(--success-color);
}

.price-value.margin {
    color: var(--primary-color);
}

/* Stock Info */
.product-stock {
    display: flex;
    justify-content: space-between;
    margin-bottom: 16px;
    padding: 8px 12px;
    background: rgba(59, 130, 246, 0.1);
    border-radius: 6px;
}

.stock-info {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.stock-label {
    font-size: 10px;
    color: var(--text-secondary);
    text-transform: uppercase;
}

.stock-value {
    font-size: 12px;
    font-weight: 600;
    color: var(--primary-color);
}

.product-actions {
    display: flex;
    gap: 8px;
    padding-top: 16px;
    border-top: 1px solid var(--border-color);
}

.btn-sm {
    padding: 8px 12px;
    font-size: 12px;
}

.btn-sm .material-icons {
    font-size: 16px;
}

.btn-danger {
    color: var(--error-color);
    border-color: var(--error-color);
}

.btn-danger:hover {
    background: var(--error-color);
    color: white;
}

/* Empty State */
.empty-state {
    grid-column: 1 / -1;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 300px;
}

.empty-content {
    text-align: center;
    max-width: 400px;
}

.empty-icon {
    font-size: 64px;
    color: var(--text-secondary);
    margin-bottom: 16px;
}

.empty-content h3 {
    font-size: 18px;
    color: var(--text-primary);
    margin: 0 0 8px;
}

.empty-content p {
    color: var(--text-secondary);
    margin: 0 0 24px;
}

/* Responsive */
@media (max-width: 768px) {
    .products-grid {
        grid-template-columns: 1fr;
        padding: 16px;
        gap: 16px;
    }
    
    .product-body {
        padding: 16px;
    }
    
    .product-actions {
        flex-wrap: wrap;
    }
    
    .product-pricing {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .products-header {
        padding: 16px;
    }
    
    .product-header {
        height: 120px;
    }
    
    .product-image {
        width: 60px;
        height: 60px;
    }
    
    .product-pricing {
        grid-template-columns: 1fr;
        gap: 8px;
    }
}
</style>
@endpush
