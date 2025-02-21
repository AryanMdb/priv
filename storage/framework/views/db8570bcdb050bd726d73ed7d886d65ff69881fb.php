
<?php
use Illuminate\Support\Facades\Session;
?>
<?php $__env->startSection('contant'); ?>
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="w-100 d-flex align-items-center justify-content-between mb-4">
                <h4 class="card-title">Edit Coupon</h4>
            </div>

            <?php if($message = Session::get('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success:</strong> <?php echo e($message); ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error:</strong>
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <form id="editCoupon" class="forms-sample" method="POST" action="<?php echo e(route('coupon.update', $coupon->id)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?> 
                
                <div class="row">
                    <!-- Coupon Name -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Coupon Name</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="name" 
                                name="name" 
                                placeholder="Enter Coupon Name" 
                                value="<?php echo e(old('name', $coupon->name)); ?>" 
                                required>
                        </div>
                    </div>

                    <!-- Coupon Code -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="code">Coupon Code</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="code" 
                                name="code" 
                                placeholder="Enter Coupon Code" 
                                value="<?php echo e(old('code', $coupon->code)); ?>" 
                                minlength="3" 
                                maxlength="20" 
                                required
                                style="text-transform: uppercase;">
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category_id">Select Category</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option 
                                        value="<?php echo e($category->id); ?>" 
                                        <?php echo e(old('category_id', $coupon->cat_id) == $category->id ? 'selected' : ''); ?>>
                                        <?php echo e($category->title); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <!-- Expiry Date -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="expires_at">Expiry Date</label>
                            <input 
                                type="date" 
                                class="form-control" 
                                id="expires_at" 
                                name="expires_at" 
                                value="<?php echo e(old('expires_at', \Carbon\Carbon::parse($coupon->expires_at)->format('Y-m-d'))); ?>" 
                                required>
                        </div>
                    </div>
                  
                    <!-- Discount Value -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="discount_value">Discount Value</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="discount_value" 
                                name="discount_value" 
                                placeholder="Enter Discount Value" 
                                value="<?php echo e(old('discount_value', $coupon->discount_value)); ?>" 
                                min="0" 
                                required>
                        </div>
                    </div>

                    <!-- Discount Type -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Discount Type</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="fixed" <?php echo e(old('type', $coupon->type) == 'fixed' ? 'selected' : ''); ?>>Fixed Amount</option>
                                <option value="percentage" <?php echo e(old('type', $coupon->type) == 'percentage' ? 'selected' : ''); ?>>Percentage</option>
                            </select>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Update Coupon</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Custom validation method to check discount value
        $.validator.addMethod("validDiscount", function (value, element) {
            var discountType = $('#type').val();
            if (discountType === 'percentage' && parseFloat(value) > 100) {
                return false;
            }
            return true;
        }, "For percentage discounts, the value cannot exceed 100.");

        // Initialize form validation
        $('#editCoupon').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 50
                },
                category_id: {
                    required: true
                },
                code: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                },
                discount_value: {
                    required: true,
                    number: true,
                    min: 0,
                    validDiscount: true
                },
                type: {
                    required: true
                },
                expires_at: {
                    required: true,
                    date: true
                }
            },
            messages: {
                name: {
                    required: "Please enter a coupon name",
                    maxlength: "Coupon name cannot exceed 50 characters"
                },
                category_id: {
                    required: "Please select a category"
                },
                code: {
                    required: "Please enter a coupon code",
                    minlength: "Coupon code must be at least 3 characters",
                    maxlength: "Coupon code cannot exceed 20 characters"
                },
                discount_value: {
                    required: "Please enter a discount value",
                    number: "Please enter a valid number",
                    min: "Discount value must be at least 0"
                },
                type: {
                    required: "Please select a discount type"
                },
                expires_at: {
                    required: "Please select an expiry date",
                    date: "Please enter a valid date"
                }
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
        });

        // Restrict discount_value input to numbers only
        $('#discount_value').on('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 5);
        });

        // Convert code input to uppercase
        $('#code').on('input', function () {
            this.value = this.value.toUpperCase();
        });

        // Revalidate discount_value when type changes
        $('#type').on('change', function () {
            $('#discount_value').valid();
        });
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1290354.cloudwaysapps.com/bhqcygtvak/public_html/resources/views/admin/coupon/edit.blade.php ENDPATH**/ ?>