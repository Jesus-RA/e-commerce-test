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
        
        $this->populateImages();

        foreach ($products as $product){

            $images = array_filter(File::files( public_path('images/products') ), function($file){
                return $file != '.DS_Store';
            });

            if( empty($images) ){

                $this->populateImages();

                $images = array_filter(File::files( public_path('images/products') ), function($file){
                    return $file != '.DS_Store';
                });

            }

            $randomNumber = random_int(0, sizeof($images)-1);
            $product
                ->addMedia( $images[ $randomNumber ]->getPathname() )
                ->toMediaCollection('images');
                
        }
    }

    public function populateImages()
    {
        $initialFiles = array_filter(File::files( public_path('images/initial-images') ), function($file){
            return $file != 'initial/.DS_Store';
        });

        foreach($initialFiles as $initialFile){

            File::copy(
                $initialFile->getPathname() ,
                public_path( "images/products/{$initialFile->getFilename()}")
            );
        }
    }
}
