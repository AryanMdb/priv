@extends('admin.layouts.master')
<?php
use Illuminate\Support\Facades\File;
?>
@section('contant')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                    <h4 class="card-title">Edit</h4>
                </div>

                @if ($errors->any())
                    @foreach ($errors->all() as $message)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error</strong> {{ $message }}
                            <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        </div>
                    @endforeach
                @endif

                <form id="edit" class="forms-sample" method="POST" action="{{ route('manage_forms.update', $manage_form->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title"
                                    value=" {{ $manage_form?->category?->title ?? '' }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-12 row">
                            <div class="main-permissions col-md-4 mb-3">
                                <div class="border h-100 p-3">
                                    <h4 class="border-bottom pb-2 mb-3">Form Fields</h4>
                                    <div class="form-group">
                                        @foreach(config('constants.input_fields') as $key => $value)
                                            <input type="checkbox" id="{{ $value }}" name="input_field[]" value="{{ $key }}"
                                                {{ in_array($key, $manage_fields->pluck('input_field')->toArray()) ? 'checked' : '' }}>
                                            <label for="{{ $value }}">{{ ucfirst(str_replace('_', ' ', $value)) }}</label><br>
                                        @endforeach
                                        {{-- @foreach(['name', 'phone', 'location', 'description', 'address_to', 'address_from', 'property_address', 'property_details', 'expected_cost'] as $field)
                                            <input type="checkbox" id="{{ $field }}" name="input_field[]" value="{{ $field }}"
                                                {{ in_array($field, $manage_fields->pluck('input_field')->toArray()) ? 'checked' : '' }}>
                                            <label for="{{ $field }}">{{ ucfirst(str_replace('_', ' ', $field)) }}</label><br>
                                        @endforeach --}}
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

@endsection
