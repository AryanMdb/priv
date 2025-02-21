@extends('admin.layouts.master')
<?php
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
?>
@section('contant')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
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

                <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                    <h4 class="card-title">Edit USER Detail's</h4>
                </div>

                <!-- <p class="card-description"> Basic form elements </p> -->
                <form id="editUser" class="forms-sample" method="POST" enctype="multipart/form-data"
                    action="{{ route('user.update', $user->id) }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="user-icon">
                                    <?php
                                    $profilePic = asset(config('constants.default_profile_image'));
                                    if (!empty($user->image)) {
                                        $imagePath = public_path('storage/profile_image') . '/' . $user->image;
                                    
                                        if (File::exists($imagePath)) {
                                            $profilePic = asset('storage/profile_image/' . $user->image);
                                        }
                                    }
                                    ?>
                                    <input type="hidden" value="{{ $user->image }}" name="old_profile">
                                    <img src="{{ $profilePic }}" id="profile_image_cls" alt="img" width="100px"
                                        height="100px">


                                    <div class="img-upload">
                                        <input type="file" class="file" name="image" id="profile-img">
                                        <label for="profile-img"><i class="icon-screen-desktop icon-camera"></i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputName1">Name</label>
                                <input type="text" class="form-control" id="exampleInputName" name="name"
                                    placeholder="Full Name" value="{{ $user->name }}">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail3">Mobile Number</label>
                                <input type="phone" class="form-control numeric" id="exampleInputPhone" name="phone"
                                    value="{{ $user->phone }}" placeholder="Mobile Number">
                                @if ($errors->has('phone'))
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select placeholder="Gender" class="form-control select2-selection--single select-gender"
                                    name="gender">
                                    <option value="">Select Gender</option>
                                    @foreach (config('constants.gender') as $val)
                                        <option value="{{ $val['key'] }}" {{$val['key'] == $user->gender ? 'selected' : ''}}>{{ $val['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('gender'))
                                    <span class="text-danger">{{ $errors->first('gender') }}</span>
                                @endif
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
            return /^[A-Za-z\s]+$/.test(value);
            }, "Please enter only alphabets");
            $('#editUser').validate({
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

                },
                messages: {
                    name: {
                        required: 'Please enter name',
                    },
                }

            });

            $("#profile-img").change(function() {
                profileImgReadURL(this);
            });


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
