<?php

// app/Constants/OrderConstants.php

namespace App\Constants;

class OrderConstants
{
    const ORDERSSTATUSES = [
        1 => ['status' => 'Chờ xác nhận', 'color' => 'blue'], // khi shipping_fee = 0
        2 => ['status' => 'Đã xác nhận', 'color' => 'green'], // khi shipping_fee = 0
        3 => ['status' => 'Đang vận chuyển', 'color' => 'orange'],
        4 => ['status' => 'Đã giao hàng', 'color' => 'purple'],
        5 => ['status' => 'Khách yêu cầu Hủy', 'color' => 'yellow'],
        6 => ['status' => 'Đã Hủy (khách yc hủy)', 'color' => 'red'],
        7 => ['status' => 'Đã Hủy (Hết hàng)', 'color' => 'grey'],
    ];
    const STATUSCOLORS = [
        'Chờ xác nhận' => '#007bff',        // Blue
        'Đã xác nhận' => '#28a745',         // Green
        'Đang vận chuyển' => '#fd7e14',     // Orange
        'Đã giao hàng' => '#6f42c1',        // Purple
        'Khách yêu cầu Hủy' => '#ffc107',   // Yellow
        'Đã Hủy (khách yc hủy)' => '#dc3545',// Red
        'Đã Hủy (Hết hàng)' => '#6c757d',   // Grey
        'Chưa Thanh Toán' => '#dc3545',     // Red
        'Đã thanh toán Phí Ship' => '#fd7e14',// Orange
        'Đã thanh toán Tiền Hàng' => '#ffc107',// Yellow
        'Đã thanh toán toàn bộ' => '#28a745',// Green
    ];

    const PAYMENTSTATUSES = [
        1 => ['status' => 'Chưa Thanh Toán', 'color' => 'red'], // khi shipping_fee = 0
        2 => ['status' => 'Đã thanh toán Phí Ship', 'color' => 'orange'],
        3 => ['status' => 'Đã thanh toán Tiền Hàng', 'color' => 'yellow'],
        4 => ['status' => 'Đã thanh toán toàn bộ', 'color' => 'green'], // khi shipping_fee != 0
    ];

//    const PAYMENT_METHODS = [
//        'cod' => 'thanh toán khi nhận hàng',
//        'bank_transfer' => 'chuyển khoản ngân hàng',
//        'onepay_atm' => 'thanh toán qua ví điện tử MOMO, ZaloPay, VNPay',
//        'onepay_credit' => 'quẹt thẻ thanh toán vnpay QR',
//    ];

    const DELIVERYMETHODS = [
//        nhanh tiets kiệm hỏa tốc hỏa tốc hẹn giờ..
    ];
    const PRODUCTSTATUSES = [
//        CŨ MỚI SECOND HAND MOI 99%
    ];
    const DELIVERYUNITS = [
//        VIETTELPOST ...
    ];
}
