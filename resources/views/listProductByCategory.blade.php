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

    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        @include('partials.contentHeader', ['breadcrumbs' => $breadcrumbs])
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="content">
            @if ($productsByParentCategory->count())
                <div class="container">
                    <div class="row">
                        <div id="content" class="col-xs-12 col-sm-12">
                            <div class="products-category">
                                <div class="category-top "></div>
                                <div id="mfilter-content-container">
                                    <div class="banner-box">
                                        <p><img src="{{asset($thisParentCategory->banner_path)}}"
                                                alt="{{$thisParentCategory->name}}"></p>
                                    </div>
                                    <h1 class="title-catepage">{{$thisParentCategory->name}}</h1>
                                    <div class="product-filter filters-panel">
                                        <div class="row">
                                            <div class="short-by-show form-inline text-center  col-md-12 col-sm-12">
                                                <div class="form-group sort-by pull-right">
                                                    <select id="input-sort" class="form-control">
                                                        <option value="">Sắp xếp: Mặc định</option>
                                                        <option value="{{ route('homeProducts.listByParentCategory', [$thisParentCategory->slug, 'sort_by' => 'name', 'sort_direction' => 'asc']) }}" {{ $sortBy == 'name' && $sortDirection == 'asc' ? 'selected' : '' }}>
                                                            Sắp xếp: Tên (A - Z)
                                                        </option>
                                                        <option value="{{ route('homeProducts.listByParentCategory', [$thisParentCategory->slug, 'sort_by' => 'name', 'sort_direction' => 'desc']) }}" {{ $sortBy == 'name' && $sortDirection == 'desc' ? 'selected' : '' }}>
                                                            Sắp xếp: Tên (Z - A)
                                                        </option>
                                                        <option value="{{ route('homeProducts.listByParentCategory', [$thisParentCategory->slug, 'sort_by' => 'sale_price', 'sort_direction' => 'asc']) }}" {{ $sortBy == 'sale_price' && $sortDirection == 'asc' ? 'selected' : '' }}>
                                                            Sắp xếp: Giá (Thấp > Cao)
                                                        </option>
                                                        <option value="{{ route('homeProducts.listByParentCategory', [$thisParentCategory->slug, 'sort_by' => 'sale_price', 'sort_direction' => 'desc']) }}" {{ $sortBy == 'sale_price' && $sortDirection == 'desc' ? 'selected' : '' }}>
                                                            Sắp xếp: Giá (Cao > Thấp)
                                                        </option>
                                                        <option value="{{ route('homeProducts.listByParentCategory', [$thisParentCategory->slug, 'sort_by' => 'rating', 'sort_direction' => 'desc']) }}" {{ $sortBy == 'rating' && $sortDirection == 'desc' ? 'selected' : '' }}>
                                                            Sắp xếp: Đánh giá (Cao nhất)
                                                        </option>
                                                        <option value="{{ route('homeProducts.listByParentCategory', [$thisParentCategory->slug, 'sort_by' => 'rating', 'sort_direction' => 'asc']) }}" {{ $sortBy == 'rating' && $sortDirection == 'asc' ? 'selected' : '' }}>
                                                            Sắp xếp: Đánh giá (Thấp nhất)
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="products-list row grid">
                                        @php
                                            $productsCount = $productsByParentCategory->count();
                                        @endphp
                                        @foreach($productsByParentCategory as $key => $product)
                                            @php
                                                $percent = round(($product->price - $product->sale_price)*100 / $product->price);
                                            @endphp
                                            <div class="product-layout col-lg-3 col-md-4 col-sm-6 col-xs-12 ">
                                                <div class="product-thumb">
                                                    <div class="product-item-content" style="height: 372px;">
                                                        <div class="left-block"><a
                                                                href="{{ route('homeProducts.displayProductDetail',['parentCategorySlug' => $thisParentCategory->slug,'childCategorySlug' => $product->category->slug,'productSlug' => $product->slug]) }}"
                                                            >
                                                                <div class="product-image-container   ">
                                                                    <img
                                                                        src="{{asset($product->feature_image_path)}}"
                                                                        alt="{{$product->name}}"
                                                                        title="{{$product->name}}"
                                                                        class="img-responsive"
                                                                    >

                                                                    <div class="box-label">
                                                                        @if( $key > $productsCount/2)
                                                                            <span
                                                                                class="label-product label-discount"
                                                                                style="display: block !important;">-{{$percent}}%
                                                                            </span>
                                                                        @else
                                                                            <span><img
                                                                                    src="{{asset('storage/icons/ICON NEW ARRIVAL4aa.png')}}"
                                                                                    alt=""></span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="right-block" style="height: 97px;">
                                                            <div class="caption">
                                                                <h4 style="height: 31px;">
                                                                    <a
                                                                        href="{{ route('homeProducts.displayProductDetail',['parentCategorySlug' => $thisParentCategory->slug,'childCategorySlug' => $product->category->slug,'productSlug' => $product->slug]) }}"
                                                                    >{{$product->name}}</a>
                                                                </h4>
                                                                <div class="sku"> # {{$product->sku}}</div>
                                                                <div class="price" style="height: 37px;">
                                                                    <div><span class="tprice">Sale price: </span> <span
                                                                            class="price-new">{{number_format($product->sale_price, 0, ',', '.')}} đ</span>
                                                                    </div>
                                                                    <div><span class="tprice">Price: </span> <span
                                                                            class="price-old">{{number_format($product->price, 0, ',', '.')}} đ </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="box-pagination form-group">
                                                <div class="col-md-12 pagination">
                                                    {{ $productsByParentCategory->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                                                </div>
{{--                                                <ul class="pagination">--}}
{{--                                                </ul>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                            <h1>Ui, Tiếc Quá !</h1>
                            <p>Danh Mục này đang trống!</p>
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
                $('.view-mode .list-view button').bind("click", function () {
                    if ($(this).is(".active")) {
                        return false;
                    }
                    $.cookie('listingType', $(this).is(".grid") ? 'grid' : 'list', {
                        path: '/'
                    });
                    location.reload();
                });
            </script>
            <script type="text/javascript">
                $('.products-list .product-layout .caption h4').matchHeight();
                $('.products-list .product-layout .caption .price').matchHeight();
            </script>
            <script type="text/javascript">
                $('.grid .product-layout .right-block').matchHeight();
            </script>
            <script>
                $(document).ready(function() {
                    $('#input-sort').on('change', function() {
                        var selectedOption = $(this).val();
                        if (selectedOption) {
                            window.location.href = selectedOption;
                        }
                    });
                });

            </script>
@endsection
