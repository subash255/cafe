@extends('layouts.master')

@section('content')

{{-- Enhanced Flash Message --}}
@if (session('success'))
<div id="flash-message" class="fixed top-6 right-6 bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-4 rounded-xl shadow-lg z-50 flex items-center">
    <i class="ri-check-line text-xl mr-2"></i>
    <span class="font-medium">{{ session('success') }}</span>
</div>
@endif

@if (session('error'))
<div id="flash-message" class="fixed top-6 right-6 bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-4 rounded-xl shadow-lg z-50 flex items-center">
    <i class="ri-error-warning-line text-xl mr-2"></i>
    <span class="font-medium">{{ session('error') }}</span>
</div>
@endif

<script>
    if (document.getElementById('flash-message')) {
        setTimeout(() => {
            const msg = document.getElementById('flash-message');
            msg.style.opacity = 0;
            msg.style.transform = 'translateX(100%)';
            msg.style.transition = "all 0.5s ease-out";
            setTimeout(() => msg.remove(), 500);
        }, 3000);
    }
</script>

<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Your Cart</h2>
        <a href="{{ route('menu') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
            <i class="ri-arrow-left-line mr-2"></i>
            Continue Shopping
        </a>
    </div>

    @if($cartItems && count($cartItems) > 0)
    <div class="grid md:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="md:col-span-2">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Cart Items</h3>
                </div>
                
                <div class="divide-y divide-gray-200">
                    @foreach($cartItems as $item)
                    <div class="p-6 flex items-center space-x-4">
                        <!-- Food Image -->
                        <div class="flex-shrink-0">
                            @if($item->fooditem->image)
                                <img src="{{ asset('fooditem/' . $item->fooditem->image) }}" 
                                     alt="{{ $item->fooditem->name }}" 
                                     class="w-20 h-20 object-cover rounded-lg">
                            @else
                                <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <i class="ri-image-line text-gray-400 text-2xl"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Food Details -->
                        <div class="flex-1 min-w-0">
                            <h4 class="text-lg font-semibold text-gray-900 truncate">{{ $item->fooditem->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $item->fooditem->category->name ?? 'Uncategorized' }}</p>
                            <p class="text-lg font-bold text-green-600 mt-1">Rs {{ number_format($item->price, 2) }}</p>
                        </div>
                        
                        <!-- Quantity Controls -->
                        <div class="flex items-center space-x-3">
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center space-x-2">
                                @csrf
                                @method('PUT')
                                <label class="text-sm font-medium text-gray-700">Qty:</label>
                                <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                       min="1" max="10"
                                       class="w-16 px-2 py-1 border border-gray-300 rounded-md text-center focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <button type="submit" 
                                        class="bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700 transition-colors text-sm">
                                    <i class="ri-refresh-line"></i>
                                </button>
                            </form>
                        </div>
                        
                        <!-- Total & Remove -->
                        <div class="flex flex-col items-end space-y-2">
                            <p class="text-lg font-bold text-gray-900">Rs {{ number_format($item->quantity * $item->price, 2) }}</p>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-800 hover:bg-red-50 px-2 py-1 rounded transition-colors"
                                        onclick="return confirm('Are you sure you want to remove this item?')">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Cart Summary -->
        <div class="md:col-span-1">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden sticky top-4">
                <div class="bg-gray-50 px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Order Summary</h3>
                </div>
                
                <div class="p-6">
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Items ({{ $cartItems->sum('quantity') }})</span>
                            <span class="text-gray-900">Rs {{ number_format($grandTotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Delivery Fee</span>
                            <span class="text-green-600">Free</span>
                        </div>
                        <hr class="my-4">
                        <div class="flex justify-between text-lg font-bold">
                            <span class="text-gray-900">Total</span>
                            <span class="text-green-600">Rs {{ number_format($grandTotal, 2) }}</span>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <a href="{{ route('checkout') }}" 
                           class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white py-3 px-4 rounded-lg hover:from-green-700 hover:to-green-800 transition-all font-semibold text-center block">
                            <i class="ri-secure-payment-line mr-2"></i>
                            Proceed to Checkout
                        </a>
                    </div>
                    
                    <div class="mt-4 text-center">
                        <p class="text-xs text-gray-500">
                            <i class="ri-shield-check-line mr-1"></i>
                            Secure checkout powered by eSewa
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else
    <div class="text-center py-16">
        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
            <i class="ri-shopping-cart-line text-4xl text-gray-400"></i>
        </div>
        <h3 class="text-2xl font-semibold text-gray-800 mb-2">Your cart is empty</h3>
        <p class="text-gray-600 mb-6">Looks like you haven't added any items to your cart yet.</p>
        <a href="{{ route('menu') }}" 
           class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
            <i class="ri-restaurant-line mr-2"></i>
            Browse Menu
        </a>
    </div>
    @endif
</div>

@endsection
