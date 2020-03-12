<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserEditTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testEditUser()
    {
        $user = factory(\App\User::class)->create();

        $this->assertNotEmpty($user);

        $response = $this->actingAs($user)
            ->get(route('edit-profile'));

        $response->assertStatus(200);

        $user->update([
            'name' => 'Sahinur Rahman',
            'email' => 'sahinur@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'), // password
            'remember_token' => Str::random(10),
        ]);

        $this->assertEquals($user->name, 'Sahinur Rahman');

        $this->assertEquals($user->email, 'sahinur@gmail.com');
    }
}
