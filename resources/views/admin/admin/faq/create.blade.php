@extends('admin.layouts.master')
<?php
use Illuminate\Support\Facades\Session;
?>
@section('contant')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                    <h4 class="card-title">New FAQ Create</h4>
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

                <form id="addFaq" class="forms-sample" method="POST" action="{{ route('faq.store') }}">
                    @csrf


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="question">FAQs Question :</label>
                                <input type="text" class="form-control" id="question" name="question"
                                    placeholder="Question">
                            </div>
                        </div>
                        <div class="col-md-6"></div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="summary-ckeditor">FAQs Answer :</label>
                                <textarea name="answer" id="answer" rows="7" class="form-control ckeditor"
                                    placeholder="Write your answer.."></textarea>
                                    <span id="descErr"></span>

                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <button type="button"  onclick="saveData()" class="btn btn-primary mr-2">Submit</button>
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

                $("#addFaq").valid();
                var isAnswerValid = checkAnswer();


                if ((isAnswerValid == true)) {
                    $('#addFaq').submit();
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

            $('#addFaq').validate({
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
                        maxlength: 100,
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
