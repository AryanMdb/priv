@extends('admin.layouts.master')
<?php
use Illuminate\Support\Facades\Session;
?>
@section('contant')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                    <h4 class="card-title">New CMS Page Create</h4>
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

                <form id="addCMS" class="forms-sample" method="POST" action="{{ route('cms.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputName1">Page Title :</label>
                                <input type="text" class="form-control" id="exampleInputName1" name="title"
                                    placeholder="Title">
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail3">Description</label>
                                <textarea  id="description" name="description" rows="10" class="form-control ckeditor"
                                    placeholder="Write your message.."></textarea>
                                    <span id="descErr"></span>
                            </div>
                            
                        </div>
                        <div class="col-md-6">
                            {{-- <div class="form-group">
                                    <label for="icon">Icon Image :</label>
                                    <input type="file" class="form-control" id="icon" name="icon_image" />
                                </div> --}}
                        </div>
                        <div class="col-md-6">
                            <button type="button" onclick='saveData()' class="btn btn-primary mr-2">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script>

        CKEDITOR.replace( 'description');

        $(document).ready(function() {

            saveData = function() {

                $("#addCMS").valid();
                var isDescriptionValid = checkDescription();


                if ((isDescriptionValid == true)) {
                    $('#addCMS').submit();
                } else {
                    return false;
                }
            }

            function checkDescription() {

                var desc = CKEDITOR.instances.description.getData();
                if (desc == '') {
                    $('#descErr').html('<span style="color:#FF0000">Please enter description</span>');
                    return false;
                } else {
                    $('#descErr').html('');
                    return true;
                }
            }
            $.validator.addMethod("alphaOnly", function(value, element) {
            return /^[A-Za-z\s]+$/.test(value);
            }, "Please enter only alphabets");
            $('#addCMS').validate({
                highlight: function(element) {
                    $(element).closest('.form-control').addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).closest('.form-control').removeClass('is-invalid');
                },
                rules: {
                    title: {
                        required: true,
                        maxlength: 100,
                        alphaOnly:true
                    },
                },
                messages: {
                    title: {
                        required: 'Please enter title',
                        maxlength: 'Title must be less than 100 characters',
                    },
                }

            });
        });
    </script>
@endsection
