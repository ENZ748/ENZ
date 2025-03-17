@extends('layouts.app') <!-- Extend the master layout -->

@section('content')
    <div class="container">
        <h1 class="text-primary">Assigned Items</h1>
        <a href="{{ route('accountability.create')}}" class="btn btn-primary mb-3">Add Item</a>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Employee Number</th>
                        <th>Equipment Name</th>
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
                            <td>
                                <a href="{{route('accountability.edit',$item['id'])}}" class="btn btn-sm btn-primary">Edit</a>
                            </td>   
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
