@extends('layouts.main')

@section('container')
<section class="bg-[linear-gradient(180deg,#fff8fb_0%,#ffffff_24%)] py-10 md:py-14">
    <div class="mx-auto max-w-6xl px-4">
        <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <span class="inline-flex rounded-full bg-pink-50 px-4 py-2 text-xs font-bold uppercase tracking-[0.3em] text-pink-600">Profil Pembeli</span>
                <h1 class="mt-4 text-3xl font-black text-gray-900">Profil Saya</h1>
                <p class="mt-2 max-w-2xl text-sm leading-7 text-gray-600">Simpan nama, nomor telepon, alamat, dan titik maps agar checkout berikutnya terisi otomatis.</p>
            </div>
            <a href="{{ route('user.orders.index') }}" class="inline-flex items-center rounded-2xl border border-pink-200 px-4 py-3 text-sm font-bold text-pink-600 transition hover:bg-pink-50">
                Lihat Pesanan Saya
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-3xl border border-green-100 bg-green-50 px-5 py-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-3xl border border-red-100 bg-red-50 px-5 py-4 text-sm text-red-700">
                <p class="font-semibold">Profil belum berhasil disimpan.</p>
                <ul class="mt-2 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.profile.update') }}" method="POST" class="grid gap-8 lg:grid-cols-[1.05fr_0.95fr]">
            @csrf
            @method('PATCH')

            <div class="space-y-8">
                <div class="rounded-[2rem] border border-gray-100 bg-white p-6 shadow-sm md:p-8">
                    <h2 class="text-xl font-black text-gray-900">Informasi Utama</h2>
                    <p class="mt-2 text-sm text-gray-500">Data ini akan dipakai sebagai identitas utama saat checkout.</p>

                    <div class="mt-6 grid gap-5">
                        <div>
                            <label for="name" class="mb-2 block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" required>
                        </div>
                        <div>
                            <label for="phone" class="mb-2 block text-sm font-semibold text-gray-700">Nomor Telepon</label>
                            <input id="phone" name="phone" type="text" inputmode="tel" value="{{ old('phone', $user->phone) }}" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" placeholder="Contoh: 081234567890" required>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">Email</label>
                            <div class="rounded-2xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm text-gray-600">{{ $user->email }}</div>
                        </div>
                    </div>
                </div>

                <div class="rounded-[2rem] border border-gray-100 bg-white p-6 shadow-sm md:p-8">
                    <h2 class="text-xl font-black text-gray-900">Alamat Default</h2>
                    <p class="mt-2 text-sm text-gray-500">Alamat ini akan otomatis muncul saat Anda membuat pesanan berikutnya.</p>

                    <div class="mt-6 space-y-5">
                        <div>
                            <label for="address_line" class="mb-2 block text-sm font-semibold text-gray-700">Alamat Lengkap</label>
                            <textarea id="address_line" name="address_line" rows="4" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" placeholder="Nama jalan, nomor rumah, patokan, dan detail alamat lainnya" required>{{ old('address_line', $user->address_line) }}</textarea>
                        </div>

                        <div class="grid gap-5 md:grid-cols-2">
                            <div>
                                <label for="province_id" class="mb-2 block text-sm font-semibold text-gray-700">Provinsi</label>
                                <select id="province_id" name="province_id" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" required></select>
                                <input type="hidden" id="province_name" name="province_name" value="{{ old('province_name', $user->province_name) }}">
                            </div>
                            <div>
                                <label for="city_id" class="mb-2 block text-sm font-semibold text-gray-700">Kabupaten / Kota</label>
                                <select id="city_id" name="city_id" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" required disabled></select>
                                <input type="hidden" id="city_name" name="city_name" value="{{ old('city_name', $user->city_name) }}">
                            </div>
                        </div>

                        <div class="grid gap-5 md:grid-cols-2">
                            <div>
                                <label for="district_name" class="mb-2 block text-sm font-semibold text-gray-700">Kecamatan</label>
                                <input id="district_name" name="district_name" type="text" list="district-suggestions" value="{{ old('district_name', $user->district_name) }}" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" autocomplete="off" required>
                                <datalist id="district-suggestions"></datalist>
                                <input type="hidden" id="district_id" name="district_id" value="{{ old('district_id', $user->district_id) }}">
                            </div>
                            <div>
                                <label for="subdistrict_name" class="mb-2 block text-sm font-semibold text-gray-700">Kelurahan / Desa</label>
                                <input id="subdistrict_name" name="subdistrict_name" type="text" list="subdistrict-suggestions" value="{{ old('subdistrict_name', $user->subdistrict_name) }}" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" autocomplete="off" required>
                                <datalist id="subdistrict-suggestions"></datalist>
                                <input type="hidden" id="subdistrict_id" name="subdistrict_id" value="{{ old('subdistrict_id', $user->subdistrict_id) }}">
                            </div>
                        </div>

                        <div class="grid gap-5 md:grid-cols-2">
                            <div>
                                <label for="rt" class="mb-2 block text-sm font-semibold text-gray-700">RT</label>
                                <input id="rt" name="rt" type="text" value="{{ old('rt', $user->rt) }}" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" required>
                            </div>
                            <div>
                                <label for="rw" class="mb-2 block text-sm font-semibold text-gray-700">RW</label>
                                <input id="rw" name="rw" type="text" value="{{ old('rw', $user->rw) }}" class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <aside class="space-y-8">
                <div class="rounded-[2rem] border border-pink-100 bg-[#fff7fb] p-6 shadow-sm">
                    <h2 class="text-xl font-black text-gray-900">Titik Maps</h2>
                    <p class="mt-2 text-sm leading-7 text-gray-600">Simpan titik lokasi pengiriman agar admin menerima data pengiriman yang lebih lengkap.</p>

                    <div class="mt-5 overflow-hidden rounded-3xl border border-pink-100 bg-white">
                        <div class="border-b border-pink-100 bg-pink-50 px-4 py-3">
                            <p class="text-sm font-semibold text-gray-800">Klik peta untuk menentukan lokasi</p>
                            <p class="text-xs text-gray-500">Anda juga bisa memakai lokasi perangkat saat ini.</p>
                        </div>
                        <div id="map" class="z-0 w-full"></div>
                        <input id="maps_link" name="maps_link" type="hidden" value="{{ old('maps_link', $user->maps_link) }}">
                        <input id="maps_latitude" name="maps_latitude" type="hidden" value="{{ old('maps_latitude', $user->maps_latitude) }}">
                        <input id="maps_longitude" name="maps_longitude" type="hidden" value="{{ old('maps_longitude', $user->maps_longitude) }}">
                    </div>

                    <button id="use-current-location" type="button" class="mt-4 inline-flex items-center rounded-2xl border border-pink-200 px-4 py-3 text-sm font-bold text-pink-600 transition hover:bg-pink-50">
                        Gunakan lokasi saya sekarang
                    </button>
                    <p id="location-feedback" class="mt-3 text-xs text-gray-500">Titik belum dipilih. Klik pada peta atau gunakan lokasi Anda saat ini.</p>
                </div>

                <div class="rounded-[2rem] border border-gray-100 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-black text-gray-900">Simpan Perubahan</h2>
                    <p class="mt-3 text-sm leading-7 text-gray-600">Setelah disimpan, checkout selanjutnya akan langsung menampilkan nama, telepon, alamat, dan titik maps ini.</p>
                    <button type="submit" class="mt-6 w-full rounded-2xl bg-pink-oke-boss px-5 py-3 text-sm font-bold text-white transition hover:bg-pink-oke-boss/90">
                        Simpan Profil
                    </button>
                </div>
            </aside>
        </form>
    </div>
</section>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    #map {
        height: 380px;
        cursor: crosshair;
    }

    .leaflet-container {
        font-family: inherit;
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
    const useCurrentLocationButton = document.getElementById('use-current-location');
    const mapsLinkInput = document.getElementById('maps_link');
    const mapsLatitudeInput = document.getElementById('maps_latitude');
    const mapsLongitudeInput = document.getElementById('maps_longitude');
    const locationFeedback = document.getElementById('location-feedback');

    const oldProvinceId = @json(old('province_id', $user->province_id));
    const oldCityId = @json(old('city_id', $user->city_id));
    const oldSubdistrictId = @json(old('subdistrict_id', $user->subdistrict_id));
    const oldDistrictName = @json(old('district_name', $user->district_name));
    const oldSubdistrictName = @json(old('subdistrict_name', $user->subdistrict_name));

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
                locationFeedback.className = 'mt-3 text-xs text-green-600';
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
        locationFeedback.className = 'mt-3 text-xs text-green-600';
    }

    map.on('click', (event) => {
        placeMarker(event.latlng.lat, event.latlng.lng, 16);
        locationFeedback.textContent = 'Titik lokasi berhasil dipilih dari peta.';
        locationFeedback.className = 'mt-3 text-xs text-green-600';
    });

    setTimeout(() => {
        map.invalidateSize();
    }, 300);

    useCurrentLocationButton.addEventListener('click', () => {
        if (!navigator.geolocation) {
            locationFeedback.textContent = 'Browser ini tidak mendukung akses lokasi.';
            locationFeedback.className = 'mt-3 text-xs text-red-500';
            return;
        }

        locationFeedback.textContent = 'Mengambil lokasi terkini...';
        locationFeedback.className = 'mt-3 text-xs text-gray-500';

        navigator.geolocation.getCurrentPosition((position) => {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;
            placeMarker(latitude, longitude, 17);

            locationFeedback.textContent = 'Lokasi saat ini berhasil dipilih.';
            locationFeedback.className = 'mt-3 text-xs text-green-600';
        }, () => {
            locationFeedback.textContent = 'Lokasi tidak berhasil diambil. Tentukan titik di peta.';
            locationFeedback.className = 'mt-3 text-xs text-red-500';
        }, {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        });
    });

    loadProvinces().catch(() => {
        setSelectOptions(provinceSelect, [], 'Gagal memuat provinsi');
        setSelectOptions(citySelect, [], 'Gagal memuat kabupaten / kota');
        districtInput.placeholder = 'Gagal memuat data kecamatan';
        subdistrictInput.placeholder = 'Gagal memuat data kelurahan';
        locationFeedback.textContent = 'API wilayah gagal dimuat. Anda masih bisa melanjutkan dengan mengisi manual jika field tersedia.';
    });
});
</script>
@endpush
