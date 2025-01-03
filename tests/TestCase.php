<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\TestResponse;
use OwowAgency\Snapshots\MatchesSnapshots;

abstract class TestCase extends BaseTestCase
{
    use MatchesSnapshots, RefreshDatabase;

    /**
     * Should seed
     */
    protected $seed = true;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        Queue::fake();

        Notification::fake();
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
