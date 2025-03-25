@extends('layouts.app')

@section('content')

@php
    use App\Models\Brand;

    // Get the brand name by its ID
    $brand = Brand::find($brandID);
@endphp

<h1>All Units for {{ $brand ? $brand->brand_name : 'No Brand Found' }}</h1>

<!-- Link to add a unit under this brand -->
<a href="{{ route('units.create', ['brandID' => $brandID, 'categoryID' => $categoryID]) }}" class="btn btn-primary mb-4">Add Unit</a>
<a href="{{ route('categories.index') }}" class="btn btn-primary mb-4">Categories</a>
<a href="{{ route('brands.index',$categoryID) }}" class="btn btn-primary mb-4">Brand</a>

<!-- Container for the units -->
<div class="row">
    @foreach($units as $unit)
        <!-- Card for each unit -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>{{ $unit->unit_name }}</h5>
                </div>
                <div class="card-body">
                    <!-- unit Create Date -->
                    <p><strong>Created At:</strong> {{ \Carbon\Carbon::parse($unit->created_at)->format('Y-m-d') }}</p>
                </div>
                <!-- Link to view the unit's details (you might want to replace 'brands.index' with the correct route for unit details) -->
                <a href="{{ route('units.edit',['id' => $unit->id, 'brandID' => $brandID, 'categoryID' => $categoryID]) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('units.destroy', ['id' => $unit->id, 'brandID' => $brandID, 'categoryID' => $categoryID]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this equipment?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">DELETE</button>
                    </form>
            </div>
        </div>
    @endforeach
</div>
<script src="https://cdn.tailwindcss.com"></script>

@endsection
