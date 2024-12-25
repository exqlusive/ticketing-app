<?php

namespace Tests\Feature\Controller\Event;

use App\Library\Enums\Event\EventStatusTypeEnum;
use App\Models\Event\Event;
use App\Models\Organization\Organization;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\TestCase;

class EventTest extends TestCase
{
    const START_DATE = '2024-12-12';

    const END_DATE = '2024-12-22';

    const WRONG_END_DATE = '2023-12-22';

    #[Test]
    public function create_an_event(): void
    {
        $organization = Organization::factory()->create();

        $response = $this->postJson('/api/events', [
            'organization_id' => $organization->id,
            'name' => fake()->firstName(),
            'description' => fake()->sentence(),
            'start_date' => self::START_DATE,
            'end_date' => self::END_DATE,
            'venue' => fake()->city(),
            'address' => fake()->address(),
            'status' => EventStatusTypeEnum::PUBLISHED->value,
        ]);

        $response->assertStatus(200);

        $this->assertResponse($response, 200, false);
    }

    #[Test]
    public function create_an_event_with_the_same_name(): void
    {
        $organization = Organization::factory()->create();

        $this->postJson('/api/events', [
            'organization_id' => $organization->id,
            'name' => $name = fake()->firstName(),
            'description' => fake()->sentence(),
            'start_date' => self::START_DATE,
            'end_date' => self::END_DATE,
            'venue' => fake()->city(),
            'address' => fake()->address(),
            'status' => EventStatusTypeEnum::PUBLISHED->value,
        ]);

        $response = $this->postJson('/api/events', [
            'organization_id' => $organization->id,
            'name' => $name,
            'description' => fake()->sentence(),
            'start_date' => self::START_DATE,
            'end_date' => self::END_DATE,
            'venue' => fake()->city(),
            'address' => fake()->address(),
            'status' => EventStatusTypeEnum::PUBLISHED->value,
        ]);

        $response->assertJson([
            'slug' => Str::slug($name.'-1'),
        ]);

        $response->assertStatus(200);

        $this->assertResponse($response, 200, false);
    }

    #[Test]
    public function create_an_event_with_invalid_date(): void
    {
        $organization = Organization::factory()->create();

        $response = $this->postJson('/api/events', [
            'organization_id' => $organization->id,

            'name' => fake()->firstName(),
            'description' => fake()->sentence(),
            'start_date' => self::START_DATE,
            'end_date' => self::WRONG_END_DATE,
            'venue' => fake()->city(),
            'address' => fake()->address(),
            'status' => EventStatusTypeEnum::PUBLISHED->value,
        ]);

        $response->assertStatus(422);

        $this->assertResponse($response, 422);
    }

    #[Test]
    public function get_event_by_id(): void
    {
        $event = Event::factory()->create();

        $response = $this->getJson('/api/events/'.$event->id);

        $response->assertStatus(200);

        $this->assertResponse($response, 200, false);
    }

    #[Test]
    public function get_event_by_id_not_found(): void
    {
        $response = $this->getJson('/api/events/1');

        $response->assertStatus(404);

        $this->assertResponse($response, 404);
    }

    #[Test]
    public function get_all_events(): void
    {
        $response = $this->getJson('/api/events');

        $response->assertStatus(200);

        $this->assertResponse($response, 200, false);
    }

    #[Test]
    public function update_event(): void
    {
        $event = Event::factory()->create();
        $organization = Organization::factory()->create();

        $response = $this->putJson('/api/events/'.$event->id, [
            'organization_id' => $organization->id,
            'name' => fake()->firstName(),
            'description' => fake()->sentence(),
            'start_date' => self::START_DATE,
            'end_date' => self::END_DATE,
            'venue' => fake()->city(),
            'address' => fake()->address(),
            'status' => EventStatusTypeEnum::PUBLISHED->value,
        ]);

        $response->assertStatus(200);

        $this->assertResponse($response, 200, false);
    }

    #[Test]
    public function update_event_not_found(): void
    {
        $organization = Organization::factory()->create();

        $response = $this->putJson('/api/events/1', [
            'organization_id' => $organization->id,
            'name' => fake()->firstName(),
            'description' => fake()->sentence(),
            'start_date' => self::START_DATE,
            'end_date' => self::END_DATE,
            'venue' => fake()->city(),
            'address' => fake()->address(),
            'status' => EventStatusTypeEnum::PUBLISHED->value,
        ]);

        $response->assertStatus(404);

        $this->assertResponse($response, 404);
    }
}
