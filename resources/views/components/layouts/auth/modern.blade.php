<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'ERPedia') }} - Authentication</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Livewire Styles -->
    @livewireStyles
    
    <!-- Auth Styles -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="auth-body">
    <div class="auth-container">
        <!-- Left Panel - Branding -->
        <div class="auth-brand-panel">
            <div class="brand-content">
                <div class="brand-logo">
                    <div class="logo-circle">
                        <i class="material-icons">business</i>
                    </div>
                    <h1 class="brand-title">ERPedia</h1>
                    <p class="brand-subtitle">Enterprise Resource Planning</p>
                </div>
                
                <div class="brand-features">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="material-icons">dashboard</i>
                        </div>
                        <div class="feature-text">
                            <h3>Smart Dashboard</h3>
                            <p>Real-time business insights</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="material-icons">inventory</i>
                        </div>
                        <div class="feature-text">
                            <h3>Inventory Management</h3>
                            <p>Complete stock control</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="material-icons">people</i>
                        </div>
                        <div class="feature-text">
                            <h3>HR Management</h3>
                            <p>Employee lifecycle management</p>
                        </div>
                    </div>
                </div>
                
                <div class="brand-footer">
                    <p>&copy; {{ date('Y') }} ERPedia. All rights reserved.</p>
                </div>
            </div>
        </div>

        <!-- Right Panel - Form -->
        <div class="auth-form-panel">
            <div class="form-container">
                <div class="form-header">
                    <a href="{{ route('home') }}" class="mobile-logo">
                        <div class="logo-circle small">
                            <i class="material-icons">business</i>
                        </div>
                        <span>ERPedia</span>
                    </a>
                </div>
                
                <div class="form-content">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay" style="display: none;">
        <div class="loading-content">
            <div class="loading-spinner-large"></div>
            <p>Please wait...</p>
        </div>
    </div>

    @livewireScripts
    @fluxScripts
    
    <script>
        // Simple loading for form submissions
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            const loadingOverlay = document.getElementById('loadingOverlay');
            
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    if (loadingOverlay) {
                        loadingOverlay.style.display = 'flex';
                    }
                });
            });
            
            // Hide loading on navigation
            document.addEventListener('livewire:navigated', function() {
                if (loadingOverlay) {
                    loadingOverlay.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>