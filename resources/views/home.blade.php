@extends('layouts.homeLayout')

@section('title')
    <title>Trang Chủ</title>
@endsection
@section('this-css-library')

@endsection
@section('this-css')

    <style>

        #test::before {
            font-family: "Font Awesome 5 Free", serif;
            content: "\f0d7"
        }
        .viewMore {
            position: absolute;
            bottom: -1%;
            margin: auto;
            left: 50%; /* position the left edge of the element at the middle of the parent */
            transform: translate(-50%, -50%);
        }
        .newArrival {
            object-fit: fill;
        }
        @media screen and (min-width: 768px) {
            .newArrival {
                min-height: 550px;
            }
        }

        .overlay {
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, .6);
            z-index: 1000;
        }
        body {
            overflow-y: hidden;
        }
        .loader1 {
            width: 48px;
            height: 48px;
            border: 5px solid #FFF;
            border-bottom-color: #FF3D00;
            border-radius: 50%;
            display: inline-block;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
            position: fixed;
            z-index: 99999;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('content')
    <span class="loader1"></span>
    <span class="overlay"></span>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
{{--        ((truyền vào  1 array $breadcrumbs--))--}}
{{--        @include('partials.contentHeader', ['breadcrumbs' => []])--}}
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="content">
            <div class="container page-builder-ltr">
                <div class="row row_5tlw row-style ">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_6utb col-style">
                        <div id="brands0" class="brands-box" style="opacity: 1;">
                            @foreach($parentCategories as $parentCategory)
                                @php
                                    $brandsOfParentCategory = $parentCategory->brands()->get();
                                 @endphp
                                @if($brandsOfParentCategory->count())
                                    <div class="item"><a href="{{ route('homeProducts.listByParentCategory', $parentCategory->slug) }}"><img
                                                src="{{asset($brandsOfParentCategory->first()->logo_path)}}" alt="CONVERSE"
                                                class="img-responsive"/></a>
                                    </div>

                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="container page-builder-ltr">
                <div class="row row_c0xj row-style bannerhome-2 ">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_olfu col-style">
                        <div id="banner0" class="banners owl-carousel banner-block  banner_hover   ">
                            <div class="item">
                                <div class="imagebanner"> <a href="#"><img
                                            src="{{asset('storage/slider/SALE-70_-0723-590x220.jpg')}}"
                                            alt="Sale 70" class="img-responsive" /></a> </div>
                            </div>
                            <div class="item">
                                <div class="imagebanner"> <a href="#"><img
                                            src="{{asset('storage/slider/SALE-70_-0723a-590x220.jpg')}}"
                                            alt="Sale 70" class="img-responsive" /></a> </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <section id="" class="section-style ">
                <div class="container-fluid page-builder-ltr">
                    <div class="row row_es7t row-style ">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col_929u col-style">
                            <div>
                                <div class="box-content">
                                    <p><img alt=""
                                            class="newArrival"
                                            src="{{asset("storage/staticBanner/new-arrival-0723.jpg")}}"
                                        /></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col_jg3d col-style">
                            <div class="clearfix module featured-module">
                                <h3 class="modtitle"></h3>
                                <div class="new-arrival-box-content pd-featured">
                                    @for($x =0; $x < 8; $x++)
                                        <div class="item ">
                                            <div class="product-thumb">
                                                <div class="product-item-content">
                                                    <div class="left-block">
                                                        <div class="product-image-container second_img so-quickview">
                                                            <a href="{{ route('homeProducts.displayProductDetail',['parentCategorySlug' => $latestConverse[$x]->category->parent->slug,'childCategorySlug' => $latestConverse[$x]->category->slug,'productSlug' => $latestConverse[$x]->slug]) }}">
                                                                <img src="{{asset($latestConverse[$x]->feature_image_path)}}"
                                                                    data-poip_id="image_ExtensionModuleFeatured_3669"
                                                                    alt="{{$latestConverse[$x]->name}}"
                                                                    title="{{$latestConverse[$x]->name}}"
                                                                    class="img-responsive"/>
                                                            </a>
                                                            <div class="box-label">
                                                                <span>
                                                                    <img
                                                                        src= "{{asset('storage/icons/ICON%20NEW%20ARRIVAL4aa.png')}}"
                                                                        alt=""/>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="right-block">
                                                        <div class="caption">
                                                            <h4>
                                                                <a href="{{ route('homeProducts.displayProductDetail',['parentCategorySlug' => $latestConverse[$x]->category->parent->slug,'childCategorySlug' => $latestConverse[$x]->category->slug,'productSlug' => $latestConverse[$x]->slug]) }}">
                                                                    {{ucwords(strtolower(($latestConverse[$x]->name)))}}
                                                                </a>
                                                            </h4>
                                                            <div class="sku"> # {{$latestConverse[$x]->sku}}</div>
                                                            <div class="price">
                                                                <div><span class="tprice">Sale price: </span> <span
                                                                        class="price-new">{{number_format($latestConverse[$x]->sale_price, 0, ',', '.')}} đ</span>
                                                                </div>
                                                                <div><span class="tprice">Price: </span> <span
                                                                        class="price-old">{{number_format($latestConverse[$x]->price, 0, ',', '.')}} đ</span>
                                                                </div>
                                                            </div>
                                                            <div class="description  hidden ">
                                                                <p> &nbsp; ..</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-thumb">
                                                <div class="product-item-content">
                                                    <div class="left-block">
                                                        <div class="product-image-container second_img so-quickview">
                                                            <a href="{{route('homeProducts.displayProductDetail',['parentCategorySlug' => $latestVans[$x]->category->parent->slug,'childCategorySlug' => $latestVans[$x]->category->slug,'productSlug' => $latestVans[$x]->slug]) }}">
                                                            <img
                                                                    src="{{asset($latestVans[$x]->feature_image_path)}}"
                                                                    data-poip_id="image_ExtensionModuleFeatured_3670"
                                                                    alt="{{$latestVans[$x]->name}}"
                                                                    title="{{$latestVans[$x]->name}}"
                                                                    class="img-responsive"/>
                                                            </a>
                                                            <div class="box-label">
                                                                <span>
                                                                    <img
                                                                        src="{{asset('storage/icons/ICON NEW ARRIVAL4aa.png')}}"
                                                                        alt=""/>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="right-block">
                                                        <div class="caption">
                                                            <h4>
                                                                <a href="{{ route('homeProducts.displayProductDetail',['parentCategorySlug' => $latestVans[$x]->category->parent->slug,'childCategorySlug' => $latestVans[$x]->category->slug,'productSlug' => $latestVans[$x]->slug]) }}">
                                                                    {{ucwords(strtolower(($latestVans[$x]->name)))}}
                                                                </a>
                                                            </h4>
                                                            <div class="sku"> # {{$latestVans[$x]->sku}}</div>
                                                            <div class="price">
                                                                <div><span class="tprice">Sale price: </span> <span
                                                                        class="price-new">{{number_format($latestVans[$x]->sale_price, 0, ',', '.')}} đ</span>
                                                                </div>
                                                                <div><span class="tprice">Price: </span> <span
                                                                        class="price-old">{{number_format($latestVans[$x]->price, 0, ',', '.')}} đ</span>
                                                                </div>
                                                            </div>
                                                            <div class="description  hidden ">
                                                                <p> Lấy cảm hứng từ phong cách bóng rổ những năm thập
                                                                    niên 80, Converse Chuck Taylor All
                                                                    Star Construct gạt bỏ những giới hạn xưa cũ để từng
                                                                    bước hoàn thiện hơn. Khoác lên diện
                                                                    mạo khác lạ và đầy vẻ t..</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            @foreach($brands as $brand)
                @php
                    $products = $brand->products()->orderBy('price', 'asc')->take(20)->get();
                    $productsCount = $products->count();
                    $parentCategoryOfBranArr = $brand->categories()->where('parent_id', 0)->get();
                    $parentCategory = $parentCategoryOfBranArr->first();
                @endphp
                <div class="container page-builder-ltr">
                    <div class="row row_xgir row-style bannerhome-2 ">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_do0r col-style">
                            <div>
                                <div class="box-content">
                                    <p><img alt=""
                                            src="{{asset($brand->banner_path)}}" /></p>
                                </div>
                            </div>
                            <div class="box-tab-home" style="position: relative;">
                                <div class="tab-content">
                                    <div id="mcproduct1_0" class="tab-pane fade in active">
                                        @for($i = 0; $i < $productsCount; $i++)
                                            @php
                                            $thisProduct = $products[$i];
                                            $percent = round(($thisProduct->price - $thisProduct->sale_price)*100 / $thisProduct->price);
                                            @endphp
                                            <div class="ltabs-item col-lg-2 col-md-2 col-sm-4 col-xs-6">
                                                <div class="product-thumb">
                                                    <div class="product-item-content">
                                                        <div class="left-block">
                                                            <div class="product-image-container second_img so-quickview">
                                                                <a
                                                                    href="{{ route('homeProducts.displayProductDetail',['parentCategorySlug' => $parentCategory->slug,'childCategorySlug' => $thisProduct->category->slug,'productSlug' => $thisProduct->slug]) }}"
                                                                >
                                                                    <img
                                                                        src="{{asset($thisProduct->feature_image_path)}}"
                                                                        alt="{{$thisProduct->name}}"
                                                                        title="{{$thisProduct->name}}" class="img-responsive" />
                                                                </a>
                                                                <div class="box-label"> <span class="label-product label-psale">-{{$percent}}%</span> </div>
                                                            </div>
                                                        </div>
                                                        <div class="right-block">
                                                            <div class="caption">
                                                                <h4><a
                                                                        href="{{ route('homeProducts.displayProductDetail',['parentCategorySlug' => $parentCategory->slug,'childCategorySlug' => $thisProduct->category->slug,'productSlug' => $thisProduct->slug]) }}"
                                                                    >{{$thisProduct->name}}</a></h4>
                                                                <div class="sku"> # {{$thisProduct->sku}} </div>
                                                                <div class="price">
                                                                    <div> <span class="tprice">Sale price: </span> <span class="price-new">{{number_format($thisProduct->sale_price, 0, ',', '.')}} đ</span>
                                                                    </div>
                                                                    <div> <span class="tprice">Price: </span> <span class="price-old">{{number_format($thisProduct->price, 0, ',', '.')}} đ </span>
                                                                    </div>
                                                                </div>
                                                                <div class="description  hidden ">
                                                                    <p> Lấy cảm hứng từ phong cách bóng rổ những năm thập niên 80, Converse Chuck Taylor All
                                                                        Star Construct gạt bỏ những giới hạn xưa cũ để từng bước hoàn thiện hơn. Khoác lên diện
                                                                        mạo khác lạ và đầy vẻ t..</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                            <div class="view-more"> <a class="viewMore" href="{{ route('homeProducts.listByParentCategory', $parentCategory->slug) }}">See More</a> </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- /.content -->
    </div>
@endsection
@section('this-js-library')

@endsection
@section('this-js')

    <script type="text/javascript">
        $('#banner0').owlCarousel2({
            margin: 15,
            items: 2,
            nav: true,
            navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
            autoplay: 400,
            smartSpeed: 200,
            slideBy: 'page',
            dots: true,
            responsive: {
                0: { items: 2 },
                480: { items: 2 },
                768: { items: 2 }
            },
        });
        $(function ($) {
            $(".pd-featured").owlCarousel2({
                nav:true,
                dots: false,
                slideBy: 1,
                margin:10,
                items: 3,
                loop: true,
                autoplay:true,
                autoplayTimeout:4500,
                smartSpeed: 550,
                navText: ['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
                responsive:{
                    0:{
                        items: 2          },
                    600:{
                        items: 2          },
                    1000:{
                        items: 3          }
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(window).on("load", function() {
            // Hide the overlay
            $(".overlay").fadeOut();

            // Enable scrolling on the body
            $("body").css("overflow-y", "auto");

            // Hide the loader
            $(".loader1").fadeOut();
        });
    </script>
@endsection






