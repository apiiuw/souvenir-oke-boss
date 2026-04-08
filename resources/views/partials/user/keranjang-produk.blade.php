<a id="floatingCart" href="{{ route('cart.index') }}"
   class="fixed bottom-6 right-6 z-50 bg-pink-oke-boss text-white p-4 rounded-full shadow-lg hover:scale-105 transition {{ $cartCount > 0 ? '' : 'hidden' }}">

    <!-- Icon -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 6h12m-6-6v6"/>
    </svg>

    <!-- Badge -->
    <span id="cartCount"
          class="absolute -top-2 -right-2 bg-red-500 text-xs w-5 h-5 flex items-center justify-center rounded-full">
        {{ $cartCount }}
    </span>
</a>
