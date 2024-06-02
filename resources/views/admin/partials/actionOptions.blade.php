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
