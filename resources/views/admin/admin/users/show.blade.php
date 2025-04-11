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
                            @if (isset($user->image) && !empty($user->image))
                                @php $profile = asset('storage/profile_image/'.$user->image);@endphp
                            @else
                                @php $profile = asset(config('constants.default_profile_image'));@endphp
                            @endif
                            <img src="{{ $profile }}" alt="user" width="100px" height="100px">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="right-info">
                            <div class="info">
                                <div class="info_data">
                                    <div class="row w-100">
                                        <div class="col-sm-12">
                                            <div class="data">
                                                <table class="table table-striped" id="table">
                                                    <tr>
                                                        <th>Name</th>
                                                        <td>{{$user->name ?? '-'}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Phone</th>
                                                        <td>{{$user->phone ?? '-'}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Gender</th>
                                                        <td>{{$user->gender_type ?? '-'}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Location</th>
                                                        <td>{{$address ?? '-'}}</td>
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
                @if($user?->orders != [])
                <div class="projects">
                    <h3>Order Details</h3>
                    <div class="projects_data">
                        <div class="row w-100">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <div class="data">
                                        <table class="table table-striped" id="table">
                                            <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($user?->orders as $order)
                                            <tr>
                                                <td><a href="{{route('order.show', $order->id)}}">{{ $order->order_id }}</a></td>
                                                <td>{{ $order->name }}</td>
                                                <td>{{$order?->cart?->category?->title}}</td>
                                                <td>₹{{$order?->cart?->grant_total}}</td>
                                                <td>{{ config('constants.order_status')[$order->status] ?? '' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                @endif
            </div>
        </div>
    </div>

@endsection
