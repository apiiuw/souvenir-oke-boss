<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->user()
            ->orders()
            ->with('items')
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('search')) {
            $search = $request->string('search');

            $query->where(function ($orderQuery) use ($search) {
                $orderQuery->where('order_code', 'like', '%' . $search . '%')
                    ->orWhere('recipient_name', 'like', '%' . $search . '%');
            });
        }

        return view('roles.users.orders.index', [
            'title' => 'Pesanan Saya',
            'orders' => $query->paginate(8)->withQueryString(),
            'statusLabels' => $this->statusLabels(),
        ]);
    }

    public function show(Request $request, Order $order)
    {
        abort_unless((int) $order->user_id === (int) $request->user()->id, 403);

        $order->load('items');

        return view('roles.users.orders.show', [
            'title' => 'Lacak Pesanan',
            'order' => $order,
            'statusLabels' => $this->statusLabels(),
            'statusDescriptions' => $this->statusDescriptions(),
            'statusSteps' => ['pending', 'processing', 'shipped', 'completed'],
        ]);
    }

    private function statusLabels(): array
    {
        return [
            'pending' => 'Menunggu Konfirmasi',
            'processing' => 'Sedang Diproses',
            'shipped' => 'Dalam Pengiriman',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];
    }

    private function statusDescriptions(): array
    {
        return [
            'pending' => 'Pesanan sudah masuk dan sedang menunggu konfirmasi admin.',
            'processing' => 'Pesanan sedang disiapkan dan diproses untuk pengiriman.',
            'shipped' => 'Pesanan sudah dikirim ke alamat tujuan.',
            'completed' => 'Pesanan telah selesai diterima.',
            'cancelled' => 'Pesanan dibatalkan. Hubungi admin jika butuh bantuan.',
        ];
    }
}
