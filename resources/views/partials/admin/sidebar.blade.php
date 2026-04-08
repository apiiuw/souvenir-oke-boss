<!-- Sidebar -->
<aside id="sidebar" class="fixed left-0 top-0 h-screen w-64 bg-white border-r border-gray-200 z-50 transition-transform duration-300 lg:translate-x-0 -translate-x-full">
    <div class="p-6 flex items-center gap-3">
        <div class="w-10 h-10 bg-pink-oke-boss rounded-xl flex items-center justify-center shadow-lg text-white font-bold text-xl">
            O
        </div>
        <span class="font-extrabold text-xl tracking-tight text-gray-900">Admin Panel</span>
    </div>

    <nav class="mt-6 flex flex-col gap-1 px-4">
        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-4 mb-2">Utama</div>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::is('admin/dashboard') ? 'sidebar-item-active' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 shadow-xs" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span class="font-semibold text-sm">Dashboard</span>
        </a>

        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-4 mt-6 mb-2">Katalog & Stok</div>
        <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::is('admin/categories*') ? 'sidebar-item-active' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 shadow-xs" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
            <span class="font-semibold text-sm">Kategori Produk</span>
        </a>
        <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::is('admin/products*') ? 'sidebar-item-active' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 shadow-xs" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            <span class="font-semibold text-sm">Data Produk</span>
        </a>
        <a href="{{ route('admin.stock') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::is('admin/stock') ? 'sidebar-item-active' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 shadow-xs" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span class="font-semibold text-sm">Data Stok</span>
        </a>

        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-4 mt-6 mb-2">Penjualan</div>
        <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::is('admin/orders*') ? 'sidebar-item-active' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 shadow-xs" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            <span class="font-semibold text-sm">Pesanan</span>
        </a>
        <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::is('admin/reports*') ? 'sidebar-item-active' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 shadow-xs" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            <span class="font-semibold text-sm">Laporan</span>
        </a>

        <div class="mt-auto pt-10 pb-6">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 transition-all">
                    <svg class="w-5 h-5 shadow-xs" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span class="font-bold text-sm">Keluar Akun</span>
                </button>
            </form>
        </div>
    </nav>
</aside>
