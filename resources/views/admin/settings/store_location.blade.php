@extends('admin.layouts.master')
<?php use Illuminate\Support\Facades\Session; ?>
@section('contant')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                    <h4 class="card-title">Privykart Store Location</h4>
                </div>

                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success</strong> {{ $message }}
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                @endif

                <form id="addStoreLocation" class="forms-sample" method="POST" action="{{ route('store_location.update') }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- Latitude -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude">Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Latitude"
                                    value="{{ old('latitude', $store_location->latitude) }}">
                            </div>
                        </div>
                        <!-- Longitude -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude">Longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude"
                                    placeholder="Longitude" value="{{ old('longitude', $store_location->longitude) }}">
                            </div>
                        </div>
                        <!-- Delivery Radius -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="delivery_radius">Delivery Radius/Distance</label>
                                <input type="text" class="form-control" id="delivery_radius" name="delivery_radius"
                                    placeholder="Delivery Radius/Distance"
                                    value="{{ old('delivery_radius', $store_location->delivery_radius) }}">
                            </div>
                        </div>

                        <!-- Distance-Wise Charges Title -->
                        <div class="col-md-12 mb-4">
                            <h4 class="card-title">Distance Wise Charge</h4>
                        </div>

                        <!-- Existing distance rows -->
                        @php
                            $distances = json_decode($store_location->distance, true) ?: explode(',', $store_location->distance);
                            $charges = json_decode($store_location->distance_charge, true) ?: explode(',', $store_location->distance_charge);
                        @endphp

                        <div class="col-md-12" id="distance-rows">
                            @foreach ($distances as $index => $distance)
                                <div class="row distance-row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="distance">Distance Value in km</label>
                                            <input inputmode="numeric" oninput="this.value = this.value.replace(/\D+/g, '')"
                                                type="text" class="form-control distance number_value" name="distance[]"
                                                placeholder="Distance in Km" value="{{ old('distance.' . $index, $distance) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="charge">Distance Charge in Rs</label>
                                            <input inputmode="numeric" oninput="this.value = this.value.replace(/\D+/g, '')"
                                                type="text" class="form-control charge number_value" name="distance_charge[]"
                                                placeholder="Distance Charge"
                                                value="{{ old('distance_charge.' . $index, $charges[$index] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label for="">&nbsp;</label>
                                        <div class="form-group d-flex flex-column">
                                            <button type="button" class="btn btn-danger remove-row">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Add New Distance Button -->
                        <div class="col-md-3">
                            <div class="form-group d-flex flex-column">
                                <button type="button" class="btn btn-dark" id="add-row">
                                    <i class="fa fa-plus"></i> Add New Distance Row
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- JS Logic -->
    <script>
        $(document).ready(function () {
            const distanceRowTemplate = `
                                        <div class="row distance-row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="distance">Distance Value in km</label>
                                                    <input inputmode="numeric" oninput="this.value = this.value.replace(/\\D+/g, '')"
                                                        type="text" class="form-control distance number_value" name="distance[]" placeholder="Distance in Km">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="charge">Distance Charge in Rs</label>
                                                    <input inputmode="numeric" oninput="this.value = this.value.replace(/\\D+/g, '')"
                                                        type="text" class="form-control charge number_value" name="distance_charge[]" placeholder="Distance Charge">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <label for="">&nbsp;</label>
                                                <div class="form-group d-flex flex-column">
                                                    <button type="button" class="btn btn-danger remove-row">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    `;

            function toggleDeleteButton() {
                $('.remove-row').prop('disabled', $('.distance-row').length === 1)
                    .toggleClass('disabled', $('.distance-row').length === 1);
            }

            $('#add-row').on('click', function () {
                let $newRow = $(distanceRowTemplate);
                $('#distance-rows').append($newRow);

                // Validate the new inputs manually
                let deliveryRadius = getDeliveryRadius();

                let $distanceInput = $newRow.find("input[name='distance[]']");
                let $chargeInput = $newRow.find("input[name='distance_charge[]']");

                // Manually add rules for the new inputs
                $distanceInput.rules("add", {
                    required: true,
                    min: deliveryRadius || 1,
                    messages: {
                        required: "Please enter a distance value",
                        min: "Distance should be at least " + (deliveryRadius || 1) + " km"
                    }
                });

                $chargeInput.rules("add", {
                    required: true,
                    min: 1,
                    messages: {
                        required: "Please enter a charge value",
                        min: "Charge must be greater than 0"
                    }
                });

                // Trigger validation (optional)
                $("#addStoreLocation").validate().element($distanceInput);
                $("#addStoreLocation").validate().element($chargeInput);
                $("#addStoreLocation").validate().settings.ignore = "";
                $("#addStoreLocation").validate().element($distanceInput);


                toggleDeleteButton(); // Update remove button state
            });


            $(document).on('click', '.remove-row', function () {
                if ($('.distance-row').length > 1) {
                    $(this).closest('.distance-row').remove();
                    toggleDeleteButton();
                }
            });

            if ($('.distance-row').length === 0) {
                $('#distance-rows').append(distanceRowTemplate);
            }

            toggleDeleteButton();

            function getDeliveryRadius() {
                return parseFloat($('#delivery_radius').val()) || 0;
            }

            $('#addStoreLocation').validate({
                highlight: function (element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid');
                },
                rules: {
                    latitude: { required: true, maxlength: 11 },
                    longitude: { required: true, maxlength: 11 },
                    delivery_radius: { required: true, maxlength: 11 },
                    "distance[]": {
                        required: true,
                        min: () => parseFloat($("#delivery_radius").val()) || 1
                    },
                    "distance_charge[]": {
                        required: true,
                        min: 1
                    }
                },
                messages: {
                    latitude: { required: 'Please enter latitude' },
                    longitude: { required: 'Please enter longitude' },
                    delivery_radius: { required: 'Please enter delivery radius' },
                    "distance[]": {
                        required: "Please enter a distance value",
                        min: () => "Distance should be at least " + $("#delivery_radius").val() + " km"
                    },
                    "distance_charge[]": {
                        required: "Please enter a charge value",
                        min: "Charge must be greater than 0"
                    }
                },
                submitHandler: function (form) {
                    // First validate the entire form
                    if (!$(form).valid()) {
                        return false;
                    }

                    let deliveryRadius = getDeliveryRadius();
                    let isValid = true;

                    $("input[name='distance[]']").each(function () {
                        let val = parseFloat($(this).val()) || 0;
                        if ($(this).val() === "" || val < deliveryRadius) {
                            isValid = false;
                            $(this).addClass('is-invalid');
                        } else {
                            $(this).removeClass('is-invalid');
                        }
                    });

                    $("input[name='distance_charge[]']").each(function () {
                        let val = parseFloat($(this).val()) || 0;
                        if ($(this).val() === "" || val <= 0) {
                            isValid = false;
                            $(this).addClass('is-invalid');
                        } else {
                            $(this).removeClass('is-invalid');
                        }
                    });

                    return isValid;
                }



            });

            $(document).on('input', "input[name='distance[]']", function () {
                const val = parseFloat($(this).val()) || 0;
                const min = getDeliveryRadius();
                $(this).toggleClass('is-invalid', val < min).closest('.form-control').toggleClass('is-invalid', val < min);
            });

            $(document).on('input', "input[name='distance_charge[]']", function () {
                const val = parseFloat($(this).val()) || 0;
                const min = 0;
                $(this).toggleClass('is-invalid', val <= 0).closest('.form-control').toggleClass('is-invalid', val <= 0);
            });
        });
    </script>
@endsection