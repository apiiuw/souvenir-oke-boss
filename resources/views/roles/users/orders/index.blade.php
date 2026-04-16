@extends('layouts.main')

@section('container')
<section class="bg-[linear-gradient(180deg,#fff8fb_0%,#ffffff_22%)] py-10 md:py-14">
    <div class="mx-auto max-w-7xl px-4">
        <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <span class="inline-flex rounded-full bg-pink-50 px-4 py-2 text-xs font-bold uppercase tracking-[0.3em] text-pink-600">Tracking Pesanan</span>
                <h1 class="mt-4 text-3xl font-black text-gray-900">Pesanan Saya</h1>
                <p class="mt-2 max-w-2xl text-sm leading-7 text-gray-600">Lihat semua pesanan yang sudah dibuat dari akunmu dan cek status pengirimannya tanpa perlu chat admin satu per satu.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-3xl border border-green-100 bg-green-50 px-5 py-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" class="mb-8 grid gap-4 rounded-[1.75rem] border border-gray-100 bg-white p-5 shadow-sm md:grid-cols-[1.4fr_0.8fr_auto]">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode pesanan atau nama penerima" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none">
            <select name="status" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none">
                <option value="">Semua Status</option>
                @foreach($statusLabels as $status => $label)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="rounded-2xl bg-gray-900 px-5 py-3 text-sm font-bold text-white transition hover:bg-gray-800">Filter</button>
        </form>

        @forelse($orders as $order)
            @php
                $statusClasses = [
                    'pending' => 'bg-amber-50 text-amber-700 border-amber-100',
                    'processing' => 'bg-sky-50 text-sky-700 border-sky-100',
                    'shipped' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                    'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                    'cancelled' => 'bg-rose-50 text-rose-700 border-rose-100',
                ];
            @endphp

            <article class="mb-5 rounded-[1.75rem] border border-gray-100 bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <div class="flex flex-wrap items-center gap-3">
                            <h2 class="text-lg font-black text-gray-900">{{ $order->order_code }}</h2>
                            <span class="rounded-full border px-3 py-1 text-[11px] font-bold uppercase {{ $statusClasses[$order->status] ?? 'bg-gray-50 text-gray-700 border-gray-100' }}">
                                {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                            </span>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Dibuat {{ $order->created_at->format('d M Y, H:i') }} untuk {{ $order->recipient_name }}</p>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3 lg:min-w-[420px]">
                        <div class="rounded-2xl bg-gray-50 px-4 py-3">
                            <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-gray-400">Total Item</p>
                            <p class="mt-2 text-sm font-bold text-gray-900">{{ $order->total_qty }} pcs</p>
                        </div>
                        <div class="rounded-2xl bg-gray-50 px-4 py-3">
                            <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-gray-400">Total Belanja</p>
                            <p class="mt-2 text-sm font-bold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>
                        <a href="{{ route('user.orders.show', $order) }}" class="flex items-center justify-center rounded-2xl bg-pink-oke-boss px-4 py-3 text-sm font-bold text-white transition hover:bg-pink-600">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-[2rem] border border-dashed border-gray-200 bg-white px-6 py-16 text-center">
                <h2 class="text-xl font-black text-gray-900">Belum ada pesanan di akun ini.</h2>
                <p class="mt-3 text-sm text-gray-500">Setelah checkout saat login, status pengiriman akan muncul di halaman ini.</p>
                <a href="{{ route('produk') }}" class="mt-6 inline-flex rounded-2xl bg-pink-oke-boss px-5 py-3 text-sm font-bold text-white transition hover:bg-pink-600">
                    Mulai Belanja
                </a>
            </div>
        @endforelse

        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    </div>
</section>
@endsection
