@extends('layouts.app')

@section('title', 'Employee Details')

@section('content')
    @livewire('users.show', ['user' => $user])
@endsection

@push('styles')
<style>
/* User Show/Detail Styles */
.user-show {
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

.user-header-info {
    display: flex;
    align-items: center;
    gap: 20px;
}

.user-header-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--border-color);
}

.user-header-details {
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
    margin: 0 0 12px;
}

.user-status {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.header-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
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

.view-all-link {
    color: var(--primary-color);
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
}

.view-all-link:hover {
    color: var(--secondary-color);
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

.email-link {
    color: var(--primary-color);
    text-decoration: none;
}

.email-link:hover {
    text-decoration: underline;
}

/* Status Badges */
.status-badge, .employment-type, .role-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
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

.status-pending {
    background: rgba(255, 174, 31, 0.1);
    color: var(--warning-color);
}

.status-approved {
    background: rgba(19, 222, 185, 0.1);
    color: var(--success-color);
}

.status-rejected {
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

.role-badge {
    background: rgba(93, 135, 255, 0.1);
    color: var(--primary-color);
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

/* Leave Requests List */
.leave-requests-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.leave-request-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px;
    background: var(--light-color);
    border-radius: 8px;
}

.leave-request-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.leave-type {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 14px;
}

.leave-dates {
    font-size: 12px;
    color: var(--text-secondary);
}

.leave-days {
    font-size: 12px;
    color: var(--text-secondary);
    font-weight: 500;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: var(--text-secondary);
}

.empty-icon {
    font-size: 48px;
    opacity: 0.5;
    margin-bottom: 8px;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 16px;
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

.btn-outline {
    background: transparent;
    border: 1px solid var(--border-color);
    color: var(--text-secondary);
}

.btn-outline:hover {
    background: var(--light-color);
    color: var(--text-primary);
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
    .header-content {
        flex-direction: column;
        align-items: stretch;
    }
    
    .user-header-info {
        flex-direction: column;
        text-align: center;
        gap: 16px;
    }
    
    .header-actions {
        justify-content: center;
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
    
    .leave-request-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
}

@media (max-width: 480px) {
    .page-title {
        font-size: 24px;
    }
    
    .user-header-avatar {
        width: 60px;
        height: 60px;
    }
    
    .card-body {
        padding: 16px;
    }
    
    .card-header {
        padding: 16px;
    }
}
</style>
@endpush
