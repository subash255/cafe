@extends('layouts.master')
@section('title', 'Checkout')
@section('content')

{{-- Flash Messages --}}
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
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Checkout</h2>
            <a href="{{ route('cart.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <i class="ri-arrow-left-line mr-2"></i>
                Back to Cart
            </a>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            <!-- Checkout Form -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Delivery Information</h3>
                </div>
                
                <form action="{{ route('process.payment') }}" method="POST" class="p-6">
                    @csrf
                    
                    <!-- Delivery Address -->
                    <div class="mb-6">
                        <label for="delivery_address" class="block text-sm font-medium text-gray-700 mb-2">
                            Delivery Address *
                        </label>
                        <textarea id="delivery_address" 
                                  name="delivery_address" 
                                  rows="3" 
                                  required
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Enter your complete delivery address...">{{ old('delivery_address') }}</textarea>
                        @error('delivery_address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div class="mb-6">
                        <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">
                            Phone Number *
                        </label>
                        <input type="tel" 
                               id="phone_number" 
                               name="phone_number" 
                               required
                               value="{{ old('phone_number') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Your contact number">
                        @error('phone_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Order Notes -->
                    <div class="mb-6">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Order Notes (Optional)
                        </label>
                        <textarea id="notes" 
                                  name="notes" 
                                  rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Any special instructions for your order...">{{ old('notes') }}</textarea>
                    </div>

                    <!-- Payment Method -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-4">
                            Payment Method *
                        </label>
                        
                        <div class="space-y-3">
                            <!-- Cash on Delivery -->
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" 
                                           name="payment_method" 
                                           value="cash_on_delivery" 
                                           class="text-blue-600 focus:ring-blue-500"
                                           {{ old('payment_method') == 'cash_on_delivery' ? 'checked' : '' }}>
                                    <div class="ml-3 flex items-center">
                                        <i class="ri-hand-coin-line text-2xl text-green-600 mr-3"></i>
                                        <div>
                                            <p class="font-medium text-gray-900">Cash on Delivery</p>
                                            <p class="text-sm text-gray-500">Pay when your order arrives</p>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- eSewa Payment -->
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" 
                                           name="payment_method" 
                                           value="esewa" 
                                           class="text-blue-600 focus:ring-blue-500"
                                           {{ old('payment_method') == 'esewa' ? 'checked' : '' }}>
                                    <div class="ml-3 flex items-center">
                                        <img src="https://esewa.com.np/common/images/esewa-logo.png" 
                                             alt="eSewa" 
                                             class="w-8 h-8 mr-3">
                                        <div>
                                            <p class="font-medium text-gray-900">Pay with eSewa</p>
                                            <p class="text-sm text-gray-500">Secure online payment via eSewa</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        @error('payment_method')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Place Order Button -->
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white py-3 px-4 rounded-lg hover:from-green-700 hover:to-green-800 transition-all font-semibold">
                        <i class="ri-shopping-bag-line mr-2"></i>
                        Place Order
                    </button>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden sticky top-4">
                <div class="bg-gray-50 px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Order Summary</h3>
                </div>
                
                <div class="p-6">
                    <!-- Cart Items -->
                    <div class="space-y-4 mb-6">
                        @foreach($cartItems as $item)
                        <div class="flex items-center space-x-3 py-2 border-b border-gray-100 last:border-b-0">
                            <div class="flex-shrink-0">
                                @if($item->fooditem->image)
                                    <img src="{{ asset('fooditem/' . $item->fooditem->image) }}" 
                                         alt="{{ $item->fooditem->name }}" 
                                         class="w-12 h-12 object-cover rounded">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                        <i class="ri-image-line text-gray-400"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900 text-sm">{{ $item->fooditem->name }}</h4>
                                <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-sm font-medium text-gray-900">
                                Rs {{ number_format($item->quantity * $item->price, 2) }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Order Totals -->
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="text-gray-900">Rs {{ number_format($grandTotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Delivery Fee</span>
                            <span class="text-green-600">Free</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tax</span>
                            <span class="text-gray-900">Rs 0.00</span>
                        </div>
                        <hr class="my-4">
                        <div class="flex justify-between text-lg font-bold">
                            <span class="text-gray-900">Total</span>
                            <span class="text-green-600">Rs {{ number_format($grandTotal, 2) }}</span>
                        </div>
                    </div>

                    <!-- Security Notice -->
                    <div class="mt-6 p-3 bg-blue-50 rounded-lg">
                        <div class="flex items-center text-sm text-blue-700">
                            <i class="ri-shield-check-line mr-2"></i>
                            <span>Your payment information is secure and encrypted</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
