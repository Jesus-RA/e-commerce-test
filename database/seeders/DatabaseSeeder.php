<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\Product\ProductSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'email' => 'admin@webforcehq.com',
            'password' => Hash::make('webforce')
        ]);

        $this->call(ProductSeeder::class);
        
        User::factory(10)->create();
    }
}
