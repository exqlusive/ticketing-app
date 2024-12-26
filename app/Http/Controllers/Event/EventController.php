<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\EventScheduleStoreRequest;
use App\Http\Requests\Event\EventScheduleUpdateRequest;
use App\Http\Requests\Event\EventStoreRequest;
use App\Http\Resources\Event\EventResource;
use App\Http\Resources\Event\EventScheduleResource;
use App\Library\Helpers\ExtendHelper;
use App\Library\Services\Event\EventScheduleService;
use App\Library\Services\Event\EventService;
use App\Models\Event\Event;
use App\Models\Event\EventSchedule;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    public function __construct(
        private readonly EventService $event,
        private readonly EventScheduleService $eventSchedule,
    ) {}

    /**
     * Get all events
     */
    public function index(): JsonResponse
    {
        $relations = ExtendHelper::resolve(
            request()->query('Extend'),
            ['organization', 'schedules']
        );

        $events = Event::with($relations)->paginate(100);

        return ok(EventResource::collection($events)->response()->getData(true));
    }

    /**
     * Get an event by id
     */
    public function show(string $id): JsonResponse
    {
        $relations = ExtendHelper::resolve(
            request()->query('Extend'),
            ['organization', 'schedules']
        );

        $event = Event::with($relations)->find($id);

        if (! $event) {
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

    /**
     * Get the schedule for the event
     */
    public function schedule(string $id): JsonResponse
    {
        $relations = ExtendHelper::resolve(
            request()->query('Extend'),
            ['event']
        );

        $schedules = EventSchedule::with($relations)->where('event_id', $id)
            ->get();

        if ($schedules->isEmpty()) {
            return not_found();
        }

        return ok(EventScheduleResource::collection($schedules));
    }

    /**
     * Show a specific schedule for an event.
     */
    public function showSchedule(string $id, string $scheduleId): JsonResponse
    {
        $schedule = EventSchedule::where('event_id', $id)
            ->where('id', $scheduleId)
            ->first();

        if (! $schedule) {
            return not_found();
        }

        return ok(new EventScheduleResource($schedule));
    }

    /**
     * Create a new schedule for the event
     *
     * @throws \Exception
     */
    public function storeSchedule(EventScheduleStoreRequest $request, string $id): JsonResponse
    {
        $event = Event::find($id);

        $schedules = $this->eventSchedule->createMany($event, $request->validated());

        return ok(EventScheduleResource::collection($schedules));
    }

    /**
     * Update a schedule for the event
     */
    public function updateSchedule(EventScheduleUpdateRequest $request, string $eventId, string $scheduleId): JsonResponse
    {
        $schedule = EventSchedule::find($scheduleId);

        $schedule->update($request->validated());

        return ok(new EventScheduleResource($schedule));
    }
}
