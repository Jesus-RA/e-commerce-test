<?php

namespace Database\Factories\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->colorName(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->text(),
            'price' => $this->faker->randomFloat(2),
            'status' => $this->faker->randomElement([true, false]),
            'stock' => random_int(0, 20)
        ];
    }
}
