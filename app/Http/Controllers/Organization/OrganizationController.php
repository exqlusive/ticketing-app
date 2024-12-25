<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\OrganizationStoreRequest;
use App\Http\Resources\Organization\OrganizationResource;
use App\Library\Services\Organization\OrganizationService;
use App\Models\Organization\Organization;
use Illuminate\Http\JsonResponse;

class OrganizationController extends Controller
{
    public function __construct(
        private readonly OrganizationService $organization,
    ) {}

    /**
     * Get all users
     */
    public function index(): JsonResponse
    {
        $users = Organization::paginate(100);

        return ok(OrganizationResource::collection($users)->response()->getData(true));
    }

    /**
     * Get a user by id
     */
    public function show(string $id): JsonResponse
    {
        $user = Organization::findOrFail($id);

        return ok(new OrganizationResource($user));
    }

    /**
     * Create a new user
     *
     * @throws \Exception
     */
    public function store(OrganizationStoreRequest $request): JsonResponse
    {
        $user = $this->organization->create($request->validated());

        return ok(new OrganizationResource($user));
    }

    /**
     * Update a user
     *
     * @throws \Exception
     */
    public function update(OrganizationStoreRequest $request, string $id): JsonResponse
    {
        $user = Organization::findOrFail($id);
        $user->update($request->validated());

        return ok(new OrganizationResource($user));
    }
}
