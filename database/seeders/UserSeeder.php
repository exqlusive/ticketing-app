<?php

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'wesley_hiraki@hotmail.com'],
            [
                'first_name' => 'Wesley',
                'last_name' => 'Hiraki',
                'password' => bcrypt('password'),
            ]
        );
    }
}
