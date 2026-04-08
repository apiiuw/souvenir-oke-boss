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
            'color_id' => 'required|exists:product_colors,id',
            'qty' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        if ($request->qty > $product->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi. Sisa stok: ' . $product->stock
            ], 422);
        }

        $cart = $this->getCart();

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->where('variant_id', $request->variant_id)
            ->where('color_id', $request->color_id)
            ->first();

        if ($item) {
            $item->qty += $request->qty;
            $item->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'variant_id' => $request->variant_id,
                'color_id' => $request->color_id,
                'qty' => $request->qty
            ]);
        }

        return response()->json([
            'success' => true,
            'total' => $cart->items()->sum('qty')
        ]);
    }

    public function buyNow(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id',
            'color_id' => 'required|exists:product_colors,id',
            'qty' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        if ($request->qty > $product->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi. Sisa stok: ' . $product->stock
            ], 422);
        }

        $sessionId = session()->getId() . '_buynow';

        $cart = Cart::firstOrCreate([
            'session_id' => $sessionId
        ]);

        $cart->items()->delete();

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $request->product_id,
            'variant_id' => $request->variant_id,
            'color_id' => $request->color_id,
            'qty' => $request->qty
        ]);

        return response()->json([
            'success' => true,
            'redirect' => route('checkout.index', ['type' => 'buynow'])
        ]);
    }

    public function index()
    {
        $cart = $this->getCart()->load([
            'items.product.images',
            'items.variant',
            'items.color'
        ]);

        return view('roles.users.keranjang-produk.index', [
            'cart' => $cart,
            'title' => 'Keranjang'
        ]);
    }

    public function update(Request $request, $id)
    {
        $cart = $this->getCart();
        $item = CartItem::where('cart_id', $cart->id)->findOrFail($id);
        
        if ($request->action == 'increase') {
            $item->qty += 1;
            $item->save();
        } elseif ($request->action == 'decrease') {
            if ($item->qty > 1) {
                $item->qty -= 1;
                $item->save();
            } else {
                $item->delete();
            }
        }
        
        return back();
    }

    public function destroy($id)
    {
        $cart = $this->getCart();
        $item = CartItem::where('cart_id', $cart->id)->findOrFail($id);
        $item->delete();
        
        return back()->with('success_delete', 'Produk berhasil dihapus dari keranjang.');
    }
}
