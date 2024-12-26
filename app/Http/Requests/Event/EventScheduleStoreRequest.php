<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class EventScheduleStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            '*.date' => ['required', 'string', 'date_format:Y-m-d', 'after_or_equal:today'],
            '*.start_time' => ['required', 'date_format:H:i'],
            '*.end_time' => ['required', 'date_format:H:i', 'after:*.start_time'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $event = $this->route('event') ? $this->route('event') : null;

            if (! $event) {
                $validator->errors()->add('event_id', 'The specified event does not exist.');

                return;
            }

            foreach ($this->all() as $index => $schedule) {
                $eventStartDate = $event->start_date->toDateString();
                $eventEndDate = $event->end_date->toDateString();

                if ($schedule['date'] < $eventStartDate || $schedule['date'] > $eventEndDate) {
                    $validator->errors()->add(
                        "{$index}.date",
                        "The date must fall within the event dates ({$eventStartDate} to {$eventEndDate})."
                    );
                }
            }
        });
    }
}
