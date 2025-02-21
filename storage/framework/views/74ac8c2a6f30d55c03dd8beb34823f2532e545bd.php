
<?php $__env->startSection('contant'); ?>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <!-- <div class="card-body"> -->
            <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>


            <div class="users-show">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="img-block">
                            <?php if(isset($user->image) && !empty($user->image)): ?>
                                <?php $profile = asset('storage/profile_image/'.$user->image);?>
                            <?php else: ?>
                                <?php $profile = asset(config('constants.default_profile_image'));?>
                            <?php endif; ?>
                            <img src="<?php echo e($profile); ?>" alt="user" width="100px" height="100px">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="right-info">
                            <div class="info">
                                <div class="info_data">
                                    <div class="row w-100">
                                        <div class="col-sm-12">
                                            <div class="data">
                                                <table class="table table-striped" id="table">
                                                    <tr>
                                                        <th>Name</th>
                                                        <td><?php echo e($user->name ?? '-'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Phone</th>
                                                        <td><?php echo e($user->phone ?? '-'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Gender</th>
                                                        <td><?php echo e($user->gender_type ?? '-'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Location</th>
                                                        <td><?php echo e($address ?? '-'); ?></td>
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
                <?php if($user?->orders != []): ?>
                <div class="projects">
                    <h3>Order Details</h3>
                    <div class="projects_data">
                        <div class="row w-100">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <div class="data">
                                        <table class="table table-striped" id="table">
                                            <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $user?->orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><a href="<?php echo e(route('order.show', $order->id)); ?>"><?php echo e($order->order_id); ?></a></td>
                                                <td><?php echo e($order->name); ?></td>
                                                <td><?php echo e($order?->cart?->category?->title); ?></td>
                                                <td>₹<?php echo e($order?->cart?->grant_total); ?></td>
                                                <td><?php echo e(config('constants.order_status')[$order->status] ?? ''); ?></td>
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
                <hr>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1290354.cloudwaysapps.com/bhqcygtvak/public_html/resources/views/admin/users/show.blade.php ENDPATH**/ ?>