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
                    {{ $item->equipment_status == 0 ? 'Available' : ($item->equipment_status == 1 ? 'In Use' : 'Out of Service') }}
                </span>
            </div>

            <div class="text-sm mb-2">
                <span class="text-gray-600">Date Purchased:</span>
                <span class="text-blue-500">{{ $datePurchased->format('Y-m-d') }}</span>
            </div>

            <div class="text-sm mb-2">
                <span class="text-gray-600">Date Acquired:</span>
                <span class="text-blue-500">{{ $dateAcquired->format('Y-m-d') }}</span>
            </div>

            <a href="{{ route('items.edit',$item->id) }}" class="btn btn-primary mb-4 px-4 py-2 bg-blue-500 text-white rounded-lg">Edit</a>
            <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this equipment?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">DELETE</button>
            </form>
              
        </div>

         

    @endforeach
</div>
<script src="https://cdn.tailwindcss.com"></script>

@endsection
