@extends('layouts.app')

@section('title', 'Add New Employee')

@section('content')
<div class="dashboard-container">
    @livewire('users.create')
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
/* User Create Form Styles */
.user-create {
    padding: 0;
}

.page-header {
    margin-bottom: 24px;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
}

.header-left {
    flex: 1;
}

.page-title {
    font-size: 28px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 4px;
}

.page-subtitle {
    font-size: 14px;
    color: var(--text-secondary);
    margin: 0;
}

.header-actions {
    display: flex;
    gap: 12px;
}

/* Alerts */
.alert {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-size: 14px;
    font-weight: 500;
}

.alert-success {
    background: rgba(19, 222, 185, 0.1);
    color: var(--success-color);
    border: 1px solid rgba(19, 222, 185, 0.2);
}

.alert-error {
    background: rgba(250, 137, 107, 0.1);
    color: var(--error-color);
    border: 1px solid rgba(250, 137, 107, 0.2);
}

/* Form */
.user-form {
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

.form-input, .form-select, .form-textarea {
    padding: 12px 16px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    font-size: 14px;
    background: white;
    transition: all 0.2s ease;
}

.form-input:focus, .form-select:focus, .form-textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(93, 135, 255, 0.1);
}

.form-textarea {
    resize: vertical;
    min-height: 80px;
}

.form-error {
    font-size: 12px;
    color: var(--error-color);
    font-weight: 500;
}

/* Avatar Preview */
.avatar-preview {
    margin-top: 12px;
}

.preview-image {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
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

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-primary {
    background: var(--primary-color);
    color: white;
}

.btn-primary:hover:not(:disabled) {
    background: #4c7dff;
}

.btn-primary:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.btn-outline {
    background: transparent;
    border: 1px solid var(--border-color);
    color: var(--text-secondary);
}

.btn-outline:hover {
    background: var(--light-color);
    color: var(--text-primary);
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
    .header-content {
        flex-direction: column;
        align-items: stretch;
    }

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
    .page-title {
        font-size: 24px;
    }

    .form-section {
        padding: 20px 16px;
    }

    .form-actions {
        padding: 16px;
    }
}
</style>
@endpush
