
<?php $__env->startSection('contant'); ?>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
            <div class="users-show">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right-info">
                            <div class="projects">
                                <h3>Coupon Details</h3>
                                <div class="projects_data">
                                    <div class="row w-100">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <div class="data">
                                                    <table class="table table-striped" id="table">
                                                        <tr>
                                                            <th>Id</th>
                                                            <td><?php echo e($coupon->id); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Name</th>
                                                            <td><?php echo e($coupon->name); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Code</th>
                                                            <td><?php echo e($coupon->code); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Category</th>
                                                            <td>
                                                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php if($category->id == $coupon->cat_id): ?>
                                                                        <?php echo e($category->title); ?>

                                                                    <?php endif; ?>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Discount</th>
                                                            <td><?php echo e($coupon->discount_value); ?> </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Type</th>
                                                            <td><?php echo e($coupon->type); ?> </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Expiry Date</th>
                                                            <td><?php echo e(date('d M Y', strtotime($coupon->expires_at))); ?> </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Created Date</th>
                                                            <td><?php if(isset($coupon->created_at)): ?><?php endif; ?><?php echo e(date('d M Y', strtotime($coupon->created_at))); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Update Date</th>
                                                            <td><?php if(isset($coupon->updated_at)): ?><?php endif; ?><?php echo e(date('d M Y', strtotime($coupon->updated_at))); ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1290354.cloudwaysapps.com/bhqcygtvak/public_html/resources/views/admin/coupon/view.blade.php ENDPATH**/ ?>