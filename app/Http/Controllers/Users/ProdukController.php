<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');
        $search = $request->query('search');
        $sort = $request->query('sort');

        // Query utama (🔥 eager loading biar cepat)
        $query = Product::with(['category', 'images', 'variants']);

        // 🔍 Filter kategori (pakai slug)
        if ($category) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        // 🔎 Search nama produk
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // 🔽 Sorting harga
        if ($sort === 'harga_terendah') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'harga_tertinggi') {
            $query->orderBy('price', 'desc');
        }

        // Ambil data
        $products = $query->paginate(25)->withQueryString();

        // Ambil semua kategori (untuk sidebar)
        $categories = Category::all();

        // Mapping label kategori (opsional, bisa dihapus kalau pakai DB full)
        $categoryLabels = [
            'peralatan-makan-portable' => 'Peralatan Makan Portable',
            'perlengkapan-rumah' => 'Perlengkapan Rumah',
            'tas' => 'Tas',
            'perawatan-kecantikan' => 'Perawatan & Kecantikan',
        ];

        // 🎯 Title dinamis
        if ($category && isset($categoryLabels[$category])) {
            $title = $categoryLabels[$category];
        } else {
            $title = 'Semua Produk';
        }

        if ($search) {
            $title .= ' - Pencarian: ' . $search;
        }

        $cart = Cart::where('session_id', session()->getId())
            ->with('items')
            ->first();

        $cartCount = $cart ? $cart->items->sum('qty') : 0;

        return view('roles.users.produk.index', [
            'title' => $title,
            'products' => $products,
            'categories' => $categories,
            'activeCategory' => $category,
            'cartCount' => $cartCount
        ]);
    }
}
