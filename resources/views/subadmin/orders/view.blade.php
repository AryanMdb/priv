@extends('subadmin.layouts.master')
@section('contant')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <!-- <div class="card-body"> -->
            <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
            <div class="users-show">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right-info">
                            <div class="projects">
                                <h3>User Details</h3>
                                <div class="projects_data">
                                    <div class="row w-100">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <div class="data">
                                                    <table class="table table-striped" id="table">
                                                        <tr>
                                                            <th>Name</th>
                                                            <td>{{ $order?->user?->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Phone Number</th>
                                                            <td>{{ $order?->user?->phone }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Gender</th>
                                                            <td>{{ $order?->user?->gender }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="projects">
                                <h3>Order Details</h3>
                                <div class="projects_data">
                                    <div class="row w-100">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <div class="data">
                                                    <table class="table table-striped" id="table">
                                                        <tr>
                                                            <th>Order ID</th>
                                                            <td>{{ $order->order_id }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Name</th>
                                                            <td>{{ $order->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Phone Number</th>
                                                            <td>{{ $order->phone_no }}</td>
                                                        </tr>
                                                        @if($address != '')
                                                        <tr>
                                                            <th>Location</th>
                                                            <td><a href="#" id='location' data-toggle="modal" data-target="#mapModal">{{ $address ?? '-'}}</a></td>
                                                        </tr>
                                                          @elseif($order->location != '')
                                                        <tr>
                                                            <th>Location</th>
                                                            <td>{{ $order->location ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->address_from != '')
                                                        <tr>
                                                            <th>Address From</th>
                                                            <td>{{ $order->address_from ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->address_to != '')
                                                        <tr>
                                                            <th>Address To </th>
                                                            <td>{{ $order->address_to ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->property_address != '')
                                                        <tr>
                                                            <th>Property Address</th>
                                                            <td>{{ $order->property_address ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->expected_cost != '')
                                                        <tr>
                                                            <th>Expected Cost</th>
                                                            <td>{{ $order->expected_cost ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->property_details != '')
                                                        <tr>
                                                            <th>Property Details</th>
                                                            <td>{{ $order->property_details ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->description != '')
                                                        <tr>
                                                            <th>Description</th>
                                                            <td>{{ $order->description ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->phone_company != '')
                                                        <tr>
                                                            <th>Phone Company</th>
                                                            <td>{{ $order->phone_company ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->phone_model != '')
                                                        <tr>
                                                            <th>Phone Model</th>
                                                            <td>{{ $order->phone_model ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->expected_rent != '')
                                                        <tr>
                                                            <th>Expected Rent</th>
                                                            <td>{{ $order->expected_rent ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->preferred_location != '')
                                                        <tr>
                                                            <th>Preferred Location</th>
                                                            <td>{{ $order->preferred_location ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->required_property_details != '')
                                                        <tr>
                                                            <th>Required Property Details</th>
                                                            <td>{{ $order->required_property_details ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->date_of_journey != '')
                                                        <tr>
                                                            <th>Date of Journey</th>
                                                            <td>{{ \Carbon\Carbon::parse($order->date_of_journey)->format('m/d/Y') ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->time_of_journey != '' && $order->time_of_journey != '00:00:00')
                                                        <tr>
                                                            <th>Time of Journey</th>
                                                            <td>{{ $order->time_of_journey ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->approximate_load != '')
                                                        <tr>
                                                            <th>Approximate Load</th>
                                                            <td>{{ $order->approximate_load ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->estimated_work_hours != '')
                                                        <tr>
                                                            <th>Estimated Work Hours</th>
                                                            <td>{{ $order->estimated_work_hours ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->no_of_passengers != '')
                                                        <tr>
                                                            <th>Number Of Passengers</th>
                                                            <td>{{ $order->no_of_passengers ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->estimated_distance != '')
                                                        <tr>
                                                            <th>Estimated Distance</th>
                                                            <td>{{ $order->estimated_distance ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->total_orchard_area != '')
                                                        <tr>
                                                            <th>Total Orchard Area/Land in Acres</th>
                                                            <td>{{ $order->total_orchard_area ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->age_of_orchard != '')
                                                        <tr>
                                                            <th>Age of the Orchard/Plant</th>
                                                            <td>{{ $order->age_of_orchard ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->type_of_fruit_plant != '')
                                                        <tr>
                                                            <th>Type of fruit plant</th>
                                                            <td>{{ $order->type_of_fruit_plant ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->total_estimated_weight != '')
                                                        <tr>
                                                            <th>Total Estimated Weight (in 100 Kilograms)</th>
                                                            <td>{{ $order->total_estimated_weight ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->expected_demanded_total_cost != '')
                                                        <tr>
                                                            <th>Expected Demanded Total Cost</th>
                                                            <td>{{ $order->expected_demanded_total_cost ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->product_name_model != '')
                                                        <tr>
                                                            <th>Product Name & Model</th>
                                                            <td>{{ $order->product_name_model ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->month_year_of_purchase != '')
                                                        <tr>
                                                            <th>Month & Year of Purchase</th>
                                                            <td>{{ $order->month_year_of_purchase ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->product_brand != '')
                                                        <tr>
                                                            <th>Product Brand</th>
                                                            <td>{{ $order->product_brand ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order->expected_demanded_price != '')
                                                        <tr>
                                                            <th>Expected/Demanded Price</th>
                                                            <td>{{ $order->expected_demanded_price ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($order?->cart?->total_price != 0)
                                                        <tr>
                                                            <th>Total Price</th>
                                                            <td>₹{{ $order?->cart?->total_price }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Delivery Charges</th>
                                                            <td>₹{{ $order?->cart?->deliver_charges }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Grand Total</th>
                                                            <td>₹{{ $order?->cart?->grant_total }}</td>
                                                        </tr>
                                                        @endif
                                                        <tr>
                                                            <th>Order Date</th>
                                                            <td>@isset($order->created_at)@endisset{{ date('d M Y', strtotime($order->created_at)) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Order Time</th>
                                                            <td>@isset($order->created_at)@endisset{{ date('h:i A', strtotime($order->created_at)) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Status</th>
                                                            <td>
                                                                @if(isset($order->status))
                                                                    <button type="button" class="btn btn-success btn-sm switch_toggle_button" style="pointer-events: none;">{{ config('constants.order_status')[$order->status] ?? '' }}</button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($order?->cart?->grant_total != 0)
                            <hr>
                            <div class="projects">
                                <h3>Cart Details</h3>
                                <div class="projects_data">
                                    <div class="row w-100">

                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <div class="data">
                                                    <table class="table table-striped" id="group_table">
                                                        <thead>
                                                            <tr>
                                                                <th>S.No.</th>
                                                                <th>Product Name</th>
                                                                <th>Item Price</th>
                                                                <th>Item Quantity</th>
                                                                <th>No of Items</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $i = 1; @endphp
                                                            @foreach ($order?->cart?->cartItems as $key => $val)
                                                                <tr>
                                                                    <td>{{ $i++ }}</td>
                                                                    <td>{{ $val?->product?->title }}</td>
                                                                    <td>₹{{ $val->item_price }}</td>
                                                                    <td>{{ $val->item_quantity }}</td>
                                                                    <td>{{ $val->no_of_items }}</td>
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
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mapModalLabel">Location</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="mapGenerate" style="height: 400px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
    @php $token = config('constants.google_map_token');@endphp
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{$token}}&callback=initMap" async defer></script>
    <script>
    $(document).ready(function() {
      
        function initMap(latitude, longitude) {
            var map;
            var myLatLng = {lat: latitude, lng: longitude};
    
            map = new google.maps.Map(document.getElementById('mapGenerate'), {
                center: myLatLng,
                zoom: 14
            });
    
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: latitude + ', ' + longitude
            });
        }
    
        // Initialize the map when the modal is shown
        $('#location').on('click', function () {
            mapModalLabel
            var latitude = {{ $latitude ?? 0 }};
            var longitude = {{ $longitude ?? 0 }};
            
            initMap(latitude, longitude);
        });
		
    });
    </script>
@endsection
