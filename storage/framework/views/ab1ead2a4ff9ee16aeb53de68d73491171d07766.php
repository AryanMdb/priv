
<?php $__env->startSection('contant'); ?>
<div class="card col-12">
    <div class="card-body">
        <div class="w-100 align-items-center justify-content-between mb-4 d-flex">  
            <h4 class="card-title">CMS Page's</h4>
            <a class=" bl_btn mb-0" href="<?php echo e(route('cms.create')); ?>">ADD</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped" id="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Slug</th>
                        
                        <th>Description</th>
                        <th>Active/Inactive</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                 <?php $__currentLoopData = $cmsPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cmsPage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="py-1"><?php echo e($key+1); ?></td>
                        <td><?php echo e($cmsPage->title); ?></td>
                        <td><?php echo e($cmsPage->slug); ?></td>
                        
                        <td class="textTd" style="text-align: justify; width: 50%;">
                            <?php echo substr(strip_tags($cmsPage->description),0, 350).'...';?>
                        </td>
                        <td>
                            <form action="<?php echo e(route('cms.status')); ?>" method="POST" style="height: 34px;">
                               <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" value="<?php echo e($cmsPage->id); ?>">
                                <label class="switch">
                                    <input type="checkbox" name="switch" class="switch_toggle_button btns" data-sid="<?php echo e($cmsPage->id); ?>" value="<?php echo e($cmsPage->status); ?>" <?php if($cmsPage->status == '1'): ?><?php echo e('checked'); ?><?php endif; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </form>
                             
                        </td>
                        <td class="text-truncate">
                            <a class="edit-btn" href="<?php echo e(route('cms.edit', $cmsPage->id)); ?>">
                                <i class="icon-note"></i>
                            </a>
                            <a class="show-btn" href="<?php echo e(route('cms.show', $cmsPage->slug)); ?>">
                                <i class="icon-eye"></i>
                            </a>
                            <form class="delete-btn" action="<?php echo e(route('cms.destroy', $cmsPage->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn">
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
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\priv\resources\views/admin/cmsPage/index.blade.php ENDPATH**/ ?>