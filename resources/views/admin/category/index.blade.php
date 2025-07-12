@extends('layouts.app')
@section('content')
<style>
    /* Enhanced Modal Styling */
    .modern-modal {
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(8px);
    }
    
    .modal-content {
        background: white;
        border-radius: 20px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        border: 1px solid #e2e8f0;
    }
    
    .modern-input {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        transition: all 0.3s ease;
        background: #f8fafc;
    }
    
    .modern-input:focus {
        border-color: #3b82f6;
        background: white;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .modern-button {
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .modal-hidden {
        display: none !important;
    }
    
    .modal-visible {
        display: flex !important;
    }
</style>

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
            <h1 class="text-3xl font-bold text-gray-800">Categories Management</h1>
            <p class="text-gray-600 mt-2">Organize and manage your menu categories</p>
        </div>
        <button id="openModalButton"
            class="modern-button bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 hover:from-blue-600 hover:to-blue-700 flex items-center space-x-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <i class="ri-add-line text-xl"></i>
            <span>Add New Category</span>
        </button>
    </div>
</div>

<!-- Enhanced Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="admin-card rounded-2xl p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                <i class="ri-folder-line text-blue-600 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Total Categories</p>
                <p class="text-2xl font-bold text-gray-800">{{ $categories->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="admin-card rounded-2xl p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                <i class="ri-eye-line text-green-600 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Available Categories</p>
                <p class="text-2xl font-bold text-gray-800">{{ $categories->where('status', 1)->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="admin-card rounded-2xl p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mr-4">
                <i class="ri-restaurant-line text-orange-600 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Menu Items</p>
                <p class="text-2xl font-bold text-gray-800">{{ $categories->sum(function($category) { return $category->fooditems->count(); }) }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Modal Structure -->
<div id="categoryModal" class="fixed inset-0 modern-modal modal-hidden items-center justify-center z-50">
    <div class="modal-content p-8 w-full max-w-2xl mx-4 relative">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Create New Category</h2>
                <p class="text-gray-600 mt-1">Add a new category to organize your menu items</p>
            </div>
            <button id="closeModalButton" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="ri-close-line text-2xl"></i>
            </button>
        </div>
        
        <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Category Name Input -->
            <div>
                <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Category Name</label>
                <input type="text" id="category" name="name" placeholder="Enter category name"
                    class="modern-input w-full px-4 py-3 text-gray-800 placeholder-gray-500"
                    oninput="generateSlug()">
            </div>

            <!-- Slug Input -->
            <div>
                <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">Slug</label>
                <input type="text" id="slug" name="slug" placeholder="Generated automatically"
                    class="modern-input w-full px-4 py-3 text-gray-800 placeholder-gray-500">
            </div>

            <!-- Image Upload -->
            <div>
                <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">Category Image</label>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 hover:border-blue-400 transition-colors">
                    <input type="file" id="image" name="image" accept="image/*" required
                        class="w-full text-gray-600">
                    <p class="text-sm text-gray-500 mt-2">Upload an image for this category (PNG, JPG, JPEG)</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t">
                <button type="button" id="closeModalButton2"
                    class="modern-button px-6 py-3 border-2 border-gray-300 text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                    class="modern-button bg-gradient-to-r from-blue-500 to-blue-600 text-white px-8 py-3 hover:from-blue-600 hover:to-blue-700 shadow-lg">
                    Create Category
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Enhanced Table Section -->
<div class="admin-card rounded-2xl overflow-hidden">
    <div class="p-6 border-b bg-gradient-to-r from-gray-50 to-white">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-800">All Categories</h3>
                <p class="text-gray-600 text-sm mt-1">Manage your existing categories</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <i class="ri-search-line absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Search categories..." 
                           class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table id="categoryTable" class="modern-table w-full">
            <thead>
                <tr>
                    <th class="text-left">S.N</th>
                    <th class="text-left">Category Name</th>
                    <th class="text-left">Slug</th>
                    <th class="text-left">Items Count</th>
                    <th class="text-left">Status</th>
                    <th class="text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <span class="text-sm font-medium text-gray-900">{{ $loop->iteration }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="ri-folder-line text-gray-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $category->name }}</p>
                                <p class="text-xs text-gray-500">Created {{ $category->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-gray-600 bg-gray-100 px-2 py-1 rounded-lg">{{ $category->slug }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <span class="text-sm font-semibold text-gray-900">{{ $category->fooditems->count() }}</span>
                            <span class="text-xs text-gray-500 ml-1">items</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <label for="status{{ $category->id }}" class="inline-flex items-center cursor-pointer">
                            <input id="status{{ $category->id }}" type="checkbox" class="hidden toggle-switch" 
                                   data-id="{{ $category->id }}" {{ $category->status ? 'checked' : '' }} />
                            <div class="relative w-12 h-6 bg-gray-200 rounded-full transition-colors duration-200 {{ $category->status ? 'bg-blue-500' : '' }}">
                                <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform duration-200 {{ $category->status ? 'transform translate-x-6' : '' }}"></div>
                            </div>
                            <span class="ml-2 text-sm {{ $category->status ? 'text-green-600' : 'text-gray-500' }}">
                                {{ $category->status ? 'Active' : 'Inactive' }}
                            </span>
                        </label>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <!-- Edit Button -->
                            <a href="{{ route('admin.category.edit', ['id' => $category->id]) }}"
                               class="w-8 h-8 bg-blue-100 hover:bg-blue-200 rounded-lg flex items-center justify-center transition-colors group">
                                <i class="ri-edit-line text-blue-600 group-hover:text-blue-700"></i>
                            </a>
                            
                            <!-- Delete Button -->
                            <form action="{{ route('admin.category.delete', ['id' => $category->id]) }}" method="post"
                                  onsubmit="return confirm('Are you sure you want to delete this category?');">
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

<script>
    // Enhanced Modal functionality
    function generateSlug() {
        let input1 = document.getElementById('category').value;
        let slug = input1.trim().replace(/\s+/g, '-').toLowerCase();
        document.getElementById('slug').value = slug;
    }

    // Open modal with animation
    document.getElementById('openModalButton').addEventListener('click', function() {
        const modal = document.getElementById('categoryModal');
        modal.classList.remove('modal-hidden');
        modal.classList.add('modal-visible');
        document.body.classList.add('overflow-hidden');
        
        // Add animation
        modal.style.opacity = '0';
        modal.style.transform = 'scale(0.95)';
        setTimeout(() => {
            modal.style.opacity = '1';
            modal.style.transform = 'scale(1)';
            modal.style.transition = 'all 0.3s ease';
        }, 10);
    });

    // Close modal function
    function closeModal() {
        const modal = document.getElementById('categoryModal');
        modal.style.opacity = '0';
        modal.style.transform = 'scale(0.95)';
        setTimeout(() => {
            modal.classList.remove('modal-visible');
            modal.classList.add('modal-hidden');
            document.body.classList.remove('overflow-hidden');
        }, 300);
    }

    // Close modal event listeners
    document.getElementById('closeModalButton').addEventListener('click', closeModal);
    document.getElementById('closeModalButton2').addEventListener('click', closeModal);

    // Close modal when clicking outside
    document.getElementById('categoryModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    // Enhanced toggle switches
    document.querySelectorAll('.toggle-switch').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const categoryId = this.getAttribute('data-id');
            const newState = this.checked ? 1 : 0;
            const toggleContainer = this.nextElementSibling;
            const statusText = toggleContainer.nextElementSibling;
            
            // Update UI immediately
            if (this.checked) {
                toggleContainer.classList.add('bg-blue-500');
                toggleContainer.classList.remove('bg-gray-200');
                toggleContainer.querySelector('div').classList.add('transform', 'translate-x-6');
                statusText.textContent = 'Active';
                statusText.classList.add('text-green-600');
                statusText.classList.remove('text-gray-500');
            } else {
                toggleContainer.classList.remove('bg-blue-500');
                toggleContainer.classList.add('bg-gray-200');
                toggleContainer.querySelector('div').classList.remove('transform', 'translate-x-6');
                statusText.textContent = 'Inactive';
                statusText.classList.remove('text-green-600');
                statusText.classList.add('text-gray-500');
            }

            // Send AJAX request
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`category/update-toggle/${categoryId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    state: newState,
                    type: 'status',
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Status updated successfully!', 'success');
                } else {
                    // Revert UI changes if request failed
                    this.checked = !this.checked;
                    // Revert toggle appearance
                    if (this.checked) {
                        toggleContainer.classList.add('bg-blue-500');
                        toggleContainer.classList.remove('bg-gray-200');
                        toggleContainer.querySelector('div').classList.add('transform', 'translate-x-6');
                        statusText.textContent = 'Active';
                        statusText.classList.add('text-green-600');
                        statusText.classList.remove('text-gray-500');
                    } else {
                        toggleContainer.classList.remove('bg-blue-500');
                        toggleContainer.classList.add('bg-gray-200');
                        toggleContainer.querySelector('div').classList.remove('transform', 'translate-x-6');
                        statusText.textContent = 'Inactive';
                        statusText.classList.remove('text-green-600');
                        statusText.classList.add('text-gray-500');
                    }
                    showNotification('Failed to update status', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.checked = !this.checked;
                showNotification('An error occurred', 'error');
            });
        });
    });

    // Enhanced notification function
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed top-6 right-6 px-6 py-4 rounded-xl shadow-lg z-50 transform transition-all duration-300 translate-x-full ${
            type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500'
        } text-white flex items-center`;
        
        notification.innerHTML = `
            <i class="ri-${type === 'success' ? 'check' : type === 'error' ? 'error-warning' : 'information'}-line mr-2 text-xl"></i>
            <span class="font-medium">${message}</span>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Initialize DataTable with modern styling
    $(document).ready(function() {
        $('#categoryTable').DataTable({
            responsive: true,
            pageLength: 10,
            order: [[0, 'asc']],
            columnDefs: [
                { orderable: false, targets: [5] }
            ],
            language: {
                search: "",
                searchPlaceholder: "Search categories...",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ categories",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            },
            dom: '<"flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4"<"flex items-center"l><"flex items-center"f>>rtip',
        });

        // Custom search styling
        $('.dataTables_filter input').addClass('modern-input px-4 py-2 w-64');
        $('.dataTables_length select').addClass('modern-input px-3 py-2');
    });
</script>

@endsection