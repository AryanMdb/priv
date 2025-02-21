@extends('admin.layouts.master')
@section('contant')
    <style>
        .pagination-table .flex.justify-between.flex-1.sm\:hidden,
        .dataTables_paginate,
        .dataTables_info,
        .dataTables_length {
            display: none;
        }
    </style>
    <div class="card col-12">
        <div class="card-body">
            <div class="w-100 align-items-center justify-content-between mb-4 row mx-0">
                <div class="col-md-2 col-12">
                    <h4 class="card-title">Product TABLE</h4>
                </div>
                <div class="col-xl-7 col-md-12 col-12 w-100 d-flex justify-content-end mt-3">
                        <div class="d-flex w-100">
                            <form class="w-100 mr-1" method="GET" action="{{ route('product.index') }}" id="searchForm">
                                <input class="form-control" type="search" name="search" id="search"
                                    placeholder="Search Products" value="{{ request('search') }}">

                                <input type="hidden" name="entries" value="{{ request('entries', 10) }}">
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            </form>

                            <form class="w-75 mx-1" method="GET" action="{{ route('product.index') }}">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="category" value="{{ request('category') }}">

                                <select name="entries" class="form-control w-100" onchange="this.form.submit()">
                                    <option value="10" {{ request('entries', 10) == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </form>

                            <form class="w-100 ml-1" method="GET" action="{{ route('product.index') }}">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="entries" value="{{ request('entries', 10) }}">

                                <select name="category" class="form-control w-100" onchange="this.form.submit()">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ ucfirst($category->title) }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-12 col-12 w-100 d-flex justify-content-end mt-3">
                        <a class="bl_btn align-items-center d-flex justify-content-center mb-0 mx-3" href="{{ route('products.export') }}">Download Excel</a>
                        <a class="bl_btn align-items-center d-flex justify-content-center mb-0 mx-0" href="{{route('product.create')}}">Add Product</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="table">
                        <thead>
                            <tr>
                                <th width="10%">S.No.</th>
                                <th width="10%">Image</th>
                                <th width="15%">Category</th>
                                <th width="15%">Subcategory</th>
                                <th width="20%">Product</th>
                                <th width="5%">Discount</th>
                                <th width="10%">Active/Inactive</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            @if(isset($products))
                                                @php $i = ($products->currentPage() - 1) * $products->perPage() + 1; @endphp
                                                @foreach($products as $key => $make)
                                                                    <tr data-id="{{$make->id}}">

                                                                        <td>{{$i++}}<i class="fas fa-grip-vertical ml-3 text-muted table-grip-icon"></i>
                                                                        </td>
                                                                        <td class="py-1">
                                                                            <?php
                                                    $defaultImage = asset(config('constants.default_image'));
                                                    $images = json_decode($make->image, true);

                                                    if (!empty($make->image)) {
                                                        if (is_array($images) && !empty($images)) {
                                                            $link = asset('storage/product/' . $images[0]);
                                                        } elseif (!is_array($images)) {
                                                            $link = asset('storage/product/' . $make->image);
                                                        } else {
                                                            $link = $defaultImage;
                                                        }
                                                    } else {
                                                        $link = $defaultImage;
                                                    }
                                                                                                                                                                                                                                                                                                                                                                                                                    ?>
                                                                            <img src="{{ $link }}" alt="make logo">
                                                                        </td>

                                                                        <td>
                                                                            {{ucfirst($make->category->title)}}
                                                                        </td>
                                                                        <td>
                                                                            {{ucfirst($make->subcategory->title)}}
                                                                        </td>
                                                                        <td>
                                                                            {{ucfirst($make->title)}}
                                                                        </td>

                                                                        <td>
                                                                            @php
                                                                                $discount = 0;
                                                                                if ($make->total_amount > 0 && $make->selling_price > 0) {
                                                                                    $discount = (($make->total_amount - $make->selling_price) / $make->total_amount) * 100;
                                                                                }
                                                                            @endphp

                                                                            @if($discount > 0)
                                                                                <span class="d-flex" style="color:#03ac51;padding:0 5px; text-transform:uppercase;">
                                                                                    {{ number_format($discount, 2) }}% off
                                                                                </span>
                                                                            @else
                                                                                <span class="d-flex text-danger" style="padding:0 5px; text-transform:uppercase;">
                                                                                    No Discount
                                                                                </span>
                                                                            @endif
                                                                        </td>

                                                                        <td>
                                                                            <form action="{{route('product.status')}}" method="POST" style="height: 34px;">
                                                                                @csrf
                                                                                <input type="hidden" name="id" value="{{$make->id}}">
                                                                                <label class="switch">
                                                                                    <input type="checkbox" name="switch" class="switch_toggle_button btns"
                                                                                        data-sid="{{$make->id}}" value="{{$make->status}}" @if(
                                                                                            $make->status ==
                                                                                            '1'
                                                                                        ){{'checked'}}@endif>
                                                                                    <span class="slider round"></span>
                                                                                </label>
                                                                            </form>

                                                                        </td>
                                                                        <td>
                                                                            <a class="edit-btn" href="{{ route('product.edit', $make->id) }}"><i
                                                                                    class="icon-note"></i></a>
                                                                            <a class="show-btn" href="{{ route('product.show', $make->id) }}"><i
                                                                                    class="icon-eye"></i></a>
                                                                            <form class="delete-btn" action="{{route('product.destroy', $make->id)}}" method="POST">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="btn">
                                                                                    <i class="icon-trash"></i>
                                                                                </button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                @endforeach
                            @else
                                @php echo 'Data Not Found.'; @endphp
                            @endif
                        </tbody>
                    </table>
                    <div class="pagination-table mt-5">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
        <script type="text/javascript">

            $('.delete-btn').click(function (event) {
                var form = $(this).closest("form");
                var name = $(this).data("name");
                event.preventDefault();
                swal({
                    title: `Are you sure you want to delete this record?`,
                    text: "If you delete this, it will be gone forever.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        }
                    });
            });
            // switch
            $('.btns').click(function (event) {

            });
            $('.switch_toggle_button').click(function (e) {
                var isChecked = $(this).is(":checked");
                $(this).val(isChecked ? '1' : '0');

                var form = $(this).closest("form");
                var name = $(this).data("name");
                var statusMessage = isChecked ? 'Active' : 'Inactive';
                // event.preventDefault();
                swal({
                    title: `Are you sure you want to change this product to ${statusMessage}?`,
                    text: "If you change this, it will not be shown in app.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDeactive) => {
                    if (willDeactive) {
                        form.submit();
                    } else {
                        location.reload();
                    }
                });
            });

            $(document).ready(function () {
                $('.table').DataTable({
                    paging: false,
                    ordering: false,
                    searching: false
                });
            });

            new Sortable(document.getElementById('sortable'), {
                animation: 150,
                forceFallback: true,  // Enables a fallback mechanism to avoid blocking scroll
                fallbackTolerance: 5, // Prevent accidental blocking of scrolling
                scroll: true,
                handle: ".table-grip-icon",
                scrollSensitivity: 100, // Adjust scrolling speed
                scrollSpeed: 10,
                paginate: false,
                onEnd: function () {
                    let order = [];

                    let currentPage = parseInt("{{ request()->get('page', 1) }}");
                    let perPage = parseInt("{{ $products->perPage() }}");
                    let startIndex = (currentPage - 1) * perPage + 1;

                    $('#sortable tr').each(function (index) {
                        let id = $(this).data('id');
                        let newIndex = startIndex + index;

                        order.push({ id: id, position: newIndex });
                    });

                    $.ajax({
                        url: "{{ route('product.updateOrder') }}",
                        type: "POST",
                        data: {
                            order: order,
                            _token: '{{ csrf_token() }}',
                            page: currentPage
                        },
                        success: function (response) {
                            console.log('Order updated successfully:', response);
                            location.reload();
                        },
                        error: function (xhr) {
                            console.log('Error:', xhr.responseText);
                        }
                    });
                }
            });


       
            // -------------------- DRAGS ROWS END -----------------------------
            document.getElementById('search').addEventListener('input', function() {
                clearTimeout(this.timer);
                this.timer = setTimeout(() => {
                    document.getElementById('searchForm').submit();
                }, 800); 
            });
        </script>
@endsection