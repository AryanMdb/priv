
<?php
use Illuminate\Support\Facades\Session;
?>
<?php $__env->startSection('contant'); ?>

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                    <h4 class="card-title">New Vendor Register</h4>
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
                <form id="addUser" class="forms-sample" method="POST" action="<?php echo e(route('user.store')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-5">

                                <div class="user-icon">
                                    <?php
                                    $profilePic = asset(config('constants.default_profile_image'));
                                    ?>
                                    <img src="<?php echo e($profilePic); ?>" id="profile_image_cls" alt="img" width="100px" height="100px">
                                    <div class="img-upload">
                                        <input type="file" class="file h-none" name="image" id="profile-img">
                                        <label for="profile-img"><i role="button" class="icon-screen-desktop icon-camera"></i></label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputName1">Name</label>
                                <input type="text" class="form-control" id="exampleInputName" name="name"
                                    placeholder="Full Name" value="<?php echo e(old('name')); ?>">
                                <?php if($errors->has('name')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('name')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail3">Mobile Number</label>
                                <input type="phone" class="form-control numeric" id="exampleInputPhone" name="phone"
                                    placeholder="Mobile Number" value="<?php echo e(old('phone')); ?>">
                                <?php if($errors->has('phone')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('phone')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail3">Email</label>
                                <input type="email" class="form-control numeric" name="email"
                                    placeholder="Email Address" value="<?php echo e(old('email')); ?>">
                                <?php if($errors->has('email')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('email')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail3">Password</label>
                                <input type="password" class="form-control numeric" name="password"
                                    placeholder="Password" value="<?php echo e(old('password')); ?>">
                                <?php if($errors->has('password')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('password')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Select Gender</label>
                                <select name="gender" id="gender" class="form-control" required>
                                    <option value="" class="form-label">Select Gender</option>
                                    <?php $__currentLoopData = config('constants.gender'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($val['key']); ?>"><?php echo e($val['name']); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
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
        $.validator.addMethod("alphaOnly", function(value, element) {
            return /^[A-Za-z\s]+$/.test(value);
            }, "Please enter only alphabets");
        $('#addUser').validate({
            highlight: function(element) {
                $(element).closest('.form-control').addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).closest('.form-control').removeClass('is-invalid');
            },
            rules: {
                name: {
                    required: true,
                    alphaOnly:true,
                    maxlength: 100,
                },
                phone: {
                    required: true,
                    maxlength: 10,
                    number: true,
                },
                gender:{
                    required:true
                },
                image: {
                    required: true,
                },

            },
            messages: {
                name: {
                    required: 'Please enter name',
                },
                phone: {
                    required: 'please enter phone number',
                    maxlength: 'maximum phone number length is 10',
                    number: 'pleae enter phone number in numbers',
                },

            }

        });
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

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\The Mad Brains\priv\resources\views/admin/vendors/create.blade.php ENDPATH**/ ?>