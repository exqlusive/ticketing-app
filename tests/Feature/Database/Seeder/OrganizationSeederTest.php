<?php

namespace Database\Seeder;

use App\Models\Organization\Organization;
use App\Models\User\User;
use Database\Seeders\OrganizationSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class OrganizationSeederTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_seeds_an_organization_and_links_user(): void
    {
        $owner = User::where(['first_name' => 'Wesley', 'last_name' => 'Hiraki'])->first();

        $this->seed(OrganizationSeeder::class);

        $this->assertDatabaseHas('organizations', [
            'name' => 'Pixxelfy',
        ]);

        $organization = Organization::where('name', 'Pixxelfy')->first();

        $this->assertTrue(
            $owner->organizations()->where('organization_user.organization_id', $organization->id)->exists()
        );
    }
}
