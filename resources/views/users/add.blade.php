<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Add</h1>

    <form action="{{route('employee.store')}}" method="POST">
        @csrf
       
        <label for="">First Name</label>
        <input type="text" name= "first_name" required>
       
        <label for="">Last Name</label>
        <input type="text" name= "last_name" required>
       
        <label for="">Employee Number</label>
        <input type="text" name= "employee_number" required>
      
        <label for="">Department</label>
        <input type="text" name= "department" required>
     
        <label for=""> Hire Date</label>
        <input type="date" name= "hire_date" required>

        <button type="submit">Add Employee</button>
    </form>
</body>
</html>