
<?php
use Illuminate\Support\Facades\File;
?>
<?php $__env->startSection('contant'); ?>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                    <h4 class="card-title">Category Edit</h4>
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

                <form id="editCategory" class="forms-sample" method="POST"
                    action="<?php echo e(route('category.update', $categories->id)); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-5">
                                <div class="user-icon">
                                    <?php
    $profilePic = asset(config('constants.default_image'));
    if (!empty($categories->image)) {
        $imagePath = public_path('storage/category') . '/' . $categories->image;

        if (File::exists($imagePath)) {
            $profilePic = asset('storage/category/' . $categories->image);
        }
    }
                                                                                                                                                        ?>
                                    <img src="<?php echo e($profilePic); ?>" id="profile_image_cls" alt="img" width="100px"
                                        height="100px">
                                    <div class="img-upload">
                                        <input type="hidden" name="old_img" value="<?php echo e($categories->image); ?>">
                                        <input type="file" class="file h-none" name="image" id="profile-img">
                                        <label for="profile-img"><i class="icon-screen-desktop icon-camera"></i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title"
                                    value="<?php if(isset($categories->title)): ?> <?php echo e($categories->title); ?> <?php endif; ?>">
                                <?php if($errors->has('title')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('title')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="title">&nbsp;</label>
                            <div class="form-group mb-0 mt-2 pt-1">
                                <input type="checkbox" id="is_show" name="is_show" value="1" <?php echo e(isset($categories) && $categories->is_show == 1 ? 'checked' : ''); ?>>
                                <label for="name">Is Show</label>
                            </div>
                            <div class="form-group mb-0 mt-2 pt-1">
                                <input type="checkbox" id="coming_soon" name="coming_soon" value="1" <?php echo e(isset($categories) && $categories->coming_soon == 1 ? 'checked' : ''); ?>>
                                <label for="name">Coming Soon</label>
                            </div>
                        </div>


                        <div class="col-md-12 mt-5 mb-4">
                            <h3 class="mb-4">Set Your Delivery Time:</h3>
                            <div class="form-group">
                                <label for="delivery_time">Time</label>
                                <select class="form-control" name="delivery_time" id="delivery_time" required>
                                    <option value="">Select Time</option>
                                </select>
                            </div>
                        </div>

                        <?php
                            $minValues = json_decode($categories->min_value, true) ?: explode(',', $categories->min_value);
                            $maxValues = json_decode($categories->max_value, true) ?: explode(',', $categories->max_value);
                            $deliveryCharges = json_decode($categories->delivery_charge, true) ?: explode(',', $categories->delivery_charge);
                        ?>

                        <div class="col-md-12 mt-5">
                            <h3 class="mb-4">Your Delivery Charges:</h3>
                            <div id="delivery-charge-container" class="col-md-12">
                                <?php $__currentLoopData = $deliveryCharges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $charge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="row delivery-charge-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="min_value">Min Value</label>
                                                <input type="text" class="form-control" name="min_value[]"
                                                    placeholder="Set Min Range" required value="<?php echo e($minValues[$index]); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="max_value">Max Value</label>
                                                <input type="text" class="form-control" name="max_value[]"
                                                    placeholder="Set Max Range" required value="<?php echo e($maxValues[$index]); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="delivery_charge">Delivery Charge</label>
                                                <input type="text" class="form-control" name="delivery_charge[]"
                                                    placeholder="Set Charges in Rs" required value="<?php echo e($charge); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group flex-column d-flex">
                                                <label for="title">&nbsp;</label>
                                                <a href="javascript:void(0);" class="btn btn-danger mr-2 remove-row">
                                                    <i class="fa fa-minus mr-2"></i>Remove Row
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group flex-column d-flex">
                                    <a href="javascript:void(0);" class="btn btn-dark mr-2" id="add-row">
                                        <i class="fa fa-plus mr-2"></i>Add New Row
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary mr-2 ">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            // Assigning the PHP values to JavaScript variables
            var minValues = <?php echo json_encode($minValues); ?>;
            var maxValues = <?php echo json_encode($maxValues); ?>;
            var deliveryCharges = <?php echo json_encode($deliveryCharges); ?>;

            // Validator for form
            $.validator.addMethod("alphaOnly", function (value, element) {
                return /^[A-Za-z\s!@#$%^&*]+$/.test(value);
            }, "Please enter only alphabets");

            $('#editCategory').validate({
                highlight: function (element) {
                    $(element).closest('.form-control').addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-control').removeClass('is-invalid');
                },
                rules: {
                    image: { required: false },
                    title: { required: true, maxlength: 100 },
                },
                messages: {
                    title: { required: 'Please enter title', maxlength: 'Title must be less than 100 characters' },
                    image: { required: "Please upload an image" },
                }
            });

            // Image preview handler
            $("#profile-img").change(function () {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#profile_image_cls').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Functions to create rows
            function createRow(minValue = "", maxValue = "", deliveryCharge = "") {
                return `
                                                                                                                                    <div class="row delivery-charge-row">
                                                                                                                                        <div class="col-md-6">
                                                                                                                                            <div class="form-group">
                                                                                                                                                <label for="min_value">Min Value</label>
                                                                                                                                                <input type="text" class="form-control numeric-input" name="min_value[]" placeholder="Set Min Range" required value="${minValue}">
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                        <div class="col-md-6">
                                                                                                                                            <div class="form-group">
                                                                                                                                                <label for="max_value">Max Value</label>
                                                                                                                                                <input type="text" class="form-control numeric-input" name="max_value[]" placeholder="Set Max Range" required value="${maxValue}">
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                        <div class="col-md-6">
                                                                                                                                            <div class="form-group">
                                                                                                                                                <label for="delivery_charge">Delivery Charge</label>
                                                                                                                                                <input type="text" class="form-control numeric-input" name="delivery_charge[]" placeholder="Set Charges in Rs" required value="${deliveryCharge}">
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                        <div class="col-md-6">
                                                                                                                                            <div class="form-group flex-column d-flex">
                                                                                                                                                <label for="title">&nbsp;</label>
                                                                                                                                                <a href="javascript:void(0);" class="btn btn-danger mr-2 remove-row">
                                                                                                                                                    <i class="fa fa-minus mr-2"></i>Remove Row
                                                                                                                                                </a>
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                    </div>`;
            }

            // Function to update visibility of the remove button
            function updateDeleteButtonVisibility(container) {
                if ($(container + ' .row').length === 1) {
                    $(container + ' .remove-row').hide();
                } else {
                    $(container + ' .remove-row').show();
                }
            }

            // Initializing the rows with pre-filled data
            function initializeRows(container, minValues, maxValues, deliveryCharges) {
                $(container).empty();
                for (let i = 0; i < minValues.length; i++) {
                    let newRow = createRow(minValues[i], maxValues[i], deliveryCharges[i]);
                    $(container).append(newRow);
                }
                updateDeleteButtonVisibility(container);
                addNumericValidation();
            }

            // Add event listeners for remove and add row
            function addEventListeners() {
                $('#delivery-charge-container').on('click', '.remove-row', function () {
                    let row = $(this).closest('.row');
                    if ($(this).closest('.row').siblings('.row').length > 0) {
                        row.remove();
                    } else {
                        alert("You cannot remove the last row.");
                    }
                    updateDeleteButtonVisibility('#delivery-charge-container');
                });

                $('#add-row').on('click', function () {
                    let newRow = createRow();
                    $('#delivery-charge-container').append(newRow);
                    updateDeleteButtonVisibility('#delivery-charge-container');
                });
            }

            // Numeric input validation
            function addNumericValidation() {
                $('.numeric-input').off('input').on('input', function () {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            }

            // Initialize the form with existing data
            initializeRows('#delivery-charge-container', minValues, maxValues, deliveryCharges);
            addEventListeners();
        });


        // /////////////////////// DELIVERY TIME /////////////////////////////////////////////#

        document.addEventListener("DOMContentLoaded", function () {
            function generateTimeSlots() {
                const slots = [];
                for (let i = 0; i < 24; i++) {
                    const period = i < 12 ? "AM" : "PM";
                    const hour = i % 12 === 0 ? 12 : i % 12;
                    slots.push(`${hour}:00 ${period}`);
                    slots.push(`${hour}:30 ${period}`);
                }
                return slots;
            }

            const timeSelect = document.getElementById("delivery_time");
            const times = generateTimeSlots();

            times.forEach(function (time) {
                const option = document.createElement("option");
                option.value = time;
                option.textContent = time;
                timeSelect.appendChild(option);
            });

            const selectedTime = "<?php echo e(old('delivery_time', (isset($categories) && !empty($categories->delivery_time)) ? date('g:i A', strtotime($categories->delivery_time)) : '')); ?>";
            if (selectedTime) {
                timeSelect.value = selectedTime;
            }
        });

    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1290354.cloudwaysapps.com/bhqcygtvak/public_html/resources/views/admin/category/edit.blade.php ENDPATH**/ ?>