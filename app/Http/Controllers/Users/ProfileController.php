<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        abort_if($request->user()->isAdmin(), 403);

        return view('roles.users.profile.edit', [
            'title' => 'Profil Saya',
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        abort_if($request->user()->isAdmin(), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'address_line' => ['required', 'string'],
            'province_id' => ['nullable', 'string', 'max:50'],
            'province_name' => ['required', 'string', 'max:255'],
            'city_id' => ['nullable', 'string', 'max:50'],
            'city_name' => ['required', 'string', 'max:255'],
            'district_id' => ['nullable', 'string', 'max:50'],
            'district_name' => ['required', 'string', 'max:255'],
            'subdistrict_id' => ['nullable', 'string', 'max:50'],
            'subdistrict_name' => ['required', 'string', 'max:255'],
            'rt' => ['required', 'string', 'max:10'],
            'rw' => ['required', 'string', 'max:10'],
            'maps_link' => ['required', 'url'],
            'maps_latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'maps_longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ], [
            'maps_link.required' => 'Silakan pilih titik lokasi pada peta.',
            'maps_link.url' => 'Titik maps harus berupa link yang valid.',
        ]);

        $request->user()->update([
            'name' => $validated['name'],
            'phone' => preg_replace('/\D+/', '', $validated['phone']) ?: $validated['phone'],
            'address_line' => $validated['address_line'],
            'province_id' => $validated['province_id'] ?: null,
            'province_name' => $validated['province_name'],
            'city_id' => $validated['city_id'] ?: null,
            'city_name' => $validated['city_name'],
            'district_id' => $validated['district_id'] ?: null,
            'district_name' => $validated['district_name'],
            'subdistrict_id' => $validated['subdistrict_id'] ?: null,
            'subdistrict_name' => $validated['subdistrict_name'],
            'rt' => $validated['rt'],
            'rw' => $validated['rw'],
            'maps_link' => $validated['maps_link'] ?: null,
            'maps_latitude' => $validated['maps_latitude'] ?: null,
            'maps_longitude' => $validated['maps_longitude'] ?: null,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui. Data ini akan otomatis terisi saat checkout berikutnya.');
    }
}
