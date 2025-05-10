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
