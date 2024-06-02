@if (Session::has('cart') && is_array(Session::get('cart')['products']) && count(Session::get('cart')['products']) > 0)
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
            $cartItemTotalPrice =  number_format($item['totalPrice'], 0, ',', '.');
            $cartItemQuantity = $item['quantity'];
            $cartItemPrice =  $item['price'];
        @endphp
        <li class="content-item">
            <table class="table table-striped">
                <tr>
                    <td class="text-center" style="width: 80px">
                        <a href="{{ $productDetailRoute }}">
                            <img src="{{$feature_image_path}}" alt="{{$productName}}" title="{{$productName}}"
                                 class="preview"/>
                        </a>
                    </td>
                    <td class="text-left">
                        <a class="cart_product_name" href="{{ $productDetailRoute }}">{{$productName}}</a>
                        <br/>
                        - <small>{{$sizeName}}</small>
                    </td>
                    <td class="text-center" style=" white-space: nowrap;">
                        x {{$cartItemQuantity}}
                    </td>
                    <td class="text-center" style=" white-space: nowrap;">
                        {{$cartItemTotalPrice}} đ
                    </td>

                    <td class="text-right">
                        <a onclick="removeFromCart(this)" href="javascript:void(0);" class="fa fa-trash"
                           style="padding:3px;" data-productid="{{$item['product_id']}}"
                           data-sizeid="{{$item['size_id']}}"></a>
                    </td>
                </tr>
            </table>
        </li>
    @endforeach
    <li>
        <div class="subTotalSumPrice">
            <span>Tổng cộng:</span>
            <span>{{number_format($cart['cartTotalPrice'],0, ',', '.')}} đ</span>
        </div>
    </li>
    <li>

        <div class="checkout clearfix">
            <a href="{{route('cartDisplay')}}" class="btn btn-view-cart inverse">Giỏ Hàng</a>
            <a href="{{route('checkout')}}" class="btn btn-checkout pull-right">Thanh Toán</a>
        </div>
    </li>
    <input type="hidden" id="cartItemNumbersData" name="cartItemNumbers" value="{{$cart['cartTotalQuantity']}}">
@else
    <li>
        <p class="text-center empty" style="font-weight:300;">Giỏ Hàng đang trống!</p>
    </li>
    <input type="hidden" id="cartItemNumbersData" name="cartItemNumbers" value="0">

@endif
