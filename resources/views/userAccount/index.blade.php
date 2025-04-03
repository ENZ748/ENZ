@extends('layouts.userApp')
@section('content')
<body>
<div class="min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="user-assets-header mb-10">
            <h1 class="text-3xl font-bold text-black mb-2 text-center">
                <i class="fas fa-laptop-house mr-2"></i>User Assets
            </h1>
            <p class="text-center text-gray-600">Manage and track your company equipment</p>
        </div>
 

 
    
 


   
 

        
        <!-- Current Assets Section -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <h2 class="text-2xl font-semibold text-gray-700">Current Assets</h2>
                    <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full ml-3">
                        {{ count($assigned_items) }} Active
                    </span>
                </div>
                
                <!-- View Toggle Buttons -->
                <div class="flex border border-gray-200 rounded-lg overflow-hidden">
                    <button id="grid-view-btn" class="px-4 py-2 bg-blue-500 text-white flex items-center">
                        <i class="fas fa-th-large mr-2"></i> Card
                    </button>
                    <button id="table-view-btn" class="px-4 py-2 bg-white text-gray-700 flex items-center">
                        <i class="fas fa-table mr-2"></i> Table
                    </button>
                </div>
            </div>
            
            @if(count($assigned_items) > 0)
                <!-- Grid View -->
                <div id="grid-view" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($assigned_items as $assigned_item)
                    <div class="rounded-xl shadow-md overflow-hidden border border-gray-100 transition hover:shadow-lg">
                            <div style="background-color: #173753;" class="px-4 py-3">
                                <h3 class="text-lg font-semibold text-white">
                                    {{ $assigned_item->item->category->category_name }} - 
                                    {{ $assigned_item->item->brand->brand_name }}
                                </h3>
                            </div>
                            <div class="p-5 space-y-3">
                                <div class="flex items-center" style="background-color: #6daedb; padding: 8px; border-radius: 4px;">
                                    <svg class="w-5 h-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="text-white">{{ $assigned_item->item->unit->unit_name }}</span>
                                </div>
                                <div class="flex items-center" style="background-color: #6daedb; padding: 8px; border-radius: 4px;">
                                    <svg class="w-5 h-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <span class="text-white">SN: {{ $assigned_item->item->serial_number }}</span>
                                </div>
                                <div class="flex items-center" style="background-color: #6daedb; padding: 8px; border-radius: 4px;">
                                    <svg class="w-5 h-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-white">Assigned: {{ \Carbon\Carbon::parse($assigned_item->assigned_date)->format('M d, Y') }}</span>
                                </div>
                                
                                @if($assigned_item->notes)
                                <div class="mt-4 pt-4 border-t border-gray-100" style="background-color: #2892d7; padding: 8px; border-radius: 4px;">
                                    <h4 class="text-sm font-medium text-white mb-2">Notes:</h4>
                                    <p class="text-white text-sm">{{ $assigned_item->notes }}</p>
                                </div>
                                @endif
                                
                                <div class="mt-4 pt-4 border-t border-gray-100 text-right" style="background-color: #1b4353; padding: 8px; border-radius: 4px;">
                                    <span class="text-xs text-white">Assigned on {{ \Carbon\Carbon::parse($assigned_item->created_at)->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Table View (Hidden by default) -->
                <div id="table-view" class="overflow-x-auto rounded-lg shadow hidden">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th style="background-color: #173753; color: white;" class="py-3 px-4 text-left">Category & Brand</th>
                                <th style="background-color: #6daedb; color: white;" class="py-3 px-4 text-left">Unit</th>
                                <th style="background-color: #6daedb; color: white;" class="py-3 px-4 text-left">Serial Number</th>
                                <th style="background-color: #2892d7; color: white;" class="py-3 px-4 text-left">Assigned Date</th>
                                <th style="background-color: #1b4353; color: white;" class="py-3 px-4 text-left">Notes</th>
                                <th style="background-color: #1d70a2; color: white;" class="py-3 px-4 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assigned_items as $assigned_item)
                            <tr class="bg-white border-b">
                                <td style="background-color: rgba(23, 55, 83, 0.1);" class="py-3 px-4">
                                    <div class="font-medium text-gray-800">{{ $assigned_item->item->category->category_name }}</div>
                                    <div class="text-sm text-gray-600">{{ $assigned_item->item->brand->brand_name }}</div>
                                </td>
                                <td style="background-color: rgba(109, 174, 219, 0.1);" class="py-3 px-4">{{ $assigned_item->item->unit->unit_name }}</td>
                                <td style="background-color: rgba(109, 174, 219, 0.1);" class="py-3 px-4">{{ $assigned_item->item->serial_number }}</td>
                                <td style="background-color: rgba(109, 174, 219, 0.1);" class="py-3 px-4">{{ \Carbon\Carbon::parse($assigned_item->assigned_date)->format('M d, Y') }}</td>
                                <td style="background-color: rgba(40, 146, 215, 0.1);" class="py-3 px-4">
                                    @if($assigned_item->notes)
                                        <span class="text-sm text-gray-600">{{ Str::limit($assigned_item->notes, 30) }}</span>
                                    @else
                                        <span class="text-xs text-gray-400">No notes</span>
                                    @endif
                                </td>
                                <td style="background-color: rgba(27, 67, 83, 0.1);" class="py-3 px-4">
                                    <button class="text-blue-500 hover:text-blue-700 mr-2">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                <div class="flex items-center">
                    <h2 class="text-2xl font-semibold text-gray-700">Asset History</h2>
                    <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full ml-3">
                        {{ count($history_items) }} Returned
                    </span>
                </div>
                
                <!-- View Toggle Buttons for History -->
                <div class="flex border border-gray-200 rounded-lg overflow-hidden">
                    <button id="history-grid-btn" class="px-4 py-2 bg-green-500 text-white flex items-center">
                        <i class="fas fa-th-large mr-2"></i> Card
                    </button>
                    <button id="history-table-btn" class="px-4 py-2 bg-white text-gray-700 flex items-center">
                        <i class="fas fa-table mr-2"></i> Table
                    </button>
                </div>
            </div>
            
            @if(count($history_items) > 0)
                <!-- Grid View for History -->
                <div id="history-grid-view" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($history_items as $history_item)
                        <div class="rounded-xl shadow-md overflow-hidden border border-gray-100 transition hover:shadow-lg">
                            <div style="background-color: #173753;" class="px-4 py-3">
                                <h3 class="text-lg font-semibold text-white">
                                    {{ $history_item->item->category->category_name }} - 
                                    {{ $history_item->item->brand->brand_name }}
                                </h3>
                            </div>
                            <div class="p-5 space-y-3">
                                <div class="flex items-center" style="background-color: #6daedb; padding: 8px; border-radius: 4px;">
                                    <svg class="w-5 h-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="text-white">{{ $history_item->item->unit->unit_name }}</span>
                                </div>
                                <div class="flex items-center" style="background-color: #6daedb; padding: 8px; border-radius: 4px;">
                                    <svg class="w-5 h-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <span class="text-white">SN: {{ $history_item->item->serial_number }}</span>
                                </div>
                                <div class="flex items-center" style="background-color: #6daedb; padding: 8px; border-radius: 4px;">
                                    <svg class="w-5 h-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-white">Assigned: {{ \Carbon\Carbon::parse($history_item->assigned_date)->format('M d, Y') }}</span>
                                </div>
                                
                                @if($history_item->notes)
                                <div class="mt-4 pt-4 border-t border-gray-100" style="background-color: #2892d7; padding: 8px; border-radius: 4px;">
                                    <h4 class="text-sm font-medium text-white mb-2">Notes:</h4>
                                    <p class="text-white text-sm">{{ $history_item->notes }}</p>
                                </div>
                                @endif
                                
                                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center" style="background-color: #1b4353; padding: 8px; border-radius: 4px;">
                                    <span class="text-xs bg-green-100 text-white px-2 py-1 rounded">Returned</span>
                                    <span class="text-xs text-white">{{ \Carbon\Carbon::parse($history_item->created_at)->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Table View for History (Hidden by default) -->
                <div id="history-table-view" class="overflow-x-auto rounded-lg shadow hidden">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th style="background-color: #173753; color: white;" class="py-3 px-4 text-left">Category & Brand</th>
                                <th style="background-color: #6daedb; color: white;" class="py-3 px-4 text-left">Unit</th>
                                <th style="background-color: #6daedb; color: white;" class="py-3 px-4 text-left">Serial Number</th>
                                <th style="background-color: #2892d7; color: white;" class="py-3 px-4 text-left">Assigned Date</th>
                                <th style="background-color: #1b4353; color: white;" class="py-3 px-4 text-left">Return Date</th>
                                <th style="background-color: #1d70a2; color: white;" class="py-3 px-4 text-left">Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($history_items as $history_item)
                            <tr class="bg-white border-b">
                                <td style="background-color: rgba(23, 55, 83, 0.1);" class="py-3 px-4">
                                    <div class="font-medium text-gray-800">{{ $history_item->item->category->category_name }}</div>
                                    <div class="text-sm text-gray-600">{{ $history_item->item->brand->brand_name }}</div>
                                </td>
                                <td style="background-color: rgba(109, 174, 219, 0.1);" class="py-3 px-4">{{ $history_item->item->unit->unit_name }}</td>
                                <td style="background-color: rgba(109, 174, 219, 0.1);" class="py-3 px-4">{{ $history_item->item->serial_number }}</td>
                                <td style="background-color: rgba(109, 174, 219, 0.1);" class="py-3 px-4">{{ \Carbon\Carbon::parse($history_item->assigned_date)->format('M d, Y') }}</td>
                                <td style="background-color: rgba(40, 146, 215, 0.1);" class="py-3 px-4">
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
                                        {{ \Carbon\Carbon::parse($history_item->created_at)->format('M d, Y') }}
                                    </span>
                                </td>
                                <td style="background-color: rgba(27, 67, 83, 0.1);" class="py-3 px-4">
                                    @if($history_item->notes)
                                        <span class="text-sm text-gray-600">{{ Str::limit($history_item->notes, 30) }}</span>
                                    @else
                                        <span class="text-xs text-gray-400">No notes</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
    background: linear-gradient(to right, #2892d7, rgb(243, 249, 252));
 }
 
 /* Table styling */
 table {
    border-collapse: separate;
    border-spacing: 0;
 }
 
 /* Column striping for readability */
 tbody tr:hover td {
    opacity: 1;
 }
 
 /* Rounded corners for tables */
 table {
    border-radius: 8px;
    overflow: hidden;
 }
 
 th:first-child {
    border-top-left-radius: 8px;
 }
 
 th:last-child {
    border-top-right-radius: 8px;
 }
 
 tr:last-child td:first-child {
    border-bottom-left-radius: 8px;
 }
 
 tr:last-child td:last-child {
    border-bottom-right-radius: 8px;
 }
 
 /* Transitions for view switching */
 #grid-view, #table-view, #history-grid-view, #history-table-view {
    transition: opacity 0.3s ease;
 }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Current Assets View Toggle
    const gridViewBtn = document.getElementById('grid-view-btn');
    const tableViewBtn = document.getElementById('table-view-btn');
    const gridView = document.getElementById('grid-view');
    const tableView = document.getElementById('table-view');
    
    gridViewBtn.addEventListener('click', function() {
        gridView.classList.remove('hidden');
        tableView.classList.add('hidden');
        gridViewBtn.classList.remove('bg-white', 'text-gray-700');
        gridViewBtn.classList.add('bg-blue-500', 'text-white');
        tableViewBtn.classList.remove('bg-blue-500', 'text-white');
        tableViewBtn.classList.add('bg-white', 'text-gray-700');
    });
    
    tableViewBtn.addEventListener('click', function() {
        gridView.classList.add('hidden');
        tableView.classList.remove('hidden');
        tableViewBtn.classList.remove('bg-white', 'text-gray-700');
        tableViewBtn.classList.add('bg-blue-500', 'text-white');
        gridViewBtn.classList.remove('bg-blue-500', 'text-white');
        gridViewBtn.classList.add('bg-white', 'text-gray-700');
    });
    
    // History Assets View Toggle
    const historyGridBtn = document.getElementById('history-grid-btn');
    const historyTableBtn = document.getElementById('history-table-btn');
    const historyGridView = document.getElementById('history-grid-view');
    const historyTableView = document.getElementById('history-table-view');
    
    historyGridBtn.addEventListener('click', function() {
        historyGridView.classList.remove('hidden');
        historyTableView.classList.add('hidden');
        historyGridBtn.classList.remove('bg-white', 'text-gray-700');
        historyGridBtn.classList.add('bg-green-500', 'text-white');
        historyTableBtn.classList.remove('bg-green-500', 'text-white');
        historyTableBtn.classList.add('bg-white', 'text-gray-700');
    });
    
    historyTableBtn.addEventListener('click', function() {
        historyGridView.classList.add('hidden');
        historyTableView.classList.remove('hidden');
        historyTableBtn.classList.remove('bg-white', 'text-gray-700');
        historyTableBtn.classList.add('bg-green-500', 'text-white');
        historyGridBtn.classList.remove('bg-green-500', 'text-white');
        historyGridBtn.classList.add('bg-white', 'text-gray-700');
    });
});
</script>
@endsection