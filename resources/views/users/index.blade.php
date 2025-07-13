@extends('layouts.app')

@section('title', 'Employee Management')

@section('content')
    @livewire('users.index')
@endsection

@push('styles')
<style>
/* Users Index Styles */
.users-index {
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
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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

/* Table */
.table-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.table-header {
    padding: 20px 24px;
    border-bottom: 1px solid var(--border-color);
}

.table-title {
    font-size: 18px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
}

.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th,
.data-table td {
    padding: 16px;
    text-align: left;
    border-bottom: 1px solid var(--border-color);
}

.data-table th {
    font-weight: 600;
    color: var(--text-primary);
    background: var(--light-color);
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.data-table th.sortable {
    cursor: pointer;
    user-select: none;
    position: relative;
}

.data-table th.sortable:hover {
    background: rgba(93, 135, 255, 0.05);
}

.sort-icon {
    font-size: 16px;
    margin-left: 4px;
}

.data-table td {
    font-size: 14px;
    color: var(--text-secondary);
}

/* User Info */
.user-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.user-details {
    display: flex;
    flex-direction: column;
}

.user-name {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 14px;
}

.user-full-name {
    font-size: 12px;
    color: var(--text-secondary);
}

.employee-id {
    font-family: monospace;
    font-weight: 600;
    color: var(--primary-color);
}

.user-email {
    color: var(--text-secondary);
}

.department-name {
    color: var(--text-primary);
    font-weight: 500;
}

/* Status Badges */
.status-badge, .employment-type {
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

.status-terminated, .status-resigned {
    background: rgba(250, 137, 107, 0.1);
    color: var(--error-color);
}

.employment-type-full_time {
    background: rgba(93, 135, 255, 0.1);
    color: var(--primary-color);
}

.employment-type-part_time {
    background: rgba(73, 190, 255, 0.1);
    color: var(--secondary-color);
}

.employment-type-contract {
    background: rgba(255, 174, 31, 0.1);
    color: var(--warning-color);
}

.employment-type-intern {
    background: rgba(156, 163, 175, 0.1);
    color: #6B7280;
}

/* Actions */
.actions-column {
    width: 120px;
}

.action-buttons {
    display: flex;
    gap: 4px;
}

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

.text-muted {
    color: var(--text-secondary);
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
    
    .action-buttons {
        flex-wrap: wrap;
    }
    
    .data-table {
        font-size: 12px;
    }
    
    .data-table th,
    .data-table td {
        padding: 12px 8px;
    }
}
</style>
@endpush
