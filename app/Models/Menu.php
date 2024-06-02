<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Menu extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'parent_id', 'slug'];

    public static function boot(): void
    {

        parent::boot();

        self::creating(function($menu) {
            $menu->slug = Str::slug($menu->name); // Generate slug from name
        });

        self::updating(function($menu) {
            $menu->slug = Str::slug($menu->name); // Update slug when name is updated
        });
    }
    // Relationship with parent category
    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    // Relationship with child categories
    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }
    use HasFactory;

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
}
