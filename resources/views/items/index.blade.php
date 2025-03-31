@extends('layouts.app')

@section('content')

@php
    use App\Models\Category;
    use App\Models\Brand;
    use App\Models\Unit;
@endphp

<h1 class="text-2xl font-semibold mb-4">Items</h1>

<!-- Category Filter Dropdown -->
<form method="GET" action="{{ route('items.index') }}" class="mb-4 flex space-x-2">
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

<!-- View Toggle Buttons -->
<div class="flex space-x-2 mb-4">
    <button onclick="setView('table')" class="bg-gray-300 px-4 py-2 rounded-md">Table View</button>
    <button onclick="setView('grid')" class="bg-gray-300 px-4 py-2 rounded-md">Grid View</button>
</div>

<!-- Add Item Button -->
<a href="{{ route('items.create') }}" class="btn btn-primary mb-4 px-4 py-2 bg-blue-500 text-white rounded-lg">Add Item</a>
<a href="{{ route('categories.index') }}" class="btn btn-primary mb-4">View Categories</a>

<!-- Table View -->
<div id="table-view" class="hidden">
    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="border px-4 py-2">Category</th>
                <th class="border px-4 py-2">Brand</th>
                <th class="border px-4 py-2">Unit</th>
                <th class="border px-4 py-2">Serial Number</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Assigned To</th>
                <th class="border px-4 py-2">Date Purchased</th>
                <th class="border px-4 py-2">Date Acquired</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
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
                <tr class="border">
                    <td class="border px-4 py-2">{{ $category->category_name }}</td>
                    <td class="border px-4 py-2">{{ $brand->brand_name }}</td>
                    <td class="border px-4 py-2">{{ $unit->unit_name }}</td>
                    <td class="border px-4 py-2">{{ $item->serial_number }}</td>
                    <td class="border px-4 py-2">
                        {{ $item->equipment_status == 0 ? 'Available' : ($item->equipment_status == 1 ? 'In Use' : 'Out of Service') }}
                    </td>
                    <td class="border px-4 py-2">{{ $user }}</td>
                    <td class="border px-4 py-2">{{ $datePurchased->format('Y-m-d') }}</td>
                    <td class="border px-4 py-2">{{ $dateAcquired->format('Y-m-d') }}</td>
                    <td class="border px-4 py-2 space-x-2">
                        <a href="{{ route('items.edit', $item->id) }}" class="text-blue-500">Edit</a>
                        <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
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
            <p class="text-gray-600 text-sm">Purchased: {{ $datePurchased->format('Y-m-d') }}</p>
            <p class="text-gray-600 text-sm">Acquired: {{ $dateAcquired->format('Y-m-d') }}</p>

            <div class="flex space-x-2 mt-4">
                <a href="{{ route('items.edit', $item->id) }}" class="text-blue-500">Edit</a>
                <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500">Delete</button>
                </form>
            </div>
        </div>
    @endforeach
</div>

<script>
    function setView(view) {
        document.getElementById('table-view').classList.toggle('hidden', view !== 'table');
        document.getElementById('grid-view').classList.toggle('hidden', view !== 'grid');
    }

    // Set default view to table
    setView('table');
</script>
<script src="https://cdn.tailwindcss.com"></script>

@endsection
