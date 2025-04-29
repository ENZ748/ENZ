@extends('layouts.superAdminApp')

@section('content')
        
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Activity Logs</h1>
            <p class="text-gray-600 mt-2">Track all system activities and user actions</p>
        </div>
        
        <!-- Export -->
        <a href="{{ route('admin.activityLogs.export') }}?search={{ request('search') }}" 
        class="flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
            Export Logs
        </a>
    </div>
        
    <!-- Search and Filter Section -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8 border border-gray-100">
        <form action="{{ route('admin.activityLogs') }}" method="GET">
            <div class="flex flex-col md:flex-row md:items-end gap-4">
                <!-- Search Input -->
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="search" placeholder="Search by user ID, activity..." 
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                               value="{{ request('search') }}">
                    </div>
                </div>
                

                
                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Apply Filters
                    </button>
                    @if(request('search') || request('date_filter') != 'All time')
                    <a href="{{ route('admin.activityLogs') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Clear
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
    
    <!-- Activity Logs Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($activityLogs as $activityLog)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <!-- User Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-blue-600 font-medium">
                                        {{ substr($activityLog->employee->first_name ?? 'N', 0, 1) }}{{ substr($activityLog->employee->last_name ?? 'A', 0, 1) }}
                                    </span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $activityLog->employee->employee_number ?? 'N/A' }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $activityLog->employee->first_name ?? '' }} {{ $activityLog->employee->last_name ?? '' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        
                        <!-- Activity Column -->
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 font-medium">{{ $activityLog->activity_logs }}</div>
                            <div class="text-sm text-gray-500 mt-1 md:hidden">
                                {{ $activityLog->created_at->format('M d, Y h:i A') }}
                            </div>
                        </td>
                        
                        <!-- Date Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $activityLog->created_at->format('M d, Y') }}</div>
                            <div class="text-sm text-gray-500">{{ $activityLog->created_at->format('h:i A') }}</div>
                        </td>
                        

                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center">
                            <div class="text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="mt-2 text-lg font-medium">No activity logs found</h3>
                                <p class="mt-1">Try adjusting your search or filter criteria</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($activityLogs->hasPages())
        <div class="bg-gray-50 px-6 py-3 flex items-center justify-between border-t border-gray-200">
            <div class="flex-1 flex justify-between sm:hidden">
                @if($activityLogs->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-300 bg-white cursor-not-allowed">
                    Previous
                </span>
                @else
                <a href="{{ $activityLogs->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Previous
                </a>
                @endif
                
                @if($activityLogs->hasMorePages())
                <a href="{{ $activityLogs->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Next
                </a>
                @else
                <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-300 bg-white cursor-not-allowed">
                    Next
                </span>
                @endif
            </div>
            
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Showing <span class="font-medium">{{ $activityLogs->firstItem() }}</span>
                        to <span class="font-medium">{{ $activityLogs->lastItem() }}</span>
                        of <span class="font-medium">{{ $activityLogs->total() }}</span> results
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        {{ $activityLogs->withQueryString()->links() }}
                    </nav>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const exportButton = document.querySelector('a[href*="export"]');
    
    if (exportButton) {
        exportButton.addEventListener('click', function(e) {
            if (!confirm('Exporting large amounts of data may take some time. Continue?')) {
                e.preventDefault();
            }
        });
    }
});
</script>
@endsection