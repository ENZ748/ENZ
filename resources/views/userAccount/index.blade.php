@extends('layouts.userApp')
@section('content')
<body>
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Profile Header -->
        <div class="flex flex-col items-center mb-8">
            <div class="relative inline-block mb-4">
                <div class="w-28 h-28 rounded-full bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center shadow-xl">
                    <i class="fas fa-user text-5xl text-white"></i>
                </div>
                <button class="absolute bottom-0 right-0 bg-white rounded-full p-2 border-4 border-blue-100 shadow-md hover:bg-blue-50 transition-all">
                    <i class="fas fa-cog text-blue-600 text-sm"></i>
                </button>
            </div>
            
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-800 mb-2">
                    <i class="fas fa-laptop-house text-blue-600 mr-3"></i>My Assets
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl">
                    Manage and track all your assigned company equipment in one place. 
                    <span class="block text-sm text-gray-500 mt-1">Last updated: {{ now()->format('M j, Y g:i A') }}</span>
                </p>
            </div>
        </div>
 
        <!-- Current Assets Section -->
        <div class="mb-16 bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between p-6 border-b">
                <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-6 mb-4 md:mb-0">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                        <span class="w-3 h-3 bg-blue-500 rounded-full mr-3"></span>
                        Current Assets
                    </h2>
                    <div class="flex items-center space-x-4">
                        <span class="bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full">
                            {{ count($assigned_items) }} Active Items
                        </span>
                        <a href="{{ route('generatePDF') }}" 
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download Form
                        </a>
                    </div>
                </div>
                
                <!-- View Toggle Buttons -->
                <div class="flex border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                    <button id="grid-view-btn" class="px-4 py-2 bg-blue-600 text-white flex items-center transition-all">
                        <i class="fas fa-th-large mr-2"></i> Card View
                    </button>
                    <button id="table-view-btn" class="px-4 py-2 bg-white text-gray-700 flex items-center hover:bg-gray-50 transition-all">
                        <i class="fas fa-table mr-2"></i> Table View
                    </button>
                </div>
            </div>
            
            @if(count($assigned_items) > 0)
                <!-- Grid View -->
                <div id="grid-view" class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($assigned_items as $assigned_item)
                    <div class="rounded-xl shadow-md overflow-hidden border border-gray-100 transition-all hover:shadow-xl hover:-translate-y-1">
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-5 py-4">
                            <div class="flex justify-between items-start">
                                <h3 class="text-lg font-semibold text-white">
                                    {{ $assigned_item->item->category->category_name }}
                                </h3>
                                <span class="bg-white bg-opacity-20 text-white text-xs px-2 py-1 rounded-full">
                                    {{ $assigned_item->item->unit->unit_name }}
                                </span>
                            </div>
                            <p class="text-blue-100 text-sm">{{ $assigned_item->item->brand->brand_name }}</p>
                        </div>
                        <div class="p-5 space-y-4 bg-white">
                            <div class="flex items-center space-x-3">
                                <div class="bg-blue-100 p-2 rounded-full">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Serial Number</p>
                                    <p class="font-medium text-gray-800">{{ $assigned_item->item->serial_number }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-3">
                                <div class="bg-blue-100 p-2 rounded-full">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Assigned Date</p>
                                    <p class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($assigned_item->assigned_date)->format('M d, Y') }}</p>
                                </div>
                            </div>
                            
                            @if($assigned_item->notes)
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-blue-100 p-2 rounded-full">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Notes</p>
                                        <p class="text-sm text-gray-700">{{ $assigned_item->notes }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                                <span class="text-xs text-gray-500">Asset ID: {{ $assigned_item->item->id }}</span>
                                <button class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                                    Details <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Table View (Hidden by default) -->
                <div id="table-view" class="hidden overflow-x-auto p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial Number</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($assigned_items as $assigned_item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $assigned_item->item->category->category_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $assigned_item->item->brand->brand_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $assigned_item->item->unit->unit_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $assigned_item->item->serial_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($assigned_item->assigned_date)->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Active
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button class="text-blue-600 hover:text-blue-900 mr-3">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-gray-600 hover:text-gray-900">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No assets assigned</h3>
                    <p class="mt-1 text-sm text-gray-500">You don't currently have any assets assigned to you.</p>
                    <div class="mt-6">
                        <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Request Equipment
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Asset History Section -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mt-12">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between p-6 border-b">
                <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-6 mb-4 md:mb-0">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                        <span class="w-3 h-3 bg-green-500 rounded-full mr-3"></span>
                        Asset History
                    </h2>
                    <div class="flex items-center space-x-4">
                        <span class="bg-green-100 text-green-800 text-sm font-semibold px-3 py-1 rounded-full">
                            {{ count($history_items) }} Returned Items
                        </span>
                        <a href="{{ route('AssetHistoryGeneratePDF') }}" 
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-600 to-teal-600 text-white rounded-lg hover:from-green-700 hover:to-teal-700 transition-all shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Return Form
                        </a>
                    </div>
                </div>
                
                <!-- View Toggle Buttons for History -->
                <div class="flex border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                    <button id="history-grid-btn" class="px-4 py-2 bg-green-600 text-white flex items-center transition-all">
                        <i class="fas fa-th-large mr-2"></i> Card View
                    </button>
                    <button id="history-table-btn" class="px-4 py-2 bg-white text-gray-700 flex items-center hover:bg-gray-50 transition-all">
                        <i class="fas fa-table mr-2"></i> Table View
                    </button>
                </div>
            </div>
            
            @if(count($history_items) > 0)
                <!-- Grid View for History -->
                <div id="history-grid-view" class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($history_items as $history_item)
                        <div class="rounded-xl shadow-md overflow-hidden border border-gray-100 transition-all hover:shadow-xl hover:-translate-y-1">
                            <div class="bg-gradient-to-r from-green-600 to-teal-700 px-5 py-4">
                                <div class="flex justify-between items-start">
                                    <h3 class="text-lg font-semibold text-white">
                                        {{ $history_item->item->category->category_name }}
                                    </h3>
                                    <span class="bg-white bg-opacity-20 text-white text-xs px-2 py-1 rounded-full">
                                        {{ $history_item->item->unit->unit_name }}
                                    </span>
                                </div>
                                <p class="text-green-100 text-sm">{{ $history_item->item->brand->brand_name }}</p>
                            </div>
                            <div class="p-5 space-y-4 bg-white">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-green-100 p-2 rounded-full">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Serial Number</p>
                                        <p class="font-medium text-gray-800">{{ $history_item->item->serial_number }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-3">
                                    <div class="bg-green-100 p-2 rounded-full">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Assigned Date</p>
                                        <p class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($history_item->assigned_date)->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-3">
                                    <div class="bg-green-100 p-2 rounded-full">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Returned Date</p>
                                        <p class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($history_item->created_at)->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                
                                @if($history_item->notes)
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-green-100 p-2 rounded-full">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Notes</p>
                                            <p class="text-sm text-gray-700">{{ $history_item->notes }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                                    <span class="text-xs text-gray-500">Asset ID: {{ $history_item->item->id }}</span>
                                    <button class="text-green-600 hover:text-green-800 text-sm font-medium flex items-center">
                                        Details <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Table View for History (Hidden by default) -->
                <div id="history-table-view" class="hidden overflow-x-auto p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial Number</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Returned Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($history_items as $history_item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $history_item->item->category->category_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $history_item->item->brand->brand_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $history_item->item->unit->unit_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $history_item->item->serial_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($history_item->assigned_date)->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($history_item->created_at)->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Returned
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No asset history</h3>
                    <p class="mt-1 text-sm text-gray-500">You haven't returned any assets yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Smooth transitions for all interactive elements */
    button, a, .transition-all {
        transition: all 0.2s ease-in-out;
    }
    
    /* Card hover effects */
    .hover\:-translate-y-1:hover {
        transform: translateY(-4px);
    }
    
    /* Gradient text for headers */
    .gradient-text {
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
        background-image: linear-gradient(to right, #3b82f6, #6366f1);
    }
    
    /* Custom scrollbar for tables */
    .custom-scrollbar::-webkit-scrollbar {
        height: 8px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }
    
    /* Pulse animation for empty states */
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }
    
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
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
        gridViewBtn.classList.add('bg-blue-600', 'text-white');
        tableViewBtn.classList.remove('bg-blue-600', 'text-white');
        tableViewBtn.classList.add('bg-white', 'text-gray-700');
        
        // Store preference in localStorage
        localStorage.setItem('currentAssetsView', 'grid');
    });
    
    tableViewBtn.addEventListener('click', function() {
        gridView.classList.add('hidden');
        tableView.classList.remove('hidden');
        tableViewBtn.classList.remove('bg-white', 'text-gray-700');
        tableViewBtn.classList.add('bg-blue-600', 'text-white');
        gridViewBtn.classList.remove('bg-blue-600', 'text-white');
        gridViewBtn.classList.add('bg-white', 'text-gray-700');
        
        // Store preference in localStorage
        localStorage.setItem('currentAssetsView', 'table');
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
        historyGridBtn.classList.add('bg-green-600', 'text-white');
        historyTableBtn.classList.remove('bg-green-600', 'text-white');
        historyTableBtn.classList.add('bg-white', 'text-gray-700');
        
        // Store preference in localStorage
        localStorage.setItem('historyAssetsView', 'grid');
    });
    
    historyTableBtn.addEventListener('click', function() {
        historyGridView.classList.add('hidden');
        historyTableView.classList.remove('hidden');
        historyTableBtn.classList.remove('bg-white', 'text-gray-700');
        historyTableBtn.classList.add('bg-green-600', 'text-white');
        historyGridBtn.classList.remove('bg-green-600', 'text-white');
        historyGridBtn.classList.add('bg-white', 'text-gray-700');
        
        // Store preference in localStorage
        localStorage.setItem('historyAssetsView', 'table');
    });
    
    // Check for saved view preferences
    const currentAssetsView = localStorage.getItem('currentAssetsView');
    const historyAssetsView = localStorage.getItem('historyAssetsView');
    
    if (currentAssetsView === 'table') {
        tableViewBtn.click();
    }
    
    if (historyAssetsView === 'table') {
        historyTableBtn.click();
    }
    
    // Add tooltips to action buttons
    tippy('[data-tippy-content]', {
        theme: 'light-border',
        animation: 'scale',
        duration: [200, 150],
        arrow: true
    });
});
</script>
@endsection