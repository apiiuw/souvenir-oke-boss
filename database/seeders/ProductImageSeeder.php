<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            $totalImages = rand(2, 4);

            for ($i = 1; $i <= $totalImages; $i++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => "products/sample-" . rand(1,5) . ".jpg",
                ]);
            }
        }
    }
}
