@extends('layouts.app')
@section('content')

<div class="max-w-6xl mx-auto p-6">
    <!-- Order Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Order #{{ $order->id }}</h1>
                <p class="text-gray-600 mt-1">Placed on {{ $order->created_at->format('M j, Y \a\t g:i A') }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <button onclick="toggleStatusDropdown('order')" 
                            class="px-4 py-2 rounded-full text-sm font-medium cursor-pointer hover:opacity-80 transition-opacity
                        @if($order->order_status === 'delivered') bg-green-100 text-green-800
                        @elseif($order->order_status === 'processing') bg-blue-100 text-blue-800
                        @elseif($order->order_status === 'cancelled') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800
                        @endif">
                        @if($order->order_status === 'delivered')
                            <i class="ri-check-line mr-1"></i>Delivered
                        @elseif($order->order_status === 'processing')
                            <i class="ri-truck-line mr-1"></i>Processing
                        @elseif($order->order_status === 'cancelled')
                            <i class="ri-close-line mr-1"></i>Cancelled
                        @else
                            <i class="ri-time-line mr-1"></i>Pending
                        @endif
                        <i class="ri-arrow-down-s-line ml-1"></i>
                    </button>
                    
                    <div id="order-status-dropdown" 
                         class="absolute top-full right-0 mt-1 bg-white border border-gray-300 rounded-lg shadow-lg z-10 hidden min-w-36">
                        <form action="{{ route('admin.order.updateStatus', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit" name="order_status" value="pending" 
                                    class="dropdown-item w-full text-left px-3 py-2 hover:bg-gray-100 {{ $order->order_status === 'pending' ? 'bg-blue-50 text-blue-700' : '' }}">
                                <i class="ri-time-line mr-2"></i>Pending
                            </button>
                            <button type="submit" name="order_status" value="processing" 
                                    class="dropdown-item w-full text-left px-3 py-2 hover:bg-gray-100 {{ $order->order_status === 'processing' ? 'bg-blue-50 text-blue-700' : '' }}">
                                <i class="ri-truck-line mr-2"></i>Processing
                            </button>
                            <button type="submit" name="order_status" value="delivered" 
                                    class="dropdown-item w-full text-left px-3 py-2 hover:bg-gray-100 {{ $order->order_status === 'delivered' ? 'bg-blue-50 text-blue-700' : '' }}">
                                <i class="ri-check-line mr-2"></i>Delivered
                            </button>
                            <button type="submit" name="order_status" value="cancelled" 
                                    class="dropdown-item w-full text-left px-3 py-2 hover:bg-gray-100 {{ $order->order_status === 'cancelled' ? 'bg-blue-50 text-blue-700' : '' }}">
                                <i class="ri-close-line mr-2"></i>Cancelled
                            </button>
                        </form>
                    </div>
                </div>
                <a href="{{ route('admin.order.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    <i class="ri-arrow-left-line mr-2"></i>Back to Orders
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-700">Total Amount:</span>
                    <span class="text-2xl font-bold text-green-600">रू {{ number_format($order->total_amount, 2) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-700">Payment Method:</span>
                    <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm">
                        {{ ucfirst($order->payment_method) }}
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-700">Payment Status:</span>
                    <div class="relative inline-block">
                        <button onclick="toggleStatusDropdown('payment')" 
                                class="px-3 py-1 rounded-full text-sm font-medium cursor-pointer hover:opacity-80 transition-opacity
                            @if($order->payment_status === 'completed') bg-green-100 text-green-800
                            @elseif($order->payment_status === 'failed') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            @if($order->payment_status === 'completed')
                                <i class="ri-check-line mr-1"></i>Completed
                            @elseif($order->payment_status === 'failed')
                                <i class="ri-close-line mr-1"></i>Failed
                            @else
                                <i class="ri-time-line mr-1"></i>Pending
                            @endif
                            <i class="ri-arrow-down-s-line ml-1"></i>
                        </button>
                        
                        <div id="payment-status-dropdown" 
                             class="absolute top-full right-0 mt-1 bg-white border border-gray-300 rounded-lg shadow-lg z-10 hidden min-w-36">
                            <form action="{{ route('admin.order.updatePaymentStatus', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" name="payment_status" value="pending" 
                                        class="dropdown-item w-full text-left px-3 py-2 hover:bg-gray-100 {{ $order->payment_status === 'pending' ? 'bg-blue-50 text-blue-700' : '' }}">
                                    <i class="ri-time-line mr-2"></i>Pending
                                </button>
                                <button type="submit" name="payment_status" value="completed" 
                                        class="dropdown-item w-full text-left px-3 py-2 hover:bg-gray-100 {{ $order->payment_status === 'completed' ? 'bg-blue-50 text-blue-700' : '' }}">
                                    <i class="ri-check-line mr-2"></i>Completed
                                </button>
                                <button type="submit" name="payment_status" value="failed" 
                                        class="dropdown-item w-full text-left px-3 py-2 hover:bg-gray-100 {{ $order->payment_status === 'failed' ? 'bg-blue-50 text-blue-700' : '' }}">
                                    <i class="ri-close-line mr-2"></i>Failed
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Order Items -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">
                <i class="ri-shopping-bag-line mr-2"></i>Order Items
            </h2>
            <div class="space-y-4">
                @foreach($order->orderItems as $item)
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                        <div class="flex items-center space-x-4">
                            <img src="{{ Storage::url($item->foodItem->image) }}" alt="{{ $item->foodItem->name }}" 
                                 class="w-16 h-16 object-cover rounded-lg">
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $item->foodItem->name }}</h3>
                                <p class="text-gray-600 text-sm">{{ $item->foodItem->category->name }}</p>
                                <p class="text-green-600 font-medium">रू {{ number_format($item->price, 2) }} each</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-600">Qty: {{ $item->quantity }}</p>
                            <p class="font-bold text-gray-800">रू {{ number_format($item->price * $item->quantity, 2) }}</p>
                        </div>
                    </div>
                @endforeach
                
                <div class="border-t border-gray-200 pt-4">
                    <div class="flex justify-between items-center text-lg font-bold">
                        <span>Total:</span>
                        <span class="text-green-600">रू {{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer & Delivery Info -->
        <div class="space-y-6">
            <!-- Customer Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="ri-user-line mr-2"></i>Customer Information
                </h2>
                <div class="space-y-3">
                    <div>
                        <span class="font-medium text-gray-700">Name:</span>
                        <span class="ml-2 text-gray-900">{{ $order->user->name }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Email:</span>
                        <span class="ml-2 text-gray-900">{{ $order->user->email }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Phone:</span>
                        <span class="ml-2 text-gray-900">{{ $order->phone ?? 'Not provided' }}</span>
                    </div>
                </div>
            </div>

            <!-- Delivery Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="ri-map-pin-line mr-2"></i>Delivery Information
                </h2>
                <div class="space-y-3">
                    <div>
                        <span class="font-medium text-gray-700">Address:</span>
                        <p class="mt-1 text-gray-900">{{ $order->address ?? 'No address provided' }}</p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Special Instructions:</span>
                        <p class="mt-1 text-gray-900">{{ $order->special_instructions ?? 'None' }}</p>
                    </div>
                </div>
            </div>

            <!-- Payment Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="ri-credit-card-line mr-2"></i>Payment Details
                </h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="font-medium text-gray-700">Payment Method:</span>
                        <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm">
                            {{ ucfirst($order->payment_method) }}
                        </span>
                    </div>
                    @if($order->payment_method === 'esewa' && $order->transaction_id)
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-gray-700">Transaction ID:</span>
                            <span class="text-gray-900 font-mono text-sm">{{ $order->transaction_id }}</span>
                        </div>
                    @endif
                    <div class="flex items-center justify-between text-lg font-bold border-t border-gray-200 pt-3">
                        <span>Total Amount:</span>
                        <span class="text-green-600">रू {{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mt-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            <i class="ri-settings-line mr-2"></i>Quick Actions
        </h2>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.order.print', $order->id) }}" target="_blank" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="ri-printer-line mr-2"></i>Print Receipt
            </a>
            
            <form action="{{ route('admin.order.delete', $order->id) }}" method="POST" class="inline-block"
                  onsubmit="return confirm('Are you sure you want to delete this order?')">>
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    <i class="ri-delete-bin-line mr-2"></i>Delete Order
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function toggleStatusDropdown(type) {
    const dropdown = document.getElementById(type + '-status-dropdown');
    dropdown.classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const orderDropdown = document.getElementById('order-status-dropdown');
    const paymentDropdown = document.getElementById('payment-status-dropdown');
    
    if (!event.target.closest('.relative')) {
        if (orderDropdown) orderDropdown.classList.add('hidden');
        if (paymentDropdown) paymentDropdown.classList.add('hidden');
    }
});
</script>

@endsection
