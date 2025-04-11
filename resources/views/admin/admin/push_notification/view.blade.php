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
                    <h4 class="card-title">Push Notification Show</h4>
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


                @if (isset($notificationData))
                    @php
                        $message = '';
                    @endphp

                    @if (isset($notificationData->message))
                        @php $message = $notificationData->message; @endphp
                    @endif
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h4 class="w-100">{{$notificationData->title ?? 'Message'}}</h4>
                            <p class="w-100">@php echo $message; @endphp</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
