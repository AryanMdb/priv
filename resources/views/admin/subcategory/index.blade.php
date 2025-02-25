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
                <h4 class="card-title">Sub Category TABLE</h4>
            </div>
                <div class=" col-md-5 col-12 my-3 d-flex">
                <form class="mr-3 w-100" method="GET" action="{{ route('subcategory.index') }}">
                    <select name="entries" class="form-control w-100" onchange="this.form.submit()">
                        <option value="10" {{ request('entries', 10)==10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('entries')==25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('entries')==50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('entries')==100 ? 'selected' : '' }}>100</option>
                    </select>
                </form>
            
                <a class="bl_btn mb-0 align-items-center d-flex justify-content-center w-100" href="{{ route('subcategory.create') }}">Add Sub Category</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped" id="table">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Active/Inactive</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="sortable">
                    @if(isset($subcategories))
                    @php $i = ($subcategories->currentPage() - 1) * $subcategories->perPage() + 1; @endphp
                    @foreach($subcategories as $key => $make)
                    <tr id="{{ $make->id }}">
                        <td>
                            <div class="d-flex align-items-center"> {{ $i++ }}
                                <i class="fas fa-grip-vertical ml-3 text-muted table-grip-icon"></i></div>
                           
                        </td>
                        <td class="py-1">
                            @php
                            $link = asset(config('constants.default_image'));
                            if (!empty($make->image)) {
                            $link = asset('storage/subcategory/' . $make->image);
                            }
                            @endphp
                            <img src="{{ $link }}" alt="subcategory image">
                        </td>
                        <td>{{ ucfirst($make->category->title) }}</td>
                        <td>{{ ucfirst($make->title) }}</td>
                        <td>
                            <form action="{{ route('subcategory.status') }}" method="POST" style="height: 34px;">
                                @csrf
                                <input type="hidden" name="id" value="{{ $make->id }}">
                                <label class="switch">
                                    <input type="checkbox" name="switch" class="switch_toggle_button btns"
                                        data-sid="{{ $make->id }}" value="{{ $make->status }}" @if($make->status == '1')
                                    checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </form>
                        </td>
                        <td>
                            <a class="edit-btn" href="{{ route('subcategory.edit', $make->id) }}">
                                <i class="icon-note"></i>
                            </a>
                            <a class="show-btn" href="{{ route('subcategory.show', $make->id) }}">
                                <i class="icon-eye"></i>
                            </a>
                            <form class="delete-btn" action="{{ route('subcategory.destroy', $make->id) }}"
                                method="POST">
                                @csrf
                                <button type="submit" class="btn">
                                    <i class="icon-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="6" class="text-center">Data Not Found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>

            <div class="pagination-table mt-5">
                {{ $subcategories->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script>
    $('.btn').click(function (event) {
        var form = $(this).closest("form");
        event.preventDefault();
        swal({
            title: "Are you sure you want to delete this record?",
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                form.submit();
            }
        });
    });

    $('.switch_toggle_button').click(function (e) {
        var isChecked = $(this).is(":checked");
        $(this).val(isChecked ? '1' : '0');
        var form = $(this).closest("form");
        var statusMessage = isChecked ? 'Active' : 'Inactive';
        swal({
            title: `Are you sure you want to change this subcategory to ${statusMessage}?`,
            text: "If you change this, it will not be shown in app.",
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

    $(document).ready(function () {
        $('.table').DataTable({
            paging: false,
            ordering: false,
            searching: false
        });
    });

    new Sortable(document.getElementById('sortable'), {
        animation: 150,
        forceFallback: true,
        fallbackTolerance: 5,
        scroll: true,
        handle: ".table-grip-icon",
        scrollSensitivity: 100,
        scrollSpeed: 10,
        onEnd: function () {
            let order = [];
            let currentPage = parseInt("{{ request()->get('page', 1) }}");
            let perPage = parseInt("{{ $subcategories->perPage() }}");
            let startIndex = (currentPage - 1) * perPage + 1;

            $('#sortable tr').each(function (index) {
                let id = $(this).attr('id');
                let newIndex = startIndex + index;
                order.push({ id: id, position: newIndex });
            });

            $.ajax({
                url: "{{ route('subcategory.updateOrder') }}",
                type: "POST",
                data: {
                    order: order,
                    _token: "{{ csrf_token() }}",
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
</script>

@endsection