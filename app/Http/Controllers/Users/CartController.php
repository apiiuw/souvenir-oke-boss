<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    private function getCart()
    {
        $sessionId = session()->getId();

        return Cart::firstOrCreate([
            'session_id' => $sessionId
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id',
            'qty' => 'required|integer|min:1'
        ]);

        $cart = $this->getCart();

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->where('variant_id', $request->variant_id)
            ->first();

        if ($item) {
            $item->qty += $request->qty;
            $item->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'variant_id' => $request->variant_id, // ✅ FIX
                'qty' => $request->qty
            ]);
        }

        return response()->json([
            'success' => true,
            'total' => $cart->items()->sum('qty')
        ]);
    }

    public function index()
    {
        $cart = $this->getCart()->load([
            'items.product.images',
            'items.variant'
        ]);

        return view('roles.users.keranjang-produk.index', [
            'cart' => $cart,
            'title' => 'Keranjang'
        ]);
    }
}
