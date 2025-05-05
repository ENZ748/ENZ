<?php $__env->startSection('content'); ?>
<?php
    use App\Models\Brand;
    $brand = Brand::find($brandID);
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <!-- Card Header -->
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="bi bi-box-seam me-2"></i>
                            Units Management - <?php echo e($brand ? $brand->brand_name : 'No Brand Found'); ?>

                        </h4>
                        <div>
                            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#createUnitModal">
                                <i class="bi bi-plus-circle me-1"></i> Add Unit
                            </button>
                            <a href="<?php echo e(route('categories.index')); ?>" class="btn btn-light btn-sm ms-2">
                                <i class="bi bi-tags me-1"></i> Categories
                            </a>
                            <a href="<?php echo e(route('brands.index', $categoryID)); ?>" class="btn btn-light btn-sm ms-2">
                                <i class="bi bi-tag me-1"></i> Back to Brands
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Units Table -->
                <div class="card-body">
                    <?php if($units->isEmpty()): ?>
                        <div class="alert alert-info text-center py-4">
                            <i class="bi bi-info-circle-fill fs-4"></i>
                            <h5 class="mt-2">No Units Found</h5>
                            <p class="mb-0">Start by adding your first unit for this brand</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>Unit Name</th>
                                        <th width="20%">Created At</th>
                                        <th width="25%" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($index + 1); ?></td>
                                            <td>
                                                <span class="badge bg-primary bg-opacity-10 text-primary p-2">
                                                    <?php echo e($unit->unit_name); ?>

                                                </span>
                                            </td>
                                            <td><?php echo e(\Carbon\Carbon::parse($unit->created_at)->format('M d, Y')); ?></td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <!-- Edit Button -->
                                                    <button class="btn btn-sm btn-outline-primary edit-unit-btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editUnitModal"
                                                            data-id="<?php echo e($unit->id); ?>"
                                                            data-name="<?php echo e($unit->unit_name); ?>"
                                                            title="Edit Unit">
                                                        <i class="bi bi-pencil"></i>
                                                    Edit</button>
                                                    
                                                    <!-- Delete Button -->
                                                    <form action="<?php echo e(route('units.destroy', ['id' => $unit->id, 'brandID' => $brandID, 'categoryID' => $categoryID])); ?>" 
                                                          method="POST" 
                                                          class="d-inline delete-unit-form">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-danger delete-unit-btn"
                                                                title="Delete Unit">
                                                            <i class="bi bi-trash"></i>
                                                        Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Unit Modal -->
<div class="modal fade" id="createUnitModal" tabindex="-1" aria-labelledby="createUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createUnitModalLabel">
                    <i class="bi bi-plus-circle me-2"></i> Add New Unit
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="createUnitForm" action="<?php echo e(route('units.store', ['brandID' => $brandID, 'categoryID' => $categoryID])); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-4">
                        <label for="unit_name" class="form-label fw-bold">Unit Name</label>
                        <input type="text" id="unit_name" name="unit_name" class="form-control form-control-lg" 
                               placeholder="Enter unit name" required>
                        <div class="form-text">This will be used to identify product units.</div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-save me-2"></i> Create Unit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Unit Modal -->
<div class="modal fade" id="editUnitModal" tabindex="-1" aria-labelledby="editUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editUnitModalLabel">
                    <i class="bi bi-pencil-square me-2"></i> Edit Unit
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editUnitForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <input type="hidden" id="edit_unit_id">
                    <div class="mb-4">
                        <label for="edit_unit_name" class="form-label fw-bold">Unit Name</label>
                        <input type="text" id="edit_unit_name" name="unit_name" class="form-control form-control-lg" 
                               placeholder="Enter unit name" required>
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
        const editUnitModal = new bootstrap.Modal(document.getElementById('editUnitModal'));
        const createUnitModal = new bootstrap.Modal(document.getElementById('createUnitModal'));
        
        // Set up edit unit buttons
        document.querySelectorAll('.edit-unit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const unitId = this.getAttribute('data-id');
                const unitName = this.getAttribute('data-name');
                
                document.getElementById('edit_unit_id').value = unitId;
                document.getElementById('edit_unit_name').value = unitName;
                
                const formAction = `/units/${unitId}/update/brand/<?php echo e($brandID); ?>/category/<?php echo e($categoryID); ?>`;
                document.getElementById('editUnitForm').setAttribute('action', formAction);
            });
        });
        
        // Unit existence check - Modified to include brand and category context
        async function checkUnitExists(unitName) {
            try {
                const response = await fetch("<?php echo e(route('units.check')); ?>", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ 
                        unit_name: unitName,
                        brand_id: <?php echo e($brandID); ?>,
                        category_id: <?php echo e($categoryID); ?>

                    })
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
        
        // Modified form submission handler
        async function handleFormSubmission(form, successMessage) {
            const formData = new FormData(form);
            const unitName = formData.get('unit_name');
            
            try {
                // First show loading immediately
                showLoading('Verifying...', 'Checking unit availability');
                
                // Check if unit exists
                const { exists } = await checkUnitExists(unitName);
                
                Swal.close();
                
                if (exists) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Duplicate Unit',
                        text: 'This unit name already exists for this brand!',
                        confirmButtonColor: '#3085d6'
                    });
                    return;
                }
                
                // If not exists, confirm submission
                const result = await Swal.fire({
                    title: 'Are you sure?',
                    text: `You're about to ${form.id.includes('edit') ? 'update' : 'create'} this unit.`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, proceed',
                    cancelButtonText: 'Cancel'
                });
                
                if (!result.isConfirmed) return;
                
                showLoading('Processing...', 'Please wait while we process your request');
                
                // Submit the form
                const response = await fetch(form.action, {
                    method: form.method,
                    body: formData
                });
                
                // Handle response
                if (response.ok) {
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
                } else {
                    const data = await response.json();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'An error occurred',
                        confirmButtonColor: '#3085d6'
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
        
        // Create unit form submission
        document.getElementById('createUnitForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            await handleFormSubmission(this, 'Unit created successfully!');
        });
        
        // Edit unit form submission
        document.getElementById('editUnitForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            await handleFormSubmission(this, 'Unit updated successfully!');
        });
        
        // Delete unit confirmation
        document.querySelectorAll('.delete-unit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Delete Unit?',
                    text: 'This will permanently delete the unit!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        showLoading('Deleting...', 'Please wait while we delete the unit');
                        form.submit();
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
    .btn-outline-danger:hover {
        color: white !important;
    }
    
    .alert-info {
        background-color: #e7f5ff;
        border-color: #d0ebff;
        color: #1864ab;
    }
</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ENZ\resources\views/units/index.blade.php ENDPATH**/ ?>