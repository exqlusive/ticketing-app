<?php

namespace Tests\Feature\Controller\Event;

use App\Library\Services\Event\EventScheduleService;
use App\Models\Event\Event;
use App\Models\Event\EventSchedule;
use App\Models\Event\EventTicket;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\TestCase;

class EventTicketTest extends TestCase
{
    #[Test]
    public function list_all_tickets_for_event(): void
    {
        $event = Event::factory()->create();
        $tickets = EventTicket::factory()->count(3)->create(['event_id' => $event->id]);

        $this->assertCount(3, $tickets); // Confirm tickets are created

        $response = $this->getJson("/api/events/{$event->id}/tickets");

        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonStructure([['id', 'name', 'type', 'capacity', 'sold']]);
    }

    #[Test]
    public function create_ticket(): void
    {
        $event = Event::factory()->create();

        $data = [
            'name' => 'VIP Ticket',
            'description' => 'Exclusive VIP access',
            'type' => 'vip',
            'price' => 10000,
            'capacity' => 50,
            'max_tickets_per_user' => 5,
            'reservation_expiration_minutes' => 15,
        ];

        $response = $this->postJson("/api/events/{$event->id}/tickets", $data);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'VIP Ticket', 'type' => 'vip', 'capacity' => 50]);

        $this->assertDatabaseHas('tickets', [
            'event_id' => $event->id,
            'type' => 'vip',
        ]);
    }

    #[Test]
    public function create_duplicate_ticket_fails(): void
    {
        $event = Event::factory()->create();

        EventTicket::factory()->create(['event_id' => $event->id, 'type' => 'vip']);

        $data = [
            'name' => 'VIP Ticket',
            'type' => 'vip',
            'price' => 100,
            'capacity' => 50,
            'max_tickets_per_user' => 5,
            'reservation_expiration_minutes' => 30,
        ];

        $response = $this->postJson("/api/events/{$event->id}/tickets", $data);

        $response->assertStatus(422)
            ->assertJsonFragment([
                'errors' => [
                    'ticket' => ['A ticket already exists for type vip.']
                ],
            ]);
    }


    public function test_get_single_ticket_by_id(): void
    {
        $event = Event::factory()->create();
        $ticket = EventTicket::factory()->create(['event_id' => $event->id]);

        $response = $this->getJson("/api/events/{$event->id}/tickets/{$ticket->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $ticket->id, 'name' => $ticket->name, 'type' => $ticket->type]);
    }

    #[Test]
    public function update_ticket(): void
    {
        $event = Event::factory()->create();
        $ticket = EventTicket::factory()->create(['event_id' => $event->id]);

        $data = [
            'name' => 'Updated Ticket',
            'type' => 'vip',
            'price' => 200,
            'capacity' => 100,
            'max_tickets_per_user' => 10,
            'reservation_expiration_minutes' => 30,
        ];

        $response = $this->putJson("/api/events/{$event->id}/tickets/{$ticket->id}", $data);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Ticket', 'type' => 'vip', 'capacity' => 100]);

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'name' => $data['name'],
            'type' => $data['type'],
        ]);
    }

    #[Test]
    public function update_ticket_duplicate_type_fails(): void
    {
        $event = Event::factory()->create();

        $existingTicket = EventTicket::factory()->create(['event_id' => $event->id, 'type' => 'vip']);
        $ticketToUpdate = EventTicket::factory()->create(['event_id' => $event->id, 'type' => 'regular']);

        $data = [
            'name' => 'Updated Ticket',
            'type' => 'vip',
            'price' => 200,
            'capacity' => 100,
            'max_tickets_per_user' => 10,
            'reservation_expiration_minutes' => 30,
        ];

        $response = $this->putJson("/api/events/{$event->id}/tickets/{$ticketToUpdate->id}", $data);

        $response->assertStatus(422)
            ->assertJsonFragment(['errors' => ['ticket' => ['A ticket already exists for type vip.']]]);
    }

    #[Test]
    public function get_tickets_for_nonexistent_event(): void
    {
        $response = $this->getJson('/api/events/invalid-id/tickets');

        $response->assertStatus(404);
    }

    #[Test]
    public function create_ticket_for_nonexistent_event(): void
    {
        $data = [
            'name' => 'VIP Ticket',
            'type' => 'vip',
            'price' => 100,
            'capacity' => 50,
            'max_tickets_per_user' => 5,
            'reservation_expiration_minutes' => 30,
        ];

        $response = $this->postJson('/api/events/invalid-id/tickets', $data);

        $response->assertStatus(404);
    }
}
