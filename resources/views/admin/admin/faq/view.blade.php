@extends('admin.layouts.master')
<?php
use Illuminate\Support\Facades\Session;
?>
@section('contant')
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                    <h4 class="card-title">FAQs Show</h4>
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


                @if (isset($faqData))
                    @php
                        $question = '';
                        $answer = '';
                    @endphp
                    @if (isset($faqData->question))
                        @php $question = $faqData->question; @endphp
                    @endif

                    @if (isset($faqData->answer))
                        @php $answer = $faqData->answer; @endphp
                    @endif
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h4 class="w-100">{{ $question }}</h4>
                            <p class="w-100">@php echo $answer; @endphp</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
