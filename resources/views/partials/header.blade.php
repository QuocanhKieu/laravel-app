<header id="header" class="">
    <div class="header-top compact-hidden">
        <div class="container">
            <div class="row">
                <div class="col-md-6 hidden-sm hidden-xs header-top-left"></div>
                <div class="col-md-6 col-sm-12 header-top-right">
                    <ul class="list-inline pull-right">
                        <li class="navbar-phone">Hotline: <a href="tel:0961056732 ">0961056732 </a></li>
                        <li><i class="fa fa-building"></i> <a href="#">Cửa hàng</a>
                        </li>
                        <li><a href=""><i class="fa fa-lock"></i> Đăng Ký</a></li>
                        <li><a href=""><i class="fa fa-user"></i> Đăng Nhập</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="header-center compact-hidden">
        <div class="container">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="logo"><a href="#"><img
                                src="{{asset("home/image/catalog/drake_logo.png")}}"
                                title="Drake Vietnam " alt="Drake Vietnam "/></a>
                    </div>
                </div>
                <div class="col-sm-3 text-right">
                    <a href="#" id="wishlist-total" title="Danh sách Yêu thích"><i class="fa fa-heart"></i></a>
                    <div id="cart" class="btn-shopping-cart">
                        <a data-loading-text="Đang Xử lý..."
                           class="btn-group  dropdown-toggle"
                           data-toggle="dropdown">
                            <div class="shopcart">
                                <span class="handle pull-left">
                                </span>
                                <span class="text-shopping-cart cart-total-full" id="cartItemNumbers">
                                    @if (Session::has('cart') && is_array(Session::get('cart')['products']) && count(Session::get('cart')['products']) > 0)
                                        @php
                                            $cart = Session::get('cart');
                                        @endphp
                                        {{$cart['cartTotalQuantity']}}
                                    @else
                                        0
                                    @endif
                                </span>
                            </div>
                        </a>
                        <ul class="dropdown-menu pull-right shoppingcart-box" id="shoppingcart-box">
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

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="notify-top">
            <div class="container">
                <div class="popup-box">
                    <div id="popup0" class="owl-carousel" style="opacity: 1;">
                        <div class="item"> Miễn phí vận chuyển toàn quốc</div>
                        <div class="item"> Đăng ký hoặc gọi 0961056732 để cập nhật chương trình khuyến mãi</div>
                        <div class="item"> Email hỗ trợ: 0961056732@sale.vn</div>
                        <div class="item"> Follow shop để nhân hàng ngàn ưu đãi</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="top-nav">
                        <div class="responsive megamenu-style-dev ">
                            <nav class="navbar-default">
                                <div class=" container-megamenu  horizontal">
                                    <div class="navbar-header">
                                        <button type="button" id="show-megamenu" data-toggle="collapse"
                                                class="navbar-toggle">
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                    </div>

                                    <div class="megamenu-wrapper">

                                        <span id="remove-megamenu" class="fa fa-times"></span>

                                        <div class="megamenu-pattern">
                                            <div class="container">
                                                <ul class="megamenu" data-transition="slide"
                                                    data-animationtime="250">

                                                    {{--                                                    <li class="home">--}}
                                                    {{--                                                        <a href="//drake.vn">--}}
                                                    {{--                                                            <i class="fa fa-home"></i> </a>--}}
                                                    {{--                                                    </li>--}}
                                                    @foreach($parentCategories as $parentCategory )
                                                        <li class=' with-sub-menu hover'>
                                                            <p class='close-menu'></p>
                                                            <a href="{{ route('homeProducts.listByParentCategory', $parentCategory->slug) }}"
                                                               class='clearfix'>
                                                                <strong>
                                                                    {{$parentCategory->name}}
                                                                </strong>
                                                                <b class='caret'></b>
                                                            </a>
                                                            <div class="sub-menu" style="width:100%">
                                                                <div class="content">
                                                                    <div class="row">
                                                                        <div class="col-sm-2">
                                                                            <div class="html ">
                                                                                <p>
                                                                                    <a href="{{ route('homeProducts.listByParentCategory', $parentCategory->slug)}}">
                                                                                        <img alt=""
                                                                                             src="{{asset($parentCategory->logo_path)}}" style="padding-right: 10px;"/>
                                                                                        All {{$parentCategory->name}}
                                                                                    </a>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-10">
                                                                            <div class="categories ">
                                                                                @php
                                                                                    $childrenCategories = $parentCategory->children;
                                                                                      $childrenCount = $childrenCategories->count();
                                                                                      $loopNum = ceil($childrenCount/6);
                                                                                      $childrenIndex = 0;
                                                                                      $columnNumber = 6;
                                                                                @endphp
                                                                                @for ($j = 0; $j < $loopNum; $j++)
                                                                                    <div class="row">
                                                                                        @for ($y = 0; $y < $columnNumber; $y++,$childrenIndex++)
                                                                                            {{--                                                                                <li>{{ $children[$j]->name }}</li>--}}
                                                                                            <div
                                                                                                class="col-sm-2 hover-menu">
                                                                                                @if ($childrenIndex <= ($childrenCount - 1))
                                                                                                    <div class="menu">
                                                                                                        <ul>
                                                                                                            <li>
                                                                                                                <a href="{{ route('homeProducts.listByChildCategory', ['parentCategorySlug' => $parentCategory->slug, 'childCategorySlug' => $childrenCategories[$childrenIndex]->slug]) }}"
                                                                                                                   class="main-menu">
                                                                                                                    <img src="{{asset($childrenCategories[$childrenIndex]->logo_path)}}" alt=""/>
                                                                                                                    {{--onclick="window.location = '//drake.vn/converse/classic';"--}}
                                                                                                                </a>
                                                                                                                <a href="{{ route('homeProducts.listByChildCategory', ['parentCategorySlug' => $parentCategory->slug, 'childCategorySlug' => $childrenCategories[$childrenIndex]->slug]) }}"
                                                                                                                    class="main-menu">{{$childrenCategories[$childrenIndex]->name}}
                                                                                                                </a>
                                                                                                            </li>
                                                                                                        </ul>
                                                                                                    </div>
                                                                                                @else
                                                                                                    <div
                                                                                                        class="menu"></div>
                                                                                                @endif
                                                                                            </div>
                                                                                        @endfor
                                                                                    </div>
                                                                                @endfor
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                    <div id="search" class="input-group sb-search">
                        <form action="{{ route('search') }}" method="GET" class="search-content">
                            <input name="search_term" class="sb-search-input" placeholder="Tìm kiếm"
                                                           type="search" value="{{ request('search_term', $searchTerm??'') }}"/>
                            <button type="submit" class="btn btn-default"><i
                                    class="fa fa-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

