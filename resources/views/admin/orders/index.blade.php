@extends('admin.layouts.master')
@section('contant')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .pagination-table .flex.justify-between.flex-1.sm\:hidden,
        .dataTables_paginate,
        .dataTables_info {
            display: none;
        }

        select.form-control.status {
            width: fit-content;
        }

        .item {
            text-wrap: nowrap;
        }
    </style>

    <div class="card col-12">
        <div class="card-body">
            <div class="w-100 align-items-center justify-content-between mb-4 d-flex row">
                <div class="col-md-7 col-12">
                    <h4 class="card-title">Orders List</h4>
                </div>
                <div class=" col-md-5 col-12 my-3 d-flex">
                    <form class="mr-3 w-100" method="GET"
                        action="{{ request()->is('admin/orders/trashed') ? route('orders.trashed') : route('order.index') }}">
                        <select name="entries" class="form-control w-100" onchange="this.form.submit()">
                            <option value="10" {{ request('entries', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </form>
              
                    <a class="bl_btn align-items-center d-flex justify-content-center mb-0 mx-0 w-100" href="{{ route('export-orders') }}">Download Excel</a>
                    {{-- <button id="deleteSelected" style="display: none;" class="btn btn-danger mb-1">Delete Selected</button> --}}
                </div>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs" id="orderTabs">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/order/list') ? 'active' : '' }}"
                        href="{{ route('order.index') }}">All Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/orders/trashed') ? 'active' : '' }}"
                        href="{{ route('orders.trashed') }}">Trashed Orders</a>
                </li>
            </ul>

            <div class="table-responsive mt-4">
                <table class="table table-striped" id="table">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Order Id</th>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th style="width: 20%;">Subadmin</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = ($orders->currentPage() - 1) * $orders->perPage() + 1; @endphp
                        @foreach($orders as $key => $order)
                            <tr>
                                <td class="py-1">{{ $i++ }}</td>
                                <td>{{ $order->order_id }}</td>
                                <td>{{ $order->cart?->category?->title }}</td>
                                <td>{{ $order->name }}</td>
                                <td>₹{{ $order->cart?->grant_total }}</td>
                                <td>
                                    <form action="{{ route('order.assign-subadmin', $order->id) }}" method="POST"
                                        class="statusForm">
                                        @csrf
                                        <select class="assign_subadmin w-100" name="role_id[]" multiple="multiple">
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{ in_array($role->id, (array) json_decode($order->role_id)) ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    @if($order->status == 'payment_completed')
                                        <button type="button" class="btn btn-success btn-sm switch_toggle_button"
                                            style="pointer-events: none;">Payment Completed</button>
                                    @else
                                        <form action="{{route('order.status', $order->id)}}" method="POST">
                                            @csrf
                                            <select name="status" class="form-control status">
                                                @foreach(config('constants.order_status') as $key => $value)
                                                    <option value="{{ $key }}" {{ $key == $order->status ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    @if($order->trashed())
                                        <form class="restore_order" action="{{ route('orders.restore', $order->id) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="btn show-btn"> <i class="icon-reload"></i></button>
                                        </form>
                                        <form class="delete-btn delete_order" action="{{ route('orders.delete', $order->id) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="btn">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <a class="show-btn" href="{{ route('order.show', $order->id) }}">
                                            <i class="icon-eye"></i>
                                        </a>
                                        <form class="delete-btn delete_order" action="{{ route('order.destroy', $order->id) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="btn">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination-table mt-5">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script type="text/javascript">


        $('.assign_subadmin').each(function () {
            var $select = $(this);


            var selectizeInstance = $select.selectize({
                plugins: ['remove_button'],
                onChange: function (selectedRoles) {
                    var form = $select.closest('form');
                    var action = form.attr('action');
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    if (!csrfToken) {
                        console.error("CSRF token is missing!");
                        return;
                    }

                    var formData = {
                        _token: csrfToken, // Ensure token is sent
                        role_id: selectedRoles
                    };

                    console.log('Submitting form data:', formData);

                    $.ajax({
                        url: action,
                        type: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // Send CSRF token
                        },
                        success: function (response) {
                            swal("Success!", "Roles updated successfully!", "success");
                        },
                        error: function (xhr, status, error) {
                            swal("Error!", "An error occurred while updating roles", "error");
                            console.error('Error details:', error);
                        }
                    });
                }
            });

            // Ensure the Selectize instance is correctly initialized
            if (!selectizeInstance[0].selectize) {
                console.error("Selectize initialization failed for", $select);
            }
        });
        $('.btns').click(function (event) {

        });
        // switch button

        $('.switch_toggle_button').click(function (e) {

            var button = $(this);
            var form = button.closest("form");
            var statusValue = button.val();

            event.preventDefault();

            swal({
                title: `Are you sure you want to change the status of this record?`,
                text: "If you change this, it will be gone.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willChange) => {
                if (willChange) {
                    button.val(statusValue == 0 ? 1 : 0);
                    form.submit();
                } else {
                    location.reload();
                }
            });
        });


        $('.statusForm').on('submit', function (e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function (response) {
                    if (response.success) {
                        swal("Success!", "Roles updated successfully!", "success");
                    } else {
                        swal("Error!", "There was an issue updating the roles.", "error");
                    }
                },
                error: function (xhr, status, error) {
                    swal("Error!", "An error occurred while updating roles", "error");
                }
            });
        });

        function confirmDelete() {

            $(document).on('click', '.delete_order', function (event) {
                event.preventDefault();
                swal({
                    title: `Are you sure you want to delete this order?`,
                    text: "If you change this, it will be gone.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then(async (willChange) => {
                    if (willChange) {
                        event.currentTarget.submit()
                    } else {
                        return false
                    }
                });
            });

        }
        confirmDelete();

        function ConfirmRestore() {

            $(document).on('click', '.restore_order', function (event) {
                event.preventDefault();
                swal({
                    title: `Are you sure you want to Restore this order?`,
                    text: "If you change this, it will be gone.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then(async (willChange) => {
                    if (willChange) {
                        event.currentTarget.submit()
                    } else {
                        return false
                    }
                });
            });

        }
        ConfirmRestore();

        //     $('#selectAll').on('click', function () {
        //         $('.orderCheckbox').prop('checked', this.checked);
        //         toggleDeleteButton();
        //     });

        //     $('.orderCheckbox').change(function() {
        //     toggleDeleteButton();
        // });

        //     function toggleDeleteButton() {
        //     if ($('.orderCheckbox:checked').length > 0) {
        //         $('#deleteSelected').show();
        //     } else {
        //         $('#deleteSelected').hide();
        //     }
        // }

        //     $('#deleteSelected').on('click', function () {
        //         var selectedOrders = [];
        //         $('.orderCheckbox:checked').each(function () {
        //             selectedOrders.push($(this).val());
        //         });

        //         if (selectedOrders.length === 0) {
        //             swal("Warning", "No orders selected", "warning");
        //             return;
        //         }

        //         swal({
        //             title: "Are you sure you want to delete selected orders?",
        //             text: "Once deleted, you will not be able to recover these records!",
        //             icon: "warning",
        //             buttons: true,
        //             dangerMode: true,
        //         }).then((willDelete) => {
        //             if (willDelete) {
        //                 $.ajax({
        //                     url: "{{ route('order.massDelete') }}",
        //                     type: "POST",
        //                     data: {
        //                         _token: "{{ csrf_token() }}",
        //                         order_ids: selectedOrders
        //                     },
        //                     success: function (response) {
        //                         swal("Success!", "Selected orders deleted successfully!", "success")
        //                             .then(() => location.reload());
        //                     },
        //                     error: function () {
        //                         swal("Error!", "There was an issue deleting orders", "error");
        //                     }
        //                 });
        //             }
        //         });
        //     });

        $(document).ready(function () {
            $('.table').DataTable({
                paging: false,
                ordering: false,
                searching: false
            });
        });

        $(document).ready(function () {
            $(document).on('change', '.status', function (event) {

                var form = $(this).closest('form');
                var selectedName = $(this).find(':selected').text();
                event.preventDefault();
                swal({
                    title: `Are you sure you want to change status to ${selectedName}?`,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willChange) => {
                    if (willChange) {
                        form.submit();
                    } else {
                        location.reload();
                    }
                });
            });
        });

    </script>
@endsection