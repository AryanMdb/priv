@extends('admin.layouts.master')
<?php
use Illuminate\Support\Facades\Session;
?>
@section('contant')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">

            <div class="w-100 align-items-center justify-content-between mb-4 d-flex">
                <h4 class="card-title">New Product Create</h4>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success</strong> {{ $message }}
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
            @endif
            @if ($errors->any())
                @foreach ($errors->all() as $message)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error</strong> {{ $message }}
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    </div>
                @endforeach
            @endif

            <form id="addProduct" class="forms-sample" method="POST" action="{{ route('product.store') }}"
                enctype="multipart/form-data">
                @csrf
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
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
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
                                value="{{ old('title') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Actual Price (₹)</label>
                            <input type="text" class="form-control numeric" id="total_amount" name="total_amount"
                                placeholder="Actual Price (₹)" value="{{ old('total_amount') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Discounted Price (₹)</label>
                            <input type="text" class="form-control numeric" id="selling_price" name="selling_price"
                                placeholder="Discounted Price (₹)" value="{{ old('selling_price') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description">Product Description</label>
                            <textarea class="form-control" id="description" name="description"
                                placeholder="Enter description here">{{ old('description') }}</textarea>
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
                                <label for="title">Quantity & Price</label>
                                <div class="row">
                                    <div class="col-5">
                                        <input type="text" class="form-control" name="inventory[0][quantity]"
                                            placeholder="Quantity" value="">
                                    </div>
                                    <div class="col-5">
                                        <input type="text" class="form-control numeric" name="inventory[0][price]"
                                            placeholder="Price (₹)" value="">
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
        var i = 1;
        $("body").on("click", ".rowAdder", function () {
            var newRowAdd =
                '<div class="dynamicRow row mb-3">' +
                '<div class="col-md-12">' +
                '<div class="row">' +
                '<div class="col-5">' +
                '<input type="text" class="form-control" name="inventory[' + i + '][quantity]" placeholder="Quantity" value="">' +
                '</div>' +
                '<div class="col-5">' +
                '<input type="text" class="form-control numeric" name="inventory[' + i + '][price]" placeholder="Price (₹)" value="">' +
                '</div>' +
                '<div class="col-2">' +
                '<button class="btn btn-danger deleteRow" data-key="' + i + '">' +
                '<i class="bi bi-trash"></i> Delete' +
                '</button>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';

            $('#dynamicFields').append(newRowAdd);
            i++;
            numeric();
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
                selling_price: {
                    // required: true,
                    sellingPriceLessThanTotalAmount: true
                },
                'inventory[0][quantity]': {
                    atLeastOneQuantityAndPrice: true
                },
                'inventory[0][price]': {
                    atLeastOneQuantityAndPrice: true
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
                // selling_price: {
                //     required: "Please enter selling price"
                // },
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
                url: "{{ route('admin.getSubcategories') }}",
                data: { _token: '{{ csrf_token() }}', id: cat_id },
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
@endsection