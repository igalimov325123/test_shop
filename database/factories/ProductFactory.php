<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'          => $this->faker->word,
            'description'   => $this->faker->text,
            'price'         => $this->faker->randomFloat(2, 0, 9999.99),
            'image'         => $this->faker->image,
            'created_at'    => $this->faker->date,
            'is_published'  => true,
            'published_at'  => $this->faker->date,
        ];
    }
}
