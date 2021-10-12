<?php

namespace Tests\Feature\Http\Controllers\api\v1\Order;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_an_order()
    {
        $order = Order::factory()->make();
        $products = Product::factory()->times(10)->create();

        $order->products = array_map(fn($product)=> [
            'id' => $product['id'],
            'quantity' => $product['stock'] > 4 ? $product['stock'] - 3 : $product['stock'],
        ], $products->toArray());

        $this
            ->post( route('orders.store'), $order->toArray(), ['Accept' => 'application/json'])
            ->assertStatus( 201 )
            ->assertJsonStructure([
                'data' => [
                    'type',
                    'id',
                ]
            ]);
    }

    public function test_it_can_not_create_an_order_without_products()
    {
        $order = Order::factory()->make();

        $this
            ->post( route('orders.store'), $order->toArray(), ['Accept' => 'application/json'])
            ->assertStatus( 400 )
            ->assertJsonStructure([
                'error' => [
                    'message'
                ]
            ]);
    }
}
