<?php

namespace Database\Seeders;

use App\Models\Organization\Organization;
use App\Models\User\Role;
use Illuminate\Database\Seeder;

class OrganizationRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = Organization::all();

        foreach ($organizations as $organization) {
            $roles = ['Admin', 'User'];

            foreach ($roles as $roleName) {
                Role::updateOrCreate(
                    [
                        'name' => $roleName,
                        'organization_id' => $organization->id,
                    ],
                    [
                        'guard_name' => 'web',
                    ]
                );
            }
        }
    }
}
