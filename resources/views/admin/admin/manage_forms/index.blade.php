@extends('admin.layouts.master')
@section('contant')
<div class="card col-12">
  <div class="card-body">
    <div class="w-100 align-items-center justify-content-between mb-4 d-flex">  
      <h4 class="card-title">Manage Forms TABLE</h4>
      <a class=" bl_btn mb-0" href="{{route('manage_forms.create')}}">Add Forms</a>
    </div>  
        <div class="table-responsive">
        <table class="table table-striped" id="table">
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Category Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($manage_forms))
            	@php $i = 1; @endphp
              @foreach($manage_forms as $key => $make)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{ucfirst($make?->category?->title)}}</td>
                    <td>
                        <a class="edit-btn" href="{{ route('manage_forms.edit',$make->id) }}"><i class="icon-note"></i></a>
                        <a class="show-btn" href="{{route('manage_forms.show',$make->id)}}"><i class="icon-eye"></i></a>
                        <form class="delete-btn" action="{{route('manage_forms.destroy',$make->id)}}" method="POST">
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
    </div>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script type="text/javascript">
    
     $('.btn').click(function(event) {
          var form =  $(this).closest("form");
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
     $('.btns').click(function(event) {
          
      });
     $('.switch_toggle_button').click(function(e)
     {
        if($(this).is(":checked"))
        {
            $(this).val('1');
        } else {
            $(this).val('0');
        }

        var form =  $(this).closest("form");
        var name = $(this).data("name");
        // event.preventDefault();
        swal({
            title: `Are you sure you want to status change this record?`,
            text: "If you change this, it will be gone.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDeactive) => {
            if (willDeactive) {
                form.submit();
            } else {
                location.reload();
            }
        });
     });
</script>
@endsection
