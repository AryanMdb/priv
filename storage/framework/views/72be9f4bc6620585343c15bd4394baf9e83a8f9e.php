
<?php $__env->startSection('contant'); ?>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <!-- <div class="card-body"> -->
            <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
            <div class="users-show">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="preview-images-zone ui-sortable mb-4">
                            <?php if(isset($product->image) && !empty($product->image)): ?>
                                <?php
                                    $profilePics = is_array($product->image) ? $product->image : json_decode($product->image, true);
                                ?>

                                <?php if(is_array($profilePics) && count($profilePics) > 0): ?>
                                    <?php $__currentLoopData = $profilePics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="preview-image preview-show-<?php echo e($key); ?>">
                                            <div class="image-zone">
                                                <img id="pro-img-<?php echo e($key); ?>" src="<?php echo e(asset('storage/product/' . $image)); ?>" alt="Image">
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <div class="image-zone pb-2">
                                    <img id="pro-img" class="prod-img" src="<?php echo e(asset(path: 'storage/product/' . $product->image)); ?>" alt="Image">
                                </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <p>No images uploaded yet.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="right-info">
                            <div class="projects">
                                <h3>Product Details</h3>
                                <div class="projects_data">
                                    <div class="row w-100">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <div class="data">
                                                    <table class="table table-striped" id="table">
                                                        <tr>
                                                            <th>Name</th>
                                                            <td><?php echo e($product->title); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Category</th>
                                                            <td><?php echo e($product?->category?->title); ?></td>
                                                        </tr>
                                                        <?php if($product->address_from != ''): ?>
                                                        <tr>
                                                            <th>Subcategory</th>
                                                            <td><?php echo e($product?->subcategory?->title ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($product->total_amount != '' || $product->total_amount != 0): ?>
                                                        <tr>
                                                            <th>Actual Price</th>
                                                            <td><?php echo e($product->total_amount ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        
                                                        <?php if($product->selling_price != 0): ?>
                                                        <tr>
                                                            <th>Selling Price</th>
                                                            <td><?php echo e($product->selling_price ?? '-'); ?></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php if($product->discount != 0): ?>
                                                        <tr>
                                                            <th>Discount</th>
                                                            <td><?php echo e($product->discount ?? '-'); ?>%</td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <tr>
                                                            <th>Out Of Stock</th>
                                                            <td><?php if(isset($product->out_of_stock)): ?><?php endif; ?> <?php echo e($product->out_of_stock == 1 ? 'True' : 'False'); ?> </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Created Date</th>
                                                            <td><?php if(isset($product->created_at)): ?><?php endif; ?><?php echo e(date('d M Y', strtotime($product->created_at))); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Update Date</th>
                                                            <td><?php if(isset($product->updated_at)): ?><?php endif; ?><?php echo e(date('d M Y', strtotime($product->updated_at))); ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <?php if($product->total_amount != 0): ?>
                            <div class="projects">
                                <h3>Inventory Details</h3>
                                <div class="projects_data">
                                    <div class="row w-100">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <div class="data">
                                                    <table class="table table-striped" id="group_table">
                                                        <thead>
                                                            <tr>
                                                                <th>S.No.</th>
                                                                <th>Quantity</th>
                                                                <th>Actual Price</th>
                                                                <th>Selling Price</th>
                                                                <th>Discount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1; ?>
                                                            <?php $__currentLoopData = $product?->inventory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <td><?php echo e($i++); ?></td>
                                                                    <td><?php echo e($val->quantity); ?></td>
                                                                    <td>₹<?php echo e($val->actual_price); ?></td>
                                                                    <td>
                                                                        <?php if($val->selling_price != 0 && $val->selling_price != null): ?>
                                                                        ₹<?php echo e($val->selling_price); ?>

                                                                        <?php else: ?>
                                                                            <span class="text-danger"> No Selling Price</span>
                                                                        <?php endif; ?>
                                                                    </td>

                                                                    <td>
                                                                        <?php if($val->discount != 0 && $val->discount != null): ?>
                                                                            <?php echo e($val->discount); ?>%
                                                                        <?php else: ?>
                                                                            <span class="text-danger"> No Discount</span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1290354.cloudwaysapps.com/bhqcygtvak/public_html/resources/views/admin/product/view.blade.php ENDPATH**/ ?>