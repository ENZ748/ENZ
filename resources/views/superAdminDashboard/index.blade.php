@extends('layouts.superAdminApp')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
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
    .dashboard-card {
        transition: all 0.3s ease;
    }
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="container mx-auto px-4 py-8">
    <!-- Top Section: Card and Chart -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-16">
        <!-- Admin Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-md overflow-hidden dashboard-card cursor-pointer h-40" 
                 onclick="showModal('items')">
                <div class="p-4 flex items-center h-full">
                    <div class="bg-blue-100 p-3 rounded-full mr-4">
                        <i class="bi bi-person-gear text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-gray-500 text-xs font-medium uppercase tracking-wider">TOTAL ADMIN</h3>
                        <p class="mt-1 text-2xl font-semibold text-gray-900">{{$count_admin}}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Chart -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 h-full">
                <div class="flex justify-between items-center mb-9">
                    <h3 class="text-lg font-medium text-gray-900">Admin Statistics</h3>
                </div>
                <div class="h-64">
                    <canvas id="chart1"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Section: Admin Management (full width) -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
        <div class="p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Admin Management</h1>
                <button class="btn btn-primary mt-4 md:mt-0" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                    <i class="bi bi-plus-lg me-1"></i> Add Admin
                </button>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger mb-6">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($admins->isEmpty())
                <div class="alert alert-info d-flex align-items-center">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    No admins found in the system.
                </div>
            @else
                <div class="table-responsive">
                    <table class="min-w-full divide-y divide-gray-200 table-hover">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee Number</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hire Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($admins as $admin)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-placeholder">
                                                {{ substr($admin->first_name, 0, 1) }}{{ substr($admin->last_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <strong>{{ $admin->first_name }} {{ $admin->last_name }}</strong><br>
                                                <small class="text-muted">{{ $admin->users->email ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">{{ $admin->employee_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">{{ $admin->department }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">{{ date('M d, Y', strtotime($admin->hire_date)) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                        <form action="{{ route('admin.toggleStatus', $admin->id) }}" method="POST" class="status-form">
                                            @csrf
                                            @method('PATCH')
                                            <button type="button" class="btn btn-sm status-badge {{ $admin->active ? 'btn-success' : 'btn-danger' }}"
                                                onclick="confirmStatusChange(this)">
                                                <i class="bi {{ $admin->active ? 'bi-check-circle' : 'bi-x-circle' }} me-1"></i>
                                                {{ $admin->active ? 'Active' : 'Inactive' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button class="btn btn-sm btn-outline-primary action-btn" onclick="openEditModal({{ $admin }})">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary action-btn" onclick="openAssignedModal({{ $admin->id }})">
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

<!-- Dashboard Modal -->
<div id="modal-items" class="modal hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity" onclick="closeModal('items')">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        
        <!-- Modal content -->
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-10 bg-opacity-5">
        <!-- Modal -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Total Admin</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 mb-2"><strong class="font-medium text-gray-700">Current Total:</strong> {{$count_admin}} Admin</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="closeModal('items')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Close
                </button>
            </div>
        </div>
        </div>
    </div>
</div>

<!-- Add Employee Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person-plus me-2"></i>Add New Admin</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addEmployeeForm" method="POST" action="{{ route('admin.store') }}" onsubmit="return confirmAddEmployee(event)">
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
                            <select name="department" class="form-select" required>
                                <option value="" selected disabled>Select Department</option>
                                <option value="IT">IT</option>
                                <option value="Marketing">Marketing</option>
                                <option value="HR">HR</option>
                                <option value="Sales">Sales</option>
                                <option value="Accounting">Accounting</option>
                            </select>
                            <div class="invalid-feedback">Please select a department.</div>
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
                            <i class="bi bi-save me-1"></i> Save Admin
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
                <h5 class="modal-title"><i class="bi bi-person-gear me-2"></i>Edit Admin</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editEmployeeForm" method="POST" action="{{ route('admin.update', $admin->id) }}">
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
                            <select id="edit_department" name="department" class="form-select" required>
                                <option value="" disabled>Select Department</option>
                                <option value="IT">IT</option>
                                <option value="Marketing">Marketing</option>
                                <option value="HR">HR</option>
                                <option value="Sales">Sales</option>
                                <option value="Accounting">Accounting</option>
                            </select>
                            <div class="invalid-feedback">Please select a department.</div>
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
                            <input type="password" id="edit_password" name="password" class="form-control">
                            <i class="bi bi-eye-slash password-toggle" onclick="togglePassword('edit_password', this)"></i>
                            <small class="text-muted">Leave blank to keep current password</small>
                            <div class="invalid-feedback">Please provide a valid password.</div>
                        </div>
                        <div class="col-md-6 position-relative">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" id="edit_confirm_password" name="password_confirmation" class="form-control">
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
                            <i class="bi bi-save me-1"></i> Update Admin
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Dashboard Chart
    const labels = @json($labels);
    const dataValues = @json($values);

    function createChartDamagedItems(chartId, chartType, label, bgColor, borderColor) {
        const ctx = document.getElementById(chartId).getContext('2d');
        new Chart(ctx, {
            type: chartType,
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: dataValues,
                    backgroundColor: bgColor,
                    borderColor: borderColor,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
    }

    createChartDamagedItems('chart1', 'bar', 'Admin', 'rgba(54, 162, 235, 0.5)', 'rgba(54, 162, 235, 1)');

    // Dashboard Modal Functions
    function showModal(type) {
      document.getElementById('modal-' + type).style.display = 'flex';
    }
    
    function closeModal(type) {
      document.getElementById('modal-' + type).style.display = 'none';
    }
    
    // Close modal when clicking outside of it
    window.onclick = function(event) {
      const modals = document.getElementsByClassName('modal');
      for (let i = 0; i < modals.length; i++) {
        if (event.target === modals[i]) {
          modals[i].style.display = 'none';
        }
      }
    }

    // Admin Management Functions
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
        const originalEmail = input.getAttribute('data-original-email');
        const currentEmail = input.value;
        const errorSpan = document.getElementById('edit_email_error');
        
        // Skip validation if email hasn't changed
        if (originalEmail && currentEmail === originalEmail) {
            errorSpan.style.display = 'none';
            input.classList.remove('is-invalid');
            return true;
        }
        
        if (!currentEmail.endsWith('@enzconsultancy.com')) {
            errorSpan.style.display = 'block';
            input.classList.add('is-invalid');
            return false;
        } else {
            errorSpan.style.display = 'none';
            input.classList.remove('is-invalid');
            return true;
        }
    }

    function openEditModal(admin) {
        document.getElementById('edit_employee_id').value = admin.id;
        document.getElementById('edit_first_name').value = admin.first_name || '';
        document.getElementById('edit_last_name').value = admin.last_name || '';
        document.getElementById('edit_employee_number').value = admin.employee_number || '';
        document.getElementById('edit_department').value = admin.department || '';
        document.getElementById('edit_hire_date').value = admin.hire_date || '';
        document.getElementById('edit_email').value = admin.users?.email || '';
        
        // Store the original email in a data attribute
        document.getElementById('edit_email').setAttribute('data-original-email', admin.users?.email || '');
        
        document.getElementById('edit_password').value = ''; // Clear password fields
        document.getElementById('edit_confirm_password').value = '';
        
        document.getElementById('editEmployeeForm').action = `/admin/update/${admin.id}`;

        // Clear any previous validation errors
        const invalidInputs = document.querySelectorAll('#editEmployeeForm .is-invalid');
        invalidInputs.forEach(input => input.classList.remove('is-invalid'));
        
        new bootstrap.Modal(document.getElementById('editEmployeeModal')).show();
    }

    function validateEditForm() {
        // Reset all invalid states
        const requiredInputs = document.querySelectorAll('#editEmployeeForm input[required]');
        let isValid = true;
        
        requiredInputs.forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });

        // Validate email format only if it has changed
        const emailInput = document.getElementById('edit_email');
        const originalEmail = emailInput.getAttribute('data-original-email');
        const currentEmail = emailInput.value;
        
        if (currentEmail !== originalEmail) {
            const emailValid = validateEditEmail(emailInput);
            if (!emailValid) isValid = false;
        }

        // Validate password match only if password fields are not empty
        const password = document.getElementById("edit_password").value;
        const confirmPassword = document.getElementById("edit_confirm_password").value;
        const errorSpan = document.getElementById("edit_password_error");

        if (password || confirmPassword) {
            if (password !== confirmPassword) {
                errorSpan.style.display = "block";
                document.getElementById("edit_confirm_password").classList.add('is-invalid');
                isValid = false;
            } else {
                errorSpan.style.display = "none";
                document.getElementById("edit_confirm_password").classList.remove('is-invalid');
            }
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
            text: "Are you sure you want to update this admin's details?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3a7bd5",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, update it!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Updating Admin",
                    html: '<div class="spinner-border text-primary my-3" role="status"><span class="visually-hidden">Loading...</span></div><p>Please wait while we update the admin record...</p>',
                    showConfirmButton: false,
                    allowOutsideClick: false
                });

                // Send email notification with CSRF protection
                fetch('/send-mail', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Email sent:', data);
                    // Show success message if needed
                    if (data.message) {
                        Swal.showValidationMessage(data.message);
                    }
                    // Proceed with form submission
                    setTimeout(() => {
                        document.getElementById('editEmployeeForm').submit();
                    }, 1500);
                })
                .catch(error => {
                    console.error('Error sending email:', error);
                    document.getElementById('editEmployeeForm').submit();
                });
            }
        });
    }

    function openAssignedModal(adminId) {
        fetch(`/employee/items/${adminId}`)
            .then(response => response.json())
            .then(assignedItems => {
                const tableBody = document.querySelector('#assignedItemsTable tbody');
                tableBody.innerHTML = '';

                if (assignedItems.length === 0) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-box-seam display-6 d-block mb-2"></i>
                                No assets assigned to this admin
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
            html: `You are about to mark this admin as <strong>${newStatus}</strong>. Continue?`,
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
                    html: '<div class="spinner-border text-primary my-3" role="status"><span class="visually-hidden">Loading...</span></div><p>Updating admin status...</p>',
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
            title: "Add New Admin?",
            text: "Please confirm all details are correct before proceeding.",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3a7bd5",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, add admin",
            cancelButtonText: "Review details"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Creating Admin",
                    html: '<div class="spinner-border text-primary my-3" role="status"><span class="visually-hidden">Loading...</span></div><p>Setting up the new admin record...</p>',
                    showConfirmButton: false,
                    allowOutsideClick: false
                });

                // Send email notification with CSRF protection
                fetch('/send-mail', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Email sent:', data);
                    // Show success message if needed
                    if (data.message) {
                        Swal.showValidationMessage(data.message);
                    }
                    // Proceed with form submission
                    setTimeout(() => {
                        form.submit();
                    }, 1500);
                })
                .catch(error => {
                    console.error('Error sending email:', error);
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