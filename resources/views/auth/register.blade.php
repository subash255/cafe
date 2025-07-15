@extends('layouts.master')

@section('title', 'Register | Nepali Cafe')

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
        }, 4000);
    }
</script>

<div class="flex items-center justify-center min-h-screen bg-[#fef6f0] py-8 px-4">
  <div class="w-full max-w-4xl bg-white shadow-lg rounded-lg overflow-hidden flex flex-col md:flex-row">

    <!-- Image Section -->
    <div class="hidden md:block md:w-1/2 bg-cover bg-center"
      style="background-image: url('https://images.unsplash.com/photo-1511920170033-f8396924c348?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80')">
    </div>

    <!-- Form Section -->
    <div class="w-full md:w-1/2 p-8">
      <div class="mb-6 text-center">
        <img src="{{ asset('images/g.png') }}" alt="Nepali Cafe Logo" class="mx-auto h-24 mb-4">
        <h2 class="text-3xl font-bold text-primary">Join Nepali Cafe </h2>
        <p class="text-sm text-gray-500 mt-1">Create an account to enjoy our delicious offerings</p>
      </div>

      <form method="POST" action="{{ route('register') }}" class="space-y-4">
    @csrf

    <!-- Name -->
    <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name"
        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-primary @error('name') border-red-500 @enderror" required>
    @error('name')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror

    <!-- Email -->
    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"
        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-primary @error('email') border-red-500 @enderror" required>
    @error('email')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror

    <!-- Password -->
    <input type="password" name="password" placeholder="Password"
        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-primary @error('password') border-red-500 @enderror" required>
    @error('password')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror

    <!-- Password Confirmation -->
    <input type="password" name="password_confirmation" placeholder="Confirm Password"
        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-primary" required>

    <button type="submit"
        class="w-full bg-primary text-white py-2 rounded hover:bg-secondary transition">Register</button>
</form>


      <div class="mt-4 text-center text-sm">
        Already have an account?
        <a href="{{ route('login') }}" class="text-primary hover:underline">Login here</a>
      </div>
    </div>
  </div>
</div>
@endsection
