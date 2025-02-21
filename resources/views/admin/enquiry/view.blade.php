@extends('admin.layouts.master')
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
                                <h3>Contact Us Details</h3>
                                <div class="projects_data">
                                    <div class="row w-100">
                                        <div class="col-sm-12">
                                            <div class="data">
                                                <table class="table table-striped" id="table">
                                                    <tr>
                                                        <th>Name</th>
                                                        <td>{{$contact->name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Phone Number</th>
                                                        <td>{{$contact->phone_no}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Email</th>
                                                        <td>{{$contact->email}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Description</th>
                                                        <td>{{$contact->description}}</td>
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

@endsection
