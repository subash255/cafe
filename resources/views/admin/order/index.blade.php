@extends('layouts.app', ['title' => 'Orders Management', 'description' => 'View and manage customer orders'])
@section('content')
    @include('components.admin-table-styles')

    <style>
        /* Fix dropdown positioning - override all table overflow restrictions */
        .admin-table-container,
        .admin-table-inner,
        .overflow-x-auto,
        .modern-table,
        .modern-table tbody,
        .modern-table tbody tr,
        .modern-table tbody tr td {
            overflow: visible !important;
        }

        /* Status dropdown positioning with higher z-index */
        .order-row {
            position: relative;
            z-index: 1;
        }

        .order-row td[data-label="Order Status"] {
            position: relative;
            z-index: 10;
        }

        /* All dropdowns open upward to prevent cutoff */
        [id*="-status-dropdown-"] {
            position: absolute !important;
            bottom: 100% !important;
            left: 0 !important;
            z-index: 9999 !important;
            background: white !important;
            border: 1px solid #d1d5db !important;
            border-radius: 8px !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
            min-width: 150px !important;
            margin-bottom: 4px !important;
        }

        /* Ensure dropdown buttons are properly styled */
        [id*="-status-dropdown-"] button {
            display: block !important;
            width: 100% !important;
            text-align: left !important;
            padding: 8px 12px !important;
            border: none !important;
            background: transparent !important;
            cursor: pointer !important;
        }

        [id*="-status-dropdown-"] button:hover {
            background: #f3f4f6 !important;
        }
    </style>

    {{-- Enhanced Flash Message --}}
    @if (session('success'))
        <div id="flash-message"
            class="fixed top-6 right-6 bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-4 rounded-xl shadow-lg z-50 flex items-center">
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

    <!-- Page Header with Stats -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Orders Management</h1>
                <p class="text-gray-600 mt-2">View and manage customer orders</p>
            </div>
            <div class="flex items-center space-x-3">
                <button onclick="refreshStats()"
                    class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-lg hover:bg-blue-200 transition-colors">
                    <i class="ri-refresh-line mr-2"></i>
                    Refresh Stats
                </button>
            </div>
        </div>


    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="relative">
                <i class="ri-search-line absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" id="searchInput" placeholder="Search by order ID, customer name, or email..."
                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <select id="statusFilter"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Order Status</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="delivered">Delivered</option>
                <option value="cancelled">Cancelled</option>
            </select>

            <select id="paymentFilter"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Payment Status</option>
                <option value="pending">Payment Pending</option>
                <option value="completed">Payment Completed</option>
                <option value="failed">Payment Failed</option>
            </select>
        </div>
    </div>

    <!-- Enhanced Table Section -->
    <div class="admin-table-container">
        <div class="admin-table-inner">
            <div class="overflow-x-auto">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Order Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="orderTableBody">
                        @forelse ($orders as $order)
                            <tr class="order-row" data-order-status="{{ $order->order_status }}"
                                data-payment-status="{{ $order->payment_status }}">
                                <td data-label="Order ID">
                                    <div class="flex items-center">

                                        <div>
                                            <p class="text-sm font-bold text-gray-900 searchable-id">#{{ $order->id }}
                                            </p>
                                            <p class="text-xs text-gray-500">Order</p>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Customer">
                                    <div class="flex items-center">

                                        <div>
                                            <p class="text-sm font-semibold text-gray-900 searchable-name">
                                                {{ $order->user->name ?? 'Guest' }}</p>
                                            <p class="text-xs text-gray-500 searchable-email">
                                                {{ $order->user->email ?? 'No email' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Items">
                                    <div class="space-y-1">
                                        <div class="flex items-center">
                                            <span
                                                class="text-sm font-medium text-gray-900">{{ $order->orderItems->count() }}</span>
                                        </div>

                                    </div>
                                </td>
                                <td data-label="Amount">
                                    <div class="text-center">
                                        <p class="text-sm font-bold text-gray-900">Rs.
                                            {{ number_format($order->total_amount) }}</p>
                                    </div>
                                </td>
                                <td data-label="Payment Method">
                                    <div class="flex items-center">
                                        @if ($order->payment_method === 'esewa')
                                            <div
                                                class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-2">
                                                <i class="ri-smartphone-line text-green-600"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">eSewa</span>
                                        @else
                                            <div
                                                class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-2">
                                                <i class="ri-money-dollar-circle-line text-yellow-600"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">Cash on Delivery</span>
                                        @endif
                                    </div>
                                </td>
                                <td data-label="Order Status">
                                    <div class="relative">
                                        <button onclick="toggleStatusDropdown({{ $order->id }}, 'order')"
                                            class="status-badge cursor-pointer hover:opacity-80 transition-opacity
                                    @if ($order->order_status === 'delivered') status-active
                                    @elseif($order->order_status === 'processing') status-pending
                                    @elseif($order->order_status === 'cancelled') status-inactive
                                    @else status-pending @endif">
                                            @if ($order->order_status === 'delivered')
                                                <i class="ri-check-line mr-1"></i>Delivered
                                            @elseif($order->order_status === 'processing')
                                                <i class="ri-truck-line mr-1"></i>Processing
                                            @elseif($order->order_status === 'cancelled')
                                                <i class="ri-close-line mr-1"></i>Cancelled
                                            @else
                                                <i class="ri-time-line mr-1"></i>Pending
                                            @endif
                                            <i class="ri-arrow-down-s-line ml-1"></i>
                                        </button>

                                        <div id="order-status-dropdown-{{ $order->id }}"
                                            class="absolute bottom-full left-0 mb-1 bg-white border border-gray-300 rounded-lg shadow-lg z-50 hidden min-w-32">
                                            <button onclick="updateOrderStatus({{ $order->id }}, 'pending')"
                                                class="dropdown-item w-full text-left px-3 py-2 hover:bg-gray-100 {{ $order->order_status === 'pending' ? 'bg-blue-50 text-blue-700' : '' }}">
                                                <i class="ri-time-line mr-2"></i>Pending
                                            </button>
                                            <button onclick="updateOrderStatus({{ $order->id }}, 'processing')"
                                                class="dropdown-item w-full text-left px-3 py-2 hover:bg-gray-100 {{ $order->order_status === 'processing' ? 'bg-blue-50 text-blue-700' : '' }}">
                                                <i class="ri-truck-line mr-2"></i>Processing
                                            </button>
                                            <button onclick="updateOrderStatus({{ $order->id }}, 'delivered')"
                                                class="dropdown-item w-full text-left px-3 py-2 hover:bg-gray-100 {{ $order->order_status === 'delivered' ? 'bg-blue-50 text-blue-700' : '' }}">
                                                <i class="ri-check-line mr-2"></i>Delivered
                                            </button>
                                            <button onclick="updateOrderStatus({{ $order->id }}, 'cancelled')"
                                                class="dropdown-item w-full text-left px-3 py-2 hover:bg-gray-100 {{ $order->order_status === 'cancelled' ? 'bg-blue-50 text-blue-700' : '' }}">
                                                <i class="ri-close-line mr-2"></i>Cancelled
                                            </button>
                                        </div>
                                    </div>
                                </td>


                                <td data-label="Actions">
                                    <div class="flex items-center space-x-2">
                                        <!-- Print Button -->
                                        <button class="action-button btn-edit" onclick="printOrder({{ $order->id }})">
                                            <i class="ri-printer-line"></i>
                                        </button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.order.delete', ['id' => $order->id]) }}"
                                            method="post"
                                            onsubmit="return confirm('Are you sure you want to delete this order? This action cannot be undone.');"
                                            class="inline">
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
                                <td colspan="9" class="no-data">
                                    <i class="ri-shopping-cart-line"></i>
                                    <p class="text-lg font-medium">No orders found</p>
                                    <p class="text-sm">Orders will appear here once customers start placing orders</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <script>
        // Search and Filter functionality
        document.getElementById('searchInput').addEventListener('input', filterOrders);
        document.getElementById('statusFilter').addEventListener('change', filterOrders);
        document.getElementById('paymentFilter').addEventListener('change', filterOrders);

        function filterOrders() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const paymentFilter = document.getElementById('paymentFilter').value;
            const rows = document.querySelectorAll('.order-row');

            rows.forEach(row => {
                const orderId = row.querySelector('.searchable-id').textContent.toLowerCase();
                const customerName = row.querySelector('.searchable-name').textContent.toLowerCase();
                const customerEmail = row.querySelector('.searchable-email').textContent.toLowerCase();

                const orderStatus = row.dataset.orderStatus;
                const paymentStatus = row.dataset.paymentStatus;

                const matchesSearch = orderId.includes(searchTerm) ||
                    customerName.includes(searchTerm) ||
                    customerEmail.includes(searchTerm);

                const matchesStatus = !statusFilter || orderStatus === statusFilter;
                const matchesPayment = !paymentFilter || paymentStatus === paymentFilter;

                const isVisible = matchesSearch && matchesStatus && matchesPayment;
                row.style.display = isVisible ? '' : 'none';
            });
        }

        function updateOrderStatus(orderId, status) {
            if (!confirm('Are you sure you want to update this order status?')) {
                return;
            }

            fetch(`/admin/order/${orderId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        order_status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    location.reload();
                });
        }

        function updatePaymentStatus(orderId, status) {
            if (!confirm('Are you sure you want to update this payment status?')) {
                return;
            }

            fetch(`/admin/order/${orderId}/update-payment-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        payment_status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    location.reload();
                });
        }

        function toggleStatusDropdown(orderId, type) {
            const dropdownId = `${type}-status-dropdown-${orderId}`;
            const dropdown = document.getElementById(dropdownId);

            // Close all other dropdowns
            document.querySelectorAll('[id*="-status-dropdown-"]').forEach(el => {
                if (el.id !== dropdownId) {
                    el.classList.add('hidden');
                }
            });

            // Toggle current dropdown
            dropdown.classList.toggle('hidden');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('[onclick*="toggleStatusDropdown"]') && !e.target.closest(
                    '[id*="-status-dropdown-"]')) {
                document.querySelectorAll('[id*="-status-dropdown-"]').forEach(el => {
                    el.classList.add('hidden');
                });
            }
        });

        function printOrder(orderId) {
            // Implementation for printing order
            window.open(`/admin/order/${orderId}/print`, '_blank');
        }

        function refreshStats() {
            // Implementation for refreshing statistics
            location.reload();
        }
    </script>
@endsection
