<?php
namespace Tests\Feature\Api;

use Tests\TestCase;

class RegisterTest extends TestCase
{
   
    /**
     * Validation test all register fields.
     *
     * @return void
     */
    public function tests_requires_name_email_and_password()
    {
        $this->json('post', '/api/register')
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                "errors" => [
                    'name' => ['The name field is required.'],
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ]
            ]);
    }

    /**
     * Validation test confirmation password.
     *
     * @return void
     */
    public function tests_require_password_confirmation()
    {
        $payload = [
            'name' => 'Test User',
            'email' => 'test_user@trivago.com',
            'password' => 'abc12345',
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                "errors" => [
                    'password' => ['The password confirmation does not match.'],
                ]
            ]);
    }

    /**
     * Validation Test Password less the 8 chracter
     *
     * @return void
     */
    public function tests_password_should_not_less_then_eight_char()
    {
        $payload = [
            'name' => 'Test User',
            'email' => 'test_user@trivago.com',
            'password' => 'top',
            'password_confirmation' => 'top',
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                "errors" => [
                    'password' => ['The password must be at least 8 characters.'],
                ]
            ]);
    }

     /**
     * Test Register User
     *
     * @return void
     */
    public function tests_registers_successfully()
    {
        $faker = \Faker\Factory::create();

        $payload = [
            'name' => 'Test User',
            'email' => $faker->email(),
            'password' => 'abc12345',
            'password_confirmation' => 'abc12345',
        ];

        $this->json('post', '/api/register', $payload)
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
