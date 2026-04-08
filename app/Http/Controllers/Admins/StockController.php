<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images']);

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sort by stock level to prioritize low stock items
        $products = $query->orderBy('stock', 'asc')->paginate(15);
        $categories = Category::all();

        return view('roles.admins.stock.index', [
            'title' => 'Manajemen Stok',
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        $product->update([
            'stock' => $request->stock
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Stok berhasil diperbarui!',
                'stock' => $product->stock
            ]);
        }

        return redirect()->route('admin.stock')->with('success', 'Stok berhasil diperbarui!');
    }
}
