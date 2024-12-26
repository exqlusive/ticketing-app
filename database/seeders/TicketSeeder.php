<?php

namespace Database\Seeders;

use App\Models\Event\Event;
use App\Models\Event\EventTicket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $event = Event::first();

        EventTicket::updateOrCreate(
            ['event_id' => $event->id, 'type' => 'VIP'],
            [
                'event_id' => $event->id,
                'name' => 'VIP Ticket',
                'description' => 'This is a VIP ticket.',
                'type' => 'VIP',
                'max_tickets_per_user' => 2,
                'reservation_expiration_minutes' => 30,
                'price' => 7500,
                'capacity' => 100,
                'sold' => 0,
            ]
        );

        EventTicket::updateOrCreate(
            ['event_id' => $event->id, 'type' => 'Regular'],
            [
                'event_id' => $event->id,
                'name' => 'Regular Ticket',
                'description' => 'This is a regular ticket.',
                'type' => 'Regular',
                'max_tickets_per_user' => 5,
                'reservation_expiration_minutes' => 15,
                'price' => 5000,
                'capacity' => 500,
                'sold' => 0,
            ]
        );
    }
}
