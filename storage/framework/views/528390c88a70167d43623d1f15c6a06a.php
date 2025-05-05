<?php $__env->startSection('content'); ?>
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-0">Assigned Items History</h1>
            </div>
        </div>

    <!-- Search Bar -->
    <div class="card-body">
        <div class="d-flex justify-content-end">
            <form action="<?php echo e(route('assigned-items.history')); ?>" method="GET">
                <div class="input-group mb-3" style="width: 450px;">
                    <input type="text" 
                           name="search" 
                           class="form-control border-0" 
                           placeholder="Search by employee name, item, serial number..." 
                           value="<?php echo e(request('search')); ?>">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>Search
                        </button>
                    </div>
                    <?php if(request('search')): ?>
                        <div class="input-group-append">
                            <a href="<?php echo e(route('assigned-items.history')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>


        <div id="table-view" class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee Details</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Information</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial Number</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned By</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assignment Period</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Returned To</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__empty_1 = true; $__currentLoopData = $assignedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignedItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <div class="font-weight-bold"><?php echo e($assignedItem->employee->first_name); ?> <?php echo e($assignedItem->employee->last_name); ?></div>
                                        <div class="text-muted small">#<?php echo e($assignedItem->employee->employee_number); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                        <div class="text-muted small">
                                            <?php echo e($assignedItem->employee->department ?? 'N/A'); ?>

                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                        <div class="font-weight-bold"><?php echo e($assignedItem->item->category->category_name); ?></div>
                                        <div class="text-muted small">
                                            <?php echo e($assignedItem->item->brand->brand_name); ?> • <?php echo e($assignedItem->item->unit->unit_name); ?>

                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500" style="color: #212529;"><?php echo e($assignedItem->item->serial_number); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500" style="color: #212529;"><?php echo e($assignedItem->assigned_by); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500" class="py-3 px-4">
                                        <div class="font-weight-bold text-primary">
                                            <?php echo e(\Carbon\Carbon::parse($assignedItem->assigned_date)->format('M d, Y')); ?>

                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                        <div class="text-muted small"><?php echo e($assignedItem->notes ?: '—'); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                        <?php if($assignedItem->status == 0): ?>
                                            <span class="badge badge-warning text-dark">Pending</span>
                                        <?php else: ?>
                                            <span class="badge badge-success text-dark">Signed</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500" style="color: #212529;"><?php echo e($assignedItem->returned_to); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500" colspan="8" class="text-center py-4 text-muted">
                                        <?php if(request('search')): ?>
                                            No results found for "<?php echo e(request('search')); ?>"
                                        <?php else: ?>
                                            No assigned items history found
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
            
                    <!-- Pagination -->
                    <?php if(method_exists($assignedItems, 'hasPages') && $assignedItems->hasPages()): ?>
                        <div class="card-footer bg-white">
                            <?php echo e($assignedItems->appends(['search' => request('search')])->links()); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
            <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #012a4a 0%, #2A6F97 100%);
        }
        .table-hover tbody tr:hover {
            background-color: rgba(1, 42, 74, 0.03);
        }
        .font-monospace {
            font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        }
        .badge-light {
            background-color: #f8f9fa;
        }
        .search-card {
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .search-input {
            border-radius: 8px;
            padding-left: 15px;
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ENZ\resources\views/itemHistory/index.blade.php ENDPATH**/ ?>