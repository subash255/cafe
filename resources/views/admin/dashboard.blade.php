@extends('layouts.app')
@section('content')
    <style>
        #myChart {
            width: 100% !important;
            max-width: 100%;
            height: 400px;
            max-height: 500px;
            margin: 0 auto;
        }

        #orderLineChart {
            height: 285px !important;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Cards Section -->
    <div class="relative grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-3 mx-4 z-20 rounded-lg">
        <!-- Pending Orders Card -->
        <div
            class="bg-white p-6 text-left hover:shadow-2xl flex flex-row items-center justify-between w-full h-20 rounded-lg transform sm:-translate-y-8 lg:-translate-y-12 shadow-lg z-[5]">
            <div>
                <h2 class="text-gray-700 font-medium">Pending Orders</h2>
                <p class="text-gray-700 font-medium">1</p>
            </div>
            <div class="bg-yellow-500 text-white w-12 h-12 flex items-center justify-center rounded-full">
                <i class="ri-time-line text-2xl"></i>
            </div>
        </div>

        <!-- Reservation Card -->
        <div
            class="bg-white p-6 rounded-lg text-left hover:shadow-2xl transition-shadow duration-300 flex flex-row items-center justify-between w-full h-20 transform sm:-translate-y-8 lg:-translate-y-12 shadow-lg">
            <div>
                <h2 class="text-gray-700 font-medium mb-2">Total Reservations</h2>
                <p class="text-gray-700 font-medium">2</p>
            </div>
            <div class="bg-yellow-600 text-white w-12 h-12 flex items-center justify-center rounded-full">
                <i class="ri-calendar-check-fill text-2xl"></i>
            </div>
        </div>

        <!-- Sales Card -->
        <div
            class="bg-white p-6 rounded-lg text-left hover:shadow-2xl transition-shadow duration-300 flex flex-row items-center justify-between w-full h-20 transform sm:-translate-y-8 lg:-translate-y-12 shadow-lg">
            <div>
                <h2 class="text-gray-700 font-medium mb-2">Total Sales</h2>
                <p class="text-gray-700 font-medium">€300</p>
            </div>
            <div class="bg-purple-600 text-white w-12 h-12 flex items-center justify-center rounded-full">
                <i class="ri-money-dollar-circle-fill text-2xl"></i>
            </div>
        </div>

        <!-- Orders Card -->
        <div
            class="bg-white p-6 rounded-lg text-left hover:shadow-2xl transition-shadow duration-300 flex flex-row items-center justify-between w-full h-20 transform sm:-translate-y-4 lg:-translate-y-8 shadow-lg">
            <div>
                <h2 class="text-gray-700 font-medium mb-2">Orders</h2>
                <p class="text-gray-700 font-medium">4</p>
            </div>
            <div class="bg-green-500 text-white w-12 h-12 flex items-center justify-center rounded-full">
                <i class="ri-shopping-cart-fill text-2xl"></i>
            </div>
        </div>



        <!-- Visitors Card -->
        <div
            class="bg-white p-6 rounded-lg text-left hover:shadow-2xl transition-shadow duration-300 flex flex-row items-center justify-between w-full h-20 transform sm:-translate-y-4 lg:-translate-y-8 shadow-lg">
            <div>
                <h2 class="text-gray-700 font-medium mb-2">Visitors</h2>
                <p class="text-gray-700 font-medium">5</p>
            </div>
            <div class="bg-red-500 text-white w-12 h-12 flex items-center justify-center rounded-full">
                <i class="ri-earth-fill text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- <div class="grid sm:grid-cols-3 gap-4 px-4">
        <!-- Order Line Chart 
        <div class="bg-white rounded-lg p-6 w-full col-span-2">
            <h2 class="text-xl font-semibold text-center mb-4">Daily Orders</h2>
            <canvas id="orderLineChart"></canvas>
        </div>

        Category Pie Chart
        <div class="bg-white rounded-lg p-6 w-full">
            <h2 class="text-xl font-semibold text-center">Categories and Fooditems Count</h2>
            <canvas id="categoryChart"></canvas>
        </div>
    </div>
    <div class="flex items-center justify-center py-8 px-4">
        <div class="w-full">
            <div class="flex flex-col justify-between h-full">
                <div>
                    <div class="lg:flex w-full justify-between">
                        <h3 class="text-gray-600 dark:text-gray-100 leading-5 text-base md:text-xl font-bold">Details of
                            Visits</h3>
                    </div>
                </div>
                <div class="mt-2">
                    <canvas id="myChart" role="img"
                        aria-label="line graph to show selling overview in terms of months and numbers"></canvas>
                </div>
            </div>
        </div>
    </div> -->

    
@endsection