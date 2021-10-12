<?php

namespace Tests\Feature\Http\Controllers\api\v1\User;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_index()
    {
        $user = User::factory()->create();
        User::factory()->times(10)->create();

        Sanctum::actingAs( $user );

        $this
            ->get( route('users.index'), ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'type',
                        'id',
                        'attributes' => [
                            'name',
                            'email',
                            'created_at',
                            'updated_at',
                        ]
                    ]
                ]
            ]);
    }

    public function test_store()
    {
        $user = User::factory()->create();
        
        $data = [
            'name' => 'New user',
            'email' => 'example@webforcehq.com',
            'password' => 'password'
        ];

        Sanctum::actingAs( $user );

        $this
            ->post( route('users.store'), $data, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure( [
                'data' => [
                    'type',
                    'id',
                    'attributes' => ['name', 'email', 'created_at', 'updated_at']
                ]
            ] );

        $this->assertEquals( true, User::emailExists($data['email'])->count() );

    }

    public function test_show()
    {
        [$user, $user2] = User::factory()->times(2)->create();

        Sanctum::actingAs( $user );

        $this
            ->get( route('users.show', $user2->id), ['Accept' => 'application/json'] )
            ->assertStatus(200)
            ->assertJsonStructure( [
                'data' => [
                    'type',
                    'id',
                    'attributes' => ['name', 'email', 'created_at', 'updated_at']
                ]
            ] );
    }

    public function test_update()
    {
        [$user, $user2] = User::factory()->times(2)->create();

        Sanctum::actingAs( $user );

        $data = ['name' => 'Name updated'];

        $this
            ->put( route('users.update', $user2->id), $data, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertExactJson([
                'data' => [
                    'type' => 'users',
                    'id' => $user2->id,
                    'attributes' => [
                        'name' => $data['name'],
                        'email' => $user2->email,
                        'created_at' => $user2->created_at,
                        'updated_at' => $user2->updated_at,
                    ]
                ]
            ]);

    }

    public function test_destroy()
    {
        [$user, $user2] = User::factory()->times(2)->create();

        Sanctum::actingAs( $user );

        $this
            ->delete( route('users.destroy', $user2->id), [], ['Accept' => 'application/json'])
            ->assertStatus(204);
    }
}
