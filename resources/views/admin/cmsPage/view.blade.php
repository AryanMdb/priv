@extends('admin.layouts.master')
<?php
use Illuminate\Support\Facades\Session;
?>
@section('contant')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                    <h4 class="card-title">CMS Page Show</h4>
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

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            @if (isset($cmsPageData))
                            @php
                                $title = '';
                                $description = '';
                            @endphp
                            @if (isset($cmsPageData->title))
                                @php $title = $cmsPageData->title; @endphp
                            @endif

                            {{-- @if (isset($cmsPageData->icon_image))
                           @php $iconImage = $cmsPageData->icon_image; @endphp
                        @endif --}}

                            @if (isset($cmsPageData->description))
                                @php $description = $cmsPageData->description; @endphp
                            @endif
                        @endif
                        <h4 class="card-titleas">{{ $title }}</h4>
                        {{-- <img src="{{asset('/pages/icon').'/'.$iconImage}}" alt="{{$title}}" style="width:120px; height: auto;" /> --}}
                        <div class="card-titles">@php echo $description; @endphp</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
