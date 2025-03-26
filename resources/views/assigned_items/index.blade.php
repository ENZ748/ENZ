@extends('layouts.app')

@section('content')
    <h1>Assigned Items</h1>
    <a href="{{ route('assigned_items.create') }}" class="btn btn-primary">Assign New Item</a>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Employee Number</th>
                <th>Item Category</th>
                <th>Item Brand</th>
                <th>Item Unit</th>
                <th>Serial Number</th>
                <th>Assigned Date</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assignedItems as $assignedItem)
                <tr>
                    <td>{{ $assignedItem->employee->first_name }}</td> <!-- Assuming you have a relationship to fetch employee name -->
                    <td>{{ $assignedItem->employee->last_name }}</td> <!-- Assuming you have a relationship to fetch employee name -->
                    <td>{{ $assignedItem->employee->employee_number }}</td> <!-- Assuming you have a relationship to fetch employee name -->
                    <td>{{ $assignedItem->item->category->category_name }}</td> <!-- Assuming you have a relationship to fetch item name -->
                    <td>{{ $assignedItem->item->brand->brand_name }}</td> <!-- Assuming you have a relationship to fetch item name -->
                    <td>{{ $assignedItem->item->unit->unit_name }}</td> <!-- Assuming you have a relationship to fetch item name -->
                    <td>{{ $assignedItem->item->serial_number }}</td> <!-- Assuming you have a relationship to fetch item name -->
                    <td>{{ $assignedItem->assigned_date }}</td>
                    <td>{{ $assignedItem->notes }}</td>
                    <td>
                        <a href="{{ route('assigned_items.edit', $assignedItem->id) }}" class="btn btn-warning">Edit</a>
                        <!-- Add a delete button if needed -->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
