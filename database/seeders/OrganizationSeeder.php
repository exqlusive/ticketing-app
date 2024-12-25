<?php

namespace Database\Seeders;

use App\Models\Organization\Organization;
use App\Models\User\User;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organization = Organization::firstOrCreate(
            ['name' => 'Pixxelfy'],
            ['name' => 'Pixxelfy']
        );

        $owner = User::first();
        $owner->organizations()->syncWithoutDetaching([$organization->id]);
    }
}
