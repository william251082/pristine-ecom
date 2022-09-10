<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        DB::table('category_product')->truncate();

        $userQuantity = 50;
        $categoryQuantity = 50;
        $productQuantity = 50;
        $transactionQuantity = 50;

        User::factory()->count($userQuantity)->create();
        Category::factory()->count($categoryQuantity)->create();
        Product::factory()->count($productQuantity)->create()->each(function ($product) {
            $categories = Category::all()->random(mt_rand(1, 5))->pluck('id');
            $product->categories()->attach($categories);
        });
        Transaction::factory()->count($transactionQuantity)->create()->each(function ($transaction) {

        });
    }
}
