@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1 class="text-primary">Assigned Items</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addItemModal">Add Item</button>
    
    @if($assigned_items->isEmpty())
        <p>No data found</p>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Employee Number</th>
                        <th>Equipment Name</th>
                        <th>Equipment Detail</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assigned_items as $item)
                        <tr>
                            <td>{{ $item['first_name'] }}</td>
                            <td>{{ $item['last_name'] }}</td>
                            <td>{{ $item['employee_number'] }}</td>
                            <td>{{ $item['equipment_name'] }}</td>
                            <td>{{ $item['equipment_detail'] }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" 
                                        data-bs-target="#editItemModal{{ $item['id'] }}">Edit</button>
                                <form action="{{ route('accountability.destroy', $item['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Returned</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Item Modal -->
                        <div class="modal fade" id="editItemModal{{ $item['id'] }}" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Item</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('accountability.update', $item['id']) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <label for="employee_number">Employee</label>
                                            <input type="text" name="employee_number" class="form-control" value="{{ $item['employee_number'] }}">
                                            <label for="equipment_name">Equipment</label>
                                            <input type="text" name="equipment_name" class="form-control" value="{{ $item['equipment_name'] }}">
                                            <button type="submit" class="btn btn-primary mt-3">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Equipment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('accountability.store') }}" method="POST">
                    @csrf
                    <label for="employee_number">Employee</label>
                    <select name="employee_number" class="form-control">
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->employee_number }}">{{ $employee->employee_number }}</option>
                        @endforeach
                    </select>
                    <label for="equipment_name">Equipment</label>
                    <select name="equipment_name" class="form-control">
                        <option value="">Select Equipment</option>
                        @foreach($available_items as $available_item)
                            <option value="{{ $available_item->equipment_name }}">{{ $available_item->equipment_name }}</option>
                        @endforeach
                    </select>
                    <label for="assigned_date">Assigned Date</label>
                    <input type="date" name="assigned_date" class="form-control">
                    <label for="return_date">Return Date</label>
                    <input type="date" name="return_date" class="form-control">
                    <label for="notes">Notes</label>
                    <input type="text" name="notes" class="form-control">
                    <label for="assigned_by">Assigned By</label>
                    <select name="assigned_by" class="form-control">
                        <option value="IT">IT</option>
                        <option value="HR">HR</option>
                    </select>
                    <button type="submit" class="btn btn-primary mt-3">Assign</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
@endsection