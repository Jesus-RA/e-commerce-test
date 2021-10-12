<?php

namespace App\Http\Controllers\api\v1\Product;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCollection;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = new ProductCollection( Product::all() );

        return response()->json( $products, 200 );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $slug = Str::slug($request->name);

        if( Product::exists( $slug )->first() ){

            return response()->json([
                'error' => [
                    'message' => 'The product already exists.'
                ]
            ], 404);

        }

        $data = array_merge( $request->all(), ['slug' => $slug]);
        $product = Product::create( $data );

        if( $request->hasFile('images') ){

            $product
                ->addMultipleMediaFromRequest(['images'])
                ->each( fn($file)=> $file->toMediaCollection('images') );

        }

        return response()->json([
            'data' => new ProductResource( $product )
        ], 201 );

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Int $productId)
    {
        $product = Product::find( $productId );

        if( !$product ){
            return response()->json([
                'error' => [
                    'message' => "Product with id {$productId} not found."
                ]
            ], 404);
        }
        
        return response()->json([
            'data' => new ProductResource( $product )
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Int $productId)
    {
        $product = Product::find( $productId );
        
        if( !$product ){
            return response()->json([
                'error' => [
                    'message' => "Product with id {$productId} not found."
                ]
            ], 404);
        }

        if( $request->hasFile('images') ){
            $product
                ->addMultipleMediaFromRequest(['images'])
                ->each( fn($file)=> $file->toMediaCollection('images') );
        }

        $product->update( $request->all() );

        return response()->json([
            'data' => new ProductResource( $product )
        ], 201 );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $productId)
    {
        $product = Product::find( $productId );
        
        if( !$product ){
            return response()->json([
                'error' => [
                    'message' => "Product with id {$productId} not found."
                ]
            ], 404);
        }

        $product->delete();

        return response()->noContent();
    }
}
