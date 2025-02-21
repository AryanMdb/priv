@extends('admin.layouts.master')
@section('contant')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">OTP</h4>
                    <!-- <p class="card-description"> Basic form elements </p> -->
            <form class="forms-sample" method="POST" action="{{route('optVerify')}}">
                @csrf
                <div class="form-group">
                    <label for="exampleInputName1">Name</label>
                    <input type="text" class="form-control" id="exampleInputName1" name="otp" placeholder="Enter OTP" required>
                </div>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
            </form>
        </div>
    </div>
</div>

@endsection