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
        <div class="w-100 align-items-center justify-content-between mb-4 d-flex row">
            <div class="col-md-6 col-12">
                <h4 class="card-title">Coupon TABLE</h4>
            </div>
            <div class=" col-md-5 col-12 my-3 d-flex">
                <form class="mr-3 w-100" method="GET" action="{{ route('coupon.index') }}">
                    <select name="entries" class="form-control w-100" onchange="this.form.submit()">
                        <option value="10" {{ request('entries', 10)==10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('entries')==25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('entries')==50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('entries')==100 ? 'selected' : '' }}>100</option>
                    </select>
                </form>
           
                <a class="bl_btn align-items-center d-flex justify-content-center mb-0 mx-0 w-100" href="{{route('coupon.create')}}">Add Coupon</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped" id="table">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Category</th>
                        <th>Discount</th>
                        <th>Status</th>
                        <th>Active/Inactive</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($coupon))
                    @php $i = ($coupon->currentPage() - 1) * $coupon->perPage() + 1; @endphp
                    @foreach($coupon as $key => $make)
                    <tr id="{{ $make->id }}">
                        <td>{{ $i++ }}</td>
                        <td class="py-1"> {{$make->name }}</td>
                        <td>{{ $make->code }}</td>
                        <td>
                            @foreach($categories as $category)
                            @if($category->id == $make->cat_id)
                            {{ $category->title }}
                            @endif
                            @endforeach
                        </td>
                        <td>
                            {{ $make->discount_value }}
                            @if($make->type === 'percentage')
                            %
                            @else
                            <i class="fa fa-rupee-sign"></i>
                            @endif
                        </td>
                        <td class="py-1">
                            @if($make->expires_at->isPast())
                            <span class="text-danger">Expired</span>
                            @else
                            {{ $make->expires_at->format('Y-m-d') }}
                            @endif
                        </td>
                        <td>
                            <form action="{{route('coupon.status')}}" method="POST" style="height: 34px;">
                                @csrf
                                <input type="hidden" name="id" value="{{$make->id}}">
                                <label class="switch">
                                    <input type="checkbox" name="switch" class="switch_toggle_button btns"
                                        data-sid="{{$make->id}}" value="{{$make->status}}" @if($make->status ==
                                    '1'){{'checked'}}@endif>
                                    <span class="slider round"></span>
                                </label>
                            </form>

                        </td>
                        <td>
                            <a class="edit-btn" href="{{ route('coupon.edit', $make->id) }}"><i
                                    class="icon-note"></i></a>
                            <a class="show-btn" href="{{ route('coupon.show', $make->id) }}"><i
                                    class="icon-eye"></i></a>
                            <form class="delete-btn" action="{{ route('coupon.destroy', $make->id) }}" method="POST">
                                @csrf
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
                {{ $coupon->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script type="text/javascript">

    $('.btn').click(function (event) {
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

    $(document).ready(function () {
        $('.table').DataTable({
            paging: false,
            ordering: false,
            searching: false
        });
    });

    $('.switch_toggle_button').click(function (e) {
        var isChecked = $(this).is(":checked");
        $(this).val(isChecked ? '1' : '0');

        var form = $(this).closest("form");
        var name = $(this).data("name");
        var statusMessage = isChecked ? 'Active' : 'Inactive';
        event.preventDefault();
        swal({
            title: `Are you sure you want to change this CMS Page to ${statusMessage}?`,
            text: "If you change this, it will not be shown in app.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDeactive) => {
            if (willDeactive) {
                form.submit();
            }
        });
    });

</script>
@endsection