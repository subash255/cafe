@extends('layouts.master')

@section('title', 'eSewa Payment')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6">
        <div class="text-center mb-6">
            <img src="https://cdn.esewa.com.np/ui/images/esewa_logo.png" alt="eSewa" class="mx-auto h-12 mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Pay with eSewa</h2>
            <p class="text-gray-600 mt-2">You will be redirected to eSewa to complete your payment</p>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Order ID:</span>
                <span class="font-semibold">#{{ $order->id }}</span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Amount:</span>
                <span class="font-semibold text-green-600">Rs {{ number_format($order->total_amount, 2) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Payment Method:</span>
                <span class="font-semibold">eSewa</span>
            </div>
        </div>

        <form action="{{ $paymentParams['form_url'] }}" method="POST" id="esewaForm">
            <input type="hidden" name="amount" value="{{ $paymentParams['amount'] }}">
            <input type="hidden" name="tax_amount" value="{{ $paymentParams['tax_amount'] }}">
            <input type="hidden" name="total_amount" value="{{ $paymentParams['total_amount'] }}">
            <input type="hidden" name="transaction_uuid" value="{{ $paymentParams['transaction_uuid'] }}">
            <input type="hidden" name="product_code" value="{{ $paymentParams['product_code'] }}">
            <input type="hidden" name="product_service_charge" value="{{ $paymentParams['product_service_charge'] }}">
            <input type="hidden" name="product_delivery_charge" value="{{ $paymentParams['product_delivery_charge'] }}">
            <input type="hidden" name="success_url" value="{{ $paymentParams['success_url'] }}">
            <input type="hidden" name="failure_url" value="{{ $paymentParams['failure_url'] }}">
            <input type="hidden" name="signed_field_names" value="{{ $paymentParams['signed_field_names'] }}">
            <input type="hidden" name="signature" value="{{ $paymentParams['signature'] }}">

            <button type="submit" class="w-full bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition duration-300 flex items-center justify-center">
                <i class="ri-bank-card-line mr-2"></i>
                Pay Rs {{ number_format($order->total_amount, 2) }}
            </button>
        </form>

        <div class="mt-4">
            <a href="{{ route('cart.index') }}" class="w-full bg-gray-200 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300 flex items-center justify-center">
                <i class="ri-arrow-left-line mr-2"></i>
                Back to Cart
            </a>
        </div>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500">
                For testing, use these credentials:<br>
                <strong>eSewa ID:</strong> 9806800001<br>
                <strong>Password:</strong> Nepal@123<br>
                <strong>Token:</strong> 123456
            </p>
        </div>

        <!-- Auto-redirect message -->
        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
            <div class="flex items-center text-sm text-blue-700">
                <i class="ri-information-line mr-2"></i>
                <span>You will be automatically redirected to eSewa in <span id="countdown">5</span> seconds</span>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-redirect countdown
let countdown = 5;
const countdownElement = document.getElementById('countdown');
const form = document.getElementById('esewaForm');

const timer = setInterval(() => {
    countdown--;
    countdownElement.textContent = countdown;
    
    if (countdown <= 0) {
        clearInterval(timer);
        form.submit();
    }
}, 1000);

// Allow manual form submission to cancel auto-redirect
form.addEventListener('submit', () => {
    clearInterval(timer);
});
</script>

@endsection
