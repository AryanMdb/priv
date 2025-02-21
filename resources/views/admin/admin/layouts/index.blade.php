@extends('admin.layouts.master')
@section('contant')
<div class="card col-12">
    <div class="card-body">
        <div class="w-100 align-items-center justify-content-between mb-4 row">
            <div class="col-md-7">
                <h4 class="card-title">Product TABLE</h4>
            </div>
            
            <div class="col-md-5 justify-content-end d-flex">
                <a class=" bl_btn mb-0 mr-3" href="{{ route('products.export') }}">Download Excel</a>
                <a class=" bl_btn mb-0" href="{{route('product.create')}}">Add Product</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped" id="table">
                <thead>
                    <tr>
                        <th width="5%">S.No.</th>
                        <th width="10%">Image</th>
                        <th width="15%">Category</th>
                        <th width="15%">Subcategory</th>
                        <th width="20%">Product</th>
                        <th width="10%">Discount</th>
                        <th width="10%">Active/Inactive</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tbody class="sortable">
                    @if(isset($products))
                        @php $i = 1; @endphp
                            @foreach($products as $key => $make)
                                <tr id="{{ $make->id }}">
                                    
                                    <td>{{$i++}}<i class="fas fa-grip-vertical ml-3 text-muted table-grip-icon"></i></td>
                                    <td class="py-1">
                                        <?php
                                            $defaultImage = asset(config('constants.default_image'));
                                            $images = json_decode($make->image, true);

                                            if (!empty($make->image)) {
                                                if (is_array($images) && !empty($images)) {
                                                    $link = asset('storage/product/' . $images[0]);
                                                } elseif (!is_array($images)) {
                                                    $link = asset('storage/product/' . $make->image);
                                                } else {
                                                    $link = $defaultImage;
                                                }
                                            } else {
                                                $link = $defaultImage;
                                            }
                                                                                                                                                                                                                    ?>
                                <img src="{{ $link }}" alt="make logo">
                            </td>

                            <td>
                                {{ucfirst($make->category->title)}}
                            </td>
                            <td>
                                {{ucfirst($make->subcategory->title)}}
                            </td>
                            <td>
                                {{ucfirst($make->title)}}
                            </td>
                            <td>
                                @if($make->discount) 
                                    <span class="d-flex" style="color:#03ac51;padding:0 5px; text-transform:uppercase;">{{$make->discount}}% off </span>
                                @else
                                    <span class="d-flex text-danger" style="padding:0 5px; text-transform:uppercase;">No Discount</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{route('product.status')}}" method="POST" style="height: 34px;">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$make->id}}">
                                    <label class="switch">
                                        <input type="checkbox" name="switch" class="switch_toggle_button btns"
                                            data-sid="{{$make->id}}" value="{{$make->status}}"
                                            @if($make->status == '1'){{'checked'}}@endif>
                                        <span class="slider round"></span>
                                    </label>
                                </form>

                            </td>
                            <td>
                                <a class="edit-btn" href="{{ route('product.edit', $make->id) }}"><i
                                        class="icon-note"></i></a>
                                <a class="show-btn" href="{{ route('product.show', $make->id) }}"><i
                                        class="icon-eye"></i></a>
                                <form class="delete-btn" action="{{route('product.destroy', $make->id)}}" method="POST">
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

    $('.btn').click(function (event) {
        var form = $(this).closest("form");
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
    $('.btns').click(function (event) {

    });
    $('.switch_toggle_button').click(function (e) {
        var isChecked = $(this).is(":checked");
        $(this).val(isChecked ? '1' : '0');

        var form = $(this).closest("form");
        var name = $(this).data("name");
        var statusMessage = isChecked ? 'Active' : 'Inactive';
        // event.preventDefault();
        swal({
            title: `Are you sure you want to change this product to ${statusMessage}?`,
            text: "If you change this, it will not be shown in app.",
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

    // -------------------- DRAGS ROWS START -----------------------------

    $(document).ready(function () {
        var table = $('.table').DataTable({
            "paging": true,
            "ordering": true,
            "info": false,
            "searching": false,
            "lengthChange": false
        });

        $(".sortable").sortable({
            items: "tr",
            cursor: "move",
            placeholder: "sortable-placeholder",
            helper: function (e, tr) {
                var $originals = tr.children();
                var $helper = tr.clone();

                $helper.children().each(function (index) {
                    $(this).width($originals.eq(index).width());
                });
                return $helper;
            },

            update: function (event, ui) {
                var draggedRow = ui.item;
                var draggedRowId = draggedRow.attr("id");

                // Get the current page index and number of rows per page
                var currentPage = table.page();
                var pageLength = table.page.len();

                // Get the position of the dragged row on the current page
                var localIndex = draggedRow.index();

                // Calculate the global index by considering the current page number and local index on the page
                var globalIndex = (currentPage * pageLength) + localIndex;

                // Get the index of the target drop location (where the item is dropped)
                var dropTargetRow = ui.item.prev(); // The row before the dragged row
                var dropTargetIndex = dropTargetRow.index(); // The index of the dropped target row

                // Get all rows across all pages (to get the full order)
                var allRows = table.rows().nodes();

                // Create an array to store all rows in their current order
                var sortedIDs = [];

                // Loop through all rows and push their data-id to the array
                $(allRows).each(function () {
                    var rowId = $(this).attr("id");
                    sortedIDs.push(rowId);
                });

                // Remove the dragged row from its current position and insert it at the new global position
                var currentGlobalIndex = sortedIDs.indexOf(draggedRowId);
                sortedIDs.splice(currentGlobalIndex, 1);
                sortedIDs.splice(globalIndex, 0, draggedRowId);

                // Send the updated order to the server to update the database
                $.ajax({
                    url: "{{ route('product.updateOrder') }}",
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        sorted_ids: sortedIDs,
                        updated_row_id: draggedRowId,
                        new_position: globalIndex
                    },
                    success: function (response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Failed to update the order: ' + response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('An error occurred while updating the order.');
                    }
                });
            },
        }).disableSelection();
    });

    // -------------------- DRAGS ROWS END -----------------------------
</script>
@endsection