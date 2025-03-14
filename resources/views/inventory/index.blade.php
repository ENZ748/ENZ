<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6 flex justify-center items-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-5xl">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Inventory Management</h1>

        <div class="flex justify-end mb-4">
            <a href="{{ route('equipment.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Add Equipment</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($equipments as $equipment)
            <div class="bg-white p-6 rounded-lg shadow border">
                <h2 class="text-lg font-semibold text-gray-800">{{ $equipment->equipment_name }}</h2>
                <p class="text-gray-600">Serial: {{ $equipment->serial_number }}</p>
                <p class="text-gray-600">Details: {{ $equipment->equipment_details }}</p>
                <p class="text-gray-600">Purchased: {{ $equipment->date_purchased }}</p>
                <p class="text-gray-600">Acquired: {{ $equipment->date_acquired }}</p>
                <div class="mt-4 flex space-x-2">
                    <a href="{{ route('equipment.edit', $equipment->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Edit</a>
                    <form action="{{ route('equipment.destroy', $equipment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this equipment?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">DELETE</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>
