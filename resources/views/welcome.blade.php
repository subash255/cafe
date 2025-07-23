@extends('layouts.master')
@section('title', 'Welcome | Nepali Cafe')
@section('content')

{{-- Enhanced Flash Message --}}
@if (session('success'))
<div id="flash-message" class="fixed top-6 right-6 bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-4 rounded-xl shadow-lg z-50 flex items-center">
    <i class="ri-check-line text-xl mr-2"></i>
    <span class="font-medium">{{ session('success') }}</span>
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

    <div style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 14, 14, 0.5)), url('images/bg.jpg')"
        class="bg-cover bg-center w-full">
        <div class="text-tertiary py-12 sm:py-16 md:py-24 lg:py-36 xl:px-0 lg:px-0 sm:px-6">
            <div class="xl:max-w-7xl w-full mx-auto px-6">
                <h3 class="font-bold uppercase text-center sm:text-left">
                    Welcome to Nepali Cafe
                </h3>
                <h1 class="md:text-4xl sm:text-3xl text-2xl font-bold mt-6 text-center sm:text-left">
                    The best place to enjoy your meal
                </h1>
                <p class="mt-6 sm:text-base text-sm text-center sm:text-left">
                    At Nepali Cafe, we offer a cozy and welcoming atmosphere where you can relax and savor your favorite meals
                    and drinks. <br class="lg:block hidden"> Come in, unwind, and enjoy the perfect blend of flavors,
                    comfort, and good company.
                </p>
                <div class="mt-8 flex flex-wrap items-center justify-center sm:justify-start gap-4">

    <!-- Order Now Button -->
    <a href="{{ route('menu') }}" class="group">
        <button class="relative bg-gradient-to-r from-red-500 to-red-800 hover:from-orange-800 hover:to-red-600 text-white py-2 px-8 rounded-full shadow-lg transition-all duration-300 transform group-hover:scale-105">
            <div class="flex items-center gap-x-2">
                <i class="fas fa-utensils text-xl"></i>
                <span class="text-lg font-semibold tracking-wide">Order Now!</span>
            </div>
        </button>
    </a>

    <!-- Book Table Button -->
    <a href="{{ route('home') }}#tablereservation" class="group">
        <button class="relative bg-primary text-white hover:bg-secondary hover:text-white py-2 px-8 rounded-md shadow-md transition-all duration-300 transform group-hover:scale-105">
            <div class="flex items-center gap-x-2">
                <i class="fas fa-calendar-check text-xl"></i>
                <span class="text-lg font-semibold tracking-wide">Book Table!</span>
            </div>
        </button>
    </a>

</div>

            </div>
        </div>
    </div>

    <!-- Recommended for You Section (Only for logged in users with cart items) -->
    @auth
    @if(isset($recommendedItems) && $recommendedItems->count() > 0)
    <section class="bg-white py-16 xl:px-12 lg:px-8 sm:px-5 px-3">
        <div class="xl:max-w-7xl w-full mx-auto">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-secondary">
                    <i class="ri-heart-line text-red-500 mr-2"></i>Recommended for You
                </h2>
                <p class="text-xl mt-4 text-quaternary">
                    Based on your recent selections, we think you'll love these items too!
                </p>
            </div>

            <div class="swiper swiper-recommended mt-12 relative">
                <div class="swiper-wrapper">
                    @foreach($recommendedItems as $item)
                        <div class="swiper-slide">
                            <div class="bg-white shadow-lg border border-gray-200 rounded-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:scale-105 h-full">
                                <div class="relative">
                                    <img src="{{ asset('fooditem/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-48 object-cover">
                                    <div class="absolute top-3 right-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-xs px-3 py-1 rounded-full shadow-lg">
                                        <i class="ri-thumb-up-line mr-1"></i>For You
                                    </div>
                                    @if($item->status == 1)
                                    <div class="absolute top-3 left-3 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs px-3 py-1 rounded-full shadow-lg">
                                        <i class="ri-fire-line mr-1"></i>Popular
                                    </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                                </div>
                                <div class="p-5">
                                    <div class="flex items-start justify-between mb-3">
                                        <h3 class="text-lg font-bold text-gray-800 line-clamp-1">{{ $item->name }}</h3>
                                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full ml-2 whitespace-nowrap">
                                            {{ $item->category->name ?? 'Uncategorized' }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 line-clamp-2 mb-4 min-h-[2.5rem]">{{ $item->description }}</p>
                                    
                                    <div class="flex items-center justify-between">
                                        <p class="text-xl font-bold text-secondary">Rs. {{ $item->price }}</p>
                                        
                                        <form action="{{ route('cart.store', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="price" value="{{ $item->price }}">
                                            <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-3 py-2 rounded-lg font-medium transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg transform hover:scale-105">
                                                <i class="ri-shopping-cart-line text-sm"></i>
                                                <span class="text-sm">Add</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                
                <!-- Pagination -->
                <div class="swiper-pagination swiper-pagination-recommended !bottom-0 !relative !mt-6"></div>
            </div>

            <div class="mt-8 flex justify-center items-center">
                <a href="{{ route('menu') }}" class="bg-blue-500 hover:bg-blue-600 rounded-full p-2 px-6 text-white font-bold transition-all duration-300">
                    <i class="ri-external-link-line mr-2"></i>Explore More
                </a>
            </div>
        </div>
    </section>
    
    @endif
    @endauth

    <!-- About Section -->
    <section class="py-20 xl:px-16 lg:px-12 sm:px-8 px-6 bg-gray-50">
        <div class="xl:max-w-7xl w-full mx-auto">
            <div class="grid sm:grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Image Section -->
                <div class="relative">
                    <img src="images/cafe.jpg" alt="About Us" class="w-full h-96 object-cover rounded-lg shadow-xl">
                </div>
    
                <!-- Text Section -->
                <div>
                    <h2 class="text-4xl font-semibold text-secondary leading-tight border-l-4 border-primary pl-4">About Us</h2>
                    <p class="mt-2 text-lg text-quaternary leading-relaxed">
                        Nepali Cafe is a family-owned cafe that has been proudly serving the community for over 20 years. Our
                        mission is to provide an exceptional dining experience with every visit, ensuring you feel at home
                        in our cozy atmosphere.
                    </p>
                    <p class="mt-2 text-lg text-quaternary leading-relaxed">
                        We offer a diverse range of delicious meals and beverages, all prepared with the highest quality
                        ingredients. Whether you're in the mood for a quick snack or a satisfying meal, we have something to
                        satisfy every craving.
                    </p>
                    <div class="mt-8">
                        <a href="{{ route('about') }}"
                            class="px-4 py-2 bg-secondary text-tertiary font-semibold text-lg rounded-lg text-center shadow-lg transition-all duration-300 hover:bg-primary hover:shadow-xl">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Dynamic Menu Preview Section -->
<section class="bg-gray-50 py-10 xl:px-12 lg:px-8 sm:px-5 px-3">
    <div class="xl:max-w-7xl w-full mx-auto">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-secondary">Our Popular Items</h2>
            <p class="text-xl mt-4 text-quaternary">
                Discover a variety of delicious meals and drinks, carefully crafted to satisfy your cravings.
            </p>
        </div>

        <div class="swiper swiper-container mt-12">
            <div class="swiper-wrapper">
                @forelse($popularItems as $menu)
                    <div class="swiper-slide">
                        <div class="bg-tertiary shadow-lg border border-gray-200 rounded-lg overflow-hidden">
                            <img src="{{ asset('fooditem/' . $menu->image) }}" alt="{{ $menu->name }}" class="w-full h-64 object-cover">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-xl font-semibold text-gray-800">{{ $menu->name }}</h3>
                                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">Popular</span>
                                </div>
                                <p class="mt-2 text-quaternary">{{ $menu->description }}</p>
                                
                                <div class="flex items-center justify-between mt-4">
                                    <p class="text-lg text-gray-800 font-semibold">Rs. {{ $menu->price }}</p>
                                    
                                    <form action="{{ route('cart.store', $menu->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="price" value="{{ $menu->price }}">
                                        <button type="submit" class="bg-secondary hover:bg-secondary/90 text-white px-2 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
                                            <i class="ri-shopping-cart-line"></i>
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="swiper-slide">
                        <div class="bg-tertiary shadow-lg border border-gray-200 rounded-lg p-8 text-center">
                            <i class="ri-restaurant-line text-4xl text-gray-400 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-600">No Popular Items</h3>
                            <p class="text-gray-500 mt-2">Popular items will appear here when marked by admin</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-5 flex justify-center items-center">
            <a href="{{ route('menu') }}" class="bg-secondary hover:bg-primary rounded-full p-2 px-6 text-tertiary font-bold transition-all duration-300">
                More Menus
            </a>
        </div>
    </div>
</section>

    <!-- Reservation Section -->
<div id="tablereservation"
    style="background-image: linear-gradient(rgba(17, 17, 17, 0.96), rgba(23, 16, 7, 0.89)), url('images/reserve.jpg');"
    class="bg-cover bg-center overflow-hidden reserve">
    <div class="xl:px-12 py-16 lg:px-8 sm:px-5 px-3">
        <div class="2xl:max-w-[1600px] xl:max-w-[1280px] w-full mx-auto">
            <div class="text-center">
                <h3 class="sm:text-3xl text-xl text-secondary font-bold">
                    Online Table Reservation
                </h3>
            </div>

            <!-- Show validation errors -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 mt-8">
                    <ul class="list-disc pl-5 text-left">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mt-10">
                <form action="{{ route('reservation.store') }}" autocomplete="off" method="POST">
                    @csrf
                    <div class="grid sm:grid-cols-2 gap-x-6 gap-y-12">
                        <div>
                            <label for="name" class="relative">
                                <input type="text" placeholder="Name" name="name" value="{{ old('name', auth()->user()->name ?? '')  }}"
                                    class="w-full py-3 rounded-full bg-tertiary border border-blue-600 focus:border-blue-600 focus:ring-0 pl-6 text-black placeholder:text-black">
                                <span class="absolute inset-y-0 right-0 flex items-center pr-6">
                                    <i class="ri-user-3-line"></i>
                                </span>
                            </label>
                        </div>

                        <div>
                            <label for="email" class="relative">
                                <input type="email" placeholder="Enter email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}"
                                    class="w-full py-3 rounded-full bg-tertiary border border-blue-600 focus:border-blue-600 focus:ring-0 pl-6 text-black placeholder:text-black">
                                <span class="absolute inset-y-0 right-0 flex items-center pr-6">
                                    <i class="ri-mail-line"></i>
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-x-6 gap-y-12 mt-12">
                        <div>
                            <label for="phone" class="relative">
                                <input type="text" placeholder="Phone" name="phone" value="{{ old('phone') }}"
                                    class="w-full py-3 rounded-full bg-tertiary border border-blue-600 focus:border-blue-600 focus:ring-0 pl-6 text-black placeholder:text-black">
                                <span class="absolute inset-y-0 right-0 flex items-center pr-6">
                                    <i class="ri-phone-line"></i>
                                </span>
                            </label>
                        </div>

                        <div>
                            <label for="people" class="relative">
                                <input type="text" placeholder="No. of People" name="people" value="{{ old('people') }}"
                                    class="w-full py-3 rounded-full bg-tertiary border border-blue-600 focus:border-blue-600 focus:ring-0 pl-6 text-black placeholder:text-black">
                                <span class="absolute inset-y-0 right-0 flex items-center pr-6">
                                    <i class="ri-group-line"></i>
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-x-6 gap-y-12 mt-12">
                        <div>
                            <label for="date" class="relative">
                                <input type="date" placeholder="yyyy/mm/dd" name="date" value="{{ old('date') }}"
                                    class="w-full py-3 rounded-full bg-tertiary border border-blue-600 focus:border-blue-600 focus:ring-0 pl-6 text-black placeholder:text-black">
                                <span class="absolute inset-y-0 right-0 flex items-center pr-6">
                                    <i class="ri-calendar-line"></i>
                                </span>
                            </label>
                        </div>

                        <div>
                            <label for="time" class="relative">
                                <input type="time" placeholder="Select Time" name="time" value="{{ old('time') }}"
                                    class="w-full py-3 rounded-full bg-tertiary border border-blue-600 focus:border-blue-600 focus:ring-0 pl-6 text-black placeholder:text-black">
                                <span class="absolute inset-y-0 right-0 flex items-center pr-6">
                                    <i class="ri-time-line"></i>
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="mt-12 text-center">
                        <button type="submit"
                            class="py-3 px-12 text-tertiary rounded-full text-xl font-semibold bg-secondary hover:bg-primary">
                            <span class="relative z-10">Reserve Now</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Testimonial Section -->
    <section class="bg-gray-50 py-16 xl:px-12 lg:px-8 sm:px-5 px-3">
        <div class="xl:max-w-7xl w-full mx-auto">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-secondary">Testimonials</h2>
                <p class="text-xl mt-4 text-quaternary">See what our customers have to say about their experience with us.
                </p>
            </div>
            <div class="swiper swiper-testimonials mt-4">
                <div class="swiper-wrapper pt-12">
                    <!-- Testimonial 1 -->
                    <div class="swiper-slide bg-tertiary border border-gray-200 rounded-lg shadow-lg p-6 text-center">
                        <!-- User icon instead of image -->
                        <div
                            class="w-20 h-20 rounded-full mx-auto border-2 border-blue-400 shadow-md bg-tertiary flex items-center justify-center -mt-16">
                            <i class="ri-user-fill text-black text-3xl"></i>
                        </div>
                        <p class="mt-4 text-quaternary italic">
                            <span class="text-secondary text-xl">"</span>I love the variety of smoothies and fresh salads.
                            Always a healthy and tasty option!<span class="text-secondary text-xl">"</span>
                        </p>
                        <h4 class="mt-4 text-primary font-bold">Sohan Kafle</h4>
                    </div>
                    <!-- Testimonial 2 -->
                    <div class="swiper-slide bg-tertiary border border-gray-200 rounded-lg shadow-lg p-6 text-center">
                        <!-- User icon instead of image -->
                        <div
                            class="w-20 h-20 rounded-full mx-auto border-2 border-blue-400 shadow-md bg-tertiary flex items-center justify-center -mt-16">
                            <i class="ri-user-fill text-black text-3xl"></i>
                        </div>
                        <p class="mt-4 text-quaternary italic">
                            <span class="text-secondary text-xl">"</span>Such a cozy place with great vibes. The vegan
                            smoothie is a game-changer!<span class="text-secondary text-xl">"</span>
                        </p>
                        <h4 class="mt-4 text-primary font-bold">Subash Adhikari</h4>
                    </div>
                    <!-- Testimonial 3 -->
                    <div class="swiper-slide bg-tertiary border border-gray-200 rounded-lg shadow-lg p-6 text-center">
                        <!-- User icon instead of image -->
                        <div
                            class="w-20 h-20 rounded-full mx-auto border-2 border-blue-400 shadow-md bg-tertiary flex items-center justify-center -mt-16">
                            <i class="ri-user-fill text-black text-3xl"></i>
                        </div>
                        <p class="mt-4 text-quaternary italic">
                            <span class="text-secondary text-xl">"</span>The staff is friendly, and the food is always fresh.
                            I'm definitely coming back for more!<span class="text-secondary text-xl">"</span>
                        </p>
                        <h4 class="mt-4 text-primary font-bold">Pramisha Thapa</h4>
                    </div>
                    <!-- Testimonial 4 -->
                    <div class="swiper-slide bg-tertiary border border-gray-200 rounded-lg shadow-lg p-6 text-center">
                        <!-- User icon instead of image -->
                        <div
                            class="w-20 h-20 rounded-full mx-auto border-2 border-blue-400 shadow-md bg-tertiary flex items-center justify-center -mt-16">
                            <i class="ri-user-fill text-black text-3xl"></i>
                        </div>
                        <p class="mt-4 text-quaternary italic">
                            <span class="text-secondary text-xl">"</span>Absolutely love this place. The fruit bowls are
                            always so fresh and refreshing!<span class="text-secondary text-xl">"</span>
                        </p>
                        <h4 class="mt-4 text-primary font-bold">Ishika Sigdel</h4>
                    </div>
                    <!-- Testimonial 5 -->
                    <div class="swiper-slide bg-tertiary border border-gray-200 rounded-lg shadow-lg p-6 text-center">
                        <!-- User icon instead of image -->
                        <div
                            class="w-20 h-20 rounded-full mx-auto border-2 border-blue-400 shadow-md bg-tertiary flex items-center justify-center -mt-16">
                            <i class="ri-user-fill text-black text-3xl"></i>
                        </div>
                                                <p class="mt-4 text-quaternary italic">
                            <span class="text-secondary text-xl">"</span>The food here is amazing! The coffee and pastries
                            are the perfect combination. <span class="text-secondary text-xl">"</span>
                        </p>
                        <h4 class="mt-4 text-primary font-bold">Aakash Kandel</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
 