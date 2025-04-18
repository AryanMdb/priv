
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
            <div class="w-100 align-items-center justify-content-between mb-4 d-flex row mx-0">
                <div class="col-md-7 col-12">
                    <h4 class="card-title">Category TABLE</h4>
                </div>
                <div class=" col-md-5 col-12 my-3 d-flex">
                    <form class="w-100 mr-4" method="GET" action="<?php echo e(route('category.index')); ?>">
                        <select name="entries" class="form-control w-100" onchange="this.form.submit()">
                            <option value="10" <?php echo e(request('entries', 10) == 10 ? 'selected' : ''); ?>>10</option>
                            <option value="25" <?php echo e(request('entries') == 25 ? 'selected' : ''); ?>>25</option>
                            <option value="50" <?php echo e(request('entries') == 50 ? 'selected' : ''); ?>>50</option>
                            <option value="100" <?php echo e(request('entries') == 100 ? 'selected' : ''); ?>>100</option>
                        </select>
                    </form>

                    <a class="bl_btn align-items-center d-flex justify-content-center mb-0 mx-0 w-100"
                        href="<?php echo e(route('category.create')); ?>">Add Category</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped" id="table">
                    <thead>
                        <tr>
                            <th >S.No.</th>
                            <th >Image</th>
                            <th >Title</th>
                            <th >Active/Inactive</th>
                            <th >Action</th>
                        </tr>
                    </thead>
                    <tbody id="sortable">
                        <?php if(isset($categories)): ?>
                                        <?php $i = ($categories->currentPage() - 1) * $categories->perPage() + 1; ?>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $make): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr data-id="<?php echo e($make->id); ?>">
                                                            <div class="d-flex align-items-center">
                                                                <td><?php echo e($i++); ?><i class="fas fa-grip-vertical ml-3 text-muted table-grip-icon"></i></td>
                                                            </div>
                                                            <td class="py-1">
                                                                <?php
                                            $link = asset(config('constants.default_image'));
                                            if (!empty($make->image)) {
                                                $link = asset('storage/category/' . $make->image);
                                            }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ?>
                                                                <img class="category" src="<?php echo e($link); ?>" alt="make logo">
                                                            </td>
                                                            <td><?php echo e(ucfirst($make->title)); ?></td>
                                                            <td>
                                                                <form action="<?php echo e(route('category.status')); ?>" method="POST" style="height: 34px;">
                                                                    <?php echo csrf_field(); ?>
                                                                    <input type="hidden" name="id" value="<?php echo e($make->id); ?>">
                                                                    <label class="switch">
                                                                        <input type="checkbox" name="switch" class="switch_toggle_button btns"
                                                                            data-sid="<?php echo e($make->id); ?>" value="<?php echo e($make->status); ?>" <?php if(
                                                                                $make->status ==
                                                                                '1'
                                                                            ): ?><?php echo e('checked'); ?><?php endif; ?>>
                                                                        <span class="slider round"></span>
                                                                    </label>
                                                                </form>
                                                            </td>
                                                            <td>
                                                                <a class="edit-btn" href="<?php echo e(route('category.edit', $make->id)); ?>"><i
                                                                        class="icon-note"></i></a>
                                                                <a class="show-btn" href="<?php echo e(route('category.show', $make->id)); ?>"><i
                                                                        class="icon-eye"></i></a>
                                                                <form class="delete-btn" action="<?php echo e(route('category.destroy', $make->id)); ?>" method="POST">
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
                    <?php echo e($categories->appends(request()->query())->links()); ?>

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

        $('.btns').click(function (event) {
            // No action defined for this event handler yet
        });

        $('.switch_toggle_button').click(function (e) {
            var isChecked = $(this).is(":checked");
            $(this).val(isChecked ? '1' : '0');

            var form = $(this).closest("form");
            var statusMessage = isChecked ? 'Active' : 'Inactive';
            swal({
                title: `Are you sure you want to change this category to ${statusMessage}?`,
                text: "If you change this, it will not be shown in app.",
                buttons: true,
                dangerMode: true,
            }).then((willDeactive) => {
                if (willDeactive) {
                    form.submit();
                } else {
                    location.reload();
                }
            });
        });

        // -------------------- DRAGS ROWS START -----------------------------

        $(document).ready(function () {
            $('.table').DataTable({
                paging: false,
                ordering: false,
                searching: false
            });
        });

        new Sortable(document.getElementById('sortable'), {
            animation: 150,
            forceFallback: true,
            fallbackTolerance: 5,
            scroll: true,
            handle: ".table-grip-icon",
            scrollSensitivity: 100,
            scrollSpeed: 10,
            onEnd: function () {
                let order = [];

                let currentPage = parseInt("<?php echo e(request()->get('page', 1)); ?>");
                let perPage = parseInt("<?php echo e($categories->perPage()); ?>");
                let startIndex = (currentPage - 1) * perPage + 1;

                $('#sortable tr').each(function (index) {
                    let id = $(this).data('id');
                    let newIndex = startIndex + index;

                    order.push({ id: id, position: newIndex });
                });

                $.ajax({
                    url: "<?php echo e(route('category.updateOrder')); ?>",
                    type: "POST",
                    data: {
                        order: order,
                        _token: '<?php echo e(csrf_token()); ?>',
                        page: currentPage
                    },
                    success: function (response) {
                        console.log('Order updated successfully:', response);
                        location.reload();
                    },
                    error: function (xhr) {
                        console.log('Error:', xhr.responseText);
                    }
                });
            }
        });

        // -------------------- DRAGS ROWS END -----------------------------

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\The Mad Brains\priv\resources\views/admin/category/index.blade.php ENDPATH**/ ?>