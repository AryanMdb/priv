@extends('cmsPage.layouts.master')
@if(isset($cmsPageData->title))
    @section('title', $cmsPageData->title)
@endif
@section('contant')

<div class="container">
        <div class="cms-page">
            @if(isset($cmsPageData))
                @if(isset($cmsPageData->title))
                <h2>{{$cmsPageData->title}}</h2>
                @endif
                <!-- @if(isset($cmsPageData->icon_image))
                <div class="img-block">
                    <img src="{{asset('pages/icon').'/'.$cmsPageData->icon_image}}" alt="{{$cmsPageData->title}}">
                </div>
                @endif -->

                @if(isset($cmsPageData->description))
                    @php echo $cmsPageData->description; @endphp
                @endif
            @else
                <h3>{{'Data Not Found'}}</h3>
            @endif
        </div>
    </div>
@endsection
