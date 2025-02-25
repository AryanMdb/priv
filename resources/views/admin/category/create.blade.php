@extends('admin.layouts.master')
<?php
use Illuminate\Support\Facades\Session;
?>
@section('contant')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                    <h4 class="card-title">New Category Create</h4>
                </div>

                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success</strong> {{ $message }}
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    </div>
                @endif
                @if ($errors->any())
                    @foreach ($errors->all() as $message)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error</strong> {{ $message }}
                            <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        </div>
                    @endforeach
                @endif

                <form id="addCategory" class="forms-sample" method="POST" action="{{ route('category.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-5">
                                <div class="user-icon">
                                    <?php
    $profilePic = asset(config('constants.default_image'));
    if (!empty($user->profile)) {
        if (Storage::exists(config('constants.profile_img_upload_path') . "/" . $user->profile)) {
            $profilePic = asset(config('constants.profile_img_display_path')) . '/' . $user->profile;
        }
    }
                                                                                            ?>
                                    <img src="{{ $profilePic }}" id="profile_image_cls" alt="img" width="100px"
                                        height="100px">
                                    <div class="img-upload">
                                        <input type="file" class="file h-none" name="image" id="profile-img">
                                        <label for="profile-img"><i role="button"
                                                class="icon-screen-desktop icon-camera"></i></label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title"
                                    value="{{ old('title') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="title">&nbsp;</label>
                            <div class="form-group mb-0 mt-2 pt-1">
                                <input type="checkbox" id="is_show" name="is_show" value="1">
                                <label for="name">Is Show</label>
                            </div>
                            <div class="form-group mb-0 mt-2 pt-1">
                                <input type="checkbox" id="coming_soon" name="coming_soon" value="1">
                                <label for="name">Coming Soon</label>
                            </div>
                        </div>

                        <div class="col-md-6 mt-5 mb-4">
                            <h3 class="mb-4">Set Your Delivery Time:</h3>
                            <div class="form-group">
                                <label for="delivery_time">Time</label>
                                <select class="form-control" name="delivery_time" id="delivery_time" required>
                                    <option value="">Select Time</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 mt-5 mb-4">
                            <h3 class="mb-4">Set Your Delivery Charges:</h3>
                            <div id="delivery-charge-container" class="col-md-12">
                                <div class="row delivery-charge-row">
                                    <div class="col-md-3 col-6 pl-0">
                                        <div class="form-group">
                                            <label for="min_value">Min Value</label>
                                            <input type="text" class="form-control numeric-input" name="min_value[]"
                                                placeholder="Set Min Range" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6 pl-0">
                                        <div class="form-group">
                                            <label for="max_value">Max Value</label>
                                            <input type="text" class="form-control numeric-input" name="max_value[]"
                                                placeholder="Set Max Range" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6 pl-0">
                                        <div class="form-group">
                                            <label for="delivery_charge">Delivery Charge</label>
                                            <input type="text" class="form-control numeric-input" name="delivery_charge[]"
                                                placeholder="Set Charges in Rs" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6 pl-0">
                                        <div class="form-group flex-column d-flex">
                                            <label for="title">&nbsp;</label>
                                            <a href="javascript:void(0);" style="width: fit-content"
                                                class="btn btn-danger mr-2 remove-row"><i class="fa fa-trash mr-2"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 d-flex pl-0">
                        <button type="submit" class="btn btn-primary mr-2 ">Submit</button>
                        <a href="javascript:void(0);" class="btn btn-dark mr-2" id="add-row"><i
                                class="fa fa-plus mr-2"></i></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $.validator.addMethod("alphaOnly", function (value, element) {
                return /^[A-Za-z\s!@#$%^&*]+$/.test(value);
            }, "Please enter only alphabets");

            $.validator.addMethod('imageDimensions', function (value, element, dimensions) {
                if (element.files && element.files[0]) {
                    var img = new Image();
                    img.src = window.URL.createObjectURL(element.files[0]);
                    return img.width <= dimensions[0] && img.height <= dimensions[1];
                }
                return true;
            }, function (dimensions) {
                return $.validator.format("Image dimensions should be maximum {0}x{1} pixels", dimensions[0], dimensions[1]);
            });

            $('#addCategory').validate({
                highlight: function (element) {
                    $(element).closest('.form-control').addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-control').removeClass('is-invalid');
                },
                rules: {
                    image: {
                        required: true,
                    },
                    title: {
                        required: true,
                        maxlength: 100
                    },

                    'min_value[]': {
                        // not required
                    },
                    'max_value[]': {
                        // not required
                    },
                    'delivery_charge[]': {
                        // not required
                    },
                    'min_distance_value[]': {
                        // not required
                    },
                    'max_distance_value[]': {
                        // not required
                    },
                    'distance_charge[]': {
                        // not required
                    }
                },
                messages: {
                    title: {
                        required: 'Please enter title',
                        maxlength: 'Title must be less than 100 characters',
                    },
                    image: {
                        required: "Please upload image",
                    }
                },
                errorPlacement: function (error, element) {
                    if (element.attr('name') === 'min_value[]' || element.attr('name') === 'max_value[]' || element.attr('name') === 'delivery_charge[]' || element.attr('name') === 'min_distance_value[]' || element.attr('name') === 'max_distance_value[]' || element.attr('name') === 'distance_charge[]') {
                        error.hide();
                        $(element).closest('.form-control').removeClass('is-invalid');
                    } else {
                        error.insertAfter(element);
                    }
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

            function updateDeleteButtonVisibility() {
                // Update the visibility of delete buttons for delivery charges
                if ($('.delivery-charge-row').length === 1) {
                    $('.delivery-charge-row .remove-row').hide();
                } else {
                    $('.delivery-charge-row .remove-row').show();
                }

                // Update the visibility of delete buttons for distance charges
                if ($('.distance-charge-row').length === 1) {
                    $('.distance-charge-row .remove-row').hide();
                } else {
                    $('.distance-charge-row .remove-row').show();
                }
            }

            updateDeleteButtonVisibility();

            $('#add-row').on('click', function () {
                var newRow = $('.delivery-charge-row:first').clone();
                newRow.find('input').val('');
                newRow.find('.remove-row').show();

                newRow.find('.remove-row').on('click', function () {
                    if ($('.delivery-charge-row').length > 1) {
                        newRow.remove();
                    } else {
                        alert("You cannot remove the last row.");
                    }
                    updateDeleteButtonVisibility();
                });

                $('#delivery-charge-container').append(newRow);
                updateDeleteButtonVisibility();
                addNumericValidation();
            });

            $('#add-distance-row').on('click', function () {
                var newRow = $('.distance-charge-row:first').clone();
                newRow.find('input').val('');
                newRow.find('.remove-row').show();

                newRow.find('.remove-row').on('click', function () {
                    if ($('.distance-charge-row').length > 1) {
                        newRow.remove();
                    } else {
                        alert("You cannot remove the last row.");
                    }
                    updateDeleteButtonVisibility();
                });

                $('#distance-charge-container').append(newRow);
                updateDeleteButtonVisibility();
                addNumericValidation();
            });

            function addNumericValidation() {
                $('.numeric-input').off('input').on('input', function () {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            }
            addNumericValidation();

            $('.remove-row').on('click', function () {
                var row = $(this).closest('.row');
                if ($(this).closest('#delivery-charge-container').length > 0) {
                    if ($('.delivery-charge-row').length > 1) {
                        row.remove();
                    } else {
                        alert("You cannot remove the last row.");
                    }
                } else if ($(this).closest('#distance-charge-container').length > 0) {
                    if ($('.distance-charge-row').length > 1) {
                        row.remove();
                    } else {
                        alert("You cannot remove the last row.");
                    }
                }
                updateDeleteButtonVisibility();
            });


        });


        //////////////// Delivry TIme //////////////////////////////

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
        });

        //////////////// Deliever Time //////////////////////////////
    </script>
@endsection