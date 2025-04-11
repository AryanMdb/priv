@extends('admin.layouts.master')

<?php
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
?>

@section('contant')
    <style type="text/css">
        .rate {
            display: flex;
        }

        .star-color-yellow {
            color: #ffc700;
            font-size: 20px;
        }

        .star-color-gray {
            color: #b7b3b3f2;
            font-size: 20px;
        }

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
                <div class="col-md-2 col-12">
                    <h4 class="card-title">USERS TABLE</h4>
                </div>
                <div class="col-xl-7 col-md-12 col-12 w-100 d-flex justify-content-end mt-3">
                    <div class="d-flex w-100">
                        <form class="w-100 mr-1" method="GET" action="{{ route('user.index') }}" id="searchForm">
                            <input class="form-control" type="search" name="search" id="search" placeholder="Search Users"
                                value="{{ request('search') }}">
                            <input type="hidden" name="entries" value="{{ request('entries', 10) }}">
                        </form>

                        <form class="mr-3 w-100" method="GET" action="{{ route('user.index') }}">
                            <input type="hidden" name="search" value="{{ request('search') }}">

                            <select name="entries" class="form-control w-100" onchange="this.form.submit()">
                                <option value="10" {{ request('entries', 10) == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </form>
                        <a class="bl_btn align-items-center d-flex justify-content-center mb-0 mx-0 w-100"
                            href="{{ route('user.create') }}">Add New User</a>
                            <a class="bl_btn align-items-center d-flex justify-content-center mb-0 mx-0 w-100 ml-2"
                            href="{{ route('export.users') }}">Download Excel</a> 
                    </div>
                </div>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success</strong> {{ $message }}
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
            @endif
            @if ($errors->any())
                @foreach ($errors->all() as $message)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error</strong> {{ $message }}
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    </div>
                @endforeach
            @endif

            <div class="table-responsive">
                <table class="table table-striped" id="table">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Full Name</th>
                            <th>Image</th>
                            <th>Phone No.</th>
                            <th>Gender</th>
                            <th>Active/Inactive</th>
                            <th>Time & Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = ($users->currentPage() - 1) * $users->perPage() + 1; @endphp
                        @foreach ($users as $key => $user)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $user->name }}</td>
                                <td class="py-1">
                                    <img src="@if (isset($user->image)){{asset('storage/profile_image/' . $user->image)}} @else {{ asset(config('constants.default_profile_image'))}} @endif"
                                        alt="image">
                                </td>
                                <td>{{ $user->phone ?? '' }}</td>
                                <td>{{ $user->gender_type ?? '' }}</td>
                                <td>
                                    <form action="{{ route('user.switch.toggle') }}" method="POST" style="height: 34px;">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $user['id'] }}">
                                        <label class="switch">
                                            <input type="checkbox" name="switch" class="switch_toggle_button btns"
                                                data-sid="{{ $user['id'] }}" value="{{ $user['status'] }}"
                                                @if($user['status'] == '1') {{ 'checked' }} @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </form>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('j F Y g:iA') }}</td>
                                <td>
                                    {{-- <a class="edit-btn" href="{{ route('user.edit', $user['id']) }}"><i
                                            class="icon-note"></i></a> --}}
                                    <a class="show-btn" href="{{ route('user.show', $user['id']) }}"><i
                                            class="icon-eye"></i></a>
                                    <form class="delete-btn" action="{{ route('user.destroy', $user['id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination-table mt-5">
                    {{ $users->appends(request()->query())->links() }}
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
        // switch


        $('.switch_toggle_button').click(function (e) {
            var isChecked = $(this).is(":checked");
            $(this).val(isChecked ? '1' : '0');

            var form = $(this).closest("form");
            var name = $(this).data("name");
            var statusMessage = isChecked ? 'Active' : 'Inactive';
            event.preventDefault();
            swal({
                title: `Are you sure you want to change this user to ${statusMessage}?`,
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

        $(document).ready(function () {
            $('.table').DataTable({
                paging: false,
                ordering: false,
                searching: false
            });
        });


        // ///////////// SEARCH OPTION /////////////////////////
        document.getElementById('search').addEventListener('input', function () {
            clearTimeout(this.timer);
            this.timer = setTimeout(() => {
                document.getElementById('searchForm').submit();
            }, 800);
        });

    </script>
@endsection