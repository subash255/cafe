@extends('layouts.master')
@section('title', 'Menu | Nepali Cafe')
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
<!-- Hero Section with Enhanced Design -->
<div style="background-image: url('images/cup.jpeg');" class="bg-cover bg-center h-60 md:h-80 relative">
    <div class="bg-gradient-to-r from-black/80 via-black/60 to-black/40 absolute inset-0 flex items-center justify-center">
        <div class="text-center space-y-4">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 tracking-wide">
                Our <span class="text-tertiary">Menu</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-200 max-w-2xl mx-auto leading-relaxed">
                Discover our carefully crafted selection of artisanal coffees, teas, and delicious treats
            </p>
            <div class="w-24 h-1 bg-tertiary mx-auto mt-6"></div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 py-12">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Explore Our Delicious Offerings</h2>
            <p class="text-gray-600 max-w-2xl mx-auto text-lg">From expertly brewed coffees to delectable pastries, every item is made with passion and the finest ingredients</p>
        </div>

        

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Enhanced Sidebar (Search + Filters) -->
            <aside class="w-full lg:w-1/4 space-y-6">
                <!-- Search Section -->
                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                    <div class="flex items-center mb-4">
                        <i class="ri-search-line text-secondary text-xl mr-2"></i>
                        <label for="search" class="text-lg font-semibold text-gray-800">Search Menu</label>
                    </div>
                    <div class="relative">
                        <input type="text" id="search" placeholder="Search for coffee, tea, desserts..." 
                               class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200">
                        <i class="ri-search-line absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                    <div class="flex items-center mb-4">
                        <i class="ri-menu-line text-secondary text-xl mr-2"></i>
                        <h2 class="text-lg font-semibold text-gray-800">Categories</h2>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-center group">
                            <input type="checkbox" id="coffee" class="mr-3 w-4 h-4 text-secondary border-gray-300 rounded focus:ring-secondary focus:ring-2">
                            <label for="coffee" class="text-gray-700 group-hover:text-secondary transition-colors cursor-pointer flex items-center">
                                <i class="ri-cup-line mr-2 text-amber-600"></i>
                                Coffee
                            </label>
                        </li>
                        <li class="flex items-center group">
                            <input type="checkbox" id="tea" class="mr-3 w-4 h-4 text-secondary border-gray-300 rounded focus:ring-secondary focus:ring-2">
                            <label for="tea" class="text-gray-700 group-hover:text-secondary transition-colors cursor-pointer flex items-center">
                                <i class="ri-cup-line mr-2 text-green-600"></i>
                                Tea
                            </label>
                        </li>
                        <li class="flex items-center group">
                            <input type="checkbox" id="desserts" class="mr-3 w-4 h-4 text-secondary border-gray-300 rounded focus:ring-secondary focus:ring-2">
                            <label for="desserts" class="text-gray-700 group-hover:text-secondary transition-colors cursor-pointer flex items-center">
                                <i class="ri-cake-3-line mr-2 text-pink-600"></i>
                                Desserts
                            </label>
                        </li>
                        <li class="flex items-center group">
                            <input type="checkbox" id="breakfast" class="mr-3 w-4 h-4 text-secondary border-gray-300 rounded focus:ring-secondary focus:ring-2">
                            <label for="breakfast" class="text-gray-700 group-hover:text-secondary transition-colors cursor-pointer flex items-center">
                                <i class="ri-restaurant-line mr-2 text-orange-600"></i>
                                Breakfast
                            </label>
                        </li>
                        <li class="flex items-center group">
                            <input type="checkbox" id="snacks" class="mr-3 w-4 h-4 text-secondary border-gray-300 rounded focus:ring-secondary focus:ring-2">
                            <label for="snacks" class="text-gray-700 group-hover:text-secondary transition-colors cursor-pointer flex items-center">
                                <i class="ri-cookie-line mr-2 text-yellow-600"></i>
                                Snacks
                            </label>
                        </li>
                    </ul>
                </div>

                <!-- Price Filter -->
                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                    <div class="flex items-center mb-4">
                        <i class="ri-money-dollar-circle-line text-secondary text-xl mr-2"></i>
                        <h2 class="text-lg font-semibold text-gray-800">Price Range</h2>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="relative flex-1">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rs. </span>
                                <input type="number" placeholder="Min" class="w-full pl-8 pr-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">
                            </div>
                            <span class="text-gray-400">to</span>
                            <div class="relative flex-1">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rs. </span>
                                <input type="number" placeholder="Max" class="w-full pl-8 pr-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">
                            </div>
                        </div>
                        <button class="w-full bg-secondary text-white py-2 rounded-lg hover:bg-secondary/90 transition-colors duration-200 font-medium">
                            Apply Filter
                        </button>
                    </div>
                </div>

                <!-- Popular Items -->
                <div class="bg-gradient-to-br from-secondary/10 to-tertiary/10 rounded-xl p-6 border border-secondary/20">
                    <div class="flex items-center mb-4">
                        <i class="ri-fire-line text-secondary text-xl mr-2"></i>
                        <h2 class="text-lg font-semibold text-gray-800">Popular Today</h2>
                    </div>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">Cappuccino</span>
                            <span class="text-secondary font-medium">Rs. 4.50</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">Chocolate Cake</span>
                            <span class="text-secondary font-medium">Rs. 5.50</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">Green Tea</span>
                            <span class="text-secondary font-medium">Rs. 3.00</span>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Enhanced Menu Items Grid -->
            <section class="w-full lg:w-3/4">
                <!-- Sort and View Options -->
                <div class="bg-white rounded-xl shadow-md p-4 mb-8 border border-gray-100">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="flex items-center gap-2">
                            <span class="text-gray-700 font-medium">Sort by:</span>
                            <select class="px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">
                                <option>Most Popular</option>
                                <option>Price: Low to High</option>
                                <option>Price: High to Low</option>
                                <option>Newest</option>
                            </select>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-700 font-medium">View:</span>
                            <div class="flex rounded-lg border border-gray-200 overflow-hidden">
                                <button class="px-3 py-2 bg-secondary text-white">
                                    <i class="ri-grid-line"></i>
                                </button>
                                <button class="px-3 py-2 bg-gray-100 text-gray-600 hover:bg-gray-200">
                                    <i class="ri-list-check"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menu Items Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                    <!-- Enhanced Item Card 1 -->
                     @foreach($menus as $menu)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="relative overflow-hidden">
                            <img src="{{ asset('fooditem/' . $menu->image) }}" alt="{{ $menu->name }}"  class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                            @if($menu->status == 1)
                            <div class="absolute top-4 left-4">
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-medium">
                                    <i class="ri-fire-line mr-1"></i>Popular
                                </span>
                            </div>
                            @endif
                            <div class="absolute top-4 right-4">
                                <button class="bg-white/90 backdrop-blur-sm text-gray-600 hover:text-red-500 w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                                    <i class="ri-heart-line"></i>
                                </button>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-bold text-xl text-gray-800 group-hover:text-secondary transition-colors">{{$menu->name}}</h3>
                                <div class="flex items-center">
                                    <div class="flex text-yellow-400 text-sm">
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-line"></i>
                                    </div>
                                    <span class="text-gray-500 text-xs ml-1">(4.2)</span>
                                </div>
                            </div>
                            <p class="text-gray-600 mb-4 leading-relaxed">{{$menu->description}}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-xl font-bold text-secondary">Rs. {{$menu->price}}</span>
                                <form action="{{ route('cart.store' ,$menu->id) }}" method="POST">
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
                  @endforeach
                    
                </div>

                <!-- Load More Button -->
                <div class="text-center mt-12">
                    <button class="bg-white hover:bg-gray-50 text-secondary border-2 border-secondary px-8 py-3 rounded-lg font-medium transition-colors duration-200 inline-flex items-center gap-2">
                        <i class="ri-add-line"></i>
                        Load More Items
                    </button>
                </div>
            </section>
        </div>
    </div>

    
</div>

@endsection