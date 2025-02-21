@extends('admin.layouts.master')
@section('contant')
<div class="card col-12">
    <div class="card-body">
        <div class="w-100 align-items-center justify-content-between mb-4 d-flex">  
            <h4 class="card-title">SUBADMINS</h4>
            <a class=" bl_btn mb-0" href="{{route('subadmins.create')}}">ADD</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped"  id="table">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        {{-- <th>Permissions</th> --}}
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subadmins as $subadmin)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $subadmin->name }}</td>
                            <td>{{ $subadmin->email }}</td>
                            <td>{{ $subadmin->roles->first()->name ?? '' }}</td>
                            {{-- <td>
                                @foreach($subadmin->permissions as $permission)
                                    {{ $permission->name }}<br>
                                @endforeach
                            </td> --}}
                            <td>
                                <a class="edit-btn" href="{{route('subadmins.edit', $subadmin->id)}}">
                                    <i class="icon-note"></i>
                                </a>
                                <form class="delete-btn" action="{{route('subadmins.destroy', $subadmin->id)}}" method="POST">
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
