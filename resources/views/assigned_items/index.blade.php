@extends('layouts.app')

@section('content')
    <h1>Assigned Items</h1>
    <a href="{{ route('assigned_items.create') }}" class="btn btn-primary">Assign New Item</a>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Employee Number</th>
                <th>Item Category</th>
                <th>Item Brand</th>
                <th>Item Unit</th>
                <th>Serial Number</th>
                <th>Assigned Date</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assignedItems as $assignedItem)
                <tr>
                    <td>{{ $assignedItem->employee->first_name }}</td>
                    <td>{{ $assignedItem->employee->last_name }}</td>
                    <td>{{ $assignedItem->employee->employee_number }}</td>
                    <td>{{ $assignedItem->item->category->category_name }}</td>
                    <td>{{ $assignedItem->item->brand->brand_name }}</td>
                    <td>{{ $assignedItem->item->unit->unit_name }}</td>
                    <td>{{ $assignedItem->item->serial_number }}</td>
                    <td>{{ $assignedItem->assigned_date }}</td>
                    <td>{{ $assignedItem->notes }}</td>
                    <td>
                        <a href="{{ route('assigned_items.edit', $assignedItem->id) }}" class="btn btn-warning">Edit</a>

                        <!-- Trigger Modal for Return -->
                        <button class="btn btn-danger" data-toggle="modal" data-target="#returnModal" data-id="{{ $assignedItem->id }}" data-good="{{ route('assigned_items.good', $assignedItem->id) }}" data-damaged="{{ route('assigned_items.damaged', $assignedItem->id) }}">Return</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="returnModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="returnModalLabel">Confirm Return</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to mark this item as returned?</p>
                </div>
                <div class="modal-footer">
                    <!-- Button to mark item as good -->
                    <form id="goodForm" method="POST" style="display: inline;">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-success btn-lg">Good</button>
                    </form>

                    <!-- Button to mark item as damaged -->
                    <form id="damagedForm" method="POST" style="display: inline;">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-danger btn-lg">Damaged</button>
                    </form>

                    <!-- Close button -->
                    <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Ensure Bootstrap JS and jQuery are included -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Modal Action Script -->
    <script>
        $('#returnModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var itemId = button.data('id'); // Extract the item ID from the button's data-* attribute
            var goodAction = button.data('good'); // Extract good form action
            var damagedAction = button.data('damaged'); // Extract damaged form action

            var modal = $(this);
            modal.find('#goodForm').attr('action', goodAction); // Set form action for good button
            modal.find('#damagedForm').attr('action', damagedAction); // Set form action for damaged button
        });
    </script>
@endsection
