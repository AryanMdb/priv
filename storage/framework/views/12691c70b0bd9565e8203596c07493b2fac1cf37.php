
<?php $__env->startSection('contant'); ?>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <!-- <div class="card-body"> -->
            <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
            <div class="users-show">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="img-block">
                            <?php if(isset($category->image) && !empty($category->image)): ?>
                                <?php $category_image = asset('storage/category/'.$category->image);?>
                            <?php else: ?>
                                <?php $category_image = asset('constants.default_image');?>
                            <?php endif; ?>
                            <img src="<?php echo e($category_image); ?>" alt="user" width="100px" height="100px">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="right-info">
                            <div class="projects">
                                <h3>Category Details</h3>
                                <div class="projects_data">
                                    <div class="row w-100">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <div class="data">
                                                    <table class="table table-striped" id="table">
                                                        <tr>
                                                            <th>Name</th>
                                                            <td><?php echo e($category->title); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Is Show</th>
                                                            <td><?php if(isset($category->is_show)): ?><?php endif; ?> <?php echo e($category->is_show == 1 ? 'True' : 'False'); ?> </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Coming Soon</th>
                                                            <td><?php if(isset($category->coming_soon)): ?><?php endif; ?> <?php echo e($category->coming_soon == 1 ? 'True' : 'False'); ?> </td>
                                                        </tr>

                                                        <tr>
                                                            <th>Delivery Time</th>
                                                            <td>
                                                                <?php if(isset($category->delivery_time)): ?>
                                                                    <?php echo e(date('g:i A', strtotime($category->delivery_time))); ?>

                                                                <?php else: ?>
                                                                    Not Set
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th>Created Date</th>
                                                            <td><?php if(isset($category->created_at)): ?><?php endif; ?><?php echo e(date('d M Y', strtotime($category->created_at))); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Update Date</th>
                                                            <td><?php if(isset($category->updated_at)): ?><?php endif; ?><?php echo e(date('d M Y', strtotime($category->updated_at))); ?></td>
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

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1290354.cloudwaysapps.com/bhqcygtvak/public_html/resources/views/admin/category/view.blade.php ENDPATH**/ ?>