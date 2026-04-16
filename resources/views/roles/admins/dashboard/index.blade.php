@extends('layouts.admin')

@section('admin_container')
<div class="space-y-8">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-pink-50 rounded-2xl flex items-center justify-center text-pink-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Penjualan</p>
                    <p class="text-xl font-extrabold text-gray-900">Rp {{ number_format($stats['sales'], 0, ',', '.') }}</p>
                </div>
            </div>
            @if($stats['growth'] >= 0)
            <div class="mt-4 flex items-center gap-2 text-[10px] font-bold text-green-500 bg-green-50 px-2 py-1 rounded-lg w-fit">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                <span>+{{ number_format($stats['growth'], 1) }}% vs bln lalu</span>
            </div>
            @else
            <div class="mt-4 flex items-center gap-2 text-[10px] font-bold text-red-500 bg-red-50 px-2 py-1 rounded-lg w-fit">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                <span>{{ number_format($stats['growth'], 1) }}% vs bln lalu</span>
            </div>
            @endif
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pesanan Masuk</p>
                    <p class="text-xl font-extrabold text-gray-900">{{ number_format($stats['orders']) }}</p>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-[10px] font-bold text-blue-500 bg-blue-50 px-2 py-1 rounded-lg w-fit">
                <span>Total akumulasi</span>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center text-green-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Produk</p>
                    <p class="text-xl font-extrabold text-gray-900">{{ number_format($stats['products']) }}</p>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-[10px] font-bold text-green-500 bg-green-50 px-2 py-1 rounded-lg w-fit">
                <span>Aktif di katalog</span>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kategori</p>
                    <p class="text-xl font-extrabold text-gray-900">{{ number_format($stats['categories']) }}</p>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-[10px] font-bold text-purple-500 bg-purple-50 px-2 py-1 rounded-lg w-fit">
                <span>Segmentasi produk</span>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sales Chart -->
        <div class="lg:col-span-2 bg-white p-8 rounded-4xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Tren Penjualan</h3>
                    <p class="text-xs text-gray-500">Pertumbuhan pendapatan 6 bulan terakhir</p>
                </div>
            </div>
            <div class="h-80">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Categories Doughnut -->
        <div class="bg-white p-8 rounded-4xl border border-gray-100 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-2">Sebaran Stok</h3>
            <p class="text-xs text-gray-500 mb-8">Distribusi produk per kategori</p>
            <div class="h-64 relative">
                <canvas id="categoryChart"></canvas>
            </div>
            <div class="mt-8 space-y-3">
                @foreach($categories['labels'] as $index => $label)
                <div class="flex items-center justify-between text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full" style="background-color: {{ ['#ec4899', '#8b5cf6', '#3b82f6', '#10b981'][$index % 4] }}"></span>
                        <span class="text-gray-600">{{ $label }}</span>
                    </div>
                    <span class="font-bold text-gray-900">{{ $categories['counts'][$index] }} items</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-4xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-gray-50 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Pesanan Terbaru</h3>
                <p class="text-xs text-gray-500">Data harian transaksi masuk</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-50 text-gray-600 text-xs font-bold rounded-xl hover:bg-gray-100 transition-all">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                        <th class="px-8 py-4">Kode Order</th>
                        <th class="px-8 py-4">Pelanggan</th>
                        <th class="px-8 py-4">Total Harga</th>
                        <th class="px-8 py-4">Status</th>
                        <th class="px-8 py-4">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($recentOrders as $order)
                    <tr class="text-sm text-gray-600 hover:bg-gray-50/50 transition-all">
                        <td class="px-8 py-5 font-bold text-gray-900">#{{ $order->order_code }}</td>
                        <td class="px-8 py-5">{{ $order->customer_name }}</td>
                        <td class="px-8 py-5 font-bold text-pink-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="px-8 py-5">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'processing' => 'bg-blue-50 text-blue-600 border-blue-100',
                                    'shipped' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                    'completed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'cancelled' => 'bg-rose-50 text-rose-600 border-rose-100',
                                ];
                                $currentClass = $statusClasses[$order->status] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                            @endphp
                            <span class="px-3 py-1 text-[10px] font-bold rounded-full uppercase border {{ $currentClass }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-xs">{{ $order->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-10 text-center text-gray-500">Belum ada pesanan masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Sales Chart
    const ctxSales = document.getElementById('salesChart').getContext('2d');
    new Chart(ctxSales, {
        type: 'line',
        data: {
            labels: {!! json_encode($chart['labels']) !!},
            datasets: [{
                label: 'Penjualan',
                data: {!! json_encode($chart['values']) !!},
                borderColor: '#ec4899',
                backgroundColor: 'rgba(236, 72, 153, 0.1)',
                borderWidth: 4,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#ec4899',
                pointBorderWidth: 2,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { display: false },
                    ticks: {
                        font: { size: 10 },
                        callback: function(value) { return 'Rp ' + value.toLocaleString(); }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 10 } }
                }
            }
        }
    });

    // Category Chart
    const ctxCat = document.getElementById('categoryChart').getContext('2d');
    new Chart(ctxCat, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($categories['labels']) !!},
            datasets: [{
                data: {!! json_encode($categories['counts']) !!},
                backgroundColor: ['#ec4899', '#8b5cf6', '#3b82f6', '#10b981'],
                borderWidth: 0,
                cutout: '75%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endpush
@endsection