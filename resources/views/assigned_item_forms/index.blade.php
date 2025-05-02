@extends('layouts.app')

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
            <form action="{{ route('form.search') }}" method="GET">
                <div class="input-group mb-3" style="width: 460px;">
                    <input type="text" 
                           name="search" 
                           class="form-control border-0" 
                           placeholder="Search by employee name, item, serial number..." 
                           value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>Search
                        </button>
                    </div>
                    @if(request('search'))
                        <div class="input-group-append">
                            <a href="{{ route('form.search') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if($employees->isEmpty())
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        @if(request('search'))
                            No employees found matching your search criteria.
                        @else
                            No employees found in the system.
                        @endif
                    </p>
                </div>
            </div>
        </div>
    @else

            <div id="table-view" class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($employees as $employee)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <div class="text-sm font-medium text-gray-900">{{ $employee->first_name }} {{ $employee->last_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $employee->employee_number }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                <div class="text-sm text-gray-900">{{ $employee->department }}</div>
                                <div class="text-sm text-gray-500">{{ $employee->position ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                <div class="flex space-x-2">
                                    <button onclick="openModal('accountability-modal-{{ $employee->id }}')" 
                                       class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Accountability
                                    </button>
                                    
                                    <button onclick="openModal('asset-return-modal-{{ $employee->id }}')" 
                                       class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                        Return Asset
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @foreach($employees as $employee)
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
                                <a href="{{ route('form.confirm_accountability', $employee->id) }}" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
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
                    <form action="{{ route('form.asset_return', $employee->id) }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">Items to Return</h3>
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
                        </div>
                    </form>
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
                        <a href="{{ route('form.confirm_return', $employee->id) }}" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
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
// Updated modal functions
function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Clear search function
function clearSearch() {
    window.location.href = "{{ route('assigned_items.forms') }}";
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
</script>

<style>
    .asset-card {
        transition: all 0.3s ease;
    }
    
    .asset-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    /* Style for checked checkboxes in asset return */
    input[type="checkbox"]:checked {
        background-color: #10B981;
        border-color: #10B981;
    }
    
    /* Modal transition */
    .modal-transition {
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    
    /* Prevent scrolling when modal is open */
    body.overflow-hidden {
        overflow: hidden;
    }
</style>
@endsection