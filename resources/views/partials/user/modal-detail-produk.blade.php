<div id="modalDetailProduk"
     class="fixed inset-0 z-50 hidden items-center justify-center backdrop-blur-md bg-black/40">

    <div class="bg-white w-[95%] max-w-5xl max-h-[90vh] rounded-2xl overflow-hidden flex flex-col relative">

        <!-- CLOSE -->
        <button onclick="closeModal()"
                class="absolute top-4 right-4 text-gray-500 text-xl z-10 hover:text-black">
            ✕
        </button>

        <div class="flex flex-col md:flex-row overflow-hidden h-full">

            <!-- LEFT -->
            <div class="md:w-1/2 p-6 space-y-4">

                <div class="aspect-square bg-gray-100 rounded-xl overflow-hidden">
                    <img id="modalImage" class="w-full h-full object-cover">
                </div>

                <div id="modalThumbnails" class="flex gap-2 overflow-x-auto"></div>

            </div>

            <!-- RIGHT -->
            <div class="md:w-1/2 p-6 overflow-y-auto space-y-3">

                <h2 id="modalName" class="text-xl font-bold"></h2>

                <p id="modalCategory" class="text-sm text-gray-500"></p>

                <p id="modalPrice" class="text-2xl font-bold text-pink-oke-boss"></p>

                <p class="text-sm text-gray-600">
                    Minimal pembelian: <span id="modalMinOrder"></span>
                </p>

                <p id="stockContainer" class="text-sm text-gray-600">
                    Sisa Stok: <span id="modalStock" class="font-bold text-gray-900"></span>
                </p>

                <!-- VARIANT -->
                <div>
                    <p class="font-semibold mb-2">Pilih Variasi</p>

                    <!-- WARNING -->
                    <p id="variantWarning" class="text-xs text-red-500 hidden">
                        Pilih variasi terlebih dahulu
                    </p>

                    <div id="modalVariants" class="flex flex-wrap gap-2"></div>
                </div>

                <!-- COLOR -->
                <div>
                    <p class="font-semibold mb-2">Pilih Warna</p>

                    <!-- WARNING -->
                    <p id="colorWarning" class="text-xs text-red-500 hidden">
                        Pilih warna terlebih dahulu
                    </p>

                    <div id="modalColors" class="flex flex-wrap gap-2"></div>
                </div>

                <!-- QTY -->
                <div>
                    <p class="font-semibold mb-2">Jumlah</p>
                    <div class="flex items-center gap-2">
                        <button onclick="decreaseQty()" class="bg-white hover:bg-gray-100 px-3 py-1 border rounded cursor-pointer transition-all ease-in-out duration-200">-</button>
                        <input id="qty" type="number" min="1" value="1"
                               class="w-14 py-1 text-center border rounded" style="appearance: none; -webkit-appearance: none; -moz-appearance: textfield;">
                        <button onclick="increaseQty()" class="bg-white hover:bg-gray-100 px-3 py-1 border rounded cursor-pointer transition-all ease-in-out duration-200">+</button>
                    </div>
                </div>

                <!-- DESC -->
                <div>
                    <p class="font-semibold mb-2">Deskripsi</p>
                    <p id="modalDescription" class="text-sm text-gray-600 leading-relaxed"></p>
                </div>

                <!-- BUTTON -->
                <div class="flex gap-3 pt-4">

                    <button id="btnAddToCart"
                            onclick="addToCart()"
                            disabled
                            class="flex-1 border border-pink-oke-boss bg-white hover:bg-gray-100 text-pink-oke-boss py-2 rounded-lg cursor-not-allowed opacity-50 transition-all ease-in-out duration-200">
                        + Keranjang
                    </button>

                    <button id="btnBuyNow"
                            onclick="buyNow()"
                            disabled
                            class="flex-1 bg-pink-oke-boss hover:bg-pink-oke-boss/80 text-white py-2 rounded-lg cursor-not-allowed opacity-50 transition-all ease-in-out duration-200">
                        Beli Sekarang
                    </button>

                </div>

            </div>

        </div>
    </div>
</div>
