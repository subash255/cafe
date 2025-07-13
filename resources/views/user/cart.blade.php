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
    <h2 class="text-3xl font-bold mb-6">Your Cart</h2>

    @if($cartItems && count($cartItems) > 0)
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-5">Food Item</th>
                    <th class="py-3 px-5">Quantity</th>
                    <th class="py-3 px-5">Price</th>
                    <th class="py-3 px-5">Total</th>
                    <th class="py-3 px-5">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                @foreach($cartItems as $id => $item)
                    <tr class="border-b">
                    @php $total = $item['price'] * $item['quantity']; $grandTotal += $total; @endphp
                    <tr class="border-t">
                        <td class="py-4 px-5 font-semibold">{{ $item['name'] }}</td>
                        <td class="py-4 px-5">
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="flex space-x-2">
                                @csrf
                                @method('PUT')
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-16 border rounded px-2 py-1">
                                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded">Update</button>
                            </form>
                        </td>
                        <td class="py-4 px-5">Rs {{ $item['price'] }}</td>
                        <td class="py-4 px-5 font-semibold">Rs {{ $total }}</td>
                        <td class="py-4 px-5">
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr class="bg-gray-100">
                    <td colspan="3" class="text-right font-bold py-4 px-5">Grand Total:</td>
                    <td class="font-bold text-green-600 py-4 px-5">Rs {{ $grandTotal }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('checkout') }}" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700">Proceed to Checkout</a>
    </div>

    @else
    <div class="text-center text-gray-600 text-lg">
        Your cart is empty.
    </div>
    @endif
</div>
@endsection
