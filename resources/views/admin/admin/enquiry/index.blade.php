@extends('admin.layouts.master')
@section('contant')
<div class="card col-12">
    <div class="card-body">
        <div class="w-100 align-items-center justify-content-between mb-4 d-flex">  
            <h4 class="card-title">Enquiry List</h4>
        </div>
        <div class="table-responsive">
            <table class="table table-striped"  id="table">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                 @foreach($contacts as $key => $contact)
                    <tr>
                        <td class="py-1">{{$key+1}}</td>
                        <td>{{$contact->name}}</td>
                        <td>{{$contact->phone_no}}</td>
                        <td>{{$contact->email}}</td>
                        <td>
                            <a class="show-btn" href="{{route('enquiry.show', $contact->id)}}">
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
</script>
@endsection


