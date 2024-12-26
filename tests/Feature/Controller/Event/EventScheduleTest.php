<?php

namespace Tests\Feature\Controller\Event;

use App\Library\Services\Event\EventScheduleService;
use App\Models\Event\Event;
use App\Models\Event\EventSchedule;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\TestCase;

class EventScheduleTest extends TestCase
{
    #[Test]
    public function create_event_schedule(): void
    {
        $event = Event::factory()->create([
            'start_date' => now()->subDay()->format('Y-m-d'),
            'end_date' => now()->addDay()->format('Y-m-d'),
        ]);

        $data = [
            [
                'date' => now()->format('Y-m-d'),
                'start_time' => '10:00',
                'end_time' => '18:00',
            ],
            [
                'date' => now()->addDay()->format('Y-m-d'),
                'start_time' => '12:00',
                'end_time' => '20:00',
            ],
        ];

        $response = $this->postJson("/api/events/{$event->id}/schedules", $data);

        $response->assertStatus(200);

        $this->assertResponse($response, 200, false);
    }

    #[Test]
    public function create_event_schedule_where_event_is_not_found(): void
    {
        $data = [
            [
                'date' => now()->format('Y-m-d'),
                'start_time' => '10:00',
                'end_time' => '18:00',
            ],
            [
                'date' => now()->addDay()->format('Y-m-d'),
                'start_time' => '12:00',
                'end_time' => '20:00',
            ],
        ];

        $response = $this->postJson('/api/events/1/schedules', $data);

        $response->assertStatus(422);

        $this->assertResponse($response, 422);
    }

    #[Test]
    public function create_event_schedule_where_date_is_incorrect(): void
    {
        $event = Event::factory()->create([
            'start_date' => now()->subDay()->format('Y-m-d'),
            'end_date' => now()->addDay()->format('Y-m-d'),
        ]);

        $data = [
            [
                'date' => now()->addDays(5)->format('Y-m-d'), // Invalid: Outside event date range
                'start_time' => '10:00',
                'end_time' => '18:00',
            ],
        ];

        $response = $this->postJson("/api/events/{$event->id}/schedules", $data);

        $response->assertStatus(422);
        $response->assertJsonFragment([
            '0.date' => [
                "The date must fall within the event dates ({$event->start_date->toDateString()} to {$event->end_date->toDateString()}).",
            ],
        ]);

        $this->assertResponse($response, 422);
    }

    #[Test]
    public function update_event_schedule(): void
    {
        $event = Event::factory()->create([
            'start_date' => now()->subDay()->format('Y-m-d'),
            'end_date' => now()->addDay()->format('Y-m-d'),
        ]);

        $schedule = $event->schedules()->create([
            'date' => now()->format('Y-m-d'),
            'start_time' => '10:00',
            'end_time' => '18:00',
        ]);

        $data = [
            'date' => now()->format('Y-m-d'),
            'start_time' => '12:00',
            'end_time' => '20:00',
        ];

        $response = $this->putJson("/api/events/{$event->id}/schedules/{$schedule->id}", $data);

        $response->assertStatus(200);

        $this->assertResponse($response, 200, false);
    }

    #[Test]
    public function update_event_schedule_date_validation(): void
    {
        $event = Event::factory()->create([
            'start_date' => now()->subDay()->format('Y-m-d'),
            'end_date' => now()->addDay()->format('Y-m-d'),
        ]);

        $schedule = EventSchedule::factory()->create([
            'event_id' => $event->id,
            'date' => now()->format('Y-m-d'),
            'start_time' => '10:00',
            'end_time' => '18:00',
        ]);

        $data = [
            'date' => now()->addDays(5)->format('Y-m-d'),
            'start_time' => '11:00',
            'end_time' => '19:00',
        ];

        $response = $this->putJson("/api/events/{$event->id}/schedules/{$schedule->id}", $data);

        $response->assertStatus(422);
        $response->assertJsonFragment([
            'date' => [
                "The date must fall within the event dates ({$event->start_date->toDateString()} to {$event->end_date->toDateString()}).",
            ],
        ]);
    }

    #[Test]
    public function update_event_schedule_duplicate_validation(): void
    {
        $event = Event::factory()->create([
            'start_date' => now()->subDay()->format('Y-m-d'),
            'end_date' => now()->addDay()->format('Y-m-d'),
        ]);

        $existingSchedule = EventSchedule::factory()->create([
            'event_id' => $event->id,
            'date' => now()->format('Y-m-d'),
            'start_time' => '10:00',
            'end_time' => '18:00',
        ]);

        $scheduleToUpdate = EventSchedule::factory()->create([
            'event_id' => $event->id,
            'date' => now()->addDay()->format('Y-m-d'),
            'start_time' => '12:00',
            'end_time' => '20:00',
        ]);

        $data = [
            'date' => $existingSchedule->date,
            'start_time' => $existingSchedule->start_time,
            'end_time' => $existingSchedule->end_time,
        ];

        $response = $this->putJson("/api/events/{$event->id}/schedules/{$scheduleToUpdate->id}", $data);

        $response->assertStatus(422);
        $response->assertJsonFragment([
            'schedule' => [
                sprintf(
                    'A schedule already exists for date %s and time %s - %s.',
                    Carbon::parse($data['date'])->toDateString(),
                    $data['start_time'],
                    $data['end_time']
                ),
            ],
        ]);
    }

    #[Test]
    public function update_event_schedule_where_event_is_not_found(): void
    {
        $data = [
            'date' => now()->format('Y-m-d'),
            'start_time' => '12:00',
            'end_time' => '20:00',
        ];

        $response = $this->putJson('/api/events/1/schedules/1', $data);

        $response->assertStatus(422);

        $this->assertResponse($response, 422);
    }

    public function update_event_schedule_where_schedule_is_not_found(): void
    {
        $event = Event::factory()->create([
            'start_date' => now()->subDay()->format('Y-m-d'),
            'end_date' => now()->addDay()->format('Y-m-d'),
        ]);

        $data = [
            'date' => now()->format('Y-m-d'),
            'start_time' => '12:00',
            'end_time' => '20:00',
        ];

        $response = $this->putJson("/api/events/{$event->id}/schedules/1", $data);

        $response->assertStatus(422);

        $this->assertResponse($response, 422);
    }

    #[Test]
    public function get_all_event_schedules(): void
    {
        $event = Event::factory()->create();
        $event->schedules()->create([
            'date' => now()->format('Y-m-d'),
            'start_time' => '10:00',
            'end_time' => '18:00',
        ]);

        $response = $this->getJson("/api/events/{$event->id}/schedules");

        $response->assertStatus(200);

        $this->assertResponse($response, 200, false);
    }

    #[Test]
    public function get_all_event_schedules_with_event_extend(): void
    {
        $event = Event::factory()->create();
        $event->schedules()->create([
            'date' => now()->format('Y-m-d'),
            'start_time' => '10:00',
            'end_time' => '18:00',
        ]);

        $response = $this->getJson("/api/events/{$event->id}/schedules?Extend=Event");

        $response->assertStatus(200);

        $this->assertResponse($response, 200, false);
    }

    #[Test]
    public function get_all_event_schedules_where_event_is_not_found(): void
    {
        $response = $this->getJson('/api/events/1/schedules');

        $response->assertStatus(404);

        $this->assertResponse($response, 404);
    }

    #[Test]
    public function get_a_event_schedule(): void
    {
        $event = Event::factory()->create();
        $schedule = $event->schedules()->create([
            'date' => now()->format('Y-m-d'),
            'start_time' => '10:00',
            'end_time' => '18:00',
        ]);

        $response = $this->getJson("/api/events/{$event->id}/schedules/{$schedule->id}");

        $response->assertStatus(200);

        $this->assertResponse($response, 200, false);
    }

    #[Test]
    public function get_a_event_schedule_where_event_is_not_found(): void
    {
        $response = $this->getJson('/api/events/1/schedules/1');

        $response->assertStatus(404);

        $this->assertResponse($response, 404);
    }

    public function test_create_event_schedule_successfully(): void
    {
        $event = Event::factory()->create();

        $data = [
            'date' => now()->format('Y-m-d'),
            'start_time' => '10:00',
            'end_time' => '18:00',
        ];

        $service = app(EventScheduleService::class);
        $schedule = $service->create($event, $data);

        $this->assertInstanceOf(EventSchedule::class, $schedule);
        $this->assertDatabaseHas('event_schedules', [
            'event_id' => $event->id,
            'date' => $data['date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
        ]);
    }

    public function test_create_event_schedule_fails_due_to_duplicate(): void
    {
        $event = Event::factory()->create();

        $existingData = [
            'event_id' => $event->id,
            'date' => now()->format('Y-m-d'),
            'start_time' => '10:00',
            'end_time' => '18:00',
        ];

        EventSchedule::factory()->create($existingData);

        $data = [
            'date' => $existingData['date'],
            'start_time' => $existingData['start_time'],
            'end_time' => $existingData['end_time'],
        ];

        $service = app(EventScheduleService::class);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage(
            "A schedule already exists for date {$data['date']} and time {$data['start_time']} - {$data['end_time']}."
        );

        $service->create($event, $data);
    }

    public function test_create_many_event_schedules(): void
    {
        $event = Event::factory()->create();

        $data = [
            [
                'date' => now()->format('Y-m-d'),
                'start_time' => '10:00',
                'end_time' => '18:00',
            ],
            [
                'date' => now()->addDay()->format('Y-m-d'),
                'start_time' => '12:00',
                'end_time' => '20:00',
            ],
        ];

        $service = app(EventScheduleService::class);
        $schedules = $service->createMany($event, $data);

        $this->assertCount(2, $schedules);
        foreach ($data as $scheduleData) {
            $this->assertDatabaseHas('event_schedules', [
                'event_id' => $event->id,
                'date' => $scheduleData['date'],
                'start_time' => $scheduleData['start_time'],
                'end_time' => $scheduleData['end_time'],
            ]);
        }
    }
}
