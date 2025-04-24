@extends('layouts.superAdminApp')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container mx-auto px-4 py-8">
    <!-- Top Section: Card and Chart -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-16">
        <!-- Admin Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 cursor-pointer h-40" 
                 onclick="showModal('items')">
                <div class="p-4 flex items-center h-full">
                    <div class="bg-blue-100 p-3 rounded-full mr-4">
                        <span class="text-blue-600 text-xl">👤</span>
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
                    Add Admin
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
                <div class="alert alert-warning">No admins found.</div>
            @else
                <div class="table-responsive">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">First Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee Number</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hire Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($admins as $admin)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $admin->first_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $admin->last_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $admin->employee_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $admin->department }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $admin->hire_date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">    
                                        <form action="{{ route('admin.toggleStatus', $admin->id) }}" method="POST" class="status-form">
                                            @csrf
                                            @method('PATCH')
                                            <button type="button" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $admin->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                                                onclick="confirmStatusChange(this)">
                                                {{ $admin->active ? 'Active' : 'Inactive' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 mr-3" onclick="openEditModal({{ $admin }})">Edit</button>
                                        <button class="text-blue-600 hover:text-blue-900" onclick="openAssignedModal({{ $admin->id }})">View</button>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addEmployeeForm" method="POST" action="{{ route('admin.store') }}" onsubmit="return confirmAddEmployee(event)">
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
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" id="confirm_password" name="password_confirmation" class="form-control" required>
                        <span id="password_error" class="text-danger" style="display: none;">⚠ Passwords do not match.</span>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Admin</button>
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
                <h5 class="modal-title">Edit Admin</h5>
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
                    <button type="button" class="btn btn-primary" onclick="confirmUpdate()">Update Admin</button>
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
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Unit</th>
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
    function openEditModal(admin) {
        document.getElementById('edit_employee_id').value = admin.id;
        document.getElementById('edit_first_name').value = admin.first_name;
        document.getElementById('edit_last_name').value = admin.last_name;
        document.getElementById('edit_employee_number').value = admin.employee_number;
        document.getElementById('edit_department').value = admin.department;
        document.getElementById('edit_hire_date').value = admin.hire_date;
        document.getElementById('editEmployeeForm').action = `/admin/update/${admin.id}`;
        new bootstrap.Modal(document.getElementById('editEmployeeModal')).show();
    }

    function confirmUpdate() {
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to update this admin's details?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, update it!"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Updating...",
                    text: "Please wait while processing your request.",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                setTimeout(() => {
                    Swal.fire({
                        title: "Success!",
                        text: "Admin details have been updated.",
                        icon: "success",
                        confirmButtonColor: "#3085d6"
                    }).then(() => {
                        document.getElementById('editEmployeeForm').submit();
                    });
                }, 2000);
            }
        });
    }

    function openAssignedModal(adminId) {
        fetch(`/employee/items/${adminId}`)
            .then(response => response.json())
            .then(assignedItems => {
                const tableBody = document.querySelector('#assignedItemsTable tbody');
                tableBody.innerHTML = '';

                assignedItems.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.equipment_category}</td>
                        <td>${item.equipment_brand}</td>
                        <td>${item.equipment_unit}</td>
                        <td>${item.equipment_serialNumber}</td>
                    `;
                    tableBody.appendChild(row);
                });

                new bootstrap.Modal(document.getElementById('editAssignedModal')).show();
            });
    }

    function confirmStatusChange(button) {
        Swal.fire({
            title: "Are you sure?",
            text: "You are about to change the admin's status!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, change it!"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Processing...",
                    text: "Please wait",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                setTimeout(() => {
                    Swal.fire({
                        title: "Success!",
                        text: "Admin status has been updated.",
                        icon: "success",
                        confirmButtonColor: "#3085d6"
                    }).then(() => {
                        button.closest('form').submit();
                    });
                }, 2000);
            }
        });
    }

    function validatePassword() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirm_password").value;
        var errorSpan = document.getElementById("password_error");

        if (password !== confirmPassword) {
            errorSpan.style.display = "block";
            return false;
        } else {
            errorSpan.style.display = "none";
            return true;
        }
    }

    function confirmAddEmployee(event) {
        event.preventDefault();

        if (!validatePassword()) {
            return;
        }

        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to add this admin?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, add admin!"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Processing...",
                    text: "Please wait while we add the admin.",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                setTimeout(() => {
                    Swal.fire({
                        title: "Success!",
                        text: "Admin has been added successfully.",
                        icon: "success",
                        confirmButtonColor: "#3085d6"
                    }).then(() => {
                        document.getElementById('addEmployeeForm').submit();
                    });
                }, 2000);
            }
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection