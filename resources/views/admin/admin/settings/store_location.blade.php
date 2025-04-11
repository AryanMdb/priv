@extends('admin.layouts.master')
<?php
use Illuminate\Support\Facades\Session;
?>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="latitude">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Latitude"
                                value="{{ old('latitude', $store_location->latitude) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="longitude">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude"
                                placeholder="Longitude" value="{{ old('longitude', $store_location->longitude) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="delivery_radius">Delivery Radius/Distance</label>
                            <input type="text" class="form-control" id="delivery_radius" name="delivery_radius"
                                placeholder="Delivery Radius/Distance"
                                value="{{ old('delivery_radius', $store_location->delivery_radius) }}">
                        </div>
                    </div>

                    <div class="col-md-12 mb-4">
                        <h4 class="card-title">Distance Wise Charge</h4>
                    </div>

                    @php
                        $distances = json_decode($store_location->distance, true) ?: explode(',', $store_location->distance);
                        $charges = json_decode($store_location->distance_charge, true) ?: explode(',', $store_location->distance_charge);
                    @endphp

                    <!-- Loop through the distance and charge data -->
                    <div class="col-md-12" id="distance-rows">
                        @foreach ($distances as $index => $distance)
                            <div class="row distance-row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="distance">Distance Value in km</label>
                                        <input type="text" class="form-control distance" name="distance[]"
                                            placeholder="Distance in Km" value="{{ old('distance.' . $index, $distance) }}">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="charge">Distance Charge in Rs</label>
                                        <input type="text" class="form-control charge" name="distance_charge[]"
                                            placeholder="Distance Charge"
                                            value="{{ old('distance_charge.' . $index, $charges[$index] ?? '') }}">
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
                        @endforeach
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
                    <input type="text" class="form-control distance" name="distance[]" placeholder="Distance in Km">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="charge">Distance Charge in Rs</label>
                    <input type="text" class="form-control charge" name="distance_charge[]" placeholder="Distance Charge">
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
@endsection