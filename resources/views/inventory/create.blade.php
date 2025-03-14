<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Equipment</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="background flex justify-center  items-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Add Equipment</h1>

        <form action="{{route('equipment.store')}}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-gray-700">Equipment Name</label>
                <input type="text" name="equipment_name" required class="w-full p-2 border rounded">
            </div>

            <div>
                <label class="block text-gray-700">Serial Number</label>
                <input type="text" name="serial_number" required class="w-full p-2 border rounded">
            </div>

            <div>
                <label class="block text-gray-700">Equipment Detail</label>
                <input type="text" name="equipment_details" required class="w-full p-2 border rounded">
            </div>

            <div>
                <label class="block text-gray-700">Date Purchased</label>
                <input type="date" name="date_purchased" required class="w-full p-2 border rounded">
            </div>

            <div>
                <label class="block text-gray-700">Date Acquired</label>
                <input type="date" name="date_acquired" required class="w-full p-2 border rounded">
            </div>

            <div class="flex justify-center">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Add Equipment</button>
            </div>
        </form>
    </div>

    <style>
           .background {
            margin: 0;
            padding: 160px;
            font-family: sans-serif;
            background: linear-gradient(#30142b, #2772a1);
        }
        .table {
            width: 100%;
            height: 20vh;
            grid-template-columns: 1fr 1fr;
            border: 3px solid #00ffff;
            box-shadow: 0 0 50px 0 #00a6bc;
        }

    </style>

</body>
</html>
