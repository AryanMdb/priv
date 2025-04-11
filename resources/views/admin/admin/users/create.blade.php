@extends('admin.layouts.master')
<?php
use Illuminate\Support\Facades\Session;
?>
@section('contant')

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                    <h4 class="card-title">New User Register</h4>
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
                <!-- <p class="card-description"> Basic form elements </p> -->
                <form id="addUser" class="forms-sample" method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-5">

                                <div class="user-icon">
                                    <?php
                                    $profilePic = asset(config('constants.default_profile_image'));
                                    ?>
                                    <img src="{{ $profilePic }}" id="profile_image_cls" alt="img" width="100px" height="100px">
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
                                    placeholder="Full Name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail3">Mobile Number</label>
                                <input type="phone" class="form-control numeric" id="exampleInputPhone" name="phone"
                                    placeholder="Mobile Number" value="{{ old('phone') }}">
                                @if ($errors->has('phone'))
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Select Gender</label>
                                <select name="gender" id="gender" class="form-control" required>
                                    <option value="" class="form-label">Select Gender</option>
                                    @foreach (config('constants.gender') as $val)
                                        <option value="{{ $val['key'] }}">{{ $val['name'] }}
                                        </option>
                                    @endforeach
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
@endsection
