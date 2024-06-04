@extends('layouts.homeLayout')

@section('title')
    <title>{{ucwords(strtolower(($product->name)))}}</title>
@endsection
@section('this-css-library')
@endsection
@section('this-css')

    <style>
        .description-box .read-more.whide {
            display: none;
        }

        .description-box.wbc-height .read-more.whide {
            display: block;
        }

        .description-box.wbd-height .read-more.whide {
            display: flex;
        }

        .description-box.wbc-height .read-less-button {
            display: none;
        }

        .description-box.wbc-height .read-more-button {
            display: inline-block;
        }

        .description-box.wbd-height .read-more-button {
            display: none;
        }

        .description-box.wbd-height .read-less-button {
            display: inline-block;
        }

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

        .breadcrumb li a {
            font-size: 14px !important;
            font-weight: bold;
        }

        #related-box {
            padding-block: 30px;
            background-color: rgba(243, 243, 243, 1);
        }

        .zoomContainer {
            display: none;
        }

        @media screen and (min-width: 768px) {
            .zoomContainer {
                display: block
            }

            #size-alert {
                display: none;
            }

            #size-alert.show {
                display: block;
            }
        }

        /*rating shoppe section*/
        .product-ratings {
            background: #fff;
            border-radius: .125rem;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .05);
            margin-top: .9375rem;
            overflow: hidden;
            overflow: visible;
            padding: 1.5625rem;
        }

        .product-ratings__header {
            align-items: center;
            display: flex;
            flex-flow: row nowrap;
            margin-bottom: 1em;
        }

        .product-ratings__header_score {
            font-size: 20px;
        }

        .review-avatar__img {
            border-radius: 50%;
        }

        .review-product-rating {
            align-items: flex-start;
            border-bottom: 1px solid rgba(0, 0, 0, .09);
            display: flex;
            padding: 1rem 0 1rem 1.25rem;
        }

        .review-product-rating:first-child {
            padding-top: 0;
        }

        .review-product-rating__avatar {
            margin-right: .625rem;
            text-align: center;
            width: 5rem;
        }

        .review-product-rating__main {
            flex: 1;
        }

        .review-product-rating__author-name {
            color: rgba(0, 0, 0, .87);
            font-size: 1.55rem;
            -webkit-text-decoration: none;
            text-decoration: none;
        }

        .review-product-rating__main .repeat-purchase-con {
            display: flex;
        }

        .review-product-rating__time {
            color: rgba(0, 0, 0, .54);
            font-size: 1.45rem;
            margin-bottom: .9375rem;
            margin-top: .25rem;
        }

        .TQTPT9 {
            background-color: #f5f5f5;
            margin-bottom: .75rem;
            padding: .875rem .75rem;
            position: relative;
        }
        /*review pagination */
        .review-page-controller{
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .review-page-controller .page-link {
            margin: 0 5px;

            padding: 5px 14px;
            font-size: 1.1em;
            cursor: pointer;
            border: 1px solid #ccc;
            border-radius: 3px;
            border-color: transparent;
            color: #7b7b7b;
        }

        .review-page-controller .page-link.active {
            background-color: #fe5454;
            color: #fff;

        }

    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        @include('partials.contentHeader', ['breadcrumbs' => $breadcrumbs])
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="content" id="content">
            <div class="container product-detail product-full">
                <div class="row">
                    <div id="content" class="col-md-12">
                        <div class="row product-view product-info">
                            <div class="content-product-left  class-honizol col-md-4 col-sm-5">
                                <div class="pd-content-box">
                                    <div class="image-single-box">
                                        <div class="large-image">
                                            @php
                                                $productDetailImages = $product->productImages;
                                            @endphp
                                            {{--                                            {{$product->productImages->count()}}--}}
                                            <img itemprop="image" class="product-image-zoom main-image"
                                                 src="{{asset($productDetailImages[0]->image_path)}}"
                                                 data-zoom-image="{{asset($productDetailImages[0]->image_path)}}"
                                                 title="{{$product->name}}"
                                                 alt="{{$product->name}}"/>
                                            <div class="box-label"></div>
                                        </div>
                                    </div>
                                    <div id="thumb-slider" class="full_slider owl-carousel">
                                        @foreach($productDetailImages as $index => $productDetailImage)
                                            <a data-index="{{$index}}"
                                               class="img thumbnail"
                                               data-image="{{asset($productDetailImage->image_path)}}"
                                               title="{{$product->name}}"
                                            >
                                                <img
                                                    src="{{asset($productDetailImage->image_path)}}"
                                                    title="{{$product->name}}"
                                                    alt="{{$product->name}}"/>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="content-product-right  col-md-8 col-sm-7">
                                <div class="pd-content-box">
                                    <div class="title-product">
                                        <h1>{{$product->name}}</h1>
                                        <div class="sku-title"> - {{$product->sku}}</div>
                                    </div>
                                    <div class="box-review">

                                        <div class="ratings">
                                            <div class="rating-box" title="{{round($reviews->avg('rating'),1)}}">
                                                @php
                                                    $averageRating = $reviews->avg('rating'); // Replace with actual average rating calculation
                                                    $fullStars = floor($averageRating); // Integer part
                                                    $halfStar = ($averageRating - $fullStars) >= 0.1 ? true : false; // Check for half star
                                                @endphp

                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $fullStars)
                                                        <i class="fa fa-star" style="color: #eca330"></i>
                                                        <!-- Full yellow star -->
                                                    @elseif ($i == $fullStars + 1 && $halfStar)
                                                        <i class="fa fa-star-half" style="color: #eca330"></i>
                                                        <!-- Half yellow star -->
                                                    @else
                                                        <i class="fa fa-star" style="color: #ddd"></i>
                                                        <!-- Empty grey star -->
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                        <a href="#"
                                           onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;">{{$reviews->count()}}
                                            Đánh giá</a>
                                        |
                                        <a href="#"
                                           onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;">Đưa ra
                                            đánh giá của bạn</a>
                                    </div>
                                    <div class="desc-price">
                                        <div class="product-desc">
                                            {{--                                            @php--}}
                                            {{--                                                $totalQuantity = $product->sizes->sum('pivot.quantity');--}}
                                            {{--                                            @endphp--}}
                                            {{--                                            <div>Total Sizes: {{ $product->sizes->count() }}</div>--}}
                                            {{--                                            <div>Total Quantity: {{ $totalQuantity }}</div>--}}
                                            <div>Product ID: {{ $product->id }}</div>
                                            {{--                                            <div>Total Quantity: {{ $product->total_quantity }}</div>--}}

{{--                                            <div class="stock">--}}
{{--                                                <span> Kho hàng : </span> {{ $product->total_quantity?? 0 }} Sản Phẩm--}}
{{--                                            </div>--}}
                                            {{--                                            <div class="brand hidden">--}}
                                            {{--                                                <span>Nhà sản xuất:</span>--}}
                                            {{--                                                <a--}}
                                            {{--                                                    href="https://drake.vn/brand-converse-classic-chucktaylorallstar-chuck2-chuck1970s-consonestar-seasonal-jackpurcell-sneaker-dainty-kid">Converse--}}
                                            {{--                                                </a>--}}
                                            {{--                                            </div>--}}
                                            {{--                                            <div class="model hidden"><span>Mã số:</span> Converse Chuck Taylor All Star--}}
                                            {{--                                                Fall--}}
                                            {{--                                                Tone--}}
                                            {{--                                            </div>--}}
                                            <div class="sku"><span>SKU: </span> {{ $product->sku }}</div>
                                            <div class="metarial"><span>Chất liệu: </span> {{ $product->material }}
                                            </div>
                                            <div class="color"><span>Màu sắc: </span> {{ $product->color }}</div>
                                        </div>
                                        <div class="price-stock">
                                            <div class="countdown_box">
                                                <div class="countdown_inner">
                                                    <div class="title ">Khuyến mãi chỉ còn</div>
                                                    <div class="defaultCountdown-3667"></div>
                                                </div>
                                            </div>
                                            <div class="product_page_price price" itemscope
                                                 itemtype="http://schema.org/Offer">
                                                <div class="price-new">
                                                    <span class="tprice">Sale price:</span>
                                                    <span itemprop="price" content="{{$product->sale_price}}">{{number_format($product->sale_price, 0, ',', '.')}} đ</span>
                                                    <meta itemprop="priceCurrency" content="VND"/>
                                                </div>
                                                <div class="rprice">
                                                    <span class="tprice">   Price:</span>
                                                    <span class="price-old" id="price-old">{{number_format($product->price, 0, ',', '.')}} đ</span>
                                                </div>
                                            </div>
                                            <div class="promo-text">
                                                <p>MIỄN PHÍ VẬN CHUYỂN TOÀN QUỐC KHI ĐẶT HÀNG ONLINE</p>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <div class="short-description">{{$product->intro}}</div>
                                    <div id="product">
                                        <div class="option-box">
                                            <div class="options">
                                                <div class="option-item">
                                                    <div class="form-group required">
                                                        <div class="select-box">
                                                            <select name="size"
                                                                    id="input-option" class="form-control"
                                                                    style="font-weight: bold;"
                                                                    required>
                                                                <option value="" disabled selected>VUI LÒNG CHỌN SIZE
                                                                </option>
                                                                @foreach($product->sizes as $size)
                                                                    <option value="{{$size->id}}">
                                                                        {{$size->name}} - {{$size->content}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <div class="text-danger" id="size-alert">Vui Lòng Chọn Size
                                                                !
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--                                        <span class="huongdanchonsize">--}}
                                        {{--                                            <a target="_blank" href="#">--}}
                                        {{--                                                <i class="fa fa-question-circle"></i> Hướng dẫn chọn size--}}
                                        {{--                                            </a>--}}
                                        {{--                                        </span>--}}
                                        <span class="huongdanchonsize">
                                            <a href="#" data-toggle="modal" data-target="#popupchonsize">
                                                <i class="fa fa-question-circle"></i> Hướng dẫn chọn size
                                            </a>
                                        </span>
                                        <div class="modal fade" id="popupchonsize" tabindex="-1" role="dialog"
                                             aria-labelledby="popupchonsize" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Hướng dẫn chọn
                                                            size</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span
                                                                aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <ul>
                                                            <li><b>Hướng dẫn chọn size Converse</b>
                                                                <iframe width="450"
                                                                        height="250"
                                                                        src="https://www.youtube.com/embed/3Al7Hd8Kbo0"
                                                                        frameborder="0"
                                                                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                                        allowfullscreen></iframe>
                                                            </li>
                                                            <li><b>Hướng dẫn chọn size Vans</b>
                                                                <iframe width="450"
                                                                        height="250"
                                                                        src="https://www.youtube.com/embed/Jw31XOTF1gY"
                                                                        frameborder="0"
                                                                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                                        allowfullscreen></iframe>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="quantity-box">
                                            <div class="option quantity">
                                                <div class="input-group quantity-control">
                                                    <label for="quantity"><b>Số lượng:</b></label>
                                                    <div class="quantity-content">
                                                        <span class="input-group-addon product_quantity_down">-</span>
                                                        <input id="quantity" class="form-control" type="number"
                                                               name="quantity" value="1" min="1"/>
                                                        <input type="hidden" name="product_id"
                                                               value="{{$product->id}}"/>
                                                        <span class="input-group-addon product_quantity_up">+</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="button-box" style="margin-top: 20px;">
                                                <div class="button-pd" style="padding-bottom: 15px">
                                                    <button type="button" title="Thêm Vào Giỏ Hàng"
                                                            data-loading-text="Đang Xử lý..." id="button-cart"
                                                            onclick="addCart({{ $product->id }})"
                                                            class="btn btn-mega btn-lg">
                                                        Thêm Vào Giỏ Hàng
                                                    </button>
                                                </div>
                                                <div class="button-pd">
                                                    <button type="button" title="Đặt hàng"
                                                            data-loading-text="Đang Xử lý..." id="button-buy"
                                                            class="btn btn-mega btn-lg">
                                                        Mua Ngay
                                                    </button>
                                                </div>

                                                <div class="add-to-links wish_comp">
                                                    <button type="button" class="btn btn-lg wishlist"
                                                            title="Thêm Yêu thích"
                                                            onclick="wishlist.add('{{$product->id}}');">
                                                        <i class="fa fa-heart"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="pd-tab">
                                    {{--                                    navTabs bootstrap--}}
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#tab-specification" data-toggle="tab">Thông số kỹ
                                                thuật</a></li>
                                        <li><a href="#tab-description" data-toggle="tab">Mô tả</a></li>
                                        <li><a href="#tab-review" data-toggle="tab">Đánh giá</a></li>
                                        <li><a href="#tab-tags" data-toggle="tab">Tags</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab-specification">
                                            <div class="description-box">
                                                <div class="description-content">
                                                    <div class="product-attributes">
                                                        <div class="attribute-group">
                                                            <h3>Thông tin sản phẩm</h3>
                                                            <ul class="attribute-list">
                                                                <li><label class="label">Nhãn hiệu <span
                                                                            class="prd-tab-colon">:</span></label>
                                                                    <div class="attribute-data"> <span class="data">{{$product->brand->name}}
																</span></div>
                                                                </li>
                                                                <li><label class="label">Tên <span
                                                                            class="prd-tab-colon">:</span></label>
                                                                    <div class="attribute-data"><span
                                                                            class="data">{{$product->name}}</span></div>
                                                                </li>
                                                                <li><label class="label">Mã sản phẩm <span
                                                                            class="prd-tab-colon">:</span></label>
                                                                    <div class="attribute-data"> <span class="data">{{$product->sku}}
																</span></div>
                                                                </li>
                                                                <li><label class="label">Dòng sản phẩm <span
                                                                            class="prd-tab-colon">:</span></label>
                                                                    <div class="attribute-data"><span
                                                                            class="data">{{$product->category->name}}</span>
                                                                    </div>
                                                                </li>
                                                                <li><label class="label">Nơi sản xuất <span
                                                                            class="prd-tab-colon">:</span></label>
                                                                    <div class="attribute-data"> <span class="data">Việt Nam
																</span></div>
                                                                </li>
                                                                <li><label class="label">Chế độ bảo hành <span
                                                                            class="prd-tab-colon">:</span></label>
                                                                    <div class="attribute-data"> <span class="data">Bảo hành
																	chính hãng Converse 1 tháng<br/> Hỗ trợ bảo hành 3
																	tháng từ Shop </span></div>
                                                                </li>
                                                                <li><label class="label">Phụ kiện theo kèm <span
                                                                            class="prd-tab-colon">:</span></label>
                                                                    <div class="attribute-data"> <span class="data">Túi Converse
																	<br/> Phiếu bảo hành chính hãng <br/> Hộp giày
																</span></div>
                                                                </li>
                                                                <li class="fullwidth"><label class="label">MIỄN PHÍ VẬN
                                                                        CHUYỂN
                                                                        TOÀN QUỐC KHI ĐẶT HÀNG ONLINE <span
                                                                            class="prd-tab-colon">:</span></label></li>
                                                            </ul>
                                                        </div>
                                                        <div class="attribute-group">
                                                            <h3>Đặc tính sản phẩm</h3>
                                                            <ul class="attribute-list">
                                                                <li><label class="label">Giới tính <span
                                                                            class="prd-tab-colon">:</span></label>
                                                                    <div class="attribute-data"> <span class="data">Unisex
																</span></div>
                                                                </li>
                                                                <li><label class="label">Màu sắc <span
                                                                            class="prd-tab-colon">:</span></label>
                                                                    <div class="attribute-data"> <span class="data">{{$product->color}}
																</span></div>
                                                                </li>
                                                                <li><label class="label">Phần thân <span
                                                                            class="prd-tab-colon">:</span></label>
                                                                    <div class="attribute-data"> <span class="data">{{$product->material}}
																</span></div>
                                                                </li>
                                                                <li><label class="label">Lớp lót <span
                                                                            class="prd-tab-colon">:</span></label>
                                                                    <div class="attribute-data"><span
                                                                            class="data">Vải </span>
                                                                    </div>
                                                                </li>
                                                                <li><label class="label">Đế giày <span
                                                                            class="prd-tab-colon">:</span></label>
                                                                    <div class="attribute-data"> <span class="data">Cao su
																</span></div>
                                                                </li>
                                                                <li><label class="label">Tính năng sản phẩm <span
                                                                            class="prd-tab-colon">:</span></label>
                                                                    <div class="attribute-data"> <span class="data">Phối màu
																	Dragon Scale mướt mắt<br/> Chất vải Canvas được gia
																	công tỉ mỉ, ít thấm nước<br/> Thiết kế cổ cao đặc
																	trưng với form ôm sát cổ chân<br/> Hai khoen tròn
																	nhỏ nằm bên hông thân giày giúp chân được thông
																	thoáng không bị hầm hơi<br/> Đế cao su bền chắc, có
																	độ bám và ma sát cao<br/> Mặt đế waffle tạo độ bám
																	vững chắc, hạn chế trơn trượt hiệu quả<br/> Logo
																	Chuck Taylor All Star được in rõ nét bên hông thân
																	giày, làm tăng thêm sự nổi bật<br/> Tape Logo sau
																	gót giày mang đậm dấu ấn thương hiệu<br/> </span>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="description-attributes" style="display: none">
                                                        {!! $product->content !!}
                                                    </div>
                                                </div>
                                                <div class="read-more whide">
                                                    <p class="read-more-button"> Xem thêm</p>
                                                    <p class="read-less-button"> Thu gọn</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab-description">
                                            {!! $product->content !!}
                                        </div>
                                        <div class="tab-pane" id="tab-review">
                                            <form class="form-horizontal" id="form-review">
                                                <div id="review"></div>
                                                <h2>Đưa ra đánh giá của bạn</h2>
                                                <div class="form-group required">
                                                    <div class="col-sm-12"><input type="text" name="name" value=""
                                                                                  id="input-name" class="form-control"
                                                                                  placeholder="Tên của bạn:"/>
                                                    </div>
                                                </div>
                                                <div class="form-group required">
                                                    <div class="col-sm-12"> <textarea name="review_text" rows="5"
                                                                                      id="input-review"
                                                                                      class="form-control"
                                                                                      placeholder="Bình luận:"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group required">
                                                    <div class="col-sm-12">
                                                        <div class="stars rating-star">
                                                            <label class="control-label">Đánh giá:</label>
                                                            <input class="star star-5" id="star-5"
                                                                   type="radio"
                                                                   value="5" name="rating"/>
                                                            <label
                                                                class="star star-5"
                                                                for="star-5">
                                                            </label>
                                                            <input class="star star-4"
                                                                   id="star-4"
                                                                   type="radio" value="4"
                                                                   name="rating"/>
                                                            <label
                                                                class="star star-4" for="star-4">
                                                            </label>
                                                            <input
                                                                class="star star-3" id="star-3" type="radio" value="3"
                                                                name="rating"/>
                                                            <label class="star star-3"
                                                                   for="star-3">
                                                            </label>
                                                            <input
                                                                class="star star-2" id="star-2"
                                                                type="radio" value="2" name="rating"/>
                                                            <label
                                                                class="star star-2" for="star-2">
                                                            </label>
                                                            <input
                                                                class="star star-1" id="star-1" type="radio" value="1"
                                                                name="rating"/>
                                                            <label class="star star-1"
                                                                   for="star-1">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="buttons clearfix">
                                                    <div class="pull-right">
                                                        <button type="button" id="button-review"
                                                                data-loading-text="Đang Xử lý..."
                                                                class="btn btn-primary">Gửi
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="clearfix"></div>
                                            <div class="product-ratings" data-nosnippet="true">
                                                <div class="product-ratings__header">
                                                    <div class="product-ratings__header_score">ĐÁNH GIÁ SẢN PHẨM
                                                        ({{$reviews->count()}})
                                                    </div>
                                                </div>
                                                <div class="product-ratings__list" style="opacity: 1;">
                                                    <div class="product-comment-list">
{{--                                                        @foreach($reviews as $review)--}}
{{--                                                            @php--}}
{{--                                                                $user = $review->user;--}}
{{--                                                            @endphp--}}
{{--                                                            <div class="review-product-rating">--}}
{{--                                                                <a class="review-product-rating__avatar"--}}
{{--                                                                   href="javascript:void(0)">--}}
{{--                                                                    <div class="review-avatar">--}}
{{--                                                                        <img class="review-avatar__img"--}}
{{--                                                                             src="{{asset($user?$user->avatar:'/storage/users/avatar/default_user.png')}}">--}}
{{--                                                                    </div>--}}
{{--                                                                </a>--}}
{{--                                                                <div class="review-product-rating__main">--}}
{{--                                                                    <div--}}
{{--                                                                        class="review-product-rating__author-name">{{$review->name}}--}}
{{--                                                                    </div>--}}
{{--                                                                    <div class="repeat-purchase-con">--}}
{{--                                                                        <div class="review-product-rating__rating">--}}
{{--                                                                            @for ($i = 1; $i <= 5; $i++)--}}
{{--                                                                                @if ($i <= $review->rating)--}}
{{--                                                                                    <i class="fa fa-star"--}}
{{--                                                                                       style="color: #eca330"></i>--}}
{{--                                                                                    <!-- Full yellow star -->--}}
{{--                                                                                    --}}{{--                                                                                @elseif ($i == $fullStars + 1 && $halfStar)--}}
{{--                                                                                    --}}{{--                                                                                    <i class="fa fa-star-half" style="color: #eca330"></i> <!-- Half yellow star -->--}}
{{--                                                                                @else--}}
{{--                                                                                    <i class="fa fa-star"--}}
{{--                                                                                       style="color: #ddd"></i>--}}
{{--                                                                                    <!-- Empty grey star -->--}}
{{--                                                                                @endif--}}
{{--                                                                            @endfor--}}
{{--                                                                        </div>--}}
{{--                                                                    </div>--}}
{{--                                                                    <div--}}
{{--                                                                        class="review-product-rating__time">{{$review->created_at->format('H:i d/m/Y')}}--}}
{{--                                                                    </div>--}}
{{--                                                                    <div--}}
{{--                                                                        style="position: relative; box-sizing: border-box; margin: 15px 0px; font-size: 14px; line-height: 20px; color: rgba(0, 0, 0, 0.87); word-break: break-word;">--}}
{{--                                                                        <div--}}
{{--                                                                            style="margin-top: 0.75rem;font-size: 1.2em;">--}}
{{--                                                                            {{$review->review_text}}--}}
{{--                                                                        </div>--}}
{{--                                                                        <div--}}
{{--                                                                            style="position: absolute; right: 0px; bottom: 0px; background: linear-gradient(to left, rgb(255, 255, 255) 75%, rgba(255, 255, 255, 0)); padding-left: 24px;">--}}
{{--                                                                        </div>--}}
{{--                                                                    </div>--}}
{{--                                                                    @if(trim($review->shop_response??''))--}}
{{--                                                                        <div class="TQTPT9">--}}
{{--                                                                            <div class="xO9geG">phản hồi của Người Bán--}}
{{--                                                                            </div>--}}
{{--                                                                            <div--}}
{{--                                                                                class="qiTixQ">{{$review->shop_response}}--}}
{{--                                                                            </div>--}}
{{--                                                                        </div>--}}
{{--                                                                    @endif--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}

{{--                                                        @endforeach--}}
                                                    </div>
                                                    <div class="review-page-controller">
                                                        {{--                                                    pagination--}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab-tags">
                                            <p>
                                                @foreach($product->tags as $tag)
                                                    <a href="{{route('search', ['tag' => "$tag->name"])}}">{{$tag->name}}</a>
                                                    ,
                                                @endforeach
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        @if($relatedProducts->count() > 0)
                            <div class="clearfix module related-box">
                                <h3 class="title"><span>Sản phẩm liên quan</span></h3>
                                <div class="">
                                    <div class="products-list grid">
                                        <div class="rel-product">
                                            @foreach($relatedProducts as $relatedProduct)
                                                <div class="product-thumb">
                                                    <div class="product-item-content">
                                                        <div class="left-block">
                                                            <div class="image_wrap">
                                                                <div class="image"><a class="preview-image"
                                                                                      href="{{ route('homeProducts.displayProductDetail',['parentCategorySlug' => $relatedProduct->category->parent->slug,'childCategorySlug' => $relatedProduct->category->slug,'productSlug' => $relatedProduct->slug]) }}">
                                                                        <img
                                                                            src="{{asset($relatedProduct->feature_image_path)}}"
                                                                            alt="{{$relatedProduct->name}}"
                                                                            title="{{$relatedProduct->name}}"
                                                                            class="img-1 img-responsive"/> </a>

                                                                    {{--                                                                <div class="countdown_box">--}}
                                                                    {{--                                                                    <div class="countdown_inner">--}}
                                                                    {{--                                                                        <div class="title ">Giới hạn khuyến mãi</div>--}}
                                                                    {{--                                                                        <div class="defaultCountdown-3668"></div>--}}
                                                                    {{--                                                                    </div>--}}
                                                                    {{--                                                                </div>--}}
                                                                </div>
                                                            </div>
                                                            @php
                                                                $percent = round(($relatedProduct->price - $relatedProduct->sale_price)*100 / $relatedProduct->price);
                                                            @endphp
                                                            {{--                                                        <div class="box-label"> <span class="label-product label-psale">-{{$percent}}%</span> </div>--}}
                                                            <div class="box-label"> <span> <img
                                                                        src="{{asset('/storage/icons/ICON NEW ARRIVAL4aa.png')}}"
                                                                        alt=""/> </span></div>
                                                        </div>
                                                        <div class="caption">
                                                            <h4><a class="preview-image"
                                                                   href="{{ route('homeProducts.displayProductDetail',['parentCategorySlug' => $relatedProduct->category->parent->slug,'childCategorySlug' => $relatedProduct->category->slug,'productSlug' => $relatedProduct->slug]) }}">
                                                                    {{ucwords(strtolower(($relatedProduct->name)))}}</a>
                                                            </h4>

                                                            <div class="sku"> # {{$relatedProduct->sku}} </div>
                                                            <div class="price">
                                                                <div><span class="tprice">Sale price: </span> <span
                                                                        class="price-new">{{number_format($relatedProduct->sale_price, 0, ',', '.')}} đ</span>
                                                                </div>
                                                                <div><span class="tprice">Price: </span> <span
                                                                        class="price-old">{{number_format($relatedProduct->price, 0, ',', '.')}} đ</span>
                                                                </div>
                                                            </div>
                                                            {{--                                                        <div class="button-group bottom">--}}
                                                            {{--                                                            <div class="button-group-content"> <button class="addToCart btn-button"--}}
                                                            {{--                                                                                                       type="button" data-toggle="tooltip" title="Đặt hàng"--}}
                                                            {{--                                                                                                       onclick="cart.add('3668');"> <span>Đặt hàng</span></button>--}}
                                                            {{--                                                                <button class="wishlist btn-button" type="button"--}}
                                                            {{--                                                                        data-toggle="tooltip" title="Thêm Yêu thích"--}}
                                                            {{--                                                                        onclick="wishlist.add('3668');"><i--}}
                                                            {{--                                                                        class="fa fa-heart"></i></button> <button--}}
                                                            {{--                                                                    class="compare btn-button" type="button" data-toggle="tooltip"--}}
                                                            {{--                                                                    title="Thêm so sánh" onclick="compare.add('3668');"><i--}}
                                                            {{--                                                                        class="fa fa-refresh"></i></button> </div>--}}
                                                            {{--                                                        </div>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="clearfix module related-box">
                                <h3 class="title"><span>Gợi ý dành riêng cho bạn</span></h3>
                                <div class="">
                                    <div class="products-list grid">
                                        <div class="rel-product">
                                            @foreach($relatedProducts as $relatedProduct)
                                                <div class="product-thumb">
                                                    <div class="product-item-content">
                                                        <div class="left-block">
                                                            <div class="image_wrap">
                                                                <div class="image"><a class="preview-image"
                                                                                      href="{{ route('homeProducts.displayProductDetail',['parentCategorySlug' => $relatedProduct->category->parent->slug,'childCategorySlug' => $relatedProduct->category->slug,'productSlug' => $relatedProduct->slug]) }}">
                                                                        <img
                                                                            src="{{asset($relatedProduct->feature_image_path)}}"
                                                                            alt="{{$relatedProduct->name}}"
                                                                            title="{{$relatedProduct->name}}"
                                                                            class="img-1 img-responsive"/> </a>

                                                                    {{--                                                                <div class="countdown_box">--}}
                                                                    {{--                                                                    <div class="countdown_inner">--}}
                                                                    {{--                                                                        <div class="title ">Giới hạn khuyến mãi</div>--}}
                                                                    {{--                                                                        <div class="defaultCountdown-3668"></div>--}}
                                                                    {{--                                                                    </div>--}}
                                                                    {{--                                                                </div>--}}
                                                                </div>
                                                            </div>
                                                            @php
                                                                $percent = round(($relatedProduct->price - $relatedProduct->sale_price)*100 / $relatedProduct->price);
                                                            @endphp
                                                            {{--                                                        <div class="box-label"> <span class="label-product label-psale">-{{$percent}}%</span> </div>--}}
                                                            <div class="box-label"> <span> <img
                                                                        src="{{asset('/storage/icons/ICON NEW ARRIVAL4aa.png')}}"
                                                                        alt=""/> </span></div>
                                                        </div>
                                                        <div class="caption">
                                                            <h4><a class="preview-image"
                                                                   href="{{ route('homeProducts.displayProductDetail',['parentCategorySlug' => $relatedProduct->category->parent->slug,'childCategorySlug' => $relatedProduct->category->slug,'productSlug' => $relatedProduct->slug]) }}">
                                                                    {{ucwords(strtolower(($relatedProduct->name)))}}</a>
                                                            </h4>

                                                            <div class="sku"> # {{$relatedProduct->sku}} </div>
                                                            <div class="price">
                                                                <div><span class="tprice">Sale price: </span> <span
                                                                        class="price-new">{{number_format($relatedProduct->sale_price, 0, ',', '.')}} đ</span>
                                                                </div>
                                                                <div><span class="tprice">Price: </span> <span
                                                                        class="price-old">{{number_format($relatedProduct->price, 0, ',', '.')}} đ</span>
                                                                </div>
                                                            </div>
                                                            {{--                                                        <div class="button-group bottom">--}}
                                                            {{--                                                            <div class="button-group-content"> <button class="addToCart btn-button"--}}
                                                            {{--                                                                                                       type="button" data-toggle="tooltip" title="Đặt hàng"--}}
                                                            {{--                                                                                                       onclick="cart.add('3668');"> <span>Đặt hàng</span></button>--}}
                                                            {{--                                                                <button class="wishlist btn-button" type="button"--}}
                                                            {{--                                                                        data-toggle="tooltip" title="Thêm Yêu thích"--}}
                                                            {{--                                                                        onclick="wishlist.add('3668');"><i--}}
                                                            {{--                                                                        class="fa fa-heart"></i></button> <button--}}
                                                            {{--                                                                    class="compare btn-button" type="button" data-toggle="tooltip"--}}
                                                            {{--                                                                    title="Thêm so sánh" onclick="compare.add('3668');"><i--}}
                                                            {{--                                                                        class="fa fa-refresh"></i></button> </div>--}}
                                                            {{--                                                        </div>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div>
                <div class="clearfix"></div>
                @if($watchedProductsExcludeThis->count() > 0)
                    <section id="related-box" class="section-style section-color">
                        <div class="container page-builder-ltr">
                            <div class="row row_63ge row-style ">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_hayg col-style">
                                    <div class="module">
                                        <h3 class="modtitle recent-title">Sản phẩm bạn đã xem</h3>
                                        <div class="box-recent grid4">
                                            <div class="box-content">
                                                <div class="box-recent-product products-list">
                                                    @foreach($watchedProductsExcludeThis as $watchedProductExcludeThis)
                                                        <div class="product-thumb">
                                                            <div class="product-item-content">
                                                                <div class="left-block">
                                                                    <div class="image_wrap">
                                                                        <div class="image"><a class="preview-image"
                                                                                              href="{{ route('homeProducts.displayProductDetail',['parentCategorySlug' => $watchedProductExcludeThis->category->parent->slug,'childCategorySlug' => $watchedProductExcludeThis->category->slug,'productSlug' => $watchedProductExcludeThis->slug]) }}">
                                                                                <img
                                                                                    src="{{asset($watchedProductExcludeThis->feature_image_path)}}"
                                                                                    alt="{{$watchedProductExcludeThis->name}}"
                                                                                    title="{{$watchedProductExcludeThis->name}}"
                                                                                    class="img-1 img-responsive"/> </a>

                                                                            {{--                                                                <div class="countdown_box">--}}
                                                                            {{--                                                                    <div class="countdown_inner">--}}
                                                                            {{--                                                                        <div class="title ">Giới hạn khuyến mãi</div>--}}
                                                                            {{--                                                                        <div class="defaultCountdown-3668"></div>--}}
                                                                            {{--                                                                    </div>--}}
                                                                            {{--                                                                </div>--}}
                                                                        </div>
                                                                    </div>
                                                                    @php
                                                                        $percent = round(($watchedProductExcludeThis->price - $watchedProductExcludeThis->sale_price)*100 / $watchedProductExcludeThis->price);
                                                                    @endphp
                                                                    <div class="box-label"><span
                                                                            class="label-product label-psale">-{{$percent}}%</span>
                                                                    </div>
                                                                    {{--                                                        <div class="box-label"> <span> <img--}}
                                                                    {{--                                                                    src="{{asset('/storage/icons/ICON NEW ARRIVAL4aa.png')}}"--}}
                                                                    {{--                                                                    alt="" /> </span> </div>--}}
                                                                </div>
                                                                <div class="caption">
                                                                    <h4><a class="preview-image"
                                                                           href="{{ route('homeProducts.displayProductDetail',['parentCategorySlug' => $watchedProductExcludeThis->category->parent->slug,'childCategorySlug' => $watchedProductExcludeThis->category->slug,'productSlug' => $watchedProductExcludeThis->slug]) }}">
                                                                            {{ucwords(strtolower(($watchedProductExcludeThis->name)))}}</a>
                                                                    </h4>

                                                                    <div class="sku">
                                                                        # {{$watchedProductExcludeThis->sku}} </div>
                                                                    <div class="price">
                                                                        <div><span class="tprice">Sale price: </span>
                                                                            <span
                                                                                class="price-new">{{number_format($watchedProductExcludeThis->sale_price, 0, ',', '.')}} đ</span>
                                                                        </div>
                                                                        <div><span class="tprice">Price: </span> <span
                                                                                class="price-old">{{number_format($watchedProductExcludeThis->price, 0, ',', '.')}} đ</span>
                                                                        </div>
                                                                    </div>
                                                                    {{--                                                        <div class="button-group bottom">--}}
                                                                    {{--                                                            <div class="button-group-content"> <button class="addToCart btn-button"--}}
                                                                    {{--                                                                                                       type="button" data-toggle="tooltip" title="Đặt hàng"--}}
                                                                    {{--                                                                                                       onclick="cart.add('3668');"> <span>Đặt hàng</span></button>--}}
                                                                    {{--                                                                <button class="wishlist btn-button" type="button"--}}
                                                                    {{--                                                                        data-toggle="tooltip" title="Thêm Yêu thích"--}}
                                                                    {{--                                                                        onclick="wishlist.add('3668');"><i--}}
                                                                    {{--                                                                        class="fa fa-heart"></i></button> <button--}}
                                                                    {{--                                                                    class="compare btn-button" type="button" data-toggle="tooltip"--}}
                                                                    {{--                                                                    title="Thêm so sánh" onclick="compare.add('3668');"><i--}}
                                                                    {{--                                                                        class="fa fa-refresh"></i></button> </div>--}}
                                                                    {{--                                                        </div>--}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif
            </div>
        </div>
        <div class="clearfix" style="margin-top: 20px;padding-top: 40px;background-color: rgba(243, 243, 243, 1);">
        </div>
        <!-- /.content -->
    </div>
@endsection
@section('this-js-library')
    <script src={{asset("home/javascript/soconfig/js/jquery.elevateZoom-3.0.8.min.js")}}></script>
    {{--    <script src={{asset("home/javascript/soconfig/js/lightslider.js")}}></script>--}}
    <script src={{asset("home/javascript/jquery/datetimepicker/moment.js")}}></script>
    {{--    <script src={{asset("home/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js")}}></script>--}}
    {{--    <script src={{asset("home/javascript/jquery/pdt360DegViewer.js")}}></script>--}}
@endsection
@section('this-js')
    <script type="text/javascript">
        function addCart(productId) {
            var sizeId = $('#input-option').val();
            if (!sizeId) {
                if (!$('#size-alert').hasClass('show')) {
                    $('#size-alert').addClass('show');
                    alertify.error('Vui lòng chọn size!');
                }
                return false;
            } else {
                if ($('#size-alert').hasClass('show')) {
                    $('#size-alert').removeClass('show');
                    alertify.success('Bạn đã chọn size, Xin cảm ơn!');
                }
            }

            var quantity = $('#quantity').val();
            var url = '{{ route('addToCart') }}';

            $.ajax({
                url: url,
                type: 'POST', // Change to POST method as we are sending data
                data: {
                    _token: '{{ csrf_token() }}', // Include CSRF token for security
                    quantity: quantity,
                    sizeId: sizeId,
                    productId: productId
                },
                beforeSend: function () {
                    $('#button-cart').button('loading');
                },
                complete: function () {
                    $('#button-cart').button('reset');
                },
                success: function (response) {
                    if (response.success) {
                        $("#shoppingcart-box").html(response.view); // Update the cart view with rendered HTML
                        var cartQty = $('#cartItemNumbersData').val();
                        $("#cartItemNumbers").html(cartQty)
                        alertify.success('Đã thêm sản phẩm'); // Show success message
                    } else {
                        alertify.error(response.msg); // Show error message if product could not be added
                    }
                },
                error: function (xhr, status, error) {
                    alertify.error('Thêm sản phẩm vào giỏ hàng thất bại'); // Show generic error message
                    console.error(xhr.responseText); // Log the error for debugging
                }
            });
        }

        $(function ($) {
            var $nav = $("#thumb-slider");
            console.log($nav.length);
            $nav.each(function () {
                $(this).owlCarousel2({
                    nav: true,
                    dots: false,
                    slideBy: 1,
                    margin: 10,
                    navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
                    responsive: {
                        0: {
                            items: 2
                        },
                        600: {
                            items: 3
                        },
                        1000: {
                            items: 3
                        }
                    }
                });
            })

        });
        $(function () {
            var austDay = new Date(2024, 6 - 1, 13, 23, 59, 5);
            $('.defaultCountdown-3667').countdown(austDay, function (event) {
                $(this).html(event.strftime(''
                    + '<div class="time-item time-day"><div class="num-time">%D</div><div class="name-time">Ngày </div></div>'
                    + '<div class="time-item time-hour"><div class="num-time">%H</div><div class="name-time">Giờ </div></div>'
                    + '<div class="time-item time-min"><div class="num-time">%M</div><div class="name-time">Phút </div></div>'
                    + '<div class="time-item time-sec"><div class="num-time">%S</div><div class="name-time">Giây </div></div>'));
            });
        });
        $('.fb-list').owlCarousel2({
            nav: true,
            dots: false,
            slideBy: 1,
            margin: 5,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            responsive: {
                0: {items: 2},
                600: {items: 3},
                1000: {items: 4}
            }
        });
        jQuery(document).ready(function ($) {
            $('.rel-product').owlCarousel2({
                pagination: false,
                center: false,
                nav: true,
                dots: false,
                loop: false,
                margin: 30,
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                slideBy: 1,
                autoplay: false,
                autoplayTimeout: 2500,
                autoplayHoverPause: true,
                autoplaySpeed: 800,
                startPosition: 0,
                responsive: {
                    0: {
                        items: 2,
                        margin: 3
                    },
                    480: {
                        items: 2,
                        margin: 3
                    },
                    768: {
                        items: 2
                    },
                    991: {
                        items: 3
                    },
                    1200: {
                        items: 4
                    }
                }
            });

            $('.grid4 .box-recent-product').owlCarousel2({
                pagination: false,
                center: false,
                nav: true,
                dots: false,
                loop: true,
                margin: 0,
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                slideBy: 1,
                autoplay: false,
                autoplayTimeout: 2500,
                autoplayHoverPause: true,
                autoplaySpeed: 800,
                startPosition: 0,
                responsive: {
                    0: {
                        margin: 3,
                        items: 2
                    },
                    480: {
                        margin: 3,
                        items: 2
                    },
                    600: {
                        items: 3
                    },
                    992: {
                        items: 3
                    },
                    1200: {
                        items: 4
                    }
                }
            });
        });

        jQuery(document).ready(function ($) {
            //1st block

            // 2nd block
            $("#khuyenmai div:first-of-type label").addClass('active');
            $("#khuyenmai div:first-of-type label input[name=km_id]").prop("checked", true);

            function addkm(id) {
                var a = "#km" + id + " label";
                $("#khuyenmai label").removeClass('active');
                $("#km" + id + " label.km_" + id).addClass('active');
            }

            $('#review').delegate('.pagination a', 'click', function (e) {
                e.preventDefault();

                $('#review').fadeOut('slow');
                $('#review').load(this.href);
                $('#review').fadeIn('slow');
            });

            $('#review').load('index.php?route=product/product/review&product_id=3667');

            $('#button-review').on('click', function () {
                $.ajax({
                    url: 'index.php?route=product/product/write&product_id=3667',
                    type: 'post',
                    dataType: 'json',
                    data: $("#form-review").serialize(),
                    beforeSend: function () {
                        $('#button-review').button('loading');
                    },
                    complete: function () {
                        $('#button-review').button('reset');
                    },
                    success: function (json) {
                        $('.alert-success, .alert-danger').remove();

                        if (json['error']) {
                            $('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
                        }

                        if (json['success']) {
                            $('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

                            $('input[name=\'name\']').val('');
                            $('textarea[name=\'text\']').val('');
                            $('input[name=\'rating\']:checked').prop('checked', false);
                        }
                    }
                });
            });

//ko thấy
            $('#button-sendmail').on('click', function () {
                $.ajax({
                    url: 'index.php?route=product/product/sendmail&product_id=3667',
                    type: 'post',
                    dataType: 'json',
                    data: $("#form-sendmail").serialize(),
                    beforeSend: function () {
                        $('#button-sendmail').button('loading');
                    },
                    complete: function () {
                        $('#button-sendmail').button('reset');
                    },
                    success: function (json) {
                        $('.alert-success, .alert-danger').remove();

                        if (json['error']) {
                            $('#sendmail').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
                        }

                        if (json['success']) {
                            $('#sendmail').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

                            $('input[name=\'name\']').val('');
                            $('input[name=\'phone\']').val('');
                            $('input[name=\'email\']').val('');
                        }
                    }
                });
            });
        });
        $(document).ready(function () {
            var ajax_price = function () {
                $.ajax({
                    type: 'POST',
                    url: 'index.php?route=extension/soconfig/liveprice/index',
                    data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
                    dataType: 'json',
                    success: function (json) {
                        if (json.success) {
                            change_price('#price-special', json.new_price.special);
                            change_price('#price-tax', json.new_price.tax);
                            change_price('#price-old', json.new_price.price);
                        }
                    }
                });
            }

            var change_price = function (id, new_price) {
                $(id).html(new_price);
            }
            $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\'], .product-info input[type=\'checkbox\'], .product-info select, .product-info textarea, .product-info input[name=\'quantity\']').on('change', function () {
                ajax_price();
            });
        });
        //Quan trọng
        $(document).ready(function () {
            $("#thumb-slider .owl2-item").each(function () {
                $(this).find("[data-index='0']").addClass('active');
                console.log(` $("#thumb-slider .owl2-item").each(function()`)
            });

            var zoomCollection = '.large-image img';
            $(zoomCollection).elevateZoom({
                zoomType: "inner",
                lensSize: "250",
                easing: true,
                gallery: 'thumb-slider',
                cursor: 'pointer',
                galleryActiveClass: "active"// auto add active to item in the gallerry và là dữ liệu cho magnificPopup below
            });

            // << Product Option Image PRO module
            var poip_elevate_zoom_object = $(zoomCollection).data('elevateZoom');
            // >> Product Option Image PRO module

            $('.large-image img').magnificPopup({
                items: [
                        @foreach($productDetailImages as $productDetailImage)
                    {
                        src: '{{asset($productDetailImage->image_path)}}'
                    },
                    @endforeach
                ],
                gallery: {enabled: true, preload: [0, 2]},
                type: 'image',
                mainClass: 'mfp-fade',
                callbacks: {
                    open: function () {
                        var activeIndex = ($('#thumb-slider .img.active').data('index'));// tựa element.dataset.index
                        var magnificPopup = $.magnificPopup.instance;
                        magnificPopup.goTo(activeIndex);
                    }
                }
            });

        });
        $('.box-recent .product-item .product-content .name h4').matchHeight();// prevent broken layout when used with boostrap col-size sys
    </script>
    {{--    readmore readless code--}}
    <script type="text/javascript">
        $(document).ready(function () {
            // if ($('.description-box').height() > 500) {
            //     $('.description-box').addClass('wbc-height');
            // }
            var $description = $('.description-box .description-attributes');
            // if ( $description.height() > 100)  {
            //     $('.description-box').addClass('wbc-height');
            // }
            if ($description.children().length > 0 || $description.text().trim() !== '' || $description.height() > 100) {
                $('.description-box').addClass('wbc-height');
            }

            $('.description-box .read-more .read-more-button').click(function () {
                $('.description-box').removeClass('wbc-height');
                $('.description-box').addClass('wbd-height');
            });
            $('.description-box .read-more .read-less-button').click(function () {
                $('.description-box').addClass('wbc-height');
                $('.description-box').removeClass('wbd-height');
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {

            $('#button-review').click(function (e) {
                $this = $(this);
                var formData = $('#form-review').serialize();
                var extraFieldData = {
                    product_id: {{$product->id}},
                };
                var combinedData = formData + '&' + $.param(extraFieldData);

                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                // Perform AJAX request to process the entire form
                var url = '{{route('submitReview')}}';
                $.ajax({
                    type: 'POST',
                    url: url, // Laravel route for processing the form
                    data: combinedData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Pass CSRF token via header
                    },
                    success: function (response) {
                        // Handle success response
                        if (response.success) {
                            // Redirect to success page or show success message
                            alertify.alert('', "Cảm Ơn Quý Khách Đã Đánh Giá!");
                        } else {
                            // Display Laravel validation errors if any
                            if (response.errors) {
                                $.each(response.errors, function (key, value) {
                                    alertify.alert('', value[0]);
                                    return false;//just display one alert
                                });
                            }
                            // alertify.error(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        // Handle AJAX error
                        console.error('AJAX Error: ' + error);
                    }
                });
            });

        });
    </script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            $(".description-attributes").fadeIn();
        });
    </script>
    <script>
        $(document).ready(function() {
            loadReviews();

            function loadReviews(page = 1) {
                // alertify.success("call");
                $.ajax({
                    url: '{{route('reviewsWithPagination')}}',
                    type: 'GET',
                    data: {
                        page: page,
                        productId: {{$product->id}},
                    },
                    success: function(response) {
                        $('.product-comment-list').html(response.html);
                        $('.review-page-controller').html(generatePagination(response));
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching reviews:', error);
                    }
                });
            }
            $('.review-page-controller').on('click', '.page-link', function() {
                // alertify.success("call 2nd");
                const page = $(this).data('page');
                loadReviews(page);
            });
            function generatePagination(response) {
                let paginationHTML = '';

                // Previous button
                paginationHTML += `<button type="button" class="page-link" data-page="${response.current_page - 1}" ${response.prev_page_url ? '' : 'disabled'}><i class="fas fa-chevron-left"></i></button>`;

                // Page buttons
                for (let i = 1; i <= response.last_page; i++) {
                    paginationHTML += `<button type="button" class="page-link ${i === response.current_page ? 'active' : ''}" data-page="${i}">${i}</button>`;
                }

                // Next button
                paginationHTML += `<button type="button" class="page-link" data-page="${response.current_page + 1}" ${response.next_page_url ? '' : 'disabled'}><i class="fas fa-chevron-right"></i></button>`;

                return paginationHTML;
            }
        });
    </script>
@endsection






