
<?php
use Illuminate\Support\Facades\File;
?>
<?php $__env->startSection('contant'); ?>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                    <h4 class="card-title">Edit</h4>
                </div>

                <?php if($errors->any()): ?>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error</strong> <?php echo e($message); ?>

                            <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

                <form id="edit" class="forms-sample" method="POST" action="<?php echo e(route('manage_forms.update', $manage_form->id)); ?>"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title"
                                    value=" <?php echo e($manage_form?->category?->title ?? ''); ?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-12 row">
                            <div class="main-permissions col-md-4 mb-3">
                                <div class="border h-100 p-3">
                                    <h4 class="border-bottom pb-2 mb-3">Form Fields</h4>
                                    <div class="form-group">
                                        <?php $__currentLoopData = config('constants.input_fields'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <input type="checkbox" id="<?php echo e($value); ?>" name="input_field[]" value="<?php echo e($key); ?>"
                                                <?php echo e(in_array($key, $manage_fields->pluck('input_field')->toArray()) ? 'checked' : ''); ?>>
                                            <label for="<?php echo e($value); ?>"><?php echo e(ucfirst(str_replace('_', ' ', $value))); ?></label><br>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                    </div>
                                </div>
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
    <script>
        $(document).ready(function() {

            $.validator.addMethod("alphaOnly", function(value, element) {
                return /^[A-Za-z\s!@#$%^&*]+$/.test(value);
            }, "Please enter only alphabets");

            $('#editCategory').validate({
                highlight: function(element) {
                    $(element).closest('.form-control').addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).closest('.form-control').removeClass('is-invalid');
                },
                rules: {
                    category_id: {
                        required: false,
                    },
                },
                messages: {
                    category_id: {
                        required: 'Please select category',
                    },
                }

            });

            $("#profile-img").change(function() {
                profileImgReadURL(this);
            });

            function profileImgReadURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#profile_image_cls').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1290354.cloudwaysapps.com/bhqcygtvak/public_html/resources/views/admin/manage_forms/edit.blade.php ENDPATH**/ ?>