<div class="space-y-3">

    <!-- Semua -->
    <a href="{{ route('produk') }}"
    class="block px-4 py-3 rounded-xl
    {{ !request('category') ? 'bg-pink-oke-boss text-white' : 'bg-gray-100' }}">
        Semua Produk
    </a>

    @foreach ($categories as $category)
        <a href="{{ route('produk', ['category' => $category->slug]) }}"
        class="block px-4 py-3 rounded-xl
        {{ request('category') == $category->slug
            ? 'bg-pink-oke-boss text-white'
            : 'bg-gray-100 hover:bg-gray-200' }}">
            {{ $category->name }}
        </a>
    @endforeach

</div>
