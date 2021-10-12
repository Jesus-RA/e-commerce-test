<?php

namespace App\Http\Controllers\api\v1\Order;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    public function store(OrderRequest $request)
    {
        if(!$request->products){
            return response()->json([
                'error' => [
                    'message' => 'It is necessary add products to cart to create an order.'
                ]
            ], 400);
        }

        $order = Order::create( $request->all() );
        $soldProducts = [];

        foreach($request->products as $cartProduct)
        {
            $product = Product::find( $cartProduct['id'] );

            if( !$product ){
                return response()->json([
                    'error' => [
                        'messafe' => "Product with id {$cartProduct['id']} not found."
                    ]
                ], 404 );
            }

            if( $product->stock < $cartProduct['quantity']){
                return response()->json([
                    'error' => [
                        'message' => "Product with id {$cartProduct['id']} has not enough stock."
                    ]
                ], 409);
            }

            $product->decrement('stock', $cartProduct['quantity']);

            $soldProducts[] = [
                'product_id' => $product->id,
                'quantity' => $cartProduct['quantity'],
                'total' => ($product->price * $cartProduct['quantity'])
            ];
        }

        $order->products()->attach( $soldProducts );

        return response()->json( new OrderResource( $order ), 201);
    }

}
