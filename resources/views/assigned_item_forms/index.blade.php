@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Employee Forms</h1>
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
                    <p class="text-sm text-yellow-700">No employees found in the system.</p>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-blue-600 to-blue-800">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Employee</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Details</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($employees as $employee)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-blue-600 font-medium">{{ substr($employee->first_name, 0, 1) }}{{ substr($employee->last_name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $employee->first_name }} {{ $employee->last_name }}</div>
                                        <div class="text-sm text-gray-500">#{{ $employee->employee_number }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $employee->department }}</div>
                                <div class="text-sm text-gray-500">{{ $employee->position ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
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

        <!-- Modals -->
        @foreach($employees as $employee)
        <!-- Accountability Modal -->
        <div id="accountability-modal-{{ $employee->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                
                <!-- Modal container -->
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-800 flex items-center justify-between">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h2 class="text-lg font-medium text-white">Accountability Form - {{ $employee->first_name }} {{ $employee->last_name }}</h2>
                        </div>
                        <button onclick="closeModal('accountability-modal-{{ $employee->id }}')" class="text-white hover:text-gray-200">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-6 max-h-[70vh] overflow-y-auto">
                            @if($employee->assigned_items->where('status', 0)->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                                    @foreach($employee->assigned_items->where('status', 0) as $assigned_item)
                                <div class="rounded-xl shadow-md overflow-hidden border border-gray-100 transition hover:shadow-lg asset-card">
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
                                            <svg class="w-5 w-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
                            
            
                        @else
                            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                                <p class="text-gray-500">No assets currently assigned to this employee.</p>
                            </div>
                        @endif
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <a href ="{{route('form.confirm_accountability', $employee->id)}}" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Signed
                        </a>
                        <button type="button" onclick="closeModal('accountability-modal-{{ $employee->id }}')" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Asset Return Modal -->
        <div id="asset-return-modal-{{ $employee->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                
                <!-- Modal container -->
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="px-6 py-4 bg-gradient-to-r from-green-600 to-green-800 flex items-center justify-between">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                            <h2 class="text-lg font-medium text-white">Asset Return Form - {{ $employee->first_name }} {{ $employee->last_name }}</h2>
                        </div>
                        <button onclick="closeModal('asset-return-modal-{{ $employee->id }}')" class="text-white hover:text-gray-200">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-6 max-h-[70vh] overflow-y-auto">
                        @if(count($employee->assigned_items) > 0)
                            <form action="{{ route('form.asset_return', $employee->id) }}" method="POST">
                                @csrf
                              
                                
                                <div class="mb-6">
                                    <label for="return_notes" class="block text-sm font-medium text-gray-700">Return Notes</label>
                                    <textarea id="return_notes" name="return_notes" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"></textarea>
                                </div>
                                
                                <!-- Return History -->
                                @if($employee->item_history->where('status', 0)->count() > 0)
                                    <div class="mt-8">
                                        <h3 class="text-lg font-medium text-gray-900 mb-4">Return Item</h3>
                                        <div class="overflow-x-auto rounded-lg shadow">
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
                                                @foreach($employee->item_history->where('status', 0) as $history_item)
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
                                                                {{ \Carbon\Carbon::parse($history_item->returned_date)->format('M d, Y') }}
                                                            </span>
                                                        </td>
                                                        <td style="background-color: rgba(27, 67, 83, 0.1);" class="py-3 px-4">
                                                            @if($history_item->return_notes)
                                                                <span class="text-sm text-gray-600">{{ Str::limit($history_item->return_notes, 30) }}</span>
                                                            @else
                                                                <span class="text-xs text-gray-400">No notes</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            </form>
                        @else
                            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                                <p class="text-gray-500">No assets currently assigned to this employee.</p>
                            </div>
                        @endif
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        @if(count($employee->assigned_items) > 0)
                            <a href ="{{route('form.confirm_return', $employee->id)}}" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Process Return
                            </a>
                        @endif
                        <button type="button" onclick="closeModal('asset-return-modal-{{ $employee->id }}')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
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