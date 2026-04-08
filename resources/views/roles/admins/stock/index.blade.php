@extends('layouts.admin')

@section('admin_container')
<div class="space-y-8">
    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Manajemen Stok</h2>
            <p class="text-sm text-gray-500">Pantau dan kelola ketersediaan produk souvenir Anda secara real-time.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="flex items-center gap-1.5 text-[10px] font-bold text-gray-400 uppercase tracking-widest bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Kritis (< 10)
            </span>
            <span class="flex items-center gap-1.5 text-[10px] font-bold text-gray-400 uppercase tracking-widest bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100">
                <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> Rendah (< 50)
            </span>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white p-4 rounded-3xl border border-gray-100 shadow-sm flex flex-col md:flex-row md:items-center gap-4">
        <form action="{{ route('admin.stock') }}" method="GET" class="flex-1 flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..." class="w-full pl-11 pr-4 py-2.5 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-pink-500 focus:bg-white transition-all text-sm">
            </div>
            <select name="category" onchange="this.form.submit()" class="px-4 py-2.5 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-pink-500 focus:bg-white transition-all text-sm font-semibold">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="hidden">Cari</button>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-4xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50">
                        <th class="px-8 py-5">Produk</th>
                        <th class="px-8 py-5">Kategori</th>
                        <th class="px-8 py-5">Status Stok</th>
                        <th class="px-8 py-5 text-center">Jumlah Stok</th>
                        <th class="px-8 py-5 text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($products as $product)
                    @php
                        $statusColor = 'bg-green-50 text-green-600 border-green-100';
                        $dotColor = 'bg-green-500';
                        $statusText = 'Sehat';
                        
                        if($product->stock < 10) {
                            $statusColor = 'bg-red-50 text-red-600 border-red-100';
                            $dotColor = 'bg-red-500';
                            $statusText = 'Kritis';
                        } elseif($product->stock < 50) {
                            $statusColor = 'bg-orange-50 text-orange-600 border-orange-100';
                            $dotColor = 'bg-orange-400';
                            $statusText = 'Rendah';
                        }
                    @endphp
                    <tr class="group hover:bg-gray-50/50 transition-all">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-50 border border-gray-100 group-hover:scale-105 transition-transform">
                                    <img src="{{ $product->thumbnail }}" class="w-full h-full object-cover">
                                </div>
                                <span class="font-bold text-sm text-gray-900 line-clamp-1">{{ $product->name }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-xs font-semibold text-gray-500">{{ $product->category->name }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 border rounded-full text-[10px] font-bold uppercase tracking-wider {{ $statusColor }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                                {{ $statusText }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <form action="{{ route('admin.stock.update', $product->id) }}" method="POST" class="flex items-center justify-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="stock" value="{{ $product->stock }}" min="0" 
                                    class="w-24 px-3 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-pink-500 focus:bg-white transition-all text-center text-sm font-bold @if($product->stock < 10) text-red-600 @endif">
                                <button type="submit" class="p-2 bg-gray-900 text-white rounded-lg hover:bg-black transition-all shadow-sm active:scale-95" title="Update Stok">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </button>
                            </form>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-xs font-bold text-pink-500 hover:text-pink-600 underline">Detail Produk</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <p class="text-gray-500 font-medium italic">Data produk tidak ditemukan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-8 border-t border-gray-50">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
