<?php $__env->startSection('content'); ?>

<h1 class="mb-4">In Stock</h1>

<!-- Search Bar -->
<div class="card-body">
        <div class="d-flex justify-content-end">
            <form action="<?php echo e(route('instock')); ?>" method="GET">
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
                            <a href="<?php echo e(route('instock')); ?>" class="btn btn-outline-secondary">
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
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee #</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Details</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial #</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__empty_1 = true; $__currentLoopData = $in_stocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in_stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <div class="font-weight-bold"><?php echo e($in_stock->employee->first_name); ?> <?php echo e($in_stock->employee->last_name); ?></div>
                                        <small class="text-muted"><?php echo e($in_stock->employee->department ?? 'N/A'); ?></small>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500"><?php echo e($in_stock->employee->employee_number); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                        <div class="font-weight-bold"><?php echo e($in_stock->item->category->category_name); ?></div>
                                        <div class="text-muted small">
                                            <?php echo e($in_stock->item->brand->brand_name); ?> • <?php echo e($in_stock->item->unit->unit_name); ?>

                                        </div>
                                    </td>
                                
                                 
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500" style="color: #212529;"><?php echo e($in_stock->item->serial_number); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500" style="color: #212529;"><?php echo e($in_stock->quantity); ?></td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">No assigned items found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ENZ\resources\views/Instock/index.blade.php ENDPATH**/ ?>