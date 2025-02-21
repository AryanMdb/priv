
<?php
use Illuminate\Support\Facades\File;
?>
<?php $__env->startSection('contant'); ?>
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">

            <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                <h4 class="card-title">SubCategory Edit</h4>
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

            <form id="editSubCategory" class="forms-sample" method="POST"
                action="<?php echo e(route('subcategory.update', $subcategory->id)); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="user-icon">
                                <?php
$profilePic = asset(config('constants.default_image'));
if (!empty($subcategory->image)) {
    $imagePath = public_path('storage/subcategory') . '/' . $subcategory->image;

    if (File::exists($imagePath)) {
        $profilePic = asset('storage/subcategory/' . $subcategory->image);
    }
}
                                    ?>
                                <img src="<?php echo e($profilePic); ?>" id="profile_image_cls" alt="img" width="100px"
                                    height="100px">
                                <div class="img-upload">
                                    <input type="hidden" id="old_img" name="old_img" value="<?php echo e($subcategory->image); ?>">
                                    <input type="file" class="file" name="image" id="profile-img">
                                    <label for="profile-img"><i class="icon-screen-desktop icon-camera"></i></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Select Category</label>
                            <select name="category_id" class="form-control">
                                <option value="" class="form-label">Select Category</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>" <?php echo e($category->id == $subcategory->category_id ? 'selected' : ''); ?>><?php echo e($category->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title"
                                value="<?php if(isset($subcategory->title)): ?> <?php echo e($subcategory->title); ?> <?php endif; ?>">
                            <?php if($errors->has('title')): ?>
                                <span class="text-danger"><?php echo e($errors->first('title')); ?></span>
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
<script>
    $(document).ready(function () {

        $.validator.addMethod("alphaOnly", function (value, element) {
            return /^[A-Za-z\s]+$/.test(value);
        }, "Please enter only alphabets");

        $('#editSubCategory').validate({
            highlight: function (element) {
                $(element).closest('.form-control').addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).closest('.form-control').removeClass('is-invalid');
            },
            rules: {
                image: {
                    required: function (element) {
                        return $("#old_img").val() === '';
                    }
                },
                title: {
                    required: true,
                    maxlength: 100,
                    // alphaOnly: true,
                },
                category_id: {
                    required: true
                },
            },
            messages: {
                title: {
                    required: 'Please enter title',
                },
                image: {
                    required: "Please upload image"
                },
                category_id: {
                    required: "Please select category"
                },
            }
        });

        $("#profile-img").change(function () {
            profileImgReadURL(this);
        });

        function profileImgReadURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#profile_image_cls').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1290354.cloudwaysapps.com/bhqcygtvak/public_html/resources/views/admin/subcategory/edit.blade.php ENDPATH**/ ?>