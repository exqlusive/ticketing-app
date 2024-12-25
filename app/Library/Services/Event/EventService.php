<?php

namespace App\Library\Services\Event;

use App\Models\Event\Event;

readonly class EventService
{
    /**
     * Create a new organization.
     *
     * @throws \Exception
     */
    public function create(array $data): Event
    {
        return Event::create($data);
    }
}
