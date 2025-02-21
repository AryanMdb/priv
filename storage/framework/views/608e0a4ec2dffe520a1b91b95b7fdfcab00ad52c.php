
<?php
use Illuminate\Support\Facades\Session;
?>
<?php $__env->startSection('contant'); ?>

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                    <h4 class="card-title">Change Password</h4>
                </div>
                <?php if($message = Session::get('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success</strong> <?php echo e($message); ?>

                        <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    </div>
                <?php endif; ?>
                <?php if($errors->any()): ?>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error</strong> <?php echo e($message); ?>

                            <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                <!-- <p class="card-description"> Basic form elements </p> -->
                <form id="editPassword" class="forms-sample" method="POST" action="<?php echo e(route('changepassword.update')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputName1">Old Password</label>
                                <input type="password" class="form-control" id="old_password" name="old_password"
                                    placeholder="Old Password" value="">
                                <?php if($errors->has('old_password')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('old_password')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputName1">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password"
                                    placeholder="New Password" value="">
                                <?php if($errors->has('new_password')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('new_password')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputpassword">Confirm Password</label>
                                <input type="password" class="form-control" id="exampleInputpassword"
                                    name="confirm_new_password" value="" placeholder="Confirm Password">
                                <?php if($errors->has('confirm_new_password')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('confirm_new_password')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    $(document).ready(function() {

      
        $('#editPassword').validate({
            highlight: function(element) {
                $(element).closest('.form-control').addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).closest('.form-control').removeClass('is-invalid');
            },
            rules: {
                old_password: {
                    required: true,
                },
                new_password: {
                    required: true,
                    minlength: 6,
                },
                confirm_new_password: {
                    required: true,
                    minlength: 6,
                    equalTo: "#new_password",
                }
            },
            messages: {
                old_password: {
                    required: 'Please enter old password',
                },
                new_password: {
                    required: 'Please enter new password',
                    minlength: 'password minimum length is 6',
                },
                confirm_new_password: {
                    required: 'Please enter confirm password',
                    minlength: 'confirm password minimum length is 6',
                    equalTo: "Please enter the same value to password",
                }
            }

        });
    });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1290354.cloudwaysapps.com/bhqcygtvak/public_html/resources/views/admin/change-password.blade.php ENDPATH**/ ?>