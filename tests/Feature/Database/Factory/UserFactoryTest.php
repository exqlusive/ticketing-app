<?php

namespace Tests\Feature\Database\Factory;

use App\Models\User\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserFactoryTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_user(): void
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $user->email,
        ]);
    }
}
