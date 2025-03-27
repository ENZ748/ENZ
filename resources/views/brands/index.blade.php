@extends('layouts.app')

@section('content')

@php
    use App\Models\Category;

    $category = Category::find($categoryID);

@endphp

@if ($errors->has('brand_name'))
    <div class="alert alert-danger">
        {{ $errors->first('brand_name') }}
    </div>
@endif


<h1>All Units for {{ $category ? $category->category_name : 'No Category Found' }}</h1>

<!-- Add a New Brand Link for the Specific Category -->
<a href="{{ route('brands.create', $categoryID) }}" class="btn btn-primary mb-4">Add Brand</a>
<a href="{{ route('categories.index') }}" class="btn btn-primary mb-4">Categories</a>

<!-- Container for the brands -->
<div class="row">
    @foreach($brands as $brand)
        <!-- Card for each brand -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>{{ $brand->brand_name }}</h5>
                </div>
                <div class="card-body">
                    <!-- Brand Create Date -->
                    <p><strong>Created At:</strong> {{ \Carbon\Carbon::parse($brand->created_at)->format('Y-m-d') }}</p>
                </div>
                <!-- View Units link for the specific brand -->
                <a href="{{ route('units.index', ['brandID' => $brand->id, 'categoryID' => $categoryID]) }}" class="btn btn-primary">View Units</a>
                <a href="{{ route('brands.edit', ['id' => $brand->id, 'categoryID' => $categoryID]) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('brands.destroy', ['id' => $brand->id, 'categoryID' => $categoryID]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this equipment?');">
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
