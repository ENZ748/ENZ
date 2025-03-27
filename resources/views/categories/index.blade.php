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
                    <br>
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">Edit</a>
                    
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this equipment?');">
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
