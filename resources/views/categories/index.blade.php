    @extends('layouts.app')

    @section('content')

    @php
        use App\Models\Category;
    @endphp

    <h1>All Categories</h1>

    <a href="{{ route('categories.create') }}" class="btn btn-primary">Add Category</a>
    <!-- Container for the categories -->
    <div class="row">
        @foreach($categories as $category)
            <!-- Card for each category -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $category->category_name }}</h5>
                    </div>
                    <div class="card-body">
                        <!-- Category Create Date -->
                        <p><strong>Created At:</strong> {{ \Carbon\Carbon::parse($category->created_at)->format('Y-m-d') }}</p>
                    </div>
                    <!-- Corrected View Link -->
                    <a href="{{ route('brands.index', $category->id) }}" class="btn btn-primary">View</a>
                </div>
            </div>
        @endforeach
    </div>

    @endsection
