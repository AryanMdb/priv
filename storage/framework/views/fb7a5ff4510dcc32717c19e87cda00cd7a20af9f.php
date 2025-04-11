
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
            <div class="w-100 align-items-center justify-content-between mb-4 row mx-0">
                <div class="col-md-2 col-12">
                    <h4 class="card-title">Product TABLE</h4>
                </div>
                <div class="col-xl-7 col-md-12 col-12 w-100 d-flex justify-content-end mt-3">
                        <div class="d-flex w-100">
                            <form class="w-100 mr-1" method="GET" action="<?php echo e(route('product.index')); ?>" id="searchForm">
                                <input class="form-control" type="search" name="search" id="search"
                                    placeholder="Search Products" value="<?php echo e(request('search')); ?>">

                                <input type="hidden" name="entries" value="<?php echo e(request('entries', 10)); ?>">
                                <input type="hidden" name="category" value="<?php echo e(request('category')); ?>">
                            </form>

                            <form class="w-75 mx-1" method="GET" action="<?php echo e(route('product.index')); ?>">
                                <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                                <input type="hidden" name="category" value="<?php echo e(request('category')); ?>">

                                <select name="entries" class="form-control w-100" onchange="this.form.submit()">
                                    <option value="10" <?php echo e(request('entries', 10) == 10 ? 'selected' : ''); ?>>10</option>
                                    <option value="25" <?php echo e(request('entries') == 25 ? 'selected' : ''); ?>>25</option>
                                    <option value="50" <?php echo e(request('entries') == 50 ? 'selected' : ''); ?>>50</option>
                                    <option value="100" <?php echo e(request('entries') == 100 ? 'selected' : ''); ?>>100</option>
                                </select>
                            </form>

                            <form class="w-100 ml-1" method="GET" action="<?php echo e(route('product.index')); ?>">
                                <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                                <input type="hidden" name="entries" value="<?php echo e(request('entries', 10)); ?>">

                                <select name="category" class="form-control w-100" onchange="this.form.submit()">
                                    <option value="">All Categories</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                            <?php echo e(ucfirst($category->title)); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-12 col-12 w-100 d-flex justify-content-end mt-3">
                        <a class="bl_btn align-items-center d-flex justify-content-center mb-0 mx-3" href="<?php echo e(route('products.export')); ?>">Download Excel</a>
                        <a class="bl_btn align-items-center d-flex justify-content-center mb-0 mx-0" href="<?php echo e(route('product.create')); ?>">Add Product</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="table">
                        <thead>
                            <tr>
                                <th width="10%">S.No.</th>
                                <th width="10%">Image</th>
                                <th width="15%">Category</th>
                                <th width="15%">Subcategory</th>
                                <th width="20%">Product</th>
                                <th width="5%">Discount</th>
                                <th width="10%">Active/Inactive</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            <?php if(isset($products)): ?>
                                                <?php $i = ($products->currentPage() - 1) * $products->perPage() + 1; ?>
                                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $make): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <tr data-id="<?php echo e($make->id); ?>">

                                                                        <td><?php echo e($i++); ?><i class="fas fa-grip-vertical ml-3 text-muted table-grip-icon"></i>
                                                                        </td>
                                                                        <td class="py-1">
                                                                            <?php
                                                    $defaultImage = asset(config('constants.default_image'));
                                                    $images = json_decode($make->image, true);

                                                    if (!empty($make->image)) {
                                                        if (is_array($images) && !empty($images)) {
                                                            $link = asset('storage/product/' . $images[0]);
                                                        } elseif (!is_array($images)) {
                                                            $link = asset('storage/product/' . $make->image);
                                                        } else {
                                                            $link = $defaultImage;
                                                        }
                                                    } else {
                                                        $link = $defaultImage;
                                                    }
                                                                                                                                                                                                                                                                                                                                                                                                                    ?>
                                                                            <img src="<?php echo e($link); ?>" alt="make logo">
                                                                        </td>

                                                                        <td>
                                                                            <?php echo e(ucfirst($make->category->title)); ?>

                                                                        </td>
                                                                        <td>
                                                                            <?php echo e(ucfirst($make->subcategory->title)); ?>

                                                                        </td>
                                                                        <td>
                                                                            <?php echo e(ucfirst($make->title)); ?>

                                                                        </td>

                                                                        <td>
                                                                            <?php
                                                                                $discount = 0;
                                                                                if ($make->total_amount > 0 && $make->selling_price > 0) {
                                                                                    $discount = (($make->total_amount - $make->selling_price) / $make->total_amount) * 100;
                                                                                }
                                                                            ?>

                                                                            <?php if($discount > 0): ?>
                                                                                <span class="d-flex" style="color:#03ac51;padding:0 5px; text-transform:uppercase;">
                                                                                    <?php echo e(number_format($discount, 2)); ?>% off
                                                                                </span>
                                                                            <?php else: ?>
                                                                                <span class="d-flex text-danger" style="padding:0 5px; text-transform:uppercase;">
                                                                                    No Discount
                                                                                </span>
                                                                            <?php endif; ?>
                                                                        </td>

                                                                        <td>
                                                                            <form action="<?php echo e(route('product.status')); ?>" method="POST" style="height: 34px;">
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
                                                                            <a class="edit-btn" href="<?php echo e(route('product.edit', $make->id)); ?>"><i
                                                                                    class="icon-note"></i></a>
                                                                            <a class="show-btn" href="<?php echo e(route('product.show', $make->id)); ?>"><i
                                                                                    class="icon-eye"></i></a>
                                                                            <form class="delete-btn" action="<?php echo e(route('product.destroy', $make->id)); ?>" method="POST">
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
                    <div class="pagination-table mt-5">
                        <?php echo e($products->links()); ?>

                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
        <script type="text/javascript">

            $('.delete-btn').click(function (event) {
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
            $('.btns').click(function (event) {

            });
            $('.switch_toggle_button').click(function (e) {
                var isChecked = $(this).is(":checked");
                $(this).val(isChecked ? '1' : '0');

                var form = $(this).closest("form");
                var name = $(this).data("name");
                var statusMessage = isChecked ? 'Active' : 'Inactive';
                // event.preventDefault();
                swal({
                    title: `Are you sure you want to change this product to ${statusMessage}?`,
                    text: "If you change this, it will not be shown in app.",
                    icon: "warning",
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

            $(document).ready(function () {
                $('.table').DataTable({
                    paging: false,
                    ordering: false,
                    searching: false
                });
            });

            new Sortable(document.getElementById('sortable'), {
                animation: 150,
                forceFallback: true,  // Enables a fallback mechanism to avoid blocking scroll
                fallbackTolerance: 5, // Prevent accidental blocking of scrolling
                scroll: true,
                handle: ".table-grip-icon",
                scrollSensitivity: 100, // Adjust scrolling speed
                scrollSpeed: 10,
                paginate: false,
                onEnd: function () {
                    let order = [];

                    let currentPage = parseInt("<?php echo e(request()->get('page', 1)); ?>");
                    let perPage = parseInt("<?php echo e($products->perPage()); ?>");
                    let startIndex = (currentPage - 1) * perPage + 1;

                    $('#sortable tr').each(function (index) {
                        let id = $(this).data('id');
                        let newIndex = startIndex + index;

                        order.push({ id: id, position: newIndex });
                    });

                    $.ajax({
                        url: "<?php echo e(route('product.updateOrder')); ?>",
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
            document.getElementById('search').addEventListener('input', function() {
                clearTimeout(this.timer);
                this.timer = setTimeout(() => {
                    document.getElementById('searchForm').submit();
                }, 800); 
            });
        </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\The Mad Brains\priv\resources\views/admin/product/index.blade.php ENDPATH**/ ?>