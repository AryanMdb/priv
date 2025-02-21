@extends('admin.layouts.master')
@section('contant')
<div class="card col-12">
  <div class="card-body">
    <div class="w-100 align-items-center justify-content-between mb-4 d-flex">  
      <h4 class="card-title">Slider TABLE</h4>
      <a class=" bl_btn mb-0" href="{{route('sliders.create')}}">Add Slider</a>
    </div>  
        <div class="table-responsive">
        <table class="table table-striped" id="table">
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Active/Inactive</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($sliders))
            	@php $i = 1; @endphp
              @foreach($sliders as $key => $make)                
                <tr>
                    <td>{{$i++}}</td>
                    <td class="py-1">
                        <?php
                            $link = asset(config('constants.default_image'));
                            if(!empty($make->image)){
                                $link = asset('storage/slider/' . $make->image) ;
                            }
                        ?>
                      <img src="{{$link}}" alt="make logo" class="slider_image">
                    </td>
                    <td>
                       {{ucfirst($make->title)}}
                    </td>
                    <td>
                        <form action="{{route('slider.status')}}" method="POST" style="height: 34px;">
                           @csrf
                            <input type="hidden" name="id" value="{{$make->id}}">
                            <label class="switch">
                                <input type="checkbox" name="switch" class="switch_toggle_button btns" data-sid="{{$make->id}}" value="{{$make->status}}" @if($make->status == '1'){{'checked'}}@endif>
                                <span class="slider round"></span>
                            </label>
                        </form>
                         
                    </td>
                    <td>
                        <a class="edit-btn" href="{{ route('sliders.edit',$make->id) }}"><i class="icon-note"></i></a>
                        <form class="delete-btn" action="{{route('sliders.destroy',$make->id)}}" method="POST">
                           @csrf
                           @method('DELETE')
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
        var isChecked = $(this).is(":checked");
        $(this).val(isChecked ? '1' : '0');

        var form = $(this).closest("form");
        var name = $(this).data("name");
        var statusMessage = isChecked ? 'Active' : 'Inactive';
        // event.preventDefault();
        swal({
            title: `Are you sure you want to change this slider to ${statusMessage}?`,
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
