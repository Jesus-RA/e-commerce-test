<?php

namespace Tests\Feature\Http\Controllers\api\v1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_register_user()
    {
        $data = [
            'name' => 'Usuario nuevo',
            'email' => 'example@webforcehq.com',
            'password' => 'password'
        ];

        $this
            ->post( route('register'), $data, ['Accept' => 'application/json'])
            ->assertStatus(201);
    }
}
