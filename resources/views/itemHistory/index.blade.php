@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="text-primary mb-1">Assigned Items History</h1>
                <p class="text-muted">Track all equipment assignments and returns</p>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('assigned-items.history') }}" method="GET">
                    <div class="input-group">
                        <input type="text" 
                               name="search" 
                               class="form-control border-0" 
                               placeholder="Search by employee name, item, serial number..." 
                               value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        @if(request('search'))
                            <div class="input-group-append">
                                <a href="{{ route('assigned-items.history') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                            <tr>
                                <th>Employee</th>
                                <th>Employee Details</th>
                                <th>Item Information</th>
                                <th>Serial Number</th>
                                <th>Assigned By</th>
                                <th>Assignment Period</th>
                                <th>Notes</th>
                                <th>Returned To</th>
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
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        @if(request('search'))
                                            No results found for "{{ request('search') }}"
                                        @else
                                            No assigned items history found
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
            
            <!-- Pagination -->
            @if(method_exists($assignedItems, 'hasPages') && $assignedItems->hasPages())
                <div class="card-footer bg-white">
                    {{ $assignedItems->appends(['search' => request('search')])->links() }}
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
        .search-card {
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .search-input {
            border-radius: 8px;
            padding-left: 15px;
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
@endsection