<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use SoftDeletes, HasFactory;
    protected $guarded = [];

    public static function boot()
    {

        parent::boot();

        self::creating(function($category) {
            $category->slug = Str::slug($category->name); // Generate slug from name
        });

        self::updating(function($category) {
            $category->slug = Str::slug($category->name); // Update slug when name is updated
        });
    }
    // Relationship with parent category
    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Relationship with child categories
    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function allProducts($limit = null)
    {
        // Get all child category IDs
        $childCategoryIds = $this->children()->pluck('id');
        $query = Product::whereIn('category_id', $childCategoryIds)->latest();
        if ($limit) {
            $query->take($limit);
        }
        // Fetch all products where childCategory_id is in the list of child category IDs
        return $query->get();
    }
    public function isDescendantOf(self $ancestor): bool
    {
        if ($this->id === $ancestor->id) {
            return false; // A category cannot be a descendant of itself
        }

        $node = $this;
        while (!is_null($node->parent)) {
            if ($node->parent->id === $ancestor->id) {
                return true;
            }
            $node = $node->parent;
        }
        return false;
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'category_brand');
    }

}


