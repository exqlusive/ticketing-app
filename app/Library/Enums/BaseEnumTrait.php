<?php

namespace App\Library\Enums;

trait BaseEnumTrait
{
    /**
     * Get all enum values as an array.
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all enum names as an array.
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }
}
