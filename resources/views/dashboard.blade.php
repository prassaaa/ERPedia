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
                    <span class="material-icons">people</span>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $totalEmployees ?? 0 }}</h3>
                    <p class="stat-label">Total Employees</p>
                    <div class="stat-change positive">
                        <span class="material-icons">trending_up</span>
                        <span>+12% from last month</span>
                    </div>
                </div>
            </div>

            <!-- Active Projects -->
            <div class="stat-card">
                <div class="stat-icon bg-success">
                    <span class="material-icons">assignment</span>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $activeProjects ?? 0 }}</h3>
                    <p class="stat-label">Active Projects</p>
                    <div class="stat-change positive">
                        <span class="material-icons">trending_up</span>
                        <span>+8% from last month</span>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="stat-card">
                <div class="stat-icon bg-warning">
                    <span class="material-icons">attach_money</span>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">${{ number_format($totalRevenue ?? 0) }}</h3>
                    <p class="stat-label">Total Revenue</p>
                    <div class="stat-change positive">
                        <span class="material-icons">trending_up</span>
                        <span>+15% from last month</span>
                    </div>
                </div>
            </div>

            <!-- Pending Tasks -->
            <div class="stat-card">
                <div class="stat-icon bg-error">
                    <span class="material-icons">pending_actions</span>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $pendingTasks ?? 0 }}</h3>
                    <p class="stat-label">Pending Tasks</p>
                    <div class="stat-change negative">
                        <span class="material-icons">trending_down</span>
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
                    <div class="chart-placeholder">
                        <div class="chart-icon">
                            <span class="material-icons">show_chart</span>
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
                                <span class="material-icons">trending_up</span>
                                <span>+9%</span>
                            </div>
                        </div>
                        <div class="earnings-chart">
                            <div class="mini-chart-placeholder">
                                <span class="material-icons">bar_chart</span>
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
@endsection
