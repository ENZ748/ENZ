@extends('layouts.app') <!-- Extend the master layout -->

@section('content')
    <div>
        <h1 class="text-2xl font-bold text-blue -800 mb-6 text-center">INVENTORY MANAGEMENT</h1>
        <table class="table">
        <div class="flex justify-end mb-4">
            <a href="{{ route('equipment.create') }}" class="button">ADD EQUIPMENTS</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($equipments as $equipment)
            <div class="table">
                <h2 class="bg-blue-700 text-white 50 font-family: sans-serif ">{{ $equipment->equipment_name }}</h2>
                <p class="text-gray-600">Serial: {{ $equipment->serial_number }}</p>
                <p class="text-gray-600">Details: {{ $equipment->equipment_details }}</p>
                <p class="text-gray-600">Purchased: {{ $equipment->date_purchased }}</p>
                <p class="text-gray-600">Acquired: {{ $equipment->date_acquired }}</p>
                <div class="mt-4 flex space-x-2">
                    <a href="{{ route('equipment.edit', $equipment->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Edit</a>
                    <form action="{{ route('equipment.destroy', $equipment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this equipment?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">DELETE</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        </table>
    </div>

    <style>
         .table {
            flex: text center;
            flex: table center;
            width: 100%;
            height: 20vh;
            border: 4px solid #00ffff;
            box-shadow: 0 0 20px 0 #00a6bc;
        }

       
        .button {
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
            letter-spacing: 4px;
        }

        .button {
            background: #2772a1;
            font: 6px;
            color: #fff;
            border-radius: 0px;
            box-shadow: 0 0 5px #00a6bc,
                        0 0 10px #00a6bc,
                        0 0 10px #00a6bc,
                        0 0 20px #00a6bc;
        }



        


    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    @endsection
