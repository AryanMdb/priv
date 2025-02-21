@extends('cmsPage.layouts.master')
@section('title', 'FAQs')
@section('contant')

<div class="container">
        <div class="cms-page">
                <div class="cms-page">
                    <h2>FAQs</h2>
                    <div class="accordion" id="accordionExample">
                    @if(isset($faqData))
                        @php $a = 0; $action = 'show'; @endphp
                        @foreach($faqData as $faq)
                            <div class="card">
                                <div class="card-header" id="heading{{$a}}">
                                    <h3 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{$a}}" aria-expanded="true" aria-controls="collapse{{$a}}">
                                          @php echo strip_tags($faq->question); @endphp
                                        </button>
                                    </h3>
                                </div>
                                <div id="collapse{{$a}}" class="collapse @if($a == 0){{$action}} @endif" aria-labelledby="heading{{$a}}" data-parent="#accordionExample">
                                    <div class="card-body">
                                        @php echo ($faq->answer); @endphp
                                    </div>
                                </div>
                            </div>
                            @php $a++; @endphp
                       @endforeach
                    @else
                        <h3>{{'Data Not Found'}}</h3>
                    @endif
                      
                </div>
            </div>
        </div>
    </div>
@endsection
