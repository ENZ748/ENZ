@extends('layouts.app')

@section('content')

@php
    use App\Models\Category;
    use App\Models\Brand;
    use App\Models\Unit;
@endphp

<div class="container mt-4">

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h2>Items</h2>


    <!-- Search Bar with Equipment Status Dropdown -->
    <div class="search-container" style="display: flex; justify-content: flex-end;">
        <form method="GET" action="{{ route('items.search') }}" class="mb-4">
            <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" class="px-4 py-2 border rounded-md">
            
            <!-- Equipment Status Dropdown -->
            <select name="equipment_status" class="px-4 py-2 border rounded-md">
                <option value="3">All Status</option>
                <option value="0" {{ request('equipment_status') == '0' ? 'selected' : '' }}>Available</option>
                <option value="1" {{ request('equipment_status') == '1' ? 'selected' : '' }}>In Use</option>
                <option value="2" {{ request('equipment_status') == '2' ? 'selected' : '' }}>Out of Service</option>
            </select>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Search</button>
        </form>
    </div>

    <!-- View Toggle Buttons -->
    <div class="flex space-x-2 mb-4">
        <button onclick="setView('table')" class="bg-gray-300 px-4 py-2 rounded-md">Table View</button>
        <button onclick="setView('grid')" class="bg-gray-300 px-4 py-2 rounded-md">Grid View</button>
    </div>

    <!-- Add Item Button (Triggers Modal) -->
    <button class="btn btn-primary mb-4 px-4 py-2 bg-blue-500 text-white rounded-lg" data-toggle="modal" data-target="#addItemModal">Add Item</button>
    <a href="{{ route('categories.index') }}" class="btn btn-primary mb-4">View Categories</a>

 
    <!-- Table View -->
    <div id="table-view" class="card-body">
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Unit</th>
                    <th>Serial Number</th>
                    <th>Status</th>
                    <th>Assigned To</th>
                    <th>Date Purchased</th>
                    <th>Date Acquired</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item) <!-- Make sure $items is being passed correctly -->
                    @php
                        // Getting the related category, brand, and unit from the eager-loaded relationships
                        $category = $item->category ? $item->category->category_name : 'N/A';
                        $brand = $item->brand ? $item->brand->brand_name : 'N/A';
                        $unit = $item->unit ? $item->unit->unit_name : 'N/A';
                        $datePurchased = \Carbon\Carbon::parse($item->date_purchased);
                        $dateAcquired = \Carbon\Carbon::parse($item->date_acquired);
                        $assignedItem = $assigned_items->firstWhere('itemID', $item->id);
                        $user = ($item->equipment_status == 1 && $assignedItem) ? $assignedItem->employee->employee_number : 'None';
                    @endphp
                    <tr>
                        <td>{{ $category }}</td>
                        <td>{{ $brand }}</td>
                        <td>{{ $unit }}</td>
                        <td>{{ $item->serial_number }}</td>
                        <td>
                            {{ $item->equipment_status == 0 ? 'Available' : ($item->equipment_status == 1 ? 'In Use' : 'Out of Service') }}
                        </td>
                        <td>{{ $user }}</td>
                        <td>{{ $datePurchased->format('Y-m-d') }}</td>
                        <td>{{ $dateAcquired->format('Y-m-d') }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm edit-item-btn" data-toggle="modal" data-target="#editItemModal" data-id="{{ $item->id }}" data-category="{{ $item->categoryID }}" data-brand="{{ $item->brandID }}" data-unit="{{ $item->unitID }}" data-serial="{{ $item->serial_number }}" data-date-purchased="{{ $item->date_purchased }}" data-date-acquired="{{ $item->date_acquired }}">Edit</button>
                            <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">No Items Found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>



    </div>

    <!-- Grid View -->
    <div id="grid-view" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-4 hidden">
        @foreach($items as $item)
            @php
                $category = Category::find($item->categoryID);
                $brand = Brand::find($item->brandID);
                $unit = Unit::find($item->unitID);
                $datePurchased = \Carbon\Carbon::parse($item->date_purchased);
                $dateAcquired = \Carbon\Carbon::parse($item->date_acquired);
                $assignedItem = $assigned_items->firstWhere('itemID', $item->id);
                $user = ($item->equipment_status == 1 && $assignedItem) ? $assignedItem->employee->employee_number : 'None';
            @endphp

            <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200">
                <div class="text-center font-semibold text-lg text-gray-800 mb-2">{{ $category->category_name }}</div>
                <p class="text-gray-600 text-sm">Brand: <span class="text-blue-500">{{ $brand->brand_name }}</span></p>
                <p class="text-gray-600 text-sm">Unit: <span class="text-blue-500">{{ $unit->unit_name }}</span></p>
                <p class="text-gray-600 text-sm">Serial: <span class="text-blue-500">{{ $item->serial_number }}</span></p>
                <p class="text-gray-600 text-sm">Status: 
                    <span class="{{ $item->equipment_status == 0 ? 'text-green-500' : ($item->equipment_status == 1 ? 'text-yellow-500' : 'text-red-500') }}">
                        {{ $item->equipment_status == 0 ? 'Available' : ($item->equipment_status == 1 ? 'In Use' : 'Out of Service') }}
                    </span>
                </p>
                <p class="text-gray-600 text-sm">Assigned to: {{ $user }}</p>
                <p class="text-gray-600 text-sm">Purchased: {{ $datePurchased->format('Y-m-d') }}</p>
                <p class="text-gray-600 text-sm">Acquired: {{ $dateAcquired->format('Y-m-d') }}</p>

                <div class="flex space-x-2 mt-4">
                        <button class="btn btn-primary btn-sm edit-item-btn" data-toggle="modal" data-target="#editItemModal" data-id="{{ $item->id }}" data-category="{{ $item->categoryID }}" data-brand="{{ $item->brandID }}" data-unit="{{ $item->unitID }}" data-serial="{{ $item->serial_number }}" data-date-purchased="{{ $item->date_purchased }}" data-date-acquired="{{ $item->date_acquired }}">Edit</button>
                <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addItemModalLabel">Add New Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('items.store') }}" method="post" id="add-item-form">
                    @csrf

                    <label for="category">Category:</label>
                    <select id="category" name="category_id" class="form-control">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                        @endforeach
                    </select><br><br>

                    <div id="brand-container">
                        <label for="brand">Brand Name:</label>
                        <select id="brand" name="brand_id" class="form-control">
                            <option value="">Select Brand</option>
                        </select><br><br>
                    </div>

                    <div id="unit-container">
                        <label for="unit">Unit:</label>
                        <select id="unit" name="unit_id" class="form-control">
                            <option value="">Select Unit</option>
                        </select><br><br>
                    </div>

                    <label for="serial_number">Serial Number:</label>
                    <input type="text" id="serial_number" name="serial_number" value="{{ old('serial_number') }}" required class="form-control"><br><br>

                    <label for="date_purchased">Date Purchased:</label>
                    <input type="date" id="date_purchased" name="date_purchased" value="{{ old('date_purchased') }}" required class="form-control"><br><br>

                    <label for="date_acquired">Date Acquired:</label>
                    <input type="date" id="date_acquired" name="date_acquired" value="{{ old('date_acquired') }}" required class="form-control"><br><br>

                    <button type="submit" id="submit-btn" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Item Modal -->
<div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="editItemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editItemModalLabel">Edit Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="" method="POST" id="edit-item-form">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit-item-id">

                <!-- Category Field -->
                <label for="edit-category">Category:</label>
                <select id="edit-category" name="category_id" class="form-control">
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select><br><br>

                <!-- Brand Field -->
                <label for="edit-brand">Brand Name:</label>
                <select id="edit-brand" name="brand_id" class="form-control">
                    <option value="">Select Brand</option>
                </select><br><br>

                <!-- Unit Field -->
                <label for="edit-unit">Unit:</label>
                <select id="edit-unit" name="unit_id" class="form-control">
                    <option value="">Select Unit</option>
                </select><br><br>

                <!-- Serial Number Field -->
                <label for="edit-serial_number">Serial Number:</label>
                <input type="text" id="edit-serial_number" name="serial_number" required class="form-control"><br><br>

                <!-- Date Purchased Field -->
                <label for="edit-date_purchased">Date Purchased:</label>
                <input type="date" id="edit-date_purchased" name="date_purchased" required class="form-control"><br><br>

                <!-- Date Acquired Field -->
                <label for="edit-date_acquired">Date Acquired:</label>
                <input type="date" id="edit-date_acquired" name="date_acquired" required class="form-control"><br><br>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function setView(view) {
        document.getElementById('table-view').classList.toggle('hidden', view !== 'table');
        document.getElementById('grid-view').classList.toggle('hidden', view !== 'grid');
    }

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
                }
            });
        }
    });

    // Edit Item Modal Population
$('.edit-item-btn').click(function() {
    var itemId = $(this).data('id'); // Get item ID from the button's data-id attribute
    var categoryId = $(this).data('category'); // Get category ID from the button's data-category attribute
    var brandId = $(this).data('brand'); // Get brand ID from the button's data-brand attribute
    var unitId = $(this).data('unit'); // Get unit ID from the button's data-unit attribute
    var serialNumber = $(this).data('serial'); // Get serial number from the button's data-serial attribute
    var datePurchased = $(this).data('date-purchased'); // Get date purchased from the button's data-date-purchased attribute
    var dateAcquired = $(this).data('date-acquired'); // Get date acquired from the button's data-date-acquired attribute

    // Set the form action dynamically
    $('#edit-item-form').attr('action', '/items/update/' + itemId); // Update the form action URL with the item ID

    // Populate modal form fields
    $('#edit-category').val(categoryId); // Set the category dropdown
    $('#edit-brand').val(brandId);  // Set the selected brand
    $('#edit-unit').val(unitId);    // Set the selected unit
    $('#edit-serial_number').val(serialNumber); // Set serial number input
    $('#edit-date_purchased').val(datePurchased); // Set date purchased input
    $('#edit-date_acquired').val(dateAcquired); // Set date acquired input

    // Reset and clear brand, unit, and serial number dropdowns
    $('#edit-brand').empty().append('<option value="">Select Brand</option>');
    $('#edit-unit').empty().append('<option value="">Select Unit</option>');

    // Populate brands based on selected category
    $.ajax({
        url: '/get-brands/' + categoryId,
        type: 'GET',
        success: function(data) {
            var brandSelect = $('#edit-brand');
            brandSelect.empty().append('<option value="">Select Brand</option>');
            $.each(data, function(key, brand) {
                brandSelect.append('<option value="' + brand.id + '">' + brand.brand_name + '</option>');
            });

            // Set the selected brand in the dropdown
            $('#edit-brand').val(brandId);

            // Now, populate units based on the selected brand
            $.ajax({
                url: '/get-units/' + brandId,
                type: 'GET',
                success: function(data) {
                    var unitSelect = $('#edit-unit');
                    unitSelect.empty().append('<option value="">Select Unit</option>');
                    $.each(data, function(key, unit) {
                        unitSelect.append('<option value="' + unit.id + '">' + unit.unit_name + '</option>');
                    });

                    // Set the selected unit in the dropdown
                    $('#edit-unit').val(unitId);
                }
            });
        }
    });
});


    // Handle category change dynamically inside the modal
    $('#edit-category').change(function() {
        var selectedCategoryId = $(this).val();

        // Reset brand, unit, and serial number dropdowns
        $('#edit-brand').empty().append('<option value="">Select Brand</option>');
        $('#edit-unit').empty().append('<option value="">Select Unit</option>');
        $('#edit-serial_number').empty().append('<option value="">Select Serial</option>');  // Reset Serial Number dropdown

        // Fetch brands based on selected category
        $.ajax({
            url: '/get-brands/' + selectedCategoryId,
            type: 'GET',
            success: function(data) {
                var brandSelect = $('#edit-brand');
                brandSelect.empty().append('<option value="">Select Brand</option>');
                $.each(data, function(key, brand) {
                    brandSelect.append('<option value="' + brand.id + '">' + brand.brand_name + '</option>');
                });
            }
        });
    });

    // Handle brand change dynamically inside the modal
    $('#edit-brand').change(function() {
        var selectedBrandId = $(this).val();

        // Reset unit and serial number dropdowns
        $('#edit-unit').empty().append('<option value="">Select Unit</option>');
        $('#edit-serial_number').empty().append('<option value="">Select Serial</option>');  // Reset Serial Number dropdown

        // Fetch units based on selected brand
        $.ajax({
            url: '/get-units/' + selectedBrandId,
            type: 'GET',
            success: function(data) {
                var unitSelect = $('#edit-unit');
                unitSelect.empty().append('<option value="">Select Unit</option>');
                $.each(data, function(key, unit) {
                    unitSelect.append('<option value="' + unit.id + '">' + unit.unit_name + '</option>');
                });
            }
        });
    });



</script>

@endsection
