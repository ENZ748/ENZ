@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-blue-800 mb-6">EMPLOYEE</h1>
        <button onclick="openModal('addEmployeeModal')" class="button">Add Employee</button>

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
                                <button onclick="openEditModal({{ $employee }})" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Add Employee Modal -->
    <div id="addEmployeeModal" class="modal hidden">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addEmployeeModal')">&times;</span>
            <h2>Add Employee</h2>
            <form action="{{ route('employee.store') }}" method="POST">
                @csrf
                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="last_name" placeholder="Last Name" required>
                <input type="text" name="employee_number" placeholder="Employee Number" required>
                <input type="text" name="department" placeholder="Department" required>
                <input type="date" name="hire_date" required>
                <button type="submit">Add Employee</button>
            </form>
        </div>
    </div>

    <!-- Edit Employee Modal -->
    <div id="editEmployeeModal" class="modal hidden">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editEmployeeModal')">&times;</span>
            <h2>Edit Employee</h2>
            <form id="editEmployeeForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_employee_id">
                <input type="text" id="edit_first_name" name="first_name" required>
                <input type="text" id="edit_last_name" name="last_name" required>
                <input type="text" id="edit_employee_number" name="employee_number" required>
                <input type="text" id="edit_department" name="department" required>
                <input type="date" id="edit_hire_date" name="hire_date" required>
                <button type="submit">Update Employee</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function openEditModal(employee) {
            document.getElementById('edit_employee_id').value = employee.id;
            document.getElementById('edit_first_name').value = employee.first_name;
            document.getElementById('edit_last_name').value = employee.last_name;
            document.getElementById('edit_employee_number').value = employee.employee_number;
            document.getElementById('edit_department').value = employee.department;
            document.getElementById('edit_hire_date').value = employee.hire_date;
            document.getElementById('editEmployeeForm').action = `/employee/${employee.id}`;
            openModal('editEmployeeModal');
        }
    </script>

    <style>
        .modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); display: flex; justify-content: center; align-items: center; }
        .modal-content { background: white; padding: 20px; border-radius: 5px; width: 300px; }
        .close { float: right; cursor: pointer; }
        .hidden { display: none; }
    </style>
@endsection
