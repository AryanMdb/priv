@extends('admin.layouts.master')
@section('contant')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <!-- <div class="card-body"> -->
            <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
            <div class="users-show">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="img-block">
                            @if (isset($category->image) && !empty($category->image))
                                @php $category_image = asset('storage/category/'.$category->image);@endphp
                            @else
                                @php $category_image = asset('constants.default_image');@endphp
                            @endif
                            <img src="{{ $category_image }}" alt="user" width="100px" height="100px">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="right-info">
                            <div class="projects">
                                <h3>Category Details</h3>
                                <div class="projects_data">
                                    <div class="row w-100">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <div class="data">
                                                    <table class="table table-striped" id="table">
                                                        <tr>
                                                            <th>Name</th>
                                                            <td>{{ $category->title }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Is Show</th>
                                                            <td>@isset($category->is_show)@endisset {{$category->is_show == 1 ? 'True' : 'False'}} </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Coming Soon</th>
                                                            <td>@isset($category->coming_soon)@endisset {{$category->coming_soon == 1 ? 'True' : 'False'}} </td>
                                                        </tr>

                                                        <tr>
                                                            <th>Delivery Time</th>
                                                            <td>
                                                                @if(isset($category->delivery_time))
                                                                    {{ date('g:i A', strtotime($category->delivery_time)) }}
                                                                @else
                                                                    Not Set
                                                                @endif
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th>Created Date</th>
                                                            <td>@isset($category->created_at)@endisset{{ date('d M Y', strtotime($category->created_at)) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Update Date</th>
                                                            <td>@isset($category->updated_at)@endisset{{ date('d M Y', strtotime($category->updated_at)) }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
