<?php

namespace App\Http\Requests\Event;

use App\Models\Event\Event;
use App\Models\Event\EventSchedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class EventScheduleUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ];
    }

    /**
     * Additional validation logic for duplicate checks and event date range.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $event = $this->route('event') ? $this->route('event') : null;
            $scheduleId = $this->route('scheduleId');

            if (! $event) {
                $validator->errors()->add('event_id', 'The specified event does not exist.');

                return;
            }

            $eventStartDate = $event->start_date->toDateString();
            $eventEndDate = $event->end_date->toDateString();

            if ($this->input('date') < $eventStartDate || $this->input('date') > $eventEndDate) {
                $validator->errors()->add(
                    'date',
                    "The date must fall within the event dates ({$eventStartDate} to {$eventEndDate})."
                );
            }

            $exists = EventSchedule::where('event_id', $event->id)
                ->where('date', $this->input('date'))
                ->where('start_time', $this->input('start_time'))
                ->where('end_time', $this->input('end_time'))
                ->where('id', '!=', $scheduleId)
                ->exists();

            if ($exists) {
                $validator->errors()->add(
                    'schedule',
                    sprintf(
                        'A schedule already exists for date %s and time %s - %s.',
                        Carbon::parse($this->input('date'))->toDateString(),
                        $this->input('start_time'),
                        $this->input('end_time')
                    )
                );
            }
        });
    }
}
