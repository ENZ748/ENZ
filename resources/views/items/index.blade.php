@extends('layouts.app')

@section('content')

@php
    use App\Models\Category;
    use App\Models\Brand;
    use App\Models\Unit;
@endphp

<h1 class="text-2xl font-semibold mb-4">Items</h1>

<!-- Category Filter Dropdown -->
<form method="GET" action="{{ route('items.index') }}" class="mb-4">
    <select name="category_id" id="category_id" class="px-4 py-2 border rounded-md">
        <option value="">All Categories</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" 
                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->category_name }}
            </option>
        @endforeach
    </select>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Filter</button>
</form>

<!-- Add Item Button -->
<<<<<<< ErickMarch31Merge
<a href="{{ route('items.create') }}" class="btn btn-success">Add Item</a>
<a href="{{ route('categories.index') }}" class="btn btn-success">View Categories</a>

<!-- Table for Displaying Items -->
<div class="table-responsive">
    <table class="table table-hover text-center">
        <thead>
            <tr class="text-center">
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
            @foreach($items as $item)
                @php
                    $category = Category::where('id', $item->categoryID)->first();
                    $brand = Brand::where('id', $item->brandID)->first();
                    $unit = Unit::where('id', $item->unitID)->first();
                    $datePurchased = \Carbon\Carbon::parse($item->date_purchased);
                    $dateAcquired = \Carbon\Carbon::parse($item->date_acquired);
                    $assignedItem = $assigned_items->firstWhere('itemID', $item->id);
                    $user = ($item->equipment_status == 1 && $assignedItem) ? $assignedItem->employee->employee_number : 'None';
                @endphp
                <tr>
                <td>{{ $category->category_name }}</td>
                <td>{{ $brand->brand_name }}</td>
                <td>{{ $unit->unit_name }}</td>
                <td>{{ $item->serial_number }}</td>
                <td>
=======
<a href="{{ route('items.create') }}" class="btn btn-primary mb-4 px-4 py-2 bg-blue-500 text-white rounded-lg">Add Item</a>
<a href="{{ route('categories.index') }}" class="btn btn-primary mb-4">View Categories</a>

<!-- Card Grid for Displaying Items -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-4">
    @foreach($items as $item)
        @php
            $category = Category::where('id', $item->categoryID)->first();
            $brand = Brand::where('id', $item->brandID)->first();
            $unit = Unit::where('id', $item->unitID)->first();

            $datePurchased = \Carbon\Carbon::parse($item->date_purchased);
            $dateAcquired = \Carbon\Carbon::parse($item->date_acquired);
        @endphp
    
        <!-- Item Card -->
        <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200">
            <div class="text-center font-semibold text-lg text-gray-800 mb-2">{{ $category->category_name }}</div>

            <div class="text-sm mb-2">
                <span class="text-gray-600">Brand:</span>
                <span class="text-blue-500">{{ $brand->brand_name }}</span>
            </div>

            <div class="text-sm mb-2">
                <span class="text-gray-600">Unit:</span>
                <span class="text-blue-500">{{ $unit->unit_name }}</span>
            </div>

            <div class="text-sm mb-2">
                <span class="text-gray-600">Serial Number:</span>
                <span class="text-blue-500">{{ $item->serial_number }}</span>
            </div>

            <div class="text-sm mb-2">
                <span class="text-gray-600">Status:</span>
                <span class="text-green-500">
>>>>>>> march31
                    {{ $item->equipment_status == 0 ? 'Available' : ($item->equipment_status == 1 ? 'In Use' : 'Out of Service') }}
                </td>
                <td>{{ $user }}</td>
                <td>{{ $datePurchased->format('Y-m-d') }}</td>
                <td>{{ $dateAcquired->format('Y-m-d') }}</td>
                <td class="flex space-x-1">
                    <a href="{{ route('items.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this equipment?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">DELETE</button>
                    </form>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.tailwindcss.com"></script>

@endsection
