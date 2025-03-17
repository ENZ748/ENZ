<<<<<<< HEAD
@extends('layouts.app')

@section('content')
    <h1>Accountability</h1>
    <a href="{{ route('accountability.create')}}">Add</a>
    <table border="1">

        <thead>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Employee Number</th>
            <th>Equipment Name</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach($assigned_items as $item)
                <tr>
                    <td>{{ $item['first_name'] }}</td>
                    <td>{{ $item['last_name'] }}</td>
                    <td>{{ $item['employee_number'] }}</td>
                    <td>{{ $item['equipment_name'] }}</td>
                    <td>
                        <a href="{{route('accountability.edit',$item['id'])}}">Edit</a>
                    </td>   
                </tr>
            @endforeach
        </tbody>
    </table>
    @endsection
=======
@extends('layouts.app') <!-- Extend the master layout -->

@section('content')
    <div class="container">
        <h1 class="text-primary">Assigned Items</h1>
        <a href="{{ route('accountability.create')}}" class="btn btn-primary mb-3">Add Item</a>
        
        @if($assigned_items->isEmpty())
            <p>No data found</p> <!-- Display this message when no data is available -->
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Employee Number</th>
                            <th>Equipment Name</th>
                            <th>Equipment Deatail</th>
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
                                    <a href="{{route('accountability.edit', $item['id'])}}" class="btn btn-sm btn-primary">Edit</a>
                                </td> 

                                <td>
                                <form action="{{ route('accountability.destroy', $item['id']) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Returned</button>
                                </form>  
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <script src="https://cdn.tailwindcss.com"></script>

@endsection
>>>>>>> 72400776f0e0117747e5abc5a27d345510702102
