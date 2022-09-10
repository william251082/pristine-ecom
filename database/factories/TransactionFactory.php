<?php

namespace Database\Factories;

use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class TransactionFactory extends Factory
{
    #[ArrayShape([
        'quantity' => "int",
        'buyer_id' => "mixed",
        'product_id' => "mixed"
    ])]
    public function definition(): array
    {
        $seller = Seller::has('product')->get()->random();
        $buyer = User::all()()->except($seller->id)->random();

        return [
            'quantity' => fake()->numberBetween(1, 3),
            'buyer_id' => $buyer->id,
            'product_id' => $seller->products->random()->id
        ];
    }
}
