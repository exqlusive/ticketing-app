<?php

namespace Database\Seeder;

use App\Models\User\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserSeederTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_seeds_a_user_correctly(): void
    {
        $this->seed(UserSeeder::class);

        $this->assertDatabaseHas('users', [
            'email' => 'wesley_hiraki@hotmail.com',
            'first_name' => 'Wesley',
            'last_name' => 'Hiraki',
        ]);

        $user = User::where('email', 'wesley_hiraki@hotmail.com')->first();
        $this->assertTrue(Hash::check('password', $user->password));
    }
}
