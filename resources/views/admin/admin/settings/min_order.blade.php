@extends('admin.layouts.master')
<?php
use Illuminate\Support\Facades\Session;
?>
@section('contant')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                <h4 class="card-title">Minimum Order Value</h4>
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success</strong> {{ $message }}
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
            @endif
            @foreach($value as $item)
                <form id="edit_min_value" class="forms-sample" method="POST" action="{{ route('min_order_add') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputName1">Value</label>
                                <input type="text" class="form-control" id="min_value" name="min_value"
                                    placeholder="Enter Minimum Order Value" value="{{ $item->minimum_order_value }}">
                                @if ($errors->has('min_value'))
                                    <span class="text-danger">{{ $errors->first('min_value') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        </div>
                    </div>
                </form>
            @endforeach
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#edit_min_value').validate({
            highlight: function (element) {
                $(element).closest('.form-control').addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).closest('.form-control').removeClass('is-invalid');
            },
            rules: {
                min_value: {
                    required: true,
                    number: true,
                },
            },
            messages: {
                min_value: {
                    required: 'Please enter Minimum Value',
                    number: 'Only numeric values are allowed',
                },
            }
        });

        $('#min_value').on('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
</script>

@endsection
