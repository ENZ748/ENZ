@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Assigned Items</h1>
            <a href="{{ route('assigned_items.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle mr-2"></i>Assign New Item
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

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Assignment Records</h5>
                <!-- <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" 
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-filter mr-1"></i>Filter
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="filterDropdown">
                        <a class="dropdown-item" href="#">Active Assignments</a>
                        <a class="dropdown-item" href="#">Recently Returned</a>
                        <a class="dropdown-item" href="#">Damaged Items</a>
                    </div>
                </div> -->
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-nowrap">Employee</th>
                                <th class="text-nowrap">Employee #</th>
                                <th class="text-nowrap">Item Details</th>
                                <th class="text-nowrap">Serial #</th>
                                <th class="text-nowrap">Assigned By</th>
                                <th class="text-nowrap">Assigned Date</th>
                                <th class="text-nowrap">Status</th>
                                <th class="text-nowrap text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assignedItems as $assignedItem)
                                <tr>
                                    <td>
                                        <div class="font-weight-bold">{{ $assignedItem->employee->first_name }} {{ $assignedItem->employee->last_name }}</div>
                                        <small class="text-muted">{{ $assignedItem->employee->department ?? 'N/A' }}</small>
                                    </td>
                                    <td>{{ $assignedItem->employee->employee_number }}</td>
                                    <td>
                                        <div class="font-weight-bold">{{ $assignedItem->item->category->category_name }}</div>
                                        <div class="text-muted small">
                                            {{ $assignedItem->item->brand->brand_name }} • {{ $assignedItem->item->unit->unit_name }}
                                        </div>
                                    </td>
                                
                                 
                                    <td style="color: #212529;">{{ $assignedItem->item->serial_number }}</td>
                                    <td style="color: #212529;">{{ $assignedItem->assigned_by }}</td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($assignedItem->assigned_date)->format('M d, Y') }}
                                    </td>


                                    <td>
                                        <span class="badge badge-success text-dark">Active</span>
                                    </td>
                                    <td class="text-right">
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
                                    <td colspan="7" class="text-center py-4">No assigned items found.</td>
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