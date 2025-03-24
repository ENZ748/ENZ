@extends('layouts.userApp')

@section('content')
    <h1 class="text-2xl font-bold mb-4">User Assets</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <h1>Assets</h1>
        @foreach($assets as $asset)
            <div class="bg-white shadow-md rounded-lg p-4 border border-gray-200">
                <h2 class="text-lg font-semibold"><strong>Equipment:</strong> {{ $asset->equipment_name }}</h2>
                <p class="text-gray-600"><strong>Serial Number:</strong> {{ $asset->serial_number }}</p>
                <p class="text-gray-600"><strong>Details:</strong> {{ $asset->equipment_details }}</p>
            </div>
        @endforeach
    </div>


    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <h1>Asset History</h1>
        @foreach($assets_history as $old_assets)
            <div class="bg-white shadow-md rounded-lg p-4 border border-gray-200">
                <h2 class="text-lg font-semibold"><strong>Equipment:</strong> {{ $old_assets->equipment_name }}</h2>
                <p class="text-gray-600"><strong>Serial Number:</strong> {{ $old_assets->serial_number }}</p>
                <p class="text-gray-600"><strong>Details:</strong> {{ $old_assets->equipment_details }}</p>
            </div>
        @endforeach
    </div>
@endsection
