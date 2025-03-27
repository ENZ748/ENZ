@extends('layouts.app')

@section('content')

@php
    use App\Models\Brand;

    // Get the brand name by its ID
    $brand = Brand::find($brandID);
@endphp

<h1>All Units for {{ $brand ? $brand->brand_name : 'No Brand Found' }}</h1>

<!-- Add Unit & Navigation Buttons -->
<div class="mb-3">
    <a href="{{ route('units.create', ['brandID' => $brandID, 'categoryID' => $categoryID]) }}" class="btn btn-primary">Add Unit</a>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Categories</a>
    <a href="{{ route('brands.index', $categoryID) }}" class="btn btn-secondary">Brand</a>
</div>

<!-- Units Table -->
<div class="table-responsive">
    <table class="table table-hover text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>Unit Name</th>
                <th>Created At</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($units as $index => $unit)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $unit->unit_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($unit->created_at)->format('Y-m-d') }}</td>
                    <td class="text-center">
                        <div class="btn-group gap-2" role="group">
                            <a href="{{ route('units.edit', ['id' => $unit->id, 'brandID' => $brandID, 'categoryID' => $categoryID]) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('units.destroy', ['id' => $unit->id, 'brandID' => $brandID, 'categoryID' => $categoryID]) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this unit?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
