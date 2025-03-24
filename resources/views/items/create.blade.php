@extends('layouts.app')

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

    <form action="{{ route('items.store') }}" method="post">
        @csrf
     
        <label for="category">Category:</label>
        <select id="category" name="category_id" onchange="this.form.submit()">
            <option value="">Select Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->category_name }}
                </option>
            @endforeach
        </select><br><br>

        @if (old('category_id'))
            @php
                $brands = Brand::where('categoryID', old('category_id'))->get();
            @endphp
            <label for="brand">Brand Name:</label>
            <select id="brand" name="brand_id" onchange="this.form.submit()">
                <option value="">Select Brand</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                        {{ $brand->brand_name }}
                    </option>
                @endforeach
            </select><br><br>

            @if (old('brand_id'))
                @php
                    $units = Unit::where('brandID', old('brand_id'))->get();
                @endphp
                <label for="unit">Unit:</label>
                <select id="unit" name="unit_id">
                    <option value="">Select Unit</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                            {{ $unit->unit_name }}
                        </option>
                    @endforeach
                </select><br><br>
            @endif
        @endif

        <label for="serial_number">Serial Number:</label>
        <input type="text" id="serial_number" name="serial_number" value="{{ old('serial_number') }}" required><br><br>

        <label for="equipment_status">Equipment Status:</label>
        <select id="equipment_status" name="equipment_status">
            <option value="0" {{ old('equipment_status') == '0' ? 'selected' : '' }}>Available</option>
            <option value="1" {{ old('equipment_status') == '1' ? 'selected' : '' }}>In Use</option>
            <option value="2" {{ old('equipment_status') == '2' ? 'selected' : '' }}>Out of Service</option>
        </select><br><br>

        <label for="date_purchased">Date Purchased:</label>
        <input type="date" id="date_purchased" name="date_purchased" value="{{ old('date_purchased') }}" required><br><br>

        <label for="date_acquired">Date Acquired:</label>
        <input type="date" id="date_acquired" name="date_acquired" value="{{ old('date_acquired') }}" required><br><br>

        <button type="submit">Submit</button>
    </form>
</div>
@endsection
