<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Update User</h1>

    <form action="{{route('employee.update', $employee->id)}}" method="POST">
        @csrf
        @method('PUT')

        <label for="">First Name</label>
        <input type="text" name= "first_name" value="{{$employee->first_name}}" required>
       
        <label for="">Last Name</label>
        <input type="text" name= "last_name" value="{{$employee->last_name}}" required>
       
        <label for="">Employee Number</label>
        <input type="text" name= "employee_number" value="{{$employee->employee_number}}" required>
      
        <label for="">Department</label>
        <input type="text" name= "department" value="{{$employee->department}}" required>
     
        <label for=""> Hire Date</label>
        <input type="date" name= "hire_date" value="{{$employee->hire_date}}" required>

        <button type="submit">Add Employee</button>

    </form>
</body>
</html>