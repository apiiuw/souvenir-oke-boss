@extends('layouts.main')

@section('container')
@php
    $totalQty = 0;
    $totalPrice = 0;
    $profileAddressReady = $user && $user->address_line && $user->province_name && $user->city_name && $user->district_name && $user->subdistrict_name && $user->rt && $user->rw;
@endphp

<div class="max-w-6xl min-h-screen mx-auto py-10 px-6 md:px-10">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ request()->query('type') === 'buynow' ? route('produk') : route('cart.index') }}" class="p-2 border rounded-full hover:bg-gray-100 text-gray-700 bg-white" title="{{ request()->query('type') === 'buynow' ? 'Kembali ke Produk' : 'Kembali ke Keranjang' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold">Checkout</h1>
            <p class="text-sm text-gray-500">Lengkapi data pengiriman sebelum melanjutkan ke WhatsApp.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <p class="font-semibold mb-1">Form belum lengkap.</p>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if($cart->items->count() > 0)
        <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
            <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST" class="space-y-6">
                @csrf
                @if(request()->query('type') === 'buynow' || request()->input('checkout_type') === 'buynow')
                    <input type="hidden" name="checkout_type" value="buynow">
                @endif

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between gap-4 mb-5">
                        <div>
                            <h2 class="text-lg font-bold">Data Penerima</h2>
                            <p class="text-sm text-gray-500">Pastikan nama dan nomor telepon mudah dihubungi.</p>
                        </div>
                        <a href="{{ route('user.profile.edit') }}" class="inline-flex items-center rounded-2xl border border-pink-200 px-4 py-2 text-xs font-bold uppercase tracking-[0.2em] text-pink-600 transition hover:bg-pink-50">
                            Edit Profil
                        </a>
                    </div>

                    @if($profileAddressReady)
                        <div class="mb-5 rounded-2xl border border-pink-100 bg-[#fff7fb] px-4 py-3 text-sm text-gray-600">
                            Data profil pengiriman Anda sudah tersimpan dan otomatis terisi di form ini. Silakan sesuaikan jika ada perubahan untuk pesanan kali ini.
                        </div>
                    @endif

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <div class="flex items-center h-6 mb-2">
                                <label for="customer_name" class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                            </div>
                            <input id="customer_name" name="customer_name" type="text" value="{{ old('customer_name', $user?->name) }}" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" placeholder="Masukkan nama lengkap" required>
                        </div>
                        <div>
                            <div class="flex items-center justify-between gap-3 h-6 mb-2">
                                <label for="recipient_name" class="block text-sm font-semibold text-gray-700">Nama Penerima</label>
                                <label class="inline-flex items-center gap-2 text-xs text-gray-500 cursor-pointer hover:text-gray-700 transition">
                                    <input id="same-as-customer" type="checkbox" class="rounded border-gray-300 text-pink-oke-boss focus:ring-pink-oke-boss">
                                    Samakan dengan nama lengkap
                                </label>
                            </div>
                            <input id="recipient_name" name="recipient_name" type="text" value="{{ old('recipient_name', $user?->name) }}" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" placeholder="Masukkan nama penerima" required>
                        </div>
                        <div class="md:col-span-2">
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                            <input id="phone" name="phone" type="text" inputmode="tel" value="{{ old('phone', $user?->phone) }}" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" placeholder="Contoh: 081234567890" required>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <div class="mb-5">
                        <h2 class="text-lg font-bold">Alamat Pengiriman</h2>
                        <p class="text-sm text-gray-500">Isi alamat selengkap mungkin agar pesanan mudah diproses.</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="address_line" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
                            <textarea id="address_line" name="address_line" rows="4" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" placeholder="Nama jalan, nomor rumah, patokan, dan detail alamat lainnya" required>{{ old('address_line', $user?->address_line) }}</textarea>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label for="province_id" class="block text-sm font-semibold text-gray-700 mb-2">Provinsi</label>
                                <select id="province_id" name="province_id" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" required></select>
                                <input type="hidden" id="province_name" name="province_name" value="{{ old('province_name', $user?->province_name) }}">
                            </div>
                            <div>
                                <label for="city_id" class="block text-sm font-semibold text-gray-700 mb-2">Kabupaten / Kota</label>
                                <select id="city_id" name="city_id" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" required disabled></select>
                                <input type="hidden" id="city_name" name="city_name" value="{{ old('city_name', $user?->city_name) }}">
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label for="district_id" class="block text-sm font-semibold text-gray-700 mb-2">Kecamatan</label>
                                <select id="district_id" name="district_id" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" required disabled></select>
                                <input type="hidden" id="district_name" name="district_name" value="{{ old('district_name', $user?->district_name) }}">
                            </div>
                            <div>
                                <label for="subdistrict_id" class="block text-sm font-semibold text-gray-700 mb-2">Kelurahan / Desa</label>
                                <select id="subdistrict_id" name="subdistrict_id" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" required disabled></select>
                                <input type="hidden" id="subdistrict_name" name="subdistrict_name" value="{{ old('subdistrict_name', $user?->subdistrict_name) }}">
                            </div>
                        </div>


                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label for="rt" class="block text-sm font-semibold text-gray-700 mb-2">RT</label>
                                <input id="rt" name="rt" type="text" value="{{ old('rt', $user?->rt) }}" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" placeholder="Contoh: 001" required>
                            </div>
                            <div>
                                <label for="rw" class="block text-sm font-semibold text-gray-700 mb-2">RW</label>
                                <input id="rw" name="rw" type="text" value="{{ old('rw', $user?->rw) }}" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" placeholder="Contoh: 002" required>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between gap-3 mb-2">
                                <label class="block text-sm font-semibold text-gray-700">Titik Maps</label>
                                <button id="use-current-location" type="button" class="text-sm font-semibold text-pink-oke-boss hover:opacity-80">Gunakan lokasi saya sekarang</button>
                            </div>
                            <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white">
                                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 bg-[#fff7fb] px-4 py-3">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Pilih titik pengiriman di peta</p>
                                        <p class="text-xs text-gray-500">Klik peta untuk memilih titik, atau gunakan lokasi Anda saat ini.</p>
                                    </div>
                                </div>

                                <div id="map" class="w-full z-0"></div>

                                <input id="maps_link" name="maps_link" type="hidden" value="{{ old('maps_link', $user?->maps_link) }}">
                                <input id="maps_latitude" name="maps_latitude" type="hidden" value="{{ old('maps_latitude', $user?->maps_latitude) }}">
                                <input id="maps_longitude" name="maps_longitude" type="hidden" value="{{ old('maps_longitude', $user?->maps_longitude) }}">
                            </div>
                            <p id="location-feedback" class="mt-2 text-xs text-gray-500">Titik belum dipilih. Klik pada peta atau gunakan lokasi saya sekarang.</p>
                        </div>

                        <div>
                            <label for="delivery_note" class="block text-sm font-semibold text-gray-700 mb-2">Catatan Pengiriman</label>
                            <textarea id="delivery_note" name="delivery_note" rows="3" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" placeholder="Contoh: Rumah pagar hitam, hubungi sebelum sampai">{{ old('delivery_note') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <div class="mb-5">
                        <h2 class="text-lg font-bold">Layanan Pengiriman</h2>
                        <p class="text-sm text-gray-500">Pilih kurir dan layanan yang diinginkan.</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="courier" class="block text-sm font-semibold text-gray-700 mb-2">Kurir</label>
                            <select id="courier" name="courier" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" required>
                                <option value="">Pilih Kurir</option>
                                <option value="jne">JNE</option>
                                <option value="pos">POS Indonesia</option>
                                <option value="tiki">TIKI</option>
                            </select>
                        </div>

                        <div id="service-container" class="hidden">
                            <label for="service" class="block text-sm font-semibold text-gray-700 mb-2">Layanan</label>
                            <select id="service" name="service" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" required></select>
                        </div>
                        
                        <input type="hidden" id="shipping_cost" name="shipping_cost" value="0">
                        
                        <div id="shipping-info" class="hidden rounded-2xl border border-pink-100 bg-[#fff7fb] px-4 py-3 text-sm text-gray-600">
                            Estimasi sampai: <span id="estimate-time" class="font-semibold"></span>
                        </div>
                    </div>
                </div>

            </form>

            <div class="space-y-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <h2 class="text-lg font-bold mb-4">Ringkasan Produk</h2>

                    <div class="space-y-4">
                        @foreach ($cart->items as $item)
                            @php
                                $subtotal = $item->product->price * $item->qty;
                                $totalQty += $item->qty;
                                $totalPrice += $subtotal;
                            @endphp

                            <div class="flex gap-4 border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                                <img src="{{ asset('storage/' . $item->product->images->first()->image) }}"
                                     class="w-16 h-16 object-cover rounded-2xl border border-gray-100">
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-gray-900">{{ $item->product->name }}</p>
                                    <p class="text-sm text-gray-500">Variasi: {{ $item->variant->name ?? '-' }}</p>
                                    <p class="text-sm text-gray-500">Warna: {{ $item->color->name ?? '-' }}</p>
                                    <div class="mt-2 flex items-center justify-between gap-3 text-sm">
                                        <span class="font-medium">x{{ $item->qty }}</span>
                                        <span class="font-bold text-pink-oke-boss">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-[#fff7fb] p-6 rounded-3xl border border-pink-100 sticky top-36">
                    <h2 class="text-lg font-bold mb-4">Ringkasan Checkout</h2>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between text-gray-600">
                            <span>Total Item</span>
                            <span>{{ $totalQty }}</span>
                        </div>
                        <div class="flex items-center justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-gray-600">
                            <span>Ongkos Kirim</span>
                            <span id="summary-shipping-cost">Rp 0</span>
                        </div>
                        <div class="flex items-center justify-between text-base font-bold text-pink-oke-boss border-t border-pink-100 pt-3">
                            <span>Total Pembayaran</span>
                            <span id="summary-grand-total">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>

                    </div>

                    <p class="mt-4 text-sm text-gray-600">Saat tombol checkout ditekan, data pesanan akan disimpan lalu Anda diarahkan ke WhatsApp admin untuk melanjutkan pemesanan.</p>

                    <button form="checkout-form" type="submit" class="mt-5 w-full px-5 py-3 bg-pink-oke-boss text-white font-bold rounded-2xl shadow-md hover:bg-pink-oke-boss/90 transition">
                        Checkout via WhatsApp
                    </button>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-20">
            <p class="text-gray-500 mb-4">Keranjang Anda kosong, tidak ada yang bisa di-checkout.</p>
            <a href="{{ route('produk') }}" class="inline-block px-6 py-2 bg-pink-oke-boss text-white rounded font-bold hover:bg-opacity-90 transition">Mulai Belanja</a>
        </div>
    @endif
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    #map {
        height: 340px;
        width: 100%;
        z-index: 10;
        cursor: crosshair;
    }

    .leaflet-container {
        font-family: inherit;
    }

    .leaflet-control-attribution {
        font-size: 10px;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const provinceSelect = document.getElementById('province_id');
    const citySelect = document.getElementById('city_id');
    const districtSelect = document.getElementById('district_id');
    const subdistrictSelect = document.getElementById('subdistrict_id');
    
    const provinceNameInput = document.getElementById('province_name');
    const cityNameInput = document.getElementById('city_name');
    const districtNameInput = document.getElementById('district_name');
    const subdistrictNameInput = document.getElementById('subdistrict_name');

    const customerNameInput = document.getElementById('customer_name');
    const recipientNameInput = document.getElementById('recipient_name');
    const sameAsCustomerCheckbox = document.getElementById('same-as-customer');
    const useCurrentLocationButton = document.getElementById('use-current-location');
    const mapsLinkInput = document.getElementById('maps_link');
    const mapsLatitudeInput = document.getElementById('maps_latitude');
    const mapsLongitudeInput = document.getElementById('maps_longitude');
    const locationFeedback = document.getElementById('location-feedback');
    
    const courierSelect = document.getElementById('courier');
    const serviceContainer = document.getElementById('service-container');
    const serviceSelect = document.getElementById('service');
    const shippingCostInput = document.getElementById('shipping_cost');
    const shippingInfo = document.getElementById('shipping-info');
    const estimateTimeSpan = document.getElementById('estimate-time');
    const summaryShippingCost = document.getElementById('summary-shipping-cost');
    const summaryGrandTotal = document.getElementById('summary-grand-total');

    const totalWeight = @json($cart->items->sum(fn($item) => ($item->product->weight ?? 200) * $item->qty));
    const totalPrice = @json($totalPrice);

    const oldProvinceId = @json(old('province_id', $user?->province_id));
    const oldCityId = @json(old('city_id', $user?->city_id));
    const oldDistrictId = @json(old('district_id', $user?->district_id));
    const oldSubDistrictId = @json(old('subdistrict_id', $user?->subdistrict_id));


    const formatRupiah = (number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(number);
    };

    const setSelectOptions = (select, items, placeholder) => {
        select.innerHTML = '';
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = placeholder;
        select.appendChild(defaultOption);

        items.forEach((item) => {
            const option = document.createElement('option');
            option.value = item.province_id || item.city_id || item.id;
            option.textContent = item.province || item.city_name || item.name;
            if (item.type) {
                option.textContent = `${item.type} ${item.city_name}`;
            }
            select.appendChild(option);
        });
    };

    const loadProvinces = async () => {
        try {
            const response = await fetch("{{ route('shipping.provinces') }}");
            const data = await response.json();
            setSelectOptions(provinceSelect, data, 'Pilih provinsi');

            if (oldProvinceId) {
                provinceSelect.value = oldProvinceId;
                const selected = provinceSelect.options[provinceSelect.selectedIndex];
                provinceNameInput.value = selected ? selected.text : '';
                await loadCities(oldProvinceId, oldCityId);
            }
        } catch (error) {
            console.error('Error loading provinces:', error);
        }
    };

    const loadCities = async (provinceId, selectedCityId = null) => {
        citySelect.disabled = true;
        districtSelect.disabled = true;
        subdistrictSelect.disabled = true;
        setSelectOptions(citySelect, [], 'Memuat kabupaten / kota...');
        setSelectOptions(districtSelect, [], 'Pilih kabupaten / kota terlebih dahulu');
        setSelectOptions(subdistrictSelect, [], 'Pilih kecamatan terlebih dahulu');

        if (!provinceId) return;

        try {
            const response = await fetch(`{{ url('/shipping/cities') }}/${provinceId}`);
            const data = await response.json();
            setSelectOptions(citySelect, data, 'Pilih kabupaten / kota');
            citySelect.disabled = false;

            if (selectedCityId) {
                citySelect.value = selectedCityId;
                const selected = citySelect.options[citySelect.selectedIndex];
                cityNameInput.value = selected ? selected.text : '';
                await loadDistricts(selectedCityId, oldDistrictId);
            }
        } catch (error) {
            console.error('Error loading cities:', error);
        }
    };

    const loadDistricts = async (cityId, selectedDistrictId = null) => {
        districtSelect.disabled = true;
        subdistrictSelect.disabled = true;
        setSelectOptions(districtSelect, [], 'Memuat kecamatan...');
        setSelectOptions(subdistrictSelect, [], 'Pilih kecamatan terlebih dahulu');

        if (!cityId) return;

        try {
            const response = await fetch(`{{ url('/shipping/districts') }}/${cityId}`);
            const data = await response.json();
            setSelectOptions(districtSelect, data, 'Pilih kecamatan');
            districtSelect.disabled = false;

            if (selectedDistrictId) {
                districtSelect.value = selectedDistrictId;
                const selected = districtSelect.options[districtSelect.selectedIndex];
                districtNameInput.value = selected ? selected.text : '';
                await loadSubDistricts(selectedDistrictId, oldSubDistrictId);
            }
        } catch (error) {
            console.error('Error loading districts:', error);
        }
    };

    const loadSubDistricts = async (districtId, selectedSubDistrictId = null) => {
        subdistrictSelect.disabled = true;
        setSelectOptions(subdistrictSelect, [], 'Memuat kelurahan / desa...');

        if (!districtId) return;

        try {
            const response = await fetch(`{{ url('/shipping/sub-districts') }}/${districtId}`);
            const data = await response.json();
            setSelectOptions(subdistrictSelect, data, 'Pilih kelurahan / desa');
            subdistrictSelect.disabled = false;

            if (selectedSubDistrictId) {
                subdistrictSelect.value = selectedSubDistrictId;
                const selected = subdistrictSelect.options[subdistrictSelect.selectedIndex];
                subdistrictNameInput.value = selected ? selected.text : '';
            }
        } catch (error) {
            console.error('Error loading sub-districts:', error);
        }
    };

    const calculateShipping = async () => {
        const subdistrictId = subdistrictSelect.value;
        const courier = courierSelect.value;

        if (!subdistrictId || !courier) {
            serviceContainer.classList.add('hidden');
            shippingInfo.classList.add('hidden');
            updateSummary(0);
            return;
        }

        serviceSelect.innerHTML = '<option value="">Memuat layanan...</option>';
        serviceContainer.classList.remove('hidden');

        try {
            const response = await fetch("{{ route('shipping.cost') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    destination: subdistrictId,
                    weight: totalWeight,
                    courier: courier
                })
            });

            const data = await response.json();
            
            serviceSelect.innerHTML = '<option value="">Pilih Layanan</option>';
            if (data && data.length > 0) {
                // Filter logic
                let filteredData = data;
                const isHeavy = totalWeight >= 10000; // 10kg threshold for trucking

                if (isHeavy) {
                    // Even if heavy, filter out vehicle services
                    filteredData = data.filter(s => {
                        const desc = s.description.toLowerCase();
                        return !desc.includes('motor') && !desc.includes('mobil') && !desc.includes('kendaraan');
                    });
                } else {
                    // If light, filter out Trucking/Cargo services AND vehicle services
                    filteredData = data.filter(s => {
                        const name = s.service.toLowerCase();
                        const desc = s.description.toLowerCase();
                        const isTrucking = name.includes('jtr') || desc.includes('trucking') || desc.includes('cargo');
                        const isVehicle = desc.includes('motor') || desc.includes('mobil') || desc.includes('kendaraan');
                        
                        return !isTrucking && !isVehicle;
                    });
                }


                if (filteredData.length === 0 && data.length > 0) {
                    filteredData = data; // Fallback if filter leaves nothing
                }

                filteredData.forEach(s => {
                    const option = document.createElement('option');
                    option.value = s.cost;
                    option.textContent = `${s.service} (${s.description}) - ${formatRupiah(s.cost)}`;
                    option.dataset.etd = s.etd;
                    option.dataset.serviceName = s.service;
                    serviceSelect.appendChild(option);
                });
            } else {

                serviceSelect.innerHTML = '<option value="">Layanan tidak tersedia</option>';
            }
        } catch (error) {
            console.error('Error calculating shipping:', error);
            serviceSelect.innerHTML = '<option value="">Gagal memuat layanan</option>';
        }
    };


    const updateSummary = (cost) => {
        shippingCostInput.value = cost;
        summaryShippingCost.textContent = formatRupiah(cost);
        summaryGrandTotal.textContent = formatRupiah(totalPrice + parseInt(cost));
    };

    provinceSelect.addEventListener('change', async () => {
        const selected = provinceSelect.options[provinceSelect.selectedIndex];
        provinceNameInput.value = selected ? selected.text : '';
        await loadCities(provinceSelect.value);
        calculateShipping();
    });

    citySelect.addEventListener('change', async () => {
        const selected = citySelect.options[citySelect.selectedIndex];
        cityNameInput.value = selected ? selected.text : '';
        await loadDistricts(citySelect.value);
        calculateShipping();
    });

    districtSelect.addEventListener('change', async () => {
        const selected = districtSelect.options[districtSelect.selectedIndex];
        districtNameInput.value = selected ? selected.text : '';
        await loadSubDistricts(districtSelect.value);
        calculateShipping();
    });

    subdistrictSelect.addEventListener('change', () => {
        const selected = subdistrictSelect.options[subdistrictSelect.selectedIndex];
        subdistrictNameInput.value = selected ? selected.text : '';
        calculateShipping();
    });


    courierSelect.addEventListener('change', calculateShipping);

    serviceSelect.addEventListener('change', () => {
        const selected = serviceSelect.options[serviceSelect.selectedIndex];
        if (selected && selected.value) {
            updateSummary(selected.value);
            estimateTimeSpan.textContent = `${selected.dataset.etd}`;
            shippingInfo.classList.remove('hidden');
            
            // Set hidden service name for form submission if needed, 
            // but we can just use the value and service name in controller if we store it.
            // Let's just store the service name in a hidden field or similar.
            // For now, let's just make sure the selected option text or value is clear.
        } else {
            updateSummary(0);
            shippingInfo.classList.add('hidden');
        }
    });

    // Same as customer logic
    sameAsCustomerCheckbox.addEventListener('change', () => {
        if (sameAsCustomerCheckbox.checked) {
            recipientNameInput.value = customerNameInput.value;
        }
    });

    // Maps logic
    const defaultLat = -6.2000000;
    const defaultLng = 106.8166667;
    const existingCoordinates = mapsLatitudeInput.value && mapsLongitudeInput.value ? {
        latitude: parseFloat(mapsLatitudeInput.value),
        longitude: parseFloat(mapsLongitudeInput.value)
    } : null;

    const map = L.map('map').setView([existingCoordinates?.latitude ?? defaultLat, existingCoordinates?.longitude ?? defaultLng], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    
    let marker = existingCoordinates ? L.marker([existingCoordinates.latitude, existingCoordinates.longitude]).addTo(map) : null;

    map.on('click', (e) => {
        if (marker) map.removeLayer(marker);
        marker = L.marker(e.latlng).addTo(map);
        mapsLatitudeInput.value = e.latlng.lat;
        mapsLongitudeInput.value = e.latlng.lng;
        mapsLinkInput.value = `https://www.google.com/maps?q=${e.latlng.lat},${e.latlng.lng}`;
        locationFeedback.textContent = 'Lokasi dipilih.';
    });

    useCurrentLocationButton.addEventListener('click', () => {
        navigator.geolocation.getCurrentPosition((pos) => {
            const { latitude, longitude } = pos.coords;
            map.setView([latitude, longitude], 15);
            if (marker) map.removeLayer(marker);
            marker = L.marker([latitude, longitude]).addTo(map);
            mapsLatitudeInput.value = latitude;
            mapsLongitudeInput.value = longitude;
            mapsLinkInput.value = `https://www.google.com/maps?q=${latitude},${longitude}`;
        });
    });

    loadProvinces();

    const checkoutForm = document.getElementById('checkout-form');
    checkoutForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const submitBtn = document.querySelector('button[form="checkout-form"]');
        submitBtn.disabled = true;
        submitBtn.innerText = 'Memproses...';

        const formData = new FormData(checkoutForm);
        // Add service name
        const selectedService = serviceSelect.options[serviceSelect.selectedIndex];
        if (selectedService) {
            formData.set('service', selectedService.dataset.serviceName);
        }

        try {
            const response = await fetch(checkoutForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();
            if (data.success) {
                window.open(data.whatsapp_url, '_blank');
                window.location.href = data.redirect_url;
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            submitBtn.disabled = false;
            submitBtn.innerText = 'Checkout via WhatsApp';
            alert(error.message);
        }
    });
});

</script>
@endpush
