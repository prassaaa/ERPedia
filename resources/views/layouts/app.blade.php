<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ERPedia') }} - @yield('title', 'Dashboard')</title>

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
    
    <!-- Components CSS -->
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-color: #5D87FF;
            --secondary-color: #49BEFF;
            --success-color: #13DEB9;
            --warning-color: #FFAE1F;
            --error-color: #FA896B;
            --dark-color: #2A3547;
            --light-color: #F2F6FA;
            --border-color: #E5EAEF;
            --text-primary: #2A3547;
            --text-secondary: #5A6A85;
            --sidebar-width: 270px;
            --header-height: 70px;
            --white: #ffffff;
            --gray-50: #f9fafb;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--light-color);
            color: var(--text-primary);
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        .main-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }
        
        .page-wrapper {
            display: flex;
            flex-grow: 1;
            flex-direction: column;
            z-index: 1;
            background-color: transparent;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
            min-height: 100vh;
        }
        
        .page-wrapper.sidebar-collapsed {
            margin-left: 0;
        }
        
        .content-container {
            padding: 24px;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
            flex: 1;
        }
        
        .content-area {
            min-height: calc(100vh - var(--header-height) - 120px);
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            padding: 32px;
            border: 1px solid var(--border-color);
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .page-wrapper {
                margin-left: 0;
            }
            
            .content-container {
                padding: 20px;
            }
            
            .content-area {
                padding: 24px;
                border-radius: 12px;
            }
        }
        
        @media (max-width: 768px) {
            .content-container {
                padding: 16px;
            }
            
            .content-area {
                padding: 20px;
                border-radius: 12px;
            }
        }
        
        @media (max-width: 480px) {
            .content-container {
                padding: 12px;
            }
            
            .content-area {
                padding: 16px;
                border-radius: 8px;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="main-wrapper">
        <!-- Sidebar -->
        @include('layouts.partials.sidebar')
        
        <!-- Page Wrapper -->
        <div class="page-wrapper" id="page-wrapper">
            <!-- Header -->
            @include('layouts.partials.header')
            
            <!-- Main Content -->
            <div class="content-container">
                <div class="content-area">
                    @yield('content')
                    {{ $slot ?? '' }}
                </div>
            </div>
            
            <!-- Footer -->
            @include('layouts.partials.footer')
        </div>
    </div>

    <!-- Livewire Scripts -->
    @livewireScripts
    
    <!-- Custom Scripts -->
    @stack('scripts')
    
    <script>
        // Sidebar toggle functionality
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const pageWrapper = document.getElementById('page-wrapper');
            
            sidebar.classList.toggle('collapsed');
            pageWrapper.classList.toggle('sidebar-collapsed');
        }
        
        // Mobile sidebar toggle
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('mobile-open');
        }
        
        // Close mobile sidebar when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.querySelector('.mobile-sidebar-toggle');
            
            if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                sidebar.classList.remove('mobile-open');
            }
        });
    </script>
</body>
</html>
