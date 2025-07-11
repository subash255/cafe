@extends('layouts.master')
@section('title', 'Contact Us | Nepali Cafe')
@section('content')

<div style="background-image: url('images/cup.jpeg');" class="bg-cover h-36 md:h-40 relative">
    <div class="bg-black bg-opacity-75 absolute inset-0 h-36 md:h-40 flex items-center justify-center">
        <div class="xl:px-12 lg:px-8 sm:px-5 px-3">
            <div class="2xl:max-w-[1600px] xl:max-w-[1280px] w-full mx-auto">
                <h1 class="md:text-3xl sm:text-2xl text-xl font-semibold uppercase text-tertiary">
                    Contact Us
                </h1>
            </div>
        </div>
    </div>
</div>

<!-- Contact Us Section -->
<section class="py-16 px-4 md:px-16">
    <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 gap-16 items-center">
        <!-- Left: Text content -->
        <div>
            <h2 class="text-3xl md:text-4xl font-bold text-secondary mb-6 border-l-4 border-primary pl-4">Get in Touch</h2>
            <p class="text-lg md:text-xl text-quaternary leading-relaxed mb-6 text-justify">
                We would love to hear from you! Whether you have a question, feedback, or just want to say hello, feel free to reach out to us. Our team is here to assist you and ensure you have the best experience at Nepali Cafe.
            </p>
            <p class="mt-3 text-lg md:text-xl text-quaternary leading-relaxed mb-6 text-justify">
                You can contact us via email or visit us at our cafe. We look forward to connecting with you!
            </p>
        </div>

        <!-- Right: Contact Form -->
        <div>
            <form action="#" method="POST" class="space-y-6">
                <input type="text" name="name" placeholder="Your Name" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                <input type="email" name="email" placeholder="Your Email" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                <textarea name="message" rows="4" placeholder="Your Message" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"></textarea>
                <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg hover:bg-secondary transition duration-300">Send Message</button>
            </form>
        </div>
    </div>
</section>

@endsection