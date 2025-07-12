@extends('layouts.app')
@section('content')
<style>
    /* Enhanced Modal and Form Styling */
    .modern-modal {
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(8px);
    }
    
    .modal-content {
        background: white;
        border-radius: 20px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        border: 1px solid #e2e8f0;
        max-height: 90vh;
        overflow-y: auto;
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
    
    .file-upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .file-upload-area:hover {
        border-color: #3b82f6;
        background-color: #f8fafc;
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
            <h1 class="text-3xl font-bold text-gray-800">Food Items Management</h1>
            <p class="text-gray-600 mt-2">Manage your menu items, pricing, and availability</p>
        </div>
        <button id="openModalButton"
            class="modern-button bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 hover:from-blue-600 hover:to-blue-700 flex items-center space-x-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <i class="ri-add-line text-xl"></i>
            <span>Add New Item</span>
        </button>
    </div>
</div>

<!-- Enhanced Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="admin-card rounded-2xl p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                <i class="ri-restaurant-line text-blue-600 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Total Items</p>
                <p class="text-2xl font-bold text-gray-800">{{ $fooditems->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="admin-card rounded-2xl p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                <i class="ri-eye-line text-green-600 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Active Items</p>
                <p class="text-2xl font-bold text-gray-800">{{ $fooditems->where('status', 1)->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="admin-card rounded-2xl p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mr-4">
                <i class="ri-folder-line text-orange-600 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Categories</p>
                <p class="text-2xl font-bold text-gray-800">{{ $categories->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="admin-card rounded-2xl p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                <i class="ri-money-dollar-circle-line text-purple-600 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Avg. Price</p>
                <p class="text-2xl font-bold text-gray-800">${{ number_format($fooditems->avg('price'), 2) }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Modal Structure -->
<div id="foodModal" class="fixed inset-0 modern-modal modal-hidden items-center justify-center z-50">
    <div class="modal-content p-8 w-full max-w-5xl mx-4 relative">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Create New Food Item</h2>
                <p class="text-gray-600 mt-1">Add a delicious new item to your menu</p>
            </div>
            <button id="closeModalButton" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="ri-close-line text-2xl"></i>
            </button>
        </div>
        
        <form action="{{ route('admin.fooditem.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Food Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Food Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter food item name"
                            class="modern-input w-full px-4 py-3 text-gray-800 placeholder-gray-500" required
                            oninput="generateSlug()">
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">Slug</label>
                        <input type="text" id="slug" name="slug" placeholder="Generated automatically"
                            class="modern-input w-full px-4 py-3 text-gray-800 placeholder-gray-500">
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                        <select id="category_id" name="category_id" required
                            class="modern-input w-full px-4 py-3 text-gray-800">
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Price ($)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                            <input type="number" id="price" name="price" placeholder="0.00" step="0.01" min="0"
                                class="modern-input w-full pl-8 pr-4 py-3 text-gray-800 placeholder-gray-500" required>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                        <textarea id="description" name="description" rows="4" placeholder="Describe your delicious food item..."
                            class="modern-input w-full px-4 py-3 text-gray-800 placeholder-gray-500 resize-none"></textarea>
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">Food Image</label>
                        <div class="file-upload-area p-6 text-center">
                            <input type="file" id="image" name="image" accept="image/*" required
                                class="hidden" onchange="displayImagePreview(this)">
                            <div id="upload-placeholder">
                                <i class="ri-image-add-line text-4xl text-gray-400 mb-3"></i>
                                <p class="text-gray-600 mb-2">Click to upload food image</p>
                                <p class="text-sm text-gray-500">PNG, JPG, JPEG up to 5MB</p>
                                <button type="button" onclick="document.getElementById('image').click()"
                                    class="mt-3 modern-button bg-blue-100 text-blue-600 px-4 py-2 hover:bg-blue-200">
                                    Choose Image
                                </button>
                            </div>
                            <div id="image-preview" class="hidden">
                                <img id="preview-img" src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg mx-auto mb-3">
                                <button type="button" onclick="removeImagePreview()"
                                    class="modern-button bg-red-100 text-red-600 px-3 py-1 text-sm hover:bg-red-200">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
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
                    Create Food Item
                </button>
            </div>
        </form>
    </div>
</div>
            @csrf

            <!-- Flex Container for Two Columns -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- Left Column -->
                <div class="space-y-6">

                    <!-- Food Name Input -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Food Name</label>
                        <input type="text" id="foodname" name="name" placeholder="Enter food name"
                            class="mt-2 px-5 py-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-300 hover:border-indigo-400 text-lg"
                            required oninput="generateSlug()">
                    </div>

                    <!-- Slug Input (auto-generated) -->
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                        <input type="text" id="slug" name="slug" placeholder="Generated slug"
                            class="mt-2 px-5 py-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-300 hover:border-indigo-400 text-lg">
                    </div>

                    <!-- Price Input -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" id="price" name="price" step="0.01" placeholder="Enter price"
                            class="mt-2 px-5 py-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-300 hover:border-indigo-400 text-lg"
                            required>
                    </div>

                    <!-- Description Input -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" placeholder="Enter description"
                            class="mt-2 px-5 py-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-300 hover:border-indigo-400 text-lg"
                            required></textarea>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">

                    <!-- Category Dropdown (Full Width) -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                        <select name="category_id" id="category_id"
                            class="mt-2 px-5 py-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-300 hover:border-indigo-400 text-lg"
                            required>
                            <option value="" disabled selected>Select Category</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Food Type Dropdown (Full Width) -->
                    <div>
                        <label for="category-filter" class="block text-sm font-medium text-gray-700">Select Food Type</label>
                        <select id="category-filter" name="type"
                            class="mt-2 w-full px-5 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-300 hover:border-indigo-400 text-lg"
                            >
                            <option value="">Select Type</option>
                            <option value="veg">Veg</option>
                            <option value="non-veg">Non-Veg</option>
                            <option value="drinks">Drinks</option>
                        </select>
                    </div>

                    <!-- Image Upload Input -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700">Upload Image</label>
                        <input type="file" id="image" name="image" accept="image/*" required
                            class="mt-2 px-5 py-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-300 hover:border-indigo-400 text-lg">
                    </div>
                </div>

            </div>

            <!-- Button Container -->
            <div class="flex justify-between gap-4 mt-8">
                <!-- Close Button -->
                <button type="button" id="closeModalButton"
                    class="w-full md:w-auto font-semibold bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition duration-300 focus:outline-none">
                    Cancel
                </button>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full md:w-auto bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-semibold py-2 px-6 rounded-lg hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 transform hover:scale-105">
                    Submit
                </button>
            </div>
        </form>

    </div>
</div><!-- Enhanced Table Section -->
<div class="admin-card rounded-2xl overflow-hidden">
    <div class="p-6 border-b bg-gradient-to-r from-gray-50 to-white">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-800">All Food Items</h3>
                <p class="text-gray-600 text-sm mt-1">Manage your menu items and pricing</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <i class="ri-search-line absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Search food items..." 
                           class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table id="foodTable" class="modern-table w-full">
            <thead>
                <tr>
                    <th class="text-left">S.N</th>
                    <th class="text-left">Food Item</th>
                    <th class="text-left">Category</th>
                    <th class="text-left">Type</th>
                    <th class="text-left">Price</th>
                    <th class="text-left">Status</th>
                    <th class="text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fooditems as $foodItem)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <span class="text-sm font-medium text-gray-900">{{ $loop->iteration }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mr-4 overflow-hidden">
                                @if($foodItem->image)
                                    <img src="{{ asset('fooditem/' . $foodItem->image) }}" alt="{{ $foodItem->name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <i class="ri-restaurant-line text-gray-400"></i>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $foodItem->name }}</p>
                                <p class="text-xs text-gray-500">{{ Str::limit($foodItem->description, 30) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ optional($foodItem->category)->name }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            {{ $foodItem->type }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-lg font-bold text-green-600">${{ number_format($foodItem->price, 2) }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <label for="status{{ $foodItem->id }}" class="inline-flex items-center cursor-pointer">
                            <input id="status{{ $foodItem->id }}" type="checkbox" class="hidden toggle-switch" 
                                   data-id="{{ $foodItem->id }}" {{ $foodItem->status ? 'checked' : '' }} />
                            <div class="relative w-12 h-6 bg-gray-200 rounded-full transition-colors duration-200 {{ $foodItem->status ? 'bg-blue-500' : '' }}">
                                <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform duration-200 {{ $foodItem->status ? 'transform translate-x-6' : '' }}"></div>
                            </div>
                            <span class="ml-2 text-sm {{ $foodItem->status ? 'text-green-600' : 'text-gray-500' }}">
                                {{ $foodItem->status ? 'Available' : 'Unavailable' }}
                            </span>
                        </label>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <!-- Edit Button -->
                            <a href="{{ route('admin.fooditem.edit', ['id' => $foodItem->id]) }}"
                               class="w-8 h-8 bg-blue-100 hover:bg-blue-200 rounded-lg flex items-center justify-center transition-colors group">
                                <i class="ri-edit-line text-blue-600 group-hover:text-blue-700"></i>
                            </a>
                            
                            <!-- Delete Button -->
                            <form action="{{ route('admin.fooditem.delete', ['id' => $foodItem->id]) }}" method="post"
                                  onsubmit="return confirm('Are you sure you want to delete this food item?');">
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


</div>

<script>
    // Enhanced functionality for food items
    function generateSlug() {
        let input1 = document.getElementById('name').value;
        let slug = input1.trim().replace(/\s+/g, '-').toLowerCase();
        document.getElementById('slug').value = slug;
    }

    // Image preview functionality
    function displayImagePreview(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('upload-placeholder').classList.add('hidden');
                document.getElementById('image-preview').classList.remove('hidden');
                document.getElementById('preview-img').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeImagePreview() {
        document.getElementById('upload-placeholder').classList.remove('hidden');
        document.getElementById('image-preview').classList.add('hidden');
        document.getElementById('image').value = '';
        document.getElementById('preview-img').src = '';
    }

    // Enhanced modal functionality
    function openModal() {
        const modal = document.getElementById('foodModal');
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
    }

    function closeModal() {
        const modal = document.getElementById('foodModal');
        modal.style.opacity = '0';
        modal.style.transform = 'scale(0.95)';
        setTimeout(() => {
            modal.classList.remove('modal-visible');
            modal.classList.add('modal-hidden');
            document.body.classList.remove('overflow-hidden');
            
            // Reset form
            modal.querySelector('form').reset();
            removeImagePreview();
        }, 300);
    }

    // Event listeners
    document.getElementById('openModalButton').addEventListener('click', openModal);
    document.getElementById('closeModalButton').addEventListener('click', closeModal);
    document.getElementById('closeModalButton2').addEventListener('click', closeModal);

    // Close modal when clicking outside
    document.getElementById('foodModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    // Enhanced toggle switches
    document.querySelectorAll('.toggle-switch').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const foodItemId = this.getAttribute('data-id');
            const newState = this.checked ? 1 : 0;
            const toggleContainer = this.nextElementSibling;
            const statusText = toggleContainer.nextElementSibling;
            
            // Update UI immediately
            if (this.checked) {
                toggleContainer.classList.add('bg-blue-500');
                toggleContainer.classList.remove('bg-gray-200');
                toggleContainer.querySelector('div').classList.add('transform', 'translate-x-6');
                statusText.textContent = 'Available';
                statusText.classList.add('text-green-600');
                statusText.classList.remove('text-gray-500');
            } else {
                toggleContainer.classList.remove('bg-blue-500');
                toggleContainer.classList.add('bg-gray-200');
                toggleContainer.querySelector('div').classList.remove('transform', 'translate-x-6');
                statusText.textContent = 'Unavailable';
                statusText.classList.remove('text-green-600');
                statusText.classList.add('text-gray-500');
            }

            // Send AJAX request
            fetch(`fooditem/update-toggle/${foodItemId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
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
        $('#foodTable').DataTable({
            responsive: true,
            pageLength: 10,
            order: [[0, 'asc']],
            columnDefs: [
                { orderable: false, targets: [6] } // Disable sorting on Actions column
            ],
            language: {
                search: "",
                searchPlaceholder: "Search food items...",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ items",
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
                    this.checked = !this.checked;
                    dot.style.transform = this.checked ? 'translateX(100%)' : 'translateX(0)';
                    dot.style.backgroundColor = this.checked ? 'green' : 'white';
                });
        });
    });

    // Function to generate slug from food name
    function generateSlug() {
        let input1 = document.getElementById('foodname').value;
        let slug = input1.trim().replace(/\s+/g, '-').toLowerCase();
        document.getElementById('slug').value = slug;
    }

    // Open the modal with animation
    document.getElementById('openModalButton').addEventListener('click', function() {
        const modal = document.getElementById('foodModal');
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
        const modal = document.getElementById('foodModal');
        modal.style.opacity = '0';
        modal.style.transform = 'scale(0.95)';
        setTimeout(() => {
            modal.classList.remove('modal-visible');
            modal.classList.add('modal-hidden');
            document.body.classList.remove('overflow-hidden');
        }, 300);
    }

    // Close modal event listener
    document.getElementById('closeModalButton').addEventListener('click', closeModal);

    // Close modal when clicking outside
    document.getElementById('foodModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>

<script>
    $(document).ready(function() {
        $('#foodTable').DataTable({
            "pageLength": 10,
            "lengthMenu": [10, 25, 50, 100],
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: true,
            initComplete: function() {
                $('.dataTables_length').addClass('flex items-center gap-2 mb-4');
                $('select').addClass('bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2 w-[4rem]');
            }
        });
    });
</script>

@endsection