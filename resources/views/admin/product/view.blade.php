@extends('admin.layouts.master')
@section('contant')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <!-- <div class="card-body"> -->
            <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
            <div class="users-show">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="preview-images-zone ui-sortable mb-4">
                            @if (isset($product->image) && !empty($product->image))
                                @php
                                    $profilePics = is_array($product->image) ? $product->image : json_decode($product->image, true);
                                @endphp

                                @if (is_array($profilePics) && count($profilePics) > 0)
                                    @foreach ($profilePics as $key => $image)
                                        <div class="preview-image preview-show-{{ $key }}">
                                            <div class="image-zone">
                                                <img id="pro-img-{{ $key }}" src="{{ asset('storage/product/' . $image) }}" alt="Image">
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                <div class="image-zone pb-2">
                                    <img id="pro-img" class="prod-img" src="{{ asset(path: 'storage/product/' . $product->image) }}" alt="Image">
                                </div>
                                @endif
                            @else
                                <p>No images uploaded yet.</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="right-info">
                            <div class="projects">
                                <h3>Product Details</h3>
                                <div class="projects_data">
                                    <div class="row w-100">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <div class="data">
                                                    <table class="table table-striped" id="table">
                                                        <tr>
                                                            <th>Name</th>
                                                            <td>{{ $product->title }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Category</th>
                                                            <td>{{ $product?->category?->title }}</td>
                                                        </tr>
                                                        @if($product->address_from != '')
                                                        <tr>
                                                            <th>Subcategory</th>
                                                            <td>{{ $product?->subcategory?->title ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($product->total_amount != '' || $product->total_amount != 0)
                                                        <tr>
                                                            <th>Actual Price</th>
                                                            <td>{{ $product->total_amount ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        
                                                        @if($product->selling_price != 0)
                                                        <tr>
                                                            <th>Selling Price</th>
                                                            <td>{{ $product->selling_price ?? '-'}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($product->discount != 0)
                                                        <tr>
                                                            <th>Discount</th>
                                                            <td>{{ $product->discount ?? '-'}}%</td>
                                                        </tr>
                                                        @endif
                                                        <tr>
                                                            <th>Out Of Stock</th>
                                                            <td>@isset($product->out_of_stock)@endisset {{$product->out_of_stock == 1 ? 'True' : 'False'}} </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Created Date</th>
                                                            <td>@isset($product->created_at)@endisset{{ date('d M Y', strtotime($product->created_at)) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Update Date</th>
                                                            <td>@isset($product->updated_at)@endisset{{ date('d M Y', strtotime($product->updated_at)) }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            @if($product->total_amount != 0)
                            <div class="projects">
                                <h3>Inventory Details</h3>
                                <div class="projects_data">
                                    <div class="row w-100">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <div class="data">
                                                    <table class="table table-striped" id="group_table">
                                                        <thead>
                                                            <tr>
                                                                <th>S.No.</th>
                                                                <th>Quantity</th>
                                                                <th>Actual Price</th>
                                                                <th>Selling Price</th>
                                                                <th>Discount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $i = 1; @endphp
                                                            @foreach ($product?->inventory as $key => $val)
                                                                <tr>
                                                                    <td>{{ $i++ }}</td>
                                                                    <td>{{ $val->quantity }}</td>
                                                                    <td>₹{{ $val->actual_price }}</td>
                                                                    <td>
                                                                        @if ($val->selling_price != 0 && $val->selling_price != null)
                                                                        ₹{{ $val->selling_price }}
                                                                        @else
                                                                            <span class="text-danger"> No Selling Price</span>
                                                                        @endif
                                                                    </td>

                                                                    <td>
                                                                        @if ($val->discount != 0 && $val->discount != null)
                                                                            {{ $val->discount }}%
                                                                        @else
                                                                            <span class="text-danger"> No Discount</span>
                                                                        @endif
                                                                    </td>
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

@endsection
