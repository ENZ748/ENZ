@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-blue-800 mb-6">EMPLOYEE</h1>
        <a href="{{ route('employee.create') }}" class=button>Add Employee</a>

        <table class="table">
                <thead class="bg-blue-800 text-white">
                    <tr>
                        <th class="py-3 px-4">First Name</th>
                        <th class="py-3 px-4">Last Name</th>
                        <th class="py-3 px-4">Employee Number</th>
                        <th class="py-3 px-4">Department</th>
                        <th class="py-3 px-4">Hire Date</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-4">{{ $employee->first_name }}</td>
                        <td class="py-3 px-4">{{ $employee->last_name }}</td>
                        <td class="py-3 px-4">{{ $employee->employee_number }}</td>
                        <td class="py-3 px-4">{{ $employee->department }}</td>
                        <td class="py-3 px-4">{{ $employee->hire_date }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 text-sm font-semibold rounded {{ $employee->active ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                {{ $employee->active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <a href="{{ route('employee.edit', $employee->id) }}" class="text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <style>
        .background{
            margin:0;
            padding: 160px;;
            font-family: sans-serif;
            background: linear-gradient(#30142b, #2772a1);

        }

        .table{
            width: 1000px;
            height: 20vh;
            grid-template-columns: 1fr 1fr;
            border: 3px solid #00ffff;
            box-shadow: 0 0 50px 0 #00a6bc;
        }

        .button{
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
        letter-spacing: 4px
        }

        .button{     
        background: #2772a1;
        font: 6px;;
        color: #fff;
        border-radius: 0px;
        box-shadow: 0 0 5px #00a6bc,
                    0 0 10px #00a6bc,
                    0 0 10px #00a6bc,
                    0 0 20px #00a6bc;
        }
        

        </style>
@endsection