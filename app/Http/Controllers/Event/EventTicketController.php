<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\EventTicketStoreRequest;
use App\Http\Requests\Event\EventTicketUpdateRequest;
use App\Http\Resources\Event\EventTicketResource;
use App\Library\Services\Event\EventTicketService;
use App\Models\Event\Event;
use App\Models\Event\EventTicket;
use Illuminate\Http\JsonResponse;

class EventTicketController extends Controller
{
    public function __construct(
        private readonly EventTicketService $eventTicket,
    ) {}

    /**
     * List all tickets for an event.
     */
    public function index(Event $event): JsonResponse
    {
        $tickets = $event->tickets;

        return ok(EventTicketResource::collection($tickets));
    }


    /**
     * Store a new ticket for an event.
     *
     * @throws \Exception
     */
    public function store(EventTicketStoreRequest $request, Event $event): JsonResponse
    {
        $ticket = $this->eventTicket->create($event, $request->validated());

        return ok(new EventTicketResource($ticket));
    }

    /**
     * Get a single ticket by ID.
     */
    public function show(Event $event, EventTicket $ticket): JsonResponse
    {
        return ok(new EventTicketResource($ticket));
    }

    /**
     * Update a ticket.
     */
    public function update(EventTicketUpdateRequest $request, Event $event, EventTicket $ticket): JsonResponse
    {
        $ticket = $this->eventTicket->update($ticket, $request->validated());

        return ok(new EventTicketResource($ticket));
    }
}
