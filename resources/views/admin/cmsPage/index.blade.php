@extends('admin.layouts.master')
@section('contant')
<div class="card col-12">
    <div class="card-body">
        <div class="w-100 align-items-center justify-content-between mb-4 d-flex">  
            <h4 class="card-title">CMS Page's</h4>
            <a class=" bl_btn mb-0" href="{{route('cms.create')}}">ADD</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped" id="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Slug</th>
                        {{-- <th>Icon (Image)</th> --}}
                        <th>Description</th>
                        <th>Active/Inactive</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                 @foreach($cmsPages as $key => $cmsPage)
                    <tr>
                        <td class="py-1">{{$key+1}}</td>
                        <td>{{$cmsPage->title}}</td>
                        <td>{{$cmsPage->slug}}</td>
                        {{-- <td>
                            @if(isset($cmsPage->icon_image) && $cmsPage->icon_image != '')
                            <img src="{{asset('/pages/icon').'/'.$cmsPage->icon_image}}" alt="icon image" width="120px" />
                            @endif
                        </td> --}}
                        <td class="textTd" style="text-align: justify; width: 50%;">
                            @php echo substr(strip_tags($cmsPage->description),0, 350).'...';@endphp
                        </td>
                        <td>
                            <form action="{{route('cms.status')}}" method="POST" style="height: 34px;">
                               @csrf
                                <input type="hidden" name="id" value="{{$cmsPage->id}}">
                                <label class="switch">
                                    <input type="checkbox" name="switch" class="switch_toggle_button btns" data-sid="{{$cmsPage->id}}" value="{{$cmsPage->status}}" @if($cmsPage->status == '1'){{'checked'}}@endif>
                                    <span class="slider round"></span>
                                </label>
                            </form>
                             
                        </td>
                        <td class="text-truncate">
                            <a class="edit-btn" href="{{route('cms.edit', $cmsPage->id)}}">
                                <i class="icon-note"></i>
                            </a>
                            <a class="show-btn" href="{{route('cms.show', $cmsPage->slug)}}">
                                <i class="icon-eye"></i>
                            </a>
                            <form class="delete-btn" action="{{route('cms.destroy', $cmsPage->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                                <button type="submit" class="btn">
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
     $('.btns').click(function(event) {
          
      });
     // switch button
     $('.switch_toggle_button').click(function(e)
     {
        var isChecked = $(this).is(":checked");
        $(this).val(isChecked ? '1' : '0');

        var form = $(this).closest("form");
        var name = $(this).data("name");
        var statusMessage = isChecked ? 'Active' : 'Inactive';
        event.preventDefault();
        swal({
            title: `Are you sure you want to change this CMS Page to ${statusMessage}?`,
            text: "If you change this, it will not be shown in app.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDeactive) => {
            if (willDeactive) {
                form.submit();
            }else {
                location.reload();
            }
        });
     });
</script>
@endsection


