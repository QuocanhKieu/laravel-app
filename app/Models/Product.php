<?php

namespace App\Models;

use Gloudemans\Shoppingcart\Contracts\Buyable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model implements Buyable
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function sizes()
    {
        return $this->belongsToMany(Size::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function getBuyableIdentifier($options = null)
    {
        return $this->id;
    }

    public function getBuyableDescription($options = null)
    {
        return $this->name;

    }

    public function getBuyablePrice($options = null)
    {
        return $this->sale_price;

    }

    public function getBuyableWeight($options = null)
    {
        return 0;

    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
