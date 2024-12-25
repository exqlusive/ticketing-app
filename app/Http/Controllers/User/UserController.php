<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Resources\User\UserResource;
use App\Library\Services\User\UserService;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $user,
    ) {}

    /**
     * Get all users
     */
    public function index(): JsonResponse
    {
        $users = User::paginate(100);

        return ok(UserResource::collection($users)->response()->getData(true));
    }

    /**
     * Get a user by id
     */
    public function show(string $id): JsonResponse
    {
        $user = User::find($id);

        if (! $user) {
            return not_found();
        }

        return ok(new UserResource($user));
    }

    /**
     * Create a new user
     *
     * @throws \Exception
     */
    public function store(UserStoreRequest $request): JsonResponse
    {
        $user = $this->user->create($request->validated());

        return ok(new UserResource($user));
    }

    /**
     * Update a user
     *
     * @throws \Exception
     */
    public function update(UserStoreRequest $request, string $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->update($request->validated());

        return ok(new UserResource($user));
    }
}
