
<?php
use Illuminate\Support\Facades\Session;
?>
<?php $__env->startSection('contant'); ?>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                    <h4 class="card-title">Privykart Store Location</h4>
                </div>
                <?php if($message = Session::get('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success</strong> <?php echo e($message); ?>

                        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                <?php endif; ?>

                <form id="addStoreLocation" class="forms-sample" method="POST" action="<?php echo e(route('store_location.update')); ?>"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude">Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Latitude"
                                    value="<?php echo e(old('latitude', $store_location->latitude)); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude">Longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude"
                                    placeholder="Longitude" value="<?php echo e(old('longitude', $store_location->longitude)); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="delivery_radius">Delivery Radius/Distance</label>
                                <input type="text" class="form-control" id="delivery_radius" name="delivery_radius"
                                    placeholder="Delivery Radius/Distance"
                                    value="<?php echo e(old('delivery_radius', $store_location->delivery_radius)); ?>">
                            </div>
                        </div>

                        <div class="col-md-12 mb-4">
                            <h4 class="card-title">Distance Wise Charge</h4>
                        </div>

                        <?php
                            $distances = json_decode($store_location->distance, true) ?: explode(',', $store_location->distance);
                            $charges = json_decode($store_location->distance_charge, true) ?: explode(',', $store_location->distance_charge);
                        ?>

                        <!-- Loop through the distance and charge data -->
                        <div class="col-md-12" id="distance-rows">
                            <?php $__currentLoopData = $distances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $distance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="row distance-row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="distance">Distance Value in km</label>
                                            <input inputmode="numeric" oninput="this.value = this.value.replace(/\D+/g, '')" type="text" class="form-control distance number_value" name="distance[]"
                                                placeholder="Distance in Km" value="<?php echo e(old('distance.' . $index, $distance)); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="charge">Distance Charge in Rs</label>
                                            <input inputmode="numeric" oninput="this.value = this.value.replace(/\D+/g, '')" type="text" class="form-control charge number_value" name="distance_charge[]"
                                                placeholder="Distance Charge"
                                                value="<?php echo e(old('distance_charge.' . $index, $charges[$index] ?? '')); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label for="">&nbsp;</label>
                                        <div class="form-group flex-column d-flex ">
                                            <button type="button" class="btn btn-danger remove-row">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group flex-column d-flex">
                                <button type="button" class="btn btn-dark" id="add-row">
                                    <i class="fa fa-plus"></i> Add New Distance Row
                                </button>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            let distanceRowTemplate = `
                <div class="row distance-row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="distance">Distance Value in km</label>
                            <input inputmode="numeric" oninput="this.value = this.value.replace(/\D+/g, '')" type="text" class="form-control distance number_value" name="distance[]" placeholder="Distance in Km">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="charge">Distance Charge in Rs</label>
                            <input inputmode="numeric" oninput="this.value = this.value.replace(/\D+/g, '')" type="text" class="form-control charge number_value" name="distance_charge[]" placeholder="Distance Charge">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <label for="">&nbsp;</label>
                        <div class="form-group flex-column d-flex">
                            <button type="button" class="btn btn-danger remove-row">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;

            function toggleDeleteButton() {
                if ($('.distance-row').length === 1) {
                    $('.remove-row').prop('disabled', true).addClass('disabled');
                } else {
                    $('.remove-row').prop('disabled', false).removeClass('disabled');
                }
            }

            // Add row
            $('#add-row').on('click', function () {
                $('#distance-rows').append(distanceRowTemplate);
                toggleDeleteButton(); // Update button state
            });

            // Remove row
            $(document).on('click', '.remove-row', function () {
                if ($('.distance-row').length > 1) {
                    $(this).closest('.distance-row').remove();
                    toggleDeleteButton(); // Update button state
                }
            });

            // If no rows exist, add a default row
            if ($('.distance-row').length === 0) {
                $('#distance-rows').append(distanceRowTemplate);
            }

            toggleDeleteButton();

            $('#addStoreLocation').validate({
                highlight: function (element) {
                    $(element).closest('.form-control').addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-control').removeClass('is-invalid');
                },
                rules: {
                    latitude: {
                        required: true,
                        maxlength: 11
                    },
                    longitude: {
                        required: true,
                        maxlength: 11
                    },
                    delivery_radius: {
                        required: true,
                        maxlength: 11
                    },
                    "distance[]": {
                        min: 8
                    },
                },
                messages: {
                    latitude: {
                        required: 'Please enter latitude',
                    },
                    longitude: {
                        required: "Please enter longitude",
                    },
                    delivery_radius: {
                        required: "Please enter delivery radius",
                    },
                    "distance[]": {
                        min: "Distance should be at least 8 km"
                    },
                },

                submitHandler: function (form) {
                    let valid = true;


                    $("input[name='distance[]']").each(function () {
                        if ($(this).val() && $(this).val() < 8) {
                            valid = false;
                            $(this).addClass('is-invalid');
                            $(this).closest('.form-control').addClass('is-invalid');
                            return false;
                        }
                    });

                    if (valid) {
                        form.submit();
                    }
                }

            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1290354.cloudwaysapps.com/bhqcygtvak/public_html/resources/views/admin/settings/store_location.blade.php ENDPATH**/ ?>