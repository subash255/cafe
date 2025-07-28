@extends('layouts.app', ['title' => 'Food Items Management', 'description' => 'Organize and manage your menu items'])
@section('content')

@include('components.admin-table-styles')

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
            <h1 class="text-3xl font-bold text-gray-800">Food Items Management</h1>
            <p class="text-gray-600 mt-2">Organize and manage your menu items</p>
        </div>
        <button id="openModalButton"
            class="modern-button bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 hover:from-blue-600 hover:to-blue-700 flex items-center space-x-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <i class="ri-add-line text-xl"></i>
            <span>Add New Food Item</span>
        </button>
    </div>
</div>

<!-- Search Section -->
<div class="search-container">
    <div class="relative">
        <i class="ri-search-line search-icon"></i>
        <input type="text" 
               id="searchInput" 
               placeholder="Search food items by name, category, or price..." 
               class="search-input">
    </div>
</div>


<!-- Enhanced Modal Structure -->
<div id="fooditemModal" class="fixed inset-0 modern-modal modal-hidden items-center justify-center z-50">
    <div class="modal-content p-6 w-full relative">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Add New Food Item</h2>
                <p class="text-gray-600 mt-1">Add a delicious new item to your menu</p>
            </div>
            <button id="closeModalButton" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="ri-close-line text-2xl"></i>
            </button>
        </div>
        
        <form action="{{ route('admin.fooditem.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-4">
                    
                    <div>
                        <label for="fooditem" class="block text-sm font-semibold text-gray-700 mb-2">Food Item Name</label>
                        <input type="text" id="fooditem" name="name" placeholder="Enter food item name"
                            class="modern-input w-full px-4 py-3 text-gray-800 placeholder-gray-500"
                            oninput="generateSlug()">
                    </div>

                    <!-- Slug Input -->
                    <div>
                        <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">Slug</label>
                        <input type="text" id="slug" name="slug" placeholder="Generated automatically"
                            class="modern-input w-full px-4 py-3 text-gray-800 placeholder-gray-500">
                    </div>

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

                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Price (Rs.)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">Rs. </span>
                            <input type="number" id="price" name="price" placeholder="0.00" step="0.01" min="0"
                                class="modern-input w-full pl-8 pr-4 py-3 text-gray-800 placeholder-gray-500" required>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                        <textarea id="description" name="description" rows="3" placeholder="Describe your delicious food item..."
                            class="modern-input w-full px-4 py-3 text-gray-800 placeholder-gray-500 resize-none"></textarea>
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">Food Type</label>
                        <select id="type" name="type" class="modern-input w-full px-4 py-3 text-gray-800">
                            <option value="">Select Type</option>
                            <option value="veg">Veg</option>
                            <option value="non-veg">Non-Veg</option>
                            <option value="drinks">Drinks</option>
                        </select>
                    </div>

                    <div>
                        <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">Food Image</label>
                        <div class="file-upload-area p-4 text-center" onclick="document.getElementById('image').click()">
                            <input type="file" id="image" name="image" accept="image/*" required class="hidden" onchange="displayImagePreview(this)">
                            <div id="upload-placeholder">
                                <i class="ri-image-add-line text-3xl text-gray-400 mb-2"></i>
                                <p class="text-gray-600 mb-1">Click to upload food image</p>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 5MB</p>
                                <button type="button"
                                    class="modern-button bg-blue-100 text-blue-600 px-3 py-2 mt-2 hover:bg-blue-200 text-sm">
                                    Choose Image
                                </button>
                            </div>
                            <div id="image-preview" class="hidden">
                                <img id="preview-img" src="" alt="Preview" class="w-24 h-24 object-cover rounded-lg mx-auto mb-2">
                                <button type="button" onclick="removeImagePreview()"
                                    class="modern-button bg-red-100 text-red-600 px-2 py-1 text-xs hover:bg-red-200">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t">
                <button type="button" id="closeModalButton2"
                    class="modern-button px-4 py-2 border-2 border-gray-300 text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                    class="modern-button bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-2 hover:from-blue-600 hover:to-blue-700 shadow-lg">
                    Add Food Item
                </button>
            </div>
        </form>
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
                        <th>Food Item</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="fooditemTableBody">
                    @forelse ($fooditems as $fooditem)
                    <tr class="fooditem-row">
                        <td data-label="S.N">
                            <span class="text-sm font-medium text-gray-900">{{ $loop->iteration }}</span>
                        </td>
                        <td data-label="Food Item">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-r from-orange-400 to-orange-600 rounded-lg flex items-center justify-center mr-4 overflow-hidden">
                                    @if($fooditem->image)
                                        <img src="{{ asset('fooditem/' . $fooditem->image) }}" alt="{{ $fooditem->name }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <i class="ri-restaurant-line text-white"></i>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 searchable-name">{{ $fooditem->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Str::limit($fooditem->description ?? 'No description', 30) }}</p>
                                </div>
                            </div>
                        </td>
                        
                        <td data-label="Category">
                            <div class="flex items-center">
                                
                                <span class="text-sm font-medium text-gray-900 searchable-category">{{ $fooditem->category->name ?? 'No Category' }}</span>
                            </div>
                        </td>
                        <td data-label="Type">
                            @if($fooditem->type === 'veg')
                                <span class="status-badge status-active">
                                    Veg
                                </span>
                            @elseif($fooditem->type === 'non-veg')
                                <span class="status-badge status-pending">
                                    Non-Veg
                                </span>
                            @elseif($fooditem->type === 'drinks')
                                <span class="status-badge status-inactive">
                                    Drinks
                                </span>
                            @else
                                <span class="status-badge status-default">
                                    Unknown
                                </span>

                            @endif
                        </td>
                        <td data-label="Price">
                            <div class="flex items-center">
                                <span class="text-lg font-bold text-green-600 searchable-price">Rs.{{ number_format($fooditem->price) }}</span>
                            </div>
                        </td>
                        <td data-label="Status">
                            <label for="status{{ $fooditem->id }}" class="inline-flex items-center cursor-pointer">
                                <input id="status{{ $fooditem->id }}" type="checkbox" class="hidden toggle-switch" 
                                       data-id="{{ $fooditem->id }}" {{ $fooditem->status ? 'checked' : '' }} />
                                <div class="relative w-12 h-6 bg-gray-200 rounded-full transition-colors duration-200 {{ $fooditem->status ? 'bg-gradient-to-r from-green-400 to-green-500' : '' }}">
                                    <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform duration-200 shadow-sm {{ $fooditem->status ? 'transform translate-x-6' : '' }}"></div>
                                </div>
                                <span class="ml-2 text-sm font-medium {{ $fooditem->status ? 'text-green-600' : 'text-gray-500' }}">
                                    {{ $fooditem->status ? 'Popular' : 'Regular' }}
                                </span>
                            </label>
                        </td>
                        <td data-label="Actions">
                            <div class="flex items-center space-x-2">
                                <!-- Edit Button -->
                                <a href="{{ route('admin.fooditem.edit', ['id' => $fooditem->id]) }}"
                                   class="action-button btn-edit">
                                    <i class="ri-edit-line"></i>
                                </a>
                                
                                <!-- Delete Button -->
                                <form action="{{ route('admin.fooditem.delete', ['id' => $fooditem->id]) }}" method="post"
                                      onsubmit="return confirm('Are you sure you want to delete this food item?');" class="inline">
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
                        <td colspan="8" class="no-data">
                            <i class="ri-restaurant-line"></i>
                            <p class="text-lg font-medium">No food items found</p>
                            <p class="text-sm">Start by adding your first delicious menu item</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('.fooditem-row');
        
        rows.forEach(row => {
            const name = row.querySelector('.searchable-name')?.textContent.toLowerCase() || '';
            const category = row.querySelector('.searchable-category')?.textContent.toLowerCase() || '';
            const price = row.querySelector('.searchable-price')?.textContent.toLowerCase() || '';
            
            const isVisible = name.includes(searchTerm) || 
                            category.includes(searchTerm) || 
                            price.includes(searchTerm);
            
            row.style.display = isVisible ? '' : 'none';
        });
    });

    // Image preview functionality
    function displayImagePreview(input) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('upload-placeholder').classList.add('hidden');
                document.getElementById('image-preview').classList.remove('hidden');
                document.getElementById('preview-img').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    function removeImagePreview() {
        document.getElementById('upload-placeholder').classList.remove('hidden');
        document.getElementById('image-preview').classList.add('hidden');
        document.getElementById('image').value = '';
        document.getElementById('preview-img').src = '';
    }

    // Enhanced Modal functionality
    function generateSlug() {
        let input1 = document.getElementById('fooditem').value;
        let slug = input1.trim().replace(/\s+/g, '-').toLowerCase();
        document.getElementById('slug').value = slug;
    }

    // Open modal with animation
    document.getElementById('openModalButton').addEventListener('click', function() {
        const modal = document.getElementById('fooditemModal');
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
        const modal = document.getElementById('fooditemModal');
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
    document.getElementById('fooditemModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    // Enhanced toggle switches with AJAX functionality
    document.querySelectorAll('.toggle-switch').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const fooditemId = this.getAttribute('data-id');
            const newState = this.checked ? 1 : 0;
            const toggleContainer = this.nextElementSibling;
            const statusText = toggleContainer.nextElementSibling;
            
            // Update UI immediately
            if (this.checked) {
                toggleContainer.classList.add('bg-gradient-to-r', 'from-green-400', 'to-green-500');
                toggleContainer.classList.remove('bg-gray-200');
                toggleContainer.querySelector('div').classList.add('transform', 'translate-x-6');
                statusText.textContent = 'Popular';
                statusText.classList.add('text-green-600');
                statusText.classList.remove('text-gray-500');
            } else {
                toggleContainer.classList.remove('bg-gradient-to-r', 'from-green-400', 'to-green-500');
                toggleContainer.classList.add('bg-gray-200');
                toggleContainer.querySelector('div').classList.remove('transform', 'translate-x-6');
                statusText.textContent = 'Regular';
                statusText.classList.remove('text-green-600');
                statusText.classList.add('text-gray-500');
            }

            // Send AJAX request to update status
            fetch(`/admin/fooditem/update-toggle/${fooditemId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ state: newState })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(
                        `Food item ${newState ? 'marked as popular' : 'removed from popular items'}!`,
                        'success'
                    );
                } else {
                    // Revert UI changes if server request failed
                    this.checked = !this.checked;
                    showNotification('Failed to update status', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Revert UI changes if request failed
                this.checked = !this.checked;
                showNotification('Failed to update status', 'error');
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
</script>

@endsection