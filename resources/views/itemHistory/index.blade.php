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
                <th>Returned Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assignedItems as $assignedItem)
                <tr>
                    <td>{{ $assignedItem->employee->first_name }}</td>
                    <td>{{ $assignedItem->employee->last_name }}</td>
                    <td>{{ $assignedItem->employee->employee_number }}</td>
                    <td>{{ $assignedItem->item->category->category_name }}</td>
                    <td>{{ $assignedItem->item->brand->brand_name }}</td>
                    <td>{{ $assignedItem->item->unit->unit_name }}</td>
                    <td>{{ $assignedItem->item->serial_number }}</td>
                    <td>{{ $assignedItem->assigned_date }}</td>
                    <td>{{ $assignedItem->notes }}</td>
                    <td>{{$assignedItem->created_at}}</td>
                   
                </tr>
            @endforeach
        </tbody>
    </table>
    
@endsection
