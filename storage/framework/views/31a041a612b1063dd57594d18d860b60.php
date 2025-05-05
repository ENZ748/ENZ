<?php $__env->startSection('content'); ?>

<?php
    use App\Models\Brand;
    use App\Models\Unit;
?>

<?php if($errors->any()): ?>
        <div>
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <form action="<?php echo e(route('assigned_items.update',$assignedItem->id)); ?>" method="POST" id="assign-item-form">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="form-group">
            <label for="employeeID">Employee</label>
            <select name="employeeID" id="employeeID" class="form-control" required>
                <option value="">Select Employee</option>
                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    < <option value="<?php echo e($employee->id); ?>" 
                        <?php echo e($employee->id == $assignedItem->employeeID ? 'selected' : ''); ?>

                        data-first-name="<?php echo e($employee->first_name); ?>"
                        data-last-name="<?php echo e($employee->last_name); ?>">
                        <?php echo e($employee->employee_number); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <!-- Display employee's full name dynamically after selection -->
        <div class="form-group">
            <label for="employee_name">Employee Name</label>
            <input type="text" id="employee_name" class="form-control" value="<?php echo e($assignedItem->employee->first_name); ?> <?php echo e($assignedItem->employee->last_name); ?>" readonly>
        </div>

        <div class="form-group">
            <label for="category">Category:</label>
            <select id="category" name="category_id" class="form-control" required>
                <option value="">Select Category</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id', $assignedItem->item->categoryID) == $category->id ? 'selected' : ''); ?>>
                    <?php echo e($category->category_name); ?>

                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select><br><br>

            <div id="brand-container">
                <label for="brand">Brand Name:</label>
                <select id="brand" name="brand_id" class="form-control" required>
                    <option value="">Select Brand</option>
                    <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($brand->id); ?>" <?php echo e(old('brand_id', $assignedItem->item->brandID) == $brand->id ? 'selected' : ''); ?>>
                    <?php echo e($brand->brand_name); ?>

                </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select><br><br>
            </div>

            <div id="unit-container">
                <label for="unit">Unit:</label>
                <select id="unit" name="unit_id" class="form-control" required>
                    <option value="">Select Unit</option>
                    <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                    <option value="<?php echo e($unit->id); ?>" <?php echo e(old('unit_id', $assignedItem->item->unitID) == $unit->id ? 'selected' : ''); ?>>
                    <?php echo e($unit->unit_name); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select><br><br>
            </div>

            <div id="serial-container">
                <label for="serial_number">Serial Number:</label>
                <select id="serial_number" name="serial_number" class="form-control" required>
                    <option value="">Select Serial</option>
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                    <option value="<?php echo e($item->id); ?>" <?php echo e(old('unit_id', $assignedItem->item->serial_number) == $item->serial_number ? 'selected' : ''); ?>>
                    <?php echo e($item->serial_number); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select><br><br>
            </div>


        </div>

        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea name="notes" id="notes" class="form-control"><?php echo e($assignedItem->notes); ?></textarea>
        </div>

        <div class="form-group">
            <label for="assigned_date">Assigned Date</label>
            <input type="date" name="assigned_date" id="assigned_date" class="form-control" value="<?php echo e($assignedItem->assigned_date); ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Assign Item</button>
    </form>

    <!-- JavaScript to show employee name after selection -->
    <script>
        document.getElementById('employeeID').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var firstName = selectedOption.getAttribute('data-first-name');
            var lastName = selectedOption.getAttribute('data-last-name');
            
            // Display the employee's full name
            document.getElementById('employee_name').value = firstName + ' ' + lastName;
        });

        $(document).ready(function() {

            // Load brands when a category is selected
            $('#category').change(function() {
                var categoryId = $(this).val();
                
                // Clear the brand, unit, and serial selections
                $('#brand').empty().append('<option value="">Select Brand</option>');
                $('#unit').empty().append('<option value="">Select Unit</option>');
                $('#serial_number').empty().append('<option value="">Select Serial</option>');

                if (categoryId) {
                    $.ajax({
                        url: '/get-brands/create/' + categoryId, // Change URL as needed
                        type: 'GET',
                        success: function(data) {
                            if (data.length > 0) {
                                $.each(data, function(key, brand) {
                                    $('#brand').append('<option value="' + brand.id + '">' + brand.brand_name + '</option>');
                                });
                            } else {
                                $('#brand').append('<option value="">No Brands Available</option>');
                            }
                        },
                        error: function() {
                            alert("Error loading brands.");
                        }
                    });
                }
            });

            // Load units when a brand is selected
            $('#brand').change(function() {
                var brandId = $(this).val();
                
                // Clear the unit and serial selections
                $('#unit').empty().append('<option value="">Select Unit</option>');
                $('#serial_number').empty().append('<option value="">Select Serial</option>');

                if (brandId) {
                    $.ajax({
                        url: '/get-units/create/' + brandId, // Make sure this URL is correct
                        type: 'GET',
                        success: function(data) {
                            if (data.length > 0) {
                                $.each(data, function(key, unit) {
                                    $('#unit').append('<option value="' + unit.id + '">' + unit.unit_name + '</option>');
                                });
                            } else {
                                $('#unit').append('<option value="">No Units Available</option>');
                            }
                        },
                        error: function(xhr) {
                            // Check the error message returned from the server
                            console.log(xhr);
                            alert("Error loading units.");
                        }
                    });
                }
            });


            // Load serial numbers when a unit is selected
            $('#unit').change(function() {
                var unitId = $(this).val();

                // Clear the serial number selection
                $('#serial_number').empty().append('<option value="">Select Serial</option>');

                if (unitId) {
                    $.ajax({
                        url: '/get-serials/create/' + unitId, // Change URL as needed
                        type: 'GET',
                        success: function(data) {
                            if (data.length > 0) {
                               // In your AJAX response when loading serial numbers:
                                $.each(data, function(key, serial) {
                                    $('#serial_number').append('<option value="' + serial.id + '">' + serial.serial_number + '</option>');
                                });
                            } else {
                                $('#serial_number').append('<option value="">No Serials Available</option>');
                            }
                        },
                        error: function() {
                            alert("Error loading serial numbers.");
                        }
                    });
                }
            });

        });


    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ENZ\resources\views/assigned_items/edit.blade.php ENDPATH**/ ?>