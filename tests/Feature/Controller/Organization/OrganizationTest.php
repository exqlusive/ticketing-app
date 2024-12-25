<?php

namespace Tests\Feature\Controller\Organization;

use App\Models\Organization\Organization;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\TestCase;

class OrganizationTest extends TestCase
{
    #[Test]
    public function create_an_organization(): void
    {
        $response = $this->postJson('/api/organizations', [
            'name' => fake()->firstName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->lastName(),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'postal_code' => fake()->postcode(),
            'country' => fake()->countryCode(),
        ]);

        $response->assertStatus(200);

        $this->assertResponse($response, 200, false);
    }

    #[Test]
    public function create_an_organization_with_invalid_name(): void
    {
        $response = $this->postJson('/api/organizations', [
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->lastName(),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'postal_code' => fake()->postcode(),
            'country' => fake()->countryCode(),
        ]);

        $response->assertStatus(422);

        $this->assertResponse($response, 422);
    }

    #[Test]
    public function get_organization_by_id(): void
    {
        $organization = Organization::factory()->create();

        $response = $this->getJson('/api/organizations/'.$organization->id);

        $response->assertStatus(200);

        $this->assertResponse($response, 200, false);
    }

    #[Test]
    public function get_organization_by_id_not_found(): void
    {
        $response = $this->getJson('/api/organizations/1');

        $response->assertStatus(404);

        $this->assertResponse($response, 404);
    }

    #[Test]
    public function get_all_organizations(): void
    {
        $response = $this->getJson('/api/organizations');

        $response->assertStatus(200);

        $this->assertResponse($response, 200, false);
    }

    #[Test]
    public function update_organization(): void
    {
        $organization = Organization::factory()->create();

        $response = $this->putJson('/api/organizations/'.$organization->id, [
            'name' => fake()->firstName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->lastName(),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'postal_code' => fake()->postcode(),
            'country' => fake()->countryCode(),
        ]);

        $response->assertStatus(200);

        $this->assertResponse($response, 200, false);
    }

    #[Test]
    public function update_organization_not_found(): void
    {
        $response = $this->putJson('/api/organizations/1', [
            'name' => fake()->firstName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->lastName(),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'postal_code' => fake()->postcode(),
            'country' => fake()->countryCode(),
        ]);

        $response->assertStatus(404);

        $this->assertResponse($response, 404);
    }
}
