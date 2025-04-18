
<?php $__env->startSection('contant'); ?>
<div class="card col-12">
    <div class="card-body">
        <div class="w-100 align-items-center justify-content-between mb-4 d-flex">  
            <h4 class="card-title">PUSH NOTIFICATIONS</h4>
            <a class=" bl_btn mb-0" href="<?php echo e(route('push_notification.create')); ?>">ADD</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped"  id="table">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Title</th>
                        <th width="50%">Message</th>
                        <th>Send Notification</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                 <?php $__currentLoopData = $notificationData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="py-1"><?php echo e($key+1); ?></td>
                        <td><?php echo e($notification->title); ?></td>
                        <td><?php echo substr(strip_tags($notification->message),0, 350).'...';?></td>
                        <td>
                            <form action="<?php echo e(route('send_push_notification', $notification->id)); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-primary btn-sm btn-notification">Send Notification</button>
                            </form>
                        </td>
                        <td>
                            <a class="edit-btn" href="<?php echo e(route('push_notification.edit', $notification->id)); ?>">
                                <i class="icon-note"></i>
                            </a>
                            <a class="show-btn" href="<?php echo e(route('push_notification.show', $notification->id)); ?>">
                                <i class="icon-eye"></i>
                            </a>
                            <form class="delete-btn" action="<?php echo e(route('push_notification.destroy', $notification->id)); ?>" method="POST">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script type="text/javascript">
    $('.btn-notification').click(function(event) {
          var form =  $(this).closest("form");
          var name = $(this).data("name");
          event.preventDefault();
          swal({
              title: `Are you sure you want send notification to all users?`,
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
     // switch button
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
        event.preventDefault();
        swal({
            title: `Are you sure you want to status change this record?`,
            text: "If you change this, it will be gone.",
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



<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\The Mad Brains\messho\resources\views/admin/push_notification/index.blade.php ENDPATH**/ ?>