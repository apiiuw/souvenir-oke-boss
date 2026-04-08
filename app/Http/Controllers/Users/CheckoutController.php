<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    private const WHATSAPP_NUMBER = '085780007175';

    private function getCart()
    {
        $sessionId = session()->getId();
        
        if (request()->query('type') === 'buynow' || request()->input('checkout_type') === 'buynow') {
            $sessionId .= '_buynow';
        }

        return Cart::firstOrCreate([
            'session_id' => $sessionId
        ]);
    }

    public function index()
    {
        $cart = $this->getCart()->load([
            'items.product.images',
            'items.variant',
            'items.color'
        ]);

        return view('roles.users.checkout.index', [
            'cart' => $cart,
            'title' => 'Checkout'
        ]);
    }

    public function store(Request $request)
    {
        $cart = $this->getCart()->load([
            'items.product.images',
            'items.variant',
            'items.color',
        ]);

        if ($cart->items->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Keranjang kosong. Tambahkan produk terlebih dahulu.');
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'address_line' => ['required', 'string'],
            'province_id' => ['nullable', 'string', 'max:50'],
            'province_name' => ['required', 'string', 'max:255'],
            'city_id' => ['nullable', 'string', 'max:50'],
            'city_name' => ['required', 'string', 'max:255'],
            'district_id' => ['nullable', 'string', 'max:50'],
            'district_name' => ['required', 'string', 'max:255'],
            'subdistrict_id' => ['nullable', 'string', 'max:50'],
            'subdistrict_name' => ['required', 'string', 'max:255'],
            'rt' => ['required', 'string', 'max:10'],
            'rw' => ['required', 'string', 'max:10'],
            'maps_link' => ['required', 'url'],
            'maps_latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'maps_longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'delivery_note' => ['nullable', 'string'],
        ], [
            'maps_link.required' => 'Silakan pilih titik lokasi pada peta.',
            'maps_link.url' => 'Titik maps harus berupa link yang valid.',
        ]);

        $normalizedPhone = preg_replace('/\D+/', '', $validated['phone']);
        $whatsappNumber = $this->normalizeWhatsappNumber(self::WHATSAPP_NUMBER);
        $orderCode = 'SOB-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));

        $totals = $cart->items->reduce(function ($carry, $item) {
            $subtotal = $item->product->price * $item->qty;

            $carry['qty'] += $item->qty;
            $carry['price'] += $subtotal;

            return $carry;
        }, ['qty' => 0, 'price' => 0]);

        // Final Stock Check
        foreach ($cart->items as $item) {
            if ($item->qty > $item->product->stock) {
                return redirect()
                    ->route('cart.index')
                    ->with('error', "Stok untuk produk '{$item->product->name}' tidak mencukupi (Tersisa: {$item->product->stock}).");
            }
        }

        $message = $this->buildWhatsappMessage($orderCode, $validated, $cart, $totals['qty'], $totals['price'], $normalizedPhone);

        $order = DB::transaction(function () use ($cart, $validated, $totals, $message, $orderCode, $whatsappNumber) {
            $order = Order::create([
                'order_code' => $orderCode,
                'session_id' => $cart->session_id,
                'customer_name' => $validated['customer_name'],
                'recipient_name' => $validated['recipient_name'],
                'phone' => $validated['phone'],
                'address_line' => $validated['address_line'],
                'province_id' => $validated['province_id'] ?: null,
                'province_name' => $validated['province_name'],
                'city_id' => $validated['city_id'] ?: null,
                'city_name' => $validated['city_name'],
                'district_id' => $validated['district_id'] ?: null,
                'district_name' => $validated['district_name'],
                'subdistrict_id' => $validated['subdistrict_id'] ?: null,
                'subdistrict_name' => $validated['subdistrict_name'],
                'rt' => $validated['rt'],
                'rw' => $validated['rw'],
                'maps_link' => $validated['maps_link'] ?: null,
                'maps_latitude' => $validated['maps_latitude'] ?: null,
                'maps_longitude' => $validated['maps_longitude'] ?: null,
                'delivery_note' => $validated['delivery_note'] ?: null,
                'total_qty' => $totals['qty'],
                'total_price' => $totals['price'],
                'whatsapp_number' => $whatsappNumber,
                'whatsapp_message' => $message,
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'variant_name' => $item->variant->name ?? null,
                    'color_name' => $item->color->name ?? null,
                    'qty' => $item->qty,
                    'unit_price' => $item->product->price,
                    'subtotal' => $item->product->price * $item->qty,
                ]);

                // Decrement Stock
                $item->product->decrement('stock', $item->qty);
            }

            $cart->delete();

            return $order;
        });

        return redirect()->away(
            'https://wa.me/' . $order->whatsapp_number . '?text=' . rawurlencode($order->whatsapp_message)
        );
    }

    private function buildWhatsappMessage(string $orderCode, array $validated, Cart $cart, int $totalQty, int $totalPrice, string $normalizedPhone): string
    {
        $lines = [
            'Halo Admin Souvenir Oke Boss, saya ingin melakukan checkout.',
            '',
            '*KODE PESANAN:* ' . $orderCode,
            '',
            '*DATA PENGIRIMAN:*',
            '*Nama Lengkap:* ' . $validated['customer_name'],
            '*Nama Penerima:* ' . $validated['recipient_name'],
            '*No. Telepon:* ' . ($normalizedPhone ?: $validated['phone']),
            '*Alamat Lengkap:* ' . $validated['address_line'],
            '   RT/RW: ' . $validated['rt'] . '/' . $validated['rw'],
            '   Kelurahan: ' . $validated['subdistrict_name'],
            '   Kecamatan: ' . $validated['district_name'],
            '   Kota/Kabupaten: ' . $validated['city_name'],
            '   Provinsi: ' . $validated['province_name'],
            '*Titik Maps:* ' . ($validated['maps_link'] ? $validated['maps_link'] : '-'),
            '*Catatan:* ' . ($validated['delivery_note'] ?: '-'),
            '',
            '*DETAIL PESANAN:*',
        ];

        foreach ($cart->items as $index => $item) {
            $variant = $item->variant->name ?? '-';
            $color = $item->color->name ?? '-';
            $subtotal = number_format($item->product->price * $item->qty, 0, ',', '.');

            $lines[] = '*- ' . $item->product->name . '*';
            $lines[] = '   Variasi: ' . $variant;
            $lines[] = '   Warna: ' . $color;
            $lines[] = '   Jumlah: ' . $item->qty . ' pcs';
            $lines[] = '   Subtotal: Rp ' . $subtotal;
            $lines[] = '';
        }

        $lines[] = '------------------------';
        $lines[] = '*Total Item:* ' . $totalQty . ' pcs';
        $lines[] = '*Total Belanja:* Rp ' . number_format($totalPrice, 0, ',', '.');
        $lines[] = '------------------------';
        $lines[] = '';
        $lines[] = 'Mohon dibantu untuk proses pesanan saya. Terima kasih!';

        return implode("\n", $lines);
    }

    private function normalizeWhatsappNumber(string $phone): string
    {
        $phone = trim($phone);

        if (Str::startsWith(strtolower($phone), 'o')) {
            $phone = '0' . substr($phone, 1);
        }

        $digits = preg_replace('/\D+/', '', $phone);

        if (Str::startsWith($digits, '0')) {
            return '62' . substr($digits, 1);
        }

        if (! Str::startsWith($digits, '62')) {
            return '62' . $digits;
        }

        return $digits;
    }
}
