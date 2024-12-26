<?php

namespace App\Library\Services\Event;

use App\Models\Event\Event;
use App\Models\Event\EventSchedule;
use Illuminate\Validation\ValidationException;

readonly class EventScheduleService
{
    /**
     * Create a new schedule for an event.
     */
    public function create(Event $event, array $data): EventSchedule
    {
        $existing = EventSchedule::where('event_id', $event->id)
            ->where('date', $data['date'])
            ->where('start_time', $data['start_time'])
            ->where('end_time', $data['end_time'])
            ->exists();

        if ($existing) {
            throw ValidationException::withMessages([
                'schedule' => "A schedule already exists for date {$data['date']} and time {$data['start_time']} - {$data['end_time']}.",
            ]);
        }

        return $event->schedules()->create($data);
    }

    /**
     * Create many schedules for an event.
     */
    public function createMany(Event $event, array $schedules): array
    {
        return collect($schedules)->map(fn ($data) => $event->schedules()->create($data))->all();
    }
}
