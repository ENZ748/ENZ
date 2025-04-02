@extends('layouts.userApp')
@section('content')
<body>
<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">User Assets</h1>
        
        <!-- Current Assets Section -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-gray-700">Current Assets</h2>
                <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                    {{ count($assigned_items) }} Active
                </span>
            </div>
            
            @if(count($assigned_items) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($assigned_items as $assigned_item)
                    <div class="bg-gradient-to-br from-orange-900 to-red-900 rounded-xl shadow-md overflow-hidden border border-gray-100 transition hover:shadow-lg">
                            <div class="bg-gradient-to-r from-blue-600 to-blue-400 px-4 py-3">
                                <h3 class="text-lg font-semibold text-black">
                                    {{ $assigned_item->item->category->category_name }} - 
                                    {{ $assigned_item->item->brand->brand_name }}
                                </h3>
                            </div>
                            <div class="p-5 space-y-3">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="text-gray-700">{{ $assigned_item->item->unit->unit_name }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <span class="text-gray-700">SN: {{ $assigned_item->item->serial_number }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-gray-700">Assigned: {{ \Carbon\Carbon::parse($assigned_item->assigned_date)->format('M d, Y') }}</span>
                                </div>
                                
                                @if($assigned_item->notes)
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <h4 class="text-sm font-medium text-gray-500 mb-2">Notes:</h4>
                                    <p class="text-gray-600 text-sm">{{ $assigned_item->notes }}</p>
                                </div>
                                @endif
                                
                                <div class="mt-4 pt-4 border-t border-gray-100 text-right">
                                    <span class="text-xs text-gray-500">Assigned on {{ \Carbon\Carbon::parse($assigned_item->created_at)->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                    <p class="text-gray-500">No assets currently assigned.</p>
                </div>
            @endif
        </div>

        <!-- Asset History Section -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-gray-700">Asset History</h2>
                <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full">
                    {{ count($history_items) }} Returned
                </span>
            </div>
            
            @if(count($history_items) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($history_items as $history_item)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 transition hover:shadow-lg">
                            <div class="bg-gradient-to-r from-green-600 to-green-400 px-4 py-3">
                                <h3 class="text-lg font-semibold text-black">
                                    {{ $history_item->item->category->category_name }} - 
                                    {{ $history_item->item->brand->brand_name }}
                                </h3>
                            </div>
                            <div class="p-5 space-y-3">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="text-gray-700">{{ $history_item->item->unit->unit_name }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <span class="text-gray-700">SN: {{ $history_item->item->serial_number }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-gray-700">Assigned: {{ \Carbon\Carbon::parse($history_item->assigned_date)->format('M d, Y') }}</span>
                                </div>
                                
                                @if($history_item->notes)
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <h4 class="text-sm font-medium text-gray-500 mb-2">Notes:</h4>
                                    <p class="text-gray-600 text-sm">{{ $history_item->notes }}</p>
                                </div>
                                @endif
                                
                                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Returned</span>
                                    <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($history_item->created_at)->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                    <p class="text-gray-500">No asset history available.</p>
                </div>
            @endif
        </div>
    </div>
</div>
</body>

<style>
 body {
            background: linear-gradient(to right,skyblue,rgb(243, 249, 252));
        }
</style>
@endsection