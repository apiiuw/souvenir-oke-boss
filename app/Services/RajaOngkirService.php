<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class RajaOngkirService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.rajaongkir.com/starter'; // Using starter as requested usually

    public function __construct()
    {
        $this->apiKey = config('services.rajaongkir.key');
        $this->baseUrl = config('services.rajaongkir.base_url');
    }


    public function getProvinces()
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get($this->baseUrl . '/destination/province');

        if ($response->failed()) {
            Log::error('Komerce Provinces Error: ' . $response->body());
            return [];
        }

        return $response->json()['data'] ?? [];
    }

    public function getCities($provinceId = null)
    {
        if (!$provinceId) return [];
        
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get($this->baseUrl . '/destination/city/' . $provinceId);

        if ($response->failed()) {
            Log::error('Komerce Cities Error: ' . $response->body());
            return [];
        }

        return $response->json()['data'] ?? [];
    }

    public function getDistricts($cityId)
    {
        if (!$cityId) return [];

        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get($this->baseUrl . '/destination/district/' . $cityId);

        if ($response->failed()) {
            Log::error('Komerce Districts Error: ' . $response->body());
            return [];
        }

        return $response->json()['data'] ?? [];
    }

    public function getSubDistricts($districtId)
    {
        if (!$districtId) return [];

        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get($this->baseUrl . '/destination/sub-district/' . $districtId);

        if ($response->failed()) {
            Log::error('Komerce Sub-Districts Error: ' . $response->body());
            return [];
        }

        return $response->json()['data'] ?? [];
    }

    public function getCost($origin, $destination, $weight, $courier)
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->asForm()->post($this->baseUrl . '/calculate/domestic-cost', [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier
        ]);

        if ($response->failed()) {
            Log::error('Komerce Cost Error: ' . $response->body());
            return [];
        }

        return $response->json()['data'] ?? [];
    }
}

