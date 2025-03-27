@extends('layouts.app')

@section('content')

@php
    use App\Models\Category;
    use App\Models\Brand;
    use App\Models\Unit;
@endphp

<h1 class="text-2xl font-semibold mb-4">Items</h1>

<!-- Category Filter Dropdown -->
<form method="GET" action="{{ route('items.index') }}" class="mb-4 flex items-center space-x-2">
    <select name="category_id" id="category_id" class="px-4 py-2 border rounded-md">
        <option value="">All Categories</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" 
                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->category_name }}
            </option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-success">Filter</button>
</form>

<!-- Add Item & View Categories Buttons -->
<div class="flex space-x-2 mb-4">
    <a href="{{ route('items.create') }}" class="btn btn-success">
        + Add Item
    </a>
    <a href="{{ route('categories.index') }}" class="btn btn-success">
        View Categories
    </a>
</div>

<!-- Responsive Table -->
<div class="card-body">
    <table class="table table-hover text-center">
        <thead>
            <tr>
                <th >Category</th>
                <th >Brand</th>
                <th >Unit</th>
                <th >Serial Number</th>
                <th >Status</th>
                <th >Date Purchased</th>
                <th >Date Acquired</th>
                <th >Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($items as $item)
                @php
                    $category = Category::find($item->categoryID);
                    $brand = Brand::find($item->brandID);
                    $unit = Unit::find($item->unitID);
                    $datePurchased = \Carbon\Carbon::parse($item->date_purchased);
                    $dateAcquired = \Carbon\Carbon::parse($item->date_acquired);
                @endphp
                <tr class="hover:bg-gray-100">
                    <td>{{ $category->category_name }}</td>
                    <td>{{ $brand->brand_name }}</td>
                    <td>{{ $unit->unit_name }}</td>
                    <td>{{ $item->serial_number }}</td>
                    <td>
                        <span class="{{ $item->equipment_status == 0 ? 'text-green-500' : ($item->equipment_status == 1 ? 'text-yellow-500' : 'text-red-500') }}">
                            {{ $item->equipment_status == 0 ? 'Available' : ($item->equipment_status == 1 ? 'In Use' : 'Out of Service') }}
                        </span>
                    </td>
                    <td>{{ $datePurchased->format('Y-m-d') }}</td>
                    <td>{{ $dateAcquired->format('Y-m-d') }}</td>
                    <td>
                        <div class="flex space-x-2">
                            <a href="{{ route('items.edit', $item->id) }}" class="btn btn-primary btn-sm">
                                Edit
                            </a>
                            <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.tailwindcss.com"></script>

@endsection
