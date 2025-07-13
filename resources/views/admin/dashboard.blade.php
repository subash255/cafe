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

    .pie-chart {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        position: relative;
        margin: 0 auto;
    }

    .activity-item {
        border-left: 3px solid #e2e8f0;
        padding-left: 1rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .activity-item:hover {
        border-left-color: #3b82f6;
        background: #f8fafc;
        border-radius: 0 8px 8px 0;
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
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
   

    <!-- Total Reservations Card -->
    <div class="dashboard-card rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Total Reservations</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalReservations }}</p>
               
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
                <p class="text-3xl font-bold text-gray-900 mt-2">Rs. {{ number_format($totalSales, 2) }}</p>
                
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
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalOrders }}</p>
               
            </div>
            <div class="stat-icon w-16 h-16 rounded-2xl flex items-center justify-center text-white"
                 style="--icon-color-1: #3b82f6; --icon-color-2: #2563eb;">
                <i class="ri-shopping-cart-line text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Chart Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Categories Distribution Pie Chart -->
    <div class="chart-container p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-6">Categories Distribution</h3>
        <div class="relative">
            <canvas id="categoriesPieChart" width="200" height="200" class="mx-auto"></canvas>
            <div class="text-center mt-4">
                <p class="text-2xl font-bold text-gray-800">{{ $totalCategories }}</p>
                <p class="text-sm text-gray-600">Total Categories</p>
            </div>
        </div>
        <div class="mt-4 space-y-2">
            @foreach($categoryData as $category)
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full mr-3" style="background-color: {{ $category['color'] }}"></div>
                    <span class="text-sm text-gray-700">{{ $category['name'] }}</span>
                </div>
                <span class="text-sm font-semibold text-gray-900">{{ $category['count'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Popular Items -->
    <div class="chart-container p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Popular Items</h3>
        <div class="space-y-4">
            @forelse($popularItems as $index => $item)
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold mr-3">
                        {{ $index + 1 }}
                    </div>
                    <div>
                        <span class="text-gray-700 font-medium">{{ $item->fooditem->name ?? 'Unknown Item' }}</span>
                        <p class="text-xs text-gray-500">Total orders: {{ $item->total_quantity }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="w-16 bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full" 
                             style="width: {{ min(100, ($item->total_quantity / $popularItems->max('total_quantity')) * 100) }}%"></div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center text-gray-500 py-8">
                <i class="ri-restaurant-line text-4xl mb-2"></i>
                <p>No orders yet</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="chart-container p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Activity</h3>
        <div class="space-y-4">
            @foreach($recentOrders->take(3) as $order)
            <div class="activity-item">
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-700">New order from {{ $order->user->name ?? 'Guest' }}</p>
                        <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }} - Rs. {{ number_format($order->total_amount, 2) }}</p>
                    </div>
                </div>
            </div>
            @endforeach

            @foreach($recentReservations->take(2) as $reservation)
            <div class="activity-item">
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-700">Reservation by {{ $reservation->name }}</p>
                        <p class="text-xs text-gray-500">{{ $reservation->created_at->diffForHumans() }} - {{ $reservation->people }} people</p>
                    </div>
                </div>
            </div>
            @endforeach

            @if($recentOrders->isEmpty() && $recentReservations->isEmpty())
            <div class="text-center text-gray-500 py-8">
                <i class="ri-time-line text-4xl mb-2"></i>
                <p>No recent activity</p>
            </div>
            @endif
        </div>
    </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
    // Categories Pie Chart
    const ctx = document.getElementById('categoriesPieChart').getContext('2d');
    const categoryData = @json($categoryData);
    
    if (categoryData.length > 0) {
        const data = categoryData.map(cat => cat.count);
        const labels = categoryData.map(cat => cat.name);
        const colors = categoryData.map(cat => cat.color);
        
        drawPieChart(ctx, data, colors, labels);
    } else {
        // Draw empty state
        ctx.fillStyle = '#e5e7eb';
        ctx.fillRect(0, 0, 200, 200);
        ctx.fillStyle = '#6b7280';
        ctx.font = '14px sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText('No categories yet', 100, 100);
    }
});

function drawPieChart(ctx, data, colors, labels) {
    const total = data.reduce((a, b) => a + b, 0);
    if (total === 0) return;
    
    const centerX = 100;
    const centerY = 100;
    const radius = 80;
    
    let currentAngle = -Math.PI / 2; // Start from top
    
    data.forEach((value, index) => {
        const sliceAngle = (value / total) * 2 * Math.PI;
        
        // Draw slice
        ctx.beginPath();
        ctx.moveTo(centerX, centerY);
        ctx.arc(centerX, centerY, radius, currentAngle, currentAngle + sliceAngle);
        ctx.closePath();
        ctx.fillStyle = colors[index];
        ctx.fill();
        
        // Draw border
        ctx.strokeStyle = '#ffffff';
        ctx.lineWidth = 2;
        ctx.stroke();
        
        currentAngle += sliceAngle;
    });
    
    // Draw center circle for donut effect (optional)
    ctx.beginPath();
    ctx.arc(centerX, centerY, 25, 0, 2 * Math.PI);
    ctx.fillStyle = '#ffffff';
    ctx.fill();
}
</script>

@endsection