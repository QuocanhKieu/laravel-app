<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Order extends Model
{
    use SoftDeletes;

    protected $guarded = [
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->order_code = $order->generateUniqueOrderId(); // Using UUID for unique order_id
        });
    }
    private function generateUniqueOrderId($length = 7) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $unique = false;
        $orderId = '';

        while (!$unique) {
            $orderId = 'OH';
            for ($i = 0; $i < $length; $i++) {
                $orderId .= $characters[rand(0, $charactersLength - 1)];
            }

            // Check if the order code exists in the database
            $exists = Order::where('order_code', $orderId)->exists();

            // If the order code does not exist, then it's unique
            if (!$exists) {
                $unique = true;
            }
        }

        return $orderId;
    }

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderDetail()
    {
        return $this->hasOne(OrderDetail::class);
    }

    public function billingInfo()
    {
        return $this->hasOne(BillingInfo::class);
    }

    public function shippingInfo()
    {
        return $this->hasOne(ShippingInfo::class);
    }

//    public function paymentInfo()
//    {
//        return $this->hasOne(PaymentInfo::class);
//    }
}
