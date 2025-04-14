@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .card-header {
            background: linear-gradient(135deg, #0074e8, #005ab4);
            color: white;
        }
        .status-badge {
            font-size: 0.85rem;
            padding: 0.35em 0.65em;
        }
        .action-btn {
            width: 80px;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(58, 123, 213, 0.1);
        }
        .modal-header {
            background: linear-gradient(135deg, #0074e8, #005ab4);
            color: white;
        }
        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
        .form-control:focus, .form-select:focus {
            border-color: #3a7bd5;
            box-shadow: 0 0 0 0.25rem rgba(58, 123, 213, 0.25);
        }
        .avatar-placeholder {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            color: #6c757d;
            font-weight: bold;
        }
        .is-invalid {
            border-color: #dc3545;
        }
        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }
    </style>

    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0"><i class="bi bi-people-fill me-2"></i>Employee Management</h2>
                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                    <i class="bi bi-plus-lg me-1"></i> Add Employee
                </button>
            </div>
            
            <div class="card-body">
                @if($employees->isEmpty())
                    <div class="alert alert-info d-flex align-items-center">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        No employees found in the system.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Employee</th>
                                    <th>Employee Number</th>
                                    <th>Department</th>
                                    <th>Hire Date</th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-placeholder">
                                                    {{ substr($employee->first_name, 0, 1) }}{{ substr($employee->last_name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong><br>
                                                    <small class="text-muted">{{ $employee->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $employee->employee_number }}</td>
                                        <td>{{ $employee->department }}</td>
                                        <td>{{ date('M d, Y', strtotime($employee->hire_date)) }}</td>
                                        <td>
                                            <form action="{{ route('employee.toggleStatus', $employee->id) }}" method="POST" class="status-form">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button" class="btn btn-sm status-badge {{ $employee->active ? 'btn-success' : 'btn-danger' }}"
                                                    onclick="confirmStatusChange(this)">
                                                    <i class="bi {{ $employee->active ? 'bi-check-circle' : 'bi-x-circle' }} me-1"></i>
                                                    {{ $employee->active ? 'Active' : 'Inactive' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="btn btn-sm btn-outline-primary action-btn" onclick="openEditModal({{ $employee }})">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary action-btn" onclick="openAssignedModal({{ $employee->id }})">
                                                    <i class="bi bi-box-seam"></i> Assets
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Add Employee Modal -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-person-plus me-2"></i>Add New Employee</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addEmployeeForm" method="POST" action="{{ route('register') }}" onsubmit="return confirmAddEmployee(event)">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control" required>
                                <div class="invalid-feedback">Please provide a first name.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control" required>
                                <div class="invalid-feedback">Please provide a last name.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Employee Number</label>
                                <input type="text" name="employee_number" class="form-control" required>
                                <div class="invalid-feedback">Please provide an employee number.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Department</label>
                                <input type="text" name="department" class="form-control" required>
                                <div class="invalid-feedback">Please provide a department.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Hire Date</label>
                                <input type="date" name="hire_date" class="form-control" required>
                                <div class="invalid-feedback">Please select a hire date.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <input type="email" name="email" class="form-control" required 
                                           oninput="this.value = this.value.toLowerCase()"
                                           onblur="validateEmail(this)">
                                </div>
                                <div id="email_error" class="text-danger small mt-1" style="display: none;">
                                    <i class="bi bi-exclamation-triangle-fill"></i> Email must end with @enzconsultancy.com
                                </div>
                                <div class="invalid-feedback">Please provide a valid email.</div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                                <i class="bi bi-eye-slash password-toggle" onclick="togglePassword('password', this)"></i>
                                <div class="invalid-feedback">Please provide a password.</div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" id="confirm_password" name="password_confirmation" class="form-control" required>
                                <i class="bi bi-eye-slash password-toggle" onclick="togglePassword('confirm_password', this)"></i>
                                <div id="password_error" class="text-danger small mt-1" style="display: none;">
                                    <i class="bi bi-exclamation-triangle-fill"></i> Passwords do not match
                                </div>
                                <div class="invalid-feedback">Please confirm your password.</div>
                            </div>
                        </div>
                        <div class="modal-footer border-top-0">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Save Employee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Employee Modal -->
    <div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-person-gear me-2"></i>Edit Employee</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editEmployeeForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_employee_id">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" id="edit_first_name" name="first_name" class="form-control" required>
                                <div class="invalid-feedback">Please provide a first name.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" id="edit_last_name" name="last_name" class="form-control" required>
                                <div class="invalid-feedback">Please provide a last name.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Employee Number</label>
                                <input type="text" id="edit_employee_number" name="employee_number" class="form-control" required>
                                <div class="invalid-feedback">Please provide an employee number.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Department</label>
                                <input type="text" id="edit_department" name="department" class="form-control" required>
                                <div class="invalid-feedback">Please provide a department.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Hire Date</label>
                                <input type="date" id="edit_hire_date" name="hire_date" class="form-control" required>
                                <div class="invalid-feedback">Please select a hire date.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <input type="email" id="edit_email" name="email" class="form-control" required
                                           onblur="validateEditEmail(this)">
                                </div>
                                <div id="edit_email_error" class="text-danger small mt-1" style="display: none;">
                                    <i class="bi bi-exclamation-triangle-fill"></i> Email must end with @enzconsultancy.com
                                </div>
                                <div class="invalid-feedback">Please provide a valid email.</div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label">Password</label>
                                <input type="password" id="edit_password" name="password" class="form-control" required>
                                <i class="bi bi-eye-slash password-toggle" onclick="togglePassword('edit_password', this)"></i>
                                <div class="invalid-feedback">Please provide a password.</div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" id="edit_confirm_password" name="password_confirmation" class="form-control" required>
                                <i class="bi bi-eye-slash password-toggle" onclick="togglePassword('edit_confirm_password', this)"></i>
                                <div id="edit_password_error" class="text-danger small mt-1" style="display: none;">
                                    <i class="bi bi-exclamation-triangle-fill"></i> Passwords do not match
                                </div>
                                <div class="invalid-feedback">Please confirm your password.</div>
                            </div>
                        </div>
                        <div class="modal-footer border-top-0">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="validateEditForm()">
                                <i class="bi bi-save me-1"></i> Update Employee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Assigned Items Modal -->
    <div class="modal fade" id="editAssignedModal" tabindex="-1" aria-labelledby="editAssignedModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-box-seam me-2"></i>Assigned Assets</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="assignedItemsTable" class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Unit</th>
                                    <th>Serial Number</th>
                                    <th>Assigned Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Assigned items will be populated here -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId, icon) {
            const field = document.getElementById(fieldId);
            if (field.type === "password") {
                field.type = "text";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            } else {
                field.type = "password";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            }
        }

        function validateEmail(input) {
            const email = input.value;
            const errorSpan = document.getElementById('email_error');
            
            if (!email.endsWith('@enzconsultancy.com')) {
                errorSpan.style.display = 'block';
                input.classList.add('is-invalid');
                return false;
            } else {
                errorSpan.style.display = 'none';
                input.classList.remove('is-invalid');
                return true;
            }
        }

        function validateEditEmail(input) {
            const email = input.value;
            const errorSpan = document.getElementById('edit_email_error');
            
            if (!email.endsWith('@enzconsultancy.com')) {
                errorSpan.style.display = 'block';
                input.classList.add('is-invalid');
                return false;
            } else {
                errorSpan.style.display = 'none';
                input.classList.remove('is-invalid');
                return true;
            }
        }

        function openEditModal(employee) {
            document.getElementById('edit_employee_id').value = employee.id;
            document.getElementById('edit_first_name').value = employee.first_name || '';
            document.getElementById('edit_last_name').value = employee.last_name || '';
            document.getElementById('edit_employee_number').value = employee.employee_number || '';
            document.getElementById('edit_department').value = employee.department || '';
            document.getElementById('edit_hire_date').value = employee.hire_date || '';
            document.getElementById('edit_email').value = employee.email || '';
            document.getElementById('editEmployeeForm').action = `/employee/update/${employee.id}`;

            // Clear any previous validation errors
            const invalidInputs = document.querySelectorAll('#editEmployeeForm .is-invalid');
            invalidInputs.forEach(input => input.classList.remove('is-invalid'));
            
            new bootstrap.Modal(document.getElementById('editEmployeeModal')).show();
        }

        function validateEditForm() {
            // Reset all invalid states
            const inputs = document.querySelectorAll('#editEmployeeForm input');
            let isValid = true;
            
            inputs.forEach(input => {
                if (input.required && !input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            // Validate email format
            const emailValid = validateEditEmail(document.getElementById('edit_email'));
            if (!emailValid) isValid = false;

            // Validate password match
            const password = document.getElementById("edit_password").value;
            const confirmPassword = document.getElementById("edit_confirm_password").value;
            const errorSpan = document.getElementById("edit_password_error");

            if (password !== confirmPassword) {
                errorSpan.style.display = "block";
                document.getElementById("edit_confirm_password").classList.add('is-invalid');
                isValid = false;
            } else {
                errorSpan.style.display = "none";
                document.getElementById("edit_confirm_password").classList.remove('is-invalid');
            }

            if (isValid) {
                confirmUpdate();
            } else {
                // Scroll to the first invalid input
                const firstInvalid = document.querySelector('#editEmployeeForm .is-invalid');
                if (firstInvalid) {
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        }

        function confirmUpdate() {
            Swal.fire({
                title: "Confirm Update",
                text: "Are you sure you want to update this employee's details?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3a7bd5",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, update it!",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Updating Employee",
                        html: '<div class="spinner-border text-primary my-3" role="status"><span class="visually-hidden">Loading...</span></div><p>Please wait while we update the employee record...</p>',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });

                    // Send email notification first
                    fetch('/send-mail')
                        .then(response => response.json())
                        .then(data => {
                            console.log('Email sent:', data);
                            // Proceed with form submission
                            setTimeout(() => {
                                document.getElementById('editEmployeeForm').submit();
                            }, 1500);
                        })
                        .catch(error => {
                            console.error('Error sending email:', error);
                            // Still proceed with form submission even if email fails
                            document.getElementById('editEmployeeForm').submit();
                        });
                }
            });
        }


        function openAssignedModal(employeeId) {
            fetch(`/employee/items/${employeeId}`)
                .then(response => response.json())
                .then(assignedItems => {
                    const tableBody = document.querySelector('#assignedItemsTable tbody');
                    tableBody.innerHTML = '';

                    if (assignedItems.length === 0) {
                        tableBody.innerHTML = `
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-box-seam display-6 d-block mb-2"></i>
                                    No assets assigned to this employee
                                </td>
                            </tr>
                        `;
                    } else {
                        assignedItems.forEach(item => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${item.equipment_category || 'N/A'}</td>
                                <td>${item.equipment_brand || 'N/A'}</td>
                                <td>${item.equipment_unit || 'N/A'}</td>
                                <td>${item.equipment_serialNumber || 'N/A'}</td>
                                <td>${item.assigned_date ? new Date(item.assigned_date).toLocaleDateString() : 'N/A'}</td>
                            `;
                            tableBody.appendChild(row);
                        });
                    }

                    new bootstrap.Modal(document.getElementById('editAssignedModal')).show();
                })
                .catch(error => {
                    console.error('Error fetching assigned items:', error);
                    Swal.fire({
                        title: "Error",
                        text: "Failed to load assigned items. Please try again.",
                        icon: "error"
                    });
                });
        }

        function confirmStatusChange(button) {
            const newStatus = button.textContent.trim().includes('Active') ? 'inactive' : 'active';
            
            Swal.fire({
                title: "Change Status?",
                html: `You are about to mark this employee as <strong>${newStatus}</strong>. Continue?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3a7bd5",
                cancelButtonColor: "#6c757d",
                confirmButtonText: `Yes, make ${newStatus}`,
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Updating Status",
                        html: '<div class="spinner-border text-primary my-3" role="status"><span class="visually-hidden">Loading...</span></div><p>Updating employee status...</p>',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });

                    setTimeout(() => {
                        button.closest('form').submit();
                    }, 1000);
                }
            });
        }

        function validatePassword() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            var errorSpan = document.getElementById("password_error");

            if (password !== confirmPassword) {
                errorSpan.style.display = "block";
                document.getElementById("confirm_password").classList.add('is-invalid');
                return false;
            } else {
                errorSpan.style.display = "none";
                document.getElementById("confirm_password").classList.remove('is-invalid');
                return true;
            }
        }

        function confirmAddEmployee(event) {
            event.preventDefault();

            // Validate all required fields
            const form = document.getElementById('addEmployeeForm');
            const inputs = form.querySelectorAll('input[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            // Validate email format
            const emailValid = validateEmail(document.querySelector('#addEmployeeForm input[name="email"]'));
            if (!emailValid) isValid = false;

            // Validate password match
            const passwordValid = validatePassword();
            if (!passwordValid) isValid = false;

            if (!isValid) {
                const firstInvalid = document.querySelector('#addEmployeeForm .is-invalid');
                if (firstInvalid) {
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return false;
            }

            Swal.fire({
                title: "Add New Employee?",
                text: "Please confirm all details are correct before proceeding.",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3a7bd5",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, add employee",
                cancelButtonText: "Review details"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Creating Employee",
                        html: '<div class="spinner-border text-primary my-3" role="status"><span class="visually-hidden">Loading...</span></div><p>Setting up the new employee record...</p>',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });

                    // Send email notification first
                    fetch('/send-mail')
                        .then(response => response.json())
                        .then(data => {
                            console.log('Email sent:', data);
                            // Proceed with form submission
                            setTimeout(() => {
                                form.submit();
                            }, 1500);
                        })
                        .catch(error => {
                            console.error('Error sending email:', error);
                            // Still proceed with form submission even if email fails
                            form.submit();
                        });
                }
            });
        }

        // Add event listeners for input validation
        document.addEventListener('DOMContentLoaded', function() {
            const editForm = document.getElementById('editEmployeeForm');
            if (editForm) {
                editForm.querySelectorAll('input[required]').forEach(input => {
                    input.addEventListener('input', function() {
                        if (this.value.trim()) {
                            this.classList.remove('is-invalid');
                        }
                    });
                });
            }

            const addForm = document.getElementById('addEmployeeForm');
            if (addForm) {
                addForm.querySelectorAll('input[required]').forEach(input => {
                    input.addEventListener('input', function() {
                        if (this.value.trim()) {
                            this.classList.remove('is-invalid');
                        }
                    });
                });
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection