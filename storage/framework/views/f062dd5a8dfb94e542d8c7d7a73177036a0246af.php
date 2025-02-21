
<?php $__env->startSection('contant'); ?>
<div class="card col-12">
  <div class="card-body">
    <div class="w-100 align-items-center justify-content-between mb-4 d-flex">  
      <h4 class="card-title">Manage Forms TABLE</h4>
      <a class=" bl_btn mb-0" href="<?php echo e(route('manage_forms.create')); ?>">Add Forms</a>
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
                <?php if(isset($manage_forms)): ?>
            	<?php $i = 1; ?>
              <?php $__currentLoopData = $manage_forms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $make): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($i++); ?></td>
                    <td><?php echo e(ucfirst($make?->category?->title)); ?></td>
                    <td>
                        <a class="edit-btn" href="<?php echo e(route('manage_forms.edit',$make->id)); ?>"><i class="icon-note"></i></a>
                        <a class="show-btn" href="<?php echo e(route('manage_forms.show',$make->id)); ?>"><i class="icon-eye"></i></a>
                        <form class="delete-btn" action="<?php echo e(route('manage_forms.destroy',$make->id)); ?>" method="POST">
                           <?php echo csrf_field(); ?>
                            <button type="submit" class="btn">
                                <i class="icon-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php else: ?>
                <?php echo 'Data Not Found.'; ?>
              <?php endif; ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1290354.cloudwaysapps.com/bhqcygtvak/public_html/resources/views/admin/manage_forms/index.blade.php ENDPATH**/ ?>