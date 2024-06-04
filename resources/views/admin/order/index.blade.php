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
        .color-indicator {
            height: 8px;
            width: 100%;
            /* border-radius: 50%; */
            position: absolute;
            top: 0;
        }
        .cancelReasonBox {
            position: absolute;
            top: -22px;
            right: -25px;
            font-size: 24px;
            color: #f14d68;
        }
        .staffNote{
            vertical-align: text-top;
            font-size: 21px;
            margin-left: 10px;

        }
        td, th{
            vertical-align: middle !important;
        }
        #loading-spinner {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000; /* Ensure it is above other content */
        }

        .spinner {
            border: 16px solid #f3f3f3; /* Light grey */
            border-top: 16px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .staffNoteWarning {
            position: absolute;
            font-size: 16px;
            top: -7px;
            right: -8px;
            color: #ff031b;
        }
        .orderNoteDisplay {
            position: absolute;
            font-size: 22px;
            top: -36px;
            right: -16px;
        }
        .shippingInfoIcon {
            color: #22d271;
        }
        #order_status, #payment_status {
            min-width: 300px;
            width: 30%;
        }
        /*.delete-order {*/
        /*    padding: 5px;*/
        /*}*/
    </style>
@endsection
@section('content')
    @php
        $ORDERS_STATUSES = App\Constants\OrderConstants::ORDERSSTATUSES;
        $PAYMENT_STATUSES = App\Constants\OrderConstants::PAYMENTSTATUSES;
        $STATUS_COLORS = App\Constants\OrderConstants::STATUSCOLORS;
    @endphp
        <div class="content-wrapper">
        @include('admin.partials.content-header',['name' => '', 'key' => 'Danh Sánh Đơn Hàng','url' => ''])
            <form class="form-inline ml-3" method="GET" action="{{ route('orders') }}">
                <input type="hidden" name="sort_by" value="{{ request('sort_by', $sortBy) }}">
                <input type="hidden" name="sort_direction" value="{{ request('sort_direction', $sortDirection) }}">
                <input type="hidden" name="show_deleted" value="{{ request('show_deleted', $showDeleted) }}">
                <input type="hidden" name="order_status" value="{{ request('order_status', $order_status) }}">
                <input type="hidden" name="payment_status" value="{{ request('payment_status', $payment_status) }}">
                <input type="hidden" name="page" value="{{ $orders->currentPage() }}">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" value="{{ request('search_term', $searchTerm) }}" name="search_term">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        <div class="content">
            <form method="GET" action="{{ route('orders') }}" style="padding-left: 13px;">
                <input type="hidden" name="sort_by" value="{{ request('sort_by', $sortBy) }}">
                <input type="hidden" name="sort_direction" value="{{ request('sort_direction', $sortDirection) }}">
                <input type="hidden" name="search_term" value="{{ request('search_term', $searchTerm) }}">
                <input type="hidden" name="page" value="{{ $orders->currentPage() }}">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="show_deleted" id="show_deleted" value="yes" {{ $showDeleted === 'yes' ? 'checked' : '' }}>
                    <label class="form-check-label" for="show_deleted">
                        Hiển thị đơn hàng đã xóa
                    </label>
                </div>

                <div class="form-group">
                    <label for="order_status">Trạng thái đơn hàng</label>
                    <select class="form-control" name="order_status" id="order_status">
                        <option value="">Tất cả</option>
                        @foreach($ORDERS_STATUSES as $key => $data)
                            <option value="{{$data['status']}}" {{ $data['status'] == $order_status ? 'selected' : '' }}>
                                {{ $data['status'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="payment_status">Trạng thái thanh toán</label>
                    <select class="form-control" name="payment_status" id="payment_status">
                        <option value="">Tất cả</option>
                        @foreach($PAYMENT_STATUSES as $key => $data)
                            <option value="{{$data['status']}}" {{ $data['status'] == $payment_status ? 'selected' : '' }}>
                                {{ $data['status'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Lọc</button>
            </form>
            <div class="container-fluid">
                <div class="row">
                    <div class="div col-md-12">
                        <div id="cartsTable">
                            <table class="table">
                                <thead>
                                <tr>
                                    @php
                                        $columns = [
                                         'id' => ['name' => 'ID|Mã đơn hàng', 'sortable' => true],
                                         'user_id' => ['name' => 'UserID|Họ và tên', 'sortable' => true],
                                         'sub_total_amount' => ['name' => 'Tiền Hàng', 'sortable' => true],
                                         'total_discount' => ['name' => 'Giảm giá', 'sortable' => true],
                                         'delivery_fee' => ['name' => 'Phí Ship', 'sortable' => true],
                                         'total_amount' => ['name' => 'Tổng chi phí', 'sortable' => true],
                                         'pending_payment' => ['name' => 'Cần thanh toán', 'sortable' => true],
                                         'payment_status' => ['name' => 'Trạng thái thanh toán', 'sortable' => true],
                                         'order_status' => ['name' => 'Trạng thái đơn hàng', 'sortable' => true],
                                         'created_at' => ['name' => 'Ngày tạo', 'sortable' => true],
                                     ];
                                    @endphp

                                    @foreach($columns as $column => $details)
                                        <th>
                                            @if($details['sortable'])
                                                <a href="{{ route('orders', [
                                                        'sort_by' => $column,
                                                        'sort_direction' => $sortBy === $column && $sortDirection === 'asc' ? 'desc' : 'asc',
                                                        'search_term' => request('search_term', $searchTerm),
                                                        'show_deleted' => request('show_deleted', $showDeleted),
                                                        'page' => $orders->currentPage(), // Preserve current page
                                                        'order_status' => $order_status,
                                                        'payment_status' => $payment_status
                                                    ]) }}">
                                                    {{ $details['name'] }}
                                                    @if($sortBy === $column)
                                                        <i class="fa fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                                    @endif
                                                </a>
                                            @else
                                                {{ $details['name'] }}
                                            @endif
                                        </th>
                                    @endforeach
                                        <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    @php
                                        $orderDetail = $order->orderDetail;
                                        $voucher = $order->voucher;
                                        $shippingInfo = $order->shippingInfo;

                                        $orderIdOrderCode = $order->id.'|#'.$order->order_code;
                                        $userIdCustomerName = ($order->user_id??'Guest').'|'.$orderDetail->name;
                                        $subTotal = $order->sub_total_amount;//tiền hàng
                                        $totalDiscount = $order->total_discount ?? 0;
                                        $deliveryFee = $order->delivery_fee ?? 0;
                                        $totalAmount = $order->total_amount;
                                        $pendingPayment = $order->pending_payment ?? 0;
                                        $paymentStatus = $order->payment_status ?? '';
                                        $orderStatus = $order->order_status ?? '';
                                        $createdAt = $order->created_at->format('H:i d/m/Y');
                                    @endphp
                                    <tr>
                                        <td style="width:10%;">
                                            <span style="position: relative">
                                            {{ $orderIdOrderCode }}
                                                @if(trim($order->order_note??''))
                                                    <a class="orderNoteDisplay" id="orderNoteDisplay{{$order->id}}"
                                                       title="Customer Note"
                                                       href="javascript:void(0)"
                                                       onclick="displayOrderNote(this, {{$order->id}})"><i
                                                            class="fas fa-comment-alt"></i></a>
                                                @endif
                                            </span>
                                        </td>
                                        <td>

                                                {{ $userIdCustomerName }}


                                        </td>
                                        <td>{{number_format($subTotal, 0, ',', '.')}}</td>
                                        <td>{{number_format($totalDiscount, 0, ',', '.')}}</td>
                                        <td style="width:10%;">
                                            <input type="number" id="deliveryFee_{{$order->id}}" name="deliveryFee_{{$order->id}}" value="{{ $deliveryFee }}" class="form-control deliveryFeeInput" data-orderid="{{$order->id}}">
                                            <input type="hidden" class="previous-delivery_fee" value="{{ $deliveryFee }}">
                                        </td>
                                        <td><span id="totalAmount_{{$order->id}}">{{number_format($totalAmount, 0, ',', '.')}}</span></td>
                                        <td><span id="pendingPayment_{{$order->id}}">{{ number_format($pendingPayment, 0, ',', '.')}}</span></td>
                                        <td>
                                            <div class="form-group" style="position: relative">
                                                <select
                                                    class="form-control payment-status"
                                                    name="paymentStatus"
                                                    data-order-id="{{ $order->id }}"
{{--                                                    style="background-color: {{$STATUS_COLORS[$order->payment_status] ?? 'transparent' }};"--}}
                                                >
                                                    @foreach( $PAYMENT_STATUSES as $key => $data)
                                                        <option
                                                            value="{{$data['status']}}" {{ $data['status'] === $paymentStatus ? 'selected' : '' }} data-color="{{$STATUS_COLORS[$data['status']]}}">
                                                            {{ $data['status'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="color-indicator" style="background-color: {{ $STATUS_COLORS[$order->payment_status] ?? 'transparent' }};"></div>
                                                <input type="hidden" class="previous-payment-status" value="{{ $order->payment_status }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group" style="position: relative">
                                                <select
                                                    class="form-control order-status"
                                                    name="orderStatus"
                                                    data-order-id="{{ $order->id }}"
{{--                                                    style="background-color: {{$STATUS_COLORS[$order->order_status] ?? 'transparent' }};"--}}
                                                >
                                                    @foreach( $ORDERS_STATUSES as $key => $data)
                                                        <option
                                                            value="{{$data['status']}}" {{ $data['status'] === $orderStatus ? 'selected' : '' }} data-color="{{$STATUS_COLORS[$data['status']]}}">
                                                            {{ $data['status'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="color-indicator" id="indicator_{{$order->id}}" style="background-color: {{ $STATUS_COLORS[$order->order_status] ?? 'transparent' }};"></div>
                                                @if($orderStatus === 'Đã Hủy (khách yc hủy)' || $orderStatus === 'Đã Hủy (Hết hàng)')
                                                    <a class="cancelReasonBox" id="cancelReasonBox_{{$order->id}}" href="javascript:void(0)" onclick="showCancelReason(this, {{$order->id}})"><i class="fas fa-comment-dots"></i></a>
                                                @endif
                                                <input type="hidden" class="previous-order-status" value="{{ $order->order_status }}">
                                            </div>
                                        </td>
                                        <td>{{ $createdAt }}</td>
                                        <td>
                                            <div class="dropdown" style=" margin-bottom: 5px; margin-right: 5px">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" id="actionOptions_{{$order->id}}">
                                                    <a class="dropdown-item" href="{{route('orders.orderDetails',['orderId'=> $order->id])}}"><i class="fas fa-eye"></i> Order Details</a>
                                                    @if($orderStatus === 'Đã xác nhận' || $orderStatus === 'Chờ xác nhận')
                                                    <a class="dropdown-item" href="{{route('orders.addDelivery',['orderId'=> $order->id])}}" style="position: relative">
                                                        <i class="fas fa-truck"></i> Add Delivery
                                                        @if($order->shippingInfo)
                                                            <i class="fas fa-check-circle shippingInfoIcon"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item" href="{{route('orders.editOrderInfo',['orderId'=> $order->id])}}"><i class="fas fa-edit"></i>Edit OrderInfo</a>
                                                    @endif
                                                    <!-- Add more actions as needed... -->
                                                </div>
                                            </div>
                                            @if($order->deleted_at)
                                                <button type="button" class="btn btn-success"
                                                        onclick="restoreOrder(this, {{ $order->id}})" title="Restore"
                                                        id="restoreBtn"> <i class="fas fa-undo"></i>
                                                </button>
                                            @else
                                                <a title="Delete" href="#" class="btn btn-danger delete-order" style="  "
                                                   data-url="{{ route('orders.delete', $order->id) }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            @endif
                                            <a class="staffNote" title="Staff Note" href="javascript:void(0)" onclick="showStaffNote(this, {{$order->id}})" style="position: relative" id="staffNote_{{$order->id}}">
                                                <i class="fas fa-user-edit"></i>
                                                @if(trim($order->staff_note??''))
                                                    <i class="fas fa-exclamation-triangle staffNoteWarning" id="staffNoteWarning_{{$order->id}}"></i>
                                                @endif
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="col-md-12">
                                {{ $orders->appends([
                                    'sort_by' =>  request('sort_by', $sortBy),
                                    'sort_direction' =>  request('sort_direction', $sortDirection),
                                    'show_deleted' => request('show_deleted', $showDeleted),
                                    'search_term' => request('search_term', $searchTerm),
                                    'order_status' => $order_status,
                                    'payment_status' => $payment_status,
                                ])->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <div id="loading-spinner" style="display: none;">
        <div class="spinner"></div>
    </div>

@endsection
@section('this-js')
    <script type="text/javascript">

        function displayOrderNote(thisEl, orderId) {
            var $this = $(thisEl);
            var orderNote = ''
            var url = '{{ route('orders.getOrderNote') }}';
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    orderId: orderId,
                },beforeSend: function() {
                    // Disable the link
                    $this.addClass('disabled');
                    $this.css('pointer-events', 'none');
                },
                complete: function() {
                    // Enable the link
                    $this.removeClass('disabled');
                    $this.css('pointer-events', '');
                },
                // headers: {
                //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // },
                success: function(response) {
                    if (response.success) {
                        orderNote = response.orderNote;
                        alertify.alert( 'Lời nhắn của Khách Hàng', orderNote
                            , function() {
                                alertify.success('Ok');
                            }).set('label', 'Xác Nhận');
                    } else {
                        alertify.error(response.message);
                        orderNote = ''
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alertify.error(xhr.responseText);
                }
            });
        }

        function showStaffNote(thisEl, orderId) {
            var $this = $(thisEl);
            var staffNote = ''
            var url = '{{ route('orders.getStaffNote') }}';
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    orderId: orderId,
                },beforeSend: function() {
                    // Disable the link
                    $this.addClass('disabled');
                    $this.css('pointer-events', 'none');
                },
                complete: function() {
                    // Enable the link
                    $this.removeClass('disabled');
                    $this.css('pointer-events', '');
                },
                // headers: {
                //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // },
                success: function(response) {
                    if (response.success) {
                        staffNote = response.staffNote;
                        alertify.prompt( 'Lời nhắn của Nhân Viên', '', staffNote
                            , function(evt, newStaffNote) {
                                var url = '{{ route('orders.updateStaffNote') }}';
                                $.ajax({
                                    url: url,
                                    method: 'POST',
                                    data: {
                                        newStaffNote: newStaffNote,
                                        orderId: orderId,
                                    },beforeSend: function() {
                                        // Disable the link
                                        $this.addClass('disabled');
                                        $this.css('pointer-events', 'none');
                                    },
                                    complete: function() {
                                        // Enable the link
                                        $this.removeClass('disabled');
                                        $this.css('pointer-events', '');
                                    },
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function(response) {
                                        if(response.success) {

                                            $('#staffNoteWarning_' + orderId).remove();
                                            $('#staffNote_' + orderId).prepend(response.staffWarningView);
                                        }
                                        else{
                                            alertify.error(response.message);
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(xhr.responseText);
                                        alertify.error(xhr.responseText);
                                    }
                                });

                            }
                            , function() {

                                alertify.error('Cancel')

                            })
                            .set('labels', {ok:'Save', cancel:'Cancel'});
                    } else {
                        alertify.error(response.message);
                        staffNote = ''
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alertify.error(xhr.responseText);
                }
            });
        }

        function showCancelReason(thisEl, orderId) {
            var $this = $(thisEl);
            var cancelReason = ''
            var url = '{{ route('orders.getOrderCancelReason') }}';
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    orderId: orderId,
                },beforeSend: function() {
                    // Disable the link
                    $this.addClass('disabled');
                    $this.css('pointer-events', 'none');
                },
                complete: function() {
                    // Enable the link
                    $this.removeClass('disabled');
                    $this.css('pointer-events', '');
                },
                // headers: {
                //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // },
                success: function(response) {
                    if (response.success) {
                        cancelReason = response.cancelReason;
                        alertify.prompt( 'Lý Do Huỷ Đơn', '', cancelReason
                            , function(evt, newCancelReason) {
                                var url = '{{ route('orders.updateOrderCancelReason') }}';
                                $.ajax({
                                    url: url,
                                    method: 'POST',
                                    data: {
                                        newCancelReason: newCancelReason,
                                        orderId: orderId,
                                    },beforeSend: function() {
                                        // Disable the link
                                        $this.addClass('disabled');
                                        $this.css('pointer-events', 'none');
                                    },
                                    complete: function() {
                                        // Enable the link
                                        $this.removeClass('disabled');
                                        $this.css('pointer-events', '');
                                    },
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function(response) {
                                        if(response.success)
                                            alertify.success(response.message);
                                        else{
                                            alertify.error(response.message);
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(xhr.responseText);
                                        alertify.error(xhr.responseText);
                                    }
                                });

                            }
                            , function() {

                            alertify.error('Cancel')

                            })
                            .set('labels', {ok:'Save', cancel:'Cancel'});
                    } else {
                        alertify.error(response.message);
                        cancelReason = ''
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alertify.error(xhr.responseText);
                }
            });
        }

        $(document).ready(function() {
            function updateColor($select) {
                var selectedOption = $select.find('option:selected');


                var color = selectedOption.data('color');
                // alertify.success('reach here');
                //
                // alertify.success(color);
                // console.log(color);
                // $select.css('background-color', color);
                $select.siblings('.color-indicator').css('background-color', color);
            }
            // Initialize background colors and color indicators for all selects
            $('.payment-status, .order-status').each(function() {
                updateColor($(this));
            });
                // Event listener for change on .payment-status selects
            $('.payment-status').change(function() {
                var $select = $(this);
                var $hiddenInput = $select.siblings('.previous-payment-status'); // Find corresponding hidden input
                var previousValue = $hiddenInput.val(); // Get previous selected value from hidden input

                // Show confirmation dialog using alertify
                alertify.confirm('Confirm Message', 'Are you sure you want to change Payment Status?',
                    function() { // On confirm
                        var orderId = $select.data('order-id');
                        var newStatus = $select.val();//newStatus for db table but is current status of the select

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
                                    $select.val(newStatus);
                                    //important for the updateColor work correctly
                                    $select.find('option').removeAttr('selected');
                                    $select.find('option[value="' + newStatus + '"]').attr('selected', true);
                                    updateColor($select);
                                } else {
                                    alertify.error(response.message);
                                    // Revert to previous value on error
                                    $select.val(previousValue);
                                    //important for the updateColor work correctly
                                    $select.find('option').removeAttr('selected');
                                    $select.find('option[value="' + previousValue + '"]').attr('selected', true);
                                    updateColor($select);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                alertify.error(xhr.responseText);
                                // Revert to previous value on error
                                $select.val(previousValue);
                                //important for the updateColor work correctly
                                $select.find('option').removeAttr('selected');
                                $select.find('option[value="' + previousValue + '"]').attr('selected', true);
                                updateColor($select);
                            }
                        });
                    },
                    function() { // On cancel
                        // Revert to previous value
                        $select.val(previousValue);
                        //important for the updateColor work correctly
                        $select.find('option').removeAttr('selected');
                        $select.find('option[value="' + previousValue + '"]').attr('selected', true);
                        updateColor($select);
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
                        var newStatus = $select.val();//newStatus for db table but is current status of the select


                        if(newStatus === 'Đã Hủy (khách yc hủy)' || newStatus === 'Đã Hủy (Hết hàng)') {

                        }
                        // Example of AJAX request to update order status
                        var url = '{{ route('orders.updateOrderStatus') }}';
                        $.ajax({
                            url: url,
                            method: 'PUT',
                            data: {
                                orderId: orderId,
                                newStatus: newStatus,
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Update hidden input with new value after successful update
                                    // $hiddenInput.val(newStatus);
                                    $hiddenInput.val(newStatus);
                                    alertify.success(response.message);
                                    $('#actionOptions_' + orderId).html(response.actionOptionsView);
                                    $('#cancelReasonBox_'+ orderId).remove();
                                    $('#indicator_' + orderId).after(response.cancelReasonMsgBoxView);

                                    $select.find('option').removeAttr('selected');
                                    $select.val(newStatus);//important for the updateColor work correctly
                                    //important for the updateColor work correctly
                                    $select.find('option').removeAttr('selected');
                                    $select.find('option[value="' + newStatus + '"]').attr('selected', true);
                                    updateColor($select);
                                } else {
                                    alertify.error(response.message);
                                    // Revert to previous value on error
                                    $select.val(previousValue);
                                    updateColor($select);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                alertify.error(xhr.responseText);
                                // Revert to previous value on error
                                $select.val(previousValue);
                                $select.find('option').removeAttr('selected');
                                $select.find('option[value="' + previousValue + '"]').attr('selected', true);
                                updateColor($select);
                            }
                        });
                    },
                    function() { // On cancel
                        // Revert to previous value
                        $select.val(previousValue);
                        $select.find('option').removeAttr('selected');
                        $select.find('option[value="' + previousValue + '"]').attr('selected', true);
                        updateColor($select);
                        alertify.error('Cancel');
                    }
                );
            });

        });

        $(document).ready(function() {
            $(document).on('click', '.delete-order', function(e) {
                e.preventDefault(); // Prevent the default action of the link

                var $this = $(this); // Capture the clicked element

                alertify.confirm(
                    'Confirm Message',
                    'Are you sure you want to delete this Order?',
                    function () {
                        window.location.href = $this.data('url'); // Use the data-url attribute for the redirect
                    },
                    function () {
                        alertify.error('Cancel'); // Handle cancel action
                    }
                );
            });
            $('.deliveryFeeInput').blur(function(e) {
                var $this = $(this);
                var $hiddenInput = $this.siblings('.previous-delivery_fee'); // Find corresponding hidden input
                var previousValue = $hiddenInput.val(); // Get previous selected value from hidden input
                alertify.confirm('Confirm Message', 'Are you sure you want to change/ apply Delivery Fee?',
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
                                        title: 'Delete',
                                        href: 'javascript:void(0);',
                                        class: 'btn btn-danger delete-order',
                                        'data-url': "{{ route('orders.delete', ':order_id') }}".replace(':order_id', order_id),
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





