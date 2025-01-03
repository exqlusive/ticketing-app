<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            OrganizationSeeder::class,
            OrganizationRolesSeeder::class,
            EventSeeder::class,
            EventScheduleSeeder::class,
            TicketSeeder::class,
        ]);
    }
}
