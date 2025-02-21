
<?php $__env->startSection('contant'); ?>
<style>
    .pagination-table .flex.justify-between.flex-1.sm\:hidden,
    .dataTables_paginate,
    .dataTables_info,
    .dataTables_length {
        display: none;
    }
</style>
<div class="card col-12">
    <div class="card-body">
        <div class="w-100 align-items-center justify-content-between mb-4 d-flex row">
            <div class="col-md-6 col-12">
                <h4 class="card-title">Coupon TABLE</h4>
            </div>
            <div class=" col-md-5 col-12 my-3 d-flex">
                <form class="mr-3 w-100" method="GET" action="<?php echo e(route('coupon.index')); ?>">
                    <select name="entries" class="form-control w-100" onchange="this.form.submit()">
                        <option value="10" <?php echo e(request('entries', 10)==10 ? 'selected' : ''); ?>>10</option>
                        <option value="25" <?php echo e(request('entries')==25 ? 'selected' : ''); ?>>25</option>
                        <option value="50" <?php echo e(request('entries')==50 ? 'selected' : ''); ?>>50</option>
                        <option value="100" <?php echo e(request('entries')==100 ? 'selected' : ''); ?>>100</option>
                    </select>
                </form>
           
                <a class="bl_btn align-items-center d-flex justify-content-center mb-0 mx-0 w-100" href="<?php echo e(route('coupon.create')); ?>">Add Coupon</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped" id="table">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Category</th>
                        <th>Discount</th>
                        <th>Status</th>
                        <th>Active/Inactive</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($coupon)): ?>
                    <?php $i = ($coupon->currentPage() - 1) * $coupon->perPage() + 1; ?>
                    <?php $__currentLoopData = $coupon; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $make): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr id="<?php echo e($make->id); ?>">
                        <td><?php echo e($i++); ?></td>
                        <td class="py-1"> <?php echo e($make->name); ?></td>
                        <td><?php echo e($make->code); ?></td>
                        <td>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($category->id == $make->cat_id): ?>
                            <?php echo e($category->title); ?>

                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                        <td>
                            <?php echo e($make->discount_value); ?>

                            <?php if($make->type === 'percentage'): ?>
                            %
                            <?php else: ?>
                            <i class="fa fa-rupee-sign"></i>
                            <?php endif; ?>
                        </td>
                        <td class="py-1">
                            <?php if($make->expires_at->isPast()): ?>
                            <span class="text-danger">Expired</span>
                            <?php else: ?>
                            <?php echo e($make->expires_at->format('Y-m-d')); ?>

                            <?php endif; ?>
                        </td>
                        <td>
                            <form action="<?php echo e(route('coupon.status')); ?>" method="POST" style="height: 34px;">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" value="<?php echo e($make->id); ?>">
                                <label class="switch">
                                    <input type="checkbox" name="switch" class="switch_toggle_button btns"
                                        data-sid="<?php echo e($make->id); ?>" value="<?php echo e($make->status); ?>" <?php if($make->status ==
                                    '1'): ?><?php echo e('checked'); ?><?php endif; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </form>

                        </td>
                        <td>
                            <a class="edit-btn" href="<?php echo e(route('coupon.edit', $make->id)); ?>"><i
                                    class="icon-note"></i></a>
                            <a class="show-btn" href="<?php echo e(route('coupon.show', $make->id)); ?>"><i
                                    class="icon-eye"></i></a>
                            <form class="delete-btn" action="<?php echo e(route('coupon.destroy', $make->id)); ?>" method="POST">
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
            <div class="pagination-table mt-5">
                <?php echo e($coupon->appends(request()->query())->links()); ?>

            </div>
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

    $(document).ready(function () {
        $('.table').DataTable({
            paging: false,
            ordering: false,
            searching: false
        });
    });

    $('.switch_toggle_button').click(function (e) {
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
            }
        });
    });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\priv\resources\views/admin/coupon/index.blade.php ENDPATH**/ ?>