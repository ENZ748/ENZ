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

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Equipment Name</th>
                    <th class="border p-2">Serial Number</th>
                    <th class="border p-2">Equipment Details</th>
                    <th class="border p-2">Date Purchased</th>
                    <th class="border p-2">Date Acquired</th>
                    <th class="border p-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($equipments as $equipment)
                <tr class="bg-white border">
                    <td class="border p-2">{{ $equipment->equipment_name }}</td>
                    <td class="border p-2">{{ $equipment->serial_number }}</td>
                    <td class="border p-2">{{ $equipment->equipment_details }}</td>
                    <td class="border p-2">{{ $equipment->date_purchased }}</td>
                    <td class="border p-2">{{ $equipment->date_acquired }}</td>
                    <td class="border p-2 flex space-x-2">
                        <a href="{{ route('equipment.edit', $equipment->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Edit</a>
                        <form action="{{ route('equipment.destroy', $equipment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this equipment?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">DELETE</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
