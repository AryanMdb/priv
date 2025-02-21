@extends('admin.layouts.master')
@section('contant')
<div class="card col-12">
    <div class="card-body">
        <div class="w-100 align-items-center justify-content-between mb-4 d-flex">  
            <h4 class="card-title">Roles</h4>
            <a class=" bl_btn mb-0" href="{{route('roles.create')}}">ADD</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped"  id="table">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                <a class="edit-btn" href="{{route('roles.edit', $role->id)}}">
                                    <i class="icon-note"></i>
                                </a>
                                <form class="delete-btn" action="{{route('roles.destroy', $role->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                    <button type="submit" class="btn btn-delete">
                                    <i class="icon-trash"></i>
                                    </button>
                                </form>                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
         $('.btn-delete').click(function(event) {
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
     $('.btns').click(function(event) {
          
      });
</script>
@endsection
