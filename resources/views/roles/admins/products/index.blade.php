@extends('layouts.admin')

@section('admin_container')
<div class="space-y-8">
    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Data Produk</h2>
            <p class="text-sm text-gray-500">Kelola katalog souvenir Anda, harga, dan ketersediaan barang.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="flex items-center justify-center gap-2 px-6 py-3 bg-pink-oke-boss text-white font-bold rounded-2xl hover:bg-pink-600 transition-all shadow-lg shadow-pink-100 active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Produk Baru
        </a>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white p-4 rounded-3xl border border-gray-100 shadow-sm flex flex-col md:flex-row md:items-center gap-4">
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex-1 flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..." class="w-full pl-11 pr-4 py-2.5 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-pink-500 focus:bg-white transition-all text-sm whitespace-nowrap">
            </div>
            <select name="category" onchange="this.form.submit()" class="px-4 py-2.5 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-pink-500 focus:bg-white transition-all text-sm">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="hidden">Cari</button>
        </form>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-r-xl animate-fade-in-up">
        <div class="flex items-center">
            <div class="shrink-0 text-green-400">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-4xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50">
                        <th class="px-8 py-5">Produk</th>
                        <th class="px-8 py-5">Kategori</th>
                        <th class="px-8 py-5">Harga (IDR)</th>
                        <th class="px-8 py-5">Min. Order</th>
                        <th class="px-8 py-5 text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($products as $product)
                    <tr class="group hover:bg-gray-50/50 transition-all">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl overflow-hidden bg-gray-100 shadow-xs group-hover:scale-105 transition-transform text-nowrap">
                                    <img src="{{ $product->thumbnail }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-gray-900 line-clamp-1">{{ $product->name }}</p>
                                    <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-tight font-bold">#PROD-{{ $product->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 bg-pink-50 text-pink-600 text-[10px] font-bold rounded-full uppercase">{{ $product->category->name }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <p class="font-extrabold text-sm text-gray-900 leading-none">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-sm font-semibold text-gray-600">{{ $product->min_order }} <span class="text-xs font-normal opacity-60">pcs</span></p>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2 text-nowrap">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-all" title="Ubah">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center text-gray-300">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                </div>
                                <p class="text-gray-500 font-medium">Belum ada produk tersedia.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-8 py-6 bg-gray-50/30">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
