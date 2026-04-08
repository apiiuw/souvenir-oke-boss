@extends('layouts.admin')

@section('admin_container')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Laporan Penjualan</h2>
            <p class="text-sm text-gray-500 mt-1">Analisis performa bisnis Anda dalam periode tertentu.</p>
        </div>
        
        <a href="{{ route('admin.reports.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" 
           class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white font-bold rounded-2xl hover:bg-gray-800 transition shadow-lg shadow-gray-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export PDF
        </a>
    </div>

    <!-- Filter Card -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
            <div class="flex-1 space-y-2">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest px-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}" 
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-pink-oke-boss/20 focus:border-pink-oke-boss transition-all outline-hidden text-sm">
            </div>
            <div class="flex-1 space-y-2">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest px-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}" 
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-pink-oke-boss/20 focus:border-pink-oke-boss transition-all outline-hidden text-sm">
            </div>
            <button type="submit" class="px-8 py-3 bg-pink-oke-boss text-white font-bold rounded-2xl hover:bg-pink-oke-boss/90 transition shadow-md shadow-pink-200 h-[46px]">
                Tampilkan
            </button>
        </form>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Pesanan</p>
            <h3 class="text-2xl font-black text-gray-900">{{ number_format($summary['total_orders'], 0, ',', '.') }}</h3>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Pendapatan</p>
            <h3 class="text-2xl font-black text-gray-900">Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</h3>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Item Terjual</p>
            <h3 class="text-2xl font-black text-gray-900">{{ number_format($summary['total_items'], 0, ',', '.') }}</h3>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Rata-rata Order</p>
            <h3 class="text-2xl font-black text-gray-900">Rp {{ number_format($summary['avg_order_value'], 0, ',', '.') }}</h3>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="font-bold text-gray-900">Rincian Transaksi</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Kode Pesanan</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Pelanggan</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Total Bayar</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-gray-600">
                            {{ $order->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm font-extrabold text-blue-600">
                            #{{ $order->order_code }}
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-900">
                            {{ $order->customer_name }}
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-pink-oke-boss">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold border uppercase tracking-widest 
                                {{ $order->status == 'completed' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-gray-50 text-gray-600 border-gray-100' }}">
                                {{ $order->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
                            <p class="text-gray-500 font-bold italic">Tidak ada transaksi ditemukan untuk periode ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
