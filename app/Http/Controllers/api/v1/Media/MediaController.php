<?php

namespace App\Http\Controllers\api\v1\Media;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MediaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'images' => 'required|array',
            'images.*' => 'image'
        ]);

        $product = Product::find( $request->product_id );

        if( !$product ){
            return response()->json([
                'error' => [
                    'message' => "Product with id {$request->product_id} not found."
                ]
            ], 404);
        }

        $product->addMultipleMediaFromRequest(['images'])
                ->each( fn($image) => $image->toMediaCollection('images') );

        $images = $product->getMedia('images')->map( fn($image) => [
            'type' => 'images',
            'attributes' => [
                'url' => $image->getUrl()
            ]
        ]);

        return response()->json([
            'data' => $images
        ], 201);
    }
}
