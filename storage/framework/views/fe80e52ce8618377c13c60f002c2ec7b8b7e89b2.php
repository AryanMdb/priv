
<?php $__env->startSection('contant'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <style>
        .pagination-table .flex.justify-between.flex-1.sm\:hidden,
        .dataTables_paginate,
        .dataTables_info {
            display: none;
        }

        select.form-control.status {
            width: fit-content;
        }

        .item {
            text-wrap: nowrap;
        }
    </style>

    <div class="card col-12">
        <div class="card-body">
            <div class="w-100 align-items-center justify-content-between mb-4 d-flex row">
                <div class="col-md-6 col-12">
                    <h4 class="card-title">Orders List</h4>
                </div>
                <div class=" col-md-6 col-6 my-3">
                    <form class="mx-3 w-100" method="GET"
                        action="<?php echo e(request()->is('admin/orders/trashed') ? route('orders.trashed') : route('order.index')); ?>">
                        <label for="text">Table Entries</label>
                        <select name="entries" class="form-control w-100" onchange="this.form.submit()">
                            <option value="10" <?php echo e(request('entries', 10) == 10 ? 'selected' : ''); ?>>10</option>
                            <option value="25" <?php echo e(request('entries') == 25 ? 'selected' : ''); ?>>25</option>
                            <option value="50" <?php echo e(request('entries') == 50 ? 'selected' : ''); ?>>50</option>
                            <option value="100" <?php echo e(request('entries') == 100 ? 'selected' : ''); ?>>100</option>
                        </select>
                    </form>
                </div>
                <div class="col-md-12 col-6 justify-content-end d-flex">
                    <a class=" bl_btn mb-0" href="<?php echo e(route('export-orders')); ?>">Download Excel</a>
                    <button id="deleteSelected" style="display: none;" class="btn btn-danger mb-1">Delete Selected</button>
                </div>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs" id="orderTabs">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->is('admin/order/list') ? 'active' : ''); ?>"
                        href="<?php echo e(route('order.index')); ?>">All Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->is('admin/orders/trashed') ? 'active' : ''); ?>"
                        href="<?php echo e(route('orders.trashed')); ?>">Trashed Orders</a>
                </li>
            </ul>

            <div class="table-responsive mt-4">
                <table class="table table-striped" id="table">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Order Id</th>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th style="width: 20%;">Subadmin</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = ($orders->currentPage() - 1) * $orders->perPage() + 1; ?>
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="py-1"><?php echo e($i++); ?></td>
                                <td><?php echo e($order->order_id); ?></td>
                                <td><?php echo e($order->cart?->category?->title); ?></td>
                                <td><?php echo e($order->name); ?></td>
                                <td>₹<?php echo e($order->cart?->grant_total); ?></td>
                                <td>
                                    <form action="<?php echo e(route('order.assign-subadmin', $order->id)); ?>" method="POST"
                                        class="statusForm">
                                        <?php echo csrf_field(); ?>
                                        <select class="assign_subadmin w-100" name="role_id[]" multiple="multiple">
                                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($role->id); ?>" <?php echo e(in_array($role->id, (array) json_decode($order->role_id)) ? 'selected' : ''); ?>>
                                                    <?php echo e($role->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <?php if($order->status == 'payment_completed'): ?>
                                        <button type="button" class="btn btn-success btn-sm switch_toggle_button"
                                            style="pointer-events: none;">Payment Completed</button>
                                    <?php else: ?>
                                        <form action="<?php echo e(route('order.status', $order->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <select name="status" class="form-control status">
                                                <?php $__currentLoopData = config('constants.order_status'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($key); ?>" <?php echo e($key == $order->status ? 'selected' : ''); ?>>
                                                        <?php echo e($value); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </form>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($order->trashed()): ?>
                                        <form class="restore_order" action="<?php echo e(route('orders.restore', $order->id)); ?>"
                                            method="POST">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn show-btn"> <i class="icon-reload"></i></button>
                                        </form>
                                        <form class="delete-btn delete_order" action="<?php echo e(route('orders.delete', $order->id)); ?>"
                                            method="POST">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <a class="show-btn" href="<?php echo e(route('order.show', $order->id)); ?>">
                                            <i class="icon-eye"></i>
                                        </a>
                                        <form class="delete-btn delete_order" action="<?php echo e(route('order.destroy', $order->id)); ?>"
                                            method="POST">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <div class="pagination-table mt-5">
                    <?php echo e($orders->appends(request()->query())->links()); ?>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script type="text/javascript">


        $('.assign_subadmin').each(function () {
            var $select = $(this);


            var selectizeInstance = $select.selectize({
                plugins: ['remove_button'],
                onChange: function (selectedRoles) {
                    var form = $select.closest('form');
                    var action = form.attr('action');
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    if (!csrfToken) {
                        console.error("CSRF token is missing!");
                        return;
                    }

                    var formData = {
                        _token: csrfToken, // Ensure token is sent
                        role_id: selectedRoles
                    };

                    console.log('Submitting form data:', formData);

                    $.ajax({
                        url: action,
                        type: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // Send CSRF token
                        },
                        success: function (response) {
                            swal("Success!", "Roles updated successfully!", "success");
                        },
                        error: function (xhr, status, error) {
                            swal("Error!", "An error occurred while updating roles", "error");
                            console.error('Error details:', error);
                        }
                    });
                }
            });

            // Ensure the Selectize instance is correctly initialized
            if (!selectizeInstance[0].selectize) {
                console.error("Selectize initialization failed for", $select);
            }
        });
        $('.btns').click(function (event) {

        });
        // switch button

        $('.switch_toggle_button').click(function (e) {

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


        $('.statusForm').on('submit', function (e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function (response) {
                    if (response.success) {
                        swal("Success!", "Roles updated successfully!", "success");
                    } else {
                        swal("Error!", "There was an issue updating the roles.", "error");
                    }
                },
                error: function (xhr, status, error) {
                    swal("Error!", "An error occurred while updating roles", "error");
                }
            });
        });

        function confirmDelete() {

            $(document).on('click', '.delete_order', function (event) {
                event.preventDefault();
                swal({
                    title: `Are you sure you want to delete this order?`,
                    text: "If you change this, it will be gone.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then(async (willChange) => {
                    if (willChange) {
                        event.currentTarget.submit()
                    } else {
                        return false
                    }
                });
            });

        }
        confirmDelete();

        function ConfirmRestore() {

            $(document).on('click', '.restore_order', function (event) {
                event.preventDefault();
                swal({
                    title: `Are you sure you want to Restore this order?`,
                    text: "If you change this, it will be gone.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then(async (willChange) => {
                    if (willChange) {
                        event.currentTarget.submit()
                    } else {
                        return false
                    }
                });
            });

        }
        ConfirmRestore();

        //     $('#selectAll').on('click', function () {
        //         $('.orderCheckbox').prop('checked', this.checked);
        //         toggleDeleteButton();
        //     });

        //     $('.orderCheckbox').change(function() {
        //     toggleDeleteButton();
        // });

        //     function toggleDeleteButton() {
        //     if ($('.orderCheckbox:checked').length > 0) {
        //         $('#deleteSelected').show();
        //     } else {
        //         $('#deleteSelected').hide();
        //     }
        // }

        //     $('#deleteSelected').on('click', function () {
        //         var selectedOrders = [];
        //         $('.orderCheckbox:checked').each(function () {
        //             selectedOrders.push($(this).val());
        //         });

        //         if (selectedOrders.length === 0) {
        //             swal("Warning", "No orders selected", "warning");
        //             return;
        //         }

        //         swal({
        //             title: "Are you sure you want to delete selected orders?",
        //             text: "Once deleted, you will not be able to recover these records!",
        //             icon: "warning",
        //             buttons: true,
        //             dangerMode: true,
        //         }).then((willDelete) => {
        //             if (willDelete) {
        //                 $.ajax({
        //                     url: "<?php echo e(route('order.massDelete')); ?>",
        //                     type: "POST",
        //                     data: {
        //                         _token: "<?php echo e(csrf_token()); ?>",
        //                         order_ids: selectedOrders
        //                     },
        //                     success: function (response) {
        //                         swal("Success!", "Selected orders deleted successfully!", "success")
        //                             .then(() => location.reload());
        //                     },
        //                     error: function () {
        //                         swal("Error!", "There was an issue deleting orders", "error");
        //                     }
        //                 });
        //             }
        //         });
        //     });

        $(document).ready(function () {
            $('.table').DataTable({
                paging: false,
                ordering: false,
                searching: false
            });
        });

        $(document).ready(function () {
            $(document).on('change', '.status', function (event) {

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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1290354.cloudwaysapps.com/bhqcygtvak/public_html/resources/views/admin/orders/index.blade.php ENDPATH**/ ?>