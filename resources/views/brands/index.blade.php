@extends('layouts.app')

@section('content')

@php
    use App\Models\Category;
    $category = Category::find($categoryID);
@endphp

@if ($errors->has('brand_name'))
    <div class="alert alert-danger">
        {{ $errors->first('brand_name') }}
    </div>
@endif

<h1>All Units for {{ $category ? $category->category_name : 'No Category Found' }}</h1>

<!-- Add Brand & Categories Buttons -->
<div class="mb-3">
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add Brand</button>
    <a href="{{ route('categories.index') }}" class="btn btn-success">Categories</a>
</div>

<!-- Brands Table -->
<div class="table-responsive">
    <table class="table table-hover text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>Brand Name</th>
                <th>Created At</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($brands as $index => $brand)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $brand->brand_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($brand->created_at)->format('Y-m-d') }}</td>
                    <td class="text-center">
                        <div class="btn-group gap-2" role="group">
                            <a href="{{ route('units.index', ['brandID' => $brand->id, 'categoryID' => $categoryID]) }}" class="btn btn-sm btn-primary">View Units</a>
                            <!-- Edit Button -->
                            <button class="btn btn-sm btn-primary editBrandBtn"
                                data-id="{{ $brand->id }}"
                                data-category="{{ $categoryID }}"
                                data-name="{{ $brand->brand_name }}">
                                Edit
                            </button>

                            <form id="delete-form-{{ $brand->id }}" action="{{ route('brands.destroy', ['id' => $brand->id, 'categoryID' => $categoryID]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $brand->id }})">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal for Editing a Brand -->
<div class="modal fade" id="editBrandModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBrandForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_brand_name" class="form-label">Brand Name:</label>
                        <input type="text" id="edit_brand_name" name="brand_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal for Adding a Brand -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add Brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="addCategoryForm" action="{{ route('brands.store', ['categoryID' => $categoryID]) }}" method="POST">
            @csrf
                    <div class="mb-3">
                        <label for="brand_name" class="form-label">Brand Name:</label>
                        <input type="text" id="brand_name" name="brand_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Create Brand</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editBrandModal = new bootstrap.Modal(document.getElementById('editBrandModal'));
        const editBrandForm = document.getElementById('editBrandForm');
        const brandNameInput = document.getElementById('edit_brand_name');

        document.querySelectorAll('.editBrandBtn').forEach(button => {
            button.addEventListener('click', function() {
                const brandID = this.getAttribute('data-id');
                const categoryID = this.getAttribute('data-category');
                const brandName = this.getAttribute('data-name');

                // Set form action dynamically
                editBrandForm.action = `/brands/${brandID}/${categoryID}`;
                brandNameInput.value = brandName;

                // Show the modal
                editBrandModal.show();
            });
        });

        // Function to show a loading animation with a custom message
        function showLoading(message) {
            Swal.fire({
                title: message,
                html: `
                    <div style="display: flex; justify-content: center; align-items: center;">
                        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <p>Please wait...</p>
                `,
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false
            });
        }

        // Function to check if brand name exists
        function checkBrandExists(brandName, categoryID) {
            return fetch("{{ route('brands.check') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ brand_name: brandName, categoryID: categoryID })
            })
            .then(response => response.json())
            .then(data => data.exists);
        }

        // Handle Add Brand Form Submission
        document.getElementById('addCategoryForm').addEventListener('submit', function(event) {
            event.preventDefault();
            let form = this;
            let formData = new FormData(form);
            let brandName = formData.get('brand_name');
            let categoryID = formData.get('categoryID');

            checkBrandExists(brandName, categoryID).then(exists => {
                if (exists) {
                    Swal.fire({
                        title: "Error!",
                        text: "This brand name already exists in this category.",
                        icon: "error"
                    });
                } else {
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You are about to add a new brand!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, proceed",
                        cancelButtonText: "Cancel"  
                    }).then((result) => {
                        if (result.isConfirmed) {
                            showLoading("Adding Brand...");
                            fetch(form.action, {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.error) {
                                    Swal.fire({
                                        title: "Error!",
                                        text: data.error,
                                        icon: "error"
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Success!",
                                        text: "Brand has been created successfully.",
                                        icon: "success"
                                    }).then(() => {
                                        location.reload();
                                    });
                                }
                            })
                            .catch(error => console.error("Error:", error));
                        }
                    });
                }
            });
        });

        // Handle Edit Brand Form Submission
        document.getElementById('editBrandForm').addEventListener('submit', function(event) {
            event.preventDefault();
            let form = this;
            let formData = new FormData(form);
            let brandName = formData.get('brand_name');
            let categoryID = form.action.split('/').pop();

            checkBrandExists(brandName, categoryID).then(exists => {
                if (exists) {
                    Swal.fire({
                        title: "Error!",
                        text: "This brand name already exists in this category.",
                        icon: "error"
                    });
                } else {
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You are about to update this brand!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, update it!",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            showLoading("Updating Brand...");
                            fetch(form.action, {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.error) {
                                    Swal.fire({
                                        title: "Error!",
                                        text: data.error,
                                        icon: "error"
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Updated!",
                                        text: "Brand has been updated successfully.",
                                        icon: "success"
                                    }).then(() => {
                                        location.reload();
                                    });
                                }
                            })
                            .catch(error => console.error("Error:", error));
                        }
                    });
                }
            });
        });

        // Confirm before deleting a brand
        window.confirmDelete = function(brandId) {
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
                    document.getElementById('delete-form-' + brandId).submit();
                }
            });
        };
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
