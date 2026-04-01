<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariant;

class ProductVariantSeeder extends Seeder
{
    public function run(): void
    {
        $colors = [
            ['name' => 'Merah', 'image' => 'colors/red.jpg'],
            ['name' => 'Biru', 'image' => 'colors/blue.jpg'],
            ['name' => 'Hijau', 'image' => 'colors/green.jpg'],
            ['name' => 'Hitam', 'image' => 'colors/black.jpg'],
        ];

        $products = Product::all();

        foreach ($products as $product) {
            $selectedColors = collect($colors)->random(rand(2, 4));

            foreach ($selectedColors as $color) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'name' => $color['name'],
                    'image' => $color['image'],
                ]);
            }
        }
    }
}
