@extends('layouts.master')

@section('title', 'User Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        

        <!-- Dashboard Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Quick Stats -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="ri-restaurant-line text-2xl text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Orders</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="ri-calendar-line text-2xl text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Reservations</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $totalReservations }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="ri-heart-line text-2xl text-red-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Favorites</p>
                        <p class="text-2xl font-semibold text-gray-900">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="ri-star-line text-2xl text-yellow-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Loyalty Points</p>
                        <p class="text-2xl font-semibold text-gray-900">0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h2>
                
                @if($recentOrders->count() > 0 || $recentReservations->count() > 0)
                    <div class="space-y-4 max-h-96 overflow-y-auto">
                        @foreach($recentOrders as $order)
                            <div class="border-l-4 border-blue-500 pl-4 py-2">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-900">Order #{{ $order->id }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $order->orderItems->count() }} item(s) - ${{ number_format($order->total_amount, 2) }}
                                        </p>
                                        <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        @if($order->payment_status === 'paid') bg-green-100 text-green-800
                                        @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                                @if($order->orderItems->count() > 0)
                                    <div class="mt-2">
                                        <p class="text-xs text-gray-500">Items: 
                                            @foreach($order->orderItems->take(3) as $item)
                                                {{ $item->fooditem->name ?? 'Unknown Item' }}@if(!$loop->last), @endif
                                            @endforeach
                                            @if($order->orderItems->count() > 3)
                                                and {{ $order->orderItems->count() - 3 }} more
                                            @endif
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        
                        @foreach($recentReservations as $reservation)
                            <div class="border-l-4 border-green-500 pl-4 py-2">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-900">Reservation #{{ $reservation->id }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $reservation->people }} guest(s) - {{ \Carbon\Carbon::parse($reservation->date)->format('M j, Y') }} at {{ \Carbon\Carbon::parse($reservation->time)->format('g:i A') }}
                                        </p>
                                        <p class="text-xs text-gray-500">{{ $reservation->created_at->diffForHumans() }}</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                        Confirmed
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="ri-file-list-line text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500">No recent activity to show</p>
                        <p class="text-sm text-gray-400 mt-2">Start by placing an order or making a reservation!</p>
                    </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('menu') }}" class="flex items-center justify-between p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors group">
                        <div class="flex items-center">
                            <i class="ri-restaurant-line text-blue-600 text-xl mr-3"></i>
                            <span class="font-medium text-gray-900">Browse Menu</span>
                        </div>
                        <i class="ri-arrow-right-line text-blue-600 group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <a href="{{ route('home') }}#reservation" class="flex items-center justify-between p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors group">
                        <div class="flex items-center">
                            <i class="ri-calendar-check-line text-green-600 text-xl mr-3"></i>
                            <span class="font-medium text-gray-900">Make Reservation</span>
                        </div>
                        <i class="ri-arrow-right-line text-green-600 group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    {{-- <a href="{{ route('profile.edit') }}" class="flex items-center justify-between p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors group">
                        <div class="flex items-center">
                            <i class="ri-user-settings-line text-purple-600 text-xl mr-3"></i>
                            <span class="font-medium text-gray-900">Edit Profile</span>
                        </div>
                        <i class="ri-arrow-right-line text-purple-600 group-hover:translate-x-1 transition-transform"></i>
                    </a> --}}

                    <a href="{{ route('contact') }}" class="flex items-center justify-between p-4 bg-orange-50 hover:bg-orange-100 rounded-lg transition-colors group">
                        <div class="flex items-center">
                            <i class="ri-customer-service-line text-orange-600 text-xl mr-3"></i>
                            <span class="font-medium text-gray-900">Contact Support</span>
                        </div>
                        <i class="ri-arrow-right-line text-orange-600 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
