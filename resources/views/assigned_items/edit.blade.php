@extends('layouts.app')

@section('content')

@php
    use App\Models\Brand;
    use App\Models\Unit;
@endphp

@if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <form action="{{ route('assigned_items.update',$assignedItem->id) }}" method="POST" id="assign-item-form">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="employeeID">Employee</label>
            <select name="employeeID" id="employeeID" class="form-control" required>
                <option value="">Select Employee</option>
                @foreach($employees as $employee)
                    < <option value="{{ $employee->id }}" 
                        {{ $employee->id == $assignedItem->employeeID ? 'selected' : '' }}
                        data-first-name="{{ $employee->first_name }}"
                        data-last-name="{{ $employee->last_name }}">
                        {{ $employee->employee_number }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Display employee's full name dynamically after selection -->
        <div class="form-group">
            <label for="employee_name">Employee Name</label>
            <input type="text" id="employee_name" class="form-control" value="{{ $assignedItem->employee->first_name }} {{ $assignedItem->employee->last_name }}" readonly>
        </div>

        <div class="form-group">
            <label for="category">Category:</label>
            <select id="category" name="category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $assignedItem->item->categoryID) == $category->id ? 'selected' : '' }}>
                    {{ $category->category_name }}
                </option>
                @endforeach
            </select><br><br>

            <div id="brand-container">
                <label for="brand">Brand Name:</label>
                <select id="brand" name="brand_id" class="form-control" required>
                    <option value="">Select Brand</option>
                    @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ old('brand_id', $assignedItem->item->brandID) == $brand->id ? 'selected' : '' }}>
                    {{ $brand->brand_name }}
                </option>
                    @endforeach
                </select><br><br>
            </div>

            <div id="unit-container">
                <label for="unit">Unit:</label>
                <select id="unit" name="unit_id" class="form-control" required>
                    <option value="">Select Unit</option>
                    @foreach($units as $unit) 
                    <option value="{{ $unit->id }}" {{ old('unit_id', $assignedItem->item->unitID) == $unit->id ? 'selected' : '' }}>
                    {{ $unit->unit_name }}
                    </option>
                    @endforeach
                </select><br><br>
            </div>

            <div id="serial-container">
                <label for="serial_number">Serial Number:</label>
                <select id="serial_number" name="serial_number" class="form-control" required>
                    <option value="">Select Serial</option>
                    @foreach($items as $item) 
                    <option value="{{ $item->id }}" {{ old('unit_id', $assignedItem->item->serial_number) == $item->serial_number ? 'selected' : '' }}>
                    {{ $item->serial_number }}
                    </option>
                    @endforeach
                </select><br><br>
            </div>


        </div>

        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea name="notes" id="notes" class="form-control">{{ $assignedItem->notes }}</textarea>
        </div>

        <div class="form-group">
            <label for="assigned_date">Assigned Date</label>
            <input type="date" name="assigned_date" id="assigned_date" class="form-control" value="{{ $assignedItem->assigned_date }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Assign Item</button>
    </form>

    <!-- JavaScript to show employee name after selection -->
    <script>
        document.getElementById('employeeID').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var firstName = selectedOption.getAttribute('data-first-name');
            var lastName = selectedOption.getAttribute('data-last-name');
            
            // Display the employee's full name
            document.getElementById('employee_name').value = firstName + ' ' + lastName;
        });

        $(document).ready(function() {

            // Load brands when a category is selected
            $('#category').change(function() {
                var categoryId = $(this).val();
                
                // Clear the brand, unit, and serial selections
                $('#brand').empty().append('<option value="">Select Brand</option>');
                $('#unit').empty().append('<option value="">Select Unit</option>');
                $('#serial_number').empty().append('<option value="">Select Serial</option>');

                if (categoryId) {
                    $.ajax({
                        url: '/get-brands/' + categoryId, // Change URL as needed
                        type: 'GET',
                        success: function(data) {
                            if (data.length > 0) {
                                $.each(data, function(key, brand) {
                                    $('#brand').append('<option value="' + brand.id + '">' + brand.brand_name + '</option>');
                                });
                            } else {
                                $('#brand').append('<option value="">No Brands Available</option>');
                            }
                        },
                        error: function() {
                            alert("Error loading brands.");
                        }
                    });
                }
            });

            // Load units when a brand is selected
            $('#brand').change(function() {
                var brandId = $(this).val();
                
                // Clear the unit and serial selections
                $('#unit').empty().append('<option value="">Select Unit</option>');
                $('#serial_number').empty().append('<option value="">Select Serial</option>');

                if (brandId) {
                    $.ajax({
                        url: '/get-units/' + brandId, // Make sure this URL is correct
                        type: 'GET',
                        success: function(data) {
                            if (data.length > 0) {
                                $.each(data, function(key, unit) {
                                    $('#unit').append('<option value="' + unit.id + '">' + unit.unit_name + '</option>');
                                });
                            } else {
                                $('#unit').append('<option value="">No Units Available</option>');
                            }
                        },
                        error: function(xhr) {
                            // Check the error message returned from the server
                            console.log(xhr);
                            alert("Error loading units.");
                        }
                    });
                }
            });


            // Load serial numbers when a unit is selected
            $('#unit').change(function() {
                var unitId = $(this).val();

                // Clear the serial number selection
                $('#serial_number').empty().append('<option value="">Select Serial</option>');

                if (unitId) {
                    $.ajax({
                        url: '/get-serials/' + unitId, // Change URL as needed
                        type: 'GET',
                        success: function(data) {
                            if (data.length > 0) {
                               // In your AJAX response when loading serial numbers:
                                $.each(data, function(key, serial) {
                                    $('#serial_number').append('<option value="' + serial.id + '">' + serial.serial_number + '</option>');
                                });
                            } else {
                                $('#serial_number').append('<option value="">No Serials Available</option>');
                            }
                        },
                        error: function() {
                            alert("Error loading serial numbers.");
                        }
                    });
                }
            });

        });


    </script>

@endsection
