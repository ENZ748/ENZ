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
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add Brand</button>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Categories</a>
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
                            <button class="btn btn-sm btn-warning editBrandBtn" 
                                    data-id="{{ $brand->id }}" 
                                    data-name="{{ $brand->brand_name }}"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editBrandModal">
                                Edit
                            </button>
                            <form action="{{ route('brands.destroy', ['id' => $brand->id, 'categoryID' => $categoryID]) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this brand?');">
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

<!-- Bootstrap Modal for Adding a Brand -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add Brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm" action="{{ route('brands.store', $categoryID) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="brand_name" class="form-label">Brand Name:</label>
                        <input type="text" id="brand_name" name="brand_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Brand</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal for Editing a Brand -->
<div class="modal fade" id="editBrandModal" tabindex="-1" aria-labelledby="editBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBrandModalLabel">Edit Brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBrandForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_brand_name" class="form-label">Brand Name:</label>
                        <input type="text" id="edit_brand_name" name="brand_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-warning">Update Brand</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS (Ensure this is loaded for the modal to work) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- JavaScript for Validation and Alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".editBrandBtn").forEach(button => {
                button.addEventListener("click", function () {
                    let brandId = this.getAttribute("data-id");
                    let brandName = this.getAttribute("data-name");

                    // Set form action dynamically
                    document.getElementById("editBrandForm").setAttribute("action", `/brands/update/${brandId}`);

                    // Set input value
                    document.getElementById("edit_brand_name").value = brandName;
                });
            });
        });


    function validateCategoryForm(event) {
        event.preventDefault();
        let categoryName = document.getElementById("brand_name").value.trim();

        if (!categoryName) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Brand name is required!'
            });
            return false;
        }

        Swal.fire({
            title: "Are you sure?",
            text: "You are about to add a new brand!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, add it!"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Adding Brand...",
                    text: "Please wait while we process your request.",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                setTimeout(() => {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: "Brand has been created successfully."
                    }).then(() => {
                        document.getElementById("addCategoryForm").submit();
                    });
                }, 2000);
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        let alertBox = document.querySelector(".alert-success");
        if (alertBox) {
            alertBox.style.display = "none";
        }
    });

</script>

@endsection
