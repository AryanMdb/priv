@extends('admin.layouts.master')
<?php
use Illuminate\Support\Facades\Session;
?>
@section('contant')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                    <h4 class="card-title">New Subadmin</h4>
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

                <form id="editSubadmin" action="{{ route('subadmins.update', $user->id) }}" class="forms-sample" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" value="{{$user->name ?? old('name')}}" id="name" name="name"
                                    placeholder="Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" value="{{$user->email ?? old('email')}}" id="email" name="email"
                                    placeholder="Email" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Role</label>
                                <select name="role" id="role" class="form-control">
                                    @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-md-12">
                            <div class="form-group">
                                <div class="permissions-container row">
                                    @foreach($groupedPermissions as $main => $permissions)
                                        <div class="main-permissions col-md-3 mb-3">
                                            <div class="border h-100 p-3">
                                                <h4 class="border-bottom pb-2 mb-3">{{ $main }}</h4>
                                                @foreach($permissions as $permission)
                                                    <div>
                                                        <input type="checkbox" name="permissions[]" value="{{ $permission->slug }}" {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                        <label>{{ $permission->name }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $.validator.addMethod("alphaOnly", function(value, element) {
                return /^[A-Za-z\s!@#$%^&*]+$/.test(value);
            }, "Please enter only alphabets");

            $('#editSubadmin').validate({
                highlight: function(element) {
                    $(element).closest('.form-control').addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).closest('.form-control').removeClass('is-invalid');
                },
                rules: {

                    name: {
                        required: true,
                        alphaOnly: true,
                        maxlength: 100,
                    },
                    role: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Please enter name',
                    },
                    role: {
                        required: 'Please select role',
                    },
                }

            });
        });
    </script>
@endsection
