<!-- resources/views/categories/create.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Brand</title>
</head>
<body>
    <h1>Add Brand</h1>

    <!-- Check for success message -->
    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <form action="{{ route('brands.store', $categoryID) }}" method="POST">
        @csrf
        <label for="brand_name">Brand Name:</label>
        <input type="text" id="brand_name" name="brand_name" required>
        
        <button type="submit">Create brand</button>
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
