<?php

namespace Tests\Feature\Http\Controllers\api\v1\Media;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Laravel\Sanctum\Sanctum;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MediaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_add_images_to_a_product()
    {
        $product = Product::factory()->create();
        Sanctum::actingAs( User::factory()->create() );
        Storage::fake('images');

        $data = [
            'product_id' => $product->id,
            'images' => [
                UploadedFile::fake()->image('product-01.jpg'),
                UploadedFile::fake()->image('product-02.jpg'),
                UploadedFile::fake()->image('product-03.jpg'),
            ]
        ];

        $this
            ->post( route('media.store'), $data, ['Accept' => 'application/json'] )
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'type',
                        'attributes' => [
                            'url'
                        ]
                    ]
                ]
            ]);
    }

    public function test_can_not_add_images_to_not_existing_product()
    {
        Sanctum::actingAs( User::factory()->create() );
        Storage::fake('images');

        $data = [
            'product_id' => 1,
            'images' => [
                UploadedFile::fake()->image('product-01.jpg'),
                UploadedFile::fake()->image('product-02.jpg'),
                UploadedFile::fake()->image('product-03.jpg'),
            ]
        ];

        $this
            ->post( route('media.store'), $data, ['Accept' => 'application/json'] )
            ->assertStatus(404)
            ->assertJsonStructure([
                'error' => [
                    'message'
                ]
            ]);
    }
}
