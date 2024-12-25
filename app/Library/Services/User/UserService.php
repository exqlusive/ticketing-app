<?php

namespace App\Library\Services\User;

use App\Models\User\User;

readonly class UserService
{
    /**
     * Create a new user.
     *
     * @throws \Exception
     */
    public function create(array $data): User
    {
        return User::create($data);
    }
}
