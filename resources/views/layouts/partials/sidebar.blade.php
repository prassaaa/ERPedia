<aside id="sidebar" class="sidebar">
    <div class="sidebar-content">
        <!-- Logo -->
        <div class="sidebar-logo">
            <a href="{{ route('dashboard') }}" class="logo-link">
                <img src="{{ asset('assets/images/logos/dark1-logo.svg') }}" alt="ERPedia" class="logo-img">
                <span class="logo-text">ERPedia</span>
            </a>
        </div>

        <!-- Navigation Menu -->
        <nav class="sidebar-nav">
            <ul class="nav-list">
                <!-- Dashboard Section -->
                <li class="nav-label">
                    <span>Home</span>
                </li>

                <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="material-icons nav-icon">dashboard</i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>

                <!-- HRM Section -->
                <li class="nav-label">
                    <span>Human Resources</span>
                </li>

                <li class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="material-icons nav-icon">people</i>
                        <span class="nav-text">Employees</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('departments.*') ? 'active' : '' }}">
                    <a href="{{ route('departments.index') }}" class="nav-link">
                        <i class="material-icons nav-icon">business</i>
                        <span class="nav-text">Departments</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('leave-requests.*') ? 'active' : '' }}">
                    <a href="{{ route('leave-requests.index') }}" class="nav-link">
                        <i class="material-icons nav-icon">event_available</i>
                        <span class="nav-text">Leave Management</span>
                    </a>
                </li>

                <!-- Inventory Section -->
                <li class="nav-label">
                    <span>Inventory</span>
                </li>

                <li class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <a href="{{ route('products.index') }}" class="nav-link">
                        <i class="material-icons nav-icon">inventory</i>
                        <span class="nav-text">Products</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('warehouses.*') ? 'active' : '' }}">
                    <a href="{{ route('warehouses.index') }}" class="nav-link">
                        <i class="material-icons nav-icon">warehouse</i>
                        <span class="nav-text">Warehouses</span>
                    </a>
                </li>

                <!-- Accounting Section -->
                <li class="nav-label">
                    <span>Accounting</span>
                </li>

                <li class="nav-item {{ request()->routeIs('chart-of-accounts.*') ? 'active' : '' }}">
                    <a href="{{ route('chart-of-accounts.index') }}" class="nav-link">
                        <i class="material-icons nav-icon">account_balance</i>
                        <span class="nav-text">Chart of Accounts</span>
                    </a>
                </li>

                <!-- Settings Section -->
                <li class="nav-label">
                    <span>Settings</span>
                </li>

                <li class="nav-item {{ request()->routeIs('companies.*') ? 'active' : '' }}">
                    <a href="{{ route('companies.index') }}" class="nav-link">
                        <i class="material-icons nav-icon">business_center</i>
                        <span class="nav-text">Companies</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <a href="{{ route('profile.edit') }}" class="nav-link">
                        <i class="material-icons nav-icon">settings</i>
                        <span class="nav-text">Profile Settings</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" onclick="toggleMobileSidebar()"></div>
</aside>

<style>
.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    width: var(--sidebar-width);
    height: 100vh;
    background: white;
    border-right: 1px solid var(--border-color);
    z-index: 1000;
    transition: transform 0.3s ease;
    overflow-y: auto;
}

.sidebar.collapsed {
    transform: translateX(-100%);
}

.sidebar-content {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.sidebar-logo {
    padding: 20px;
    border-bottom: 1px solid var(--border-color);
}

.logo-link {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: var(--text-primary);
}

.logo-img {
    height: 40px;
    margin-right: 12px;
}

.logo-text {
    font-size: 24px;
    font-weight: 700;
    color: var(--primary-color);
}

.sidebar-nav {
    flex: 1;
    padding: 20px 0;
}

.nav-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-label {
    padding: 16px 24px 8px;
    font-size: 12px;
    font-weight: 600;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.nav-item {
    margin: 2px 12px;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    text-decoration: none;
    color: var(--text-secondary);
    border-radius: 8px;
    transition: all 0.2s ease;
    font-weight: 500;
}

.nav-link:hover {
    background-color: rgba(93, 135, 255, 0.08);
    color: var(--primary-color);
}

.nav-item.active .nav-link {
    background-color: var(--primary-color);
    color: white;
}

.nav-icon {
    margin-right: 12px;
    font-size: 20px;
}

.nav-text {
    font-size: 14px;
}

.sidebar-upgrade {
    padding: 20px;
    border-top: 1px solid var(--border-color);
}

.upgrade-card {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    padding: 20px;
    border-radius: 12px;
    text-align: center;
    color: white;
}

.upgrade-icon {
    margin-bottom: 12px;
}

.upgrade-icon .material-icons {
    font-size: 32px;
}

.upgrade-card h4 {
    margin: 0 0 8px;
    font-size: 16px;
    font-weight: 600;
}

.upgrade-card p {
    margin: 0 0 16px;
    font-size: 12px;
    opacity: 0.9;
}

.upgrade-btn {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.upgrade-btn:hover {
    background: rgba(255, 255, 255, 0.3);
}

.sidebar-overlay {
    display: none;
}

/* Mobile Styles */
@media (max-width: 1024px) {
    .sidebar {
        transform: translateX(-100%);
    }

    .sidebar.mobile-open {
        transform: translateX(0);
    }

    .sidebar.mobile-open .sidebar-overlay {
        display: block;
        position: fixed;
        top: 0;
        left: var(--sidebar-width);
        width: calc(100vw - var(--sidebar-width));
        height: 100vh;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }
}

@media (max-width: 768px) {
    .sidebar {
        width: 280px;
    }

    .sidebar.mobile-open .sidebar-overlay {
        left: 280px;
        width: calc(100vw - 280px);
    }
}
</style>
