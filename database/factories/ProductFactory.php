<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'slug' => fake()->slug(),
            'price' => fake()->randomFloat(2, 1, 1000),
            'user_id' => User::inRandomOrder()->value('id'),
        ];
    }

    public function withProductCategory()
    {
        return $this->afterCreating(function (Product $product) {
            $productCategories = ProductCategory::inRandomOrder()->take(rand(1, 3))->pluck('id'); // Get 1 to 3 random collaborator IDs
            foreach ($productCategories as $productCategory) {
                $product->categories()->attach($productCategory);
            }
        });
    }
}
