<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="{{ asset('userEmployee/index.css')}}"/>
    
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Employees</h1>
        
        <a href="{{ route('employee.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add Employee</a>
        
        <div class="mt-6 overflow-x-auto">
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-blue-800 text-white">
                    <tr>
                        <th class="py-3 px-4">First Name</th>
                        <th class="py-3 px-4">Last Name</th>
                        <th class="py-3 px-4">Employee Number</th>
                        <th class="py-3 px-4">Department</th>
                        <th class="py-3 px-4">Hire Date</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-4">{{ $employee->first_name }}</td>
                        <td class="py-3 px-4">{{ $employee->last_name }}</td>
                        <td class="py-3 px-4">{{ $employee->employee_number }}</td>
                        <td class="py-3 px-4">{{ $employee->department }}</td>
                        <td class="py-3 px-4">{{ $employee->hire_date }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 text-sm font-semibold rounded {{ $employee->active ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                {{ $employee->active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <a href="{{ route('employee.edit', $employee->id) }}" class="text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
