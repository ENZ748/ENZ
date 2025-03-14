<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign</title>
</head>
<body>
<div class = "background"></class> 
    <h1 class="text-3xl font-bold text-blue-800 mb-6">ASSIGNED ITEMS</h1>
    <a href="{{ route('accountability.create')}}"class=button>Add</a>
    <table class="table">
    

        <thead class="bg-blue-800 text-white">
            <th>First Name</th>
            <th>Last Name</th>
            <th>Employee Number</th>
            <th>Equipment Name</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach($assigned_items as $item)
                <tr class="border-b hover:bg-gray-100">
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

    <style>
        .background{
            margin:0px;
            padding: 250px;;
            font-family: sans-serif;
            background: linear-gradient(#30142b, #2772a1);

        }
        .table{

            width: 520px;
            height: 20vh;
            grid-template-columns: 1fr 1fr;
            border: 3px solid #00ffff;
            box-shadow: 0 0 50px 0 #00a6bc;
        }

        .button{
        position: relative;
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        text-decoration: none;
        text-transform: uppercase;
        overflow: hidden;
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
</body>
</html>
