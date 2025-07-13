@extends('layouts.master')

@section('content')

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Success Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                <i class="ri-check-line text-4xl text-green-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Order Confirmed!</h1>
            <p class="text-gray-600">Thank you for your order. We'll prepare it with care.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            <!-- Order Details -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Order Details</h3>
                </div>
                
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order Number:</span>
                            <span class="font-semibold">#{{ $order->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order Date:</span>
                            <span class="font-semibold">{{ $order->created_at->format('M d, Y - h:i A') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Method:</span>
                            <span class="font-semibold capitalize">
                                @if($order->payment_method === 'cash_on_delivery')
                                    <i class="ri-hand-coin-line mr-1"></i>Cash on Delivery
                                @else
                                    <i class="ri-secure-payment-line mr-1"></i>eSewa Payment
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Status:</span>
                            <span class="font-semibold">
                                @if($order->payment_status === 'completed')
                                    <span class="text-green-600">
                                        <i class="ri-check-line mr-1"></i>Paid
                                    </span>
                                @else
                                    <span class="text-yellow-600">
                                        <i class="ri-time-line mr-1"></i>Pending
                                    </span>
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order Status:</span>
                            <span class="font-semibold text-blue-600 capitalize">
                                <i class="ri-shopping-bag-line mr-1"></i>{{ $order->order_status }}
                            </span>
                        </div>
                        @if($order->payment_reference)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Reference:</span>
                            <span class="font-semibold">{{ $order->payment_reference }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Delivery Information -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Delivery Information</h3>
                </div>
                
                <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <span class="text-gray-600 block mb-1">Delivery Address:</span>
                            <p class="font-semibold">{{ $order->delivery_address }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600 block mb-1">Contact Number:</span>
                            <p class="font-semibold">{{ $order->phone_number }}</p>
                        </div>
                        @if($order->notes)
                        <div>
                            <span class="text-gray-600 block mb-1">Order Notes:</span>
                            <p class="font-semibold">{{ $order->notes }}</p>
                        </div>
                        @endif
                        <div>
                            <span class="text-gray-600 block mb-1">Estimated Delivery:</span>
                            <p class="font-semibold text-green-600">30-45 minutes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="mt-8 bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b">
                <h3 class="text-lg font-semibold text-gray-800">Order Items</h3>
            </div>
            
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($order->orderItems as $item)
                    <div class="flex items-center space-x-4 py-3 border-b border-gray-100 last:border-b-0">
                        <div class="flex-shrink-0">
                            @if($item->fooditem->image)
                                <img src="{{ asset('fooditem/' . $item->fooditem->image) }}" 
                                     alt="{{ $item->fooditem->name }}" 
                                     class="w-16 h-16 object-cover rounded-lg">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <i class="ri-image-line text-gray-400 text-xl"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">{{ $item->fooditem->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $item->fooditem->category->name ?? 'Uncategorized' }}</p>
                            <p class="text-sm text-gray-600">Qty: {{ $item->quantity }} × Rs {{ number_format($item->price, 2) }}</p>
                        </div>
                        <div class="text-lg font-bold text-gray-900">
                            Rs {{ number_format($item->total, 2) }}
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Order Total -->
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-bold text-gray-800">Total Amount:</span>
                        <span class="text-2xl font-bold text-green-600">Rs {{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 text-center space-x-4">
            <a href="{{ route('menu') }}" 
               class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                <i class="ri-restaurant-line mr-2"></i>
                Order Again
            </a>
            <a href="{{ route('user.dashboard') }}" 
               class="inline-flex items-center bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors">
                <i class="ri-dashboard-line mr-2"></i>
                Go to Dashboard
            </a>
        </div>

        <!-- Important Notice -->
        @if($order->payment_method === 'cash_on_delivery')
        <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
            <div class="flex items-start">
                <i class="ri-information-line text-yellow-600 text-xl mr-3 mt-1"></i>
                <div>
                    <h4 class="font-semibold text-yellow-800 mb-2">Cash on Delivery</h4>
                    <p class="text-yellow-700">
                        Please keep the exact amount ready (Rs {{ number_format($order->total_amount, 2) }}) 
                        for the delivery person. Our delivery team will contact you shortly.
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection
