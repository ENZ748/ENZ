<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6 flex justify-center items-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Add Employee</h1>

        <form action="{{ route('employee.store') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-gray-700">First Name</label>
                <input type="text" name="first_name" required class="w-full p-2 border border-gray-300 rounded">
            </div>

            <div>
                <label class="block text-gray-700">Last Name</label>
                <input type="text" name="last_name" required class="w-full p-2 border border-gray-300 rounded">
            </div>

            <div>
                <label class="block text-gray-700">Employee Number</label>
                <input type="text" name="employee_number" required class="w-full p-2 border border-gray-300 rounded">
            </div>

            <div>
                <label class="block text-gray-700">Department</label>
                <input type="text" name="department" required class="w-full p-2 border border-gray-300 rounded">
            </div>

            <div>
                <label class="block text-gray-700">Hire Date</label>
                <input type="date" name="hire_date" required class="w-full p-2 border border-gray-300 rounded">
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Add Employee</button>
        </form>
    </div>
</body>
</html>