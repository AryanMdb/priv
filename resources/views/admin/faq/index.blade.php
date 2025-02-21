@extends('admin.layouts.master')
@section('contant')
<div class="card col-12">
    <div class="card-body">
        <div class="w-100 align-items-center justify-content-between mb-4 d-flex">  
            <h4 class="card-title">FAQ's</h4>
            <a class=" bl_btn mb-0" href="{{route('faq.create')}}">ADD</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped"  id="table">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th width="20%">Questions</th>
                        <th width="50%">Answers</th>
                        <th width="10%">Active/Inactive</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                 @foreach($faqData as $key => $faq)
                    <tr>
                        <td class="py-1">{{$key+1}}</td>
                        <td>{{$faq->question}}</td>
                        <td class="textTd">@php echo substr(strip_tags($faq->answer),0, 350).'...';@endphp</td>
                        <td>
                            <form action="{{route('faq.status')}}" method="POST">
                               @csrf
                                <input type="hidden" name="id" value="{{$faq->id}}">
                                <label class="switch">
                                    <input type="checkbox" name="switch" class="switch_toggle_button btns" data-sid="{{$faq->id}}" value="{{$faq->status}}" @if($faq->status == '1'){{'checked'}}@endif>
                                    <span class="slider round"></span>
                                </label>
                            </form>
                        </td>
                        <td>
                            <a class="edit-btn" href="{{route('faq.edit', $faq->id)}}"><i class="icon-note"></i></a>
                            <a class="show-btn" href="{{route('faq.show', $faq->id)}}"><i class="icon-eye"></i></a>
                            <form class="delete-btn" action="{{route('faq.destroy', $faq->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                                <button type="submit" class="btn"><i class="icon-trash"></i></button>
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
            title: `Are you sure you want to change this FAQ to ${statusMessage}?`,
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


