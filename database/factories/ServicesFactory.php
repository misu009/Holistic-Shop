<?php

namespace Database\Factories;

use App\Models\Collaborator;
use App\Models\Services;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Services>
 */
class ServicesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->paragraph(50),
            'price' => fake()->randomFloat(2, 0, 1000),
        ];
    }

    public function withCollaborators()
    {
        return $this->afterCreating(function (Services $service) {
            $collaborators = Collaborator::inRandomOrder()->take(rand(2, 3))->pluck('id');
            foreach ($collaborators as $collaboratorId) {
                $service->collaborators()->attach($collaboratorId, ['is_primary' => true]);
            }
        });
    }
}
