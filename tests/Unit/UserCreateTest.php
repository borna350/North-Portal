<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserCreateTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testUpdateUser()
    {
        $user = factory(\App\User::class)->create();
        $this->assertNotEmpty($user);
    }
}
