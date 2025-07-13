@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="dashboard-container">
    @livewire('products.edit', ['product' => $product])
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
/* Product Edit Form Styles - Extends dashboard.css */
.product-edit {
    padding: 0;
}

.product-form {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.form-sections {
    padding: 0;
}

.form-section {
    padding: 32px;
    border-bottom: 1px solid var(--border-color);
}

.form-section:last-child {
    border-bottom: none;
}

.section-header {
    margin-bottom: 24px;
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 4px;
}

.section-subtitle {
    font-size: 14px;
    color: var(--text-secondary);
    margin: 0;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-group-full {
    grid-column: 1 / -1;
}

.form-label {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
}

.form-label.required::after {
    content: ' *';
    color: var(--error-color);
}

.form-error {
    font-size: 12px;
    color: var(--error-color);
    font-weight: 500;
}

/* Input Groups */
.input-group {
    display: flex;
    align-items: center;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    overflow: hidden;
}

.input-prefix, .input-suffix {
    padding: 12px 16px;
    background: var(--light-color);
    color: var(--text-secondary);
    font-weight: 500;
    font-size: 14px;
    border: none;
}

.input-group .form-input {
    border: none;
    border-radius: 0;
    flex: 1;
}

.input-group .form-input:focus {
    box-shadow: none;
}

.input-group:focus-within {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Calculated Fields */
.calculated-field {
    padding: 12px 16px;
    background: var(--light-color);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    display: flex;
    align-items: center;
}

.calculated-value {
    font-weight: 600;
    color: var(--primary-color);
    font-size: 16px;
}

/* Checkbox */
.checkbox-label {
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    padding: 16px;
    background: var(--light-color);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    transition: all 0.2s ease;
}

.checkbox-label:hover {
    background: rgba(59, 130, 246, 0.05);
    border-color: var(--primary-color);
}

.form-checkbox {
    width: 18px;
    height: 18px;
    accent-color: var(--primary-color);
}

.checkbox-text {
    font-size: 14px;
    font-weight: 500;
    color: var(--text-primary);
}

/* Image Upload */
.current-image-container {
    margin-top: 8px;
}

.current-image {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid var(--border-color);
}

.image-preview-container {
    margin-top: 12px;
}

.image-preview {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid var(--border-color);
}

/* Form Actions */
.form-actions {
    padding: 24px 32px;
    background: var(--light-color);
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

/* Loading Animation */
.spinning {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Responsive */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .form-section {
        padding: 24px 20px;
    }
    
    .form-actions {
        padding: 20px;
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .form-section {
        padding: 20px 16px;
    }
    
    .form-actions {
        padding: 16px;
    }
    
    .input-prefix, .input-suffix {
        padding: 12px;
        font-size: 12px;
    }
}
</style>
@endpush
