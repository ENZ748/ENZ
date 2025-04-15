@extends('layouts.app')

@section('content')

@php
    use App\Models\Category;
    $category = Category::find($categoryID);
@endphp

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <!-- Card Header -->
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="bi bi-tags me-2"></i>
                            Brands Management - {{ $category ? $category->category_name : 'Uncategorized' }}
                        </h4>
                        <div>
                            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addBrandModal">
                                <i class="bi bi-plus-circle me-1"></i> Add Brand
                            </button>
                            <a href="{{ route('categories.index') }}" class="btn btn-light btn-sm ms-2">
                                <i class="bi bi-arrow-left me-1"></i> Back to Categories
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="alert alert-danger m-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Brands Table -->
                <div class="card-body">
                    @if($brands->isEmpty())
                        <div class="alert alert-info text-center py-4">
                            <i class="bi bi-info-circle-fill fs-4"></i>
                            <h5 class="mt-2">No Brands Found</h5>
                            <p class="mb-0">Start by adding your first brand for this category</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>Brand Name</th>
                                        <th width="20%">Created At</th>
                                        <th width="30%" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($brands as $index => $brand)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <span class="badge bg-primary bg-opacity-10 text-primary p-2">
                                                    {{ $brand->brand_name }}
                                                </span>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($brand->created_at)->format('M d, Y') }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <!-- View Units Button -->
                                                    <a href="{{ route('units.index', ['brandID' => $brand->id, 'categoryID' => $categoryID]) }}" 
                                                       class="btn btn-sm btn-primary"
                                                       title="View Units">
                                                        <i class="bi bi-box-seam"></i> Units
                                                    </a>
                                                    
                                                    <!-- Edit Button -->
                                                    <button class="btn btn-sm btn-outline-primary editBrandBtn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editBrandModal"
                                                            data-id="{{ $brand->id }}"
                                                            data-category="{{ $categoryID }}"
                                                            data-name="{{ $brand->brand_name }}"
                                                            title="Edit Brand">
                                                        <i class="bi bi-pencil"></i>
                                                    Edit</button>
                                                    
                                                    <!-- Delete Button -->
                                                    <form id="delete-form-{{ $brand->id }}" 
                                                          action="{{ route('brands.destroy', ['id' => $brand->id, 'categoryID' => $categoryID]) }}" 
                                                          method="POST" 
                                                          class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-danger delete-btn" 
                                                                data-id="{{ $brand->id }}"
                                                                title="Delete Brand">
                                                            <i class="bi bi-trash"></i>
                                                        Delete</button>
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
            </div>
        </div>
    </div>
</div>

<!-- Add Brand Modal -->
<div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addBrandModalLabel">
                    <i class="bi bi-plus-circle me-2"></i> Add New Brand
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="addBrandForm" action="{{ route('brands.store', ['categoryID' => $categoryID]) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="brand_name" class="form-label fw-bold">Brand Name</label>
                        <input type="text" id="brand_name" name="brand_name" class="form-control form-control-lg" 
                               placeholder="Enter brand name" required>
                        <div class="form-text">This will be used to organize your products.</div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-save me-2"></i> Create Brand
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Brand Modal -->
<div class="modal fade" id="editBrandModal" tabindex="-1" aria-labelledby="editBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editBrandModalLabel">
                    <i class="bi bi-pencil-square me-2"></i> Edit Brand
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editBrandForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_brand_id">
                    <div class="mb-4">
                        <label for="edit_brand_name" class="form-label fw-bold">Brand Name</label>
                        <input type="text" id="edit_brand_name" name="brand_name" class="form-control form-control-lg" 
                               placeholder="Enter brand name" required>
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

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize modals
        const editBrandModal = new bootstrap.Modal(document.getElementById('editBrandModal'));
        const addBrandModal = new bootstrap.Modal(document.getElementById('addBrandModal'));
        
        // Set up edit brand buttons
        document.querySelectorAll('.editBrandBtn').forEach(button => {
            button.addEventListener('click', function() {
                const brandId = this.getAttribute('data-id');
                const categoryId = this.getAttribute('data-category');
                const brandName = this.getAttribute('data-name');
                
                document.getElementById('edit_brand_id').value = brandId;
                document.getElementById('edit_brand_name').value = brandName;
                
                const formAction = `/brands/${brandId}/${categoryId}`;
                document.getElementById('editBrandForm').setAttribute('action', formAction);
            });
        });
        
        // Brand existence check
        async function checkBrandExists(brandName, categoryId) {
            try {
                const response = await fetch("{{ route('brands.check') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ brand_name: brandName, categoryID: categoryId })
                });
                return await response.json();
            } catch (error) {
                console.error('Error:', error);
                return { exists: false };
            }
        }
        
        // Show loading state
        function showLoading(title, text) {
            Swal.fire({
                title: title,
                html: `
                    <div class="text-center py-3">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 mb-0">${text}</p>
                    </div>
                `,
                showConfirmButton: false,
                allowOutsideClick: false
            });
        }
        
        // Form submission handlers
        async function handleFormSubmission(form, successMessage) {
            const formData = new FormData(form);
            const brandName = formData.get('brand_name');
            const categoryId = form.action.split('/').pop();
            
            try {
                const { exists } = await checkBrandExists(brandName, categoryId);
                
                if (exists) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Duplicate Brand',
                        text: 'This brand already exists in this category!',
                        confirmButtonColor: '#3085d6'
                    });
                    return;
                }
                
                const result = await Swal.fire({
                    title: 'Are you sure?',
                    text: exists ? 'This brand already exists!' : `You're about to ${form.id.includes('edit') ? 'update' : 'create'} this brand.`,
                    icon: exists ? 'error' : 'question',
                    showCancelButton: !exists,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, proceed',
                    cancelButtonText: 'Cancel'
                });
                
                if (exists || !result.isConfirmed) return;
                
                showLoading('Processing...', 'Please wait while we process your request');
                
                const response = await fetch(form.action, {
                    method: form.method,
                    body: formData
                });
                
                const data = await response.json();
                
                Swal.close();
                
                if (data.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.error,
                        confirmButtonColor: '#3085d6'
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: successMessage,
                        confirmButtonColor: '#3085d6',
                        timer: 1500,
                        timerProgressBar: true
                    }).then(() => {
                        location.reload();
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred. Please try again.',
                    confirmButtonColor: '#3085d6'
                });
            }
        }
        
        // Add brand form submission
        document.getElementById('addBrandForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            await handleFormSubmission(this, 'Brand created successfully!');
        });
        
        // Edit brand form submission
        document.getElementById('editBrandForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            await handleFormSubmission(this, 'Brand updated successfully!');
        });
        
        // Delete brand confirmation
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const brandId = this.getAttribute('data-id');
                
                Swal.fire({
                    title: 'Delete Brand?',
                    text: 'This will permanently delete the brand and all associated units!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        showLoading('Deleting...', 'Please wait while we delete the brand');
                        document.getElementById(`delete-form-${brandId}`).submit();
                    }
                });
            });
        });
    });
</script>

<style>
    .card {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }
    
    .badge {
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    .btn-sm {
        padding: 0.35rem 0.75rem;
        font-size: 0.85rem;
    }
    
    .form-control-lg {
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
    }
    
    .modal-content {
        border-radius: 10px;
    }
    
    .btn-outline-primary:hover, 
    .btn-outline-secondary:hover, 
    .btn-outline-danger:hover {
        color: white !important;
    }
</style>

@endsection