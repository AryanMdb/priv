@extends('admin.layouts.master')
<?php
use Illuminate\Support\Facades\File;
?>
@section('contant')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                    <h4 class="card-title">Product Edit</h4>
                </div>

                @if ($errors->any())
                    @foreach ($errors->all() as $message)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error</strong> {{ $message }}
                            <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        </div>
                    @endforeach
                @endif

                <form id="editProduct" class="forms-sample" method="POST"
                    action="{{ route('product.update', $product->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        @php
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

                        @endphp

                        <div class="col-md-12">
                            @if(count($profilePics) > 0)
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
                                            @foreach($profilePics as $key => $image)
                                                <div class="preview-image preview-show-{{ $key }}">
                                                    <div class="image-cancel" data-no="{{ $key }}">x</div>
                                                    <div class="image-zone">
                                                        <img id="pro-img-{{ $key }}" src="{{ $image }}" alt="Image">
                                                    </div>
                                                </div>
                                            @endforeach
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
                            @else
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
                            @endif
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Select Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="" class="form-label">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->title }}</option>
                                    @endforeach
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
                                    value="@if (isset($product->title)) {{ $product->title }} @endif">
                                @if ($errors->has('title'))
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Actual Price (₹)</label>
                                <input type="text" class="form-control numeric" id="total_amount" name="total_amount"
                                    placeholder="Actual Price (₹)"
                                    value="{{ $product->total_amount ?? old('total_amount') }}">
                                @if ($errors->has('total_amount'))
                                    <span class="text-danger">{{ $errors->first('total_amount') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Discounted Price (₹)</label>
                                <input type="text" class="form-control numeric" id="selling_price" name="selling_price"
                                    placeholder="Discounted Price (₹)"
                                    value="{{ $product->selling_price ?? old('selling_price') }}">
                                @if ($errors->has('selling_price'))
                                    <span class="text-danger">{{ $errors->first('selling_price') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description">Product Description</label>
                                <textarea class="form-control" id="description" name="description"
                                    placeholder="Enter description here">{{ $product->description ?? old('description') }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="text-danger">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="title">&nbsp;</label>
                            <div class="form-group mb-3">
                                <input type="checkbox" id="out_of_stock" name="out_of_stock" value="1" {{ isset($product) && $product->out_of_stock == 1 ? 'checked' : '' }}>
                                <label for="name">Out of stock</label>
                            </div>
                        </div>

                        <span class="col-md-12" id="dynamicFields">
                            @php $i = 0; @endphp
                            @foreach($product_inventory as $inventoryItem)
                                <div class="dynamicRow">
                                    <div class="row mb-3">
                                        <div class="col-3">
                                            <label for="title">Quantity</label>
                                            <input type="text" class="form-control" name="inventory[{{ $i }}][quantity]"
                                                placeholder="Quantity" value="{{ $inventoryItem['quantity'] }}">
                                        </div>
                                        <div class="col-3">
                                            <label for="title">Actual Price</label>
                                            <input type="text" class="form-control numeric" id="actual_price"
                                                name="inventory[{{ $i }}][price]" placeholder="Actual Price (₹)"
                                                value="{{ $inventoryItem['actual_price'] }}">
                                        </div>

                                        <div class="col-3">
                                            <label for="title">Selling Price</label>
                                            <input type="text" class="form-control numeric"
                                                name="inventory[{{ $i }}][discount_price]" id="discount_price"
                                                placeholder="Discount Price (₹)" value="{{ $inventoryItem['selling_price'] }}">
                                        </div>

                                        <div class="col-3 mt-4">
                                            <button class="btn btn-danger  deleteRow" data-key="{{ $i }}">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @php $i++; @endphp
                            @endforeach
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
            var selectedSubcategoryId = {{ $product->subcategory_id ?? 'null' }};
            $.ajax({
                url: "{{ route('admin.getSubcategories') }}",
                data: { _token: '{{ csrf_token() }}', id: cat_id },
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
            var i = {{ isset($product_inventory) ? count($product_inventory) : 1 }};

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

            var selectedSubcategoryId = {{ $product->subcategory_id ?? 'null' }};
            $('#category_id').on('change', function () {
                var cat_id = $(this).val();
                $.ajax({
                    url: "{{ route('admin.getSubcategories') }}",
                    data: { _token: '{{ csrf_token() }}', id: cat_id },
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

@endsection