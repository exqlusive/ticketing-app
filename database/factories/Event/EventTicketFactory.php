<?php

namespace Database\Factories\Event;

use App\Models\Event\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event\EventTicket>
 */
class EventTicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'type' => fn () => Str::random(10),
            'price' => $this->faker->numberBetween(1000, 10000),
            'capacity' => $this->faker->numberBetween(10, 500),
            'max_tickets_per_user' => $this->faker->numberBetween(1, 10),
            'sold' => $this->faker->numberBetween(0, 500),
            'reservation_expiration_minutes' => $this->faker->numberBetween(10, 60),
        ];
    }
}
