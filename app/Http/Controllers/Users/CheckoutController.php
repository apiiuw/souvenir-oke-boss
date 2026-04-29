<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\RajaOngkirService;


class CheckoutController extends Controller
{
    private const WHATSAPP_NUMBER = '085780007175';
    protected $rajaOngkir;

    public function __construct(RajaOngkirService $rajaOngkir)
    {
        $this->rajaOngkir = $rajaOngkir;
    }


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
            'title' => 'Checkout',
            'user' => auth()->user(),
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
            'shipping_cost' => ['required', 'numeric'],
            'courier' => ['required', 'string'],
            'service' => ['required', 'string'],
        ], [
            'maps_link.required' => 'Silakan pilih titik lokasi pada peta.',
            'maps_link.url' => 'Titik maps harus berupa link yang valid.',
            'shipping_cost.required' => 'Silakan pilih layanan pengiriman.',
        ]);


        $normalizedPhone = preg_replace('/\D+/', '', $validated['phone']);
        $whatsappNumber = $this->normalizeWhatsappNumber(self::WHATSAPP_NUMBER);
        $orderCode = 'SOB-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));

        $totals = $cart->items->reduce(function ($carry, $item) {
            $subtotal = $item->product->price * $item->qty;
            $weight = ($item->product->weight ?? 200) * $item->qty;


            $carry['qty'] += $item->qty;
            $carry['price'] += $subtotal;
            $carry['weight'] += $weight;

            return $carry;
        }, ['qty' => 0, 'price' => 0, 'weight' => 0]);


        // Final Stock Check
        foreach ($cart->items as $item) {
            if ($item->qty > $item->product->stock) {
                return redirect()
                    ->route('cart.index')
                    ->with('error', "Stok untuk produk '{$item->product->name}' tidak mencukupi (Tersisa: {$item->product->stock}).");
            }
        }

        $message = $this->buildWhatsappMessage($orderCode, $validated, $cart, $totals['qty'], $totals['price'], $normalizedPhone);


        $order = DB::transaction(function () use ($cart, $validated, $totals, $message, $orderCode, $whatsappNumber, $normalizedPhone) {
            if (auth()->check()) {
                auth()->user()->update([
                    'name' => $validated['customer_name'],
                    'phone' => $normalizedPhone ?: $validated['phone'],
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
                ]);
            }

            $order = Order::create([
                'user_id' => auth()->id(),
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
                'total_weight' => $totals['weight'],
                'total_price' => $totals['price'],
                'shipping_cost' => $validated['shipping_cost'],
                'grand_total' => $totals['price'] + $validated['shipping_cost'],
                'courier' => $validated['courier'],
                'service' => $validated['service'],
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



        $whatsappUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode($message);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'whatsapp_url' => $whatsappUrl,
                'redirect_url' => route('user.orders.show', $order)
            ]);
        }

        return redirect()
            ->route('user.orders.show', $order)
            ->with('success', 'Pesanan berhasil dibuat. Status pengiriman bisa dipantau dari halaman ini.')
            ->with('whatsapp_url', $whatsappUrl);
    }

    private function buildWhatsappMessage(string $orderCode, array $validated, Cart $cart, int $totalQty, int $totalPrice, string $normalizedPhone): string
    {
        $grandTotal = $totalPrice + $validated['shipping_cost'];
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
            '*PENGIRIMAN:*',
            '*Kurir:* ' . strtoupper($validated['courier']),
            '*Layanan:* ' . $validated['service'],
            '*Ongkos Kirim:* Rp ' . number_format($validated['shipping_cost'], 0, ',', '.'),
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
        $lines[] = '*Subtotal Belanja:* Rp ' . number_format($totalPrice, 0, ',', '.');
        $lines[] = '*Total Ongkos Kirim:* Rp ' . number_format($validated['shipping_cost'], 0, ',', '.');
        $lines[] = '*Total Pembayaran:* Rp ' . number_format($grandTotal, 0, ',', '.');
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

    public function getProvinces()
    {
        return response()->json($this->rajaOngkir->getProvinces());
    }

    public function getCities($provinceId)
    {
        return response()->json($this->rajaOngkir->getCities($provinceId));
    }

    public function getDistricts($cityId)
    {
        return response()->json($this->rajaOngkir->getDistricts($cityId));
    }

    public function getSubDistricts($districtId)
    {
        return response()->json($this->rajaOngkir->getSubDistricts($districtId));
    }


    public function getCost(Request $request)
    {
        $request->validate([
            'destination' => 'required',
            'weight' => 'required|numeric',
            'courier' => 'required|string'
        ]);

        $origin = '17601'; // Gambir, Jakarta Pusat (Subdistrict ID)

        $costs = $this->rajaOngkir->getCost($origin, $request->destination, $request->weight, $request->courier);

        return response()->json($costs);
    }
}

