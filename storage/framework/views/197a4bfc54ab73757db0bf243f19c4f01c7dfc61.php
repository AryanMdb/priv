
<?php $__env->startSection('contant'); ?>
<div class="card col-12">
    <div class="card-body">
        <div class="w-100 align-items-center justify-content-between mb-4 d-flex">  
            <h4 class="card-title">SUBADMINS</h4>
            <a class=" bl_btn mb-0" href="<?php echo e(route('subadmins.create')); ?>">ADD</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped"  id="table">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $subadmins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subadmin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($subadmin->name); ?></td>
                            <td><?php echo e($subadmin->email); ?></td>
                            <td><?php echo e($subadmin->roles->first()->name ?? ''); ?></td>
                            
                            <td>
                                <a class="edit-btn" href="<?php echo e(route('subadmins.edit', $subadmin->id)); ?>">
                                    <i class="icon-note"></i>
                                </a>
                                <form class="delete-btn" action="<?php echo e(route('subadmins.destroy', $subadmin->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-delete">
                                        <i class="icon-trash"></i>
                                        </button>
                                    </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\priv\resources\views/admin/subadmins/index.blade.php ENDPATH**/ ?>