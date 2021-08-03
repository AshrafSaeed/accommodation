<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
class LogoutTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_logout_without_token()
    {
        // Simulating login
        $user = User::factory()->create();

        $headers = [
            'Authorization' => 'Bearer ',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $this->json('get', '/api/accommodation', [], $headers)->assertStatus(401);
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_logout()
    {
        $user = User::factory()->create();
        $auth_token = $user->createToken('auth-token')->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer '.$auth_token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $this->json('GET', '/api/accommodation', [], $headers)->assertStatus(200);
        $this->json('POST', '/api/logout', [], $headers)->assertStatus(200);
        
        $user = User::find($user->id);

        $user_token = null;
        if ($user->tokenCan('auth-token')) {
            $user_token = 'token exist';
        }

        $this->assertEquals(null, $user_token);
    }
}