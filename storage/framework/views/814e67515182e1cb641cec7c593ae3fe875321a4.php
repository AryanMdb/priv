<?php $__env->startSection('contant'); ?>
<div class="card col-12">
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <div class="d-sm-flex align-items-baseline report-summary-header">
            <h5 class="font-weight-semibold">Report Summary</h5> <span class="ml-auto"></span>
          </div>
        </div>
      </div>
      <div class="row report-inner-cards-wrapper">
        <div class=" col-md-6 col-xl report-inner-card">
          <div class="inner-card-text">
            <span class="report-title">Total Orders</span>
            <h4><?php echo e($total_orders); ?></h4>
            <!-- <span class="report-count"> 2 Reports</span> -->
          </div>
          <div class="inner-card-icon bg-success">
            <a href="<?php echo e(route('order-manage.index')); ?>" style="text-decoration:none; color:white;">
              <i class="icon-magnifier"></i>
            </a>
          </div>
        </div>        
      </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('subadmin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\priv\resources\views/subadmin/dashboard.blade.php ENDPATH**/ ?>