@extends('layouts.superAdminApp')

@section('content')
@php
    use App\Models\Brand;
    use App\Models\Unit;
    use App\Models\Category;
@endphp


<div class="container">

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <h2>Edit Item</h2>

    <!-- Display success message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('items.update', $item->id) }}" method="post" id="edit-item-form">
        @csrf
        @method('PUT') <!-- Use PUT method for updating -->
        
        <!-- Category Dropdown -->
        <label for="category">Category:</label>
        <select id="category" name="category_id">
            <option value="">Select Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $item->categoryID) == $category->id ? 'selected' : '' }}>
                    {{ $category->category_name }}
                </option>
            @endforeach
        </select><br><br>   

        <!-- Brand Dropdown (Dynamically Loaded Based on Category Selection) -->
        <label for="brand">Brand Name:</label>
        <select id="brand" name="brand_id">
            <option value="">Select Brand</option>
            @foreach ($brands as $brand)
                <option value="{{ $brand->id }}" {{ old('brand_id', $item->brandID) == $brand->id ? 'selected' : '' }}>
                    {{ $brand->brand_name }}
                </option>
            @endforeach
        </select><br><br>

        <!-- Unit Dropdown (Dynamically Loaded Based on Brand Selection) -->
        <label for="unit">Unit:</label>
        <select id="unit" name="unit_id">
            <option value="">Select Unit</option>
            @foreach ($units as $unit)
                <option value="{{ $unit->id }}" {{ old('unit_id', $item->unitID) == $unit->id ? 'selected' : '' }}>
                    {{ $unit->unit_name }}
                </option>
            @endforeach
        </select><br><br>

            <!-- Serial Number Input -->
            <label for="serial_number">Serial Number:</label>
            <input type="text" id="serial_number" name="serial_number" value="{{ old('serial_number', $item->serial_number) }}" required><br><br>

            <!-- Date Purchased Input -->
            <label for="date_purchased">Date Purchased:</label>
            <input type="date" id="date_purchased" name="date_purchased" value="{{ old('date_purchased', $item->date_purchased) }}" required><br><br>

            <!-- Date Acquired Input -->
            <label for="date_acquired">Date Acquired:</label>
            <input type="date" id="date_acquired" name="date_acquired" value="{{ old('date_acquired', $item->date_acquired) }}" required><br><br>
    
        <button type="submit">Submit</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Load brands when a category is selected
    $('#category').change(function() {
        var categoryId = $(this).val();
        
        // Reset the brand and unit dropdowns when the category is changed
        $('#brand').empty().append('<option value="">Select Brand</option>');
        $('#unit').empty().append('<option value="">Select Unit</option>');

        if (categoryId) {
            $.ajax({
                url: '/get-brands/' + categoryId,
                type: 'GET',
                success: function(data) {
                    var brandSelect = $('#brand');
                    $.each(data, function(key, brand) {
                        brandSelect.append('<option value="' + brand.id + '">' + brand.brand_name + '</option>');
                    });
                }
            });
        }
    });

    // Load units when a brand is selected
    $('#brand').change(function() {
        var brandId = $(this).val();
        
        // Reset the unit dropdown when the brand is changed
        $('#unit').empty().append('<option value="">Select Unit</option>');

        if (brandId) {
            $.ajax({
                url: '/get-units/' + brandId,
                type: 'GET',
                success: function(data) {
                    var unitSelect = $('#unit');
                    $.each(data, function(key, unit) {
                        unitSelect.append('<option value="' + unit.id + '">' + unit.unit_name + '</option>');
                    });
                }
            });
        }
    });
});
</script>


@endsection
