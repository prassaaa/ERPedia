@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Welcome back! Here's what's happening in your business today.</p>
    </div>

    <!-- Dashboard Grid -->
    <div class="dashboard-grid">
        <!-- Stats Cards Row -->
        <div class="stats-row">
            <!-- Total Employees -->
            <div class="stat-card">
                <div class="stat-icon bg-primary">
                    <i class="material-icons">people</i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ number_format($totalEmployees ?? 0) }}</h3>
                    <p class="stat-label">Total Employees</p>
                    <div class="stat-change positive">
                        <i class="material-icons">trending_up</i>
                        <span>+12% from last month</span>
                    </div>
                </div>
            </div>

            <!-- Active Projects -->
            <div class="stat-card">
                <div class="stat-icon bg-success">
                    <i class="material-icons">assignment</i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ number_format($activeProjects ?? 0) }}</h3>
                    <p class="stat-label">Active Projects</p>
                    <div class="stat-change positive">
                        <i class="material-icons">trending_up</i>
                        <span>+8% from last month</span>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="stat-card">
                <div class="stat-icon bg-warning">
                    <i class="material-icons">attach_money</i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">${{ number_format($totalRevenue ?? 0) }}</h3>
                    <p class="stat-label">Total Revenue</p>
                    <div class="stat-change positive">
                        <i class="material-icons">trending_up</i>
                        <span>+15% from last month</span>
                    </div>
                </div>
            </div>

            <!-- Pending Tasks -->
            <div class="stat-card">
                <div class="stat-icon bg-error">
                    <i class="material-icons">pending_actions</i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ number_format($pendingTasks ?? 0) }}</h3>
                    <p class="stat-label">Pending Tasks</p>
                    <div class="stat-change negative">
                        <i class="material-icons">trending_down</i>
                        <span>-5% from last month</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="charts-row">
            <!-- Sales Overview -->
            <div class="chart-card large">
                <div class="card-header">
                    <h3 class="card-title">Sales Overview</h3>
                    <div class="card-actions">
                        <select class="period-select">
                            <option value="month">This Month</option>
                            <option value="quarter">This Quarter</option>
                            <option value="year">This Year</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-placeholder" id="sales-chart">
                        <div class="chart-icon">
                            <i class="material-icons">show_chart</i>
                        </div>
                        <p>Sales chart will be displayed here</p>
                    </div>
                </div>
            </div>

            <!-- Monthly Earnings -->
            <div class="chart-card small">
                <div class="card-header">
                    <h3 class="card-title">Monthly Earnings</h3>
                </div>
                <div class="card-body">
                    <div class="earnings-content">
                        <div class="earnings-amount">
                            <h2>${{ number_format($monthlyEarnings ?? 0) }}</h2>
                            <div class="earnings-change positive">
                                <i class="material-icons">trending_up</i>
                                <span>+9%</span>
                            </div>
                        </div>
                        <div class="earnings-chart">
                            <div class="mini-chart-placeholder">
                                <i class="material-icons">bar_chart</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add some interactive elements
    const statCards = document.querySelectorAll('.stat-card');
    const chartPlaceholder = document.getElementById('sales-chart');
    
    // Add hover effects for stat cards
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Period selector functionality
    const periodSelect = document.querySelector('.period-select');
    if (periodSelect) {
        periodSelect.addEventListener('change', function() {
            // Here you would normally update the chart data
            console.log('Period changed to:', this.value);
            
            // Add a loading effect
            if (chartPlaceholder) {
                chartPlaceholder.style.opacity = '0.5';
                setTimeout(() => {
                    chartPlaceholder.style.opacity = '1';
                }, 500);
            }
        });
    }
    
    // Simulate real-time updates (optional)
    setInterval(() => {
        const changes = document.querySelectorAll('.stat-change');
        changes.forEach(change => {
            change.style.animation = 'pulse 0.5s ease-in-out';
            setTimeout(() => {
                change.style.animation = '';
            }, 500);
        });
    }, 30000); // Update every 30 seconds
});
</script>
@endpush
@endsection
