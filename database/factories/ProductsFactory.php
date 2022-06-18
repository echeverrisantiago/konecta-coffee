<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $categories = ['Bebidas', 'Panes', 'Pasteles'];
        $prices = [1000, 2000, 3500, 5000, 32000, 20000, 45000];

        return [
            'name' => $this->faker->unique()->text(10),
            'reference' => 'KNA' . rand(001,999),
            'price' => $prices[rand(0, count($prices) - 1)],
            'weight' => $this->faker->numberBetween(3, 30),
            'category' => $categories[rand(0, count($categories) - 1)],
            'stock' => rand(0, 20)
        ];
    }
}
