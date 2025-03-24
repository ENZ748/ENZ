@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8 px-4 py-6">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Edit Equipment Assignment</h1>

        <!-- Form to edit accountability -->
        <form action="{{ route('accountability.update', $accountability->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <!-- Employee Dropdown -->
            <div class="mb-4">
                <label for="employee_number" class="block text-gray-700 font-medium mb-2">Employee</label>
                <select name="employee_number" id="employee_number" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="{{ $accountability->employee->employee_number }}" selected>
                        {{ $accountability->employee->employee_number }}
                    </option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->employee_number }}">
                            {{ $employee->employee_number }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Equipment Dropdown -->
            <div class="mb-4">
                <label for="equipment_name" class="block text-gray-700 font-medium mb-2">Equipment</label>
                <select name="equipment_name" id="equipment_name" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="{{ $accountability->equipment->equipment_name }}" selected>
                        {{ $accountability->equipment->equipment_name }}
                    </option>
                    @foreach($equipments as $equipment)
                        <option value="{{ $equipment->equipment_name }}">
                            {{ $equipment->equipment_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Assigned Date -->
            <div class="mb-4">
                <label for="assigned_date" class="block text-gray-700 font-medium mb-2">Assigned Date</label>
                <input type="date" name="assigned_date" id="assigned_date" value="{{ $accountability->assigned_date }}" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Return Date -->
            <div class="mb-4">
                <label for="return_date" class="block text-gray-700 font-medium mb-2">Return Date</label>
                <input type="date" name="return_date" id="return_date" value="{{ $accountability->return_date }}" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Notes -->
            <div class="mb-4">
                <label for="notes" class="block text-gray-700 font-medium mb-2">Notes</label>
                <input type="text" name="notes" value="{{ $accountability->notes }}" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Assigned By -->
            <div class="mb-4">
                <label for="assigned_by" class="block text-gray-700 font-medium mb-2">Assigned By</label>
                <select name="assigned_by" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="IT" {{ $accountability->assigned_by == 'IT' ? 'selected' : '' }}>IT</option>
                    <option value="HR" {{ $accountability->assigned_by == 'HR' ? 'selected' : '' }}>HR</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary mb-3">
                Update Assignment
            </button>
        </form>
    </div>
@endsection
