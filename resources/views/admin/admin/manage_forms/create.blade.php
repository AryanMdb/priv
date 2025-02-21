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

                <form id="addCategory" class="forms-sample" method="POST" action="{{ route('manage_forms.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Select Category</label>
                                <select name="category_id" class="form-control">
                                        <option value="" class="form-label">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-12 row">
                            <div class="main-permissions col-md-3 mb-3">
                                <div class="border h-100 p-3">
                                    <h4 class="border-bottom pb-2 mb-3">Form Fields</h4>
                                    <div class="form-group">
                                        @foreach(config('constants.input_fields') as $key => $value)
                                        <input type="checkbox" id="name" name="input_field[]" value= "{{ $key }}">
                                        <label for="title">{{ $value }}</label><br>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" onclick="disableButton(this)" class="btn btn-primary mr-2">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
          function disableButton(button) {
            button.disabled = true;
            button.innerHTML = 'Submitting...';
            button.form.submit();
        }
        $(document).ready(function() {

            $.validator.addMethod("alphaOnly", function(value, element) {
                return /^[A-Za-z\s!@#$%^&*]+$/.test(value);
            }, "Please enter only alphabets");

            $('#addCategory').validate({
                highlight: function(element) {
                    $(element).closest('.form-control').addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).closest('.form-control').removeClass('is-invalid');
                },
                rules: {
                    category_id: {
                        required: true,
                    },
                },
                messages: {
                    category_id: {
                        required: 'Please select category',
                    },
                },       
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
