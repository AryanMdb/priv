@extends('admin.layouts.master')
<?php
use Illuminate\Support\Facades\Session;
?>
@section('contant')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                    <h4 class="card-title">New Push Notification Create</h4>
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

                <form id="addNotification" class="forms-sample" method="POST" action="{{ route('push_notification.store') }}">
                    @csrf


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" value="{{old('title')}}" id="title" name="title"
                                    placeholder="Title">
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="summary-ckeditor">Message :</label>
                                <textarea name="message" id="message" rows="7" class="form-control"
                                    placeholder="Write your message..">{{old('message')}}</textarea>
                                    <span id="descErr"></span>

                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <button type="submit"  class="btn btn-primary mr-2">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function() {


            $('#addNotification').validate({
                highlight: function(element) {
                    $(element).closest('.form-control').addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).closest('.form-control').removeClass('is-invalid');
                },
                rules: {
                    title:{
                        required:true,
                        maxlength: 100
                    },
                    message: {
                        required: true,
                        minlength: 10,
                    },
                },
                messages: {
                    title: {
                        required: 'Please enter title',
                        maxlength: 'Title must be less than 100 characters',
                    },
                    message: {
                        required: 'Please enter message',
                    },
                }

            });
        });
    </script>
@endsection
