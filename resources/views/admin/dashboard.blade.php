@extends('layouts.app')
@section('content')
<style>
    .dashboard-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .stat-icon {
        background: linear-gradient(135deg, var(--icon-color-1), var(--icon-color-2));
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }
    
    .chart-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
    }
</style>


<!-- Welcome Section -->
<div class="mb-8">
    <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 rounded-2xl p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-blue-100 text-lg">Here's what's happening with your cafe today</p>
            </div>
            <div class="hidden md:block">
                <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="ri-dashboard-3-line text-4xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Pending Orders Card -->
    <div class="dashboard-card rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Pending Orders</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">1</p>
                <div class="flex items-center mt-2">
                    <span class="text-sm text-green-600 font-medium">+2.5%</span>
                    <span class="text-sm text-gray-500 ml-2">vs yesterday</span>
                </div>
            </div>
            <div class="stat-icon w-16 h-16 rounded-2xl flex items-center justify-center text-white" 
                 style="--icon-color-1: #f59e0b; --icon-color-2: #d97706;">
                <i class="ri-time-line text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Reservations Card -->
    <div class="dashboard-card rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Total Reservations</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">2</p>
                <div class="flex items-center mt-2">
                    <span class="text-sm text-green-600 font-medium">+5.2%</span>
                    <span class="text-sm text-gray-500 ml-2">vs yesterday</span>
                </div>
            </div>
            <div class="stat-icon w-16 h-16 rounded-2xl flex items-center justify-center text-white"
                 style="--icon-color-1: #8b5cf6; --icon-color-2: #7c3aed;">
                <i class="ri-calendar-check-line text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Sales Card -->
    <div class="dashboard-card rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Total Sales</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">$300</p>
                <div class="flex items-center mt-2">
                    <span class="text-sm text-green-600 font-medium">+12.5%</span>
                    <span class="text-sm text-gray-500 ml-2">vs yesterday</span>
                </div>
            </div>
            <div class="stat-icon w-16 h-16 rounded-2xl flex items-center justify-center text-white"
                 style="--icon-color-1: #10b981; --icon-color-2: #059669;">
                <i class="ri-money-dollar-circle-line text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Orders Card -->
    <div class="dashboard-card rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Total Orders</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">4</p>
                <div class="flex items-center mt-2">
                    <span class="text-sm text-green-600 font-medium">+8.1%</span>
                    <span class="text-sm text-gray-500 ml-2">vs yesterday</span>
                </div>
            </div>
            <div class="stat-icon w-16 h-16 rounded-2xl flex items-center justify-center text-white"
                 style="--icon-color-1: #3b82f6; --icon-color-2: #2563eb;">
                <i class="ri-shopping-cart-line text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Chart Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
   

    <!-- Quick Stats -->
    <div class="space-y-6">
        <!-- Popular Items -->
        <div class="chart-container p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Popular Items Today</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                        <span class="text-gray-700">Cappuccino</span>
                    </div>
                    <span class="text-gray-900 font-semibold">24</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-gray-700">Chocolate Cake</span>
                    </div>
                    <span class="text-gray-900 font-semibold">18</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></div>
                        <span class="text-gray-700">Green Tea</span>
                    </div>
                    <span class="text-gray-900 font-semibold">15</span>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="chart-container p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Activity</h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                    <div>
                        <p class="text-sm text-gray-700">New order received</p>
                        <p class="text-xs text-gray-500">2 minutes ago</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                    <div>
                        <p class="text-sm text-gray-700">Reservation confirmed</p>
                        <p class="text-xs text-gray-500">15 minutes ago</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-purple-500 rounded-full mt-2"></div>
                    <div>
                        <p class="text-sm text-gray-700">New menu item added</p>
                        <p class="text-xs text-gray-500">1 hour ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection