<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use App\View\Components\admin\CategoriesTable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name(),
            'slug' => fake()->slug(),
            'excerpt' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'created_by' => User::query()->orderByRaw('RAND()')->value('name'),
        ];
    }

    public function withPostCategory()
    {
        return $this->afterCreating(function (Post $post) {
            $postCategories = PostCategory::inRandomOrder()->take(rand(1, 3))->pluck('id'); // Get 1 to 3 random collaborator IDs
            foreach ($postCategories as $postCategory) {
                $post->categories()->attach($postCategory);
            }
        });
    }
}
