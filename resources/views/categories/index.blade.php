@extends('layouts.app')

@section('content')

@php
    use App\Models\Category;
@endphp

<div class="container mt-4">
    <h2>Category Management</h2>

    <!-- Add Category Button -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="bi bi-plus-circle"></i> Add Category
        </button>
    </div>

    <!-- Category Table -->
        <div class="card-body">
            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category Name</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $index => $category)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $category->category_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($category->created_at)->format('Y-m-d') }}</td>
                            <td>
                                <div class="btn-group gap-2">
                                    <a href="{{ route('brands.index', $category->id) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <button class="btn btn-primary btn-sm edit-category-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editCategoryModal"
                                            data-id="{{ $category->id }}"
                                            data-name="{{ $category->category_name }}">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <form id="delete-form-{{ $category->id }}" action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $category->id }}">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm" action="{{ route('categories.store') }}" method="POST" onsubmit="return validateCategoryForm(event)">
                    @csrf
                    <div class="mb-3">
                        <label for="category_name" class="form-label">Category Name:</label>
                        <input type="text" id="category_name" name="category_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Create Category</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCategoryForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_category_id">
                    <div class="mb-3">
                        <label for="edit_category_name" class="form-label">Category Name:</label>
                        <input type="text" id="edit_category_name" name="category_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Include Bootstrap and SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Function to check if a category exists
    function checkCategoryExists(categoryName, callback) {
        fetch("{{ route('categories.check') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ category_name: categoryName })
        })
        .then(response => response.json())
        .then(data => {
            callback(data.exists);
        })
        .catch(error => {
            console.error("Error:", error);
            Swal.fire({
                icon: "error",
                title: "Server Error",
                text: "Something went wrong. Please try again."
            });
        });
    }

    // Validate and submit Add Category Form
    function validateCategoryForm(event) {
        event.preventDefault();
        let categoryName = document.getElementById("category_name").value.trim();
        
        if (!categoryName) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Category name is required!'
            });
            return false;
        }

        // Check if the category already exists
        checkCategoryExists(categoryName, function(exists) {
            if (exists) {
                Swal.fire({
                    icon: "error",
                    title: "Duplicate Category",
                    text: "This category already exists!"
                });
            } else {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You are about to add a new category!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, add it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Adding Category...",
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        setTimeout(() => {
                            Swal.fire({
                                icon: "success",
                                title: "Success!",
                                text: "Category has been created successfully."
                            }).then(() => {
                                document.getElementById("addCategoryForm").submit();
                            });
                        }, 2000);
                    }
                });
            }
        });
    }

    // Validate and submit Edit Category Form
    document.getElementById('editCategoryForm').addEventListener('submit', function (event) {
        event.preventDefault();
        
        let categoryId = document.getElementById('edit_category_id').value;
        let categoryName = document.getElementById('edit_category_name').value.trim();

        if (!categoryName) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Category name is required!'
            });
            return false;
        }

        // Check if the category already exists (excluding the current category)
        checkCategoryExists(categoryName, function(exists) {
            if (exists) {
                Swal.fire({
                    icon: "error",
                    title: "Duplicate Category",
                    text: "This category name is already in use!"
                });
            } else {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You are about to update this category!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, update it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Updating...",
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        setTimeout(() => {
                            Swal.fire({
                                icon: "success",
                                title: "Updated!",
                                text: "Category has been updated successfully."
                            }).then(() => {
                                document.getElementById("editCategoryForm").submit();
                            });
                        }, 2000);
                    }
                });
            }
        });
    });

    // Populate Edit Modal
    document.querySelectorAll('.edit-category-btn').forEach(button => {
        button.addEventListener('click', function () {
            let categoryId = this.getAttribute('data-id');
            let categoryName = this.getAttribute('data-name');
            
            document.getElementById('edit_category_id').value = categoryId;
            document.getElementById('edit_category_name').value = categoryName;
            
            let formAction = "{{ route('categories.update', ':id') }}".replace(':id', categoryId);
            document.getElementById('editCategoryForm').setAttribute('action', formAction);
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            let categoryId = this.getAttribute('data-id');
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
                    document.getElementById(`delete-form-${categoryId}`).submit();
                }
            });
        });
    });
});

</script>


@endsection
