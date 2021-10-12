<?php

namespace Tests\Feature\Http\Controllers\api\v1;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_login()
    {
        $data = [
            'email' => 'example@webforcehq.com',
            'password' => 'password'
        ];
        
        User::factory()->create(['email' => $data['email'], 'password' => Hash::make($data['password'])]);

        $this
            ->post( route('login'), $data, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'user',
                ]
            ]);
    }
}
