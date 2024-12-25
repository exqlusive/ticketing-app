<?php

namespace App\Library\Services\Organization;

use App\Models\Organization\Organization;

readonly class OrganizationService
{
    /**
     * Create a new organization.
     *
     * @throws \Exception
     */
    public function create(array $data): Organization
    {
        return Organization::create($data);
    }
}
