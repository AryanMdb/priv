
<?php
use Illuminate\Support\Facades\Session;
?>
<?php $__env->startSection('contant'); ?>
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                <h4 class="card-title">Minimum Order Value</h4>
            </div>
            <?php if($message = Session::get('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success</strong> <?php echo e($message); ?>

                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
            <?php endif; ?>
            <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <form id="edit_min_value" class="forms-sample" method="POST" action="<?php echo e(route('min_order_add')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputName1">Value</label>
                                <input type="text" class="form-control" id="min_value" name="min_value"
                                    placeholder="Enter Minimum Order Value" value="<?php echo e($item->minimum_order_value); ?>">
                                <?php if($errors->has('min_value')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('min_value')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        </div>
                    </div>
                </form>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#edit_min_value').validate({
            highlight: function (element) {
                $(element).closest('.form-control').addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).closest('.form-control').removeClass('is-invalid');
            },
            rules: {
                min_value: {
                    required: true,
                    number: true,
                },
            },
            messages: {
                min_value: {
                    required: 'Please enter Minimum Value',
                    number: 'Only numeric values are allowed',
                },
            }
        });

        $('#min_value').on('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\priv\resources\views/admin/settings/min_order.blade.php ENDPATH**/ ?>