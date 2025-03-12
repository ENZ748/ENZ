<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Users</h1>

    <a href="{{ route('employee.create') }}">Add Employee</a>
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
                <a href="{{ route('employee.edit', $employee->id) }}">Edit</a>
                 
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>