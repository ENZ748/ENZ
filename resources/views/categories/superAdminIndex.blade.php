@extends('layouts.superAdminApp')

@section('content')

@php
    use App\Models\Category;
@endphp

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-tags fs-4 me-2"></i>
                            <h4 class="mb-0 fw-semibold">Category Management</h4>
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-light btn-sm px-3" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                <i class="bi bi-plus-circle me-1"></i> Add Category
                            </button>
                            <a href="{{ route('superAdmin.items') }}" class="btn btn-light btn-sm ms-2 px-3">
                                <i class="bi bi-tag me-1"></i> Back to Items
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if($categories->isEmpty())
                        <div class="alert alert-info text-center">
                            <i class="bi bi-info-circle-fill"></i> No categories found. Start by adding a new category.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 10%">#</th>
                                        <th style="width: 40%">Category Name</th>
                                        <th class="text-center" style="width: 20%">Created At</th>
                                        <th class="text-center" style="width: 30%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $index => $category)
                                        <tr class="hover-shadow">
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>
                                                <span class="badge bg-primary bg-opacity-10 text-primary p-2">
                                                    {{ $category->category_name }}
                                                </span>
                                            </td>
                                            <td class="text-center">{{ \Carbon\Carbon::parse($category->created_at)->format('M d, Y') }}</td>
                                            <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <!-- View Brands Button -->
                                                        <a href="{{ route('brands.SuperAdminIndex', $category->id) }}" class="btn btn-sm btn-primary" title="View Brands">
                                                            <i class="bi bi-eye-fill me-1"></i> Brands
                                                        </a>
                                                        
                                                        <!-- Edit Button -->
                                                        <button class="btn btn-sm btn-outline-primary edit-category-btn"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editCategoryModal"
                                                                data-id="{{ $category->id }}"
                                                                data-name="{{ $category->category_name }}"
                                                                title="Edit Category">
                                                            <i class="bi bi-pencil-fill"></i>
                                                        Edit</button>
                                                        
                                                        <!-- Delete Button -->
                                                        <form class="d-inline" id="delete-form-{{ $category->id }}" action="{{ route('categories.SuperAdminDestroy', $category->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-id="{{ $category->id }}" title="Delete Category">Delete
                                                                <i class="bi bi-trash-fill"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                @if($categories instanceof \Illuminate\Pagination\LengthAwarePaginator && $categories->hasPages())
                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-center">
                            {{ $categories->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addCategoryModalLabel">
                    <i class="bi bi-plus-circle me-2"></i> Create New Category
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="addCategoryForm" action="{{ route('categories.SuperAdminStore') }}" method="POST" onsubmit="return validateCategoryForm(event)">
                    @csrf
                    <div class="mb-4">
                        <label for="category_name" class="form-label fw-bold">Category Name</label>
                        <input type="text" id="category_name" name="category_name" class="form-control form-control-lg" placeholder="Enter category name" required>
                        <div class="form-text">This will be used to organize your products.</div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-save me-2"></i> Create Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editCategoryModalLabel">
                    <i class="bi bi-pencil-square me-2"></i> Edit Category
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editCategoryForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_category_id">
                    <div class="mb-4">
                        <label for="edit_category_name" class="form-label fw-bold">Category Name</label>
                        <input type="text" id="edit_category_name" name="category_name" class="form-control form-control-lg" placeholder="Enter category name" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-save me-2"></i> Save Changes
                        </button>
                    </div>
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
        fetch("{{ route('categories.SuperAdminCheck') }}", {
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
                text: 'Category name is required!',
                confirmButtonColor: '#3085d6'
            });
            return false;
        }

        // Check if the category already exists
        checkCategoryExists(categoryName, function(exists) {
            if (exists) {
                Swal.fire({
                    icon: "error",
                    title: "Duplicate Category",
                    text: "This category already exists!",
                    confirmButtonColor: '#3085d6'
                });
            } else {
                Swal.fire({
                    title: "Confirm Category Creation",
                    text: "Are you sure you want to add this new category?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, create it!",
                    cancelButtonText: "Cancel",
                    backdrop: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        const swalInstance = Swal.fire({
                            title: "Creating Category...",
                            html: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Please wait while we create your category.</p>',
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });

                        setTimeout(() => {
                            swalInstance.close();
                            document.getElementById("addCategoryForm").submit();
                        }, 1000);
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
                text: 'Category name is required!',
                confirmButtonColor: '#3085d6'
            });
            return false;
        }

        // Check if the category already exists (excluding the current category)
        checkCategoryExists(categoryName, function(exists) {
            if (exists) {
                Swal.fire({
                    icon: "error",
                    title: "Duplicate Category",
                    text: "This category name is already in use!",
                    confirmButtonColor: '#3085d6'
                });
            } else {
                Swal.fire({
                    title: "Confirm Category Update",
                    text: "Are you sure you want to update this category?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, update it!",
                    cancelButtonText: "Cancel",
                    backdrop: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        const swalInstance = Swal.fire({
                            title: "Updating Category...",
                            html: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Please wait while we update your category.</p>',
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });

                        setTimeout(() => {
                            swalInstance.close();
                            document.getElementById("editCategoryForm").submit();
                        }, 1000);
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
            
            let formAction = "{{ route('categories.SuperAdminUpdate', ':id') }}".replace(':id', categoryId);
            document.getElementById('editCategoryForm').setAttribute('action', formAction);
        });
    });

    // Delete Confirmation
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            let categoryId = this.getAttribute('data-id');
            Swal.fire({
                title: "Delete Category?",
                text: "This will permanently delete the category and all associated brands!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel",
                backdrop: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const swalInstance = Swal.fire({
                        title: "Deleting...",
                        html: '<div class="spinner-border text-danger" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Please wait while we delete the category.</p>',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });

                    setTimeout(() => {
                        document.getElementById(`delete-form-${categoryId}`).submit();
                    }, 800);
                }
            });
        });
    });

    // Show success message if session has success
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6',
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    // Show error message if session has error
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#3085d6'
        });
    @endif
</script>

<style>
    .card {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .table {
        margin-bottom: 0;
    }
    
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }
    
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .modal-content {
        border-radius: 10px;
    }
    
    .form-control-lg {
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
    }
    
    .btn-outline-primary, .btn-outline-secondary, .btn-outline-danger {
        transition: all 0.2s ease;
    }
    
    .btn-outline-primary:hover {
        background-color: var(--bs-primary);
        color: white;
    }
    
    .btn-outline-secondary:hover {
        background-color: var(--bs-secondary);
        color: white;
    }
    
    .btn-outline-danger:hover {
        background-color: var(--bs-danger);
        color: white;
    }
</style>

@endsection 