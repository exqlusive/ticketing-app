<?php

namespace App\Library\Enums\Event;

use App\Library\Enums\BaseEnumTrait;

enum EventStatusTypeEnum: string
{
    use BaseEnumTrait;

    case CANCELLED = 'cancelled';
    case DRAFT = 'draft';
    case POSTPONED = 'postponed';
    case PUBLISHED = 'published';
    case RESCHEDULED = 'rescheduled';
    case SOLD_OUT = 'sold_out';

    /**
     * Get the display name of the status (e.g., "Sold Out" instead of "sold_out").
     */
    public function displayName(): string
    {
        return match ($this) {
            self::CANCELLED => 'Cancelled',
            self::DRAFT => 'Draft',
            self::POSTPONED => 'Postponed',
            self::PUBLISHED => 'Published',
            self::RESCHEDULED => 'Rescheduled',
            self::SOLD_OUT => 'Sold Out',
        };
    }

    /**
     * Check if the event is considered active.
     */
    public function isActive(): bool
    {
        return in_array($this, [
            self::PUBLISHED,
            self::SOLD_OUT,
        ]);
    }

    /**
     * Get all active statuses.
     */
    public static function activeStatuses(): array
    {
        return [
            self::PUBLISHED->value,
            self::SOLD_OUT->value,
        ];
    }
}
