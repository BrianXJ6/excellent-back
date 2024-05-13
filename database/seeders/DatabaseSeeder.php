<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        Order::factory(3)
            ->hasAttached(
                Product::factory(3)->has(ProductImage::factory()->count(3)),
                ['quantity' => fake()->randomDigitNotZero()]
            )
            ->create();
    }
}
