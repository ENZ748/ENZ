@extends('layouts.userApp')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">User Assets</h1>

        <!-- Assets Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Current Assets</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($assets as $asset)
                    <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-300 hover:shadow-xl transition-shadow duration-300">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $asset->equipment_name }}</h3>
                        <p class="text-gray-600"><strong>Serial Number:</strong> {{ $asset->serial_number }}</p>
                        <p class="text-gray-600"><strong>Details:</strong> {{ $asset->equipment_details }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <br>
        <br>
        <!-- Asset History Section -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Asset History</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($assets_history as $old_assets)
                    <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-300 hover:shadow-xl transition-shadow duration-300">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $old_assets->equipment_name }}</h3>
                        <p class="text-gray-600"><strong>Serial Number:</strong> {{ $old_assets->serial_number }}</p>
                        <p class="text-gray-600"><strong>Details:</strong> {{ $old_assets->equipment_details }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
