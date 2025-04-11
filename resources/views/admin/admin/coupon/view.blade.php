@extends('admin.layouts.master')
@section('contant')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
            <div class="users-show">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right-info">
                            <div class="projects">
                                <h3>Coupon Details</h3>
                                <div class="projects_data">
                                    <div class="row w-100">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <div class="data">
                                                    <table class="table table-striped" id="table">
                                                        <tr>
                                                            <th>Id</th>
                                                            <td>{{ $coupon->id }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Name</th>
                                                            <td>{{ $coupon->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Code</th>
                                                            <td>{{ $coupon->code }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Category</th>
                                                            <td>
                                                                @foreach($categories as $category)
                                                                    @if($category->id == $coupon->cat_id)
                                                                        {{ $category->title }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Discount</th>
                                                            <td>{{$coupon->discount_value}} </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Type</th>
                                                            <td>{{$coupon->type}} </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Expiry Date</th>
                                                            <td>{{ date('d M Y', strtotime($coupon->expires_at)) }} </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Created Date</th>
                                                            <td>@isset($coupon->created_at)@endisset{{ date('d M Y', strtotime($coupon->created_at)) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Update Date</th>
                                                            <td>@isset($coupon->updated_at)@endisset{{ date('d M Y', strtotime($coupon->updated_at)) }}</td>
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
