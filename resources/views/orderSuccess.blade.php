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
            <div class="container" id="container">
                <div class="notification">
                    <h1>Đơn Hàng Của Bạn Đã Được Xử Lý !</h1>
                    <p>Đơn hàng của bạn đã được xử lý thành công.</p>
                    <p>Nếu có bất kỳ thắc mắc gì, vui lòng chuyển cho chúng tôi.</p>
                    <p>Cảm ơn bạn đã mua hàng tại cửa hàng online của chúng tôi.</p>
                    <p>Số đơn hàng của bạn là: #{{$order->order_code}}</p>
                    <button>Tiếp tục</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('this-js-library')
@endsection
@section('this-js')
@endsection
