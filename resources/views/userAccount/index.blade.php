@extends('layouts.userApp')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">User Assets</h1>

        <!-- Current Assets Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Current Assets</h2>

            <!-- Cards for Current Assets -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($assigned_items as $assigned_item)
                    <div class="bg-gradient-to-r from-blue-500 via-blue-400 to-blue-300 p-4 rounded-xl shadow-lg transform transition hover:scale-105 hover:shadow-2xl">
                        <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200">
                            <h3 class="text-lg font-semibold text-blue-800 mb-4">Item Details</h3>
                            <div class="space-y-2">
                                <p><strong class="text-gray-600">Item Category:</strong> {{ $assigned_item->item->category->category_name }}</p>
                                <p><strong class="text-gray-600">Item Brand:</strong> {{ $assigned_item->item->brand->brand_name }}</p>
                                <p><strong class="text-gray-600">Item Unit:</strong> {{ $assigned_item->item->unit->unit_name }}</p>
                                <p><strong class="text-gray-600">Serial Number:</strong> {{ $assigned_item->item->serial_number }}</p>
                                <p><strong class="text-gray-600">Assigned Date:</strong> {{ $assigned_item->assigned_date }}</p>
                                <p><strong class="text-gray-600">Notes:</strong> {{ $assigned_item->notes }}</p>
                                <p><strong class="text-gray-600">Assigned On:</strong> {{ $assigned_item->created_at }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <br><br>

        <!-- Asset History Section -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Asset History</h2>

            <!-- Cards for Asset History -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($history_items as $history_item)
                    <div class="bg-gradient-to-r from-green-500 via-green-400 to-green-300 p-4 rounded-xl shadow-lg transform transition hover:scale-105 hover:shadow-2xl">
                        <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200">
                            <h3 class="text-lg font-semibold text-green-800 mb-4">Asset History</h3>
                            <div class="space-y-2">

                                <p><strong class="text-gray-600">Item Category:</strong> {{ $history_item->item->category->category_name }}</p>
                                <p><strong class="text-gray-600">Item Brand:</strong> {{ $history_item->item->brand->brand_name }}</p>
                                <p><strong class="text-gray-600">Item Unit:</strong> {{ $history_item->item->unit->unit_name }}</p>
                                <p><strong class="text-gray-600">Serial Number:</strong> {{ $history_item->item->serial_number }}</p>
                                <p><strong class="text-gray-600">Assigned Date:</strong> {{ $history_item->assigned_date }}</p>
                                <p><strong class="text-gray-600">Notes:</strong> {{ $history_item->notes }}</p>
                                <p><strong class="text-gray-600">Returned On:</strong> {{ $history_item->created_at }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script src="https://cdn.tailwindcss.com"></script>

@endsection
