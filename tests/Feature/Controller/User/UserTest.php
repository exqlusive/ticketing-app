<?php

namespace Tests\Feature\Controller\User;

use App\Models\User\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\TestCase;

class UserTest extends TestCase
{
    #[Test]
    public function create_normal_user(): void
    {
        $response = $this->postJson('/api/users', [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ]);

        $response->assertStatus(200);

        $this->assertResponse($response, 200, false);
    }

    #[Test]
    public function create_an_organization_user(): void
    {
        $response = $this->postJson('/api/users', [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
            'is_organizer' => 1,
        ]);

        $response->assertStatus(200);

        $this->assertResponse($response, 200, false);
    }

    #[Test]
    public function create_normal_user_with_invalid_password_length(): void
    {
        $response = $this->postJson('/api/users', [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'paswd',
            'is_organizer' => 1,
        ]);

        $response->assertStatus(422);

        $this->assertResponse($response, 422);
    }

    #[Test]
    public function create_normal_user_with_invalid_email(): void
    {
        $response = $this->postJson('/api/users', [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => str_replace('@', '', fake()->unique()->safeEmail()),
            'password' => 'password',
            'is_organizer' => 1,
        ]);

        $response->assertStatus(422);

        $this->assertResponse($response, 422);
    }

    #[Test]
    public function get_user_by_id(): void
    {
        $user = User::factory()->create();

        $response = $this->getJson('/api/users/'.$user->id);

        $response->assertStatus(200);

        $this->assertResponse($response, 200, false);
    }

    #[Test]
    public function get_user_by_id_not_found(): void
    {
        $response = $this->getJson('/api/users/1');

        $response->assertStatus(404);

        $this->assertResponse($response, 404);
    }

    #[Test]
    public function get_all_users(): void
    {
        $response = $this->getJson('/api/users');

        $response->assertStatus(200);

        $this->assertResponse($response, 200, false);
    }

    #[Test]
    public function update_user(): void
    {
        $user = User::factory()->create();

        $response = $this->putJson('/api/users/'.$user->id, [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ]);

        $response->assertStatus(200);

        $this->assertResponse($response, 200, false);
    }

    #[Test]
    public function update_user_not_found(): void
    {
        $response = $this->putJson('/api/users/1', [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ]);

        $response->assertStatus(404);

        $this->assertResponse($response, 404);
    }
}
