<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $category_id = $this->faker->numberBetween(1, 9);
        return [
            'name' => $this->faker->name,
            'price' => (string) $this->faker->randomFloat(2, 10, 1000),
            'feature_image_path' => $this->faker->imageUrl(),
            'content' => $this->faker->text,
            'user_id' => 1,
            'category_id' => $category_id,
        ];
    }
}
