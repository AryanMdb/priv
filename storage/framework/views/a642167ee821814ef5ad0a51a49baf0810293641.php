
<?php
use Illuminate\Support\Facades\File;
?>
<?php $__env->startSection('contant'); ?>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                    <h4 class="card-title">Product Edit</h4>
                </div>

                <?php if($errors->any()): ?>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error</strong> <?php echo e($message); ?>

                            <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

                <form id="editProduct" class="forms-sample" method="POST"
                    action="<?php echo e(route('product.update', $product->id)); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="row">
                        <?php
                            $profilePics = [];
                            if (!empty($product->image)) {
                                $images = json_decode($product->image, true);
                                if ($images) {
                                    foreach ($images as $image) {
                                        $imagePath = public_path('storage/product') . '/' . $image;
                                        if (File::exists($imagePath)) {
                                            $profilePics[] = asset('storage/product/' . $image);
                                        }
                                    }
                                } else {
                                    $imagePath = public_path('storage/product') . '/' . $product->image;
                                    if (File::exists($imagePath)) {
                                        $profilePics[] = asset('storage/product/' . $product->image);
                                    }
                                }
                            }

                        ?>

                        <div class="col-md-12">
                            <?php if(count($profilePics) > 0): ?>
                                <div class="form-group">
                                    <div class="img-upload">
                                        <fieldset class="form-group file-upload-link"
                                            style="display:<?php    count($profilePics) > 0 ? 'block' : 'none'  ?>">
                                            <a href="javascript:void(0)" onclick="$('#pro-image').click()">Upload Images</a>
                                            <input type="file" id="pro-image" name="image[]" style="display: none;"
                                                class="form-control file" multiple>
                                            <input type="hidden" id="image-order" name="image-order">
                                            <input type="hidden" id="image-removed" name="removed_images">
                                        </fieldset>
                                        <div class="preview-images-zone ui-sortable"
                                            style="display:<?php    count($profilePics) > 0 ? 'block' : 'none'  ?>">
                                            <?php $__currentLoopData = $profilePics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="preview-image preview-show-<?php echo e($key); ?>">
                                                    <div class="image-cancel" data-no="<?php echo e($key); ?>">x</div>
                                                    <div class="image-zone">
                                                        <img id="pro-img-<?php echo e($key); ?>" src="<?php echo e($image); ?>" alt="Image">
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>

                                    </div>
                                    <div style="display: <?php    count($profilePics) == 0 ? 'unset' : 'none' ?>">
                                        <div class="file-drop-zone w-100 bg-primary bg-opacity-10 mt-1 border-primary mb-5">
                                            <div class="mt-5 text-center h1">
                                                <div class="text-body" width="32" height="32">
                                                    <i class="icon-cloud-upload menu-icon"></i>
                                                </div>
                                            </div>
                                            <div class="mb-5 text-center">
                                                <input type="file" id="pro-image" name="image[]" style="display: none;"
                                                    class="form-control file" multiple>
                                                <a href="javascript:void(0)" onclick="$('#pro-image').click()">Upload
                                                    Images</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="img-upload  mb-5">
                                    <fieldset class="form-group file-upload-link">
                                        <a href="javascript:void(0) file-upload-link" onclick="$('#pro-image').click()">Upload
                                            Images</a>
                                        <input type="file" id="pro-image" name="image[]" style="display: none;"
                                            class="form-control file" multiple>
                                    </fieldset>
                                    <div class="preview-images-zone ui-sortable">
                                    </div>
                                </div>
                                <div class="file-drop-zone w-100 bg-primary bg-opacity-10 mt-1 border-primary mb-5">
                                    <div class="mt-5 text-center h1">
                                        <div class="mt-5 text-center h1">
                                            <div class="text-body" width="32" height="32">
                                                <i class="icon-cloud-upload menu-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-5 text-center">
                                        <input type="file" id="pro-image" name="image[]" style="display: none;"
                                            class="form-control file" multiple>
                                        <a href="javascript:void(0)" onclick="$('#pro-image').click()">Upload Images</a>

                                    </div>
                                </div>
                                <input type="hidden" id="image-order" name="image-order">
                                <input type="hidden" id="image-removed" name="removed_images">
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Select Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="" class="form-label">Select Category</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" <?php echo e($category->id == $product->category_id ? 'selected' : ''); ?>><?php echo e($category->title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Select Sub Category</label>
                                <select name="subcategory_id" id="subcategory_id" class="form-control">
                                    <option value="">Select Sub-category</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title"
                                    value="<?php if(isset($product->title)): ?> <?php echo e($product->title); ?> <?php endif; ?>">
                                <?php if($errors->has('title')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('title')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Actual Price (₹)</label>
                                <input type="text" class="form-control numeric" id="total_amount" name="total_amount"
                                    placeholder="Actual Price (₹)"
                                    value="<?php echo e($product->total_amount ?? old('total_amount')); ?>">
                                <?php if($errors->has('total_amount')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('total_amount')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Discounted Price (₹)</label>
                                <input type="text" class="form-control numeric" id="selling_price" name="selling_price"
                                    placeholder="Discounted Price (₹)"
                                    value="<?php echo e($product->selling_price ?? old('selling_price')); ?>">
                                <?php if($errors->has('selling_price')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('selling_price')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description">Product Description</label>
                                <textarea class="form-control" id="description" name="description"
                                    placeholder="Enter description here"><?php echo e($product->description ?? old('description')); ?></textarea>
                                <?php if($errors->has('description')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('description')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="title">&nbsp;</label>
                            <div class="form-group mb-3">
                                <input type="checkbox" id="out_of_stock" name="out_of_stock" value="1" <?php echo e(isset($product) && $product->out_of_stock == 1 ? 'checked' : ''); ?>>
                                <label for="name">Out of stock</label>
                            </div>
                        </div>

                        <span class="col-md-12" id="dynamicFields">
                            <?php $i = 0; ?>
                            <?php $__currentLoopData = $product_inventory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inventoryItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="dynamicRow">
                                    <div class="row mb-3">
                                        <div class="col-3">
                                            <label for="title">Quantity</label>
                                            <input type="text" class="form-control" name="inventory[<?php echo e($i); ?>][quantity]"
                                                placeholder="Quantity" value="<?php echo e($inventoryItem['quantity']); ?>">
                                        </div>
                                        <div class="col-3">
                                            <label for="title">Actual Price</label>
                                            <input type="text" class="form-control numeric" id="actual_price"
                                                name="inventory[<?php echo e($i); ?>][price]" placeholder="Actual Price (₹)"
                                                value="<?php echo e($inventoryItem['actual_price']); ?>">
                                        </div>

                                        <div class="col-3">
                                            <label for="title">Selling Price</label>
                                            <input type="text" class="form-control numeric"
                                                name="inventory[<?php echo e($i); ?>][discount_price]" id="discount_price"
                                                placeholder="Discount Price (₹)" value="<?php echo e($inventoryItem['selling_price']); ?>">
                                        </div>

                                        <div class="col-3 mt-4">
                                            <button class="btn btn-danger  deleteRow" data-key="<?php echo e($i); ?>">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </span>

                        <div class="col-md-12">
                            <button type="button" class="btn btn-dark mr-3 rowAdder">
                                <span class="bi bi-plus-square-dotted"></span> ADD
                            </button>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(window).on('load', function () {
            var cat_id = $("#category_id").val();
            var selectedSubcategoryId = <?php echo e($product->subcategory_id ?? 'null'); ?>;
            $.ajax({
                url: "<?php echo e(route('admin.getSubcategories')); ?>",
                data: { _token: '<?php echo e(csrf_token()); ?>', id: cat_id },
                type: 'GET',
                dataType: 'json',
                success: function (result) {
                    var optionHTML = '';
                    $('#subcategory_id').empty().append('<option value="">-- Please select --</option>');
                    result.forEach((element) => {
                        optionHTML = '<option value="' + element.id + '" ' + (element.id == selectedSubcategoryId ? 'selected' : '') + '>' + element.title + '</option>';
                        $('#subcategory_id').append(optionHTML);
                    });
                },
            });
        });
        $(document).ready(function () {
            $('.numeric').on('input', function () {
                $(this).val($(this).val().replace(/[^0-9]/g, ''));
            });
        });
        function numeric() {
            $(document).ready(function () {
                $('.numeric').on('input', function () {
                    $(this).val($(this).val().replace(/[^0-9]/g, ''));
                });
            });
        }
        $(document).ready(function () {
            var i = <?php echo e(isset($product_inventory) ? count($product_inventory) : 1); ?>;

            $.validator.addMethod("discountedPriceValidation", function (value, element) {
                let row = $(element).closest(".row");
                let actualPrice = parseFloat(row.find("input[name*='[price]']").val()) || 0;
                let discountPrice = parseFloat(value) || 0;
                return discountPrice <= actualPrice;
            }, "Discounted price must be less than or equal to Actual Price");

            var validator = $("form").validate();

            function applyValidation() {
                $("input[name*='[discount_price]']").each(function () {
                    $(this).rules("add", {
                        required: true,
                        number: true,
                        discountedPriceValidation: true,
                        messages: {
                            required: "Please enter Discounted Price",
                            number: "Please enter a valid number",
                            discountedPriceValidation: "Discounted price must be less than or equal to Actual Price"
                        }
                    });
                });
            }

            $("body").on("click", ".rowAdder", function () {
                var newRowAdd =
                    '<div class="dynamicRow">' +
                    '    <div class="row mb-3">' +
                    '        <div class="col-3">' +
                    '            <input type="text" class="form-control" name="inventory[' + i + '][quantity]" placeholder="Quantity" value="">' +
                    '        </div>' +
                    '        <div class="col-3">' +
                    '            <input type="text" class="form-control numeric price" name="inventory[' + i + '][price]" placeholder="Actual Price (₹)" value="">' +
                    '        </div>' +
                    '        <div class="col-3">' +
                    '            <input type="text" class="form-control numeric discount_price" name="inventory[' + i + '][discount_price]" placeholder="Discounted Price (₹)" value="">' +
                    '            <span class="error text-danger"></span>' +
                    '        </div>' +
                    '        <div class="col-3">' +
                    '            <button class="btn btn-danger deleteRow" data-key="' + i + '">' +
                    '                <i class="bi bi-trash"></i> Delete' +
                    '            </button>' +
                    '        </div>' +
                    '    </div>' +
                    '</div>';
                $('#dynamicFields').append(newRowAdd);
                i++;

                // Apply validation to the new discount_price field
                applyValidation();

                // Show delete buttons if more than one row exists
                if (i > 1) {
                    $('.deleteRow').show();
                }
            });

            $("body").on("click", ".deleteRow", function (e) {
                e.preventDefault();
                var dynamicRow = $(this).closest('.dynamicRow');
                if ($('.dynamicRow').length > 1) {
                    dynamicRow.remove();
                }
                if ($('.dynamicRow').length === 1) {
                    $('.deleteRow').hide();
                }
            });

            var selectedSubcategoryId = <?php echo e($product->subcategory_id ?? 'null'); ?>;
            $('#category_id').on('change', function () {
                var cat_id = $(this).val();
                $.ajax({
                    url: "<?php echo e(route('admin.getSubcategories')); ?>",
                    data: { _token: '<?php echo e(csrf_token()); ?>', id: cat_id },
                    type: 'GET',
                    dataType: 'json',
                    success: function (result) {
                        var optionHTML = '';
                        $('#subcategory_id').empty().append('<option value="">Select Sub-category</option>');
                        result.forEach((element) => {
                            optionHTML = '<option value="' + element.id + '"' + (element.id == selectedSubcategoryId ? 'selected' : '') + '>' + element.title + '</option>';
                            $('#subcategory_id').append(optionHTML);
                        });
                    },
                });
            });

            $.validator.addMethod("alphaOnly", function (value, element) {
                return /^[A-Za-z\s]+$/.test(value);
            }, "Please enter only alphabets");

            $.validator.addMethod("sellingPriceLessThanTotalAmount", function (value, element) {
                var totalAmount = parseFloat($("#total_amount").val());
                var sellingPrice = parseFloat(value);
                if (isNaN(sellingPrice) || value.trim() === '') {
                    return true;
                }
                if (totalAmount === 0) {
                    return sellingPrice === 0;
                }
                return sellingPrice < totalAmount;
            }, "Discounted price must be less than actual price");

            $.validator.addMethod("atLeastOneQuantityAndPrice", function (value, element, param) {
                var isValidQuantity = false;
                var isValidPrice = false;

                $('#dynamicFields .dynamicRow').each(function () {
                    var quantity = $(this).find('input[name^="inventory"][name$="[quantity]"]').val();
                    var price = $(this).find('input[name^="inventory"][name$="[discount_price]"]').val();

                    if (quantity !== "") {
                        isValidQuantity = true;
                    }
                    if (price !== "") {
                        isValidPrice = true;
                    }

                    // Break loop early if both are valid
                    if (isValidQuantity && isValidPrice) {
                        return false;
                    }
                });

                return isValidQuantity && isValidPrice;
            }, "At least one Quantity and one Price is required.");

            $('#editProduct').validate({
                highlight: function (element) {
                    $(element).closest('.form-control').addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-control').removeClass('is-invalid');
                },
                rules: {
                    image: {
                        required: function (element) {
                            return $("#old_img").val() === '';
                        }
                    },
                    title: {
                        required: true,
                        maxlength: 100,
                    },
                    category_id: {
                        required: true
                    },
                    subcategory_id: {
                        required: true
                    },
                    total_amount: {
                        required: true
                    },
                    selling_price: {
                        sellingPriceLessThanTotalAmount: true
                    },
                    'inventory[0][quantity]': {
                        atLeastOneQuantityAndPrice: true
                    },
                    'inventory[0][discount_price]': {
                        atLeastOneQuantityAndPrice: true,
                        discountedPriceValidation: true
                    }
                },
                messages: {
                    title: {
                        required: 'Please enter title',
                    },
                    image: {
                        required: "Please upload image"
                    },
                    category_id: {
                        required: "Please select category"
                    },
                    subcategory_id: {
                        required: "Please select sub category"
                    },
                    total_amount: {
                        required: "Please enter total amount"
                    },

                    'inventory[0][discount_price]': {
                        required: "Please enter Discounted Price",
                        number: "Please enter a valid number",
                        discountedPriceValidation: "Discounted price must be less than or equal to Actual Price"
                    }
                }
            });


            $(document).ready(function () {
                updateImageOrder();
                $('#pro-image').on('change', readImage);

                $(".preview-images-zone").sortable({
                    update: updateImageOrder
                });

                $(document).on('click', '.image-cancel', function () {
                    let no = $(this).data('no');
                    let imageToDelete = $(".preview-image.preview-show-" + no).find('img').attr('src').split('/').pop();
                    $(".preview-image.preview-show-" + no).remove();
                    removeImageFromOrder(imageToDelete);
                    updateImageOrder();
                    addImageToRemoved(imageToDelete);
                    togglePreviewZoneVisibility();
                });

                togglePreviewZoneVisibility();
            });

            let imageOrder = [];
            let removedImages = [];

            function updateImageOrder() {
                imageOrder = $(".preview-image img").map(function () {
                    return $(this).attr('src').split('/').pop(); // Get the file name (or path)
                }).get();
                $('#image-order').val(JSON.stringify(imageOrder));
                togglePreviewZoneVisibility(); // Check if the preview zone should be visible after order is updated
            }

            function removeImageFromOrder(image) {
                const index = imageOrder.indexOf(image);
                if (index > -1) imageOrder.splice(index, 1);
                $('#image-order').val(JSON.stringify(imageOrder));
            }

            function addImageToRemoved(image) {
                removedImages.push(image);
                $('#image-removed').val(JSON.stringify(removedImages));
            }

            function readImage(event) {
                if (window.File && window.FileList && window.FileReader) {
                    const files = event.target.files;
                    const output = $(".preview-images-zone");

                    Array.from(files).forEach((file, index) => {
                        if (!file.type.match('image')) return;

                        const picReader = new FileReader();
                        picReader.onload = function (e) {
                            // Display preview
                            const html = `
                                                                            <div class="preview-image preview-show-${index}">
                                                                                <div class="image-cancel" data-no="${index}">x</div>
                                                                                <div class="image-zone"><img id="pro-img-${index}" src="${e.target.result}"></div>
                                                                            </div>`;
                            output.append(html);
                            imageOrder.push(file.name);
                            updateImageOrder();
                        };
                        picReader.readAsDataURL(file);
                    });
                } else {
                    console.log('Browser not supported');
                }
            }

            function togglePreviewZoneVisibility() {
                const previewZone = $(".preview-images-zone");
                const imageCount = $(".preview-image").length;
                const filedropzone = $(".file-drop-zone");
                const fileuploadlink = $(".file-upload-link");

                if (imageCount > 0) {
                    previewZone.show();
                    filedropzone.hide();
                    fileuploadlink.show();
                } else {
                    previewZone.hide();
                    filedropzone.show();
                    fileuploadlink.hide();
                }
            }

            applyValidation();

        });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1290354.cloudwaysapps.com/bhqcygtvak/public_html/resources/views/admin/product/edit.blade.php ENDPATH**/ ?>