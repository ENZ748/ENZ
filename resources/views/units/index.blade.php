@extends('layouts.app')

@section('content')
@php
    use App\Models\Brand;
    $brand = Brand::find($brandID);
@endphp

<h1>All Units for {{ $brand ? $brand->brand_name : 'No Brand Found' }}</h1>

<!-- Add Unit & Navigation Buttons -->
<div class="mb-3">
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createUnitModal">Add Unit</button>
    <a href="{{ route('categories.index') }}" class="btn btn-success">Categories</a>
    <a href="{{ route('brands.index', $categoryID) }}" class="btn btn-success">Brand</a>
</div>

<!-- Units Table -->
<div class="table-responsive">
    <table class="table table-hover text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>Unit Name</th>
                <th>Created At</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($units as $index => $unit)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $unit->unit_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($unit->created_at)->format('Y-m-d') }}</td>
                    <td class="text-center">
                        <div class="btn-group gap-2" role="group">
                            <button class="btn btn-primary btn-sm edit-category-btn" data-bs-toggle="modal" data-bs-target="#editUnitModal" 
                                data-id="{{ $unit->id }}" data-name="{{ $unit->unit_name }}">
                                Edit
                            </button>
                            <form action="{{ route('units.destroy', ['id' => $unit->id, 'brandID' => $brandID, 'categoryID' => $categoryID]) }}" 
                                method="POST" class="d-inline delete-unit-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>

                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Create Unit Modal -->
<div class="modal fade" id="createUnitModal" tabindex="-1" aria-labelledby="createUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUnitModalLabel">Create Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('units.store', ['brandID' => $brandID, 'categoryID' => $categoryID]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="unit_name" class="form-label">Unit Name:</label>
                        <input type="text" id="unit_name" name="unit_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Create Unit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Unit Modal -->
<div class="modal fade" id="editUnitModal" tabindex="-1" aria-labelledby="editUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUnitModalLabel">Edit Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUnitForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_unit_name" class="form-label">Unit Name:</label>
                        <input type="text" id="edit_unit_name" name="unit_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    // Handle Edit Unit Modal
    var editUnitModal = document.getElementById('editUnitModal');
    editUnitModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var unitId = button.getAttribute('data-id');
        var unitName = button.getAttribute('data-name');

        var form = document.getElementById('editUnitForm');
        form.action = `/units/${unitId}/update/brand/{{ $brandID }}/category/{{ $categoryID }}`;
        document.getElementById('edit_unit_name').value = unitName;
    });

    // Check if Unit Name Already Exists
    async function checkUnitExists(unitName) {
        let response = await fetch("{{ route('units.check') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ unit_name: unitName })
        });
        let result = await response.json();
        return result.exists;
    }

    // Apply SweetAlert Confirmation for Submission
    async function handleFormSubmission(event) {
        event.preventDefault();

        let unitName = event.target.querySelector("input[name='unit_name']").value;
        let unitExists = await checkUnitExists(unitName);

        if (unitExists) {
            Swal.fire({
                title: "Error!",
                text: "This unit name already exists.",
                icon: "error",
                confirmButtonText: "OK"
            });
            return;
        }

        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to proceed with the submission?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, submit it!"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Processing...",
                    text: "Please wait while processing your request.",
                    icon: "info",
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                setTimeout(() => {
                    Swal.fire({
                        title: "Success!",
                        text: "Your request has been submitted successfully.",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        event.target.submit();
                    });
                }, 2000);
            }
        });
    }

    // Attach event listener to create unit form
    document.querySelector("#createUnitModal form").addEventListener("submit", handleFormSubmission);

    // Attach event listener to edit unit form
    document.querySelector("#editUnitForm").addEventListener("submit", handleFormSubmission);

    // Apply SweetAlert Confirmation for Deletion
    document.querySelectorAll(".delete-unit-form").forEach(form => {
        form.addEventListener("submit", function(event) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});


</script>
@endsection
