<nav class="bg-white border-gray-200 sticky top-0 z-50 shadow-sm">
  <!-- BARIS 1 (Desktop) / Mobile Navigation -->
  <div class="max-w-screen-2xl mx-auto px-4 py-3">
    <div class="flex flex-wrap items-center justify-between">
      <!-- Logo + Search (Kiri) -->
      <div class="flex items-center space-x-3 flex-1">
        <a href="{{ route('beranda') }}" class="flex items-center">
          <img src="{{ asset('img/icon/logo.png') }}" class="h-10 md:h-14" alt="Logo" />
        </a>
        <!-- Search di Mobile dan Desktop -->
        <div class="hidden sm:flex flex-1 md:flex-none ml-4">
            <form action="{{ route('produk') }}" method="GET" class="flex">
                <input
                    type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari produk..."
                    class="px-3 py-2 text-sm border border-gray-300 rounded-lg w-full md:w-64 focus:ring-pink-oke-boss focus:border-pink-oke-boss"
                />
            </form>
        </div>
      </div>

      <div class="flex items-center space-x-4">
        <!-- WhatsApp Contact (Kanan Desktop Only) -->
        <a href="https://wa.me/6281234567890" target="_blank" class="hidden md:flex items-center space-x-3 px-4 py-2 bg-green-500 text-white rounded-2xl hover:bg-green-600 transition">
          <svg class="w-8 h-8" viewBox="-2.73 0 1225.016 1225.016" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="white"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill="white" d="M1041.858 178.02C927.206 63.289 774.753.07 612.325 0 277.617 0 5.232 272.298 5.098 606.991c-.039 106.986 27.915 211.42 81.048 303.476L0 1225.016l321.898-84.406c88.689 48.368 188.547 73.855 290.166 73.896h.258.003c334.654 0 607.08-272.346 607.222-607.023.056-162.208-63.052-314.724-177.689-429.463zm-429.533 933.963h-.197c-90.578-.048-179.402-24.366-256.878-70.339l-18.438-10.93-191.021 50.083 51-186.176-12.013-19.087c-50.525-80.336-77.198-173.175-77.16-268.504.111-278.186 226.507-504.503 504.898-504.503 134.812.056 261.519 52.604 356.814 147.965 95.289 95.36 147.728 222.128 147.688 356.948-.118 278.195-226.522 504.543-504.693 504.543z"></path><path fill="white" d="M462.273 349.294c-11.234-24.977-23.062-25.477-33.75-25.914-8.742-.375-18.75-.352-28.742-.352-10 0-26.25 3.758-39.992 18.766-13.75 15.008-52.5 51.289-52.5 125.078 0 73.797 53.75 145.102 61.242 155.117 7.5 10 103.758 166.266 256.203 226.383 126.695 49.961 152.477 40.023 179.977 37.523s88.734-36.273 101.234-71.297c12.5-35.016 12.5-65.031 8.75-71.305-3.75-6.25-13.75-10-28.75-17.5s-88.734-43.789-102.484-48.789-23.75-7.5-33.75 7.516c-10 15-38.727 48.773-47.477 58.773-8.75 10.023-17.5 11.273-32.5 3.773-15-7.523-63.305-23.344-120.609-74.438-44.586-39.75-74.688-88.844-83.438-103.859-8.75-15-.938-23.125 6.586-30.602 6.734-6.719 15-17.508 22.5-26.266 7.484-8.758 9.984-15.008 14.984-25.008 5-10.016 2.5-18.773-1.25-26.273s-32.898-81.67-46.234-111.326z"></path></g></svg>
          <div class="flex flex-col">
            <span class="text-sm font-semibold">Hubungi Kami</span>
            <span class="text-xs opacity-90">Fast Respon</span>
          </div>
        </a>

        <!-- Hamburger Button (Mobile Only) -->
        <button data-collapse-toggle="navbar-menu" type="button" class="md:hidden inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-menu" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- Search Mobile (di bawah Logo) -->
    <div class="sm:hidden mt-3">
        <form action="{{ route('produk') }}" method="GET" class="flex">
            <input
                type="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari produk..."
                class="px-3 py-2 text-sm border border-gray-300 rounded-lg w-full md:w-64 focus:ring-pink-oke-boss focus:border-pink-oke-boss"
            />
        </form>
    </div>
  </div>

  <!-- BARIS 2 (Desktop Only) / Menu Navigation -->
  <div class="hidden md:block bg-pink-oke-boss-light border-t border-pink-oke-boss">
    <div class="max-w-screen-2xl mx-auto px-4">
      <ul class="font-medium flex flex-row space-x-14 py-3 justify-center">
        <li>
          <a href="{{ route('beranda') }}" class="@if(request()->routeIs('beranda')) text-pink-oke-boss font-bold border-b-2 border-pink-oke-boss @else text-gray-700 hover:text-pink-oke-boss @endif pb-1 inline-block" aria-current="{{ request()->routeIs('beranda') ? 'page' : 'false' }}">Beranda</a>
        </li>
        <li>
            <a href="{{ route('produk', ['category' => 'peralatan-makan-portable']) }}"
            class="{{ request('category') == 'peralatan-makan-portable'
                ? 'text-pink-oke-boss font-bold border-b-2 border-pink-oke-boss'
                : 'text-gray-700 hover:text-pink-oke-boss' }} pb-1 inline-block transition-all ease-in-out-duration-200">
                Peralatan Makan Portable
            </a>
        </li>
        <li>
          <a href="{{ route('produk', ['category' => 'perlengkapan-rumah']) }}"
             class="{{ request('category') == 'perlengkapan-rumah'
                 ? 'text-pink-oke-boss font-bold border-b-2 border-pink-oke-boss'
                 : 'text-gray-700 hover:text-pink-oke-boss' }} pb-1 inline-block transition-all ease-in-out-duration-200">
            Perlengkapan Rumah
          </a>
        </li>
        <li>
            <a href="{{ route('produk', ['category' => 'tas']) }}"
            class="{{ request('category') == 'tas'
                ? 'text-pink-oke-boss font-bold border-b-2 border-pink-oke-boss'
                : 'text-gray-700 hover:text-pink-oke-boss' }} pb-1 inline-block transition-all ease-in-out-duration-200">
                Tas
            </a>
        </li>
        <li>
            <a href="{{ route('produk', ['category' => 'perawatan-kecantikan']) }}"
            class="{{ request('category') == 'perawatan-kecantikan'
                ? 'text-pink-oke-boss font-bold border-b-2 border-pink-oke-boss'
                : 'text-gray-700 hover:text-pink-oke-boss' }} pb-1 inline-block transition-all ease-in-out-duration-200">
                Perawatan & Kecantikan
            </a>
        </li>
        <li>
            <a href="{{ route('produk') }}"
            class="{{ request()->routeIs('produk') && !request('category')
                ? 'text-pink-oke-boss font-bold border-b-2 border-pink-oke-boss'
                : 'text-gray-700 hover:text-pink-oke-boss' }} pb-1 inline-block transition-all ease-in-out-duration-200">
                Semua Produk
            </a>
        </li>
        <li>
          <a href="{{ route('tentang-kami') }}" class="@if(request()->routeIs('tentang-kami')) text-pink-oke-boss font-bold border-b-2 border-pink-oke-boss @else text-gray-700 hover:text-pink-oke-boss @endif pb-1 inline-block" aria-current="{{ request()->routeIs('tentang-kami') ? 'page' : 'false' }}">Tentang Kami</a>
        </li>
        {{-- <li>
          <a href="{{ route('kontak') }}" class="@if(request()->routeIs('kontak')) text-pink-oke-boss font-bold border-b-2 border-pink-oke-boss @else text-gray-700 hover:text-pink-oke-boss @endif pb-1 inline-block" aria-current="{{ request()->routeIs('kontak') ? 'page' : 'false' }}">Kontak</a>
        </li> --}}
      </ul>
    </div>
  </div>

  <!-- Mobile Menu (Collapsible) -->
    <div class="hidden md:hidden" id="navbar-menu">
    <div class="bg-gray-50 border-t border-gray-200">
        <ul class="font-medium flex flex-col space-y-2 p-4">

        <!-- Beranda -->
        <li>
            <a href="{{ route('beranda') }}"
            class="block py-2 px-3 rounded-lg transition
            {{ request()->routeIs('beranda')
                ? 'bg-pink-oke-boss text-white font-semibold'
                : 'text-gray-900 hover:bg-gray-100' }} transition-all ease-in-out-duration-200">
            Beranda
            </a>
        </li>

        <!-- Peralatan Makan -->
        <li>
            <a href="{{ route('produk', ['category' => 'peralatan-makan-portable']) }}"
            class="block py-2 px-3 rounded-lg transition
            {{ request('category') == 'peralatan-makan-portable'
                ? 'bg-pink-oke-boss text-white font-semibold'
                : 'text-gray-900 hover:bg-gray-100' }} transition-all ease-in-out-duration-200">
            Peralatan Makan Portable
            </a>
        </li>

        <!-- Perlengkapan Rumah -->
        <li>
            <a href="{{ route('produk', ['category' => 'perlengkapan-rumah']) }}"
            class="block py-2 px-3 rounded-lg transition
            {{ request('category') == 'perlengkapan-rumah'
                ? 'bg-pink-oke-boss text-white font-semibold'
                : 'text-gray-900 hover:bg-gray-100' }} transition-all ease-in-out-duration-200">
            Perlengkapan Rumah
            </a>
        </li>

        <!-- Tas -->
        <li>
            <a href="{{ route('produk', ['category' => 'tas']) }}"
            class="block py-2 px-3 rounded-lg transition
            {{ request('category') == 'tas'
                ? 'bg-pink-oke-boss text-white font-semibold'
                : 'text-gray-900 hover:bg-gray-100' }} transition-all ease-in-out-duration-200">
            Tas
            </a>
        </li>

        <!-- Perawatan -->
        <li>
            <a href="{{ route('produk', ['category' => 'perawatan-kecantikan']) }}"
            class="block py-2 px-3 rounded-lg transition
            {{ request('category') == 'perawatan-kecantikan'
                ? 'bg-pink-oke-boss text-white font-semibold'
                : 'text-gray-900 hover:bg-gray-100' }} transition-all ease-in-out-duration-200">
            Perawatan & Kecantikan
            </a>
        </li>

        <!-- Semua Produk -->
        <li>
            <a href="{{ route('produk') }}"
            class="block py-2 px-3 rounded-lg transition
            {{ request()->routeIs('produk') && !request('category')
                ? 'bg-pink-oke-boss text-white font-semibold'
                : 'text-gray-900 hover:bg-gray-100' }} transition-all ease-in-out-duration-200">
                Semua Produk
            </a>
        </li>

        <!-- Tentang Kami -->
        <li>
            <a href="{{ route('tentang-kami') }}"
            class="block py-2 px-3 rounded-lg transition
            {{ request()->routeIs('tentang-kami')
                ? 'bg-pink-oke-boss text-white font-semibold'
                : 'text-gray-900 hover:bg-gray-100' }} transition-all ease-in-out-duration-200">
            Tentang Kami
            </a>
        </li>

        <!-- WhatsApp -->
        <li class="pt-2 border-t border-gray-200">
            <a href="https://wa.me/6281234567890" target="_blank"
            class="flex items-center space-x-3 py-2 px-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
            <span class="text-sm font-semibold">Hubungi Kami</span>
            </a>
        </li>

        </ul>
    </div>
    </div>
</nav>
