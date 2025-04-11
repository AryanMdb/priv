
<?php $__env->startSection('contant'); ?>
<div class="card col-12">
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <div class="d-sm-flex align-items-baseline report-summary-header">
            <h5 class="font-weight-semibold">Report Summary</h5> <span class="ml-auto"></span>
          </div>
        </div>
      </div>&nbsp;
      <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="title">Orders as per Category</label>
              <select name="category_id" id="category_id" class="form-control category_id" required>
                  <option value="" class="form-label">--Select Category--</option>
                  <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($category->id); ?>"><?php echo e($category->title); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
          </div>
        </div>
      </div>
      <div class="row report-inner-cards-wrapper">
        <div class=" col-md -6 col-xl report-inner-card">
          <div class="inner-card-text">
            <span class="report-title">Total Orders</span>
            <h4><?php echo e($total_orders); ?></h4>
            <!-- <span class="report-count"> 2 Reports</span> -->
          </div>
          <div class="inner-card-icon bg-success">
            <a href="<?php echo e(route('order.index')); ?>" style="text-decoration:none; color:white;">
              <i class="icon-magnifier"></i>
            </a>
          </div>
        </div>
        <div class="col-md-6 col-xl report-inner-card">
          <div class="inner-card-text">
            <span class="report-title">Total Earnings</span>
            <h4>₹<?php echo e($totalEarnings); ?></h4>
            <!-- <span class="report-count"> 5 Reports</span> -->
          </div>
          <div class="inner-card-icon bg-warning">
            <a href="<?php echo e(route('order.index')); ?>" style="text-decoration:none; color:white;">
              <i class="icon-wallet"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="row report-inner-cards-wrapper">
        <div class="col-md-6 col-xl report-inner-card">
          <div class="inner-card-text">
            <span class="report-title">Total Subadmins</span>
            <h4><?php echo e($totalSubadmin); ?></h4>
            <!-- <span class="report-count"> 5 Reports</span> -->
          </div>
          <div class="inner-card-icon bg-success">
            <a href="<?php echo e(route('subadmins.index')); ?>" style="text-decoration:none; color:white;">
              <i class="icon-user-follow"></i>
            </a>
          </div>
        </div> 
        <div class="col-md-6 col-xl report-inner-card">
          <div class="inner-card-text">
            <span class="report-title">Total Users</span>
            <h4><?php echo e($totalUser); ?></h4>
            <!-- <span class="report-count"> 5 Reports</span> -->
          </div>
          <div class="inner-card-icon bg-warning">
            <a href="<?php echo e(route('user.index')); ?>" style="text-decoration:none; color:white;">
              <i class="icon-people"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="row report-inner-cards-wrapper">
        <div id="category-report" class="col-md-6 col-xl report-inner-card">
        </div>
        <div class="col-md-6 col-xl report-inner-card">
        </div>
      </div>
    </div>
</div>
<script>
   $(document).ready(function() {
        $(document).on('change', '.category_id', function(event) {
            var categoryId = $(this).val();
            if (categoryId) {
                $.ajax({
                    url: 'orders/category/' + categoryId,
                    method: 'GET',
                    success: function(response) {
                        var cardHtml = `
                                <div class="inner-card-text">
                                    <span class="report-title">Orders in ${response.category}</span>
                                    <h4>${response.orderCount}</h4>
                                </div>
                                <div class="inner-card-icon bg-success">
                                    <a href="<?php echo e(route('order.index')); ?>" style="text-decoration:none; color:white;">
                                      <i class="icon-notebook"></i>
                                    </a>
                                </div>`;
                        $('#category-report').html(cardHtml);
                    }
                });
            } else {
                $('#category-report').html('');
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\The Mad Brains\priv\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>