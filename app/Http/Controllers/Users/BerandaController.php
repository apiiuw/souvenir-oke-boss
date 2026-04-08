<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;

class BerandaController extends Controller
{
    public function index()
    {
        // Clean up old carts
        Cart::where('updated_at', '<=', now()->subHour())->delete();

        // Fetch categories for the explorer section (max 4)
        $categories = Category::take(4)->get();

        // Fetch featured products (latest 8, prioritized by stock)
        $featuredProducts = Product::with('images')
            ->orderByRaw('stock > 0 DESC')
            ->latest()
            ->take(8)
            ->get();

        return view('roles.users.beranda.index', [
            'title' => 'Beranda',
            'categories' => $categories,
            'featuredProducts' => $featuredProducts
        ]);
    }
}
