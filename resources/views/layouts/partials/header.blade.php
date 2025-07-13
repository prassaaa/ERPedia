<header class="header">
    <div class="header-content">
        <!-- Left Side -->
        <div class="header-left">
            <!-- Sidebar Toggle -->
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="material-icons">menu</i>
            </button>
            
            <!-- Mobile Sidebar Toggle -->
            <button class="mobile-sidebar-toggle" onclick="toggleMobileSidebar()">
                <i class="material-icons">menu</i>
            </button>
            
            <!-- Search Bar -->
            <div class="search-container">
                <div class="search-input-wrapper">
                    <i class="material-icons search-icon">search</i>
                    <input type="text" class="search-input" placeholder="Search anything...">
                </div>
            </div>
        </div>
        
        <!-- Right Side -->
        <div class="header-right">
            <!-- Notifications -->
            <div class="header-item notification-dropdown">
                <button class="header-btn notification-btn">
                    <i class="material-icons">notifications</i>
                    <span class="notification-badge">3</span>
                </button>
                
                <!-- Notification Dropdown -->
                <div class="dropdown-menu notification-menu">
                    <div class="dropdown-header">
                        <h6>Notifications</h6>
                        <span class="badge">3 new</span>
                    </div>
                    <div class="dropdown-body">
                        <a href="#" class="notification-item">
                            <div class="notification-icon bg-primary">
                                <span class="material-icons">person_add</span>
                            </div>
                            <div class="notification-content">
                                <h6>New user registered</h6>
                                <p>John Doe just created an account</p>
                                <small>2 minutes ago</small>
                            </div>
                        </a>
                        
                        <a href="#" class="notification-item">
                            <div class="notification-icon bg-success">
                                <span class="material-icons">check_circle</span>
                            </div>
                            <div class="notification-content">
                                <h6>Leave request approved</h6>
                                <p>Your leave request has been approved</p>
                                <small>1 hour ago</small>
                            </div>
                        </a>
                        
                        <a href="#" class="notification-item">
                            <div class="notification-icon bg-warning">
                                <span class="material-icons">inventory</span>
                            </div>
                            <div class="notification-content">
                                <h6>Low stock alert</h6>
                                <p>Product XYZ is running low on stock</p>
                                <small>3 hours ago</small>
                            </div>
                        </a>
                    </div>
                    <div class="dropdown-footer">
                        <a href="#" class="view-all-btn">View All Notifications</a>
                    </div>
                </div>
            </div>
            
            <!-- Messages -->
            <div class="header-item message-dropdown">
                <button class="header-btn message-btn">
                    <i class="material-icons">mail</i>
                    <span class="message-badge">2</span>
                </button>
            </div>
            
            <!-- Profile Dropdown -->
            <div class="header-item profile-dropdown">
                <button class="header-btn profile-btn">
                    <img src="{{ auth()->user()->avatar ?? asset('assets/images/profile/user-1.jpg') }}" 
                         alt="Profile" class="profile-avatar">
                    <div class="profile-info">
                        <span class="profile-name">{{ auth()->user()->name ?? 'User' }}</span>
                        <span class="profile-role">{{ auth()->user()->getRoleNames()->first() ?? 'Employee' }}</span>
                    </div>
                    <i class="material-icons dropdown-arrow">keyboard_arrow_down</i>
                </button>
                
                <!-- Profile Dropdown Menu -->
                <div class="dropdown-menu profile-menu">
                    <div class="dropdown-header">
                        <div class="user-info">
                            <img src="{{ auth()->user()->avatar ?? asset('assets/images/profile/user-1.jpg') }}" 
                                 alt="Profile" class="user-avatar">
                            <div class="user-details">
                                <h6>{{ auth()->user()->name ?? 'User' }}</h6>
                                <p>{{ auth()->user()->email ?? 'user@example.com' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="dropdown-body">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <span class="material-icons">person</span>
                            <span>My Profile</span>
                        </a>
                        
                        <a href="#" class="dropdown-item">
                            <span class="material-icons">account_balance_wallet</span>
                            <span>My Account</span>
                        </a>
                        
                        <a href="#" class="dropdown-item">
                            <span class="material-icons">task</span>
                            <span>My Tasks</span>
                        </a>
                        
                        <div class="dropdown-divider"></div>
                        
                        <a href="#" class="dropdown-item">
                            <span class="material-icons">settings</span>
                            <span>Account Settings</span>
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" class="logout-form">
                            @csrf
                            <button type="submit" class="dropdown-item logout-btn">
                                <span class="material-icons">logout</span>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
.header {
    position: sticky;
    top: 0;
    height: var(--header-height);
    background: white;
    border-bottom: 1px solid var(--border-color);
    z-index: 100;
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 100%;
    padding: 0 24px;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 16px;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 8px;
}

.sidebar-toggle {
    display: none;
    background: none;
    border: none;
    padding: 8px;
    border-radius: 6px;
    cursor: pointer;
    color: var(--text-secondary);
    transition: all 0.2s ease;
}

.sidebar-toggle:hover {
    background-color: var(--light-color);
    color: var(--primary-color);
}

.mobile-sidebar-toggle {
    display: none;
    background: none;
    border: none;
    padding: 8px;
    border-radius: 6px;
    cursor: pointer;
    color: var(--text-secondary);
}

.search-container {
    flex: 1;
    max-width: 400px;
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

.search-input {
    width: 100%;
    padding: 10px 12px 10px 44px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    font-size: 14px;
    background: var(--light-color);
    transition: all 0.2s ease;
}

.search-input:focus {
    outline: none;
    border-color: var(--primary-color);
    background: white;
}

.header-item {
    position: relative;
}

.header-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    background: none;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    color: var(--text-secondary);
}

.header-btn:hover {
    background-color: var(--light-color);
}

.notification-btn, .message-btn {
    position: relative;
    padding: 8px;
}

.notification-badge, .message-badge {
    position: absolute;
    top: 4px;
    right: 4px;
    background: var(--error-color);
    color: white;
    font-size: 10px;
    font-weight: 600;
    padding: 2px 6px;
    border-radius: 10px;
    min-width: 16px;
    text-align: center;
}

.profile-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
}

.profile-info {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.profile-name {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
}

.profile-role {
    font-size: 12px;
    color: var(--text-secondary);
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border: 1px solid var(--border-color);
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    min-width: 280px;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.2s ease;
}

.header-item:hover .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-header {
    padding: 16px;
    border-bottom: 1px solid var(--border-color);
}

.dropdown-header h6 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: var(--text-primary);
}

.badge {
    background: var(--primary-color);
    color: white;
    font-size: 10px;
    padding: 2px 8px;
    border-radius: 12px;
    font-weight: 600;
}

.dropdown-body {
    padding: 8px 0;
    max-height: 300px;
    overflow-y: auto;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    text-decoration: none;
    color: var(--text-secondary);
    transition: all 0.2s ease;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
}

.dropdown-item:hover {
    background-color: var(--light-color);
    color: var(--text-primary);
}

.dropdown-divider {
    height: 1px;
    background: var(--border-color);
    margin: 8px 0;
}

.logout-form {
    margin: 0;
}

.logout-btn {
    color: var(--error-color);
}

.logout-btn:hover {
    background-color: rgba(250, 137, 107, 0.1);
}

/* Responsive */
@media (min-width: 1025px) {
    .sidebar-toggle {
        display: block;
    }
}

@media (max-width: 1024px) {
    .mobile-sidebar-toggle {
        display: block;
    }
    
    .search-container {
        display: none;
    }
    
    .profile-info {
        display: none;
    }
}

@media (max-width: 768px) {
    .header-content {
        padding: 0 16px;
    }
    
    .dropdown-menu {
        min-width: 250px;
    }
}
</style>
