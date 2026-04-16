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
                                <label for="district_name" class="block text-sm font-semibold text-gray-700 mb-2">Kecamatan</label>
                                <input id="district_name" name="district_name" type="text" list="district-suggestions" value="{{ old('district_name', $user?->district_name) }}" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" placeholder="Pilih kabupaten/kota terlebih dahulu" autocomplete="off" required>
                                <datalist id="district-suggestions"></datalist>
                                <input type="hidden" id="district_id" name="district_id" value="{{ old('district_id', $user?->district_id) }}">
                            </div>
                            <div>
                                <label for="subdistrict_name" class="block text-sm font-semibold text-gray-700 mb-2">Kelurahan / Desa</label>
                                <input id="subdistrict_name" name="subdistrict_name" type="text" list="subdistrict-suggestions" value="{{ old('subdistrict_name', $user?->subdistrict_name) }}" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" placeholder="Pilih kecamatan terlebih dahulu" autocomplete="off" required>
                                <datalist id="subdistrict-suggestions"></datalist>
                                <input type="hidden" id="subdistrict_id" name="subdistrict_id" value="{{ old('subdistrict_id', $user?->subdistrict_id) }}">
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
                        <div class="flex items-center justify-between text-base font-bold text-pink-oke-boss border-t border-pink-100 pt-3">
                            <span>Total Belanja</span>
                            <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
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
    const regionApiBase = 'https://www.emsifa.com/api-wilayah-indonesia/api';

    const provinceSelect = document.getElementById('province_id');
    const citySelect = document.getElementById('city_id');
    const provinceNameInput = document.getElementById('province_name');
    const cityNameInput = document.getElementById('city_name');
    const districtInput = document.getElementById('district_name');
    const districtIdInput = document.getElementById('district_id');
    const districtList = document.getElementById('district-suggestions');
    const subdistrictInput = document.getElementById('subdistrict_name');
    const subdistrictIdInput = document.getElementById('subdistrict_id');
    const subdistrictList = document.getElementById('subdistrict-suggestions');
    const customerNameInput = document.getElementById('customer_name');
    const recipientNameInput = document.getElementById('recipient_name');
    const sameAsCustomerCheckbox = document.getElementById('same-as-customer');
    const useCurrentLocationButton = document.getElementById('use-current-location');
    const mapsLinkInput = document.getElementById('maps_link');
    const mapsLatitudeInput = document.getElementById('maps_latitude');
    const mapsLongitudeInput = document.getElementById('maps_longitude');
    const locationFeedback = document.getElementById('location-feedback');

    const oldProvinceId = @json(old('province_id', $user?->province_id));
    const oldCityId = @json(old('city_id', $user?->city_id));
    const oldSubdistrictId = @json(old('subdistrict_id', $user?->subdistrict_id));
    const oldDistrictName = @json(old('district_name', $user?->district_name));
    const oldSubdistrictName = @json(old('subdistrict_name', $user?->subdistrict_name));

    let districts = [];
    let subdistricts = [];
    let shouldRestoreDistrict = true;
    let shouldRestoreSubdistrict = true;

    const setSelectOptions = (select, items, placeholder) => {
        select.innerHTML = '';

        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = placeholder;
        select.appendChild(defaultOption);

        items.forEach((item) => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = item.name;
            select.appendChild(option);
        });
    };

    const fillDatalist = (list, items) => {
        list.innerHTML = '';

        items.forEach((item) => {
            const option = document.createElement('option');
            option.value = item.name;
            option.label = item.name;
            list.appendChild(option);
        });
    };

    const setProvinceName = () => {
        const selected = provinceSelect.options[provinceSelect.selectedIndex];
        provinceNameInput.value = selected && selected.value ? selected.text : '';
    };

    const setCityName = () => {
        const selected = citySelect.options[citySelect.selectedIndex];
        cityNameInput.value = selected && selected.value ? selected.text : '';
    };

    const syncDistrictSelection = () => {
        const match = districts.find((item) => item.name.toLowerCase() === districtInput.value.trim().toLowerCase());
            districtIdInput.value = match ? match.id : '';

        if (!match) {
            subdistricts = [];
            subdistrictInput.value = '';
            subdistrictIdInput.value = '';
            subdistrictList.innerHTML = '';
            subdistrictInput.placeholder = 'Pilih kecamatan dari sugesti yang tersedia';
            return;
        }

        const selectedSubdistrictId = shouldRestoreSubdistrict ? oldSubdistrictId : null;
        const selectedSubdistrictName = shouldRestoreSubdistrict ? oldSubdistrictName : '';

        shouldRestoreSubdistrict = false;
        loadSubdistricts(match.id, selectedSubdistrictId, selectedSubdistrictName);
    };

    const syncSubdistrictSelection = () => {
        const match = subdistricts.find((item) => item.name.toLowerCase() === subdistrictInput.value.trim().toLowerCase());
        subdistrictIdInput.value = match ? match.id : '';
    };

    const loadProvinces = async () => {
        const response = await fetch(`${regionApiBase}/provinces.json`);
        const data = await response.json();
        setSelectOptions(provinceSelect, data, 'Pilih provinsi');

        if (oldProvinceId) {
            provinceSelect.value = oldProvinceId;
            setProvinceName();
            await loadCities(oldProvinceId, oldCityId);
        }
    };

    const loadCities = async (provinceId, selectedCityId = null) => {
        citySelect.disabled = true;
        setSelectOptions(citySelect, [], 'Memuat kabupaten / kota...');
        districtInput.value = '';
        districtIdInput.value = '';
        subdistrictInput.value = '';
        subdistrictIdInput.value = '';
        districtList.innerHTML = '';
        subdistrictList.innerHTML = '';

        if (!provinceId) {
            setSelectOptions(citySelect, [], 'Pilih provinsi terlebih dahulu');
            cityNameInput.value = '';
            citySelect.disabled = true;
            return;
        }

        const response = await fetch(`${regionApiBase}/regencies/${provinceId}.json`);
        const data = await response.json();
        setSelectOptions(citySelect, data, 'Pilih kabupaten / kota');
        citySelect.disabled = false;

        if (selectedCityId) {
            citySelect.value = selectedCityId;
            setCityName();
            await loadDistricts(selectedCityId, shouldRestoreDistrict ? oldDistrictName : '');
        }
    };

    const loadDistricts = async (cityId, selectedDistrictName = '') => {
        districtInput.placeholder = 'Memuat kecamatan...';
        subdistrictInput.placeholder = 'Pilih kecamatan terlebih dahulu';
        districtIdInput.value = '';
        subdistrictInput.value = '';
        subdistrictIdInput.value = '';
        subdistrictList.innerHTML = '';

        if (!cityId) {
            districts = [];
            fillDatalist(districtList, []);
            districtInput.placeholder = 'Pilih kabupaten/kota terlebih dahulu';
            return;
        }

        const response = await fetch(`${regionApiBase}/districts/${cityId}.json`);
        districts = await response.json();
        fillDatalist(districtList, districts);
        districtInput.placeholder = 'Ketik atau pilih kecamatan';

        if (selectedDistrictName) {
            districtInput.value = selectedDistrictName;
            shouldRestoreDistrict = false;
            syncDistrictSelection();
        }
    };

    const loadSubdistricts = async (districtId, selectedSubdistrictId = null, selectedSubdistrictName = '') => {
        subdistrictInput.placeholder = 'Memuat kelurahan / desa...';
        subdistrictInput.value = '';
        subdistrictIdInput.value = '';
        subdistrictList.innerHTML = '';

        const response = await fetch(`${regionApiBase}/villages/${districtId}.json`);
        subdistricts = await response.json();
        fillDatalist(subdistrictList, subdistricts);
        subdistrictInput.placeholder = 'Ketik atau pilih kelurahan / desa';

        if (selectedSubdistrictName) {
            subdistrictInput.value = selectedSubdistrictName;
            syncSubdistrictSelection();
        } else if (selectedSubdistrictId) {
            const match = subdistricts.find((item) => item.id === selectedSubdistrictId);
            if (match) {
                subdistrictInput.value = match.name;
                syncSubdistrictSelection();
            }
        }
    };

    provinceSelect.addEventListener('change', async () => {
        shouldRestoreDistrict = false;
        shouldRestoreSubdistrict = false;
        setProvinceName();
        cityNameInput.value = '';
        await loadCities(provinceSelect.value);
    });

    citySelect.addEventListener('change', async () => {
        shouldRestoreDistrict = false;
        shouldRestoreSubdistrict = false;
        setCityName();
        await loadDistricts(citySelect.value);
    });

    districtInput.addEventListener('input', () => {
        shouldRestoreSubdistrict = false;
        districtIdInput.value = '';
        subdistrictInput.value = '';
        subdistrictIdInput.value = '';
        subdistrictList.innerHTML = '';
    });

    districtInput.addEventListener('change', syncDistrictSelection);
    districtInput.addEventListener('blur', syncDistrictSelection);

    subdistrictInput.addEventListener('input', () => {
        subdistrictIdInput.value = '';
    });

    subdistrictInput.addEventListener('change', syncSubdistrictSelection);
    subdistrictInput.addEventListener('blur', syncSubdistrictSelection);

    sameAsCustomerCheckbox.addEventListener('change', () => {
        if (sameAsCustomerCheckbox.checked) {
            recipientNameInput.value = customerNameInput.value;
        }
    });

    customerNameInput.addEventListener('input', () => {
        if (sameAsCustomerCheckbox.checked) {
            recipientNameInput.value = customerNameInput.value;
        }
    });

    const defaultLat = -6.2000000;
    const defaultLng = 106.8166667;

    const parseCoordinatesFromLink = (link) => {
        if (!link) {
            return null;
        }

        const match = link.match(/q=(-?\d+(?:\.\d+)?),(-?\d+(?:\.\d+)?)/i);

        if (!match) {
            return null;
        }

        return {
            latitude: Number.parseFloat(match[1]),
            longitude: Number.parseFloat(match[2]),
        };
    };

    const existingCoordinates = mapsLatitudeInput.value && mapsLongitudeInput.value
        ? {
            latitude: Number.parseFloat(mapsLatitudeInput.value),
            longitude: Number.parseFloat(mapsLongitudeInput.value),
        }
        : parseCoordinatesFromLink(mapsLinkInput.value);

    const currentLat = existingCoordinates?.latitude ?? defaultLat;
    const currentLng = existingCoordinates?.longitude ?? defaultLng;

    const map = L.map('map', {
        zoomControl: true,
        scrollWheelZoom: true,
    }).setView([currentLat, currentLng], existingCoordinates ? 16 : 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    let marker = null;

    const updateMapLink = (lat, lng) => {
        const roundedLat = Number(lat).toFixed(7);
        const roundedLng = Number(lng).toFixed(7);
        const link = `https://www.google.com/maps?q=${roundedLat},${roundedLng}`;

        mapsLatitudeInput.value = roundedLat;
        mapsLongitudeInput.value = roundedLng;
        mapsLinkInput.value = link;
    };

    const placeMarker = (lat, lng, zoom = null) => {
        const latLng = L.latLng(lat, lng);

        if (!marker) {
            marker = L.marker(latLng, { draggable: true }).addTo(map);

            marker.on('dragend', (event) => {
                const position = event.target.getLatLng();
                updateMapLink(position.lat, position.lng);
                locationFeedback.textContent = 'Titik lokasi diperbarui dari marker yang digeser.';
                locationFeedback.className = 'mt-2 text-xs text-green-600';
            });
        } else {
            marker.setLatLng(latLng);
        }

        if (zoom) {
            map.setView(latLng, zoom);
        }

        updateMapLink(lat, lng);
    };

    if (existingCoordinates) {
        placeMarker(currentLat, currentLng);
        locationFeedback.textContent = 'Titik lokasi sebelumnya berhasil dimuat ke peta.';
        locationFeedback.className = 'mt-2 text-xs text-green-600';
    }

    map.on('click', (event) => {
        placeMarker(event.latlng.lat, event.latlng.lng, 16);
        locationFeedback.textContent = 'Titik lokasi berhasil dipilih dari peta.';
        locationFeedback.className = 'mt-2 text-xs text-green-600';
    });

    setTimeout(() => {
        map.invalidateSize();
    }, 300);

    useCurrentLocationButton.addEventListener('click', () => {
        if (!navigator.geolocation) {
            locationFeedback.textContent = 'Browser ini tidak mendukung akses lokasi.';
            locationFeedback.className = 'mt-2 text-xs text-red-500';
            return;
        }

        locationFeedback.textContent = 'Mengambil lokasi terkini...';
        locationFeedback.className = 'mt-2 text-xs text-gray-500';

        navigator.geolocation.getCurrentPosition((position) => {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;
            placeMarker(latitude, longitude, 17);

            locationFeedback.textContent = 'Lokasi saat ini berhasil dipilih.';
            locationFeedback.className = 'mt-2 text-xs text-green-600';
        }, () => {
            locationFeedback.textContent = 'Lokasi tidak berhasil diambil. Tentukan titik di peta.';
            locationFeedback.className = 'mt-2 text-xs text-red-500';
        }, {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        });
    });

    loadProvinces().catch(() => {
        setSelectOptions(provinceSelect, [], 'Gagal memuat provinsi');
        setSelectOptions(provinceSelect, [], 'Gagal memuat provinsi');
        setSelectOptions(citySelect, [], 'Gagal memuat kabupaten / kota');
        districtInput.placeholder = 'Gagal memuat data kecamatan';
        subdistrictInput.placeholder = 'Gagal memuat data kelurahan';
        locationFeedback.textContent = 'API wilayah gagal dimuat. Anda masih bisa melanjutkan dengan mengisi manual jika field tersedia.';
    });

    const checkoutForm = document.getElementById('checkout-form');
    checkoutForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const submitBtn = document.querySelector('button[form="checkout-form"]');
        const originalText = submitBtn.innerText;
        
        // Disable button
        submitBtn.disabled = true;
        submitBtn.innerText = 'Memproses Pesanan...';

        const formData = new FormData(checkoutForm);

        try {
            const response = await fetch(checkoutForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();

            if (!response.ok) {
                if (response.status === 422) {
                    const errors = Object.values(data.errors).flat().join('\n');
                    throw new Error(errors);
                }
                throw new Error(data.message || 'Terjadi kesalahan saat memproses pesanan.');
            }

            if (data.success) {
                // 1. Buka WhatsApp
                window.open(data.whatsapp_url, '_blank');

                // 2. Redirect ke halaman detail
                window.location.href = data.redirect_url;
            }
        } catch (error) {
            submitBtn.disabled = false;
            submitBtn.innerText = originalText;

            Swal.fire({
                title: 'Data Belum Lengkap',
                text: error.message,
                icon: 'warning',
                confirmButtonColor: '#ec4899'
            });
        }
    });
});
</script>
@endpush
