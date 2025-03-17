@extends('layouts.app') <!-- Extend the master layout -->

@section('content')
    <h1>ASSIGNED ITEMS</h1>
    <href class ="background">
    <a href="{{ route('accountability.create')}}"class="button">ADD</a>
    <table class="table w-full">

    <h2 class="bg-blue-700 text-white 50 font-family: sans-serif"></h2>
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
    </class>
    <style>
        .background {
            font-family: sans-serif;
            background: linear-gradient(#30142b, #2772a1);
        }
        
        table {
            width: 100%;
            height: 20vh;
            grid-template-columns: 1fr 1fr;
            border: 3px solid #00ffff;
            box-shadow: 0 0 50px 0 #00a6bc;
        }
        .button {
            position: relative;
            display: inline-block;
            padding: 10px 20px;
            color: #b79726;
            font-size: 16px;
            text-decoration: none;
            text-transform: uppercase;
            overflow: hidden;
            transition: .5s;
            margin-top: 5px;
            letter-spacing: 4px;
        }
        .button {
            background: #2772a1;
            font: 6px;
            color: #fff;
            border-radius: 0px;
            box-shadow: 0 0 5px #00a6bc,
                        0 0 10px #00a6bc,
                        0 0 10px #00a6bc,
                        0 0 20px #00a6bc;
        }
    </style>
    @endsection
