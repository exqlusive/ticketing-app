<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\EventStoreRequest;
use App\Http\Resources\Event\EventResource;
use App\Library\Services\Event\EventService;
use App\Models\Event\Event;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    public function __construct(
        private readonly EventService $event,
    ) {}

    /**
     * Get all events
     */
    public function index(): JsonResponse
    {
        $events = Event::with('organization')->paginate(100);

        return ok(EventResource::collection($events)->response()->getData(true));
    }

    /**
     * Get an event by id
     */
    public function show(string $id): JsonResponse
    {
        $event = Event::with('organization')->find($id);

        if (!$event) {
            return not_found();
        }

        return ok(new EventResource($event));
    }

    /**
     * Create a new event
     *
     * @throws \Exception
     */
    public function store(EventStoreRequest $request): JsonResponse
    {
        $event = $this->event->create($request->validated());
        $event->load('organization');

        return ok(new EventResource($event));
    }

    /**
     * Update a event
     *
     * @throws \Exception
     */
    public function update(EventStoreRequest $request, string $id): JsonResponse
    {
        $event = Event::findOrFail($id);
        $event->update($request->validated());

        return ok(new EventResource($event));
    }
}
