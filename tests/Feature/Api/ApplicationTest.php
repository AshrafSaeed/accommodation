<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;

class ApplicationTest extends TestCase
{
    /**
     * User login fields validation test.
     *
     * @return void
     */
    public function test_trivago_api_application_access()
    {
        $this->json('GET', 'api/')
            ->assertStatus(200);
    }

   
}
