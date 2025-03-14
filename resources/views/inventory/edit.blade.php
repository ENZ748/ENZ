<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Equipment</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6 flex justify-center items-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Update Equipment</h1>

        <form action="{{route('equipment.update', $equipment->id)}}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-700">Equipment Name</label>
                <input type="text" name="equipment_name" value="{{$equipment->equipment_name}}" required class="w-full p-2 border rounded">
            </div>

            <div>
                <label class="block text-gray-700">Serial Number</label>
                <input type="text" name="serial_number" value="{{$equipment->serial_number}}" required class="w-full p-2 border rounded">
            </div>

            <div>
                <label class="block text-gray-700">Equipment Detail</label>
                <input type="text" name="equipment_details" value="{{$equipment->equipment_details}}" required class="w-full p-2 border rounded">
            </div>

            <div>
                <label class="block text-gray-700">Date Purchased</label>
                <input type="date" name="date_purchased" value="{{$equipment->date_purchased}}" required class="w-full p-2 border rounded">
            </div>

            <div>
                <label class="block text-gray-700">Date Acquired</label>
                <input type="date" name="date_acquired" value="{{$equipment->date_acquired}}" required class="w-full p-2 border rounded">
            </div>

            <div class="flex justify-center">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Equipment</button>
            </div>
        </form>
    </div>
</body>
</html>
