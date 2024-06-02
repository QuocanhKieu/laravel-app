<?php

namespace Database\Factories;
use App\Models\Category;
use App\Models\Food;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Food>
 */
class FoodFactory extends Factory
{
      /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Food::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence, // Generate a fake sentence for the name
            'description' => $this->faker->paragraph, // Generate a fake paragraph for the description
            'quantity' => $this->faker->numberBetween(1, 100), // Generate a random quantity between 1 and 100
            'category_id' => Category::factory(), // Create a new Category and get its ID
        ];
    }
}
