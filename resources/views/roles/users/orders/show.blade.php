@extends('layouts.main')

@section('container')
@php
    $statusClass = [
        'pending' => 'bg-amber-50 text-amber-700 border-amber-100',
        'processing' => 'bg-sky-50 text-sky-700 border-sky-100',
        'shipped' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
        'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
        'cancelled' => 'bg-rose-50 text-rose-700 border-rose-100',
    ];

    $currentStepIndex = array_search($order->status, $statusSteps, true);
@endphp

<section class="bg-[linear-gradient(180deg,#fff7fb_0%,#ffffff_26%)] py-10 md:py-14">
    <div class="mx-auto max-w-7xl px-4">
        @if(session('success'))
            <div class="mb-6 rounded-3xl border border-green-100 bg-green-50 px-5 py-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <a href="{{ route('user.orders.index') }}" class="text-xs font-bold uppercase tracking-[0.3em] text-pink-600 hover:text-pink-500">Kembali ke Pesanan Saya</a>
                <h1 class="mt-3 text-3xl font-black text-gray-900">{{ $order->order_code }}</h1>
                <p class="mt-2 text-sm text-gray-500">Pesanan dibuat pada {{ $order->created_at->format('d F Y, H:i') }}</p>
            </div>
            <span class="inline-flex rounded-full border px-4 py-2 text-sm font-bold {{ $statusClass[$order->status] ?? 'bg-gray-50 text-gray-700 border-gray-100' }}">
                {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
            </span>
        </div>

        <div class="grid gap-8 lg:grid-cols-[1.2fr_0.8fr]">
            <div class="space-y-8">
                <div class="rounded-[2rem] border border-gray-100 bg-white p-6 shadow-sm md:p-8">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-black text-gray-900">Progress Pengiriman</h2>
                            <p class="mt-2 text-sm text-gray-500">{{ $statusDescriptions[$order->status] ?? 'Status pesanan sedang diperbarui.' }}</p>
                        </div>
                    </div>

                    @if($order->status === 'cancelled')
                        <div class="mt-6 rounded-3xl border border-rose-100 bg-rose-50 px-5 py-4 text-sm text-rose-700">
                            Pesanan ini dibatalkan. Kalau perlu bantuan lebih lanjut, silakan hubungi admin.
                        </div>
                    @else
                        <div class="mt-8 grid gap-4 md:grid-cols-4">
                            @foreach($statusSteps as $index => $step)
                                @php
                                    $isCompleted = $currentStepIndex !== false && $index <= $currentStepIndex;
                                    $isCurrent = $order->status === $step;
                                @endphp
                                <div class="rounded-3xl border px-4 py-5 {{ $isCompleted ? 'border-pink-200 bg-pink-50' : 'border-gray-100 bg-gray-50' }}">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.24em] {{ $isCompleted ? 'text-pink-600' : 'text-gray-400' }}">
                                        Tahap {{ $index + 1 }}
                                    </p>
                                    <p class="mt-3 text-sm font-bold {{ $isCompleted ? 'text-gray-900' : 'text-gray-500' }}">
                                        {{ $statusLabels[$step] }}
                                    </p>
                                    <p class="mt-2 text-xs {{ $isCurrent ? 'text-pink-600 font-semibold' : 'text-gray-400' }}">
                                        {{ $isCurrent ? 'Status saat ini' : ($isCompleted ? 'Sudah dilalui' : 'Menunggu proses') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="rounded-[2rem] border border-gray-100 bg-white p-6 shadow-sm md:p-8">
                    <h2 class="text-xl font-black text-gray-900">Detail Produk</h2>
                    <div class="mt-6 space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex flex-col gap-4 rounded-3xl border border-gray-100 p-5 md:flex-row md:items-center md:justify-between">
                                <div>
                                    <h3 class="text-base font-black text-gray-900">{{ $item->product_name }}</h3>
                                    <p class="mt-2 text-sm text-gray-500">Variasi: {{ $item->variant_name ?: '-' }} | Warna: {{ $item->color_name ?: '-' }}</p>
                                </div>
                                <div class="grid gap-3 sm:grid-cols-3 md:min-w-[320px]">
                                    <div class="rounded-2xl bg-gray-50 px-4 py-3">
                                        <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-gray-400">Qty</p>
                                        <p class="mt-2 text-sm font-bold text-gray-900">{{ $item->qty }} pcs</p>
                                    </div>
                                    <div class="rounded-2xl bg-gray-50 px-4 py-3">
                                        <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-gray-400">Harga</p>
                                        <p class="mt-2 text-sm font-bold text-gray-900">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="rounded-2xl bg-gray-900 px-4 py-3">
                                        <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-gray-400">Subtotal</p>
                                        <p class="mt-2 text-sm font-bold text-white">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <aside class="space-y-8">
                <div class="rounded-[2rem] border border-gray-100 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-black text-gray-900">Ringkasan Pesanan</h2>
                    <div class="mt-6 space-y-4">
                        <div class="rounded-2xl bg-gray-50 px-4 py-4">
                            <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-gray-400">Penerima</p>
                            <p class="mt-2 text-sm font-bold text-gray-900">{{ $order->recipient_name }}</p>
                        </div>
                        <div class="rounded-2xl bg-gray-50 px-4 py-4">
                            <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-gray-400">No. Telepon</p>
                            <p class="mt-2 text-sm font-bold text-gray-900">{{ $order->phone }}</p>
                        </div>
                        <div class="rounded-2xl bg-gray-50 px-4 py-4">
                            <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-gray-400">Alamat</p>
                            <p class="mt-2 text-sm leading-7 text-gray-700">
                                {{ $order->address_line }}<br>
                                RT/RW {{ $order->rt }}/{{ $order->rw }}, {{ $order->subdistrict_name }}, {{ $order->district_name }}, {{ $order->city_name }}, {{ $order->province_name }}
                            </p>

                        </div>
                        <div class="rounded-2xl bg-gray-50 px-4 py-4">
                            <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-gray-400">Pengiriman</p>
                            <p class="mt-2 text-sm font-bold text-gray-900">{{ strtoupper($order->courier) }} - {{ $order->service }}</p>
                            <p class="mt-1 text-xs text-gray-500">Ongkos Kirim: Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</p>
                        </div>
                        <div class="rounded-2xl bg-pink-50 px-4 py-4">
                            <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-pink-500">Total Pembayaran</p>
                            <p class="mt-2 text-xl font-black text-pink-600">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</p>
                            <p class="mt-1 text-xs text-pink-400">Subtotal: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>

                    </div>
                </div>

                <div class="rounded-[2rem] border border-gray-100 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-black text-gray-900">Catatan Pengiriman</h2>
                    <p class="mt-4 text-sm leading-7 text-gray-600">{{ $order->delivery_note ?: 'Tidak ada catatan khusus untuk pengiriman ini.' }}</p>

                    @if($order->maps_link)
                        <a href="{{ $order->maps_link }}" target="_blank" class="mt-6 inline-flex w-full items-center justify-center rounded-2xl bg-gray-900 px-4 py-3 text-sm font-bold text-white transition hover:bg-gray-800">
                            Buka Titik Maps
                        </a>
                    @endif
                </div>
            </aside>
        </div>
    </div>
</section>

@endsection
