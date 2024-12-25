<?php

namespace Tests\Feature;

use Illuminate\Testing\TestResponse;
use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Set up the test
     */
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'auth.throttle_max_attempts' => 3,
            'auth.login_throttle_max_attempts' => 2,
        ]);
    }

    /**
     * Asserts a response.
     */
    protected function assertResponse(
        TestResponse $response,
        int $status = 200,
        bool $assertStructure = true,
        bool $assertContent = false,
    ): void {
        $response->assertStatus($status);

        if ($assertStructure) {
            $this->assertJsonStructureSnapshot($response);
        } elseif ($assertContent) {
            $this->assertMatchesJsonSnapshot($response);
        }
    }
}
