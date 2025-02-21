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
                            @if (isset($subcategory->image) && !empty($subcategory->image))
                                @php $subcategory_image = asset('storage/subcategory/'.$subcategory->image);@endphp
                            @else
                                @php $subcategory_image = asset('constants.default_image');@endphp
                            @endif
                            <img src="{{ $subcategory_image }}" alt="user" width="100px" height="100px">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="right-info">
                            <div class="projects">
                                <h3>Sub Category Details</h3>
                                <div class="projects_data">
                                    <div class="row w-100">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <div class="data">
                                                    <table class="table table-striped" id="table">
                                                        <tr>
                                                            <th>Name</th>
                                                            <td>{{ $subcategory->title }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Category</th>
                                                            <td>{{ $subcategory?->category?->title }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Created Date</th>
                                                            <td>@isset($subcategory->created_at)@endisset{{ date('d M Y', strtotime($subcategory->created_at)) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Update Date</th>
                                                            <td>@isset($subcategory->updated_at)@endisset{{ date('d M Y', strtotime($subcategory->updated_at)) }}</td>
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
