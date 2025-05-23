@if(count($history_items) > 0)

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