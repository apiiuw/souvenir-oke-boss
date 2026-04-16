@extends('layouts.admin')

@section('admin_container')
<div class="space-y-8">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Data Pelanggan</h2>
            <p class="mt-1 text-sm text-gray-500">Lihat data pelanggan, kontak, alamat default, dan frekuensi pemesanan dalam satu halaman.</p>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-3xl border border-pink-100 bg-[#fff7fb] p-6">
            <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-pink-500">Total Pelanggan</p>
            <p class="mt-3 text-3xl font-black text-gray-900">{{ $totalCustomers }}</p>
        </div>
        <div class="rounded-3xl border border-emerald-100 bg-emerald-50 p-6">
            <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-emerald-600">Sudah Pernah Pesan</p>
            <p class="mt-3 text-3xl font-black text-gray-900">{{ $activeCustomers }}</p>
        </div>
        <div class="rounded-3xl border border-blue-100 bg-blue-50 p-6">
            <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-blue-600">Total Pemesanan</p>
            <p class="mt-3 text-3xl font-black text-gray-900">{{ $totalOrders }}</p>
        </div>
    </div>

    <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
        <form method="GET" class="flex flex-col gap-4 md:flex-row">
            <div class="relative flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau no. telepon pelanggan..." class="w-full rounded-2xl border border-gray-100 bg-gray-50 px-4 py-3 pl-12 text-sm outline-hidden transition-all focus:border-pink-oke-boss focus:ring-2 focus:ring-pink-oke-boss/20">
                <svg class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <button type="submit" class="rounded-2xl bg-pink-oke-boss px-6 py-3 text-sm font-bold text-white transition hover:bg-pink-oke-boss/90">Cari Pelanggan</button>
        </form>
    </div>

    <div class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Pelanggan</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Kontak</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Alamat</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-400">Pemesanan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($customers as $customer)
                        @php
                            $addressParts = array_filter([
                                $customer->address_line ?: $customer->latestOrder?->address_line,
                                trim(collect([
                                    $customer->rt ?: $customer->latestOrder?->rt,
                                    $customer->rw ?: $customer->latestOrder?->rw,
                                ])->filter()->isNotEmpty() ? 'RT/RW ' . ($customer->rt ?: $customer->latestOrder?->rt) . '/' . ($customer->rw ?: $customer->latestOrder?->rw) : ''),
                                $customer->subdistrict_name ?: $customer->latestOrder?->subdistrict_name,
                                $customer->district_name ?: $customer->latestOrder?->district_name,
                                $customer->city_name ?: $customer->latestOrder?->city_name,
                                $customer->province_name ?: $customer->latestOrder?->province_name,
                            ]);
                        @endphp
                        <tr class="align-top transition-colors hover:bg-gray-50/60">
                            <td class="px-6 py-5">
                                <p class="text-sm font-bold text-gray-900">{{ $customer->name }}</p>
                                <p class="mt-1 text-xs text-gray-500">Bergabung {{ $customer->created_at->format('d M Y') }}</p>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-sm font-semibold text-gray-900">{{ $customer->phone ?: '-' }}</p>
                                <p class="mt-1 text-xs text-gray-500">{{ $customer->email }}</p>
                            </td>
                            <td class="px-6 py-5">
                                @if(count($addressParts))
                                    <p class="max-w-md text-sm leading-6 text-gray-700">{{ implode(', ', $addressParts) }}</p>
                                @else
                                    <p class="text-sm text-gray-400">Alamat belum disimpan.</p>
                                @endif
                            </td>
                            <td class="px-6 py-5">
                                <div class="inline-flex rounded-2xl bg-pink-50 px-4 py-3">
                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-pink-500">Total Order</p>
                                        <p class="mt-2 text-lg font-black text-gray-900">{{ $customer->orders_count }}x</p>
                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $customer->latestOrder?->created_at ? 'Terakhir pesan ' . $customer->latestOrder->created_at->format('d M Y') : 'Belum ada pesanan' }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-20 text-center">
                                <p class="text-base font-bold text-gray-900">Data pelanggan belum tersedia.</p>
                                <p class="mt-2 text-sm text-gray-500">Pelanggan yang mendaftar akan tampil di sini, beserta jumlah pemesanannya.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($customers->hasPages())
            <div class="border-t border-gray-100 bg-gray-50 px-6 py-4">
                {{ $customers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
