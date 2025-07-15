<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Default Title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body class="font-[Jost]">
    <div class="min-h-screen bg-gray-100">

        <!-- Top bar for Social and Contact Info -->
        <div class="px-2 bg-primary hidden md:block">
            <div class="xl:max-w-7xl w-full mx-auto grid grid-cols-2 h-8">
                <div>
                    <div class="flex items-center h-full justify-left text-xs">
                        <a href="#" target="_blank" class="group">
                            <div
                                class="group-hover:-translate-y-1 duration-300 transition ease-in-out delay-75 bg-tertiary h-6 w-6 rounded-full text-tertiary relative flex items-center justify-center mx-1">
                                <i class="ri-facebook-fill text-blue-800"></i>
                            </div>
                        </a>
                        <a href="#" target="_blank" class="group">
                            <div
                                class="group-hover:-translate-y-1 duration-300 transition ease-in-out delay-75 bg-tertiary h-6 w-6 rounded-full text-tertiary relative flex items-center justify-center mx-1">
                                <i class="ri-instagram-fill text-pink-600"></i>
                            </div>
                        </a>
                        <a href="#" target="_blank" class="group">
                            <div
                                class="group-hover:-translate-y-1 duration-300 transition ease-in-out delay-75 bg-tertiary h-6 w-6 rounded-full text-tertiary relative flex items-center justify-center mx-1">
                                <i class="ri-whatsapp-fill text-green-700"></i>
                            </div>
                        </a>
                    </div>
                </div>


                <div>
                    <div class="flex text-gray-50 items-center h-full text-sm font-medium justify-end">
                        <div class="pr-4">
                            <i class="ri-phone-fill"></i>
                            <span>
                                <a href="tel:+9811442231" class="hover:text-gray-100">+977-9811442231</a>
                            </span>
                        </div>
                        <div>
                            <i class="ri-mail-open-fill"></i>
                            <span> <a href="mailto:info@nepalicafe.com"
                                    class="hover:text-gray-100">info@nepalicafe.com</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Navigation Bar -->
        <div class="w-full bg-tertiary sticky top-0 z-30 shadow-lg">
            <div class="xl:max-w-7xl w-full mx-auto text-black font-bold flex justify-between px-4 items-center">
                <div class="flex items-center space-x-4">
                    <!-- Logo -->
                    <a href="/">
                        <img src="{{ asset('images/g.png') }}" alt="logo" class="max-h-32 w-auto object-contain">
                    </a>
                </div>
                <div class="hidden md:flex items-center justify-center w-full">
                    <ul class="flex items-center space-x-6 mx-auto">
    <li>
        <a href="/" 
           class="{{ request()->is('/') ? 'text-secondary font-semibold' : 'hover:text-secondary' }}">
           Home
        </a>
    </li>
    <li>
        <a href="{{ route('about') }}" 
           class="{{ request()->routeIs('about') ? 'text-secondary font-semibold' : 'hover:text-secondary' }}">
           About Us
        </a>
    </li>
    <li>
        <a href="{{ route('menu') }}" 
           class="{{ request()->routeIs('menu') ? 'text-secondary font-semibold' : 'hover:text-secondary' }}">
           Menu
        </a>
    </li>
    <li>
        <a href="{{ route('contact') }}" 
           class="{{ request()->routeIs('contact') ? 'text-secondary font-semibold' : 'hover:text-secondary' }}">
           Contact
        </a>
    </li>
</ul>

                </div>
                <div class="hidden md:flex items-center space-x-4">

                    @guest
                        <!-- Guest: Login & Register -->
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 rounded-full border border-primary text-primary hover:bg-primary hover:text-white transition-all font-medium">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="bg-primary text-white px-4 py-2 rounded-full hover:bg-secondary transition-all font-medium">
                            Register
                        </a>
                    @endguest

                    @auth
                        <!-- Authenticated: Cart, Username and Avatar -->
                        <a href="{{route('cart.index')}}" class="relative">
                            <i class="ri-shopping-cart-line text-2xl text-black hover:text-secondary"></i>
                            @php
                                $cartCount = Auth::check() ? \App\Models\Cart::where('user_id', Auth::id())->sum('quantity') : 0;
                            @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                        <div class="relative">
                            <div class="flex items-center space-x-2 cursor-pointer group" onclick="toggleDropdown()">
                                <!-- User Avatar -->
                                <img src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=6366f1&color=ffffff' }}"
                                    alt="{{ Auth::user()->name }}"
                                    class="h-8 w-8 rounded-full object-cover border border-gray-300" />
                                <!-- Username -->
                                <span class="font-medium text-primary">{{ Auth::user()->name }}</span>

                                <!-- Dropdown arrow -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary transition-transform duration-200" id="dropdown-arrow" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>

                            <!-- Dropdown menu -->
                            <div id="user-dropdown"
                                class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg opacity-0 invisible transform scale-95 transition-all duration-200 z-50">
                                <div class="py-2">
                                    <div class="px-4 py-2 border-b border-gray-100">
                                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                    </div>
                                    
                                        <a href="{{ route('user.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                            <i class="ri-dashboard-line mr-2"></i>
                                            My Dashboard
                                        </a>
                                   
{{--                                     
                                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                        <i class="ri-user-line mr-2"></i>
                                        Profile Settings
                                    </a> --}}
                                    
                                    <div class="border-t border-gray-100 mt-1">
                                        <form method="POST" action="{{ route('logout') }}" class="block">
                                            @csrf
                                            <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                                <i class="ri-logout-box-line mr-2"></i>
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endauth

                </div>

                <div class="md:hidden flex items-center space-x-4">
                    @auth
                        <a href="{{route('cart.index')}}" class="relative">
                            <i class="ri-shopping-cart-line text-2xl text-black hover:text-secondary"></i>
                            @if($cartCount > 0)
                                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    @endauth
                    
                    <button id="menu" class="text-3xl text-black">
                        <i class="ri-menu-line"></i>
                    </button>
                </div>
            </div>
        </div>


        <!-- Mobile Navigation (Hamburger Menu) -->
        <div id="mobile-menu" class="md:hidden hidden">
            <div class="bg-gray-800 text-tertiary p-4">
                <ul class="space-y-2">
                    <li><a href="/" class="block py-2 hover:text-secondary">Home</a></li>
                    <li><a href="{{ route('about') }}" class="block py-2 hover:text-secondary">About Us</a></li>
                    <li><a href="{{ route('menu') }}" class="block py-2 hover:text-secondary">Menu</a></li>
                    <li><a href="{{ route('contact') }}" class="block py-2 hover:text-secondary">Contact</a></li>
                    
                    @guest
                        <div class="border-t border-gray-600 mt-4 pt-4">
                            <li><a href="{{ route('login') }}" class="block py-2 hover:text-secondary">Login</a></li>
                            <li><a href="{{ route('register') }}" class="block py-2 hover:text-secondary">Register</a></li>
                        </div>
                    @endguest
                    
                    @auth
                        <div class="border-t border-gray-600 mt-4 pt-4">
                            <li class="text-sm text-gray-400 px-2">{{ Auth::user()->name }}</li>
                            
                            
                                <li><a href="{{ route('user.dashboard') }}" class="block py-2 hover:text-secondary">My Dashboard</a></li>
                            
                            <li><a href="{{ route('profile.edit') }}" class="block py-2 hover:text-secondary">Profile Settings</a></li>
                            
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left py-2 hover:text-secondary text-red-400">Logout</button>
                                </form>
                            </li>
                        </div>
                    @endauth
                </ul>
            </div>
        </div>



        <!-- Main Content Area -->
        <main>
            @yield('content')
        </main>

        <footer class="bg-primary text-tertiary py-10 px-5 md:px-20">
            <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between flex-wrap gap-8 md:gap-24">
                <!-- Left Section (Logo and Text) -->
                <div class="mb-6 md:mb-0 w-full md:w-auto">
                    <a href="/" class="inline-block px-4 bg-white rounded-lg">
                        <!-- Logo Image -->
                        <img src="{{ asset('images/g.png') }}" alt="Logo" class="w-48">
                    </a>
                    <p class="text-sm text-tertiary mt-2 max-w-xs md:max-w-sm text-justify">
                        Nepali Cafe offers a cozy environment to enjoy delicious meals, premium coffee, and excellent
                        service. Visit us today and experience the best cafe vibes!
                    </p>
                    <div class="flex space-x-3 mt-4">
                        <a href="#"
                            class="bg-blue-500 shadow-md rounded-full w-8 h-8 flex items-center justify-center p-2">
                            <i class="ri-facebook-fill text-xl text-tertiary"></i>
                        </a>
                        <a href="#"
                            class="bg-pink-600 shadow-md rounded-full w-8 h-8 flex items-center justify-center p-2">
                            <i class="ri-instagram-fill text-xl text-tertiary"></i>
                        </a>
                        <a href="#"
                            class="bg-blue-400 shadow-md rounded-full w-8 h-8 flex items-center justify-center p-2">
                            <i class="ri-twitter-fill text-xl text-tertiary"></i>
                        </a>
                    </div>
                </div>

                <!-- Right Section (Quick Links, Policy, and Contact Info) -->
                <div
                    class="mt-8 md:mt-0 w-full md:w-auto space-y-6 md:space-y-0 flex flex-col md:flex-row justify-end md:space-x-20 flex-grow">
                    <div class="w-full">
                        <h3 class="text-md font-bold relative">Quick Links</h3>
                        <ul class="text-sm font-semibold text-tertiary mt-2 space-y-2">
                            <li><a href="/">Home</a></li>
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{route('menu')}}">Menu</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                        </ul>
                    </div>
                    <div class="w-full">
                        <h3 class="text-md font-bold relative">Policy</h3>
                        <ul class="text-sm font-semibold text-tertiary mt-2 space-y-2">
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Privacy</a></li>
                            <li><a href="#">Shipping</a></li>
                        </ul>
                    </div>
                    <div class="w-full space-y-2">
                        <h3 class="text-md font-bold">Get In Touch</h3>
                        <div class="flex items-center space-x-2">
                            <i class="ri-phone-line text-tertiary"></i>
                            <p class="text-sm text-tertiary font-semibold">+977-9811442231</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="ri-mail-line text-tertiary"></i>
                            <p class="text-sm text-tertiary font-semibold">info@nepalicafe.com</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="ri-map-pin-line text-tertiary"></i>
                            <p class="text-sm text-tertiary font-semibold">Chitwan, Nepal</p>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-t border-gray-300 my-6">

            <div class="text-center text-xs text-tertiary">
                &copy; {{ date('Y') }} Nepali Cafe. All rights reserved.
            </div>
        </footer>



    </div>

    <!-- Scripts for the Mobile Menu Toggle -->
    <script>
        const menuButton = document.getElementById('menu');
        const mobileMenu = document.getElementById('mobile-menu');

        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // User dropdown functionality
        function toggleDropdown() {
            const dropdown = document.getElementById('user-dropdown');
            const arrow = document.getElementById('dropdown-arrow');
            
            if (dropdown.classList.contains('opacity-0')) {
                // Show dropdown
                dropdown.classList.remove('opacity-0', 'invisible', 'scale-95');
                dropdown.classList.add('opacity-100', 'visible', 'scale-100');
                arrow.classList.add('rotate-180');
            } else {
                // Hide dropdown
                dropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                dropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                arrow.classList.remove('rotate-180');
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('user-dropdown');
            const userMenuButton = event.target.closest('[onclick="toggleDropdown()"]');
            
            if (!userMenuButton && dropdown && !dropdown.contains(event.target)) {
                dropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                dropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                const arrow = document.getElementById('dropdown-arrow');
                if (arrow) arrow.classList.remove('rotate-180');
            }
        });
    </script>

    <!-- Swiper Script -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>


    <script>
        // Initialize Swiper after DOM is fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            var swiperMenus = new Swiper('.swiper-container', {
                loop: true,
                slidesPerView: 3, // Default for larger screens
                spaceBetween: 20, // Space between slides
                autoplay: {
                    delay: 3000, // 3 seconds
                    disableOnInteraction: false, // Keep autoplay after user interaction
                },
                // pagination: {
                //     el: '.swiper-pagination', // The container for the dots
                //     clickable: true,          // Make the dots clickable
                // },
                breakpoints: {
                    320: { // For very small screens (mobile)
                        slidesPerView: 1, // Show 1 slide on very small screens
                        spaceBetween: 10, // Smaller space between slides
                    },
                    480: { // For small screens (larger mobile, tablet portrait)
                        slidesPerView: 1, // Show 1 slide
                        spaceBetween: 15,
                    },
                    640: {
                        slidesPerView: 2, // Show 2 slides for small tablets
                        spaceBetween: 15,
                    },
                    768: {
                        slidesPerView: 2, // Show 2 slides for larger mobile/tablets
                        spaceBetween: 20,
                    },
                    1024: {
                        slidesPerView: 3, // Show 3 slides for laptops and larger devices
                        spaceBetween: 20,
                    },
                }
            });

            // Testimonials Swiper Initialization
            var swiperTestimonials = new Swiper('.swiper-testimonials', {
                loop: true,
                slidesPerView: 3,
                spaceBetween: 30,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    320: { // For very small screens (mobile)
                        slidesPerView: 1, // Show 1 slide on very small screens
                        spaceBetween: 10, // Smaller space between slides
                    },
                    480: { // For small screens (larger mobile, tablet portrait)
                        slidesPerView: 1, // Show 1 slide
                        spaceBetween: 15,
                    },
                    640: {
                        slidesPerView: 2, // Show 2 slides for small tablets
                        spaceBetween: 15,
                    },
                    768: {
                        slidesPerView: 2, // Show 2 slides for larger mobile/tablets
                        spaceBetween: 20,
                    },
                    1024: {
                        slidesPerView: 3, // Show 3 slides for laptops and larger devices
                        spaceBetween: 20,
                    },
                }
            });
        });
    </script>

    <!-- Include Flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Flatpickr for the Date input
            flatpickr("input[type='date']", {
                dateFormat: "Y-m-d", // Set the date format
                minDate: "today", // Optional: prevent selecting past dates
            });

            // Initialize Flatpickr for the Time input
            flatpickr("input[type='time']", {
                enableTime: true, // Enable time input
                noCalendar: true, // Disable calendar (we only need time)
                dateFormat: "H:i", // Set the time format (24-hour clock)
            });
        });
    </script>
</body>

</html>
