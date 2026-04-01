@extends('layouts.main')

@section('container')

@php
$categoryLabels = [
    'peralatan-makan-portable' => 'Peralatan Makan Portable',
    'perlengkapan-rumah' => 'Perlengkapan Rumah',
    'tas' => 'Tas',
    'perawatan-kecantikan' => 'Perawatan & Kecantikan',
];
@endphp

<div class="max-w-screen-2xl min-h-screen mx-auto px-8 md:px-20 py-10">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <div>
            <h1 class="text-3xl font-bold">Kategori Produk</h1>
            <p class="text-gray-500 text-sm">
                Menampilkan {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }}
                dari {{ $products->total() }} hasil
            </p>
        </div>

        <!-- Sort -->
        <form method="GET" action="{{ route('produk') }}">
            <select name="sort" onchange="this.form.submit()" class="border rounded-lg px-4 py-2 text-sm">
                <option value="">Urutkan</option>
                <option value="harga_terendah" {{ request('sort') == 'harga_terendah' ? 'selected' : '' }}>
                    Harga Terendah
                </option>
                <option value="harga_tertinggi" {{ request('sort') == 'harga_tertinggi' ? 'selected' : '' }}>
                    Harga Tertinggi
                </option>
            </select>
        </form>
    </div>

    <!-- Layout -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <!-- Sidebar (Desktop) -->
        <div class="hidden md:block">
            @include('partials.sidebar-produk')
        </div>

        <!-- Content -->
        <div class="md:col-span-3">

            <!-- Sidebar Mobile (Toggle simple) -->
            <div class="md:hidden mb-4">
                <details class="bg-gray-100 rounded-lg p-3">
                    <summary class="cursor-pointer font-semibold">
                        Filter Produk
                    </summary>
                    <div class="mt-3">
                        @include('partials.sidebar-produk')
                    </div>
                </details>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">

            @forelse ($products as $product)
            <div
            onclick="openModal(this)"

            data-name="{{ $product->name }}"
            data-category="{{ $product->category->name }}"
            data-price="Rp {{ number_format($product->price, 0, ',', '.') }}"
            data-min="{{ $product->min_order }} pcs"
            data-description="{{ $product->description }}"
            data-id="{{ $product->id }}"

            data-images='@json($product->images->pluck("image"))'
            data-colors='@json($product->variants)'

            class="cursor-pointer bg-white hover:bg-gray-100 rounded-lg shadow transition-all duration-200"
            >

                <!-- Image -->
                <div class="aspect-square bg-gray-100">
                    <img
                        src="{{ $product->images->first()
                            ? asset('storage/' . $product->images->first()->image)
                            : 'https://via.placeholder.com/400' }}"
                        class="w-full h-full object-cover rounded-t-xl"
                    >
                </div>

                <!-- Content -->
                <div class="p-4 space-y-1">

                    <!-- Nama -->
                    <h3 class="font-semibold text-sm line-clamp-2">
                        {{ $product->name }}
                    </h3>

                    <!-- Harga -->
                    <p class="text-pink-oke-boss font-bold text-sm">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    <!-- Kategori -->
                    <p class="text-gray-500 text-xs">
                        {{ $product->category->name }}
                    </p>

                    <!-- Action -->
                    <div class="flex justify-end pt-2">
                        <button onclick="event.stopPropagation()"
                        class="bg-pink-oke-boss text-white w-8 h-8 rounded-full">
                            +
                        </button>
                    </div>

                </div>

            </div>
            @empty
            <p class="col-span-full text-center text-gray-500">
                Produk tidak ditemukan
            </p>
            @endforelse

            </div>

            <div class="mt-8 w-full">
                <div class="flex justify-center">
                    {{ $products->links() }}
                </div>
            </div>

        </div>

    </div>

</div>

@include('partials.modal-detail-produk')
@include('partials.keranjang-produk')

@push('scripts')
<script>
let images = [];
let currentIndex = 0;
let selectedProductId = null;

function openModal(el) {
    selectedProductId = el.dataset.id;
    const modal = document.getElementById('modalDetailProduk');
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    document.getElementById('btnAddToCart').disabled = true;
    document.getElementById('btnAddToCart').classList.add('opacity-50','cursor-not-allowed');

    document.getElementById('variantWarning').classList.remove('hidden');


    // Basic
    modalName.innerText = el.dataset.name;
    modalCategory.innerText = el.dataset.category;
    modalPrice.innerText = el.dataset.price;
    modalMinOrder.innerText = el.dataset.min;
    modalDescription.innerText = el.dataset.description;

    // Images
    images = JSON.parse(el.dataset.images);
    currentIndex = 0;
    renderImages();

    // Colors
    const colors = JSON.parse(el.dataset.colors);
    modalColors.innerHTML = '';

    colors.forEach(c => {
        modalColors.innerHTML += `
            <div onclick="selectColor(this)"
                data-id="${c.id}"
                class="border rounded px-3 py-2 cursor-pointer flex items-center gap-2 hover:border-pink-oke-boss transition">

                <img src="/storage/${c.image}" class="w-6 h-6 rounded">
                <span class="text-xs">${c.name}</span>
            </div>
        `;
    });
}

function renderImages() {
    modalImage.src = "/storage/" + images[currentIndex];

    let thumbs = '';
    images.forEach((img, i) => {
        thumbs += `
            <img src="/storage/${img}" onclick="setImage(${i})"
            class="w-16 h-16 object-cover rounded cursor-pointer border ${i===currentIndex ? 'border-pink-oke-boss' : ''}">
        `;
    });

    modalThumbnails.innerHTML = thumbs;
}

function setImage(i){
    currentIndex = i;
    renderImages();
}

function closeModal(){
    modalDetailProduk.classList.add('hidden');
    modalDetailProduk.classList.remove('flex');
}

function increaseQty(){
    let q = document.getElementById('qty');
    q.value = parseInt(q.value) + 1;
}

function decreaseQty(){
    let q = document.getElementById('qty');
    if(q.value > 1) q.value--;
}

function selectColor(el){
    document.querySelectorAll('#modalColors div').forEach(e=>{
        e.classList.remove('border-pink-oke-boss');
    });

    el.classList.add('border-pink-oke-boss');

    selectedVariantId = el.dataset.id;

    // enable button
    let btn = document.getElementById('btnAddToCart');
    btn.disabled = false;
    btn.classList.remove('opacity-50','cursor-not-allowed');

    document.getElementById('variantWarning').classList.add('hidden');
}

function addToCart() {
    let qty = document.getElementById('qty').value;

    if (!selectedVariantId) {
        document.getElementById('variantWarning').classList.remove('hidden');
        return;
    }

    fetch("/cart/add", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            product_id: selectedProductId,
            variant_id: selectedVariantId,
            qty: qty
        })
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('cartCount').innerText = data.total;
        closeModal();
    });
}
</script>
@endpush

@endsection
