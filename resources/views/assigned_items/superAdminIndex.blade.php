@extends('layouts.superAdminApp')

@section('content')

    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Assigned Items</h1>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
                <i class="fas fa-plus mr-1"></i>Assign New Item
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Search Bar -->
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <form action="{{ route('superAdminAssigned_items.index') }}" method="GET">
                    <div class="input-group" style="width: 450px;">
                        <input type="text" name="search" class="form-control" 
                            placeholder="Search by employee, item, serial number..." 
                            value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> Search
                            </button>
                            @if(request('search'))
                                <a href="{{ route('superAdminAssigned_items.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

            
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-2"><i class="bi bi-journal-text me-2"></i>Assignment Records</h5>
                <div class="d-flex flex-wrap gap-2">
                <span class="badge bg-light text-dark border">
                    <i class="bi bi-collection me-1"></i> Total Records: {{ $assignedItems->total() }}
                </span>
                @if(request('search'))
                    <span class="badge bg-info text-white">
                    <i class="bi bi-filter-circle me-1"></i> Filtered Results
                    </span>
                @endif
                </div>
            </div>
        </div>
            
        <div id="table-view" class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee #</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Details</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial #</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned By</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Files</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($assignedItems as $assignedItem)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <div class="font-weight-bold">{{ $assignedItem->employee->first_name }} {{ $assignedItem->employee->last_name }}</div>
                                    <small class="text-muted">{{ $assignedItem->employee->department ?? 'N/A' }}</small>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">{{ $assignedItem->employee->employee_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                    <div class="font-weight-bold">{{ $assignedItem->item->category->category_name }}</div>
                                    <div class="text-muted small">
                                        {{ $assignedItem->item->brand->brand_name }} • {{ $assignedItem->item->unit->unit_name }}
                                    </div>
                                </td>
                            
                             
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500" style="color: #212529;">{{ $assignedItem->item->serial_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500" style="color: #212529;">{{ $assignedItem->assigned_by }}</td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                    {{ \Carbon\Carbon::parse($assignedItem->assigned_date)->format('M d, Y') }}
                                </td>


                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                    @if ($assignedItem->status == 0)
                                        <span class="badge badge-warning text-dark">Pending</span>
                                    @else
                                        <span class="badge badge-success text-dark">Signed</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                    @if($assignedItem->file)
                                        <div class="mb-2">
                                            <a href="{{ route('asset_files.download', ['assetSignedItem' => $assignedItem->file->id]) }}" 
                                            class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                                    Signed Asset
                                            </a>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">No files</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500" class="text-right">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button class="btn btn-outline-primary edit-btn" 
                                                data-toggle="modal" 
                                                data-target="#editModal"
                                                data-id="{{ $assignedItem->id }}"
                                                data-employee-id="{{ $assignedItem->employeeID }}"
                                                data-employee-name="{{ $assignedItem->employee->first_name }} {{ $assignedItem->employee->last_name }}"
                                                data-category-id="{{ $assignedItem->item->categoryID }}"
                                                data-brand-id="{{ $assignedItem->item->brandID }}"
                                                data-unit-id="{{ $assignedItem->item->unitID }}"
                                                data-serial-number="{{ $assignedItem->item->serial_number }}"
                                                data-notes="{{ $assignedItem->notes }}"
                                                data-assigned-date="{{ $assignedItem->assigned_date }}"
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-outline-danger" data-toggle="modal" 
                                                data-target="#returnModal" 
                                                data-id="{{ $assignedItem->id }}" 
                                                data-good="{{ route('assigned_items.superAdmingood', $assignedItem->id) }}" 
                                                data-damaged="{{ route('assigned_items.superAdmindamaged', $assignedItem->id) }}"
                                                title="Return">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500" colspan="7" class="text-center py-4">No assigned items found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(method_exists($assignedItems, 'hasPages') && $assignedItems->hasPages())
            <div class="card-footer bg-white">
                {{ $assignedItems->links() }}
            </div>
        @endif
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createModalLabel">Assign New Item</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('assigned_items.store') }}" method="POST" id="assign-item-form">
                        @csrf
                        <div class="row">
                            <!-- First Column -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="employeeID">Employee</label>
                                    <select name="employeeID" id="employeeID" class="form-control" required>
                                        <option value="">Select Employee</option>
                                        @foreach($employees as $emp)
                                            <option value="{{ $emp->id }}" 
                                                    data-first-name="{{ $emp->first_name }}"
                                                    data-last-name="{{ $emp->last_name }}">
                                                {{ $emp->employee_number }} - {{ $emp->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="employee_name">Employee Name</label>
                                    <input type="text" id="employee_name" class="form-control" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="category">Category:</label>
                                    <select id="category" name="category_id" class="form-control" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categoriesWithItems as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Second Column -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="brand">Brand Name:</label>
                                    <select id="brand" name="brand_id" class="form-control" required>
                                        <option value="">Select Brand</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="unit">Unit:</label>
                                    <select id="unit" name="unit_id" class="form-control" required>
                                        <option value="">Select Unit</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="serial_number">Serial Number:</label>
                                    <select id="serial_number" name="serial_number" class="form-control" required>
                                        <option value="">Select Serial</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Notes and Date side by side -->
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control" required rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="assigned_date">Assigned Date</label>
                                    <input type="date" name="assigned_date" id="assigned_date" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" form="assign-item-form" class="btn btn-primary">Assign Item</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editModalLabel">Edit Assigned Item</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit-assign-item-form" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- First Column -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_employeeID">Employee</label>
                                    <select name="employeeID" id="edit_employeeID" class="form-control" required>
                                        <option value="">Select Employee</option>
                                        @foreach($employees as $emp)
                                            <option value="{{ $emp->id }}" 
                                                    data-first-name="{{ $emp->first_name }}"
                                                    data-last-name="{{ $emp->last_name }}">
                                                {{ $emp->employee_number }} - {{ $emp->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="edit_employee_name">Employee Name</label>
                                    <input type="text" id="edit_employee_name" class="form-control" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="edit_category">Category:</label>
                                    <select id="edit_category" name="category_id" class="form-control" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Second Column -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_brand">Brand Name:</label>
                                    <select id="edit_brand" name="brand_id" class="form-control" required>
                                        <option value="">Select Brand</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="edit_unit">Unit:</label>
                                    <select id="edit_unit" name="unit_id" class="form-control" required>
                                        <option value="">Select Unit</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="edit_serial_number">Serial Number:</label>
                                    <select id="edit_serial_number" name="serial_number" class="form-control" required>
                                        <option value="">Select Serial</option>
                                        @foreach($items as $item)
                                            <option value="{{ $item->id }}">{{ $item->serial_number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Notes and Date side by side -->
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="edit_notes">Notes</label>
                                    <textarea name="notes" id="edit_notes" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit_assigned_date">Assigned Date</label>
                                    <input type="date" name="assigned_date" id="edit_assigned_date" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" form="edit-assign-item-form" class="btn btn-primary">Update Assignment</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Return Modal -->
    <div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="returnModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="returnModalLabel">Confirm Item Return</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-undo-alt fa-3x text-primary mb-3"></i>
                        <h5>How would you like to return this item?</h5>
                        <p class="text-muted">Please select the condition of the item being returned.</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card h-100 border-success">
                                <div class="card-body text-center">
                                    <i class="fas fa-check-circle fa-2x text-success mb-3"></i>
                                    <h5 class="card-title">Good Condition</h5>
                                    <p class="card-text text-muted small">Item is fully functional with no issues.</p>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <form id="goodForm" method="POST" class="mb-0">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-success btn-block">
                                            <i class="fas fa-check mr-2"></i>Mark as Good
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card h-100 border-danger">
                                <div class="card-body text-center">
                                    <i class="fas fa-exclamation-triangle fa-2x text-danger mb-3"></i>
                                    <h5 class="card-title">Damaged</h5>
                                    <p class="card-text text-muted small">Item has issues or requires maintenance.</p>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <form id="damagedForm" method="POST" class="mb-0">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-danger btn-block">
                                            <i class="fas fa-times mr-2"></i>Mark as Damaged
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

    <script>
        $(document).ready(function() {
            // Modal action setup
            $('#returnModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var itemId = button.data('id');
                var goodAction = button.data('good');
                var damagedAction = button.data('damaged');

                var modal = $(this);
                modal.find('#goodForm').attr('action', goodAction);
                modal.find('#damagedForm').attr('action', damagedAction);
            });

            // Edit modal setup
            $('.edit-btn').on('click', function() {
                var button = $(this);
                var id = button.data('id');
                var employeeId = button.data('employee-id');
                var employeeName = button.data('employee-name');
                var categoryId = button.data('category-id');
                var brandId = button.data('brand-id');
                var unitId = button.data('unit-id');
                var serialNumber = button.data('serial-number');
                var notes = button.data('notes');
                var assignedDate = button.data('assigned-date');

                var modal = $('#editModal');
                modal.find('form').attr('action', 'superAdmin/assigned_items/' + id);
                modal.find('#edit_employeeID').val(employeeId);
                modal.find('#edit_employee_name').val(employeeName);
                modal.find('#edit_category').val(categoryId);
                modal.find('#edit_brand').val(brandId);
                modal.find('#edit_unit').val(unitId);
                modal.find('#edit_serial_number').val(serialNumber);
                modal.find('#edit_notes').val(notes);
                modal.find('#edit_assigned_date').val(assignedDate);
            });

            // Employee name display for create modal
            $('#employeeID').change(function() {
                var selectedOption = $(this).find('option:selected');
                var firstName = selectedOption.data('first-name');
                var lastName = selectedOption.data('last-name');
                $('#employee_name').val(firstName + ' ' + lastName);
            });

            // Employee name display for edit modal
            $('#edit_employeeID').change(function() {
                var selectedOption = $(this).find('option:selected');
                var firstName = selectedOption.data('first-name');
                var lastName = selectedOption.data('last-name');
                $('#edit_employee_name').val(firstName + ' ' + lastName);
            });

            // AJAX for category, brand, unit, serial in create modal
            $('#category').change(function() {
                var categoryId = $(this).val();
                $('#brand').empty().append('<option value="">Select Brand</option>');
                $('#unit').empty().append('<option value="">Select Unit</option>');
                $('#serial_number').empty().append('<option value="">Select Serial</option>');

                if (categoryId) {
                    $.ajax({
                        url: 'superAdmin/get-brands/create/' + categoryId,
                        type: 'GET',
                        success: function(data) {
                            if (data.length > 0) {
                                $.each(data, function(key, brand) {
                                    $('#brand').append('<option value="' + brand.id + '">' + brand.brand_name + '</option>');
                                });
                            }
                        }
                    });
                }
            });

            $('#brand').change(function() {
                var brandId = $(this).val();
                $('#unit').empty().append('<option value="">Select Unit</option>');
                $('#serial_number').empty().append('<option value="">Select Serial</option>');

                if (brandId) {
                    $.ajax({
                        url: 'superAdmin/get-units/create/' + brandId,
                        type: 'GET',
                        success: function(data) {
                            if (data.length > 0) {
                                $.each(data, function(key, unit) {
                                    $('#unit').append('<option value="' + unit.id + '">' + unit.unit_name + '</option>');
                                });
                            }
                        }
                    });
                }
            });

            $('#unit').change(function() {
                var unitId = $(this).val();
                $('#serial_number').empty().append('<option value="">Select Serial</option>');

                if (unitId) {
                    $.ajax({
                        url: 'superAdmin/get-serials/create/' + unitId,
                        type: 'GET',
                        success: function(data) {
                            if (data.length > 0) {
                                $.each(data, function(key, serial) {
                                    $('#serial_number').append('<option value="' + serial.id + '">' + serial.serial_number + '</option>');
                                });
                            }
                        }
                    });
                }
            });

            // AJAX for category, brand, unit, serial in edit modal
            $('#edit_category').change(function() {
                var categoryId = $(this).val();
                $('#edit_brand').empty().append('<option value="">Select Brand</option>');
                $('#edit_unit').empty().append('<option value="">Select Unit</option>');
                $('#edit_serial_number').empty().append('<option value="">Select Serial</option>');

                if (categoryId) {
                    $.ajax({
                        url: 'superAdmin/get-brands/create/' + categoryId,
                        type: 'GET',
                        success: function(data) {
                            if (data.length > 0) {
                                $.each(data, function(key, brand) {
                                    $('#edit_brand').append('<option value="' + brand.id + '">' + brand.brand_name + '</option>');
                                });
                            }
                        }
                    });
                }
            });

            $('#edit_brand').change(function() {
                var brandId = $(this).val();
                $('#edit_unit').empty().append('<option value="">Select Unit</option>');
                $('#edit_serial_number').empty().append('<option value="">Select Serial</option>');

                if (brandId) {
                    $.ajax({
                        url: 'superAdmin/get-units/create/' + brandId,
                        type: 'GET',
                        success: function(data) {
                            if (data.length > 0) {
                                $.each(data, function(key, unit) {
                                    $('#edit_unit').append('<option value="' + unit.id + '">' + unit.unit_name + '</option>');
                                });
                            }
                        }
                    });
                }
            });

            $('#edit_unit').change(function() {
                var unitId = $(this).val();
                $('#edit_serial_number').empty().append('<option value="">Select Serial</option>');

                if (unitId) {
                    $.ajax({
                        url: 'superAdmin/get-serials/create/' + unitId,
                        type: 'GET',
                        success: function(data) {
                            if (data.length > 0) {
                                $.each(data, function(key, serial) {
                                    $('#edit_serial_number').append('<option value="' + serial.id + '">' + serial.serial_number + '</option>');
                                });
                            }
                        }
                    });
                }
            });

            // Tooltip initialization
            $('[title]').tooltip({
                placement: 'top',
                trigger: 'hover'
            });
        });
    </script>
@endsection