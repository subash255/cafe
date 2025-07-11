@extends('layouts.master')
@section('title', 'About Us | Nepali Cafe')
@section('content')

<div style="background-image: url('images/cup.jpeg');" class="bg-cover h-36 md:h-40 relative">
    <div class="bg-black bg-opacity-75 absolute inset-0 h-36 md:h-40 flex items-center justify-center">
        <div class="xl:px-12 lg:px-8 sm:px-5 px-3">
            <div class="2xl:max-w-[1600px] xl:max-w-[1280px] w-full mx-auto">
                <h1 class="md:text-3xl sm:text-2xl text-xl font-semibold uppercase text-tertiary">
                    About Us
                </h1>
            </div>
        </div>
    </div>
</div>


<!-- About Us Section -->
<section class="py-16 px-4 md:px-16">
    <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 gap-16 items-center">
        <!-- Left: Text content -->
        <div>
            <h2 class="text-3xl md:text-4xl font-bold text-secondary mb-6 border-l-4 border-primary pl-4">Introduction</h2>
            <p class="text-lg md:text-xl text-quaternary leading-relaxed mb-6 text-justify">
                We are more than just a cafe; we are a cozy corner where you can relax, enjoy a freshly brewed cup of coffee,
                and savor homemade pastries, all while enjoying a warm atmosphere. Located in the heart of Chitwan, Nepali Cafe
                is a place where community, great food, and great conversation come together.
            </p>
            <p class="mt-3 text-lg md:text-xl text-quaternary leading-relaxed mb-6 text-justify">
                At our Cafe, we pride ourselves on providing a welcoming space for everyone—whether you're stopping by for a quick coffee or spending a few hours working or socializing. Our team is passionate about making every visit a special experience for you.
            </p>
        </div>
        

        <!-- Right: Image content -->
        <div class="w-full">
            <img src="images/cafee.jpg" alt="Cafe Image" class="w-full h-auto rounded-lg shadow-lg">
        </div>
    </div>
</section>

<!-- Our Mission Section -->
<section class="py-16 px-4 md:px-16 bg-gray-100">
    <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 gap-16 items-center">
        <!-- Left: Image content -->
        <div class="w-full">
            <img src="images/people.jpg" alt="Mission Image" class="w-full h-auto rounded-lg shadow-lg">
        </div>

        <div>
            <h3 class="text-2xl md:text-3xl font-semibold text-secondary mb-6 border-l-4 border-primary pl-4">Our Mission</h3>
            <p class="text-lg md:text-xl text-quaternary leading-relaxed text-justify">
                Our mission is simple: To bring people together over delicious coffee and food, create a space where creativity
                flows, and make every visit feel like a personal experience. We are committed to supporting local businesses,
                offering high-quality products, and creating a welcoming environment for everyone.
            </p>
        
            <p class="mt-3 text-lg md:text-xl text-quaternary leading-relaxed text-justify">
                At Nepali Cafe, we believe in fostering a sense of community. Every cup of coffee we serve is brewed with care, and every dish is made with the freshest ingredients. We aim to inspire creativity, conversation, and connection in every corner of our cafe.
            </p>
        </div>
        
    </div>
</section>

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
                        class="w-20 h-20 rounded-full mx-auto border-2 border-primary shadow-md bg-tertiary flex items-center justify-center -mt-16">
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
                        class="w-20 h-20 rounded-full mx-auto border-2 border-primary shadow-md bg-tertiary flex items-center justify-center -mt-16">
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
                        class="w-20 h-20 rounded-full mx-auto border-2 border-primary shadow-md bg-tertiary flex items-center justify-center -mt-16">
                        <i class="ri-user-fill text-black text-3xl"></i>
                    </div>
                    <p class="mt-4 text-quaternary italic">
                        <span class="text-secondary text-xl">“</span>The staff is friendly, and the food is always fresh.
                        I’m definitely coming back for more!<span class="text-secondary text-xl">”</span>
                    </p>
                    <h4 class="mt-4 text-primary font-bold">Ishika Sigdel</h4>
                </div>
                <!-- Testimonial 4 -->
                <div class="swiper-slide bg-tertiary border border-gray-200 rounded-lg shadow-lg p-6 text-center">
                    <!-- User icon instead of image -->
                    <div
                        class="w-20 h-20 rounded-full mx-auto border-2 border-primary shadow-md bg-tertiary flex items-center justify-center -mt-16">
                        <i class="ri-user-fill text-black text-3xl"></i>
                    </div>
                    <p class="mt-4 text-quaternary italic">
                        <span class="text-secondary text-xl">“</span>Absolutely love this place. The fruit bowls are
                        always so fresh and refreshing!<span class="text-secondary text-xl">”</span>
                    </p>
                    <h4 class="mt-4 text-primary font-bold">Pramisha Thapa</h4>
                </div>
                <!-- Testimonial 5 -->
                <div class="swiper-slide bg-tertiary border border-gray-200 rounded-lg shadow-lg p-6 text-center">
                    <!-- User icon instead of image -->
                    <div
                        class="w-20 h-20 rounded-full mx-auto border-2 border-primary shadow-md bg-tertiary flex items-center justify-center -mt-16">
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
