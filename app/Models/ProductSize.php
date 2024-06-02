<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductSize extends Pivot
{
    protected $table = 'product_size';

    protected $fillable = ['quantity'];

    // Define any additional attributes or methods here
    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_size');
    }

// ShoeSize.php
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_size');
    }
}
