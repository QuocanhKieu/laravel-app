<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // Automatically generate slug based on the name before saving
    public static function boot()
    {

        parent::boot();
        self::creating(function($brand) {
            $brand->slug = Str::slug($brand->name); // Generate slug from name
        });

        self::updating(function($brand) {
            $brand->slug = Str::slug($brand->name); // Update slug when name is updated
        });
    }
    public function allProducts($limit = null)
    {
        // Get all child category IDs
        $childCategoryIds = $this->products();
        if ($limit) {
            $childCategoryIds->take($limit);
        }
        // Fetch all products where childCategory_id is in the list of child category IDs
        return $childCategoryIds->get();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_brand');
    }

}
