@extends('layouts.superAdminApp')

@section('content')

    <div class="overflow-x-auto py-4">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left font-semibold">User ID</th>
                    <th class="px-4 py-2 text-left font-semibold">Activity</th>
                    <th class="px-4 py-2 text-left font-semibold">Date</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @foreach($activityLogs as $activityLog)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{$activityLog->user_id}}</td>
                        <td class="px-4 py-2">{{$activityLog->activity_logs}}</td>
                        <td class="px-4 py-2">{{$activityLog->created_at}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.tailwindcss.com"></script>

@endsection
