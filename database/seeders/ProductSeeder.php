<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        for ($i = 1; $i <= 50; $i++) {
            $category = $categories->random();

            Product::create([
                'category_id' => $category->id,
                'name' => $this->generateProductName($category->name, $i),
                'slug' => Str::slug($category->name . ' ' . $i),
                'price' => rand(10000, 150000),
                'min_order' => rand(1, 5),
                'description' => 'Produk berkualitas tinggi dengan bahan premium. Cocok untuk kebutuhan sehari-hari maupun hadiah spesial.',
            ]);
        }
    }

    private function generateProductName($category, $i)
    {
        $names = [
            'Peralatan Makan Portable' => ['Lunch Box', 'Botol Minum', 'Sendok Set', 'Kotak Bekal'],
            'Perlengkapan Rumah' => ['Karpet', 'Bantal', 'Rak Serbaguna', 'Tempat Penyimpanan'],
            'Tas' => ['Tas Premium', 'Tas Sekolah', 'Tas Travel', 'Tas Selempang'],
            'Perawatan & Kecantikan' => ['Skincare Set', 'Body Care', 'Face Wash', 'Serum Wajah'],
        ];

        return $names[$category][array_rand($names[$category])] . " {$i}";
    }
}
