<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Users</h1>

        <table border="1">
            <thead>
                <tr>
                    
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Employee Number</th>
                    <th>Department</th>
                    <th>Hire Date</th>
                    <th>Status</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                <tr>
                    <td>{{ $employee->first_name }}</td>
                    <td>{{ $employee->last_name }}</td>
                    <td>{{ $employee->employee_number }}</td>
                    <td>{{ $employee->department }}</td>
                    <td>{{ $employee->hire_date }}</td>
                    <td>{{ $employee->active }}</td>

                    <td>
                    <a href="{{ route('employee.edit', $employee->id) }}">Assign</a>
                    
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <form action="">

            @csrf

            <label for="">Employee</label>

            <select name="employee_number">
                <option value="">Select
                    @foreach($employees as $employee)
                        <option value="$employee->{{$employee->id}}">{{$employee->employee_number}}</option>
                    @endforeach
                </option>
            </select>

            <label for="">Equipment</label>
             
            <select name="equipment_name">
                <option value="">Select Equipment</option>
                    @foreach($equipments as $equipment)
                        <option value="">{{$equipment->equipment_name}}</option>
                    @endforeach
            </select>

            <label for="">Assigned Date</label>
            <input type="date" name="assigned_date">

            <label for="">Return Date</label>
            <input type="date" name="return_date">

            <label for="">Assigned By</label>
            <select name="assigned_by">
                <option value="IT" {{ $assigned_by->assigned_by== 'IT' ? 'selected' : ''}} >IT</option>
                <option value="HR" {{ $assigned_by->assigned_by== 'IT' ? 'selected' : ''}}>IT >HR</option>
            </select>
            <button type="submit">Assign</button>

        </form>
</body>
</html>