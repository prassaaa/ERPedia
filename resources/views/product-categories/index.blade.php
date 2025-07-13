@extends('layouts.app')

@section('title', 'Product Categories')

@section('content')
<div class="dashboard-container">
    @livewire('product-categories.index')
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
/* Product Categories Grid Styles - Extends dashboard.css */
.categories-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.categories-header {
    padding: 20px 24px;
    border-bottom: 1px solid var(--border-color);
}

.categories-title {
    font-size: 18px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 24px;
    padding: 24px;
}

/* Category Card */
.category-card {
    background: white;
    border: 1px solid var(--border-color);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.2s ease;
}

.category-card:hover {
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.category-header {
    position: relative;
    height: 120px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    display: flex;
    align-items: center;
    justify-content: center;
}

.category-image {
    width: 60px;
    height: 60px;
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
    font-size: 24px;
}

.category-status {
    position: absolute;
    top: 12px;
    right: 12px;
}

.category-body {
    padding: 20px;
}

.category-name {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 4px;
}

.category-code {
    font-size: 12px;
    color: var(--text-secondary);
    font-weight: 500;
    margin: 0 0 8px;
    text-transform: uppercase;
}

.category-description {
    font-size: 14px;
    color: var(--text-secondary);
    line-height: 1.5;
    margin: 0 0 16px;
}

.category-info {
    display: flex;
    flex-direction: column;
    gap: 8px;
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

.category-stats {
    display: flex;
    gap: 16px;
    margin-bottom: 16px;
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.stat-number {
    font-size: 18px;
    font-weight: 700;
    color: var(--primary-color);
}

.stat-label {
    font-size: 11px;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.category-actions {
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
    .categories-grid {
        grid-template-columns: 1fr;
        padding: 16px;
        gap: 16px;
    }
    
    .category-body {
        padding: 16px;
    }
    
    .category-actions {
        flex-wrap: wrap;
    }
}

@media (max-width: 480px) {
    .categories-header {
        padding: 16px;
    }
    
    .category-header {
        height: 100px;
    }
    
    .category-image {
        width: 50px;
        height: 50px;
    }
}
</style>
@endpush
