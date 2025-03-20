<!-- resources/views/categories/create.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Unit</title>
</head>
<body>
    <h1>Create Unit</h1>

    <!-- Check for success message -->
    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <form action="{{ route('units.store') }}" method="POST">
        @csrf
        <label for="unit_name">Unit Name:</label>
        <input type="text" id="unit_name" name="unit_name" required>
        
        <button type="submit">Create Unit</button>
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
