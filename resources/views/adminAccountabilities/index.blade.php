@extends('layouts.app')
@section('content')
<body>
<!-- Add this right after the profile header section -->
<div class="absolute top-4 right-4">
    <button id="theme-toggle" class="p-2 rounded-full bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl transition-all">
        <svg id="theme-toggle-dark-icon" class="w-5 h-5 text-gray-700 dark:text-gray-300 hidden" fill="currentColor" viewBox="0 0 20 20">
            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
        </svg>
        <svg id="theme-toggle-light-icon" class="w-5 h-5 text-gray-700 dark:text-gray-300 hidden" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
        </svg>
    </button>
</div>
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-blue-900 dark:to-indigo-900">

<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Profile Header -->
        <div class="flex flex-col items-center mb-8">
            <div>
                    <i class="fas fa-cog text-blue-600 text-sm"></i>
            </div>
            
            <div class="text-center">
                <h1 class="text-5xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-laptop-house text-blue-600 mr-3"></i>MY ASSETS
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl text-center">
                    Manage and track all your assigned company equipment in one place. 
                    <span class="block text-sm text-gray-500 mt-1">
                        Date and Time Now: 
                        <time id="philippine-time" datetime="{{ now()->setTimezone('Asia/Manila')->toIso8601String() }}">
                            {{ now()->setTimezone('Asia/Manila')->format('l, F j, Y h:i:s A') }}
                        </time>
                    </span>
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
                <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data" class="compact-upload-form">
                    @csrf
                    <div class="file-upload-box">
                        <input type="file" id="file" name="file" required class="file-input" onchange="showFileName(this)">
                        <label for="file" class="file-label">
                            <span id="fileNameDisplay" class="file-name">No file selected</span>
                            <span class="browse-btn">Choose File</span>
                        </label>
                        <button type="submit" class="upload-btn">Upload</button>
                    </div>
                </form>

                
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

                    <form action="{{ route('user_return_files.store') }}" method="POST" enctype="multipart/form-data" class="compact-upload-form">
                        @csrf
                        <div class="file-upload-box">
                            <input type="file" id="returnfile" name="returnfile" required class="file-input" onchange="returnshowFileName(this)">
                            <label for="returnfile" class="file-label">
                                <span id="returnfileNameDisplay" class="returnfile-name">No file selected</span>
                                <span class="browse-btn">Choose File</span>
                            </label>
                            <button type="submit" class="upload-btn">Upload</button>
                        </div>
                    </form>
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



<script>
    // Add this to your existing script section
    const themeToggle = document.getElementById('theme-toggle');
    const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

    // Check for saved theme preference or use system preference
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        themeToggleLightIcon.classList.remove('hidden');
    } else {
        document.documentElement.classList.remove('dark');
        themeToggleDarkIcon.classList.remove('hidden');
    }

    // Toggle button click handler
    themeToggle.addEventListener('click', function() {
        // Toggle icons
        themeToggleDarkIcon.classList.toggle('hidden');
        themeToggleLightIcon.classList.toggle('hidden');
        
        // Update localStorage and apply theme
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        }
    });
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
    // Update the time every minute
    function updatePhilippineTime() {
        const options = { 
            timeZone: 'Asia/Manila',
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        };
        
        const formatter = new Intl.DateTimeFormat('en-US', options);
        const parts = formatter.formatToParts(new Date());
        
        let formattedDate = {};
        parts.forEach(part => {
            formattedDate[part.type] = part.value;
        });
        
        const timeString = `${formattedDate.weekday}, ${formattedDate.month} ${formattedDate.day}, ${formattedDate.year} ${formattedDate.hour}:${formattedDate.minute} ${formattedDate.dayPeriod}`;
        document.getElementById('philippine-time').textContent = timeString; 
    }

    // Initial call
    updatePhilippineTime();

    // Update every minute
    setInterval(updatePhilippineTime, 60000);
</script>


<script>
    function showFileName(input) {
        const fileNameDisplay = document.getElementById('fileNameDisplay');
        if (input.files.length > 0) {
            fileNameDisplay.textContent = input.files[0].name;
            fileNameDisplay.classList.add('has-file');
        } else {
            fileNameDisplay.textContent = 'No file selected';
            fileNameDisplay.classList.remove('has-file');
        }
    }

    function returnshowFileName(input) {
        const returnfileNameDisplay = document.getElementById('returnfileNameDisplay');
        if (input.files.length > 0) {
            returnfileNameDisplay.textContent = input.files[0].name;
            returnfileNameDisplay.classList.add('has-file');
        } else {
            returnfileNameDisplay.textContent = 'No file selected';
            returnfileNameDisplay.classList.remove('has-file');
        }
    }


</script>

<style>
    .compact-upload-form {
        max-width: 400px;
        margin: 0 auto;
    }

    .file-upload-box {
        display: flex;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
    }

    .file-input {
        display: none;
    }

    .file-label {
        flex-grow: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 12px;
        background: #f8f9fa;
        cursor: pointer;
    }

    .file-name {
        color: #666;
        font-size: 14px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
    }

    .file-name.has-file {
        color: #333;
        font-weight: 500;
    }

    .browse-btn {
        background: #e9ecef;
        color: #495057;
        padding: 6px 12px;
        border-radius: 3px;
        font-size: 13px;
        border: 1px solid #ced4da;
        margin-left: 10px;
    }

    .upload-btn {
        background: #4a6bff;
        color: white;
        border: none;
        padding: 0 16px;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.2s;
    }

    .upload-btn:hover {
        background: #3a5bef;
    }
</style>
@endsection

