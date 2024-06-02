<?php

namespace App\Rules;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueParentCategoryName implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check for uniqueness only for parent categories (parent_id = 0)
        if (Category::where('name', $value)->where('parent_id', 0)->exists()) {
            $fail('The '.$attribute.' must be unique for parent categories.');
        }
    }
}
