@extends('layouts.superAdminApp')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-0">Forms</h1>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="card-body">
        <div class="d-flex justify-content-end">
            <form action="{{ route('superAdmin.assigned_items.forms') }}" method="GET">
                <div class="input-group mb-3" style="width: 460px;">
                    <input type="text" 
                           name="search" 
                           class="form-control border-0" 
                           placeholder="Search" 
                           value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                    @if(request('search'))
                        <div class="input-group-append">
                            <a href="{{ route('superAdmin.assigned_items.forms') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if($employees->isEmpty())
        <!-- Empty State Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-8 text-center">
                <div class="mx-auto h-24 w-24 text-yellow-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900">
                    @if(request('search'))
                        No matching employees found
                    @else
                        No employees in the system
                    @endif
                </h3>
                <p class="mt-2 text-sm text-gray-500">
                    @if(request('search'))
                        Try adjusting your search or filter to find what you're looking for.
                    @else
                        Employees will appear here once they have assets assigned to them.
                    @endif
                </p>
                @if(request('search'))
                    <div class="mt-6">
                        <a href="{{ route('superAdmin.assigned_items.forms') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Clear search
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @else
        <!-- Employee Table Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee Details</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Latest Signed Form</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Latest Returned Form</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">All Forms</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($employees as $employee)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <!-- Employee Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <span class="text-indigo-600 font-medium">{{ substr($employee->first_name, 0, 1) }}{{ substr($employee->last_name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $employee->first_name }} {{ $employee->last_name }}</div>
                                        <div class="text-sm text-gray-500">#{{ $employee->employee_number }}</div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Department Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-medium">{{ $employee->department }}</div>
                                <div class="text-sm text-gray-500">{{ $employee->position ?? 'Not specified' }}</div>
                            </td>
                            
                            <!-- Actions Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <!-- Accountability Button -->
                                    <button onclick="openModal('accountability-modal-{{ $employee->id }}')" 
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors group">
                                        <span class="group-hover:animate-bounce mr-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </span>
                                        Accountability
                                    </button>
                                    
                                    <!-- Return Asset Button -->
                                    <button onclick="openModal('asset-return-modal-{{ $employee->id }}')" 
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors group">
                                        <span class="group-hover:animate-pulse mr-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                            </svg>
                                        </span>
                                        Return Asset
                                    </button>
                                </div>
                            </td>
                            
                            <!-- Latest Signed Form Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($employee->files->count() > 0)
                                    @php
                                        $latestFile = $employee->files->sortByDesc('created_at')->first();
                                    @endphp
                                    <div class="flex items-center">
                                        <a href="{{ route('files.download', ['employee' => $employee->id, 'file' => $latestFile->id]) }}" 
                                           class="inline-flex items-center px-3 py-1 border border-gray-200 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:shadow-sm transition-all group">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-500 group-hover:text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                            </svg>
                                            {{ $latestFile->created_at->format('M d, Y') }}
                                        </a>
                                    </div>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                        No files
                                    </span>
                                @endif
                            </td>

                            <!-- Latest Returned Form Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($employee->returnfiles->count() > 0)
                                    @php
                                        $latestReturnFile = $employee->returnfiles->sortByDesc('created_at')->first();
                                    @endphp
                                    <div class="flex items-center">
                                        <a href="{{ route('return_files.download', ['employee' => $employee->id, 'returnFile' => $latestReturnFile->id]) }}" 
                                           class="inline-flex items-center px-3 py-1 border border-gray-200 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:shadow-sm transition-all group">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500 group-hover:text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                            </svg>
                                            {{ $latestReturnFile->created_at->format('M d, Y') }}
                                        </a>
                                    </div>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                        No files
                                    </span>
                                @endif
                            </td>

                            <!-- All Forms Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    @if($employee->files->count() > 0 || $employee->returnfiles->count() > 0)
                                        <button onclick="openModal('all-forms-modal-{{ $employee->id }}')" 
                                                class="inline-flex items-center px-3 py-1 border border-gray-200 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:shadow-sm transition-all">
                                            View All
                                        </button>
                                    @else
                                        <span class="text-gray-400 text-sm">No forms</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($employees->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    Showing {{ $employees->firstItem() }} to {{ $employees->lastItem() }} of {{ $employees->total() }} results
                </div>
                <div class="flex space-x-2">
                    {{ $employees->links() }}
                </div>
            </div>
            @endif
        </div>

        @foreach($employees as $employee)
        <!-- All Forms Modal -->
        <div id="all-forms-modal-{{ $employee->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen p-4 text-center">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
                
                <!-- Modal container -->
                <div class="relative inline-block w-full max-w-2xl text-left align-middle transform bg-white rounded-xl shadow-2xl overflow-hidden transition-all">
                    <!-- Header -->
                    <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-indigo-700 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 rounded-lg bg-indigo-700/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white">All Forms for {{ $employee->first_name }} {{ $employee->last_name }}</h2>
                                <p class="text-indigo-100 text-sm">Employee #{{ $employee->employee_number }}</p>
                            </div>
                        </div>
                        <button onclick="closeModal('all-forms-modal-{{ $employee->id }}')" class="text-white hover:text-indigo-200 transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Content -->
                    <div class="p-6 max-h-[65vh] overflow-y-auto">
                        <!-- Signed Forms Section -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Signed Accountability Forms
                                <span class="ml-auto text-sm font-medium text-gray-500">{{ $employee->files->count() }} files</span>
                            </h3>
                            
                            @if($employee->files->count() > 0)
                                <div class="space-y-3">
                                    @foreach($employee->files->sortByDesc('created_at') as $file)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span class="text-sm font-medium text-gray-700">{{ $file->created_at->format('M d, Y h:i A') }}</span>
                                        </div>
                                        <a href="{{ route('files.download', ['employee' => $employee->id, 'file' => $file->id]) }}" 
                                           class="text-blue-600 hover:text-blue-800 transition-colors flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            Download
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4 text-gray-500">
                                    No signed forms available
                                </div>
                            @endif
                        </div>

                        <!-- Returned Forms Section -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                                Returned Asset Forms
                                <span class="ml-auto text-sm font-medium text-gray-500">{{ $employee->returnfiles->count() }} files</span>
                            </h3>
                            
                            @if($employee->returnfiles->count() > 0)
                                <div class="space-y-3">
                                    @foreach($employee->returnfiles->sortByDesc('created_at') as $returnfile)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                            </svg>
                                            <span class="text-sm font-medium text-gray-700">{{ $returnfile->created_at->format('M d, Y h:i A') }}</span>
                                        </div>
                                        <a href="{{ route('return_files.download', ['employee' => $employee->id, 'returnFile' => $returnfile->id]) }}" 
                                           class="text-green-600 hover:text-green-800 transition-colors flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            Download
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4 text-gray-500">
                                    No returned forms available
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end">
                        <button onclick="closeModal('all-forms-modal-{{ $employee->id }}')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accountability Modal -->
        <div id="accountability-modal-{{ $employee->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen p-4 text-center">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
                
                <!-- Modal container -->
                <div class="relative inline-block w-full max-w-4xl text-left align-middle transform bg-white rounded-xl shadow-2xl overflow-hidden transition-all">
                    <!-- Header -->
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 rounded-lg bg-blue-700/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white">Accountability Form</h2>
                                <p class="text-blue-100 text-sm">{{ $employee->first_name }} {{ $employee->last_name }}</p>
                            </div>
                        </div>
                        <button onclick="closeModal('accountability-modal-{{ $employee->id }}')" class="text-white hover:text-blue-200 transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Content -->
                    <div class="p-6 max-h-[65vh] overflow-y-auto">
                        @if($employee->assigned_items->where('status', 0)->count() > 0)
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">Assigned Assets</h3>
                                
                                <!-- Assets Signed Files Form -->
                                <form action="{{ route('superAdminassets_signed_files.store', ['id' => $employee->id]) }}" method="POST" enctype="multipart/form-data" id="assetsSignedForm-{{ $employee->id }}">
                                    @csrf
                                    <div class="file-upload-box mb-4">
                                        <input type="file" id="assetFile-{{ $employee->id }}" name="file" required class="file-input">
                                        <label for="assetFile-{{ $employee->id }}" class="file-label">
                                            <span id="assetFileNameDisplay-{{ $employee->id }}" class="file-name">No file selected</span>
                                            <span class="browse-btn">Choose File</span>
                                        </label>
                                        <button type="submit" class="upload-btn">Upload Signed Form</button>
                                    </div>
                                </form>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($employee->assigned_items->where('status', 0) as $assigned_item)
                                        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                            <div class="p-4">
                                                <div class="flex justify-between items-start">
                                                    <h3 class="font-medium text-gray-800">{{ $assigned_item->item->category->category_name }}</h3>
                                                    <span class="inline-block px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">{{ $assigned_item->item->brand->brand_name }}</span>
                                                </div>
                                                
                                                <div class="mt-3 space-y-2">
                                                    <div class="flex items-center text-sm text-gray-600">
                                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                                        </svg>
                                                        {{ $assigned_item->item->unit->unit_name }}
                                                    </div>
                                                    <div class="flex items-center text-sm text-gray-600">
                                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                                        </svg>
                                                        {{ $assigned_item->item->serial_number }}
                                                    </div>
                                                    <div class="flex items-center text-sm text-gray-600">
                                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        Assigned: {{ \Carbon\Carbon::parse($assigned_item->assigned_date)->format('M d, Y') }}
                                                    </div>
                                                </div>
                                                
                                                @if($assigned_item->notes)
                                                    <div class="mt-3 p-3 bg-blue-50 rounded-md border border-blue-100">
                                                        <h4 class="text-xs font-semibold text-blue-700 mb-1">NOTES</h4>
                                                        <p class="text-sm text-blue-800">{{ $assigned_item->notes }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-2 text-lg font-medium text-gray-900">No pending assigned assets</h3>
                                <p class="mt-1 text-gray-500">This employee currently has no pending assets assigned to them.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-between items-center">
                        <div class="text-sm text-gray-500">
                            {{ $employee->assigned_items->where('status', 0)->count() }} items assigned
                        </div>
                        <div class="flex space-x-3">
                            <button onclick="closeModal('accountability-modal-{{ $employee->id }}')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none">
                                Cancel
                            </button>
                            @if($employee->assigned_items->where('status', 0)->count() > 0)
                                <a href="{{ route('superAdminform.confirm_accountability', $employee->id) }}" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Confirm Signature
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Asset Return Modal -->
        <div id="asset-return-modal-{{ $employee->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen p-4 text-center">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
                
                <!-- Modal container -->
                <div class="relative inline-block w-full max-w-4xl text-left align-middle transform bg-white rounded-xl shadow-2xl overflow-hidden transition-all">
                    <!-- Header -->
                    <div class="px-6 py-4 bg-gradient-to-r from-green-600 to-green-700 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 rounded-lg bg-green-700/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white">Asset Return</h2>
                                <p class="text-green-100 text-sm">{{ $employee->first_name }} {{ $employee->last_name }}</p>
                            </div>
                        </div>
                        <button onclick="closeModal('asset-return-modal-{{ $employee->id }}')" class="text-white hover:text-green-200 transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Content -->
                    <div class="p-6 max-h-[65vh] overflow-y-auto">
                        @if($employee->item_history->where('status', 0)->count() > 0)
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">Items to Return</h3>

                                <!-- Return Files Form -->
                                <form action="{{ route('superAdminformreturn_files.store', ['id' => $employee->id]) }}" method="POST" enctype="multipart/form-data" id="returnFilesForm-{{ $employee->id }}">
                                    @csrf
                                    <div class="file-upload-box mb-4">
                                        <input type="file" id="returnFile-{{ $employee->id }}" name="returnfile" required class="file-input">
                                        <label for="returnFile-{{ $employee->id }}" class="file-label">
                                            <span id="returnFileNameDisplay-{{ $employee->id }}" class="file-name">No file selected</span>
                                            <span class="browse-btn">Choose File</span>
                                        </label>
                                        <button type="submit" class="upload-btn">Upload Return Form</button>
                                    </div>
                                </form>

                                <form action="{{ route('superAdminform.asset_return', $employee->id) }}" method="POST">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($employee->item_history->where('status', 0) as $history_item)
                                            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                                <div class="p-4">
                                                    <div class="flex justify-between items-start">
                                                        <h3 class="font-medium text-gray-800">{{ $history_item->item->category->category_name }}</h3>
                                                        <span class="inline-block px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">{{ $history_item->item->brand->brand_name }}</span>
                                                    </div>
                                                    
                                                    <div class="mt-3 space-y-2">
                                                        <div class="flex items-center text-sm text-gray-600">
                                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                                            </svg>
                                                            {{ $history_item->item->unit->unit_name }}
                                                        </div>
                                                        <div class="flex items-center text-sm text-gray-600">
                                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                                            </svg>
                                                            {{ $history_item->item->serial_number }}
                                                        </div>
                                                        <div class="flex items-center text-sm text-gray-600">
                                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                            Assigned: {{ \Carbon\Carbon::parse($history_item->assigned_date)->format('M d, Y') }}
                                                        </div>
                                                        <div class="flex items-center text-sm text-gray-600">
                                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                            Returned: <span class="ml-1 px-2 py-0.5 text-xs font-medium bg-green-100 text-green-800 rounded-full">{{ \Carbon\Carbon::parse($history_item->returned_date)->format('M d, Y') }}</span>
                                                        </div>
                                                    </div>
                                                    
                                                    @if($history_item->return_notes)
                                                        <div class="mt-3 p-3 bg-green-50 rounded-md border border-green-100">
                                                            <h4 class="text-xs font-semibold text-green-700 mb-1">RETURN NOTES</h4>
                                                            <p class="text-sm text-green-800">{{ $history_item->return_notes }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-2 text-lg font-medium text-gray-900">No pending assets to return</h3>
                                <p class="mt-1 text-gray-500">This employee currently has no pending assets that need to be returned.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-between items-center">
                        <div class="text-sm text-gray-500">
                            @if($employee->item_history->where('status', 0)->count() > 0)
                                {{ $employee->item_history->where('status', 0)->count() }} items to process
                            @endif
                        </div>
                        <div class="flex space-x-3">
                            <button onclick="closeModal('asset-return-modal-{{ $employee->id }}')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none">
                                Cancel
                            </button>
                            @if($employee->item_history->where('status', 0)->count() > 0)
                                <a href="{{ route('superAdminform.confirm_return', $employee->id) }}" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Process Return
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>

<script>
    // Modal functions
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        @foreach($employees as $employee)
            if (event.target === document.getElementById('accountability-modal-{{ $employee->id }}')) {
                closeModal('accountability-modal-{{ $employee->id }}');
            }
            if (event.target === document.getElementById('asset-return-modal-{{ $employee->id }}')) {
                closeModal('asset-return-modal-{{ $employee->id }}');
            }
            if (event.target === document.getElementById('all-forms-modal-{{ $employee->id }}')) {
                closeModal('all-forms-modal-{{ $employee->id }}');
            }
        @endforeach
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            @foreach($employees as $employee)
                if (!document.getElementById('accountability-modal-{{ $employee->id }}').classList.contains('hidden')) {
                    closeModal('accountability-modal-{{ $employee->id }}');
                }
                if (!document.getElementById('asset-return-modal-{{ $employee->id }}').classList.contains('hidden')) {
                    closeModal('asset-return-modal-{{ $employee->id }}');
                }
                if (!document.getElementById('all-forms-modal-{{ $employee->id }}').classList.contains('hidden')) {
                    closeModal('all-forms-modal-{{ $employee->id }}');
                }
            @endforeach
        }
    });

    // File input handling
    document.addEventListener('DOMContentLoaded', function() {
        @foreach($employees as $employee)
            // Accountability form
            const assetFileInput{{ $employee->id }} = document.getElementById('assetFile-{{ $employee->id }}');
            
            if (assetFileInput{{ $employee->id }}) {
                assetFileInput{{ $employee->id }}.addEventListener('change', function() {
                    const fileName = this.files.length > 0 ? this.files[0].name : 'No file selected';
                    const label = this.nextElementSibling?.querySelector('.file-label-text');
                    if (label) {
                        label.textContent = fileName;
                    }
                });
            }

            // Return form
            const returnFileInput{{ $employee->id }} = document.getElementById('returnFile-{{ $employee->id }}');
            
            if (returnFileInput{{ $employee->id }}) {
                returnFileInput{{ $employee->id }}.addEventListener('change', function() {
                    const fileName = this.files.length > 0 ? this.files[0].name : 'No file selected';
                    const label = this.nextElementSibling?.querySelector('.file-label-text');
                    if (label) {
                        label.textContent = fileName;
                    }
                });
            }

            // Form validation
            document.getElementById('assetsSignedForm-{{ $employee->id }}')?.addEventListener('submit', function(e) {
                if (!assetFileInput{{ $employee->id }}.files.length) {
                    e.preventDefault();
                    alert('Please select a file to upload for Accountability');
                }
            });

            document.getElementById('returnFilesForm-{{ $employee->id }}')?.addEventListener('submit', function(e) {
                if (!returnFileInput{{ $employee->id }}.files.length) {
                    e.preventDefault();
                    alert('Please select a file to upload for Return Asset');
                }
            });
        @endforeach
    });
</script>

<style>
    .file-upload-box {
        display: flex;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
        margin-bottom: 15px;
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

    /* Modal transitions */
    .modal-transition {
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    /* Asset card styling */
    .asset-card {
        transition: all 0.3s ease;
    }
    
    .asset-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
</style>

<script>
    // Modal functions
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        @foreach($employees as $employee)
            if (event.target === document.getElementById('accountability-modal-{{ $employee->id }}')) {
                closeModal('accountability-modal-{{ $employee->id }}');
            }
            if (event.target === document.getElementById('asset-return-modal-{{ $employee->id }}')) {
                closeModal('asset-return-modal-{{ $employee->id }}');
            }
        @endforeach
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            @foreach($employees as $employee)
                if (!document.getElementById('accountability-modal-{{ $employee->id }}').classList.contains('hidden')) {
                    closeModal('accountability-modal-{{ $employee->id }}');
                }
                if (!document.getElementById('asset-return-modal-{{ $employee->id }}').classList.contains('hidden')) {
                    closeModal('asset-return-modal-{{ $employee->id }}');
                }
            @endforeach
        }
    });

    // File input handling
    document.addEventListener('DOMContentLoaded', function() {
        @foreach($employees as $employee)
            // Accountability form
            const assetFileInput{{ $employee->id }} = document.getElementById('assetFile-{{ $employee->id }}');
            const assetFileNameDisplay{{ $employee->id }} = document.getElementById('assetFileNameDisplay-{{ $employee->id }}');
            
            if (assetFileInput{{ $employee->id }}) {
                assetFileInput{{ $employee->id }}.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        assetFileNameDisplay{{ $employee->id }}.textContent = this.files[0].name;
                        assetFileNameDisplay{{ $employee->id }}.classList.add('has-file');
                    } else {
                        assetFileNameDisplay{{ $employee->id }}.textContent = 'No file selected';
                        assetFileNameDisplay{{ $employee->id }}.classList.remove('has-file');
                    }
                });
            }

            // Return form
            const returnFileInput{{ $employee->id }} = document.getElementById('returnFile-{{ $employee->id }}');
            const returnFileNameDisplay{{ $employee->id }} = document.getElementById('returnFileNameDisplay-{{ $employee->id }}');
            
            if (returnFileInput{{ $employee->id }}) {
                returnFileInput{{ $employee->id }}.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        returnFileNameDisplay{{ $employee->id }}.textContent = this.files[0].name;
                        returnFileNameDisplay{{ $employee->id }}.classList.add('has-file');
                    } else {
                        returnFileNameDisplay{{ $employee->id }}.textContent = 'No file selected';
                        returnFileNameDisplay{{ $employee->id }}.classList.remove('has-file');
                    }
                });
            }

            // Form validation
            document.getElementById('assetsSignedForm-{{ $employee->id }}')?.addEventListener('submit', function(e) {
                if (!assetFileInput{{ $employee->id }}.files.length) {
                    e.preventDefault();
                    alert('Please select a file to upload for Accountability');
                }
            });

            document.getElementById('returnFilesForm-{{ $employee->id }}')?.addEventListener('submit', function(e) {
                if (!returnFileInput{{ $employee->id }}.files.length) {
                    e.preventDefault();
                    alert('Please select a file to upload for Return Asset');
                }
            });
        @endforeach
    });
</script>

@endsection