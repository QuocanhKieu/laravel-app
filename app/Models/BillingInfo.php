<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingInfo extends Model
{
    protected $guarded = [
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
