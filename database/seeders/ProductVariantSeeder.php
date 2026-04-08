<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariant;

class ProductVariantSeeder extends Seeder
{
    public function run(): void
    {
        $variants = [
            'Mickey Mouse',
            'SpongeBob',
            'Batman',
            'Hello Kitty',
            'Doraemon',
        ];

        $products = Product::all();

        $variantImages = [
            'Mickey Mouse' => 'variants/mickey.png',
            'SpongeBob' => 'variants/spongebob.png',
            'Batman' => 'variants/batman.png',
            'Hello Kitty' => 'variants/hellokitty.png',
            'Doraemon' => 'variants/doraemon.png',
        ];

        foreach ($products as $product) {
            $selectedVariants = collect($variants)->random(rand(1, 3));
            foreach ($selectedVariants as $variantName) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'name' => $variantName,
                    'image' => $variantImages[$variantName] ?? 'variants/default.png',
                ]);
            }
        }
    }
}
