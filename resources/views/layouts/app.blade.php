<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Panel - Nepali Cafe</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: #1e40af;
            --primary-dark: #1e3a8a;
            --secondary-color: #3b82f6;
            --accent-color: #06b6d4;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-bg: #0f172a;
            --light-bg: #f8fafc;
            --card-bg: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        /* Modern Sidebar Styling */
        .modern-sidebar {
            background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .sidebar-link {
            position: relative;
            overflow: hidden;
        }

        .sidebar-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s;
        }

        .sidebar-link:hover::before {
            left: 100%;
        }

        .sidebar-link.active {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        /* DataTables Styling */
        .dataTables_length select {
            padding: 8px 40px 8px 12px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            background: white;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-primary);
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23475569"><path d="M7 10l5 5 5-5z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            transition: all 0.3s ease;
        }

        .dataTables_length select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .dataTables_length select::-ms-expand {
            display: none;
        }

        /* Modern Card Styling */
        .admin-card {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .admin-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Modern Button Styling */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 14px 0 rgba(59, 130, 246, 0.39);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px 0 rgba(59, 130, 246, 0.39);
        }

        /* Header Gradient */
        .admin-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 50%, var(--accent-color) 100%);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Modern Table Styling */
        .modern-table {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .modern-table thead {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .modern-table thead th {
            padding: 16px;
            font-weight: 600;
            color: var(--text-primary);
            border-bottom: 2px solid var(--border-color);
        }

        .modern-table tbody tr {
            transition: all 0.2s ease;
        }

        .modern-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .modern-table tbody td {
            padding: 16px;
            border-bottom: 1px solid var(--border-color);
        }

        /* Animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-in {
            animation: slideIn 0.5s ease-out;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar-mobile-hidden {
                transform: translateX(-100%);
            }
        }
    </style>
    <script>
        // Enhanced sidebar functionality
        window.onload = function() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content-container');
            
            // Add smooth animations
            sidebar.style.transition = 'all 0.3s ease';
            
            // Mobile menu toggle
            const mobileToggle = document.getElementById('mobile-toggle');
            if (mobileToggle) {
                mobileToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('sidebar-mobile-hidden');
                });
            }
        };

        // Function to update entries with animation
        function updateEntries() {
            const entries = document.getElementById('entries').value;
            const url = new URL(window.location.href);
            url.searchParams.set('entries', entries);
            
            // Add loading animation
            const table = document.querySelector('.modern-table');
            if (table) {
                table.style.opacity = '0.5';
                table.style.transition = 'opacity 0.3s ease';
            }
            
            window.location.href = url;
        }

        // Enhanced notification system
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-6 right-6 px-6 py-4 rounded-lg shadow-lg z-50 transform transition-all duration-300 ${
                type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500'
            } text-white`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="ri-${type === 'success' ? 'check' : type === 'error' ? 'error-warning' : 'information'}-line mr-2"></i>
                    ${message}
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    </script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css" />

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>

</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 text-gray-900 h-screen flex flex-col font-[Inter]">

    <div class="flex h-full">
        <!-- Enhanced Sidebar -->
        <aside id="sidebar"
            class="w-72 modern-sidebar text-white shadow-2xl flex flex-col fixed top-0 bottom-0 left-0 transition-all duration-300 overflow-y-auto z-20">
            
            <!-- Logo Section -->
            <div class="p-6 flex items-center justify-center border-b border-white/10">
                <div class="text-center">
                    <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-lg">
                        <img src="{{ asset('images/g.png') }}" alt="Logo" class="w-28 h-28 object-contain">
                    </div>
                    <h3 class="text-lg font-bold text-white">Nepali Cafe</h3>
                    <p class="text-sm text-gray-300">Admin Panel</p>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-6 px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="sidebar-link flex items-center px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'active' : 'hover:bg-white/10' }} transition-all duration-200 group">
                    <div class="w-10 h-10 rounded-lg bg-blue-500/20 flex items-center justify-center mr-3 group-hover:bg-blue-500/30 transition-colors">
                        <i class="ri-dashboard-3-line text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <span class="font-semibold text-sm">Dashboard</span>
                        <p class="text-xs text-gray-300 mt-0.5">Overview & Analytics</p>
                    </div>
                </a>
                
                <a href="{{route('admin.category.index')}}"
                    class="sidebar-link flex items-center px-4 py-3 rounded-xl {{ request()->routeIs('admin.category.index', 'admin.category.edit') ? 'active' : 'hover:bg-white/10' }} transition-all duration-200 group">
                    <div class="w-10 h-10 rounded-lg bg-green-500/20 flex items-center justify-center mr-3 group-hover:bg-green-500/30 transition-colors">
                        <i class="ri-grid-line text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <span class="font-semibold text-sm">Categories</span>
                        <p class="text-xs text-gray-300 mt-0.5">Manage Menu Categories</p>
                    </div>
                </a>
                
                <a href="{{route('admin.fooditem.index')}}"
                    class="sidebar-link flex items-center px-4 py-3 rounded-xl {{ request()->routeIs('admin.fooditems.index', 'admin.fooditems.edit') ? 'active' : 'hover:bg-white/10' }} transition-all duration-200 group">
                    <div class="w-10 h-10 rounded-lg bg-orange-500/20 flex items-center justify-center mr-3 group-hover:bg-orange-500/30 transition-colors">
                        <i class="ri-restaurant-line text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <span class="font-semibold text-sm">Food Items</span>
                        <p class="text-xs text-gray-300 mt-0.5">Menu Items & Pricing</p>
                    </div>
                </a>

                <a href="{{route('admin.reservation.index')}}"
                    class="sidebar-link flex items-center px-4 py-3 rounded-xl {{ request()->routeIs('admin.booking.index') ? 'active' : 'hover:bg-white/10' }} transition-all duration-200 group">
                    <div class="w-10 h-10 rounded-lg bg-purple-500/20 flex items-center justify-center mr-3 group-hover:bg-purple-500/30 transition-colors">
                        <i class="ri-calendar-check-line text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <span class="font-semibold text-sm">Reservations</span>
                        <p class="text-xs text-gray-300 mt-0.5">Table Bookings</p>
                    </div>
                </a>
            </nav>

        
        </aside>

        <!-- Enhanced Main Content -->
        <main class="ml-72 w-full min-h-screen">
            <!-- Modern Header Section -->
            <div class="admin-header w-full text-white flex items-center justify-between px-8 py-6 shadow-xl">
                <div class="flex items-center space-x-4">
                    <!-- Mobile Menu Toggle -->
                    <button id="mobile-toggle" class="lg:hidden text-white hover:bg-white/10 p-2 rounded-lg transition-colors">
                        <i class="ri-menu-line text-xl"></i>
                    </button>
                    
                    <div>
                        <h1 class="text-2xl font-bold">{{ $title ?? 'Dashboard' }}</h1>
                        <p class="text-blue-100 text-sm mt-1">Welcome back to your admin panel</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-6">
                    <!-- Notifications -->
                    <button class="relative text-white hover:bg-white/10 p-2 rounded-lg transition-colors">
                        <i class="ri-notification-3-line text-xl"></i>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                    </button>
                    
                    <!-- Settings -->
                    <button class="text-white hover:bg-white/10 p-2 rounded-lg transition-colors">
                        <i class="ri-settings-3-line text-xl"></i>
                    </button>
                    
                    <!-- User Profile Dropdown -->
                    <div class="relative group">
                        <div class="flex items-center space-x-3 cursor-pointer bg-white/10 rounded-xl px-4 py-2 hover:bg-white/20 transition-colors">
                            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                                <i class="ri-user-3-fill text-blue-600"></i>
                            </div>
                            <div class="text-left hidden sm:block">
                                <p class="font-semibold text-sm">{{ Auth::user()->name }}</p>
                                <p class="text-blue-100 text-xs">Administrator</p>
                            </div>
                            <i class="ri-arrow-down-s-line text-white ml-2"></i>
                        </div>

                        <!-- Enhanced Dropdown Menu -->
                        <div class="absolute right-0 top-full mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-100 hidden group-hover:block z-50 overflow-hidden">
                            <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-100">
                                <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="py-2">
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="ri-user-settings-line mr-3 text-gray-400"></i>
                                    <span>Edit Profile</span>
                                </a>
                                <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="ri-settings-3-line mr-3 text-gray-400"></i>
                                    <span>Settings</span>
                                </a>
                                <div class="border-t border-gray-100 my-2"></div>
                                <form action="{{ route('logout') }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-3 text-red-600 hover:bg-red-50 transition-colors">
                                        <i class="ri-logout-box-line mr-3"></i>
                                        <span>Log Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Content Area -->
            <div class="p-8 animate-slide-in">
                @yield('content')
            </div>
        </main>
    </div>

</body>

</html>