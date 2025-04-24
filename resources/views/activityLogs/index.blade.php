@extends('layouts.superAdminApp')

@section('content')

<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Activity Logs</h1>
    
    <div id="table-view" class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($activityLogs as $activityLog)
                        @php
                            $admin = \App\Models\Employees::where('user_id', $activityLog->user_id)->first();
                        @endphp
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <span class="font-medium">{{ $admin->employee_number ?? 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                            <div class="flex items-center">
                                <div>
                                    <p class="text-gray-800">{{ $activityLog->activity_logs }}</p>
                                    <p class="text-gray-500 text-xs sm:hidden">
                                        {{ \Carbon\Carbon::parse($activityLog->created_at)->format('M d, Y h:i A') }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                            {{ \Carbon\Carbon::parse($activityLog->created_at)->format('M d, Y h:i A') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($activityLogs->isEmpty())
            <div class="p-6 text-center text-gray-500">
                No activity logs found.
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.tailwindcss.com"></script>
    
@endsection