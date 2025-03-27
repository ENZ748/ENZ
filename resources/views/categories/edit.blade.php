<!-- resources/views/categories/create.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
</head>
<body>
    <h1>Edit Category</h1>

    <!-- Check for success message -->
    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="category_name">Category Name:</label>
        <input type="text" id="category_name" name="category_name" value="{{$category->category_name}}" required>
        
        <button type="submit">Edit Category</button>
    </form>

    <!-- Check for validation errors -->
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
</html>
