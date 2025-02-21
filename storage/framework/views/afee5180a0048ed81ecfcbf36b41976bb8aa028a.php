<?php $__env->startSection('contant'); ?>
<div class="card col-12">
    <div class="card-body">
        <div class="w-100 align-items-center justify-content-between mb-4 d-flex">  
            <h4 class="card-title">Orders List</h4> 
            <a class=" bl_btn mb-0" href="<?php echo e(route('orders.export')); ?>">Download Excel</a>  
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Order Id</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                 <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="py-1"><?php echo e($key+1); ?></td>
                        <td><?php echo e($order->order_id); ?></td>
                        <td><?php echo e($order?->cart?->category?->title); ?></td>
                        <td><?php echo e($order->name); ?></td>
                        <td>₹<?php echo e($order?->cart?->grant_total); ?></td>
                        <td>
                            <?php if($order->status == 'payment_completed'): ?>
                                <button type="button" class="btn btn-success btn-sm switch_toggle_button" style="pointer-events: none;">Payment Completed</button>
                                <?php else: ?>
                                <input type="hidden" name="id" value="<?php echo e($order->id); ?>">
                                <form action="<?php echo e(route('order-manage.status', $order->id)); ?>" method="POST" id="statusForm">
                                    <?php echo csrf_field(); ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select name="status" id="status" class="form-control status" data-id="<?php echo e($order->status); ?>">
                                                <?php $__currentLoopData = config('constants.order_status'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($key); ?>" <?php echo e($key ==  $order->status ? 'selected' : ''); ?>><?php echo e($value); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a class="show-btn" href="<?php echo e(route('order-manage.show', $order->id)); ?>">
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

     $(document).ready(function() {
        $(document).on('change', '.status', function(event) {

            var form = $(this).closest('form');
            var selectedName = $(this).find(':selected').text();
            event.preventDefault();
            swal({
                title: `Are you sure you want to change status to ${selectedName}?`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willChange) => {
                if (willChange) {
                    form.submit();
                } else {
                    location.reload();
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('subadmin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1290354.cloudwaysapps.com/bhqcygtvak/public_html/resources/views/subadmin/orders/index.blade.php ENDPATH**/ ?>