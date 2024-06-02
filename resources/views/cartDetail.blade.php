@extends('layouts.homeLayout')

@section('title')
    <title>Giỏ Hàng</title>
@endsection
@section('this-css-library')
    <link rel="stylesheet" href="{{asset("home/theme/batosa/css/custom.css")}}">
    <link rel="stylesheet" href="{{asset("home/theme/batosa/css/custom.css")}}">
@endsection
@section('this-css')
    <style>
        /*hide number input spin buttons*/
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
        .button, .btn{
            padding: 6px 12px;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        @include('partials.contentHeader', ['breadcrumbs' => $breadcrumbs])
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="content">
            @if (Session::has('cart') && is_array(Session::get('cart')['products']) && count(Session::get('cart')['products']) > 0)
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 hidden-xs hidden-sm">
                        </div>
                        <div id="content" class="col-sm-12">
                            <h1>Giỏ Hàng </h1>
                                <div class="table">
                                    <table class="table table-bordered carttable">
                                        <thead>
                                        <tr>
                                            <td class="text-center" data-breakpoints="xs">Hình ảnh</td>
                                            <td class="text-left">Tên sản phẩm</td>
                                            <td class="text-left" data-breakpoints="xs">Dòng Sản Phẩm</td>
                                            <td class="text-left" data-breakpoints="xs">Số lượng</td>
                                            <td class="text-right" data-breakpoints="xs">Đơn Giá</td>
                                            <td class="text-right">Tổng cộng</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $cart = Session::get('cart');
                                        @endphp
                                        @foreach ($cart['products'] as $item)
                                            @php
                                                $product = $item['thisProduct'];
                                                $size = $product->sizes()->where('sizes.id', $item['size_id'])->first();
                                                $sizeName = $size->name;
                                                $feature_image_path = asset($product->feature_image_path);
                                                $productDetailRoute = route('homeProducts.displayProductDetail',['parentCategorySlug' => $product->category->parent->slug,'childCategorySlug' => $product->category->slug,'productSlug' => $product->slug]);
                                                $productName = ucwords(strtolower(($product->name)));
                                                $cartItemQuantity = $item['quantity'];
                                                $cartItemPrice =  number_format($item['price'], 0, ',', '.');
                                                $cartItemTotalPrice =  number_format($item['totalPrice'], 0, ',', '.');
                                            @endphp
                                            <tr>
                                                <td class="text-center" style="width: 12%;">
                                                    <a href="{{ $productDetailRoute }}">
                                                        <img
                                                            src="{{$feature_image_path}}" alt="{{$productName}}" title="{{$productName}}"
                                                            class="img-thumbnail"
                                                        />
                                                    </a>
                                                </td>
                                                <td class="text-left"><a
                                                        href="{{$productDetailRoute}}">{{$productName}}</a>
                                                    <br/>

                                                    <small>{{$sizeName}}</small>
                                                </td>
                                                <td class="text-left">{{$product->category->name}}
                                                </td>
                                                <td class="text-left">
                                                    <div class="input-group btn-block" style="max-width: 200px; margin: auto;">
                                                        <div class="option quantity">
                                                            <div class="input-group quantity-control">
                                                                <div class="quantity-content">
                                                                    <input id="quantity" class="form-control cartQtyInput" type="number" name="quantity" value="{{$cartItemQuantity}}" min="1" data-productidsizeid="{{$item['product_id'].'-'.$item['size_id']}}"/>
                                                                    <input type="hidden" name="product_id" value="{{$item['product_id']}}" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="input-group-btn">
													        <button
                                                                type="button" data-toggle="tooltip" title="Cập nhật"
                                                                    class="btn btn-primary updateButton"
                                                                    onclick="updateCart(this)"
                                                                    data-productid="{{$item['product_id']}}"
                                                                    data-sizeid="{{$item['size_id']}}"
                                                                data-productidsizeid="{{$item['product_id'].'-'.$item['size_id']}}">
                                                                <i class="fa fa-refresh"></i>
                                                            </button>
                                                            <button
                                                                type="button" data-toggle="tooltip"
                                                                    title="Loại bỏ"
                                                                    class="btn btn-danger removeButton"
                                                                onclick="removeFromCart(this) "
                                                                    data-productid="{{$item['product_id']}}"
                                                                    data-sizeid="{{$item['size_id']}}">
                                                                <i class="fa fa-times-circle"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="text-right">{{$cartItemPrice}} đ</td>
                                                <td class="text-right">{{$cartItemTotalPrice}} đ</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            <div class="row">
                                <div class="col-sm-4 col-sm-offset-8">
                                    <table class="table table-bordered">
                                            <td class="text-right"><strong>Tổng cộng:<br>(Tạm Tính)</strong></td>
                                            <td class="text-right">{{number_format($cart['cartTotalPrice'], 0, ',', '.')}} đ</td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                            <div class="buttons clearfix">
                                <div class="pull-left"><a href="{{route('home')}}" class="btn btn-default">Tiếp tục mua hàng</a>
                                </div>
                                <div class="pull-right"><a href="{{route('checkout')}}" class="btn btn-primary">Thanh
                                        toán</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-3 hidden-xs hidden-sm">
                    </div>
                    <div id="content" class="col-sm-12 page-404">
                        <div class="col-sm-12 text-center">
                            <h1>Giỏ Hàng</h1>
                            <p>Giỏ hàng của bạn đang trống!</p>
                            <a href="{{route('home')}}" class="btn btn-primary" title="Tiếp tục">Tiếp tục</a>
                        </div>

                    </div>
                </div>
            @endif
        </div>
@endsection
@section('this-js-library')
@endsection
@section('this-js')
    <script type="text/javascript">

        function updateCart(thisEl) {
            // alertify.success('Update button clicked');
            var $this = $(thisEl);
            var url = '{{ route('updateCartItem') }}';
            var sizeId = $this.data('sizeid')
            var productId = $this.data('productid')
            var quantity = $('input[data-productidsizeid="' + productId+'-'+sizeId + '"]').val();

            $.ajax({
                url: url,
                type: 'POST', // Change to POST method as we are sending data
                data: {
                    _token: '{{ csrf_token() }}', // Include CSRF token for security
                    sizeId: sizeId,
                    productId: productId,
                    quantity: quantity
                },
                beforeSend: function () {
                    // alertify.notify('Đang Cập Nhật Số Lượng', 'success', 5, function () {
                    //     console.log('dismissed');
                    // });
                    // $this.prop('disabled', true);
                    $this.button('loading');// better bootstrap method than                     // $this.prop('disabled', true);
                },
                complete: function () {
                    // $('#button-cart').button('reset');
                    // $this.prop('disabled', false);
                    $this.button('reset');
                },
                success: function (response) {
                    if (response.success) {
                        $("#shoppingcart-box").html(response.view); // Update the cart view with rendered HTML
                        var cartQty = $('#cartItemNumbersData').val();
                        $("#cartItemNumbers").html(cartQty)
                        // alertify.success('Đã Cập Nhật Số Lượng Sản Phẩm Thành Công'); // Show success message
                        var currentRoute = $('#currentRoute').val(); // Using hidden input
                        // alertify.success(currentRoute);
                        if (currentRoute === 'cartDisplay') {
                            location.reload(); // Reload the page if the current routeName is 'cartDisplay'
                        }
                    } else {
                        alertify.error(response.msg); // Show error message if product could not be added
                    }
                },
                error: function (xhr, status, error) {
                    alertify.error('Cập Nhật Số lượng thất bại'); // Show generic error message
                    console.error(xhr.responseText); // Log the error for debugging
                }
            });
        }

        $(document).ready(function() {
            // When the quantity input loses focus, trigger the update button click event
            $('.cartQtyInput').on('blur', function() {
                var productidsizeid = $(this).data('productidsizeid');
                var $updateButton = $('button[data-productidsizeid="' + productidsizeid + '"].updateButton');
                $updateButton.trigger('click');
            });
            $('.cartQtyInput').keypress(function(e) {
                if(e.which === 13) {  // 13 is the ASCII code for the Enter key
                    // Your code here
                    var $this = $(this);
                    $this.blur();
                    // alertify.success('You pressed Enter!');
                    e.preventDefault();  // Prevent the default action of the Enter key
                }
            });

        });

    </script>
@endsection
