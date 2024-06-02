@extends('admin.layouts.admin')

@section('title')
    <title>Add a New Product</title>
@endsection
@section('this-css')
    <link rel="stylesheet" href="{{asset('admins/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/css/dropzone.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/css/summernote-bs4.css')}}">
    <style>
        .select2 {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--multiple {
            height: auto;
            margin-left: 0 !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
            padding-left: 7px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            margin-left: 0;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            padding-inline: 7px;
        }

        .select2-selection__choice {
            background-color: #3b3b3b !important;
        }

        #feature_image, #product_images {
            height: auto;
            padding: unset;
            min-width: 100%;
            width: auto;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header',['name' => 'Products', 'key' => 'Add','url' => route('products')])
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="div col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h1 class="card-title">Add a New Product</h1><br>
                                <form action='{{route('products.store')}}' method="POST" enctype="multipart/form-data" accept-charset="UTF-8">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="productName">Product Name</label>
                                                <input type="text"
                                                       class="form-control @error('name') is-invalid @enderror"
                                                       id="productName" aria-describedby="productName"
                                                       placeholder="Converse Old Skool" name="name"
                                                       value="{{old('name')}}" required max="255">
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="salePrice">Sale Price</label>
                                                <input type="number"
                                                       class="form-control @error('sale_price') is-invalid @enderror"
                                                       id="salePrice" aria-describedby="menuName"
                                                       placeholder="800000" name="sale_price" min="0"
                                                       value="{{old('sale_price')}}" required>
                                                @error('sale_price')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="price">Price</label>
                                                <input type="number"
                                                       class="form-control @error('price') is-invalid @enderror"
                                                       id="price" aria-describedby="Price"
                                                       placeholder="1000000" name="price" min="0"
                                                       value="{{old('price')}}" required>
                                                @error('price')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="intro">Intro</label>
                                                <textarea class="form-control @error('intro') is-invalid @enderror"
                                                          id="intro"
                                                          rows="5" name="intro" value="{{old('intro')}}"></textarea>
                                                @error('intro')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="material">Material</label>
                                                <input type="text"
                                                       class="form-control @error('material') is-invalid @enderror"
                                                       id="material" aria-describedby="material"
                                                       placeholder="Silk, Canvas" name="material"
                                                       value="{{old('material')}}">
                                                @error('material')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="selectCat">Select Category</label><br>
                                                <select
                                                    class="categories_select2 form-control @error('category') is-invalid @enderror"
                                                    multiple="multiple"
                                                    id="selectCat" name="category_id" value="{{old('category_id')}}">
                                                    @foreach($categories as $category)
                                                        <option
                                                            value="{{ $category->id }}" {{ $category->parent_id == 0 ? 'disabled' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('category')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="color">Color</label>
                                                <input type="text"
                                                       class="form-control @error('color') is-invalid @enderror"
                                                       id="color" aria-describedby="color"
                                                       placeholder="Red, Brown" name="color" value="{{old('color')}}">
                                                @error('color')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="selectBrand">Select Brand</label><br>
                                                <select
                                                    class="brands_select2 form-control @error('brand') is-invalid @enderror"
                                                    multiple="multiple" id="selectBrand"
                                                    name="brand_id" value="{{old('brand')}}">
                                                    @foreach($brands as $brand)
                                                        <option value="{{$brand->id}}">{{$brand->name}} </option>
                                                    @endforeach
                                                </select>
                                                @error('brand')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="selectSizes">Select Sizes Then Quantity</label><br>
                                                <select class="sizes_select2 form-control" multiple="multiple"
                                                        id="selectSizes" name="sizes[]" value="{{old('sizes[]')}}">
                                                    @foreach($sizes as $size)
                                                        <option value="{{$size->id}}">{{$size->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row" id="quantityFields">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="selectTags">Select Tags</label><br>
                                                <select class="tags_select2 form-control" multiple="multiple"
                                                        id="selectTags" name="tags[]" value="{{old('tags[]')}}">
                                                    @foreach($tags as $tag)
                                                        <option value="{{$tag->name}}">{{$tag->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <label for="feature_image">Feature Image/ thumbnail</label>
                                                        <input type="file"
                                                               class="form-control @error('feature_image') is-invalid @enderror"
                                                               id="feature_image" name="feature_image"
                                                        >
                                                        @error('feature_image')
                                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <label for="product_images">Desc Images</label>
                                                        <input type="file"
                                                               class="form-control @error('product_images') is-invalid @enderror"
                                                               id="product_images" name="product_images[]" multiple>
                                                        @error('feature_image')
                                                        <span class="product_images" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="col-xl-8">
                                            <label for="summernote">Product Description Content</label>
                                            <textarea id="summernote" name="description" rows="7"
                                                      value="{{old('content')}}"></textarea>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div
@endsection
@section('this-js')
    <script src="{{asset('admins/js/select2.min.js')}}"></script>
    <script src="{{asset('admins/js/dropzone.min.js')}}"></script>
    <script src="{{asset('admins/js/summernote-bs4.js')}}"></script>

    <script>
        $(document).ready(function () {
            console.log('hello');
            $('.categories_select2').select2({
                tags: false, // Disable creating new tags
                tokenSeparators: [','],
                maximumSelectionLength: 1,
                placeholder: 'Chọn Danh Mục',
                // allowClear: true
            });

            $('.brands_select2').select2({
                tags: false, // Disable creating new tags
                tokenSeparators: [','],
                maximumSelectionLength: 1,
                placeholder: 'Chọn Brand',
                // allowClear: true
            });
            $('.sizes_select2').select2({
                tags: false, // Disable creating new tags
                tokenSeparators: [','],
                placeholder: 'Chọn Sizes',
                allowClear: true
            });
            $('.tags_select2').select2({
                tags: true,
                tokenSeparators: [','],
                placeholder: 'Chọn Tags',
                allowClear: true
            });

            (function () {
                const existingInputFields = {};
                $('#selectSizes')
                    .on('select2:select', function (e) {
                        const sizeName = $(e.params.data.element).text();
                        const selectedSizeIds = $(this).val() || [];
                        console.log(selectedSizeIds)
                        // return;
                        selectedSizeIds.forEach(sizeId => {
                            if (!existingInputFields[sizeId]) {
                                createQuantityInputField(sizeId, sizeName, null); // Create input field if it doesn't exist
                            }
                        });
                    })
                    .on('select2:unselect', function (e) {
                        const selectedSizeIds = $(this).val() || [];
                        Object.keys(existingInputFields).forEach(sizeId => {
                            if (!selectedSizeIds.includes(sizeId)) {
                                removeQuantityInputField(sizeId); // Remove input field if size is deselected
                            }
                        });
                    });

                function removeQuantityInputField(sizeId) {
                    if (existingInputFields[sizeId]) {
                        existingInputFields[sizeId].remove(); // Remove input field from DOM
                        delete existingInputFields[sizeId]; // Remove input field from collection
                    }
                }

                function createQuantityInputField(sizeId, sizeName, productId) {
                    let quantity = 0;
                    // AJAX request to fetch quantity for the size from the server
                    if (productId) {
                        $.ajax({
                            url: '{{ route("products.fetch-quantity") }}', // Use Laravel route helper to generate URL
                            method: 'GET',
                            data: {
                                sizeId: sizeId,
                                productId: productId
                            },
                            success: function (data) {
                                quantity = data.quantity || 0; // If quantity is not available, default to 0
                            },
                            error: function (xhr, status, error) {
                                console.error('Error fetching quantity data:', error);
                            }
                        });
                    }

                    const wrapperDiv = document.createElement('div');
                    wrapperDiv.className = 'col-sm-3';

                    // Create quantity input field
                    const quantityInputField = document.createElement('input');
                    quantityInputField.type = 'number';
                    quantityInputField.placeholder = sizeName;
                    quantityInputField.className = 'form-control mb-3';
                    quantityInputField.min = 0; // Minimum quantity constraint
                    quantityInputField.setAttribute('data-sizeId', sizeId); // Store the size as data attribute
                    quantityInputField.name = `qtyInput${sizeId}`; // Assign unique name attribute based on size
                    quantityInputField.value = quantity; // Set the quantity value
                    quantityInputField.id = sizeId; // Set the quantity value

                    // Create size label
                    const sizeLabel = document.createElement('label');
                    sizeLabel.innerText = sizeName;
                    sizeLabel.htmlFor = sizeId;
                    // Append quantity input field and size label to wrapper div
                    wrapperDiv.appendChild(sizeLabel);
                    wrapperDiv.appendChild(quantityInputField);

                    // Append wrapper div to the container
                    document.getElementById('quantityFields').appendChild(wrapperDiv);

                    // Store the input field in the collection
                    existingInputFields[sizeId] = wrapperDiv;
                }
            })();

        });

        document.addEventListener("DOMContentLoaded", function () {
            $('#summernote').summernote(
                {
                    placeholder: 'Enter content....',
                    tabsize: 2,
                    minHeight: 100,
                    focus: true,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript', 'fontname']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']],
                    ],
                    popover: {
                        image: [
                            ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                            ['float', ['floatLeft', 'floatRight', 'floatNone']],
                            ['remove', ['removeMedia']]
                        ],
                        link: [
                            ['link', ['linkDialogShow', 'unlink']]
                        ],
                        table: [
                            ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                            ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
                        ],
                        air: [
                            ['color', ['color']],
                            ['font', ['bold', 'underline', 'clear']],
                            ['para', ['ul', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link', 'picture']]
                        ]
                    },
                    codemirror: {
                        theme: 'monokai'
                    }
                }
            );
        });
    </script>
@endsection





