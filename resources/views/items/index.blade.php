@extends('layouts.app')

@section('content')

@php
    use App\Models\Category;
    use App\Models\Brand;
    use App\Models\Unit;
@endphp

<h1>Items</h1>

<!-- Start the table structure -->
<table>
    <thead>
        <tr>
            <th>Category</th>
            <th>Brand</th>
            <th>Unit</th>
            <th>Serial Number</th>
            <th>Equipment Status</th>
            <th>Date Purchased</th>
            <th>Date Acquired</th>
        </tr>
    </thead>
    <tbody>
    @foreach($items as $item)
    @php
        $category = $item->category;
        $brand = $item->brand;
        $unit = $item->unit;

        $datePurchased = \Carbon\Carbon::parse($item->date_purchased);
        $dateAcquired = \Carbon\Carbon::parse($item->date_acquired);
    @endphp
    <tr>
        <td>{{ $category ? $category->category_name : 'No Category' }}</td>
        <td>{{ $brand ? $brand->brand_name : 'No Brand' }}</td>
        <td>{{ $unit ? $unit->unit_name : 'No Unit' }}</td>
        <td>{{ $item->serial_number }}</td>
        <td>{{ $item->equipment_status == 0 ? 'Available' : ($item->equipment_status == 1 ? 'In Use' : 'Out of Service') }}</td>
        
        <!-- Format dates after parsing -->
        <td>{{ $datePurchased->format('Y-m-d') }}</td>
        <td>{{ $dateAcquired->format('Y-m-d') }}</td>
    </tr>
@endforeach

    </tbody>
</table>

@endsection
