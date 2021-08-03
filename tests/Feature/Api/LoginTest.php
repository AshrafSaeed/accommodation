<?php
namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;

class LoginTest extends TestCase
{
    /**
     * User login fields validation test.
     *
     * @return void
     */
    public function test_requires_email_and_password_login()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(422)
            ->assertJson([
                'message' => "The given data was invalid.",
                'errors' => [
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ]
            ]);
    }

    /**
     * User login test.
     *
     * @return void
     */
    public function test_user_login_successfully()
    {    
        $user = User::factory()->create();
        $payload = ['email' => $user->email, 'password' => 'password'];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'name',
                    'email',
                    'access_token',
                ],
            ]);

    }
}
