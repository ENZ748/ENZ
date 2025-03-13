<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign</title>
</head>
<body>
    <h1>Assigned Items</h1>
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
</body>
</html>
