<?php

namespace Database\Seeders;

use App\Models\Event\Event;
use App\Models\Event\EventSchedule;
use Illuminate\Database\Seeder;

class EventScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = Event::all();

        foreach ($events as $event) {
            EventSchedule::create([
                'event_id' => $event->id,
                'date' => $event->start_date,
                'start_time' => '10:00:00',
                'end_time' => '18:00:00',
            ]);

            EventSchedule::create([
                'event_id' => $event->id,
                'date' => $event->end_date,
                'start_time' => '12:00:00',
                'end_time' => '20:00:00',
            ]);
        }
    }
}
