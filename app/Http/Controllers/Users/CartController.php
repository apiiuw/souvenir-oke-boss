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
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id',
            'color_id' => 'required|exists:product_colors,id',
            'qty' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($validated['product_id']);
        if ($validated['qty'] < $product->min_order) {
            return response()->json([
                'success' => false,
                'message' => 'Minimal pemesanan untuk produk ini adalah ' . $product->min_order . ' pcs.'
            ], 422);
        }

        if ($validated['qty'] > $product->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi. Sisa stok: ' . $product->stock
            ], 422);
        }

        $cart = $this->getCart();

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $validated['product_id'])
            ->where('variant_id', $validated['variant_id'])
            ->where('color_id', $validated['color_id'])
            ->first();

        if ($item) {
            if (($item->qty + $validated['qty']) > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi. Sisa stok: ' . $product->stock
                ], 422);
            }

            $item->qty += $validated['qty'];
            $item->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $validated['product_id'],
                'variant_id' => $validated['variant_id'],
                'color_id' => $validated['color_id'],
                'qty' => $validated['qty']
            ]);
        }

        return response()->json([
            'success' => true,
            'total' => $cart->items()->sum('qty')
        ]);
    }

    public function buyNow(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id',
            'color_id' => 'required|exists:product_colors,id',
            'qty' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($validated['product_id']);
        if ($validated['qty'] < $product->min_order) {
            return response()->json([
                'success' => false,
                'message' => 'Minimal pemesanan untuk produk ini adalah ' . $product->min_order . ' pcs.'
            ], 422);
        }

        if ($validated['qty'] > $product->stock) {
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
            'product_id' => $validated['product_id'],
            'variant_id' => $validated['variant_id'],
            'color_id' => $validated['color_id'],
            'qty' => $validated['qty']
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
        $product = $item->product;
        
        if ($request->action == 'increase') {
            if ($item->qty >= $product->stock) {
                return back()->with('error', 'Stok produk ini sudah mencapai batas maksimum.');
            }

            $item->qty += 1;
            $item->save();
        } elseif ($request->action == 'decrease') {
            if ($item->qty > $product->min_order) {
                $item->qty -= 1;
                $item->save();
            } else {
                return back()->with('error', 'Jumlah minimal untuk produk ini adalah ' . $product->min_order . ' pcs.');
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
