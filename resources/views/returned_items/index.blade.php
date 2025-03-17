@extends('layouts.app') <!-- Extend the master layout -->

@section('content')
    <div class="container">
        <h1 class="text-primary">History</h1>
     
        
        @if($returned_items->isEmpty())
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
                            <th>Equipment Detail</th>
                            <th>Date</th>
                           
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($returned_items as $item)
                            <tr>
                                <td>{{ $item['first_name'] }}</td>
                                <td>{{ $item['last_name'] }}</td>
                                <td>{{ $item['employee_number'] }}</td>
                                <td>{{ $item['equipment_name'] }}</td>
                                <td>{{ $item['equipment_detail'] }}</td>
                                <td>{{$item['created_at']}}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <script src="https://cdn.tailwindcss.com"></script>

@endsection
