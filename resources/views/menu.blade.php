@extends('layouts.master')
@section('title', 'Menu | Nepali Cafe')
@section('content')

    {{-- Enhanced Flash Message --}}
    @if (session('success'))
        <div id="flash-message"
            class="fixed top-6 right-6 bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-4 rounded-xl shadow-lg z-50 flex items-center">
            <i class="ri-check-line text-xl mr-2"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div id="flash-message"
            class="fixed top-6 right-6 bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-4 rounded-xl shadow-lg z-50 flex items-center">
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
        <div
            class="bg-gradient-to-r from-black/80 via-black/60 to-black/40 absolute inset-0 flex items-center justify-center">
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
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">From expertly brewed coffees to delectable pastries,
                    every item is made with passion and the finest ingredients</p>
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
                            @foreach($categories as $category)
                            <li class="flex items-center group">
                                <input type="checkbox" class="category-filter mr-3 w-4 h-4 text-secondary border-gray-300 rounded focus:ring-secondary focus:ring-2" 
                                       value="{{ $category->id }}" data-category="{{ strtolower($category->name) }}">
                                <label class="text-gray-700 group-hover:text-secondary transition-colors cursor-pointer flex items-center">
                                    {{ $category->name }}
                                </label>
                            </li>
                            @endforeach
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
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rs.
                                    </span>
                                    <input type="number" id="min-price" placeholder="Min"
                                        class="w-full pl-8 pr-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">
                                </div>
                                <span class="text-gray-400">to</span>
                                <div class="relative flex-1">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rs.
                                    </span>
                                    <input type="number" id="max-price" placeholder="Max"
                                        class="w-full pl-8 pr-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">
                                </div>
                            </div>
                            <button id="apply-price-filter"
                                class="w-full bg-secondary text-white py-2 rounded-lg hover:bg-secondary/90 transition-colors duration-200 font-medium">
                                Apply Filter
                            </button>
                        </div>
                    </div>

                    <!-- Popular Items -->
                    <div
                        class="bg-gradient-to-br from-secondary/10 to-tertiary/10 rounded-xl p-6 border border-secondary/20">
                        <div class="flex items-center mb-4">
                            <i class="ri-fire-line text-secondary text-xl mr-2"></i>
                            <h2 class="text-lg font-semibold text-gray-800">Popular Today</h2>
                        </div>
                        <div class="space-y-3 text-sm">
                            @forelse ($popularItems->take(3) as $item)
                                <div class="flex items-center justify-between cursor-pointer hover:bg-white/50 p-2 rounded transition-colors"
                                     onclick="filterByItem('{{ strtolower($item->name) }}')">
                                    <span class="text-gray-700">{{ $item->name }}</span>
                                    <span class="text-secondary font-medium">Rs. {{ number_format($item->price, 2) }}</span>
                                </div>
                            @empty
                                <div class="text-gray-500 text-center py-2">
                                    No popular items available
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Clear Filters Button -->
                    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                        <button id="clear-filters" 
                                class="w-full bg-gray-500 hover:bg-gray-600 text-white py-3 rounded-lg transition-colors duration-200 font-medium flex items-center justify-center gap-2">
                            <i class="ri-refresh-line"></i>
                            Clear All Filters
                        </button>
                    </div>

                </aside>

                <!-- Enhanced Menu Items Grid -->
                <section class="w-full lg:w-3/4">
                    <!-- Sort and View Options -->
                    <div class="bg-white rounded-xl shadow-md p-4 mb-8 border border-gray-100">
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                            <div class="flex items-center gap-2">
                                <span class="text-gray-700 font-medium">Sort by:</span>
                                <select id="sort-select"
                                    class="px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">
                                    <option value="default">Most Popular</option>
                                    <option value="price-low">Price: Low to High</option>
                                    <option value="price-high">Price: High to Low</option>
                                    <option value="name">Name: A to Z</option>
                                </select>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-gray-700 font-medium">View:</span>
                                <div class="flex rounded-lg border border-gray-200 overflow-hidden">
                                    <button id="grid-view" class="px-3 py-2 bg-secondary text-white">
                                        <i class="ri-grid-line"></i>
                                    </button>
                                    <button id="list-view" class="px-3 py-2 bg-gray-100 text-gray-600 hover:bg-gray-200">
                                        <i class="ri-list-check"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Menu Items Grid -->
                    <div id="menu-grid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                        <!-- Enhanced Item Card 1 -->
                        @foreach ($menus as $menu)
                            <div class="menu-item bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                                 data-name="{{ strtolower($menu->name) }}" 
                                 data-description="{{ strtolower($menu->description) }}" 
                                 data-price="{{ $menu->price }}" 
                                 data-category="{{ $menu->category_id }}"
                                 data-category-name="{{ strtolower($menu->category->name ?? '') }}">
                                <div class="relative overflow-hidden">
                                    <img src="{{ asset('fooditem/' . $menu->image) }}" alt="{{ $menu->name }}"
                                        class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                    @if ($menu->status == 1)
                                        <div class="absolute top-4 left-4">
                                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-medium">
                                                <i class="ri-fire-line mr-1"></i>Popular
                                            </span>
                                        </div>
                                    @endif
                                    <div class="absolute top-4 right-4">
                                        <button
                                            class="bg-white/90 backdrop-blur-sm text-gray-600 hover:text-red-500 w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                                            <i class="ri-heart-line"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <div class="flex items-start justify-between mb-2">
                                        <h3
                                            class="font-bold text-xl text-gray-800 group-hover:text-secondary transition-colors">
                                            {{ $menu->name }}</h3>
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
                                    <p class="text-gray-600 mb-4 leading-relaxed">{{ $menu->description }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-secondary">Rs. {{ $menu->price }}</span>
                                        @auth
                                        <form action="{{ route('cart.store', $menu->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="price" value="{{ $menu->price }}">
                                            <button type="submit"
                                                class="bg-secondary hover:bg-secondary/90 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
                                                <i class="ri-shopping-cart-line"></i>
                                                Add to Cart
                                            </button>
                                        </form>
                                        @else
                                        <a href="{{ route('login') }}" class="bg-secondary hover:bg-secondary/90 text-white px-4 py-2 rounded-lg transition-colors duration-200 text-sm font-semibold flex items-center gap-2">
                                            <i class="ri-shopping-cart-line"></i>Add to Cart
                                        </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- No Results Message -->
                    <div id="no-results" class="hidden text-center py-12">
                        <i class="ri-search-line text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">No items found</h3>
                        <p class="text-gray-500">Try adjusting your search or filter criteria</p>
                    </div>

                    <!-- Load More Button -->
                    <div class="text-center mt-12">
                        <button
                            class="bg-white hover:bg-gray-50 text-secondary border-2 border-secondary px-8 py-3 rounded-lg font-medium transition-colors duration-200 inline-flex items-center gap-2">
                            <i class="ri-add-line"></i>
                            Load More Items
                        </button>
                    </div>
                </section>
            </div>
        </div>


    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const categoryFilters = document.querySelectorAll('.category-filter');
    const minPriceInput = document.getElementById('min-price');
    const maxPriceInput = document.getElementById('max-price');
    const applyPriceFilter = document.getElementById('apply-price-filter');
    const sortSelect = document.getElementById('sort-select');
    const menuItems = document.querySelectorAll('.menu-item');
    const menuGrid = document.getElementById('menu-grid');
    const noResults = document.getElementById('no-results');
    const gridView = document.getElementById('grid-view');
    const listView = document.getElementById('list-view');
    const clearFiltersBtn = document.getElementById('clear-filters');

    let currentFilters = {
        search: '',
        categories: [],
        minPrice: null,
        maxPrice: null,
        sort: 'default'
    };

    // Search functionality
    searchInput.addEventListener('input', function() {
        currentFilters.search = this.value.toLowerCase();
        filterAndSortItems();
    });

    // Category filter functionality
    categoryFilters.forEach(filter => {
        filter.addEventListener('change', function() {
            if (this.checked) {
                currentFilters.categories.push(this.value);
            } else {
                currentFilters.categories = currentFilters.categories.filter(cat => cat !== this.value);
            }
            filterAndSortItems();
        });
    });

    // Price filter functionality
    applyPriceFilter.addEventListener('click', function() {
        currentFilters.minPrice = minPriceInput.value ? parseFloat(minPriceInput.value) : null;
        currentFilters.maxPrice = maxPriceInput.value ? parseFloat(maxPriceInput.value) : null;
        filterAndSortItems();
        
        // Show feedback
        this.innerHTML = '<i class="ri-check-line mr-2"></i>Applied!';
        this.classList.add('bg-green-500');
        setTimeout(() => {
            this.innerHTML = 'Apply Filter';
            this.classList.remove('bg-green-500');
        }, 1500);
    });

    // Enter key support for price inputs
    [minPriceInput, maxPriceInput].forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                applyPriceFilter.click();
            }
        });
    });

    // Sort functionality
    sortSelect.addEventListener('change', function() {
        currentFilters.sort = this.value;
        filterAndSortItems();
    });

    // View toggle functionality
    gridView.addEventListener('click', function() {
        // Reset to original grid layout
        menuGrid.className = 'grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8';
        this.className = 'px-3 py-2 bg-secondary text-white';
        listView.className = 'px-3 py-2 bg-gray-100 text-gray-600 hover:bg-gray-200';
        
        // Reset all items to original card layout
        menuItems.forEach(item => {
            item.classList.remove('flex', 'flex-row');
            const imgContainer = item.querySelector('.relative.overflow-hidden');
            if (imgContainer) {
                imgContainer.classList.remove('w-1/3');
            }
            const content = item.querySelector('.p-6');
            if (content) {
                content.classList.remove('w-2/3');
            }
        });
    });

    listView.addEventListener('click', function() {
        menuGrid.className = 'grid grid-cols-1 gap-4';
        this.className = 'px-3 py-2 bg-secondary text-white';
        gridView.className = 'px-3 py-2 bg-gray-100 text-gray-600 hover:bg-gray-200';
        
        // Adjust card layout for list view
        menuItems.forEach(item => {
            if (item.style.display !== 'none') {
                item.classList.add('flex', 'flex-row');
                const imgContainer = item.querySelector('.relative.overflow-hidden');
                if (imgContainer) {
                    imgContainer.classList.add('w-1/3');
                }
                const content = item.querySelector('.p-6');
                if (content) {
                    content.classList.add('w-2/3');
                }
            }
        });
    });

    // Clear all filters
    clearFiltersBtn.addEventListener('click', function() {
        clearAllFilters();
        
        // Show feedback
        this.innerHTML = '<i class="ri-check-line mr-2"></i>Filters Cleared!';
        this.classList.remove('bg-gray-500', 'hover:bg-gray-600');
        this.classList.add('bg-green-500');
        setTimeout(() => {
            this.innerHTML = '<i class="ri-refresh-line mr-2"></i>Clear All Filters';
            this.classList.remove('bg-green-500');
            this.classList.add('bg-gray-500', 'hover:bg-gray-600');
        }, 1500);
    });

    function filterAndSortItems() {
        let visibleItems = [];

        menuItems.forEach(item => {
            let isVisible = true;

            // Search filter
            if (currentFilters.search) {
                const name = item.dataset.name;
                const description = item.dataset.description;
                const categoryName = item.dataset.categoryName;
                if (!name.includes(currentFilters.search) && 
                    !description.includes(currentFilters.search) && 
                    !categoryName.includes(currentFilters.search)) {
                    isVisible = false;
                }
            }

            // Category filter
            if (currentFilters.categories.length > 0) {
                if (!currentFilters.categories.includes(item.dataset.category)) {
                    isVisible = false;
                }
            }

            // Price filter
            const price = parseFloat(item.dataset.price);
            if (currentFilters.minPrice !== null && price < currentFilters.minPrice) {
                isVisible = false;
            }
            if (currentFilters.maxPrice !== null && price > currentFilters.maxPrice) {
                isVisible = false;
            }

            if (isVisible) {
                visibleItems.push(item);
                item.style.display = 'block';
                item.classList.remove('opacity-50');
            } else {
                item.style.display = 'none';
                item.classList.add('opacity-50');
            }
        });

        // Sort visible items
        sortItems(visibleItems);

        // Show/hide no results message
        if (visibleItems.length === 0) {
            noResults.classList.remove('hidden');
        } else {
            noResults.classList.add('hidden');
        }

        // Update result count
        updateResultCount(visibleItems.length);
    }

    function sortItems(items) {
        const parent = menuGrid;
        
        switch (currentFilters.sort) {
            case 'price-low':
                items.sort((a, b) => parseFloat(a.dataset.price) - parseFloat(b.dataset.price));
                break;
            case 'price-high':
                items.sort((a, b) => parseFloat(b.dataset.price) - parseFloat(a.dataset.price));
                break;
            case 'name':
                items.sort((a, b) => a.dataset.name.localeCompare(b.dataset.name));
                break;
            case 'default':
            default:
                // Keep original order (popular items first)
                break;
        }

        // Reorder DOM elements
        items.forEach(item => {
            parent.appendChild(item);
        });
    }

    function clearAllFilters() {
        searchInput.value = '';
        categoryFilters.forEach(filter => filter.checked = false);
        minPriceInput.value = '';
        maxPriceInput.value = '';
        sortSelect.value = 'default';
        
        currentFilters = {
            search: '',
            categories: [],
            minPrice: null,
            maxPrice: null,
            sort: 'default'
        };
        
        filterAndSortItems();
    }

    function updateResultCount(count) {
        const totalItems = menuItems.length;
        let resultText = `Showing ${count} of ${totalItems} items`;
        
        // Add or update result count display
        let resultCount = document.getElementById('result-count');
        if (!resultCount) {
            resultCount = document.createElement('div');
            resultCount.id = 'result-count';
            resultCount.className = 'text-sm text-gray-600 mb-4';
            const sortSection = document.querySelector('.bg-white.rounded-xl.shadow-md.p-4.mb-8');
            sortSection.parentNode.insertBefore(resultCount, sortSection.nextSibling);
        }
        resultCount.textContent = resultText;
    }

    // Global function for popular item quick filter
    window.filterByItem = function(itemName) {
        searchInput.value = itemName;
        currentFilters.search = itemName;
        filterAndSortItems();
        
        // Scroll to menu section
        document.getElementById('menu-grid').scrollIntoView({ 
            behavior: 'smooth', 
            block: 'start' 
        });
    };

    // Initialize result count
    updateResultCount(menuItems.length);
});
</script>

@endsection
