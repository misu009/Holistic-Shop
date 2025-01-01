<?php

namespace Database\Factories;

use App\Models\Collaborator;
use App\Models\Events;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Events>
 */
class EventsFactory extends Factory
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
            'starts_at' => fake()->dateTimeBetween('now', '+1 month'),
            'ends_at' => fake()->dateTimeBetween('+1 month', '+2 month'),
            'price' => fake()->randomFloat(2, 0, 1000),
        ];
    }

    public function withCollaborators()
    {
        return $this->afterCreating(function (Events $event) {
            // Attach random collaborators to the event
            $collaborators = Collaborator::inRandomOrder()->take(rand(1, 3))->pluck('id'); // Get 1 to 3 random collaborator IDs
            foreach ($collaborators as $collaboratorId) {
                $event->collaborators()->attach($collaboratorId, ['is_primary' => $collaboratorId === $collaborators->first()]);
            }
        });
    }
}