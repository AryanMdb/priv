
<?php
use Illuminate\Support\Facades\Session;
?>
<?php $__env->startSection('contant'); ?>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                    <h4 class="card-title">Edit Push Notifications</h4>
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

                <form id="editNotification" class="forms-sample" method="POST" action="<?php echo e(route('push_notification.update', $notificationData->id)); ?>">
                    <?php echo csrf_field(); ?>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" value="<?php echo e($notificationData->title ?? old('title')); ?>" id="title" name="title"
                                    placeholder="Title">
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail3">Message</label>
                                <textarea name="message" id="message" rows="10" class="form-control ckeditor"
                                    placeholder="Write your message.."><?php echo e($notificationData->message ?? old('message')); ?></textarea>
                                    <span id="descErr"></span>

                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary mr-2">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        CKEDITOR.replace('answer');

        $(document).ready(function() {


            $('#editNotification').validate({
                highlight: function(element) {
                    $(element).closest('.form-control').addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).closest('.form-control').removeClass('is-invalid');
                },
                rules: {
                    title:{
                        required:true
                    },
                    message: {
                        required: true,
                        minlength: 10,
                    },
                },
                messages: {
                    title: {
                        required: 'Please enter title',
                    },
                    message: {
                        required: 'Please enter message',
                    },
                }

            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1290354.cloudwaysapps.com/bhqcygtvak/public_html/resources/views/admin/push_notification/edit.blade.php ENDPATH**/ ?>