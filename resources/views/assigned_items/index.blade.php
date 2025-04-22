@extends('layouts.app')

@section('content')

    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Assigned Items</h1>
            <a href="{{ route('assigned_items.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-1"></i>Assign New Item
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Search Bar -->
        
            <div class="card-body">
                <form action="{{ route('assigned_items.index') }}" method="GET">
                    <div class="input-group w-50">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Search by employee, item, serial number..." 
                               value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> Search
                            </button>
                            @if(request('search'))
                                <a href="{{ route('assigned_items.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

        
            
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-2"><i class="bi bi-journal-text me-2"></i>Assignment Records</h5>
                <div class="d-flex flex-wrap gap-2">
                <span class="badge bg-light text-dark border">
                    <i class="bi bi-collection me-1"></i> Total Records: {{ $assignedItems->total() }}
                </span>
                @if(request('search'))
                    <span class="badge bg-info text-white">
                    <i class="bi bi-filter-circle me-1"></i> Filtered Results
                    </span>
                @endif
                </div>
            </div>
        </div>

            
            <div id="table-view" class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee #</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Details</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial #</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned By</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($assignedItems as $assignedItem)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <div class="font-weight-bold">{{ $assignedItem->employee->first_name }} {{ $assignedItem->employee->last_name }}</div>
                                        <small class="text-muted">{{ $assignedItem->employee->department ?? 'N/A' }}</small>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">{{ $assignedItem->employee->employee_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                        <div class="font-weight-bold">{{ $assignedItem->item->category->category_name }}</div>
                                        <div class="text-muted small">
                                            {{ $assignedItem->item->brand->brand_name }} • {{ $assignedItem->item->unit->unit_name }}
                                        </div>
                                    </td>
                                
                                 
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500" style="color: #212529;">{{ $assignedItem->item->serial_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500" style="color: #212529;">{{ $assignedItem->assigned_by }}</td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                        {{ \Carbon\Carbon::parse($assignedItem->assigned_date)->format('M d, Y') }}
                                    </td>


                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                        <span class="badge badge-success text-dark">Active</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500" class="text-right">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('assigned_items.edit', $assignedItem->id) }}" 
                                               class="btn btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-outline-danger" data-toggle="modal" 
                                                    data-target="#returnModal" 
                                                    data-id="{{ $assignedItem->id }}" 
                                                    data-good="{{ route('assigned_items.good', $assignedItem->id) }}" 
                                                    data-damaged="{{ route('assigned_items.damaged', $assignedItem->id) }}"
                                                    title="Return">
                                                <i class="fas fa-undo"></i>
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500" colspan="7" class="text-center py-4">No assigned items found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if(method_exists($assignedItems, 'hasPages') && $assignedItems->hasPages())
                <div class="card-footer bg-white">
                    {{ $assignedItems->links() }}
                </div>
            @endif
    </div>

    <!-- Return Modal -->
    <div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="returnModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="returnModalLabel">Confirm Item Return</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-undo-alt fa-3x text-primary mb-3"></i>
                        <h5>How would you like to return this item?</h5>
                        <p class="text-muted">Please select the condition of the item being returned.</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card h-100 border-success">
                                <div class="card-body text-center">
                                    <i class="fas fa-check-circle fa-2x text-success mb-3"></i>
                                    <h5 class="card-title">Good Condition</h5>
                                    <p class="card-text text-muted small">Item is fully functional with no issues.</p>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <form id="goodForm" method="POST" class="mb-0">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-success btn-block">
                                            <i class="fas fa-check mr-2"></i>Mark as Good
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card h-100 border-danger">
                                <div class="card-body text-center">
                                    <i class="fas fa-exclamation-triangle fa-2x text-danger mb-3"></i>
                                    <h5 class="card-title">Damaged</h5>
                                    <p class="card-text text-muted small">Item has issues or requires maintenance.</p>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <form id="damagedForm" method="POST" class="mb-0">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-danger btn-block">
                                            <i class="fas fa-times mr-2"></i>Mark as Damaged
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

        <script>
            $(document).ready(function() {
                // Modal action setup
                $('#returnModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var itemId = button.data('id');
                    var goodAction = button.data('good');
                    var damagedAction = button.data('damaged');

                    var modal = $(this);
                    modal.find('#goodForm').attr('action', goodAction);
                    modal.find('#damagedForm').attr('action', damagedAction);
                    
                    // You could add an AJAX call here to get more item details if needed
                });

                // Tooltip initialization
                $('[title]').tooltip({
                    placement: 'top',
                    trigger: 'hover'
                });
            });
        </script>
@endsection