<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Kiosk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_name' => fake()->word(),
            'category_id' => fake()->randomElement(Category::pluck('id')->toArray()),
            'qty' => fake()->numberBetween(0, 100),
            'unit' => fake()->randomElement(['pcs', 'kg', 'box', 'pack', 'sak']),
            'price_per_unit' => fake()->numberBetween(1000000, 10000000),
            'description' => fake()->paragraph(5),
            'product_picture' => 'product-picture/default.jpg',
            'kiosk_id' => fake()->randomElement(Kiosk::pluck('id')->toArray())
        ];
    }
}
