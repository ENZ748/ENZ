@extends('layouts.userApp') <!-- Extend the master layout -->

@section('content')

    <h1 class="text-2xl font-semibold text-gray-800 mb-4">User Page</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto bg-white border-collapse border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-gray-700">Equipment Name</th>
                    <th class="px-4 py-2 text-left text-gray-700">Serial Number</th>
                    <th class="px-4 py-2 text-left text-gray-700">Equipment Details</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through each asset and display it in a new row -->
                @foreach($assets as $asset)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2 text-gray-600">{{ $asset->equipment_name }}</td>
                        <td class="px-4 py-2 text-gray-600">{{ $asset->serial_number }}</td>
                        <td class="px-4 py-2 text-gray-600">{{ $asset->equipment_details }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
