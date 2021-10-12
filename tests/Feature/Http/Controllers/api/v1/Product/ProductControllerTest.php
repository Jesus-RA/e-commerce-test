<?php

namespace Tests\Feature\Http\Controllers\api\v1\Product;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        Product::factory()->times(20)->create();

        Sanctum::actingAs( User::factory()->create() );

        $this
            ->get( route('products.index'), ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'type',
                        'id',
                        'attributes' => [
                            'name',
                            'slug',
                            'description',
                            'price',
                            'status',
                            'stock'
                        ]
                    ]
                ]
            ]);
    }

    public function test_store_without_uploading_images()
    {
        $product = Product::factory()->make();

        Sanctum::actingAs( User::factory()->create() );

        $this
            ->post( route('products.store'), $product->toArray(), ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'type',
                    'id',
                    'attributes' => [
                        'name',
                        'slug',
                        'description',
                        'price',
                        'status',
                        'stock',
                        'images' => [
                            '*' => [ 'url' ]
                        ]
                    ]
                ]
            ]);
    }

    public function test_show()
    {
        $product = Product::factory()->create();

        Sanctum::actingAs( User::factory()->create() );

        $this
            ->get( route('products.show', $product->id), ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'type',
                    'id',
                    'attributes' => [
                        'name',
                        'slug',
                        'description',
                        'price',
                        'status',
                        'stock',
                        'images' => [
                            '*' => [ 'url' ]
                        ]
                    ]
                ]
            ]);
    }

    public function test_update_without_uploading_images()
    {
        $product = Product::factory()->create();

        $data = ['name' => 'Product edited'];

        Sanctum::actingAs( User::factory()->create() );

        $this
            ->put( route('products.update', $product->id), $data, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'type',
                    'id',
                    'attributes' => [
                        'name',
                        'slug',
                        'description',
                        'price',
                        'status',
                        'stock',
                        'images' => [
                            '*' => [ 'url' ]
                        ]
                    ]
                ]
            ]);
    }

    public function test_destroy()
    {
        $product = Product::factory()->create();
        Sanctum::actingAs( User::factory()->create() );

        $this
            ->delete( route('products.destroy', $product->id), [], ['Accept' => 'application/json'])
            ->assertStatus(204);
    }

    public function test_index_without_products()
    {
        Sanctum::actingAs( User::factory()->create() );

        $this
            ->get( route('products.index'), ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => []
            ]);
    }

    public function test_can_not_create_an_existing_product()
    {
        $product = Product::factory()->make();
        $product->slug = Str::slug( $product->name );
        $product->save();
        
        Sanctum::actingAs( User::factory()->create() );

        $this
            ->post( route('products.store'), $product->toArray(), ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure([
                'error' => [
                    'message'
                ]
            ]);
    }

    public function test_can_not_show_a_product_that_does_not_exist()
    {
        Sanctum::actingAs( User::factory()->create() );

        $this
            ->get( route('products.show', 1), ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure([
                'error' => [
                    'message'
                ]
            ]);
    }

    public function test_can_not_update_a_product_that_does_not_exist()
    {
        Sanctum::actingAs( User::factory()->create() );
        $data = ['name' => 'This product does not exists'];

        $this
            ->put( route('products.update', 1), $data, ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure([
                'error' => [
                    'message'
                ]
            ]);
    }

    public function test_can_not_delete_a_product_that_does_not_exist()
    {
        Sanctum::actingAs( User::factory()->create() );

        $this
            ->delete( route('products.destroy', 1), ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure([
                'error' => [
                    'message'
                ]
            ]);
    }

    public function test_store_uploading_images(){
        Storage::fake('images');
        $product = Product::factory()->make();

        $product->images = [
            UploadedFile::fake()->image('product-01.jpg'),
            UploadedFile::fake()->image('product-02.jpg'),
            UploadedFile::fake()->image('product-03.jpg')
        ];

        Sanctum::actingAs( User::factory()->create() );

        $response = $this
            ->post( route('products.store'), $product->toArray(), ['Accept' => 'application/json'])
            ->assertStatus( 201 )
            ->assertJsonStructure([
                'data' => [
                    'type',
                    'id',
                    'attributes' => [
                        'name',
                        'slug',
                        'description',
                        'price',
                        'status',
                        'stock',
                        'images' => [
                            '*' => [ 'url' ]
                        ]
                    ]
                ]
            ]);

        $this->assertEquals( sizeof($product->images), count($response['data']['attributes']['images']));

    }

    public function test_update_uploading_images()
    {
        $product = Product::factory()->create();
        Storage::fake('images');

        $data['images'] = [
            UploadedFile::fake()->image('product-01.jpg')
        ];

        Sanctum::actingAs( User::factory()->create() );

        $response = $this
            ->put( route('products.update', $product->id), $data, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'type',
                    'id',
                    'attributes' => [
                        'name',
                        'slug',
                        'description',
                        'price',
                        'status',
                        'stock',
                        'images' => [
                            '*' => [ 'url' ]
                        ]
                    ]
                ]
            ]);

        $this->assertEquals( count($response['data']['attributes']['images']), $product->getMedia('images')->count());
    }

}
