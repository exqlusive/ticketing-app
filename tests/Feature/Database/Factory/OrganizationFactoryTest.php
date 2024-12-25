<?php

namespace Tests\Feature\Database\Factory;

use App\Models\Organization\Organization;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class OrganizationFactoryTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_an_organization(): void
    {
        $organization = Organization::factory()->create();

        $this->assertDatabaseHas('organizations', [
            'id' => $organization->id,
            'name' => $organization->name,
        ]);
    }
}
