@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="text-primary mb-1">Assigned Items History</h1>
                <p class="text-muted">Track all equipment assignments and returns</p>
            </div>

        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-gradient-primary text-white">
                            <tr>
                                <th class="py-3 px-4 text-left">Employee</th>
                                <th class="py-3 px-4 text-left">Employee Details</th>
                                <th class="py-3 px-4 text-left">Item Information</th>
                                <th class="py-3 px-4 text-left">Serial Number</th>
                                <th class="py-3 px-4 text-left">Assigned By</th>
                                <th class="py-3 px-4 text-left">Assignment Period</th>
                                <th class="py-3 px-4 text-left">Notes</th>
                                <th class="py-3 px-4 text-left">Returned T  o</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assignedItems as $assignedItem)
                                <tr class="border-bottom">
                                    <td class="py-3 px-4">
                                        <div class="font-weight-bold">{{ $assignedItem->employee->first_name }} {{ $assignedItem->employee->last_name }}</div>
                                        <div class="text-muted small">#{{ $assignedItem->employee->employee_number }}</div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="text-muted small">
                                            {{ $assignedItem->employee->department ?? 'N/A' }}
                                        </div>

                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="font-weight-bold">{{ $assignedItem->item->category->category_name }}</div>
                                        <div class="text-muted small">
                                            {{ $assignedItem->item->brand->brand_name }} • {{ $assignedItem->item->unit->unit_name }}
                                        </div>
                                    </td>
                                    <td style="color: #212529;">{{ $assignedItem->item->serial_number }}</td>
                                    <td style="color: #212529;">{{ $assignedItem->assigned_by }}</td>

                                    <td class="py-3 px-4">
                                        <div class="font-weight-bold text-primary">
                                            {{ \Carbon\Carbon::parse($assignedItem->assigned_date)->format('M d, Y') }}
                                        </div>
                                        
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="text-muted small">{{ $assignedItem->notes ?: '—' }}</div>
                                    </td>
                                    <td style="color: #212529;">{{ $assignedItem->returned_to }}</td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">No assigned items history found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
          <!-- Pagination (only shown if using paginate()) -->
          @if(method_exists($assignedItems, 'hasPages') && $assignedItems->hasPages())
                <div class="card-footer bg-white">
                    {{ $assignedItems->links() }}
                </div>
            @endif
        </div>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #012a4a 0%, #2A6F97 100%);
        }
        .table-hover tbody tr:hover {
            background-color: rgba(1, 42, 74, 0.03);
        }
        .font-monospace {
            font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        }
        .badge-light {
            background-color: #f8f9fa;
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    
@endsection