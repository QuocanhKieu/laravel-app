@if($orderStatus === 'Đã Hủy (khách yc hủy)' || $orderStatus === 'Đã Hủy (Hết hàng)')
<a class="cancelReasonBox" id="cancelReasonBox_{{$order->id}}" href="javascript:void(0)" onclick="showCancelReason(this, {{$order->id}})"><i class="fas fa-comment-dots"></i></a>
@endif
