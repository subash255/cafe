@extends('layouts.master')
@section('title', 'Welcome | Nepali Cafe')
@section('content')
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
                <div class="mt-8 flex flex-wrap items-center justify-center sm:justify-start gap-3">
                    <a href="#">
                        <button class="rounded-md overflow-hidden">
                            <div class="bg-secondary hover:bg-primary py-2 px-8 relative">
                                <div class="flex items-center gap-x-3 relative z-20">
                                    <i class="text-xl"></i>
                                    <span class="text-lg font-bold">Order Now!</span>
                                </div>
                            </div>
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

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
    


    <!-- Menu Preview Section -->
    <section class="bg-gray-50 py-10 xl:px-12 lg:px-8 sm:px-5 px-3">
        <div class="xl:max-w-7xl w-full mx-auto">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-secondary">Our Popular Menu</h2>
                <p class="text-xl mt-4 text-quaternary">Discover a variety of delicious meals and drinks, carefully crafted
                    to
                    satisfy your cravings.</p>
            </div>
            <div class="swiper swiper-container mt-12">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="bg-tertiary border border-gray-200 rounded-lg overflow-hidden">
                            <img src="images/coffee.png" alt="Menu Item 1" class="w-full h-64 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-800">Coffee & Pastry Combo</h3>
                                <p class="mt-2 text-quaternary">A perfect combination of freshly brewed coffee and a
                                    delicious
                                    pastry.</p>
                                <p class="mt-4 text-lg text-gray-800 font-semibold">$7.99</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="bg-tertiary shadow-lg rounded-lg overflow-hidden">
                            <img src="images/salaad.jpg" alt="Menu Item 2" class="w-full h-64 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-800">Salad Bowl</h3>
                                <p class="mt-2 text-quaternary">Fresh greens topped with your choice of protein, dressed to
                                    perfection.</p>
                                <p class="mt-4 text-lg text-gray-800 font-semibold">$9.99</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="bg-tertiary shadow-lg rounded-lg overflow-hidden">
                            <img src="images/vegansm.jpg" alt="Menu Item 3" class="w-full h-64 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-800">Vegan Smoothie</h3>
                                <p class="mt-2 text-quaternary">A refreshing blend of fruits, perfect for a healthy snack.
                                </p>
                                <p class="mt-4 text-lg text-gray-800 font-semibold">$5.99</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="bg-tertiary shadow-lg rounded-lg overflow-hidden">
                            <img src="images/vegan.jpg" alt="Menu Item 3" class="w-full h-64 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-800">Vegan</h3>
                                <p class="mt-2 text-quaternary">A refreshing blend of fruits, perfect for a healthy snack.
                                </p>
                                <p class="mt-4 text-lg text-gray-800 font-semibold">$5.99</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="bg-tertiary shadow-lg rounded-lg overflow-hidden">
                            <img src="images/smoothie.jpg" alt="Menu Item 3" class="w-full h-64 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-800">Smoothie</h3>
                                <p class="mt-2 text-quaternary">A refreshing blend of fruits, perfect for a healthy snack.
                                </p>
                                <p class="mt-4 text-lg text-gray-800 font-semibold">$5.99</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="bg-tertiary shadow-lg rounded-lg overflow-hidden">
                            <img src="images/fruits.jpg" alt="Menu Item 3" class="w-full h-64 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-800">Fruits</h3>
                                <p class="mt-2 text-quaternary">A refreshing blend of fruits, perfect for a healthy snack.
                                </p>
                                <p class="mt-4 text-lg text-gray-800 font-semibold">$5.99</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5 flex justify-center items-center">
                <button class="bg-secondary hover:bg-primary rounded-full p-2 text-tertiary font-bold">
                    More Menus
                </button>
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
                <div class="mt-10">
                    <form action="#" autocomplete="off" method="POST">

                        <div class="grid sm:grid-cols-2 gap-x-6 gap-y-12">
                            <div>
                                <label for="name" class="relative">
                                    <input type="text" placeholder="Name"
                                        class="w-full py-3 rounded-full bg-tertiary  border border-blue-600 focus:border-blue-600 focus:ring-0 pl-6 text-black placeholder:text-black">
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-6">
                                        <i class="ri-user-3-line"></i>
                                    </span>
                                </label>
                            </div>

                            <div>
                                <label for="phone" class="relative">
                                    <input type="text" placeholder="Phone"
                                        class="w-full py-3 rounded-full bg-tertiary  border border-blue-600 focus:border-blue-600 focus:ring-0 pl-6 text-black placeholder:text-black">
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-6">
                                        <i class="ri-phone-line"></i>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-x-6 gap-y-12 mt-12">
                            <div>
                                <label for="people" class="relative">
                                    <input type="text" placeholder="No. of People"
                                        class="w-full py-3 rounded-full bg-tertiary  border border-blue-600 focus:border-blue-600 focus:ring-0 pl-6 text-black placeholder:text-black">
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-6">
                                        <i class="ri-group-line"></i>
                                    </span>
                                </label>
                            </div>

                            <div>
                                <label for="date" class="relative">
                                    <input type="date" placeholder="yyyy/mm/dd"
                                        class="w-full py-3 rounded-full bg-tertiary  border border-blue-600 focus:border-blue-600 focus:ring-0 pl-6 text-black placeholder:text-black">
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-6">
                                        <i class="ri-calendar-line"></i>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-x-6 gap-y-12 mt-12">
                            <div>
                                <label for="time" class="relative">
                                    <input type="time" placeholder="Enter Time"
                                        class="w-full py-3 rounded-full bg-tertiary  border border-blue-600 focus:border-blue-600 focus:ring-0 pl-6 text-black placeholder:text-black">
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-6">
                                        <i class="ri-time-line"></i>
                                    </span>
                                </label>
                            </div>


                            <div>
                                <label for="email" class="relative">
                                    <input type="email" placeholder="Enter email"
                                        class="w-full py-3 rounded-full bg-tertiary  border border-blue-600 focus:border-blue-600 focus:ring-0 pl-6 text-black placeholder:text-black">
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-6">
                                        <i class="ri-mail-line"></i>
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
                            <span class="text-secondary text-xl">“</span>I love the variety of smoothies and fresh salads.
                            Always a healthy and tasty option!<span class="text-secondary text-xl">”</span>
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
                            <span class="text-secondary text-xl">“</span>Such a cozy place with great vibes. The vegan
                            smoothie is a game-changer!<span class="text-secondary text-xl">”</span>
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
                            <span class="text-secondary text-xl">“</span>The staff is friendly, and the food is always fresh.
                            I’m definitely coming back for more!<span class="text-secondary text-xl">”</span>
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
                            <span class="text-secondary text-xl">“</span>Absolutely love this place. The fruit bowls are
                            always so fresh and refreshing!<span class="text-secondary text-xl">”</span>
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
                            <span class="text-secondary text-xl">“</span>The food here is amazing! The coffee and pastries
                            are the perfect combination. <span class="text-secondary text-xl">”</span>
                        </p>
                        <h4 class="mt-4 text-primary font-bold">Aakash Kandel</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
