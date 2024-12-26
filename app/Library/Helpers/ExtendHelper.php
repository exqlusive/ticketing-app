<?php

namespace App\Library\Helpers;

class ExtendHelper
{
    /**
     * Resolve valid relations based on the `Extend` query parameter.
     */
    public static function resolve(?string $extend, array $allowedRelations): array
    {
        if (! $extend) {
            return [];
        }

        $requestedRelations = explode(',', $extend);

        return array_intersect(
            array_map('strtolower', $requestedRelations),
            array_map('strtolower', $allowedRelations)
        );
    }
}
