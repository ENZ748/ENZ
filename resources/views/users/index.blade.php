@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="container mt-4">
        <h1 class="text-primary">Employees</h1>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
            Add Employee
        </button> 

        @if($employees->isEmpty())
            <div class="alert alert-warning">No employees found.</div>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Employee Number</th>
                            <th>Department</th>
                            <th>Hire Date</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr>
                                <td>{{ $employee->first_name }}</td>
                                <td>{{ $employee->last_name }}</td>
                                <td>{{ $employee->employee_number }}</td>
                                <td>{{ $employee->department }}</td>
                                <td>{{ $employee->hire_date }}</td>
                                <td>
                                    <form action="{{ route('employee.toggleStatus', $employee->id) }}" method="POST" class="status-form">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" class="btn btn-sm {{ $employee->active ? 'btn-success' : 'btn-danger' }}"
                                            onclick="confirmStatusChange(this)">
                                            {{ $employee->active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" onclick="openEditModal({{ $employee }})">Edit</button>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" onclick="openAssignedModal({{ $employee->id }})">View</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Add Employee Modal -->
        <<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Employee Number</label>
                            <input type="text" name="employee_number" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <input type="text" name="department" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hire Date</label>
                            <input type="date" name="hire_date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Employee</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


                <!-- Edit Employee Modal -->
        <div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editEmployeeForm" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="edit_employee_id">
                            <div class="mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" id="edit_first_name" name="first_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" id="edit_last_name" name="last_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Employee Number</label>
                                <input type="text" id="edit_employee_number" name="employee_number" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Department</label>
                                <input type="text" id="edit_department" name="department" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Hire Date</label>
                                <input type="date" id="edit_hire_date" name="hire_date" class="form-control" required>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="confirmUpdate()">Update Employee</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <!-- Assigned Item Modal -->
    <div class="modal fade" id="editAssignedModal" tabindex="-1" aria-labelledby="editAssignedModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assigned Items</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="assignedItemsTable" class="table">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Details</th>
                                <th>Serial Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Assigned items will be populated here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script>

    function openEditModal(employee) {
            // Populate form fields with employee data
            document.getElementById('edit_employee_id').value = employee.id;
            document.getElementById('edit_first_name').value = employee.first_name;
            document.getElementById('edit_last_name').value = employee.last_name;
            document.getElementById('edit_employee_number').value = employee.employee_number;
            document.getElementById('edit_department').value = employee.department;
            document.getElementById('edit_hire_date').value = employee.hire_date;

            // Dynamically set form action
            document.getElementById('editEmployeeForm').action = `/employee/update/${employee.id}`;

            // Show modal
            new bootstrap.Modal(document.getElementById('editEmployeeModal')).show();
        }

        function confirmUpdate() {
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to update this employee's details?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, update it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading animation
                    Swal.fire({
                        title: "Updating...",
                        text: "Please wait while processing your request.",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Simulate a delay (2 seconds) before success message
                    setTimeout(() => {
                        Swal.fire({
                            title: "Success!",
                            text: "Employee details have been updated.",
                            icon: "success",
                            confirmButtonColor: "#3085d6"
                        }).then(() => {
                            document.getElementById('editEmployeeForm').submit(); // Submit after clicking "OK"
                        });
                    }, 2000); // Simulated 2-second delay
                }
            });
        }

        function openAssignedModal(employeeId) {
            fetch(`/employee/items/${employeeId}`)  // Assuming this route returns assigned items
                .then(response => response.json())
                .then(assignedItems => {
                    const tableBody = document.querySelector('#assignedItemsTable tbody');
                    tableBody.innerHTML = '';  // Clear the table

                    assignedItems.forEach(item => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.equipment_name}</td>
                            <td>${item.equipment_detail}</td>
                            <td>${item.equipment_serialNumber}</td>
                        `;
                        tableBody.appendChild(row);
                    });

                    // Show the modal
                    new bootstrap.Modal(document.getElementById('editAssignedModal')).show();
                });
        }


        function confirmStatusChange(button) {
        Swal.fire({
            title: "Are you sure?",
            text: "You are about to change the employee's status!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, change it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading animation
                Swal.fire({
                    title: "Processing...",
                    text: "Please wait",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Simulate a delay (2 seconds) before showing success message
                setTimeout(() => {
                    Swal.fire({
                        title: "Success!",
                        text: "Employee status has been updated.",
                        icon: "success",
                        confirmButtonColor: "#3085d6"
                    }).then(() => {
                        button.closest('form').submit(); // Only submit after clicking OK
                    });
                }, 2000); // Simulated delay of 2 seconds
            }
        });
    }

         </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
@endsection
