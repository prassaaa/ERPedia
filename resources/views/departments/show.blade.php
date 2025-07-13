@extends('layouts.app')

@section('title', 'Department Details')

@section('content')
<div class="dashboard-container">
    @livewire('departments.show', ['department' => $department])
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
/* Department Show/Detail Styles - Extends dashboard.css */
.department-show {
    padding: 0;
}

.department-header-info {
    display: flex;
    align-items: flex-start;
    gap: 20px;
}

.department-header-details {
    flex: 1;
}

/* Breadcrumb */
.department-breadcrumb {
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

.department-status {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-top: 8px;
}

/* Content Grid */
.content-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 24px;
}

.left-column, .right-column {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

/* Cards */
.info-card, .stats-card {
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

.info-item-full {
    grid-column: 1 / -1;
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

.email-link, .parent-link, .manager-link {
    color: var(--primary-color);
    text-decoration: none;
}

.email-link:hover, .parent-link:hover, .manager-link:hover {
    text-decoration: underline;
}

.text-muted {
    color: var(--text-secondary);
    font-style: italic;
}

/* Description Section */
.description-section {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid var(--border-color);
}

.department-description {
    font-size: 14px;
    color: var(--text-primary);
    line-height: 1.6;
    margin: 8px 0 0;
}

/* Statistics Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 16px;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    background: var(--light-color);
    border-radius: 8px;
}

.stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.stat-icon.bg-primary { background: var(--primary-color); }
.stat-icon.bg-success { background: var(--success-color); }
.stat-icon.bg-warning { background: var(--warning-color); }
.stat-icon.bg-info { background: var(--secondary-color); }

.stat-content {
    display: flex;
    flex-direction: column;
}

.stat-number {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-primary);
}

.stat-label {
    font-size: 12px;
    color: var(--text-secondary);
}

/* Responsive */
@media (max-width: 1024px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    }
}

@media (max-width: 768px) {
    .department-header-info {
        flex-direction: column;
        gap: 16px;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .stat-item {
        justify-content: center;
        text-align: center;
    }
    
    .department-breadcrumb {
        flex-wrap: wrap;
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
