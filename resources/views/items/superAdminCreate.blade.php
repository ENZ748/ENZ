@extends('layouts.superAdminApp')

@section('content')
@php
    use App\Models\Brand;
    use App\Models\Unit;
@endphp
<div class="container">
    <h2>Add Item</h2>

    <!-- Display success message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('items.store') }}" method="post" id="add-item-form">
        @csrf
     
        <label for="category">Category:</label>
        <select id="category" name="category_id">
            <option value="">Select Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->category_name }}
                </option>
            @endforeach
        </select><br><br>   

        <div id="brand-container">
            <label for="brand">Brand Name:</label>
            <select id="brand" name="brand_id">
                <option value="">Select Brand</option>
            </select><br><br>
        </div>

        <div id="unit-container">
            <label for="unit">Unit:</label>
            <select id="unit" name="unit_id">
                <option value="">Select Unit</option>
            </select><br><br>
        </div>

        <label for="serial_number">Serial Number:</label>
        <input type="text" id="serial_number" name="serial_number" value="{{ old('serial_number') }}" required><br><br>

        <label for="date_purchased">Date Purchased:</label>
        <input type="date" id="date_purchased" name="date_purchased" value="{{ old('date_purchased') }}" required><br><br>

        <label for="date_acquired">Date Acquired:</label>
        <input type="date" id="date_acquired" name="date_acquired" value="{{ old('date_acquired') }}" required><br><br>

        <button type="submit" id="submit-btn">Submit</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

    // Load brands when a category is selected
    $('#category').change(function() {
        var categoryId = $(this).val();
        
        // Clear the brand and unit selections
        $('#brand').empty().append('<option value="">Select Brand</option>');
        $('#unit').empty().append('<option value="">Select Unit</option>');
        
        if (categoryId) {
            $.ajax({
                url: '/get-brands/' + categoryId, // Change URL as needed
                type: 'GET',
                success: function(data) {
                    $.each(data, function(key, brand) {
                        $('#brand').append('<option value="' + brand.id + '">' + brand.brand_name + '</option>');
                    });
                }
            });
        }
    });

    // Load units when a brand is selected
    $('#brand').change(function() {
        var brandId = $(this).val();
        
        // Clear the unit selection
        $('#unit').empty().append('<option value="">Select Unit</option>');
        
        if (brandId) {
            $.ajax({
                url: '/get-units/' + brandId, // Change URL as needed
                type: 'GET',
                success: function(data) {
                    $.each(data, function(key, unit) {
                        $('#unit').append('<option value="' + unit.id + '">' + unit.unit_name + '</option>');
                    });
                }
            });
        }
    });

    // Submit the form via AJAX
    $('#add-item-form').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission
        
        var formData = $(this).serialize(); // Get all the form data

        $.ajax({
            url: $(this).attr('action'), // Use the form's action attribute (POST route)
            method: 'POST',
            data: formData,
            success: function(response) {
                // Handle success response
                if(response.success) {
                    alert('Item added successfully!');
                    window.location.href = "{{ route('items') }}"; // Pass the URL as a string
                } else {
                    window.location.href = "{{ route('items') }}"; // Pass the URL as a string
                }
            },
            error: function(xhr) {
                console.log(xhr); // This will log the full response from the server
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    for (var field in errors) {
                        alert(errors[field].join(' ')); // Show the error messages for each field
                    }
                } else {
                    alert('An unknown error occurred. Please try again.');
                }
            }
        });
    });
});
</script>
@endsection
