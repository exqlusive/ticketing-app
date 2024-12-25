<?php

namespace Database\Factories\Event;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'organization_id' => \App\Models\Organization\Organization::factory(),
            'name' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'start_date' => now(),
            'end_date' => now()->addDays(),
            'venue' => fake()->company(),
            'address' => fake()->address(),
        ];
    }
}
