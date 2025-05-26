<!-- resources/views/categories/Edit.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Unit</title>
</head>
<body>
    <h1>Edit Unit</h1>

    <!-- Check for success message -->
    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <form action="{{ route('units.update', ['id' => $unit->id, 'brandID' => $brandID, 'categoryID' => $categoryID]) }}" method="POST">
    @csrf
    @method('PUT')
        
        <label for="unit_name">Unit Name:</label>
        <input type="text" id="unit_name" name="unit_name" value = "{{$unit->unit_name}}" required>
        
        <button type="submit">Edit Unit</button>
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
