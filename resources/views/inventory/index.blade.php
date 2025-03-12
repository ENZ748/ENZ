<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Inventory Management</h1>

    <a href="{{ route('equipment.create') }}">Add Equipment</a>
    <table border="1">
        <thead>
            <tr>
                <th>Equipment Name</th>
                <th>Serial Number</th>
                <th>Equipment Details</th>
                <th>Date Purchased</th>
                <th>Date Acquired</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($equipments as $equipment)
            <tr>
                <td>{{ $equipment->equipment_name }}</td>
                <td>{{ $equipment->serial_number }}</td>
                <td>{{ $equipment->equipment_details }}</td>
                <td>{{ $equipment->date_purchased }}</td>
                <td>{{ $equipment->date_acquired }}</td>
                <td>
                <a href="{{ route('equipment.edit', $equipment->id) }}">Edit</a>

                <td>
                   <form action="{{ route('equipment.destroy', $equipment->id) }}" method ="POST" onsubmit="return confirm('Are you sure you want to delete this equipment');">
                        @csrf   
                        @method('DELETE')
                        <button type="submit">DELETE</button>
 
                   </form>
                </td>

                <td>
                    <a href="{{ route('assign.add',$equipment->id)}}">Assign</a>
                </td>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>