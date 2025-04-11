@extends('admin.layouts.master')
<?php
use Illuminate\Support\Facades\Session;
?>
@section('contant')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                    <h4 class="card-title">Edit FAQs</h4>
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

                <form id="editFaq" class="forms-sample" method="POST" action="{{ route('faq.update', $faqData->id) }}">
                    @csrf


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputName1">FAQs Question :</label>
                                <input type="text" class="form-control" id="exampleInputName1" name="question"
                                    placeholder="" value="{{ $faqData->question }}">
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail3">FAQs Answer</label>
                                <textarea name="answer" id="answer" rows="10" class="form-control ckeditor"
                                    placeholder="Write your message..">{{ $faqData->answer }}</textarea>
                                    <span id="descErr"></span>

                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <button type="button" onclick="saveData()" class="btn btn-primary mr-2">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('answer');

        $(document).ready(function() {

            saveData = function() {

                $("#editFaq").valid();
                var isAnswerValid = checkAnswer();


                if ((isAnswerValid == true)) {
                    $('#editFaq').submit();
                } else {
                    return false;
                }
            }

            function checkAnswer() {

                var desc = CKEDITOR.instances.answer.getData();
                if (desc == '') {
                    $('#descErr').html('<span style="color:#FF0000">Please enter answer</span>');
                    return false;
                } else {
                    $('#descErr').html('');
                    return true;
                }
            }

            $('#editFaq').validate({
                highlight: function(element) {
                    $(element).closest('.form-control').addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).closest('.form-control').removeClass('is-invalid');
                },
                rules: {
                    question: {
                        required: true,
                        minlength: 3,
                    },
                },
                messages: {
                    question: {
                        required: 'Please enter question',
                    },
                }

            });
        });
    </script>
@endsection
