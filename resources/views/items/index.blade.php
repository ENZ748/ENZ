@extends('layouts.app')

@section('content')

@php
    use App\Models\Category;
    use App\Models\Brand;
    use App\Models\Unit;
@endphp

<div class="container mx-auto px-10 py-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">Inventory Management</h2>
        
        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-3">
            <button class="btn btn-primary px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md transition duration-300 flex items-center"
                    data-toggle="modal" data-target="#addItemModal">
                <i class="fas fa-plus-circle mr-2"></i> Add Item
            </button>
            <a href="{{ route('categories.index') }}" 
               class="px-5 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg shadow-md transition duration-300 flex items-center no-underline">
                <i class="fas fa-tags mr-2"></i> View Categories
            </a>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white p-6 rounded-xl shadow-md mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
            <!-- View Toggle -->
            <div class="flex space-x-2">
                <button onclick="setView('table')" id="table-view-btn" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-table mr-2"></i>Table View
                </button>
                <button onclick="setView('grid')" id="grid-view-btn" 
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md shadow hover:bg-gray-300 transition duration-200">
                    <i class="fas fa-th-large mr-2"></i>Grid View
                </button>
            </div>
            
            <!-- Search Form -->
            <form method="GET" action="{{ route('items.search') }}" class="w-full md:w-auto">
                <div class="flex flex-col sm:flex-row gap-2">
                    <input type="text" name="search" placeholder="Search items..." 
                           value="{{ request('search') }}"
                           class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    
                    <select name="equipment_status" 
                            class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="3">All Status</option>
                        <option value="0" {{ request('equipment_status') == '0' ? 'selected' : '' }}>Available</option>
                        <option value="1" {{ request('equipment_status') == '1' ? 'selected' : '' }}>In Use</option>
                        <option value="2" {{ request('equipment_status') == '2' ? 'selected' : '' }}>Out of Service</option>
                    </select>

                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 transition duration-200">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table View -->
    <div id="table-view" class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial Number</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned To</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Purchased</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Acquired</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($items as $item)
                        @php
                            $category = $item->category ? $item->category->category_name : 'N/A';
                            $brand = $item->brand ? $item->brand->brand_name : 'N/A';
                            $unit = $item->unit ? $item->unit->unit_name : 'N/A';
                            $datePurchased = \Carbon\Carbon::parse($item->date_purchased);
                            $dateAcquired = \Carbon\Carbon::parse($item->date_acquired);
                            $assignedItem = $assigned_items->firstWhere('itemID', $item->id);
                            $user = ($item->equipment_status == 1 && $assignedItem) ? $assignedItem->employee->employee_number : 'None';
                            
                            // Status colors
                            $statusColor = [
                                0 => 'bg-green-100 text-green-800',
                                1 => 'bg-yellow-100 text-yellow-800',
                                2 => 'bg-red-100 text-red-800'
                            ][$item->equipment_status];
                        @endphp
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $category }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $brand }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $unit }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">{{ $item->serial_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">
                                    {{ $item->equipment_status == 0 ? 'Available' : ($item->equipment_status == 1 ? 'In Use' : 'Out of Service') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $datePurchased->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $dateAcquired->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button class="edit-item-btn text-blue-600 hover:text-blue-900 transition duration-200"
                                            data-toggle="modal" data-target="#editItemModal" 
                                            data-id="{{ $item->id }}" 
                                            data-category="{{ $item->categoryID }}" 
                                            data-brand="{{ $item->brandID }}" 
                                            data-unit="{{ $item->unitID }}" 
                                            data-serial="{{ $item->serial_number }}" 
                                            data-quantity="{{ $item->quantity }}" 
                                            data-date-purchased="{{ $item->date_purchased }}" 
                                            data-date-acquired="{{ $item->date_acquired }}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    @if($item->equipment_status == 2)
                                        <button class="repair-item-btn text-green-600 hover:text-green-900 transition duration-200"
                                                data-toggle="modal" data-target="#repairItemModal" 
                                                data-id="{{ $item->id }}">
                                            <i class="fas fa-tools"></i>
                                        </button>
                                    @endif

                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="delete-item-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="text-red-600 hover:text-red-900 transition duration-200 delete-item-btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500">No items found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Grid View -->
    <div id="grid-view" class="hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
        @foreach($items as $item)
            @php
                $category = Category::find($item->categoryID);
                $brand = Brand::find($item->brandID);
                $unit = Unit::find($item->unitID);
                $datePurchased = \Carbon\Carbon::parse($item->date_purchased);
                $dateAcquired = \Carbon\Carbon::parse($item->date_acquired);
                $assignedItem = $assigned_items->firstWhere('itemID', $item->id);
                $user = ($item->equipment_status == 1 && $assignedItem) ? $assignedItem->employee->employee_number : 'None';
                
                // Status colors and icons
                $statusConfig = [
                    0 => ['color' => 'bg-green-100 text-green-800', 'icon' => 'fa-check-circle'],
                    1 => ['color' => 'bg-yellow-100 text-yellow-800', 'icon' => 'fa-user-clock'],
                    2 => ['color' => 'bg-red-100 text-red-800', 'icon' => 'fa-times-circle']
                ][$item->equipment_status];
            @endphp

            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 truncate">{{ $category->category_name }}</h3>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusConfig['color'] }}">
                            <i class="fas {{ $statusConfig['icon'] }} mr-1"></i>
                            {{ $item->equipment_status == 0 ? 'Available' : ($item->equipment_status == 1 ? 'In Use' : 'Out of Service') }}
                        </span>
                    </div>
                    
                    <div class="space-y-2 text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-tag text-gray-400 mr-2 w-4"></i>
                            <span class="font-medium">Brand:</span>
                            <span class="ml-1">{{ $brand->brand_name }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-ruler-combined text-gray-400 mr-2 w-4"></i>
                            <span class="font-medium">Unit:</span>
                            <span class="ml-1">{{ $unit->unit_name }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-barcode text-gray-400 mr-2 w-4"></i>
                            <span class="font-medium">Serial:</span>
                            <span class="ml-1 font-mono">{{ $item->serial_number }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-box-open text-gray-400 mr-2 w-4"></i>
                            <span class="font-medium">Quantity:</span>
                            <span class="ml-1 font-mono">{{ $item->quantity }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-user text-gray-400 mr-2 w-4"></i>
                            <span class="font-medium">Assigned:</span>
                            <span class="ml-1">{{ $user }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-calendar-day text-gray-400 mr-2 w-4"></i>
                            <span class="font-medium">Purchased:</span>
                            <span class="ml-1">{{ $datePurchased->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-calendar-check text-gray-400 mr-2 w-4"></i>
                            <span class="font-medium">Acquired:</span>
                            <span class="ml-1">{{ $dateAcquired->format('M d, Y') }}</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-2 mt-4 pt-4 border-t border-gray-100">
                        <button class="edit-item-btn text-blue-600 hover:text-blue-800 transition duration-200"
                                data-toggle="modal" data-target="#editItemModal" 
                                data-id="{{ $item->id }}" 
                                data-category="{{ $item->categoryID }}" 
                                data-brand="{{ $item->brandID }}" 
                                data-unit="{{ $item->unitID }}" 
                                data-serial="{{ $item->serial_number }}" 
                                data-quantity="{{ $item->quantity }}"
                                data-date-purchased="{{ $item->date_purchased }}" 
                                data-date-acquired="{{ $item->date_acquired }}">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </button>

                        @if($item->equipment_status == 2)
                            <button class="repair-item-btn text-green-600 hover:text-green-800 transition duration-200"
                                    data-toggle="modal" data-target="#repairItemModal" 
                                    data-id="{{ $item->id }}">
                                <i class="fas fa-tools mr-1"></i> Repair
                            </button>
                        @endif

                        <form class="delete-item-form" action="{{ route('items.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="text-red-600 hover:text-red-800 transition duration-200 delete-item-btn">
                                <i class="fas fa-trash-alt mr-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($items instanceof \Illuminate\Pagination\AbstractPaginator && $items->hasPages())
    <div class="bg-white px-6 py-3 rounded-xl shadow-md">
        {{ $items->links() }}
    </div>
    @endif
</div>

<!-- Add Item Modal -->
    <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-blue-600 text-white">
                    <h5 class="modal-title text-xl font-semibold" id="addItemModalLabel">Add New Inventory Item</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-6">
                    <form action="{{ route('items.store') }}" method="post" id="add-item-form">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Category Field -->
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <select id="category" name="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Brand Field -->
                            <div id="brand-container">
                                <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                                <select id="brand" name="brand_id" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Brand</option>
                                </select>
                            </div>

                            <!-- Unit Field -->
                            <div id="unit-container">
                                <label for="unit" class="block text-sm font-medium text-gray-700 mb-1">Unit</label>
                                <select id="unit" name="unit_id" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Unit</option>
                                </select>
                            </div>

                            <!-- Serial Number Field -->
                            <div>
                                <label for="serial_number" class="block text-sm font-medium text-gray-700 mb-1">Serial Number</label>
                                <input type="text" id="serial_number" name="serial_number" value="{{ old('serial_number') }}" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            </div>  

                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                    required min="1">
                            </div>


                            <!-- Date Purchased Field -->
                            <div>
                                <label for="date_purchased" class="block text-sm font-medium text-gray-700 mb-1">Date Purchased</label>
                                <input type="date" id="date_purchased" name="date_purchased" value="{{ old('date_purchased') }}" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            </div>

                            <!-- Date Acquired Field -->
                            <div>
                                <label for="date_acquired" class="block text-sm font-medium text-gray-700 mb-1">Date Acquired</label>
                                <input type="date" id="date_acquired" name="date_acquired" value="{{ old('date_acquired') }}" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 transition duration-200">Add Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Edit Item Modal -->
    <div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="editItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-blue-600 text-white">
                    <h5 class="modal-title text-xl font-semibold" id="editItemModalLabel">Edit Inventory Item</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-6">
                    <form action="" method="POST" id="edit-item-form">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="edit-item-id">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Category Field -->
                            <div>
                                <label for="edit-category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <select id="edit-category" name="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Brand Field -->
                            <div>
                                <label for="edit-brand" class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                                <select id="edit-brand" name="brand_id" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Brand</option>
                                </select>
                            </div>

                            <!-- Unit Field -->
                            <div>
                                <label for="edit-unit" class="block text-sm font-medium text-gray-700 mb-1">Unit</label>
                                <select id="edit-unit" name="unit_id" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Unit</option>
                                </select>
                            </div>

                            <!-- Serial Number Field -->
                            <div>
                                <label for="edit-serial_number" class="block text-sm font-medium text-gray-700 mb-1">Serial Number</label>
                                <input type="text" id="edit-serial_number" name="serial_number" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            </div>

                            <!-- Quantity Field -->
                            <div>
                                <label for="edit-quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                <input type="number" id="edit-quantity" name="quantity" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            </div>

                            <!-- Date Purchased Field -->
                            <div>
                                <label for="edit-date_purchased" class="block text-sm font-medium text-gray-700 mb-1">Date Purchased</label>
                                <input type="date" id="edit-date_purchased" name="date_purchased" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            </div>

                            <!-- Date Acquired Field -->
                            <div>
                                <label for="edit-date_acquired" class="block text-sm font-medium text-gray-700 mb-1">Date Acquired</label>
                                <input type="date" id="edit-date_acquired" name="date_acquired" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 transition duration-200">Update Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Repair Item Modal (Shared by both views) -->
    <div class="modal fade" id="repairItemModal" tabindex="-1" role="dialog" aria-labelledby="repairItemModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-green-600 text-white">
                    <h5 class="modal-title" id="repairItemModalLabel">Repair Item</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to mark this item as repaired and return it to available inventory?</p>
                    <form id="repair-item-form" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="equipment_status" value="0">
                    
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 transition duration-200" data-dismiss="modal">Cancel</button>
                    <button type="submit" form="repair-item-form" class="px-4 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-700 transition duration-200">
                        <i class="fas fa-check-circle mr-1"></i> Confirm Repair
                    </button>
                </div>
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle repair button clicks for both table and grid views
        document.querySelectorAll('.repair-item-btn').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                const form = document.getElementById('repair-item-form');
                form.action = `/items/${itemId}/repair`;
            });
        });

        // Initialize Bootstrap tooltips if needed
        if (typeof $ !== 'undefined') {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
</script>

<script>
    // View Toggle Functionality
    function setView(viewType) {
        if (viewType === 'table') {
            document.getElementById('table-view').classList.remove('hidden');
            document.getElementById('grid-view').classList.add('hidden');
            document.getElementById('table-view-btn').classList.replace('bg-gray-200', 'bg-blue-600');
            document.getElementById('table-view-btn').classList.replace('text-gray-700', 'text-white');
            document.getElementById('grid-view-btn').classList.replace('bg-blue-600', 'bg-gray-200');
            document.getElementById('grid-view-btn').classList.replace('text-white', 'text-gray-700');
        } else {
            document.getElementById('table-view').classList.add('hidden');
            document.getElementById('grid-view').classList.remove('hidden');
            document.getElementById('table-view-btn').classList.replace('bg-blue-600', 'bg-gray-200');
            document.getElementById('table-view-btn').classList.replace('text-white', 'text-gray-700');
            document.getElementById('grid-view-btn').classList.replace('bg-gray-200', 'bg-blue-600');
            document.getElementById('grid-view-btn').classList.replace('text-gray-700', 'text-white');
        }
    }

    // Initialize with table view
    document.addEventListener('DOMContentLoaded', function() {
        setView('table');
        
        // Show success message if exists
            // Show success message if session has success
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6',
            timer: 3000,
            timerProgressBar: true
        });
    @endif
        
        // Show error message if exists
        @if($errors->any())
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Validation Error',
                html: `@foreach ($errors->all() as $error)<p class="text-sm">{{ $error }}</p>@endforeach`,
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                toast: true,
                background: '#fef2f2',
                iconColor: '#ef4444',
                color: '#991b1b'
            });
        @endif
    });

    // Form submission handlers
    function handleFormSubmission(form, successMessage) {
    const formData = new FormData(form);
    const url = form.getAttribute('action');
    const method = form.getAttribute('method');
    
    // Show loading state
    Swal.fire({
        title: 'Processing...',
        html: `
            <div class="text-center py-3">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Please wait while we process your request.</p>
            </div>
        `,
        showConfirmButton: false,
        allowOutsideClick: false
    });

    fetch(url, {
        method: method,
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(errData => {
                // Create custom error with status and data
                const error = new Error('Request failed');
                error.response = {
                    status: response.status,
                    data: errData
                };
                throw error;
            });
        }
        return response.json();
    })
    .then(data => {
        Swal.close();
        if (data.success) {
            // Success case
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: successMessage,
                confirmButtonColor: '#3085d6',
                timer: 3000,
                timerProgressBar: true
            }).then(() => {
                window.location.reload();
            });
        } else {
            // Handle non-success responses
            showSerialNumberError(data);
        }
    })
    .catch(error => {
        Swal.close();
        if (error.response && error.response.status === 422) {
            // Specifically handle validation errors
            showSerialNumberError(error.response.data);
        } else {
            // Generic error handling
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'An error occurred. Please try again.',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                toast: true
            });
        }
    });
}

// Specialized function to display serial number error
function showSerialNumberError(responseData) {
    let errorMessage = responseData.message || 'Validation failed';
    
    // Check if this is a serial number error
    if (responseData.errors && responseData.errors.serial_number) {
        errorMessage = responseData.errors.serial_number[0]; // "Serial Number already exists"
    }
    
    Swal.fire({
        position: 'top-end',
        icon: 'error',
        title: errorMessage,
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        toast: true,
        background: '#fef2f2',
        iconColor: '#ef4444'
    });
}

    // Add item form submission
    document.getElementById('add-item-form').addEventListener('submit', function(e) {
        e.preventDefault();
        handleFormSubmission(this, 'Item added successfully!');
    });

    // Edit item form submission
    document.getElementById('edit-item-form').addEventListener('submit', function(e) {
        e.preventDefault();
        handleFormSubmission(this, 'Item updated successfully!');
    });

    // Delete Item Confirmation - Updated Version
    $(document).on('click', '.delete-item-btn', function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                Swal.fire({
                    title: 'Deleting...',
                    html: `
                        <div class="text-center py-3">
                            <div class="spinner-border text-danger" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Please wait while we delete the item.</p>
                        </div>
                    `,
                    showConfirmButton: false,
                    allowOutsideClick: false
                });

                // Submit the form via AJAX
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        Swal.close();
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Item deleted successfully!',
                                confirmButtonColor: '#3085d6',
                                timer: 3000,
                                timerProgressBar: true
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: response.message || 'Failed to delete item',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                toast: true
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.close();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'An error occurred while deleting the item',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                            toast: true
                        });
                    }
                });
            }
        });
    });

    // Handle category change to populate brands in the Add modal
    $('#category').change(function() {
        var categoryId = $(this).val();
        $('#brand').empty().append('<option value="">Select Brand</option>');
        $('#unit').empty().append('<option value="">Select Unit</option>');

        if (categoryId) {
            $.ajax({
                url: '/get-brands/' + categoryId,
                type: 'GET',
                success: function(data) {
                    $.each(data, function(key, brand) {
                        $('#brand').append('<option value="' + brand.id + '">' + brand.brand_name + '</option>');
                    });
                },
                error: function() {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Failed to load brands',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        toast: true,
                        background: '#fef2f2',
                        iconColor: '#ef4444',
                        color: '#991b1b'
                    });
                }
            });
        }
    });

    // Handle brand change to populate units in the Add modal
    $('#brand').change(function() {
        var brandId = $(this).val();
        $('#unit').empty().append('<option value="">Select Unit</option>');

        if (brandId) {
            $.ajax({
                url: '/get-units/' + brandId,
                type: 'GET',
                success: function(data) {
                    $.each(data, function(key, unit) {
                        $('#unit').append('<option value="' + unit.id + '">' + unit.unit_name + '</option>');
                    });
                },
                error: function() {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Failed to load units',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        toast: true,
                        background: '#fef2f2',
                        iconColor: '#ef4444',
                        color: '#991b1b'
                    });
                }
            });
        }
    });

    // Edit Item Modal Population - Updated Version
    $(document).on('click', '.edit-item-btn', function() {
    var itemId = $(this).data('id');
    var categoryId = $(this).data('category');
    var brandId = $(this).data('brand');
    var unitId = $(this).data('unit');
    var serialNumber = $(this).data('serial');
    var quantity = $(this).data('quantity');
    var datePurchased = $(this).data('date-purchased');
    var dateAcquired = $(this).data('date-acquired');

    // Set form action with correct route
    $('#edit-item-form').attr('action', '/items/' + itemId);
    $('#edit-item-id').val(itemId);
    $('#edit-category').val(categoryId);
    $('#edit-serial_number').val(serialNumber);
    $('#edit-quantity').val(quantity);

    // Format dates properly for the date inputs
    $('#edit-date_purchased').val(formatDateForInput(datePurchased));
    $('#edit-date_acquired').val(formatDateForInput(dateAcquired));

    // Initialize brand and unit selects
    $('#edit-brand').empty().append('<option value="">Select Brand</option>');
    $('#edit-unit').empty().append('<option value="">Select Unit</option>');

    if (categoryId) {
        $.ajax({
            url: '/get-brands/' + categoryId,
            type: 'GET',
            success: function(data) {
                $.each(data, function(key, brand) {
                    $('#edit-brand').append('<option value="' + brand.id + '">' + brand.brand_name + '</option>');
                });
                // Set the selected brand after populating
                $('#edit-brand').val(brandId).trigger('change');
                
                // Now populate units based on selected brand
                if (brandId) {
                    $.ajax({
                        url: '/get-units/' + brandId,
                        type: 'GET',
                        success: function(data) {
                            $.each(data, function(key, unit) {
                                $('#edit-unit').append('<option value="' + unit.id + '">' + unit.unit_name + '</option>');
                            });
                            // Set the selected unit after populating
                            $('#edit-unit').val(unitId);
                        }
                    });
                }
            }
        });
    }
    
        // Show the modal
         $('#editItemModal').modal('show');
    });

    // Helper function to format date for input field
    function formatDateForInput(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        return date.toISOString().split('T')[0];
    }

    // Handle category change in edit modal
    $('#edit-category').change(function() {
        var categoryId = $(this).val();
        $('#edit-brand').empty().append('<option value="">Select Brand</option>');
        $('#edit-unit').empty().append('<option value="">Select Unit</option>');

        if (categoryId) {
            $.ajax({
                url: '/get-brands/' + categoryId,
                type: 'GET',
                success: function(data) {
                    $.each(data, function(key, brand) {
                        $('#edit-brand').append('<option value="' + brand.id + '">' + brand.brand_name + '</option>');
                    });
                }
            });
        }
    });

    // Handle brand change in edit modal
    $('#edit-brand').change(function() {
        var brandId = $(this).val();
        $('#edit-unit').empty().append('<option value="">Select Unit</option>');

        if (brandId) {
            $.ajax({
                url: '/get-units/' + brandId,
                type: 'GET',
                success: function(data) {
                    $.each(data, function(key, unit) {
                        $('#edit-unit').append('<option value="' + unit.id + '">' + unit.unit_name + '</option>');
                    });
                }
            });
        }
    });
</script>

@endsection