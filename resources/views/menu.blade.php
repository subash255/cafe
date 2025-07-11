@extends('layouts.master')
@section('content')

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
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                                <input type="number" placeholder="Min" class="w-full pl-8 pr-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">
                            </div>
                            <span class="text-gray-400">to</span>
                            <div class="relative flex-1">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
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
                            <span class="text-secondary font-medium">$4.50</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">Chocolate Cake</span>
                            <span class="text-secondary font-medium">$5.50</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">Green Tea</span>
                            <span class="text-secondary font-medium">$3.00</span>
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
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="relative overflow-hidden">
                            <img src="https://source.unsplash.com/400x300/?coffee" alt="Cappuccino" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute top-4 left-4">
                                <span class="bg-secondary text-white px-3 py-1 rounded-full text-xs font-medium">Popular</span>
                            </div>
                            <div class="absolute top-4 right-4">
                                <button class="bg-white/90 backdrop-blur-sm text-gray-600 hover:text-red-500 w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                                    <i class="ri-heart-line"></i>
                                </button>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-bold text-xl text-gray-800 group-hover:text-secondary transition-colors">Cappuccino</h3>
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
                            <p class="text-gray-600 mb-4 leading-relaxed">Freshly brewed with steamed milk and a perfect foam art. Made with premium arabica beans.</p>
                            <div class="flex items-center justify-between">
                                <span class="text-2xl font-bold text-secondary">$4.50</span>
                                <button class="bg-secondary hover:bg-secondary/90 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
                                    <i class="ri-shopping-cart-line"></i>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Item Card 2 -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="relative overflow-hidden">
                            <img src="https://source.unsplash.com/400x300/?tea" alt="Green Tea" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute top-4 left-4">
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-medium">Organic</span>
                            </div>
                            <div class="absolute top-4 right-4">
                                <button class="bg-white/90 backdrop-blur-sm text-gray-600 hover:text-red-500 w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                                    <i class="ri-heart-line"></i>
                                </button>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-bold text-xl text-gray-800 group-hover:text-secondary transition-colors">Green Tea</h3>
                                <div class="flex items-center">
                                    <div class="flex text-yellow-400 text-sm">
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                    </div>
                                    <span class="text-gray-500 text-xs ml-1">(4.8)</span>
                                </div>
                            </div>
                            <p class="text-gray-600 mb-4 leading-relaxed">Organic and refreshing green tea with antioxidant properties. Perfect for a healthy lifestyle.</p>
                            <div class="flex items-center justify-between">
                                <span class="text-2xl font-bold text-secondary">$3.00</span>
                                <button class="bg-secondary hover:bg-secondary/90 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
                                    <i class="ri-shopping-cart-line"></i>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Item Card 3 -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="relative overflow-hidden">
                            <img src="https://source.unsplash.com/400x300/?cake" alt="Chocolate Cake" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute top-4 left-4">
                                <span class="bg-pink-500 text-white px-3 py-1 rounded-full text-xs font-medium">Chef's Special</span>
                            </div>
                            <div class="absolute top-4 right-4">
                                <button class="bg-white/90 backdrop-blur-sm text-gray-600 hover:text-red-500 w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                                    <i class="ri-heart-line"></i>
                                </button>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-bold text-xl text-gray-800 group-hover:text-secondary transition-colors">Chocolate Cake</h3>
                                <div class="flex items-center">
                                    <div class="flex text-yellow-400 text-sm">
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-line"></i>
                                    </div>
                                    <span class="text-gray-500 text-xs ml-1">(4.5)</span>
                                </div>
                            </div>
                            <p class="text-gray-600 mb-4 leading-relaxed">Rich and moist chocolate cake made with premium Belgian chocolate. A true indulgence for chocolate lovers.</p>
                            <div class="flex items-center justify-between">
                                <span class="text-2xl font-bold text-secondary">$5.50</span>
                                <button class="bg-secondary hover:bg-secondary/90 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
                                    <i class="ri-shopping-cart-line"></i>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Item Card 4 -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="relative overflow-hidden">
                            <img src="https://source.unsplash.com/400x300/?croissant" alt="Butter Croissant" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute top-4 left-4">
                                <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-medium">Fresh Baked</span>
                            </div>
                            <div class="absolute top-4 right-4">
                                <button class="bg-white/90 backdrop-blur-sm text-gray-600 hover:text-red-500 w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                                    <i class="ri-heart-line"></i>
                                </button>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-bold text-xl text-gray-800 group-hover:text-secondary transition-colors">Butter Croissant</h3>
                                <div class="flex items-center">
                                    <div class="flex text-yellow-400 text-sm">
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-half-line"></i>
                                    </div>
                                    <span class="text-gray-500 text-xs ml-1">(4.6)</span>
                                </div>
                            </div>
                            <p class="text-gray-600 mb-4 leading-relaxed">Flaky, buttery croissant baked fresh daily. Perfect with your morning coffee or afternoon tea.</p>
                            <div class="flex items-center justify-between">
                                <span class="text-2xl font-bold text-secondary">$3.75</span>
                                <button class="bg-secondary hover:bg-secondary/90 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
                                    <i class="ri-shopping-cart-line"></i>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Item Card 5 -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="relative overflow-hidden">
                            <img src="https://source.unsplash.com/400x300/?smoothie" alt="Berry Smoothie" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute top-4 left-4">
                                <span class="bg-purple-500 text-white px-3 py-1 rounded-full text-xs font-medium">Healthy</span>
                            </div>
                            <div class="absolute top-4 right-4">
                                <button class="bg-white/90 backdrop-blur-sm text-gray-600 hover:text-red-500 w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                                    <i class="ri-heart-line"></i>
                                </button>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-bold text-xl text-gray-800 group-hover:text-secondary transition-colors">Berry Smoothie</h3>
                                <div class="flex items-center">
                                    <div class="flex text-yellow-400 text-sm">
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-line"></i>
                                    </div>
                                    <span class="text-gray-500 text-xs ml-1">(4.3)</span>
                                </div>
                            </div>
                            <p class="text-gray-600 mb-4 leading-relaxed">Fresh blend of mixed berries, yogurt, and honey. Packed with vitamins and natural goodness.</p>
                            <div class="flex items-center justify-between">
                                <span class="text-2xl font-bold text-secondary">$4.25</span>
                                <button class="bg-secondary hover:bg-secondary/90 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
                                    <i class="ri-shopping-cart-line"></i>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Item Card 6 -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="relative overflow-hidden">
                            <img src="https://source.unsplash.com/400x300/?sandwich" alt="Club Sandwich" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute top-4 left-4">
                                <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-medium">Bestseller</span>
                            </div>
                            <div class="absolute top-4 right-4">
                                <button class="bg-white/90 backdrop-blur-sm text-gray-600 hover:text-red-500 w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                                    <i class="ri-heart-line"></i>
                                </button>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-bold text-xl text-gray-800 group-hover:text-secondary transition-colors">Club Sandwich</h3>
                                <div class="flex items-center">
                                    <div class="flex text-yellow-400 text-sm">
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                    </div>
                                    <span class="text-gray-500 text-xs ml-1">(4.9)</span>
                                </div>
                            </div>
                            <p class="text-gray-600 mb-4 leading-relaxed">Triple-layered sandwich with turkey, bacon, lettuce, tomato, and our special sauce. Served with fries.</p>
                            <div class="flex items-center justify-between">
                                <span class="text-2xl font-bold text-secondary">$8.75</span>
                                <button class="bg-secondary hover:bg-secondary/90 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
                                    <i class="ri-shopping-cart-line"></i>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
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