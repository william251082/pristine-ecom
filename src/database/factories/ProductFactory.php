<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class ProductFactory extends Factory
{
    #[ArrayShape([
        'name' => "string",
        'description' => "string",
        'quantity' => "int",
        'status' => "mixed",
        'image' => "mixed",
        'seller_id' => "\Illuminate\Support\HigherOrderCollectionProxy|mixed"
    ])]
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->paragraph(1),
            'quantity' => fake()->numberBetween(1, 10),
            'status' => fake()->randomElement([Product::AVAILABLE_PRODUCT, Product::UNAVAILABLE_PRODUCT]),
            'image' => fake()->randomElement(['1.jpg', '2.jpg', '3.jpg']),
            'seller_id' => User::all()->random()->id
        ];
    }
}
