<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\EventScheduleStoreRequest;
use App\Http\Requests\Event\EventScheduleUpdateRequest;
use App\Http\Resources\Event\EventScheduleResource;
use App\Library\Helpers\ExtendHelper;
use App\Library\Services\Event\EventScheduleService;
use App\Models\Event\Event;
use App\Models\Event\EventSchedule;
use Illuminate\Http\JsonResponse;

class EventScheduleController extends Controller
{
    public function __construct(
        private readonly EventScheduleService $eventSchedule,
    ) {}

    /**
     * Get the schedule for the event
     */
    public function index(Event $event): JsonResponse
    {
        $relations = ExtendHelper::resolve(
            request()->query('Extend'),
            ['event']
        );

        $schedules = EventSchedule::with($relations)->where('event_id', $event->id)
            ->get();

        return ok(EventScheduleResource::collection($schedules));
    }

    /**
     * Show a specific schedule for an event.
     */
    public function show(Event $event, EventSchedule $schedule): JsonResponse
    {
        return ok(new EventScheduleResource($schedule));
    }

    /**
     * Create a new schedule for the event
     *
     * @throws \Exception
     */
    public function store(EventScheduleStoreRequest $request, Event $event): JsonResponse
    {
        $schedules = $this->eventSchedule->createMany($event, $request->validated());

        return ok(EventScheduleResource::collection($schedules));
    }

    /**
     * Update a schedule for the event
     */
    public function update(EventScheduleUpdateRequest $request, Event $event, EventSchedule $schedule): JsonResponse
    {
        $schedule->update($request->validated());

        return ok(new EventScheduleResource($schedule));
    }
}
