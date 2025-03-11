<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Add</h1>

    <form action="{{route('equipment.store')}}" method="POST">
        @csrf
       
        <label for="">Equipment Name</label>
        <input type="text" name= "equipment_name" required>
       
        <label for="">Serial Number</label>
        <input type="text" name= "serial_number" required>
       
        <label for="">Equipment Detail</label>
        <input type="text" name= "equipment_details" required>
      
        <label for="">Date Purchased</label>
        <input type="date" name= "date_purchased" required>
     
        <label for="">Date Acquired</label>
        <input type="date" name= "date_acquired" required>

        <button type="submit">Add Equipment</button>
    </form>
</body>
</html>