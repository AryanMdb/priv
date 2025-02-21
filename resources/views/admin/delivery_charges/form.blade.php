@extends('admin.layouts.master')
<?php
use Illuminate\Support\Facades\Session;
?>
@section('contant')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">

            <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                <h4 class="card-title">Delivery Charges</h4>
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success</strong> {{ $message }}
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
            @endif
            {{-- @if ($errors->any())
                @foreach ($errors->all() as $message)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error</strong> {{ $message }}
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    </div>
                @endforeach
            @endif --}}

            <form id="delivery_charges" class="forms-sample" method="POST" action="{{ route('delivery_charges.update') }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-8 col-xl-4">
                        <div class="form-group">
                            <label>Range</label>
                        </div>
                    </div>
                    <div class="col-4 col-xl-3">
                        <div class="form-group">
                            <label>Charge (in rupees)</label>
                        </div>
                    </div>
                </div>
            
                @foreach ($deliveryCharges as $deliveryCharge)
                    <div class="row">
                        <div class="col-4 col-xl-2">
                            <div class="form-group">
                                <input type="hidden" name="ids[]" value="{{ $deliveryCharge->id }}">
                                <input type="text" class="form-control" name="from_price[]" value="{{ $deliveryCharge->from_price }}" disabled>
                            </div>
                        </div>
                        <div class="col-4 col-xl-2">
                            <div class="form-group">
                                <input type="text" class="form-control" name="to_price[]" value="{{ $deliveryCharge->to_price }}" disabled>
                            </div>
                        </div>
                        <div class="col-4 col-xl-3">
                            <div class="form-group">
                                <input type="text" class="form-control numeric" name="delivery_charges[]" value="{{ $deliveryCharge->delivery_charges }}">
                            </div>
                        </div>
                        <div class="col-2 col-xl-5">
                            @if ($errors->has('delivery_charges.' . $loop->index))
                                <div class="alert alert-danger" role="alert">
                                    <strong>Error:</strong> {{ $errors->first('delivery_charges.' . $loop->index) }}
                                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                            @endif
                        </div>
        
                    </div>
                @endforeach
                <div class="colmd">
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection