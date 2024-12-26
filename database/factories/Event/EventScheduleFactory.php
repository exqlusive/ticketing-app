<?php

namespace Database\Factories\Event;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event\EventSchedule>
 */
class EventScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => \App\Models\Event\Event::factory(),
            'date' => now(),
            'start_time' => '10:00:00',
            'end_time' => '18:00:00',
        ];
    }
}
