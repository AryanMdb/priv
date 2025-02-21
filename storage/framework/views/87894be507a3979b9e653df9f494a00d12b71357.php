
<?php $__env->startSection('contant'); ?>
<div class="card col-12">
  <div class="card-body">
    <div class="w-100 align-items-center justify-content-between mb-4 d-flex">  
      <h4 class="card-title">Slider TABLE</h4>
      <a class=" bl_btn mb-0" href="<?php echo e(route('sliders.create')); ?>">Add Slider</a>
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
                <?php if(isset($sliders)): ?>
            	<?php $i = 1; ?>
              <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $make): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                
                <tr>
                    <td><?php echo e($i++); ?></td>
                    <td class="py-1">
                        <?php
                            $link = asset(config('constants.default_image'));
                            if(!empty($make->image)){
                                $link = asset('storage/slider/' . $make->image) ;
                            }
                        ?>
                      <img src="<?php echo e($link); ?>" alt="make logo" class="slider_image">
                    </td>
                    <td>
                       <?php echo e(ucfirst($make->title)); ?>

                    </td>
                    <td>
                        <form action="<?php echo e(route('slider.status')); ?>" method="POST" style="height: 34px;">
                           <?php echo csrf_field(); ?>
                            <input type="hidden" name="id" value="<?php echo e($make->id); ?>">
                            <label class="switch">
                                <input type="checkbox" name="switch" class="switch_toggle_button btns" data-sid="<?php echo e($make->id); ?>" value="<?php echo e($make->status); ?>" <?php if($make->status == '1'): ?><?php echo e('checked'); ?><?php endif; ?>>
                                <span class="slider round"></span>
                            </label>
                        </form>
                         
                    </td>
                    <td>
                        <a class="edit-btn" href="<?php echo e(route('sliders.edit',$make->id)); ?>"><i class="icon-note"></i></a>
                        <form class="delete-btn" action="<?php echo e(route('sliders.destroy',$make->id)); ?>" method="POST">
                           <?php echo csrf_field(); ?>
                           <?php echo method_field('DELETE'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1290354.cloudwaysapps.com/bhqcygtvak/public_html/resources/views/admin/sliders/index.blade.php ENDPATH**/ ?>