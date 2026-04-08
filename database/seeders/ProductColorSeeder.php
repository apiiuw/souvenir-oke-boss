<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['name' => 'Merah', 'image' => 'colors/red.jpg'],
            ['name' => 'Biru', 'image' => 'colors/blue.jpg'],
            ['name' => 'Hijau', 'image' => 'colors/green.jpg'],
            ['name' => 'Hitam', 'image' => 'colors/black.jpg'],
            ['name' => 'Putih', 'image' => 'colors/white.jpg'],
        ];

        foreach (\App\Models\Product::all() as $product) {
            collect($colors)->random(rand(2, 4))->each(function ($color) use ($product) {
                \App\Models\ProductColor::create([
                    'product_id' => $product->id,
                    'name' => $color['name'],
                    'image' => $color['image'],
                ]);
            });
        }
    }
}
