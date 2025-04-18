
<?php
use Illuminate\Support\Facades\Session;
?>
<?php $__env->startSection('contant'); ?>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                    <h4 class="card-title">New Product Create</h4>
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

                <form id="addProduct" class="forms-sample" method="POST" action="<?php echo e(route('product.store')); ?>"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-5">
                                <div class="img-upload">
                                    <fieldset class="form-group">
                                        <a href="javascript:void(0)" onclick="$('#pro-image').click()">Upload Image</a>
                                        <input type="file" id="pro-image" name="image[]" style="display: none;"
                                            class="form-control file" multiple accept="image/jpeg,image/png,image/jpg">
                                    </fieldset>
                                    <div class="preview-images-zone">
                                        <div class="preview-image preview-show-0">
                                        </div>
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
                                        <input type="hidden" id="image-order" name="image-order">
                                        <input type="hidden" id="image-removed" name="removed_images">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Select Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="" class="form-label">Select Category</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->title); ?></option>
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
                                    value="<?php echo e(old('title')); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Actual Price (₹)</label>
                                <input type="text" class="form-control numeric" id="total_amount" name="total_amount"
                                    placeholder="Actual Price (₹)" value="<?php echo e(old('total_amount')); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Discounted Price (₹)</label>
                                <input type="text" class="form-control numeric" id="selling_price" name="selling_price"
                                    placeholder="Discounted Price (₹)" value="<?php echo e(old('selling_price')); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description">Product Description</label>
                                <textarea class="form-control" id="description" name="description"
                                    placeholder="Enter description here"><?php echo e(old('description')); ?></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="d-none d-md-block pb-2" for="title">&nbsp;</label>
                            <div class="form-group">
                                <input type="checkbox" id="out_of_stock" name="out_of_stock" value="1">
                                <label for="name">Out of stock</label>
                            </div>
                        </div>

                        <span class="col-md-12" id="dynamicFields">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="title">Quantity</label>
                                            <input type="text" class="form-control" name="inventory[0][quantity]"
                                                placeholder="Quantity" value="">
                                        </div>

                                        <div class="col-3">
                                            <label for="title">Actual Price</label>
                                            <input type="text" class="form-control numeric" name="inventory[0][price]"
                                                placeholder="Actual Price" id="actual_price" value="">
                                        </div>

                                        <div class="col-3">
                                            <label for="title">Discount Price</label>
                                            <input type="text" class="form-control numeric"
                                                name="inventory[0][discount_price]" placeholder="Discounted Price (₹)"
                                                id="discount_price" value="">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </span>

                        <div class="col-md-12">
                            <button type="button" class="btn btn-dark mr-3 rowAdder">
                                <span class="bi bi-plus-square-dotted"></span> ADD Qty & Price Row
                            </button>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            var i = 1; // Start index for dynamic fields

            // Custom validation method for discount price
            $.validator.addMethod("discountedPriceValidation", function (value, element) {
                let row = $(element).closest(".row");
                let actualPrice = parseFloat(row.find("input[name^='inventory'][name$='[price]']").val()) || 0;
                let discountPrice = parseFloat(value) || 0;
                return discountPrice <= actualPrice;
            }, "Discounted price must be less than or equal to Actual Price");

            // Function to add a new row dynamically
            $("body").on("click", ".rowAdder", function () {
                var newRowAdd =
                    '<div class="dynamicRow row mb-3">' +
                    '<div class="col-md-12">' +
                    '<div class="row">' +
                    '<div class="col-3">' +
                    '<label for="inventory[' + i + '][quantity]">Quantity</label>' +
                    '<input type="text" class="form-control" name="inventory[' + i + '][quantity]" placeholder="Quantity" required>' +
                    '</div>' +
                    '<div class="col-3">' +
                    '<label for="inventory[' + i + '][price]">Actual Price</label>' +
                    '<input type="text" class="form-control numeric actual_price" name="inventory[' + i + '][price]" placeholder="Actual Price (₹)" required>' +
                    '</div>' +
                    '<div class="col-3">' +
                    '<label for="inventory[' + i + '][discount_price]">Discount Price</label>' +
                    '<input type="text" class="form-control numeric discount_price mb-2" name="inventory[' + i + '][discount_price]" placeholder="Discounted Price (₹)" required>' +
                    '</div>' +
                    '<div class="col-3 mt-4">' +
                    '<button type="button" class="btn btn-danger deleteRow" data-key="' + i + '">' +
                    '<i class="bi bi-trash"></i> Delete' +
                    '</button>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                $('#dynamicFields').append(newRowAdd);

                // Add validation rules for the new fields
                $('input[name="inventory[' + i + '][quantity]"]').rules("add", {
                    required: true,
                    messages: {
                        required: "Please enter quantity",
                    }
                });
                $('input[name="inventory[' + i + '][price]"]').rules("add", {
                    required: true,
                    number: true,
                    messages: {
                        required: "Please enter Actual Price",
                        number: "Please enter a valid number"
                    }
                });
                $('input[name="inventory[' + i + '][discount_price]"]').rules("add", {
                    required: true,
                    number: true,
                    discountedPriceValidation: true,
                    messages: {
                        required: "Please enter Discounted Price",
                        number: "Please enter a valid number",
                    }
                });

                i++;
            });

            // Validate discount price dynamically
            $("body").on("input", ".discount_price", function () {
                let row = $(this).closest(".row");
                let actualPrice = parseFloat(row.find("input[name^='inventory'][name$='[price]']").val()) || 0;
                let discountPrice = parseFloat($(this).val()) || 0;

                if (discountPrice > actualPrice) {
                    $(this).next(".error").text("Discounted price must be less than or equal to Actual Price");
                } else {
                    $(this).next(".error").text("");
                }
            });


            $("body").on("click", ".deleteRow", function () {
                $(this).closest('.dynamicRow').remove();
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

                $('#dynamicFields .row').each(function () {
                    var quantity = $(this).find('input[name^="inventory"][name$="[quantity]"]').val();
                    var price = $(this).find('input[name^="inventory"][name$="[price]"]').val();
                    if (quantity !== "") {
                        isValidQuantity = true;
                    }
                    if (price !== "") {
                        isValidPrice = true;
                    }

                    if (isValidQuantity && isValidPrice) {
                        return false;
                    }
                });

                return isValidQuantity && isValidPrice;
            }, "");


            $('#addProduct').validate({
                highlight: function (element) {
                    $(element).closest('.form-control').addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-control').removeClass('is-invalid');
                },
                rules: {
                    'image[]': {
                        required: function () {
                            return $("input[name='image[]']").length == 0;
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
                    'inventory[0][quantity]': {
                        required: true,
                    },
                    'inventory[0][price]': {
                        required: true,
                        number: true,
                    },
                    'inventory[0][discount_price]': {
                        required: true,
                        number: true,
                        discountedPriceValidation: true
                    }
                },
                messages: {
                    title: {
                        required: 'Please enter title',
                    },
                    'image[]': {
                        required: "Please upload at least one image"
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
                    'inventory[0][quantity]': {
                        required: "Please enter quantity",
                    },

                    'inventory[0][price]': {
                        required: "Please enter Actual Price",
                        number: "Please enter a valid number"
                    },
                    'inventory[0][discount_price]': {
                        required: "Please enter Discounted Price",
                        number: "Please enter a valid number",
                        discountedPriceValidation: "Discounted price must be less than or equal to Actual Price."
                    }
                }
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
                            optionHTML = '<option value="' + element.id + '">' + element.title + '</option>';
                            $('#subcategory_id').append(optionHTML);
                        });
                    },
                });
            });
        });
        // ///////////////////////////////// Multiple image ////////////////////

        $(document).ready(function () {
            document.getElementById('pro-image').addEventListener('change', readImage, false);
            $(".preview-images-zone").sortable();
            $(document).on('click', '.image-cancel', function () {
                let no = $(this).data('no');
                $(".preview-image.preview-show-" + no).remove();
                togglePreviewZoneVisibility(); // Recalculate visibility when an image is removed
            });
            togglePreviewZoneVisibility(); // Initial check
        });

        var num = 1;
        function readImage(event) {
            if (window.File && window.FileList && window.FileReader) {
                var files = event.target.files;
                var output = $(".preview-images-zone");

                for (let i = 0; i < files.length; i++) {
                    var file = files[i];
                    if (!file.type.match('image')) continue;

                    var picReader = new FileReader();

                    picReader.addEventListener('load', function (event) {
                        var picFile = event.target;
                        var html =
                            '<div class="preview-image preview-show-' + num + '">' +
                            '<div class="image-cancel" data-no="' + num + '">x</div>' +
                            '<div class="image-zone"><img id="pro-img-' + num + '" src="' + picFile.result + '"></div>' +
                            '</div>';

                        output.append(html);
                        num++;
                        togglePreviewZoneVisibility(); // Recalculate visibility after adding an image
                    });

                    picReader.readAsDataURL(file);
                }
            } else {
                console.log('Browser not supported');
            }
        }

        function togglePreviewZoneVisibility() {
            const previewZone = $(".img-upload");
            const imageCount = $(".preview-image").length;
            const filedropzone = $(".file-drop-zone");

            if (imageCount > 1) {
                previewZone.show();
                filedropzone.hide();
            } else {
                previewZone.hide();
                filedropzone.show();
            }
        }

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\The Mad Brains\messho\resources\views/admin/product/create.blade.php ENDPATH**/ ?>