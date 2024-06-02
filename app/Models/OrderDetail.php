<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $guarded = [
    ];

    /**
     * Get the order that owns the details.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the province associated with the order detail.
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    /**
     * Get the district associated with the order detail.
     */
    public function district()
    {
        return $this->belongsTo(District::class, 'district_code', 'code');
    }
}
