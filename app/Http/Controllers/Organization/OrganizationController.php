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
        $organizations = Organization::paginate(100);

        return ok(OrganizationResource::collection($organizations)->response()->getData(true));
    }

    /**
     * Get an organization by id
     */
    public function show(string $id): JsonResponse
    {
        $organization = Organization::find($id);

        if (! $organization) {
            return not_found();
        }

        return ok(new OrganizationResource($organization));
    }

    /**
     * Create a new organization
     *
     * @throws \Exception
     */
    public function store(OrganizationStoreRequest $request): JsonResponse
    {
        $organization = $this->organization->create($request->validated());

        return ok(new OrganizationResource($organization));
    }

    /**
     * Update a organization
     *
     * @throws \Exception
     */
    public function update(OrganizationStoreRequest $request, string $id): JsonResponse
    {
        $organization = Organization::findOrFail($id);
        $organization->update($request->validated());

        return ok(new OrganizationResource($organization));
    }
}
