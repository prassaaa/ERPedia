@extends('layouts.app')

@section('title', 'Edit Department')

@section('content')
<div class="dashboard-container">
    @livewire('departments.edit', ['department' => $department])
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
/* Department Edit Form Styles - Extends dashboard.css */
.department-edit {
    padding: 0;
}

.department-form {
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
}
</style>
@endpush
