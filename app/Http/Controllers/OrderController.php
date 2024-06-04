<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ShippingInfo;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class OrderController extends Controller
{
    public function index(Request $request) {
        $sortBy = $request->get('sort_by', 'created_at'); // Default column to sort by
        $sortDirection = $request->get('sort_direction', 'desc'); // Default sort direction
        $showDeleted = $request->get('show_deleted', 'no'); // Default to not showing deleted
        $searchTerm = $request->get('search_term', '');

        $order_status = $request->get('order_status', null);
        $payment_status = $request->get('payment_status', null);


        // Validate sort direction
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }
        $query = Order::query();
        // Fetch orders with or without trashed ones
        if ($showDeleted === 'yes') {
            $query = $query->withTrashed();
        }
        if ($searchTerm) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('id', 'like', "%$searchTerm%")
                    ->orWhere('order_code', 'like', "%$searchTerm%")
                    ->orWhere('payment_method', 'like', "%$searchTerm%")
                    ->orWhere('user_id', 'like', "%$searchTerm%");
            })->orWhereHas('orderDetail', function ($query) use ($searchTerm) {
                $query->where(function ($query) use ($searchTerm) {
                    $query->where('name', 'like', "%$searchTerm%")
                        ->orWhere('email', 'like', "%$searchTerm%") // Added column
                        ->orWhere('phone_number', 'like', "%$searchTerm%"); // Added column
                });
            })->orWhereHas('voucher', function ($query) use ($searchTerm) {
                $query->where(function ($query) use ($searchTerm) {
                    $query->where('code', 'like', "%$searchTerm%");
//                        ->orWhere('email', 'like', "%$searchTerm%") // Added column
//                        ->orWhere('phone_number', 'like', "%$searchTerm%"); // Added column
                });
            })->orWhereHas('user', function ($query) use ($searchTerm) {
                $query->where(function ($query) use ($searchTerm) {
                    $query->where('name', 'like', "%$searchTerm%");
//                        ->orWhere('id', 'like', "%$searchTerm%") // Added column
//                        ->orWhere('phone_number', 'like', "%$searchTerm%"); // Added column
                });
            });
        }

        if ($order_status !== null) {
            $query = $query->where('order_status', $order_status);
        }

        if ($payment_status !== null) {
            $query = $query->where('payment_status', $payment_status);
        }

        $query->orderBy($sortBy, $sortDirection);

        $orders = $query->paginate(5);

        return view('admin.order.index', compact('orders', 'sortBy', 'sortDirection', 'showDeleted', 'order_status', 'payment_status','searchTerm'));
    }

    public function delete(Request $request, $order_id)
    {
        $order = Order::findOrFail($order_id);
        $order->delete();
        return redirect(route('orders'));
    }

    public function restore(Request $request)
    {
        $order_id = $request->order_id;
        // Fetch categories based on showDeleted value
        $softDeletedOrder = Order::withTrashed()->find($order_id);
        if ($softDeletedOrder) {

            $softDeletedOrder->restore();

            // Category found, you can perform further actions here
            return response()->json(['success' => true ,'message' => 'Restore thành công.', 'softDeletedOrder' => $softDeletedOrder]);
        } else {
            // Category not found
            return response()->json(['success'=> false, 'message' => 'Order not found.']);
        }
    }

    public function updatePaymentStatus(Request $request) {
        try {
        $newStatus = $request->newStatus;
        $orderId = $request->orderId;
        $order = Order::findOrfail($orderId);
        if ($order) {
            $order->payment_status = $newStatus; // Replace 'Paid' with the actual status
            // Save the changes
            $order->save();
            return response()->json(['success' => true, 'message' => 'Payment Status Changed successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Order not found,Payment Status change failure.']);
        }catch(\Exception $exception) {
            return response()->json(['success' => false, 'message' => 'Something went wrong,Payment Status change failure.', 404]);
        }
    }
    public function updateOrderStatus(Request $request) {
        try {
            $newStatus = $request->newStatus;
            $orderId = $request->orderId;

            $order = Order::findOrfail($orderId);
            if ($order) {
                $order->order_status = $newStatus; // Replace 'Paid' with the actual status
                if($newStatus !== 'Đã Hủy (khách yc hủy)' && $newStatus !== 'Đã Hủy (Hết hàng)') {
                    $order->cancel_reason = '';
                }
                // Save the changes
                $order->save();
                $actionOptionsView = view('admin.partials.actionOptions', ['orderStatus' => $order->order_status, 'order'=> $order])->render();
                $cancelReasonMsgBoxView = view('admin.partials.cancelReasonMsgBox', ['orderStatus' => $order->order_status, 'order'=> $order])->render();

                return response()->json(['success' => true, 'message' => 'Order Status Changed successfully.', 'actionOptionsView' => $actionOptionsView, 'cancelReasonMsgBoxView' => $cancelReasonMsgBoxView]);
            }
            return response()->json(['success' => false, 'message' => 'Order not found,Order Status change failure.']);
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => 'Something went wrong,Order Status change failure.', 404]);
        }
    }
    public function updateDeliveryFee(Request $request) {
        try {
            $newDeliveryFee = $request->newDeliveryFee;
            $orderId = $request->orderId;
            $order = Order::findOrfail($orderId);
            $oldTotalAmount = $order->sub_total_amount - $order->total_discount;
            $newTotalAmount = $oldTotalAmount + (int)$newDeliveryFee;
            if ($order && $oldTotalAmount && $newTotalAmount) {
                $order->delivery_fee = $newDeliveryFee; // Replace 'Paid' with the actual status
                $order->total_amount = $newTotalAmount;
                // Save the changes

                switch ($order->payment_status) {
                    case 'Chưa Thanh Toán':
                        $pendingPayment = $newTotalAmount;
                        $order->pending_payment  = $pendingPayment;
                        break;
                    case 'Đã thanh toán Phí Ship':
                        $pendingPayment = $oldTotalAmount;
                        $order->pending_payment  = $pendingPayment;
                        break;
                    case 'Đã thanh toán Tiền Hàng':
                        $pendingPayment = (int)$newDeliveryFee;
                        $order->pending_payment  = $pendingPayment;
                        break;
                    case 'Đã thanh toán toàn bộ':
                        $order->pending_payment  = 0;
                        break;
                    default :
                        $order->pending_payment  = 0;
                }
                $order->save();


                return response()->json(['success' => true, 'message' => 'Order Fee Updated successfully.', 'totalAmount' => number_format($order->total_amount, 0, ',', '.'), 'pendingPayment'=>number_format($order->pending_payment, 0, ',', '.')]);
            }
            return response()->json(['success' => false, 'message' => 'Order not found,Order Fee Updated failure.']);
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => 'Order not found,Order Fee Updated failure.', 404]);
        }
    }


    public function orderDetails(Request $request) {
        $orderId = $request->get('orderId');
        $order = Order::find($orderId);
        $orderDetail = $order->orderDetail;
        $orderItems = $order->orderItems;
        $user = $order->user;
        $voucher = $order->voucher;
        $shippingInfo = $order->shippingInfo;
        $billingInfo = $order->billingInfo;
        return view('admin.order.orderDetails', [
            'order' => $order,
            'orderDetail' => $orderDetail,
            'orderItems' => $orderItems,
            'user' => $user,
            'voucher' => $voucher,
            'shippingInfo' => $shippingInfo,
            'billingInfo' => $billingInfo
        ]);
    }


    public function addDelivery(Request $request) {
        $orderId = $request->get('orderId');
        $order = Order::find($orderId);
        return view('admin.order.addDelivery',['order' => $order]);
    }
    public function updateDelivery(Request $request) {
        try {
            $data = $request->all();
            $orderId = $data['order_id'];
            $order = Order::findOrFail($orderId);

            if ($order) {
                // Check if shipping info exists or create a new instance
                $shippingInfo = ShippingInfo::firstOrNew(['order_id' => $order->id]);

                // Update shipping info with new data
                $shippingInfo->delivery_unit = $data['delivery_unit']    ??'';
                $shippingInfo->order_code = $order->order_code ?? '';
                $shippingInfo->delivery_code = $data['delivery_code'] ?? '';
                $shippingInfo->delivery_method = $data['delivery_method'] ?? '';
                $shippingInfo->real_delivery_fee = $data['real_delivery_fee'] ?? 0;

                // Save the shipping info
                $shippingInfo->save();

                return response()->json(['success' => true, 'message' => 'updateDelivery successfully.']);
            }
            return response()->json(['success' => false, 'message' => 'Order not found, updateDelivery failure.']);
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => 'Something went wrong, updateDelivery failure.', 'error' => $exception->getMessage()], 404);
        }
    }



    public function editOrderInfo(Request $request) {
        $orderId = $request->get('orderId');
        return view('admin.inProgressPage');
    }
    public function getOrderCancelReason(Request $request) {
        $orderId = $request->orderId;

        $order = Order::findOrfail($orderId);
        if ($order) {
            $cancelReason = $order->cancel_reason ?? '';
            return response()->json(['success' => true, 'message' => 'getOrderCancelReason successfully.', 'cancelReason' => $cancelReason]);
        }
        return response()->json(['success' => false, 'message' => 'Order not found,Cant get getOrderCancelReason.']);
    }

    public function updateOrderCancelReason(Request $request) {
        try {
            $orderId = $request->orderId;
            $newCancelReason = $request->newCancelReason;
            $order = Order::findOrfail($orderId);
            if ($order) {
                $order->cancel_reason = $newCancelReason??'';
                // Save the changes
                $order->save();
                return response()->json(['success' => true, 'message' => 'updateOrderCancelReason successfully.']);
            }
            return response()->json(['success' => false, 'message' => 'Order not found, updateOrderCancelReason failure.']);
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => 'Something went wrong,updateOrderCancelReason failure.', 404]);
        }
    }

    public function getStaffNote(Request $request) {
        $orderId = $request->orderId;

        $order = Order::findOrfail($orderId);
        if ($order) {
            $staffNote = $order->staff_note ?? '';
            return response()->json(['success' => true, 'message' => 'getStaffNote successfully.', 'staffNote' => $staffNote]);
        }
        return response()->json(['success' => false, 'message' => 'Order not found,Cant getStaffNote.']);
    }

    public function updateStaffNote(Request $request) {
        try {
            $orderId = $request->orderId;
            $newStaffNote = $request->newStaffNote;
            $order = Order::findOrfail($orderId);
            if ($order) {
                $order->staff_note = $newStaffNote??'';
                // Save the changes
                $order->save();
                $staffWarningView = view('admin.partials.staffWarningView', ['order'=> $order])->render();

                return response()->json(['success' => true, 'message' => 'updateStaffNote successfully.', 'staffWarningView' => $staffWarningView]);
            }
            return response()->json(['success' => false, 'message' => 'Order not found, cant updateStaffNote.']);
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => 'Something went wrong, cant updateStaffNote.', 404]);
        }
    }

    public function getOrderNote(Request $request) {
        $orderId = $request->orderId;

        $order = Order::findOrfail($orderId);
        if ($order) {
            $orderNote = $order->order_note ?? '';
            return response()->json(['success' => true, 'message' => 'getStaffNote successfully.', 'orderNote' => $orderNote]);
        }
        return response()->json(['success' => false, 'message' => 'Order not found,Cant getStaffNote.']);
    }
}
