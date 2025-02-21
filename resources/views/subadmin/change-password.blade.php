@extends('subadmin.layouts.master')
<?php
use Illuminate\Support\Facades\Session;
?>
@section('contant')

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                    <h4 class="card-title">Change Password</h4>
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
                <form id="editPassword" class="forms-sample" method="POST" action="{{ route('changepassword.update') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputName1">Old Password</label>
                                <input type="password" class="form-control" id="old_password" name="old_password"
                                    placeholder="Old Password" value="">
                                @if ($errors->has('old_password'))
                                    <span class="text-danger">{{ $errors->first('old_password') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputName1">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password"
                                    placeholder="New Password" value="">
                                @if ($errors->has('new_password'))
                                    <span class="text-danger">{{ $errors->first('new_password') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputpassword">Confirm Password</label>
                                <input type="password" class="form-control" id="exampleInputpassword"
                                    name="confirm_new_password" value="" placeholder="Confirm Password">
                                @if ($errors->has('confirm_new_password'))
                                    <span class="text-danger">{{ $errors->first('confirm_new_password') }}</span>
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

    <script type="text/javascript">
    $(document).ready(function() {

      
        $('#editPassword').validate({
            highlight: function(element) {
                $(element).closest('.form-control').addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).closest('.form-control').removeClass('is-invalid');
            },
            rules: {
                old_password: {
                    required: true,
                },
                new_password: {
                    required: true,
                    minlength: 6,
                },
                confirm_new_password: {
                    required: true,
                    minlength: 6,
                    equalTo: "#new_password",
                }
            },
            messages: {
                old_password: {
                    required: 'Please enter old password',
                },
                new_password: {
                    required: 'Please enter new password',
                    minlength: 'password minimum length is 6',
                },
                confirm_new_password: {
                    required: 'Please enter confirm password',
                    minlength: 'confirm password minimum length is 6',
                    equalTo: "Please enter the same value to password",
                }
            }

        });
    });
    </script>
@endsection
