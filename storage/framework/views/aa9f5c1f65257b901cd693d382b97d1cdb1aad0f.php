

<?php
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
?>

<?php $__env->startSection('contant'); ?>
<style type="text/css">
    .rate {
        display: flex;
    }

    .star-color-yellow {
        color: #ffc700;
        font-size: 20px;
    }

    .star-color-gray {
        color: #b7b3b3f2;
        font-size: 20px;
    }

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
                <h4 class="card-title">USERS TABLE</h4>
            </div>
            <div class=" col-md-6 col-6 my-3">
                <form class="mx-3 w-100" method="GET" action="<?php echo e(route('user.index')); ?>">
                    <label for="text">Table Entries</label>
                    <select name="entries" class="form-control w-100" onchange="this.form.submit()">
                        <option value="10" <?php echo e(request('entries', 10)==10 ? 'selected' : ''); ?>>10</option>
                        <option value="25" <?php echo e(request('entries')==25 ? 'selected' : ''); ?>>25</option>
                        <option value="50" <?php echo e(request('entries')==50 ? 'selected' : ''); ?>>50</option>
                        <option value="100" <?php echo e(request('entries')==100 ? 'selected' : ''); ?>>100</option>
                    </select>
                </form>
            </div>
            <div class="col-md-12 col-6 justify-content-end d-flex">
                <a class=" bl_btn mb-0" href="<?php echo e(route('user.create')); ?>">ADD</a>
            </div>
        </div>

        <?php if($message = Session::get('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success</strong> <?php echo e($message); ?>

            <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">×</span></button>
        </div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error</strong> <?php echo e($message); ?>

            <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">×</span></button>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped" id="table">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Full Name</th>
                        <th>Image</th>
                        <th>Phone No.</th>
                        <th>Gender</th>
                        <th>Active/Inactive</th>
                        <th>Time & Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = ($users->currentPage() - 1) * $users->perPage() + 1; ?>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($i++); ?></td>
                        <td><?php echo e($user->name); ?></td>
                        <td class="py-1">
                            <img src="<?php if(isset($user->image)): ?><?php echo e(asset('storage/profile_image/'.$user->image)); ?> <?php else: ?> <?php echo e(asset(config('constants.default_profile_image'))); ?> <?php endif; ?>"
                                alt="image">
                        </td>
                        <td><?php echo e($user->phone ?? ''); ?></td>
                        <td><?php echo e($user->gender_type ?? ''); ?></td>
                        <td>
                            <form action="<?php echo e(route('user.switch.toggle')); ?>" method="POST" style="height: 34px;">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" value="<?php echo e($user['id']); ?>">
                                <label class="switch">
                                    <input type="checkbox" name="switch" class="switch_toggle_button btns"
                                        data-sid="<?php echo e($user['id']); ?>" value="<?php echo e($user['status']); ?>"
                                        <?php if($user['status']=='1' ): ?> <?php echo e('checked'); ?> <?php endif; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </form>
                        </td>
                        <td><?php echo e(\Carbon\Carbon::parse($user->created_at)->format('j F Y g:iA')); ?></td>
                        <td>
                            
                            <a class="show-btn" href="<?php echo e(route('user.show', $user['id'])); ?>"><i
                                    class="icon-eye"></i></a>
                            <form class="delete-btn" action="<?php echo e(route('user.destroy', $user['id'])); ?>" method="POST">
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
            <div class="pagination-table mt-5">
                <?php echo e($users->appends(request()->query())->links()); ?>

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
    // switch


    $('.switch_toggle_button').click(function (e) {
        var isChecked = $(this).is(":checked");
        $(this).val(isChecked ? '1' : '0');

        var form = $(this).closest("form");
        var name = $(this).data("name");
        var statusMessage = isChecked ? 'Active' : 'Inactive';
        event.preventDefault();
        swal({
            title: `Are you sure you want to change this user to ${statusMessage}?`,
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

    $(document).ready(function () {
        $('.table').DataTable({
            paging: false,
            ordering: false,
            searching: false
        });
    });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1290354.cloudwaysapps.com/bhqcygtvak/public_html/resources/views/admin/users/index.blade.php ENDPATH**/ ?>