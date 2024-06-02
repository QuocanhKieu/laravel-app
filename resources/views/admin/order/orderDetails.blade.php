@extends('admin.layouts.admin')
@section('title')
    <title>Danh Sách Đơn Hàng</title>
@endsection
@section('this-css')
    <link rel="stylesheet" href="{{asset('admins/css/select2.min.css')}}">
    <style>
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
        .deliveryFeeInput {
            max-width: 90px; padding-block: 0;
            height: auto !important;
        }
    </style>
@endsection
@section('content')
{{--    @php--}}
{{--        $ORDERS_STATUSES = App\Constants\OrderConstants::ORDERSSTATUSES;--}}
{{--        $PAYMENT_STATUSES = App\Constants\OrderConstants::PAYMENTSTATUSES;--}}
{{--        $STATUS_COLORS = App\Constants\OrderConstants::STATUSCOLORS;--}}
{{--    @endphp--}}
        <div class="content-wrapper">
        <!-- Content Header (Page header) -->
{{--        <div style="display: flex; justify-content: end" >    {{(explode('.',request()->route()->getName())[0]). '.' .'search'}}--}}
        @include('admin.partials.content-header',['name' => 'Danh Sách Orders', 'key' => 'Chi tiết đơn hàng','url' => route('orders')])
{{--            breadCrumb--}}
        <div class="content">
            <div class="container-fluid ">
                <div class="row order_details">
                    <div class="div col-md-12">
                        <div class="card">
                            <h1 class="">Mã Đơn hàng: #{{$order->order_code}}</h1>
                            <div class="row">
                                <div class="div col-md-12">
                                <h1>Thông tin Khách Hàng và Địa Chỉ Giao Hàng</h1>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Province</th>
                                        <th scope="col">District</th>
                                        <th scope="col">Ward</th>
                                        <th scope="col">Detail Address</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $province = $orderDetail->province;
                                            $district = $orderDetail->district;
                                        @endphp
                                        <tr>
                                            <td>{{$orderDetail->name}}</td>
                                            <td>{{$orderDetail->phone_number}}</td>
                                            <td>{{$orderDetail->email}}</td>
                                            <td>{{$province->full_name}}</td>
                                            <td>{{$district->full_name}}</td>
                                            <td>{{$orderDetail->ward}}</td>
                                            <td>{{$orderDetail->delivery_address_detail}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                    <hr>
                                    <h1>Thông tin Đơn Hàng</h1>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">Order ID</th>
                                            <th scope="col">Order Code</th>
                                            <th scope="col">Customer Note</th>
                                            <th scope="col">Staff Note</th>
                                            <th scope="col">Cancel Reason</th>
                                            <th scope="col">Order status</th>
                                            <th scope="col">Total quantity</th>
                                            <th scope="col">Sub Total Amount</th>
                                            <th scope="col">Total Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>{{$order->id}}</td>
                                            <td>{{$order->order_code}}</td>
                                            <td>{{$order->order_note}}</td>
                                            <td>{{$order->staff_note}}</td>
                                            <td>{{$order->cancel_reason}}</td>
                                            <td>{{$order->order_status}}</td>
                                            <td>{{$order->total_quantity}}</td>
                                            <td>{{number_format($order->sub_total_amount, 0, ',', '.')}} đ</td>
                                            <td>{{number_format($order->total_amount, 0, ',', '.')}} đ</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <h1>Thông tin Thanh Toán</h1>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">sub_total_amount</th>
                                            <th scope="col">total_discount</th>
                                            <th scope="col">total_tax</th>
                                            <th scope="col">delivery_fee</th>
                                            <th scope="col">total_amount</th>
                                            <th scope="col">pending_payment</th>
                                            <th scope="col">payment_status</th>
                                            <th scope="col">payment_method</th>
                                            <th scope="col">billing_account_info</th>
                                            <th scope="col">Customer Note</th>
                                            <th scope="col">Staff Note</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>{{number_format($order->sub_total_amount, 0, ',', '.')}} đ</td>
                                            <td>{{number_format($order->total_discount, 0, ',', '.')}} đ</td>
                                            <td>{{number_format($order->total_tax, 0, ',', '.')}} đ</td>
                                            <td>{{number_format($order->delivery_fee, 0, ',', '.')}} đ</td>
                                            <td>{{number_format($order->total_amount, 0, ',', '.')}} đ</td>
                                            <td>{{number_format($order->pending_payment, 0, ',', '.')}} đ</td>
                                            <td>{{$order->payment_status}}</td>
                                            <td>{{$order->payment_method}}</td>
                                            <td>{{$billingInfo?$billingInfo->billing_account_info:''}}</td>
                                            <td>{{$order->order_note}}</td>
                                            <td>{{$order->staff_note}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <h1>Thông tin Vận Chuyển và Mã Vận Đơn</h1>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">order_code</th>
                                            <th scope="col">delivery_unit</th>
                                            <th scope="col">delivery_code</th>
                                            <th scope="col">delivery_method</th>
                                            <th scope="col">real_delivery_fee</th>
                                            <th scope="col">total_amount</th>
                                            <th scope="col">created_at</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>{{$shippingInfo?$shippingInfo->order_code:''}}</td>
                                            <td>{{$shippingInfo?$shippingInfo->delivery_unit:''}}</td>
                                            <td>{{$shippingInfo?$shippingInfo->delivery_code:''}}</td>
                                            <td>{{$shippingInfo?$shippingInfo->delivery_method:''}}</td>
                                            <td>{{$shippingInfo?number_format($shippingInfo->real_delivery_fee, 0, ',', '.') :0}} đ</td>
                                            <td>{{number_format($order->total_amount, 0, ',', '.')}} đ</td>
                                            <td>{{$shippingInfo?$shippingInfo->created_at->format('H:i d/m/Y'):''}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <h1>Thông tin Sản Phẩm</h1>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">product_id </th>
                                            <th scope="col">product_image</th>
                                            <th scope="col">product_sku</th>
                                            <th scope="col">product_name</th>
                                            <th scope="col">Size</th>
                                            <th scope="col">quantity</th>
                                            <th scope="col">price</th>
                                            <th scope="col">total_price</th>
                                            <th scope="col">status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orderItems  as $orderItem)
                                            @php
                                            $product = $orderItem->product;
                                            $size = $orderItem->size;
                                            @endphp
                                        <tr>
                                            <td>{{$orderItem->product_id}}</td>
                                            <td><img src="{{asset($product->feature_image_path)}}" style="max-width:75px"></td>
                                            <td>{{$product->sku}}</td>
                                            <td>{{$product->name}}</td>
                                            <td>{{$size->name}}</td>
                                            <td>{{$orderItem->quantity}}</td>
                                            <td>{{$orderItem->price}}</td>
                                            <td>{{$orderItem->total_price}}</td>
                                            <td>Hàng Mới</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
        </div>
@endsection
@section('this-js')
    <script type="text/javascript">

            $(document).ready(function() {
                // Event listener for change on .payment-status selects
                $('.payment-status').change(function() {
                    var $select = $(this);
                    var $hiddenInput = $select.siblings('.previous-payment-status'); // Find corresponding hidden input
                    var previousValue = $hiddenInput.val(); // Get previous selected value from hidden input
                    var newValue = $select.val(); // Get current selected value

                    // Show confirmation dialog using alertify
                    alertify.confirm('Confirm Message', 'Are you sure you want to change Payment Status?',
                        function() { // On confirm
                            var orderId = $select.data('order-id');
                            var newStatus = $select.val();

                            // Example of AJAX request to update order status
                            var url = '{{ route('orders.updatePaymentStatus') }}';
                            $.ajax({
                                url: url,
                                method: 'PUT',
                                data: {
                                    orderId: orderId,
                                    newStatus: newStatus
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    if (response.success) {
                                        alertify.success(response.message);
                                        // Update hidden input with new value after successful update
                                        $hiddenInput.val(newStatus);
                                        $('#deliveryFee_' + orderId).blur();

                                    } else {
                                        alertify.error(response.message);
                                        // Revert to previous value on error
                                        $select.val(previousValue);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText);
                                    alertify.error(xhr.responseText);
                                    // Revert to previous value on error
                                    $select.val(previousValue);
                                }
                            });
                        },
                        function() { // On cancel
                            // Revert to previous value
                            $select.val(previousValue);
                            alertify.error('Cancel');
                        }
                    );
                });

                $('.order-status').change(function() {
                    var $select = $(this);
                    var $hiddenInput = $select.siblings('.previous-order-status'); // Find corresponding hidden input
                    var previousValue = $hiddenInput.val(); // Get previous selected value from hidden input

                    // Show confirmation dialog using alertify
                    alertify.confirm('Confirm Message', 'Are you sure you want to change Order Status?',
                        function() { // On confirm
                            var orderId = $select.data('order-id');
                            var newStatus = $select.val();

                            // Example of AJAX request to update order status
                            var url = '{{ route('orders.updateOrderStatus') }}';
                            $.ajax({
                                url: url,
                                method: 'PUT',
                                data: {
                                    orderId: orderId,
                                    newStatus: newStatus
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    if (response.success) {
                                        alertify.success(response.message);
                                        $('#actionOptions_' + orderId).html(response.view);
                                        // Update hidden input with new value after successful update
                                        $hiddenInput.val(newStatus);
                                    } else {
                                        alertify.error(response.message);
                                        // Revert to previous value on error
                                        $select.val(previousValue);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText);
                                    alertify.error(xhr.responseText);
                                    // Revert to previous value on error
                                    $select.val(previousValue);
                                }
                            });
                        },
                        function() { // On cancel
                            // Revert to previous value
                            $select.val(previousValue);
                            alertify.error('Cancel');
                        }
                    );
                });


            });

        $(document).ready(function() {
            $('.delete-order').click(function(e) {
                e.preventDefault();
                var $this = $(this);
                alertify.confirm('Confirm Message', 'Are you sure you want to delete this order?',
                    function() {
                        window.location.href = $this.data('url');
                    },
                    function() {
                        alertify.error('Cancel');
                    }
                );
            });
            $('.deliveryFeeInput').blur(function(e) {
                var $this = $(this);
                var $hiddenInput = $this.siblings('.previous-delivery_fee'); // Find corresponding hidden input
                var previousValue = $hiddenInput.val(); // Get previous selected value from hidden input
                alertify.confirm('Confirm Message', 'Are you sure you want to change Delivery Fee?',
                    function() { // On confirm
                        var orderId = $this.data('orderid');
                        var newDeliveryFee = $this.val();
                        alertify.success(orderId+'/'+newDeliveryFee+'/'+previousValue);
                        // Example of AJAX request to update order status
                        var url = '{{ route('orders.updateDeliveryFee') }}';
                        $.ajax({
                            url: url,
                            method: 'PUT',
                            data: {
                                orderId: orderId,
                                newDeliveryFee: newDeliveryFee
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    alertify.success(response.message+ response.totalAmount + response.pendingPayment);
                                    $('#totalAmount_' + orderId).text(response.totalAmount);
                                    $('#pendingPayment_' + orderId).text(response.pendingPayment);

                                    // Update hidden input with new value after successful update
                                    $hiddenInput.val(newDeliveryFee);
                                } else {
                                    alertify.error(response.message);
                                    // Revert to previous value on error
                                    $this.val(previousValue);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                alertify.error(xhr.responseText);
                                // Revert to previous value on error
                                $this.val(previousValue);
                            }
                        });
                    },
                    function() { // On cancel
                        // Revert to previous value
                        $this.val(previousValue);
                        alertify.error('Cancel');
                    }
                );
            });
            $('.deliveryFeeInput').on('keypress', function(e) {
                if(e.which === 13) {
                    // Enter key pressed
                    $(this).blur();
                }
            });

        });
            function restoreOrder(button, order_id) {
                // Confirm before sending the AJAX request
                alertify.confirm('Confirm Message', 'Are you sure you want to restore this order?',
                    function() {
                        // Send an AJAX request to restore the order
                        var url = '{{ route('orders.restore') }}';
                        $.ajax({
                            url: url,
                            type: "put",
                            data: {
                                order_id: order_id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                if (response.success) {
                                    var deleteLink = $('<a>', {
                                        href: "{{ route('orders.delete', ':order_id') }}".replace(':order_id', order_id),
                                        class: 'btn btn-danger',
                                        html: '<i class="fas fa-trash"></i>'
                                    });
                                    $(button).replaceWith(deleteLink);
                                    alertify.success(response.message);

                                } else {
                                    alertify.error(response.message);
                                }
                            },
                            error: function (xhr, status, error) {
                                alertify.error('Restore Order thất bại'); // Show generic error message
                                console.error(xhr.responseText); // Log the error for debugging
                            }
                        });
                    },
                    function() {
                        alertify.error('Cancel');
                    }
                );
            }
    </script>
@endsection





