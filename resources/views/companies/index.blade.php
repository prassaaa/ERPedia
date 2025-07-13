@extends('layouts.app')

@section('title', 'Company Management')

@section('content')
<div class="dashboard-container">
    @livewire('companies.index')
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
/* Companies Index Styles */
.companies-index {
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

/* Filters */
.filters-section {
    background: white;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border: 1px solid var(--border-color);
}

.filters-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    gap: 20px;
}

.filter-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.filter-label {
    font-size: 12px;
    font-weight: 600;
    color: var(--text-primary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.search-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.search-icon {
    position: absolute;
    left: 12px;
    color: var(--text-secondary);
    font-size: 20px;
}

.search-input, .filter-select {
    width: 100%;
    padding: 10px 12px 10px 44px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    font-size: 14px;
    background: white;
    transition: all 0.2s ease;
}

.filter-select {
    padding-left: 12px;
}

.search-input:focus, .filter-select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(93, 135, 255, 0.1);
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

/* Companies Container */
.companies-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.companies-header {
    padding: 20px 24px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.companies-title {
    font-size: 18px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
}

/* Companies Grid */
.companies-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 24px;
    padding: 24px;
}

.company-card {
    background: white;
    border: 1px solid var(--border-color);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.2s ease;
    display: flex;
    flex-direction: column;
}

.company-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.company-header {
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    border-bottom: 1px solid var(--border-color);
}

.company-logo {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.logo-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.logo-placeholder {
    width: 100%;
    height: 100%;
    background: var(--light-color);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-secondary);
}

.logo-placeholder .material-icons {
    font-size: 32px;
}

.company-status {
    display: flex;
    align-items: center;
}

.company-body {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.company-name {
    font-size: 18px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
}

.company-code {
    font-family: monospace;
    font-weight: 600;
    color: var(--primary-color);
    font-size: 12px;
    margin: 0;
}

.company-description {
    font-size: 14px;
    color: var(--text-secondary);
    line-height: 1.5;
    margin: 0;
}

.company-info {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: var(--text-secondary);
}

.info-item .material-icons {
    font-size: 16px;
}

.website-link {
    color: var(--primary-color);
    text-decoration: none;
}

.website-link:hover {
    text-decoration: underline;
}

.company-stats {
    display: flex;
    gap: 20px;
    margin-top: auto;
    padding-top: 12px;
    border-top: 1px solid var(--border-color);
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
    color: var(--text-primary);
}

.stat-label {
    font-size: 12px;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.company-actions {
    padding: 16px 20px;
    background: var(--light-color);
    display: flex;
    justify-content: center;
    gap: 8px;
}

/* Status Badges */
.status-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-active {
    background: rgba(19, 222, 185, 0.1);
    color: var(--success-color);
}

.status-inactive {
    background: rgba(255, 174, 31, 0.1);
    color: var(--warning-color);
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 8px 16px;
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

.btn-primary:hover {
    background: #4c7dff;
}

.btn-sm {
    padding: 6px 8px;
    font-size: 12px;
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

.btn-danger {
    border-color: var(--error-color);
    color: var(--error-color);
}

.btn-danger:hover {
    background: rgba(250, 137, 107, 0.1);
}

/* Empty State */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
}

.empty-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
}

.empty-icon {
    font-size: 64px;
    color: var(--text-secondary);
    opacity: 0.5;
}

.empty-content h3 {
    font-size: 18px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
}

.empty-content p {
    font-size: 14px;
    color: var(--text-secondary);
    margin: 0;
}

/* Pagination */
.pagination-wrapper {
    padding: 20px 24px;
    border-top: 1px solid var(--border-color);
}

/* Responsive */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: stretch;
    }

    .filters-grid {
        grid-template-columns: 1fr;
    }

    .companies-grid {
        grid-template-columns: 1fr;
        padding: 16px;
        gap: 16px;
    }

    .company-card {
        margin: 0;
    }

    .company-header {
        padding: 16px;
    }

    .company-body {
        padding: 16px;
    }

    .company-actions {
        padding: 12px 16px;
        flex-wrap: wrap;
    }
}
</style>
@endpush
