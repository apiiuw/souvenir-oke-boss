@extends('layouts.admin')

@section('admin_container')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-gray-400 hover:text-pink-oke-boss transition uppercase tracking-widest flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Kembali Ke Daftar
                </a>
            </div>
            <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Detail Pesanan #{{ $order->order_code }}</h2>
            <p class="text-xs text-gray-500 mt-1 uppercase font-bold tracking-widest">{{ $order->created_at->format('d F Y, H:i') }}</p>
        </div>

        <div class="flex items-center gap-3">
            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="flex items-center gap-2">
                @csrf
                @method('PATCH')
                <select name="status" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-bold focus:ring-2 focus:ring-pink-oke-boss/20 outline-hidden">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-gray-800 transition">
                    Update Status
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
    <div class="p-4 bg-green-50 border border-green-100 text-green-700 rounded-2xl flex items-center gap-3">
        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <span class="font-semibold text-sm">{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Items Card -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900">Daftar Produk</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-4 py-4 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                            <div class="w-16 h-16 bg-gray-100 rounded-2xl overflow-hidden shrink-0">
                                @php
                                    $product = \App\Models\Product::find($item->product_id);
                                    $img = $product && $product->images->first() ? asset('storage/' . $product->images->first()->image) : 'https://via.placeholder.com/400';
                                @endphp
                                <img src="{{ $img }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold text-gray-900">{{ $item->product_name }}</h4>
                                <p class="text-xs text-gray-500">
                                    {{ $item->variant_name }} | {{ $item->color_name }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] text-gray-400 font-bold tracking-widest">{{ $item->qty }} x Rp {{ number_format($item->unit_price, 0, ',', '.') }}</p>
                                <p class="text-sm font-extrabold text-pink-oke-boss">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="px-6 py-6 bg-pink-50/50 border-t border-pink-100 flex justify-between items-center">
                    <span class="text-sm font-bold text-gray-600 uppercase tracking-widest">Grand Total</span>
                    <span class="text-2xl font-black text-pink-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Meta Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Informasi Pelanggan
                    </h3>
                    <div class="space-y-3">
                        <div class="p-4 bg-gray-50 rounded-2xl">
                            <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Nama Pemesan</p>
                            <p class="text-sm font-bold text-gray-900">{{ $order->customer_name }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl">
                            <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Nama Penerima</p>
                            <p class="text-sm font-bold text-gray-900">{{ $order->recipient_name }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl">
                            <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Telepon / WhatsApp</p>
                            <p class="text-sm font-bold text-gray-900">{{ $order->phone }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl">
                            <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Email Akun</p>
                            <p class="text-sm font-bold text-gray-900">{{ $order->user?->email ?? 'Tidak terhubung ke akun pelanggan' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        Pesan Checkout
                    </h3>
                    <div class="p-4 bg-gray-50 rounded-2xl h-full">
                        <p class="text-[10px] text-gray-400 font-bold uppercase mb-2">WhatsApp Message</p>
                        <div class="text-xs text-gray-600 bg-white p-4 rounded-xl border border-gray-100 max-h-60 overflow-y-auto whitespace-pre-line leading-relaxed">
                            {{ $order->whatsapp_message }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-8">
            <!-- Address Card -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Alamat Pengiriman
                </h3>
                <div class="space-y-4">
                    <div class="p-4 bg-gray-50 rounded-2xl">
                        <p class="text-[10px] text-gray-400 font-bold mb-1 uppercase tracking-tight">Alamat Lengkap</p>
                        <p class="text-sm text-gray-900 font-medium leading-relaxed">{{ $order->address_line }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-3 bg-gray-50 rounded-xl">
                            <p class="text-[10px] text-gray-400 font-bold mb-0.5 uppercase">Kelurahan</p>
                            <p class="text-xs text-gray-900 font-bold">{{ $order->subdistrict_name }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-xl">
                            <p class="text-[10px] text-gray-400 font-bold mb-0.5 uppercase">Provinsi</p>
                            <p class="text-xs text-gray-900 font-bold">{{ $order->province_name }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-xl">
                            <p class="text-[10px] text-gray-400 font-bold mb-0.5 uppercase">Kota/Kab</p>
                            <p class="text-xs text-gray-900 font-bold">{{ $order->city_name }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-xl">
                            <p class="text-[10px] text-gray-400 font-bold mb-0.5 uppercase">Kecamatan</p>
                            <p class="text-xs text-gray-900 font-bold">{{ $order->district_name }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-xl">
                            <p class="text-[10px] text-gray-400 font-bold mb-0.5 uppercase">RT/RW</p>
                            <p class="text-xs text-gray-900 font-bold">{{ $order->rt }} / {{ $order->rw }}</p>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-2xl">
                        <p class="text-[10px] text-gray-400 font-bold mb-1 uppercase tracking-tight">Ringkasan Pengiriman</p>
                        <p class="text-sm text-gray-700 leading-relaxed">
                            Penerima {{ $order->recipient_name }}, telepon {{ $order->phone }}, alamat {{ $order->address_line }},
                            RT/RW {{ $order->rt }}/{{ $order->rw }}, {{ $order->subdistrict_name }}, {{ $order->district_name }}, {{ $order->city_name }}, {{ $order->province_name }}.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Maps Card -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m6 13l5.447-2.724A1 1 0 0021 16.382V5.618a1 1 0 00-1.447-.894L15 7m0 13V7m-6 0v13m0-13L15 7"/></svg>
                    Lokasi Maps
                </h3>
                @if($order->maps_latitude && $order->maps_longitude)
                <div id="orderMap" class="aspect-video rounded-2xl overflow-hidden relative mb-4 z-0">
                    <!-- Map will be rendered here -->
                </div>
                <a href="{{ $order->maps_link }}" target="_blank" class="block w-full text-center py-3 bg-blue-50 text-blue-600 font-bold rounded-2xl hover:bg-blue-100 transition shadow-xs text-sm">
                    Buka di Google Maps
                </a>
                @else
                <div class="p-6 bg-gray-50 rounded-2xl text-center">
                    <p class="text-xs text-gray-400">Titik koordinat tidak tersedia.</p>
                </div>
                @endif
            </div>

            <!-- Note Card -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-2">Catatan Pengiriman</h3>
                <p class="text-sm text-gray-600 leading-relaxed italic">
                    "{{ $order->delivery_note ?? 'Tidak ada catatan.' }}"
                </p>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lat = {{ $order->maps_latitude }};
        const lng = {{ $order->maps_longitude }};
        
        if (lat && lng) {
            const map = L.map('orderMap').setView([lat, lng], 15);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);
            
            L.marker([lat, lng]).addTo(map)
                .bindPopup('Lokasi Pengiriman: {{ $order->customer_name }}')
                .openPopup();
            
            // Fix for leaflet tile rendering in hidden elements or after layout
            setTimeout(() => {
                map.invalidateSize();
            }, 100);
        }
    });
</script>
@endpush
@endsection
