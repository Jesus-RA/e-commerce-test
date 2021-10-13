<?php

namespace Database\Seeders\Product;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::factory()->times(20)->create();

        foreach ($products as $product){

            $images = array_filter(Storage::disk( 'products' )->files(), function($file){
                return $file != '.DS_Store';
            });

            if( empty($images) ){

                $initialFiles = array_filter(Storage::disk('products')->files('initial'), function($file){
                    return $file != 'initial/.DS_Store';
                });
                
                foreach($initialFiles as $initialFile){

                    $filename = Str::replace('initial/', '', $initialFile);
                    File::copy(
                        public_path("products/{$initialFile}") ,
                        public_path( "products/{$filename}")
                    );
                }

                $images = array_filter(Storage::disk( 'products' )->files(), function($file){
                    return $file != '.DS_Store';
                });

            }

            $images = array_map(function($image){
                return public_path("products/{$image}");
            }, array_values($images));


            $product
                ->addMedia( $images[ random_int(0, sizeof($images)-1) ] )
                ->toMediaCollection('images');
                
        }
    }
}
