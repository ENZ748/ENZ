@extends('layouts.app') <!-- Extend the master layout -->

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-5xl">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Inventory Management</h1>

            <div class="container">
                <div class="search-container">
                    <input class="input" type="text">
                    <svg viewBox="0 0 24 24" class="search__icon">
                    <g>
                    <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z">
                     </path>
                    </g>
                    </svg>
                </div>
            </div>

        <div class="flex justify-end mb-4">
            <a href="{{ route('equipment.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Add Equipment</a>
        </div>
        
        <div class="flex justify-end mb-4">
            <a href="{{ route('equipment.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Add Category</a>
=======
            <div class="text-sm mb-2">
                <span class="text-gray-600">Assigned to:</span>
                <span class="text-green-500">
                    @php 
                        // Assuming $assigned_items is a collection of assigned items
                        $assignedItem = $assigned_items->firstWhere('itemID', $item->id); // or another way to find the related assigned item

                        if ($item->equipment_status == 1 && $assignedItem) {
                            $user = $assignedItem->employee->employee_number;
                        } else {
                            $user = 'None';
                        }
                    @endphp
                    {{ $user }}
                </span>
            </div>


            <div class="text-sm mb-2">
                <span class="text-gray-600">Date Purchased:</span>
                <span class="text-blue-500">{{ $datePurchased->format('Y-m-d') }}</span>
            </div>

            <div class="text-sm mb-2">
                <span class="text-gray-600">Date Acquired:</span>
                <span class="text-blue-500">{{ $dateAcquired->format('Y-m-d') }}</span>
            </div>

            <a href="{{ route('items.edit',$item->id) }}" class="btn btn-primary mb-4 px-4 py-2 bg-blue-500 text-white rounded-lg">Edit</a>
            <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this equipment?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">DELETE</button>
            </form>
              
        </div>

        @if($equipments->isEmpty())
            <p class="text-center text-gray-600">No equipment available.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($equipments as $equipment)
                <div class="bg-white p-6 rounded-lg shadow border">
                    <h2 class="text-lg font-semibold text-gray-800">{{ $equipment->equipment_name }}</h2>
                    <p class="text-gray-600">Serial: {{ $equipment->serial_number }}</p>
                    <p class="text-gray-600">Details: {{ $equipment->equipment_details }}</p>
                    <p class="text-gray-600">Purchased: {{ $equipment->date_purchased }}</p>
                    <p class="text-gray-600">Acquired: {{ $equipment->date_acquired }}</p>
                    <p class="text-gray-600">Status: {{ $equipment->equipment_status == 1 ? 'Unavailable' : 'Available' }}</p>

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
        @endif
    </div>

<style>
        /* From Uiverse.io by Smit-Prajapati */ 
    .container {
    position: relative;
    background: linear-gradient(135deg,rgb(0, 116, 232) 0%,rgb(0, 116, 232) 100%);
    border-radius: 1000px;
    padding: 10px;
    display: grid;
    place-content: center;
    z-index: 0;
    max-width: 300px;
    margin: 0 5px;
    }

    .search-container {
    position: relative;
    width: 100%;
    border-radius: 50px;
    background: linear-gradient(135deg,#5F8FA5(218, 232, 247) 0%, #5F8FA5(214, 229, 247) 100%);
    padding: 5px;
    display: flex;
    align-items: center;
    }

    .search-container::after, .search-container::before {
    content: "";
    width: 100%;
    height: 100%;
    border-radius: inherit;
    position: absolute;
    }

    .search-container::before {
    top: -1px;
    left: -1px;
    background: linear-gradient(0deg, #5F8FA5(218, 232, 247) 0%, #5F8FA5(255, 255, 255) 100%);
    z-index: -1;
    }

    .search-container::after {
    bottom: -1px;
    right: -1px;
    background: linear-gradient(0deg,#5F8FA5(163, 206, 255) 0%, #5F8FA5(211, 232, 255) 100%);
    box-shadow: rgba(79, 156, 232, 0.7019607843) 3px 3px 5px 0px, rgba(79, 156, 232, 0.7019607843) 5px 5px 20px 0px;
    z-index: -2;
    }

    .input {
    padding: 10px;
    width: 100%;
    background: linear-gradient(135deg, #5F8FA5(218, 232, 247) 0%, #5F8FA5(214, 229, 247) 100%);
    border: none;
    color:rgb(0, 0, 0);
    font-size: 20px;
    border-radius: 50px;
    }

    .input:focus {
    outline: none;
    background: linear-gradient(135deg, #5F8FA5(239, 247, 255) 0%, #5F8FA5(214, 229, 247) 100%);
    }

    .search__icon {
    width: 50px;
    aspect-ratio: 1;
    border-left: 2px solid white;
    border-top: 3px solid transparent;
    border-bottom: 3px solid transparent;
    border-radius: 50%;
    padding-left: 12px;
    margin-right: 10px;
    }

    .search__icon:hover {
    border-left: 3px solid white;
    }

    .search__icon path {
    fill: white;
    }
</style>

    <script src="https://cdn.tailwindcss.com"></script>
@endsection