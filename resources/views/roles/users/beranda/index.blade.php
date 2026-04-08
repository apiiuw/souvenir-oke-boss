@extends('layouts.main')

@section('container')
<div class="relative min-h-screen bg-white">
    <!-- Hero Section -->
    <div class="relative h-[450px] md:h-[650px] overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-1000 transform scale-105" style="background-image: url('{{ asset('img/backgrounds/home-hero.png') }}')">
            <div class="absolute inset-0 bg-linear-to-r from-black/70 via-black/40 to-transparent"></div>
        </div>
        <div class="relative h-full flex items-center max-w-screen-2xl mx-auto px-6 md:px-20">
            <div class="max-w-2xl text-white">
                <span class="inline-block px-4 py-1.5 bg-pink-oke-boss text-white text-xs font-bold tracking-widest uppercase rounded-full mb-6 animate-fade-in-up">Premium Souvenir Gallery</span>
                <h1 class="text-4xl md:text-7xl font-bold mb-6 leading-tight animate-fade-in-up" style="animation-delay: 0.2s">Kenangan Abadi dalam Setiap Detail</h1>
                <p class="text-lg md:text-xl text-gray-200 mb-10 leading-relaxed max-w-xl animate-fade-in-up" style="animation-delay: 0.4s">
                    Ciptakan momen tak terlupakan dengan koleksi souvenir eksklusif kami. Dirancang dengan hati untuk kebahagiaan Anda.
                </p>
                <div class="flex flex-wrap gap-4 animate-fade-in-up" style="animation-delay: 0.6s">
                    <a href="{{ route('produk') }}" class="px-8 py-4 bg-pink-oke-boss text-white rounded-full font-bold hover:bg-pink-oke-boss/90 transition shadow-2xl hover:scale-105 active:scale-95">Lihat Koleksi</a>
                    <a href="{{ route('tentang-kami') }}" class="px-8 py-4 bg-white/10 backdrop-blur-md text-white border border-white/30 rounded-full font-bold hover:bg-white/20 transition">Tentang Kami</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features / Value Propositions -->
    <section class="py-12 bg-white border-b border-gray-100">
        <div class="max-w-screen-2xl mx-auto px-6 md:px-20">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-4 text-center md:text-left">
                    <div class="w-12 h-12 rounded-2xl bg-pink-50 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">Kualitas Premium</h4>
                        <p class="text-xs text-gray-500">Bahan pilihan standar ekspor</p>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row items-center md:items-start gap-4 text-center md:text-left">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">Harga Terbaik</h4>
                        <p class="text-xs text-gray-500">Harga grosir kompetitif</p>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row items-center md:items-start gap-4 text-center md:text-left">
                    <div class="w-12 h-12 rounded-2xl bg-green-50 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">Custom Desain</h4>
                        <p class="text-xs text-gray-500">Sesuai keinginan anda</p>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row items-center md:items-start gap-4 text-center md:text-left">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">Pengiriman Cepat</h4>
                        <p class="text-xs text-gray-500">Tepat waktu & aman</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Explorer -->
    <section class="py-20 md:py-32 bg-white">
        <div class="max-w-screen-2xl mx-auto px-6 md:px-20">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div class="max-w-2xl">
                    <h2 class="text-3xl md:text-5xl font-bold mb-4 text-gray-900">Eksplorasi Koleksi Kami</h2>
                    <p class="text-gray-500 text-lg">Temukan berbagai kategori souvenir yang dirancang khusus untuk memenuhi kebutuhan momen berharga Anda.</p>
                </div>
                <a href="{{ route('produk') }}" class="group flex items-center gap-2 text-pink-oke-boss font-bold hover:gap-3 transition-all">
                    Lihat Semua <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
                @foreach($categories as $category)
                <a href="{{ route('produk', ['category' => $category->slug]) }}" class="group relative aspect-4/5 rounded-3xl overflow-hidden bg-gray-50 flex items-end p-6 hover:-translate-y-2 transition-all duration-500 shadow-lg hover:shadow-2xl">
                    <div class="absolute inset-0 bg-linear-to-t from-black/60 via-transparent to-transparent z-10 opacity-40 group-hover:opacity-60 transition-opacity"></div>
                    <img src="{{ asset('img/categories/' . $category->slug . '.png') }}" 
                         onerror="this.src='https://images.unsplash.com/photo-1513151233558-d860c5398176?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'"
                         class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="{{ $category->name }}">
                    <div class="relative z-20 w-full">
                        <h3 class="text-xl md:text-2xl font-bold text-white drop-shadow-md mb-2">{{ $category->name }}</h3>
                        <div class="h-1 w-0 bg-pink-oke-boss group-hover:w-full transition-all duration-500 rounded-full"></div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-20 md:py-32 bg-gray-50">
        <div class="max-w-screen-2xl mx-auto px-6 md:px-20">
            <div class="text-center mb-16">
                <span class="text-pink-oke-boss font-bold tracking-widest uppercase mb-4 block">Pick of the Week</span>
                <h2 class="text-3xl md:text-5xl font-bold mb-6 text-gray-900">Produk Terpopuler</h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg leading-relaxed">Pilihan terbaik yang paling banyak diminati oleh pelanggan kami untuk berbagai acara spesial.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-10">
                @forelse($featuredProducts as $product)
                <div class="group bg-white rounded-4xl overflow-hidden hover:shadow-2xl hover:shadow-pink-oke-boss/10 transition-all duration-500">
                    <div class="aspect-square relative overflow-hidden bg-gray-100">
                        <img src="{{ $product->images->first() ? asset('storage/' . $product->images->first()->image) : 'https://via.placeholder.com/400' }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 {{ $product->stock <= 0 ? 'grayscale opacity-50' : '' }}" alt="{{ $product->name }}">
                        @if($product->stock > 0)
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-[10px] font-bold text-pink-600 uppercase tracking-wider z-10 shadow-sm">Hot Item</div>
                        @else
                        <div class="absolute inset-0 bg-white/20 backdrop-blur-[2px] z-10 flex items-center justify-center">
                            <span class="bg-gray-900/80 text-white text-[10px] font-bold px-4 py-2 rounded-full uppercase tracking-widest shadow-xl border border-white/20">Stok Habis</span>
                        </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-gray-900 text-base md:text-lg mb-2 line-clamp-1">{{ $product->name }}</h3>
                        <p class="text-pink-oke-boss font-black text-lg md:text-xl mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <a href="{{ route('produk') }}?search={{ $product->name }}" class="block w-full text-center py-3 bg-gray-50 text-gray-900 font-bold rounded-2xl hover:bg-pink-oke-boss hover:text-white transition-all">Lihat Detail</a>
                    </div>
                </div>
                @empty
                <p class="col-span-full text-center text-gray-500">Produk belum tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 md:py-32 bg-white flex justify-center">
        <div class="max-w-screen-2xl mx-auto px-6 md:px-20 w-full">
            <div class="relative rounded-4xl overflow-hidden bg-pink-oke-boss p-10 md:p-24 text-center text-white shadow-3xl">
                <div class="absolute inset-0 bg-linear-to-br from-pink-oke-boss via-purple-700 to-indigo-900"></div>
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                <div class="relative z-10 max-w-3xl mx-auto">
                    <h2 class="text-3xl md:text-6xl font-bold mb-8 leading-tight">Buat Acara Anda Tak Terlupakan Sekarang</h2>
                    <p class="text-lg md:text-2xl text-pink-100 mb-12 leading-relaxed opacity-90">Tim ahli kami siap membantu Anda memilih souvenir terbaik yang sesuai dengan anggaran dan tema acara Anda.</p>
                    <div class="flex flex-wrap justify-center gap-6">
                        <a href="https://wa.me/6285780007175?text=Halo%20Admin%20Souvenir%20Oke%20Boss%2C%20saya%20ingin%20konsultasi%20mengenai%20pesanan%20souvenir." target="_blank" class="inline-flex items-center gap-3 px-10 py-5 bg-white text-pink-oke-boss rounded-full font-bold text-lg hover:shadow-2xl hover:scale-105 active:scale-95 transition-all duration-300 group">
                            Hubungi Admin Melalui WA
                            <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fade-in-up {
        opacity: 0;
        animation: fade-in-up 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    
    .rounded-4xl { border-radius: 2.5rem; }
    .shadow-3xl { box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.3); }
</style>
@endsection
