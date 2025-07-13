@extends('layouts.app')

@section('title', 'Department Management')

@section('content')
<div class="dashboard-container">
    @livewire('departments.index')
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
/* Department-specific styles that extend dashboard.css */

/* Filters Section */
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

/* Table Container */
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

.table-wrapper {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th,
.data-table td {
    padding: 16px 20px;
    text-align: left;
    border-bottom: 1px solid var(--border-color);
}

.data-table th {
    background: var(--light-color);
    font-weight: 600;
    color: var(--text-primary);
    font-size: 14px;
}

.data-table th.sortable {
    cursor: pointer;
    user-select: none;
    transition: background-color 0.2s ease;
}

.data-table th.sortable:hover {
    background: #f0f0f0;
}

.sort-icon {
    font-size: 16px;
    margin-left: 4px;
    vertical-align: middle;
}

.data-table tbody tr:hover {
    background: var(--light-color);
}

/* Department Info */
.department-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.department-name {
    font-weight: 600;
    color: var(--text-primary);
}

.department-description {
    font-size: 12px;
    color: var(--text-secondary);
}

.department-code {
    font-family: monospace;
    font-weight: 600;
    color: var(--primary-color);
    font-size: 12px;
}

.company-name {
    font-weight: 500;
    color: var(--text-primary);
}

.parent-department {
    font-weight: 500;
    color: var(--text-secondary);
}

.employee-count {
    font-weight: 600;
    color: var(--primary-color);
}

.text-muted {
    color: var(--text-secondary);
    font-style: italic;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 8px;
    align-items: center;
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

/* Responsive */
@media (max-width: 768px) {
    .filters-grid {
        grid-template-columns: 1fr;
    }
    
    .table-wrapper {
        overflow-x: scroll;
    }
    
    .data-table {
        min-width: 800px;
    }
    
    .action-buttons {
        flex-wrap: wrap;
    }
}
</style>
@endpush
