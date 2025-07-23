@extends('layouts.app')
@section('content')

@include('components.admin-table-styles')

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

<!-- Search Section -->
<div class="search-container">
    <div class="relative">
        <i class="ri-search-line search-icon"></i>
        <input type="text" 
               id="searchInput" 
               placeholder="Search reservations by name, email, or phone..." 
               class="search-input">
    </div>
</div>

<!-- Enhanced Table Section -->
<div class="admin-table-container">
    <div class="admin-table-inner">
        <div class="overflow-x-auto">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>Guests</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="reservationTableBody">
                    @forelse ($reservations as $reservation)
                    <tr class="reservation-row">
                        <td data-label="S.N">
                            <span class="text-sm font-medium text-gray-900">{{ $loop->iteration }}</span>
                        </td>
                        <td data-label="Customer">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full flex items-center justify-center mr-3">
                                    <i class="ri-user-3-line text-white"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 searchable-name">{{ $reservation->name }}</p>
                                    <p class="text-xs text-gray-500">Customer</p>
                                </div>
                            </div>
                        </td>
                        <td data-label="Contact">
                            <div class="space-y-1">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="ri-mail-line mr-2 text-blue-500"></i>
                                    <span class="searchable-email">{{ $reservation->email }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="ri-phone-line mr-2 text-green-500"></i>
                                    <span class="searchable-phone">{{ $reservation->phone }}</span>
                                </div>
                            </div>
                        </td>
                        
                        
                        
                        <td data-label="Guests">
                            <div class="flex items-center">
                                
                                <span class="text-sm font-semibold text-gray-900">{{ $reservation->people }}</span>
                                <span class="text-xs text-gray-500 ml-1">{{ $reservation->people == 1 ? 'guest' : 'guests' }}</span>
                            </div>
                        </td>
                        <td data-label="Status">
                            @php
                                $reservationDateTime = \Carbon\Carbon::parse($reservation->date . ' ' . $reservation->time);
                                $isUpcoming = $reservationDateTime->isFuture();
                                $isPast = $reservationDateTime->isPast();
                                $isToday = $reservationDateTime->isToday();
                            @endphp
                            
                            @if($reservation->status === 'confirmed')
                                <span class="status-badge status-active">
                                    <i class="ri-check-line mr-1"></i>
                                    Confirmed
                                </span>
                            @elseif($reservation->status === 'cancelled')
                                <span class="status-badge status-inactive">
                                    <i class="ri-close-line mr-1"></i>
                                    Cancelled
                                </span>
                            @elseif($reservation->status === 'pending')
                                <span class="status-badge status-pending">
                                    <i class="ri-time-line mr-1"></i>
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td data-label="Actions">
                            <div class="flex items-center space-x-2">
                                <!-- View Details Button -->
                                <button class="action-button btn-view"
                                        onclick="viewReservationDetails('{{ $reservation->id }}', '{{ $reservation->name }}', '{{ $reservation->email }}', '{{ $reservation->phone }}', '{{ $reservation->date }}', '{{ $reservation->time }}', '{{ $reservation->people }}', '{{ $reservation->status }}')">
                                    <i class="ri-eye-line"></i>
                                </button>
                                
                                <!-- Delete Button -->
                                <form action="{{ route('admin.reservation.delete', ['id' => $reservation->id]) }}" method="post"
                                      onsubmit="return confirm('Are you sure you want to delete this reservation?');" class="inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="action-button btn-delete">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="no-data">
                            <i class="ri-calendar-line"></i>
                            <p class="text-lg font-medium">No reservations found</p>
                            <p class="text-sm">Reservations will appear here once customers start booking tables</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Reservation Details Modal -->
<div id="reservationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto relative shadow-2xl">
        <div class="sticky top-0 bg-white border-b border-gray-200 p-6 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-800">Reservation Details</h2>
                <button onclick="closeReservationModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="ri-close-line text-2xl"></i>
                </button>
            </div>
        </div>
        
        <div class="p-6">
            <div id="reservationDetails" class="space-y-4 mb-6">
                <!-- Details will be populated by JavaScript -->
            </div>
            
            <div class="flex justify-between items-center pt-6 border-t">
                <div class="flex space-x-3">
                    <button id="acceptBtn" onclick="updateReservationStatus('accept')" 
                            class="px-6 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:from-green-600 hover:to-green-700 transition-all flex items-center">
                        <i class="ri-check-line mr-2"></i>
                        Accept
                    </button>
                    <button id="rejectBtn" onclick="updateReservationStatus('reject')" 
                            class="px-6 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:from-red-600 hover:to-red-700 transition-all flex items-center">
                        <i class="ri-close-line mr-2"></i>
                        Reject
                    </button>
                </div>
                <button onclick="closeReservationModal()" 
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentReservationId = null;

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('.reservation-row');
        
        rows.forEach(row => {
            const name = row.querySelector('.searchable-name')?.textContent.toLowerCase() || '';
            const email = row.querySelector('.searchable-email')?.textContent.toLowerCase() || '';
            const phone = row.querySelector('.searchable-phone')?.textContent.toLowerCase() || '';
            const date = row.querySelector('.searchable-date')?.textContent.toLowerCase() || '';
            const time = row.querySelector('.searchable-time')?.textContent.toLowerCase() || '';
            
            const isVisible = name.includes(searchTerm) || 
                            email.includes(searchTerm) || 
                            phone.includes(searchTerm) || 
                            date.includes(searchTerm) ||
                            time.includes(searchTerm);
            
            row.style.display = isVisible ? '' : 'none';
        });
    });

    function viewReservationDetails(id, name, email, phone, date, time, people, status) {
        currentReservationId = id;
        const modal = document.getElementById('reservationModal');
        const detailsContainer = document.getElementById('reservationDetails');
        const acceptBtn = document.getElementById('acceptBtn');
        const rejectBtn = document.getElementById('rejectBtn');
        
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

        // Show/hide buttons based on status
        if (status === 'confirmed') {
            acceptBtn.style.display = 'none';
            rejectBtn.innerHTML = '<i class="ri-close-line mr-2"></i>Cancel';
        } else if (status === 'cancelled') {
            acceptBtn.innerHTML = '<i class="ri-refresh-line mr-2"></i>Restore';
            rejectBtn.style.display = 'none';
        } else {
            acceptBtn.style.display = 'inline-flex';
            rejectBtn.style.display = 'inline-flex';
            acceptBtn.innerHTML = '<i class="ri-check-line mr-2"></i>Accept';
            rejectBtn.innerHTML = '<i class="ri-close-line mr-2"></i>Reject';
        }
        
        // Get status badge HTML
        let statusBadge = '';
        if (status === 'confirmed') {
            statusBadge = '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800"><i class="ri-check-line mr-1"></i>Confirmed</span>';
        } else if (status === 'cancelled') {
            statusBadge = '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800"><i class="ri-close-line mr-1"></i>Cancelled</span>';
        } else {
            statusBadge = '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800"><i class="ri-time-line mr-1"></i>Pending</span>';
        }
        
        detailsContainer.innerHTML = `
            <div class="grid grid-cols-1 gap-4">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center">
                            <i class="ri-user-3-line text-blue-500 mr-2"></i>
                            <span class="font-semibold text-gray-700">Customer Name</span>
                        </div>
                        ${statusBadge}
                    </div>
                    <p class="text-gray-900 font-medium">${name}</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <i class="ri-mail-line text-green-500 mr-2"></i>
                            <span class="font-semibold text-gray-700">Email</span>
                        </div>
                        <p class="text-gray-900 text-sm break-all">${email}</p>
                    </div>
                    
                    <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <i class="ri-phone-line text-purple-500 mr-2"></i>
                            <span class="font-semibold text-gray-700">Phone</span>
                        </div>
                        <p class="text-gray-900 text-sm">${phone}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <i class="ri-calendar-line text-orange-500 mr-2"></i>
                            <span class="font-semibold text-gray-700">Date</span>
                        </div>
                        <p class="text-gray-900 text-sm">${formattedDate}</p>
                    </div>
                    
                    <div class="bg-gradient-to-r from-red-50 to-red-100 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <i class="ri-time-line text-red-500 mr-2"></i>
                            <span class="font-semibold text-gray-700">Time</span>
                        </div>
                        <p class="text-gray-900 text-sm">${formattedTime}</p>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 rounded-lg p-4">
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
        document.body.style.overflow = 'hidden';
    }
    
    function closeReservationModal() {
        const modal = document.getElementById('reservationModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
        currentReservationId = null;
    }

    function updateReservationStatus(action) {
        if (!currentReservationId) return;
        
        const actionButton = document.getElementById(action === 'accept' ? 'acceptBtn' : 'rejectBtn');
        const originalContent = actionButton.innerHTML;
        
        // Show loading state
        actionButton.innerHTML = `<i class="ri-loader-4-line animate-spin mr-2"></i>${action === 'accept' ? 'Accepting...' : 'Rejecting...'}`;
        actionButton.disabled = true;
        
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/reservation/${currentReservationId}/${action}`;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (csrfToken) {
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken.getAttribute('content');
            form.appendChild(csrfInput);
        }
        
        document.body.appendChild(form);
        form.submit();
    }

    // Close modal when clicking outside
    document.getElementById('reservationModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeReservationModal();
        }
    });
</script>

@endsection