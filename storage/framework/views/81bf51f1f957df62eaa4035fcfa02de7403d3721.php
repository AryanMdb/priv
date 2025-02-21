
<?php $__env->startSection('contant'); ?>
<div class="card col-12">
    <div class="card-body">
        <div class="w-100 align-items-center justify-content-between mb-4 d-flex">  
            <h4 class="card-title">Enquiry List</h4>
        </div>
        <div class="table-responsive">
            <table class="table table-striped"  id="table">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                 <?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="py-1"><?php echo e($key+1); ?></td>
                        <td><?php echo e($contact->name); ?></td>
                        <td><?php echo e($contact->phone_no); ?></td>
                        <td><?php echo e($contact->email); ?></td>
                        <td>
                            <a class="show-btn" href="<?php echo e(route('enquiry.show', $contact->id)); ?>">
                                <i class="icon-eye"></i>
                            </a>
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
     $('.btns').click(function(event) {
          
      });
     // switch button
     $('.switch_toggle_button').click(function(e)
     {

        var button = $(this);
        var form = button.closest("form");
        var statusValue = button.val();

    event.preventDefault();
    
    swal({
        title: `Are you sure you want to change the status of this record?`,
        text: "If you change this, it will be gone.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willChange) => {
        if (willChange) {
            button.val(statusValue == 0 ? 1 : 0);
            form.submit();
        } else {
            location.reload();
        }
    });
     });
</script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\priv\resources\views/admin/enquiry/index.blade.php ENDPATH**/ ?>