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

        .button, .btn {
            padding: 6px 12px;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        @include('partials.contentHeader', ['breadcrumbs' => $breadcrumbs])
        <!-- /.content-header -->
        <div class="content">
            @if (Session::has('cart') && is_array(Session::get('cart')['products']) && count(Session::get('cart')['products']) > 0)
                <div class="container" id="container">
                    <div class="checkout-page">
                        <div class="row">
                            <div class="col-md-4">
                                <a href="https://drake.vn/" class="btn btn-back-to-home"><i
                                        class="fa fa-angle-double-left"></i> Chọn Thêm Sản Phẩm?</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row">
                            <div id="content" class="col-sm-12">
                                <div id="d_quickcheckout">
                                    <div class="row">
                                        <div class="col-md-12"></div>
                                    </div>
                                    <div class="row">
                                        <div class="qc-col-1 col-md-4">
                                            <div id="payment_address" class="qc-step" data-col="1" data-row="2">
                                                <div class="">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                            <span class="icon">
                                                                <i class="fa fa-book"></i>
                                                            </span>
                                                                <span class="text">Địa chỉ</span>
                                                            </h4>
                                                        </div>
                                                        <div class="panel-body">
                                                            <form id="payment_address_form" class="form-horizontal"
                                                                  novalidate="novalidate">
                                                                <div id="payment_address_name_input"
                                                                     class="text-input form-group  sort-item   required"
                                                                     data-sort="0">
                                                                    <div class="col-xs-5">
                                                                        <label class="control-label"
                                                                               for="payment_address_name">
                                                                            <span class="text"
                                                                                  title=""> Họ và Tên:</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-xs-7">
                                                                        <input type="text"
                                                                               name="payment_address_name"
                                                                               id="payment_address_name" value=""
                                                                               class="form-control  required firstname"
                                                                               autocomplete="on"
                                                                               placeholder="* Họ và Tên"
                                                                               data-rule-minlength="1"
                                                                               data-msg-minlength="Tên phải từ 1 đến 32 kí tự!"
                                                                               data-rule-maxlength="32"
                                                                               data-msg-maxlength="Tên phải từ 1 đến 32 kí tự!">
                                                                        <div id="payment_address_name-error" class="text-danger"></div>
                                                                    </div>
                                                                </div>
                                                                <div id="payment_address_email_input"
                                                                     class="text-input form-group  sort-item   required"
                                                                     data-sort="3">
                                                                    <div class="col-xs-5">
                                                                        <label class="control-label"
                                                                               for="payment_address_email">
                                                                            <span class="text" title=""> E-Mail:</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-xs-7">
                                                                        <input type="email" name="payment_address_email"
                                                                               id="payment_address_email" value=""
                                                                               class="form-control  required email"
                                                                               autocomplete="on" placeholder=" E-Mail Không bắt buộc"
                                                                               data-rule-minlength="3"
                                                                               data-msg-minlength="[object Object]"
                                                                               data-rule-maxlength="96"
                                                                               data-msg-maxlength="[object Object]"
                                                                               data-rule-remote="index.php?route=d_quickcheckout/field/validate_regex&amp;regex=%2F%5E%5B%5E%5C%40%5D%2B%40.*%5C.%5Ba-z%5D%7B2%2C6%7D%24%2Fi"
                                                                               data-msg-remote="E-Mail không hợp lệ!">
                                                                        <div id="payment_address_email-error" class="text-danger"></div>
                                                                    </div>
                                                                </div>
                                                                <div id="payment_address_telephone_input"
                                                                     class="text-input form-group  sort-item   required"
                                                                     data-sort="5">
                                                                    <div class="col-xs-5">
                                                                        <label class="control-label"
                                                                               for="payment_address_telephone">
                                                                            <span class="text"
                                                                                  title=""> Điện thoại:</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-xs-7">
                                                                        <input type="tel"
                                                                               name="payment_address_telephone"
                                                                               id="payment_address_telephone" value=""
                                                                               class="form-control  required telephone  "
                                                                               autocomplete="on"
                                                                               required
                                                                               data-telephone_countries=""
                                                                               data-telephone_preferred_countries=""
                                                                               placeholder="* Nhập Số Điện Thoại" data-rule-minlength="10"
                                                                               data-msg-minlength="Điện thoại phải từ 10 đến 11 kí tự!"
                                                                               data-rule-maxlength="11"
                                                                               data-msg-maxlength="Điện thoại phải từ 10 đến 11 kí tự!"
                                                                               data-msg-telephone="Please enter a valid telephone number">
                                                                        <div id="payment_address_telephone-error" class="text-danger"></div>
                                                                    </div>

                                                                </div>
                                                                <div id="payment_address_telephone_input"
                                                                     class="text-input form-group  sort-item   required"
                                                                     data-sort="5">

                                                                    <div class="col-xs-5">
                                                                        <label class="control-label" style="text-align: left"
                                                                               for="payment_address_telephone_confirm">
                                                                            <span class="text"
                                                                                  title="">Xác Nhận Số Điện thoại:</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-xs-7">
                                                                        <input type="tel" name="payment_address_telephone_confirm" id="payment_address_telephone_confirm" class="form-control required telephone" placeholder="* Nhập Lại Số Điện Thoại" required>
                                                                        <div id="payment_address_telephone_confirm-error" class="text-danger"></div>
                                                                    </div>

                                                                </div>
                                                                <div id="payment_address_province_input"
                                                                     class="select-input form-group  sort-item  country required"
                                                                     data-sort="14">
                                                                    <div class="col-xs-5">
                                                                        <label class="control-label"
                                                                               for="payment_address_province">
                                                                            <span class="text"
                                                                                  title="">Tỉnh Thành:</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-xs-7">
                                                                        <select name="payment_address_province"
                                                                                required="required"
                                                                                id="payment_address_province"
                                                                                class="form-control required country_id"
                                                                                autocomplete="on">
                                                                            <option value=""> --- Chọn ---</option>
                                                                            @foreach($provinces as $province)
                                                                            <option value="{{$province->code}}">{{$province->full_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <div id="payment_address_province-error" class="text-danger"></div>
                                                                    </div>
                                                                </div>
                                                                <div id="payment_address_district_input"
                                                                     class="select-input form-group  sort-item  zone required"
                                                                     data-sort="15">
                                                                    <div class="col-xs-5">
                                                                        <label class="control-label"
                                                                               for="payment_address_district">
                                                                            <span class="text"
                                                                                  title="">Quận / Huyện:</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-xs-7">
                                                                        <select name="payment_address_district"
                                                                                required=""
                                                                                id="payment_address_district"
                                                                                class="form-control required zone_id"
                                                                                autocomplete="on">
                                                                            <option value=""> --- Chọn ---</option>
                                                                        </select>
                                                                        <div id="payment_address_district-error" class="text-danger"></div>
                                                                    </div>
                                                                </div>
                                                                <div id="payment_address_ward_input"
                                                                     class="text-input form-group  sort-item   required"
                                                                     data-sort="16">
                                                                    <div class="col-xs-5">
                                                                        <label class="control-label"
                                                                               for="payment_address_ward">
                                                                            <span class="text"
                                                                                  title=""> Xã / Phường:</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-xs-7">
                                                                        <input type="text" name="payment_address_ward"
                                                                               id="payment_address_ward" value=""
                                                                               class="form-control  required city"
                                                                               autocomplete="on"
                                                                               placeholder="* Xã / Phường"
                                                                               data-rule-minlength="2"
                                                                               data-msg-minlength="Xã / Phường phải từ 2 đến 128 kí tự!"
                                                                               data-rule-maxlength="128"
                                                                               data-msg-maxlength="Xã / Phường phải từ 2 đến 128 kí tự!">
                                                                        <div id="payment_address_ward-error" class="text-danger"></div>
                                                                    </div>
                                                                </div>
                                                                <div id="payment_address_address_detail_input"
                                                                     class="text-input form-group  sort-item   required"
                                                                     data-sort="17">
                                                                    <div class="col-xs-5">
                                                                        <label class="control-label"
                                                                               for="payment_address_address_detail">
                                                                            <span class="text" title=""> Địa chỉ:</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-xs-7">
                                                                        <input type="text"
                                                                               name="payment_address_address_detail"
                                                                               id="payment_address_address_detail" value=""
                                                                               class="form-control  required address_1"
                                                                               autocomplete="on" placeholder="* Địa chỉ"
                                                                               data-rule-minlength="3"
                                                                               data-msg-minlength="Địa chỉ dòng 1 phải từ 3 đến 128 kí tự!"
                                                                               data-rule-maxlength="128"
                                                                               data-msg-maxlength="Địa chỉ dòng 1 phải từ 3 đến 128 kí tự!">
                                                                        <div id="payment_address_address_detail-error" class="text-danger"></div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="qc-col-2 col-md-6">
                                                    <div id="shipping_method" class="qc-step" data-col="2" data-row="1">
                                                        <form id="shipping_method_form">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                    <span class="icon">
                                                                        <i class="fa fa-truck"></i>
                                                                    </span>
                                                                        <span class="text">Phương thức giao hàng</span>
                                                                    </h4>
                                                                </div>
                                                                <div class="panel-body">
                                                                    <div id="shipping_method_list">
                                                                        <div class="radio-input radio">
                                                                            <label
                                                                                for="ultimate_shipping.ultimate_shipping_1">

                                                                                <input type="radio"
                                                                                       name="shipping_method"
                                                                                       value="0"
                                                                                       id="ultimate_shipping.ultimate_shipping_1"
                                                                                       checked="checked"
                                                                                       data-refresh="5" class="styled">
                                                                                <span
                                                                                    class="text"><span></span>Liên Hệ</span><span
                                                                                    class="price"></span></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                                <div class="qc-col-3 col-md-6">
                                                    <div id="payment_method" class="qc-step" data-col="3" data-row="1">
                                                        <form  id="payment_method_form">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                    <span class="icon">
                                                                        <i class="fa fa-credit-card"></i>
                                                                    </span>
                                                                        <span class="text">Phương thức thanh toán</span>
                                                                    </h4>
                                                                </div>
                                                                <div class="panel-body">
                                                                    <div id="payment_method_list" class="">

                                                                        <div class="radio-input radio">
                                                                            <label for="cod">
                                                                                <input type="radio"
                                                                                       name="payment_method"
                                                                                       value="cod" id="cod"
                                                                                       checked="checked" class="styled"
                                                                                       data-refresh="6">
                                                                                <span class="text"><span></span></span>
                                                                                Thanh toán khi nhận hàng
                                                                                <span class="price"></span>
                                                                            </label>
                                                                        </div>

                                                                        <div class="radio-input radio">
                                                                            <label for="onepay_atm">
                                                                                <input type="radio"
                                                                                       name="payment_method"
                                                                                       value="onepay_atm"
                                                                                       id="onepay_atm"
                                                                                       class="styled" data-refresh="6">
                                                                                <span class="text"><span></span></span>
                                                                                Thanh toán bằng ATM nội địa (Internet
                                                                                Banking)
                                                                                <span class="price"></span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="radio-input radio">
                                                                            <label for="onepay_credit">
                                                                                <input type="radio"
                                                                                       name="payment_method"
                                                                                       value="onepay_credit"
                                                                                       id="onepay_credit" class="styled"
                                                                                       data-refresh="6">
                                                                                <span class="text"><span></span></span>
                                                                                Thanh toán bằng Credit/Debit Card (VISA,
                                                                                MASTER, JCB, AMEX)
                                                                                <span class="price"></span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="radio-input radio">
                                                                            <label for="bank_transfer">
                                                                                <input type="radio"
                                                                                       name="payment_method"
                                                                                       value="bank_transfer"
                                                                                       id="bank_transfer" class="styled"
                                                                                       data-refresh="6">
                                                                                <span class="text">
                                                                                <span></span>
                                                                            </span>
                                                                                Chuyển khoản ngân hàng
                                                                                <span class="price"></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="qc-col-4 col-md-12">
                                                    <div id="cart_view" class="qc-step" data-col="4" data-row="2">
                                                        <div class="panel panel-default ">
                                                            <div class="panel-heading" style="display:flex; justify-content: space-between;" >
                                                                <h4 class="panel-title">
                                                                <span class="icon">
                                                                    <i class="fa fa-shopping-cart"></i>
                                                                </span>
                                                                    <span class="text">Giỏ hàng </span>
                                                                </h4>
                                                                <h4 class="panel-title">
                                                                    <span class="icon">
                                                                       <i class="fas fa-chevron-left"></i>
                                                                    </span><a href="{{route('cartDisplay')}}" class="text" style="text-decoration: underline;">Chỉnh Sửa Giỏ Hàng</a>
                                                                </h4>
                                                            </div>
                                                            <div class="qc-checkout-product panel-body">
                                                                <table class="table table-bordered qc-cart">
                                                                    <thead>
                                                                    <tr>
                                                                        <td class="qc-image ">Hình ảnh:</td>
                                                                        <td class="qc-name ">Tên sản phẩm:</td>
                                                                        <td class="qc-model hidden-xs hidden">Dòng sản phẩm:
                                                                        </td>
                                                                        <td class="qc-quantity " style="width: 13%">Số lượng:</td>
                                                                        <td class="qc-price hidden-xs ">Đơn Giá:</td>
                                                                        <td class="qc-total ">Tổng cộng:</td>
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
                                                                            $cartTotalPrice =  number_format($cart['cartTotalPrice'], 0, ',', '.');
                                                                        @endphp
                                                                    <tr>
                                                                        <td class="qc-image " style="max-width: 100px; min-width: 80px;">
                                                                            <a href="{{$productDetailRoute}}"
                                                                               data-container="body"
                                                                               data-toggle="popover"
                                                                               data-placement="top"
                                                                               data-content="<img src='{{$feature_image_path}}'; ></a>"
                                                                               data-trigger="hover">
                                                                                <img
                                                                                    src="{{$feature_image_path}}"
                                                                                    class="img-responsive" alt="{{$productName}}"/>
                                                                            </a>
                                                                        </td>
                                                                        <td class="qc-name ">
                                                                            <a href="{{$productDetailRoute}}">
                                                                                {{$productName}}
                                                                            </a>
                                                                            <div> &nbsp;
                                                                                <small>
                                                                                    {{$sizeName}}
                                                                                </small>
                                                                            </div>
                                                                            <div class="qc-name-price visible-xs-block " >
                                                                                <small>
                                                                                    <span class="title">Đơn Giá:</span>
                                                                                    <span class="text">{{$cartItemPrice}} đ</span>
                                                                                </small>
                                                                            </div>
                                                                        </td>
                                                                        <td class="qc-quantity ">
                                                                            <div class="input-group input-group-sm">
                                                                                <input type="text"
                                                                                       value="{{$cartItemQuantity}}"
                                                                                       readonly
                                                                                       class="qc-product-qantity form-control text-center"
                                                                                       name=""
                                                                                       data-refresh="2">
                                                                            </div>
                                                                        </td>
                                                                        <td class="qc-price hidden-xs ">{{$cartItemPrice}} đ</td>
                                                                        <td class="qc-total ">{{$cartItemTotalPrice}} đ</td>
                                                                    </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                                <div class="form-horizontal">
                                                                    <div class=" form-group qc-coupon ">
{{--                                                                        <div class="col-sm-12" id="voucher-error">--}}
{{--                                                                            <div class="alert alert-danger">--}}
{{--                                                                                <i class="fa fa-exclamation-circle"></i> Lỗi: Mã Giảm giá không tồn tại, quá hạn hay đã được sử dụng!--}}
{{--                                                                            </div>--}}
{{--                                                                        </div>--}}
                                                                        <label class="col-sm-4 control-label">
                                                                            Áp dụng mã Giảm giá </label>
                                                                        <div class="col-sm-8">
                                                                            <div class="input-group">
                                                                                <input type="text" value=""
                                                                                       name="coupon"
                                                                                       id="coupon"
                                                                                       placeholder="Áp dụng mã Giảm giá"
                                                                                       class="form-control">
                                                                                <span class="input-group-btn">
                                                                                    <button class="btn btn-primary" id="confirm_coupon" onclick="confirmCoupon(this, {{$cart['cartTotalPrice']}})" type="button"><i
                                                                                            class="fa fa-check"></i></button>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-horizontal qc-totals">
                                                                    <div class="row">
                                                                        <label class="col-sm-9 col-xs-6 control-label">Thành
                                                                            tiền</label>
                                                                        <div
                                                                            class="col-sm-3 col-xs-6 form-control-static text-right">
                                                                            {{$cartTotalPrice}} đ
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <label class="col-sm-9 col-xs-6 control-label">Phí
                                                                            Ship</label>
                                                                        <div
                                                                            class="col-sm-3 col-xs-6 form-control-static text-right">
                                                                            Liên Hệ
                                                                        </div>
                                                                    </div>
                                                                    <div id="totalBlock">
                                                                        <div class="row" id="VoucherApplied">
                                                                            <label
                                                                                class="col-sm-9 col-xs-6 control-label">Mã
                                                                                Giảm Giá
                                                                            </label>
                                                                            <div
                                                                                class="col-sm-3 col-xs-6 form-control-static text-right">
                                                                                0 đ
                                                                            </div>
                                                                            <input type="hidden" name="voucherCode" value="">
                                                                        </div>
                                                                        <div class="row" id="Total">
                                                                            <label
                                                                                class="col-sm-9 col-xs-6 control-label">Tổng
                                                                                cộng </label>
                                                                            <div
                                                                                class="col-sm-3 col-xs-6 form-control-static text-right">
                                                                                {{$cartTotalPrice}} đ
                                                                            </div>
                                                                            <input type="hidden" name="cartTotalPrice" value="{{$cart['cartTotalPrice']}}">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                {{--                                                            <div class="preloader row"><img class="icon"--}}
                                                                {{--                                                                                            src="image/catalog/d_quickcheckout/svg-loaders/puff.svg">--}}
                                                                {{--                                                            </div>--}}

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="payment_view" class="qc-step" data-col="4" data-row="2">
                                                        <h2>HƯỚNG DẪN THANH TOÁN QUA NGÂN HÀNG</h2>
                                                        <p><b><font color="GREEN">Bạn vui lòng chuyển tiền Mua hàng và
                                                                    tiền Cước vận chuyển (nếu có) vào 1 trong các tài
                                                                    khoản Ngân hàng sau:</font></b></p>
                                                        <div class="well well-sm">
                                                            <p>Vietcombank <br>
                                                                0721000628739 <br>
                                                                Công ty TNHH Phân Phối và Phát Triển Thương Mại Đăng
                                                                Khoa<br>
                                                                Chi nhánh Kỳ Đồng<br>
                                                                <br>
                                                                Sau khi chuyển tiền, Quý khách liên hệ bộ phận chăm sóc
                                                                khách hàng để được xác nhận đã thanh toán xong tiền hàng
                                                                và tiền cước vận chuyển (nếu có). Trong vòng 1-2 ngày sẽ
                                                                đảm bảo đủ hàng hoặc chấp nhận giá đợt sale (nếu có),
                                                                sau 3 ngày Drake sẽ có quyền từ chối đơn hàng.</p>
                                                            <p></p>
                                                        </div>
                                                    </div>
                                                    <div id="confirm_view" class="qc-step" data-col="4" data-row="2">
                                                        <div id="confirm_wrap">
                                                            <div class="panel panel-default">
                                                                <div class="panel-body">
                                                                    <form id="confirm_form" class="form-horizontal"
                                                                          novalidate="novalidate">
                                                                        <div id="confirm_comment_input"
                                                                             class="text-input form-group  sort-item   "
                                                                             data-sort="0">
                                                                            <div class="col-xs-12">
                                                                                <label class="control-label"
                                                                                       for="order_note">
                                                                                    <span class="text" title=""> Thêm ghi chú cho đơn hàng:</span>
                                                                                </label>
                                                                            </div>
                                                                            <div class="col-xs-12">
                                                                            <textarea name="order_note"
                                                                                      id="order_note"
                                                                                      class="form-control validate not-required textarea comment"
                                                                                      autocomplete="on"
                                                                                      placeholder=" Thêm ghi chú cho đơn hàng"
                                                                                      data-rule-minlength="1"
                                                                                      data-msg-minlength="Please fill in the comment to the order"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                    <button id="qc_confirm_order"
                                                                            class="btn btn-primary btn-lg btn-block ">
                                                                        Xác
                                                                        nhận đơn hàng
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
                            <h1>Giỏ Hàng</h1>
                            <p>Giỏ hàng của bạn đang trống!</p>
                            <a href="{{route('home')}}" class="btn btn-primary" title="Tiếp tục">Tiếp tục</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('this-js-library')
@endsection
@section('this-js')
    <script type="text/javascript">
        function confirmCoupon(thisEl, totalPrice) {
            var $this = $(thisEl);
            var coupon = $('#coupon').val();
            if (coupon) {
                var url = '{{ route('checkCoupon') }}';
                $.ajax({
                    url: url,
                    type: 'POST', // Change to POST method as we are sending data
                    data: {
                        _token: '{{ csrf_token() }}', // Include CSRF token for security
                        voucherCode: coupon,
                        totalPrice: totalPrice
                    },
                    beforeSend: function () {
                        $this.button('loading'); // better bootstrap method than $this.prop('disabled', true);
                    },
                    complete: function () {
                        $this.button('reset');
                    },
                    success: function (response) {
                        if (response.success) {
                            $("#totalBlock").html(response.view); // Update the cart view with rendered HTML
                            alertify.success('Áp dụng voucher thành công');
                        } else {
                            alertify.error(response.message); // Show error message if product could not be added
                        }
                    },
                    error: function (xhr, status, error) {
                        alertify.error('Áp dụng voucher Thất Bại'); // Show generic error message
                        console.error(xhr.responseText); // Log the error for debugging
                    }
                });
            } else {

                alertify.success('Vui lòng nhập Mã Giảm Giá');
            }
        }

        // click confirmVoucher programmatically
        $(document).ready(function () {
            // When the quantity input loses focus, trigger the update button click event
            $('#coupon').on('blur', function () {
                var $confirmCounponBtn = $('#confirm_coupon');
                $confirmCounponBtn.trigger('click');
            });
            $('#coupon').keypress(function (e) {
                if (e.which === 13) {  // 13 is the ASCII code for the Enter key
                    // Your code here
                    var $this = $(this);
                    $this.blur();
                    // alertify.success('You pressed Enter!');
                    e.preventDefault();  // Prevent the default action of the Enter key
                }
            });
        });
        // provinces onchange
        $(document).ready(function () {
            $('#payment_address_province').change(function() {
                var province_code = $(this).val();
                if (province_code) {
                    $.ajax({
                        url: '{{ route('get.districts') }}',
                        type: 'GET',
                        data: {
                            _token: '{{ csrf_token() }}',
                            province_code: province_code
                        },
                        success: function(response) {
                            if (response.success) {
                                $("#payment_address_district").html(response.view); // Update the cart view with rendered HTML
                            } else {
                                alertify.error(response.message); // Show error message if product could not be added
                            }
                        }
                    });
                } else {
                    $("#payment_address_district").html('<option value=""> --- Chọn ---</option>');
                }
            });
        });
        //individual fields validation
        $(document).ready(function() {
            // Hide all error message containers initially
            $('.text-danger').hide();
            // Function to validate and display errors
            function validateAndDisplayErrors(input) {
                // Clear previous error message for this input and hide it
                var errorDiv = $('#' + input.id + '-error');
                errorDiv.html('').hide();

                // Perform AJAX request to validate only this input
                var url = '{{route('validateCheckoutField')}}';
                $.ajax({
                    type: 'GET',
                    url: url, // Laravel route for individual input validation
                    data: $('#'+ input.form.id).serialize(), // Serialize entire form data
                    dataType: 'json', // Expect JSON response from server
                    success: function (response) {
                        if(response.success) {
                            alertify.success('All fields are valid');
                        }else {
                            if (response.errors && response.errors[input.name]) {
                                errorDiv.html(response.errors[input.name][0]).show(); // Show error message
                            }
                        }
                        // Check if this input has errors

                    },
                    error: function (xhr, status, error) {
                        // Handle AJAX error
                        console.error('AJAX Error: ' + error);
                    }
                });
            }

            // Bind blur event handler to each input field for validation
            $('#payment_address_form input').blur(function () {
                // alertify.success('input blurred');
                validateAndDisplayErrors(this);
            });
        });
        //final validtion all fields before move to next route
        $('#qc_confirm_order').click(function() {
            // Clear previous error messages and hide them
            $('.text-danger').html('').hide();

            // Serialize form data
            var formData = $('#payment_address_form').serialize();

            // Manually serialize extra fields outside the form
            var extraFieldData = {
                shipping_method:  $('input[name="shipping_method"]:checked').val(),
                payment_method:  $('input[name="payment_method"]:checked').val(),
                voucher_code: $('input[name="voucherCode"]').val(),
                order_note: $('textarea[name="order_note"]').val(),
                cartTotalPrice: $('input[name="cartTotalPrice"]').val(),
            };

            // Combine both serialized data
            var combinedData = formData + '&' + $.param(extraFieldData);
            // alertify.success(combinedData);
            // console.log(combinedData);
            // return false;
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            // Perform AJAX request to process the entire form
            var url = '{{route('processCheckout')}}';
            $.ajax({
                type: 'POST',
                url: url, // Laravel route for processing the form
                data: combinedData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Pass CSRF token via header
                },
                success: function(response) {
                    // Handle success response
                    if (response.success) {
                        // Redirect to success page or show success message
                        alertify.success('check whole, all valid');
                        window.location.href = response.redirect_url;
                    } else {
                        // Display Laravel validation errors if any
                        if (response.errors) {
                            $.each(response.errors, function(key, value) {
                                $('#' + key + '-error').html(value[0]).show(); // Show error message
                            });
                        }
                        alertify.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle AJAX error
                    console.error('AJAX Error: ' + error);
                }
            });
        });
    </script>
@endsection
