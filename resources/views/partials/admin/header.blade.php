<!-- Header -->
<header class="h-20 bg-white border-b border-gray-200 px-6 flex items-center justify-between sticky top-0 z-40">
    <div class="flex items-center gap-4">
        <button id="sidebar-toggle" class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <h1 class="font-bold text-xl text-gray-900">{{ $title ?? 'Dashboard' }}</h1>
    </div>

    <div class="flex items-center gap-6">
        
        <div class="flex items-center gap-3 pl-6 border-l border-gray-200">
            <div class="text-right hidden sm:block">
                <p class="text-xs font-bold text-gray-900">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-gray-500">Administrator</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center text-pink-600 font-bold border-2 border-white shadow-xs">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
        </div>
    </div>
</header>
