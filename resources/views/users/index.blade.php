@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto p-6 rounded-lg shadow-md" x-data="{ openAdd: false, openEdit: null }">
        <h1 class="text-3xl font-bold text-blue-800 mb-6">EMPLOYEE</h1>

        <!-- Button to open "Add Employee" modal -->
        <button @click="openAdd = true" class="button">Add Employee</button>

        <!-- ADD EMPLOYEE MODAL -->
        <div x-show="openAdd" x-cloak x-transition class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg relative">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Add Employee</h2>
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

                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="openAdd = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Add</button>
                    </div>
                </form>
            </div>
        </div>

        @if($employees->isEmpty())
            <p class="text-center text-gray-600 mt-6">No employees found.</p>
        @else
            <table class="table w-full mt-6">
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
                                <form action="{{ route('employee.toggleStatus', $employee->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-2 py-1 text-sm font-semibold rounded {{ $employee->active ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                        {{ $employee->active ? 'Active' : 'Inactive' }}
                                    </button>
                                </form>
                            </td>
                            <td class="py-3 px-4">
                                <button @click="openEdit = {{ $employee->id }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Edit</button>
                            </td>
                        </tr>

                        <!-- EDIT EMPLOYEE MODAL -->
                        <div x-show="openEdit === {{ $employee->id }}" x-cloak x-transition class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg relative">
                                <h2 class="text-xl font-bold text-gray-800 mb-4">Edit Employee</h2>
                                <form action="{{ route('employee.update', $employee->id) }}" method="POST" class="space-y-4">
                                    @csrf
                                    @method('PUT')

                                    <div>
                                        <label class="block text-gray-700">First Name</label>
                                        <input type="text" name="first_name" value="{{ $employee->first_name }}" required class="w-full p-2 border border-gray-300 rounded">
                                    </div>
                                    <div>
                                        <label class="block text-gray-700">Last Name</label>
                                        <input type="text" name="last_name" value="{{ $employee->last_name }}" required class="w-full p-2 border border-gray-300 rounded">
                                    </div>
                                    <div>
                                        <label class="block text-gray-700">Employee Number</label>
                                        <input type="text" name="employee_number" value="{{ $employee->employee_number }}" required class="w-full p-2 border border-gray-300 rounded">
                                    </div>
                                    <div>
                                        <label class="block text-gray-700">Department</label>
                                        <input type="text" name="department" value="{{ $employee->department }}" required class="w-full p-2 border border-gray-300 rounded">
                                    </div>
                                    <div>
                                        <label class="block text-gray-700">Hire Date</label>
                                        <input type="date" name="hire_date" value="{{ $employee->hire_date }}" required class="w-full p-2 border border-gray-300 rounded">
                                    </div>

                                    <div class="flex justify-end space-x-2">
                                        <button type="button" @click="openEdit = null" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Tailwind & Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.3/cdn.min.js" defer></script>

    <style>
        [x-cloak] { display: none !important; }
        .button {
            background: #2772a1;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .button:hover {
            background: #005f87;
        }
    </style>
@endsection
