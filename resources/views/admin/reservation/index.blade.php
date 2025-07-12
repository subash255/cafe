@extends('layouts.app')
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

<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Reservations Management</h1>
            <p class="text-gray-600 mt-2">View and manage table reservations</p>
        </div>
        <div class="flex items-center space-x-3">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                <i class="ri-calendar-line mr-1"></i>
                Today: {{ now()->format('M d, Y') }}
            </span>
        </div>
    </div>
</div>

<!-- Enhanced Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="admin-card rounded-2xl p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                <i class="ri-calendar-check-line text-blue-600 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Total Reservations</p>
                <p class="text-2xl font-bold text-gray-800">{{ $reservations->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="admin-card rounded-2xl p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                <i class="ri-calendar-today-line text-green-600 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Today's Bookings</p>
                <p class="text-2xl font-bold text-gray-800">{{ $reservations->where('date', now()->format('Y-m-d'))->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="admin-card rounded-2xl p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mr-4">
                <i class="ri-group-line text-orange-600 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Total Guests</p>
                <p class="text-2xl font-bold text-gray-800">{{ $reservations->sum('people') }}</p>
            </div>
        </div>
    </div>
    
    <div class="admin-card rounded-2xl p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                <i class="ri-time-line text-purple-600 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Upcoming</p>
                <p class="text-2xl font-bold text-gray-800">{{ $reservations->where('date', '>=', now()->format('Y-m-d'))->count() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Table Section -->
<div class="admin-card rounded-2xl overflow-hidden">
    <div class="p-6 border-b bg-gradient-to-r from-gray-50 to-white">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-800">All Reservations</h3>
                <p class="text-gray-600 text-sm mt-1">Manage customer table bookings</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <i class="ri-search-line absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Search reservations..." 
                           class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table id="reservationTable" class="modern-table w-full">
            <thead>
                <tr>
                    <th class="text-left">S.N</th>
                    <th class="text-left">Customer</th>
                    <th class="text-left">Contact</th>
                    <th class="text-left">Date & Time</th>
                    <th class="text-left">Guests</th>
                    <th class="text-left">Status</th>
                    <th class="text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
            <tbody>
                @foreach ($reservations as $reservation)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <span class="text-sm font-medium text-gray-900">{{ $loop->iteration }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <i class="ri-user-3-line text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $reservation->name }}</p>
                                <p class="text-xs text-gray-500">Customer</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="space-y-1">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="ri-mail-line mr-2"></i>
                                {{ $reservation->email }}
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="ri-phone-line mr-2"></i>
                                {{ $reservation->phone }}
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="space-y-1">
                            <div class="flex items-center text-sm font-medium text-gray-900">
                                <i class="ri-calendar-line mr-2 text-blue-500"></i>
                                {{ \Carbon\Carbon::parse($reservation->date)->format('M d, Y') }}
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="ri-time-line mr-2 text-green-500"></i>
                                {{ \Carbon\Carbon::parse($reservation->time)->format('h:i A') }}
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-2">
                                <i class="ri-group-line text-orange-600"></i>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">{{ $reservation->people }}</span>
                            <span class="text-xs text-gray-500 ml-1">{{ $reservation->people == 1 ? 'guest' : 'guests' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $reservationDateTime = \Carbon\Carbon::parse($reservation->date . ' ' . $reservation->time);
                            $isUpcoming = $reservationDateTime->isFuture();
                            $isPast = $reservationDateTime->isPast();
                            $isToday = $reservationDateTime->isToday();
                        @endphp
                        
                        @if($isPast && !$isToday)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <i class="ri-check-line mr-1"></i>
                                Completed
                            </span>
                        @elseif($isToday)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <i class="ri-time-line mr-1"></i>
                                Today
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="ri-calendar-check-line mr-1"></i>
                                Upcoming
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <!-- View Details Button -->
                            <button class="w-8 h-8 bg-blue-100 hover:bg-blue-200 rounded-lg flex items-center justify-center transition-colors group"
                                    onclick="viewReservationDetails('{{ $reservation->id }}', '{{ $reservation->name }}', '{{ $reservation->email }}', '{{ $reservation->phone }}', '{{ $reservation->date }}', '{{ $reservation->time }}', '{{ $reservation->people }}')">
                                <i class="ri-eye-line text-blue-600 group-hover:text-blue-700"></i>
                            </button>
                            
                            <!-- Delete Button -->
                            <form action="{{ route('admin.reservation.delete', ['id' => $reservation->id]) }}" method="post"
                                  onsubmit="return confirm('Are you sure you want to delete this reservation?');">
                                @csrf
                                @method('delete')
                                <button type="submit"
                                        class="w-8 h-8 bg-red-100 hover:bg-red-200 rounded-lg flex items-center justify-center transition-colors group">
                                    <i class="ri-delete-bin-line text-red-600 group-hover:text-red-700"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Reservation Details Modal -->
<div id="reservationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 w-full max-w-lg mx-4 relative">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Reservation Details</h2>
            <button onclick="closeReservationModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="ri-close-line text-2xl"></i>
            </button>
        </div>
        
        <div id="reservationDetails" class="space-y-4">
            <!-- Details will be populated by JavaScript -->
        </div>
        
        <div class="flex justify-end space-x-3 mt-8 pt-6 border-t">
            <button onclick="closeReservationModal()" 
                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                Close
            </button>
        </div>
    </div>
</div>

<script>
    function viewReservationDetails(id, name, email, phone, date, time, people) {
        const modal = document.getElementById('reservationModal');
        const detailsContainer = document.getElementById('reservationDetails');
        
        const formattedDate = new Date(date).toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        const formattedTime = new Date(`1970-01-01T${time}`).toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });
        
        detailsContainer.innerHTML = `
            <div class="grid grid-cols-1 gap-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <i class="ri-user-3-line text-blue-500 mr-2"></i>
                        <span class="font-semibold text-gray-700">Customer Name</span>
                    </div>
                    <p class="text-gray-900 font-medium">${name}</p>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <i class="ri-mail-line text-green-500 mr-2"></i>
                            <span class="font-semibold text-gray-700">Email</span>
                        </div>
                        <p class="text-gray-900 text-sm">${email}</p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <i class="ri-phone-line text-purple-500 mr-2"></i>
                            <span class="font-semibold text-gray-700">Phone</span>
                        </div>
                        <p class="text-gray-900 text-sm">${phone}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <i class="ri-calendar-line text-orange-500 mr-2"></i>
                            <span class="font-semibold text-gray-700">Date</span>
                        </div>
                        <p class="text-gray-900 text-sm">${formattedDate}</p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <i class="ri-time-line text-red-500 mr-2"></i>
                            <span class="font-semibold text-gray-700">Time</span>
                        </div>
                        <p class="text-gray-900 text-sm">${formattedTime}</p>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <i class="ri-group-line text-indigo-500 mr-2"></i>
                        <span class="font-semibold text-gray-700">Number of Guests</span>
                    </div>
                    <p class="text-gray-900 font-medium">${people} ${people == 1 ? 'guest' : 'guests'}</p>
                </div>
            </div>
        `;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    
    function closeReservationModal() {
        const modal = document.getElementById('reservationModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Initialize DataTable
    $(document).ready(function() {
        $('#reservationTable').DataTable({
            responsive: true,
            pageLength: 10,
            order: [[3, 'desc']], // Sort by date
            columnDefs: [
                { orderable: false, targets: [6] } // Disable sorting on Actions column
            ],
            language: {
                search: "",
                searchPlaceholder: "Search reservations...",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ reservations",
            },
            dom: '<"flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4"<"flex items-center"l><"flex items-center"f>>rtip',
        });

        // Custom search styling
        $('.dataTables_filter input').addClass('modern-input px-4 py-2 w-64');
        $('.dataTables_length select').addClass('modern-input px-3 py-2');
    });
</script>

@endsection