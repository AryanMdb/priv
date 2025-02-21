@extends('subadmin.layouts.master')
@section('contant')
<div class="card col-12">
    <div class="card-body">
        <div class="w-100 align-items-center justify-content-between mb-4 d-flex">  
            <h4 class="card-title">Orders List</h4> 
            <a class=" bl_btn mb-0" href="{{ route('orders.export') }}">Download Excel</a>  
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Order Id</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                 @foreach($orders as $key => $order)
                    <tr>
                        <td class="py-1">{{$key+1}}</td>
                        <td>{{$order->order_id}}</td>
                        <td>{{$order?->cart?->category?->title}}</td>
                        <td>{{$order->name}}</td>
                        <td>₹{{$order?->cart?->grant_total}}</td>
                        <td>
                            @if($order->status == 'payment_completed')
                                <button type="button" class="btn btn-success btn-sm switch_toggle_button" style="pointer-events: none;">Payment Completed</button>
                                @else
                                <input type="hidden" name="id" value="{{$order->id}}">
                                <form action="{{route('order-manage.status', $order->id)}}" method="POST" id="statusForm">
                                    @csrf
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select name="status" id="status" class="form-control status" data-id="{{$order->status}}">
                                                @foreach(config('constants.order_status') as $key => $value)
                                                <option value="{{ $key }}" {{ $key ==  $order->status ? 'selected' : '' }}>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </td>
                        <td>
                            <a class="show-btn" href="{{route('order-manage.show', $order->id)}}">
                                <i class="icon-eye"></i>
                            </a>
                        </td>
                    </tr>
                 @endforeach   
                </tbody>
            </table>
        </div>
    </div>
</div>    
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script type="text/javascript">
     $('.btns').click(function(event) {
          
      });
     // switch button
     $('.switch_toggle_button').click(function(e)
     {

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

     $(document).ready(function() {
        $(document).on('change', '.status', function(event) {

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


