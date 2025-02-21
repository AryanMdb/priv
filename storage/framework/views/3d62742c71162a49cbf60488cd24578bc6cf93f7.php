
<?php
use Illuminate\Support\Facades\Session;
?>
<?php $__env->startSection('contant'); ?>
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">

            <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                <h4 class="card-title">Delivery Charges</h4>
            </div>
            <?php if($message = Session::get('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success</strong> <?php echo e($message); ?>

                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
            <?php endif; ?>
            

            <form id="delivery_charges" class="forms-sample" method="POST" action="<?php echo e(route('delivery_charges.update')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="row">
                    <div class="col-8 col-xl-4">
                        <div class="form-group">
                            <label>Range</label>
                        </div>
                    </div>
                    <div class="col-4 col-xl-3">
                        <div class="form-group">
                            <label>Charge (in rupees)</label>
                        </div>
                    </div>
                </div>
            
                <?php $__currentLoopData = $deliveryCharges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deliveryCharge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="row">
                        <div class="col-4 col-xl-2">
                            <div class="form-group">
                                <input type="hidden" name="ids[]" value="<?php echo e($deliveryCharge->id); ?>">
                                <input type="text" class="form-control" name="from_price[]" value="<?php echo e($deliveryCharge->from_price); ?>" disabled>
                            </div>
                        </div>
                        <div class="col-4 col-xl-2">
                            <div class="form-group">
                                <input type="text" class="form-control" name="to_price[]" value="<?php echo e($deliveryCharge->to_price); ?>" disabled>
                            </div>
                        </div>
                        <div class="col-4 col-xl-3">
                            <div class="form-group">
                                <input type="text" class="form-control numeric" name="delivery_charges[]" value="<?php echo e($deliveryCharge->delivery_charges); ?>">
                            </div>
                        </div>
                        <div class="col-2 col-xl-5">
                            <?php if($errors->has('delivery_charges.' . $loop->index)): ?>
                                <div class="alert alert-danger" role="alert">
                                    <strong>Error:</strong> <?php echo e($errors->first('delivery_charges.' . $loop->index)); ?>

                                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                            <?php endif; ?>
                        </div>
        
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="colmd">
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1290354.cloudwaysapps.com/bhqcygtvak/public_html/resources/views/admin/delivery_charges/form.blade.php ENDPATH**/ ?>