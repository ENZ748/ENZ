<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Update</h1>

    <form action="{{route('equipment.update', $equipment->id)}}" method="POST">
        @csrf
        @method('PUT')

        <label for="">Equipment Name</label>
        <input type="text" name= "equipment_name" value="{{$equipment->equipment_name}}" required>
       
        <label for="">Serial Number</label>
        <input type="text" name= "serial_number" value="{{$equipment->serial_number}}" required>
       
        <label for="">Equipment Detail</label>
        <input type="text" name= "equipment_details" value="{{$equipment->equipment_details}}" required>
      
        <label for="">Date Purchased</label>
        <input type="date" name= "date_purchased" value="{{$equipment->date_purchased}}" required>
     
        <label for="">Date Acquired</label>
        <input type="date" name= "date_acquired" value="{{$equipment->date_acquired}}" required>

        <button type="submit">Add Equipment</button>
    </form>
</body>
</html>