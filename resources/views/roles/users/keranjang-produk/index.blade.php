@extends('layouts.main')

@section('container')

<div class="max-w-5xl min-h-screen mx-auto py-10 px-8 md:px-20">

    <h1 class="text-2xl font-bold mb-6">Keranjang</h1>

    @forelse ($cart->items as $item)
        <div class="flex items-center gap-4 border-b py-4">

            <img src="{{ asset('storage/' . $item->product->images->first()->image) }}"
                 class="w-20 h-20 object-cover rounded">

            <div class="flex-1">
                <h3 class="font-semibold">{{ $item->product->name }}</h3>
                <p class="text-sm text-gray-500">
                    Rp {{ number_format($item->product->price,0,',','.') }}
                </p>
                <p class="text-sm text-gray-500">
                    Warna: {{ $item->variant->name ?? '-' }}
                </p>
            </div>

            <div>
                x{{ $item->qty }}
            </div>

            <div class="font-bold text-pink-oke-boss">
                Rp {{ number_format($item->product->price * $item->qty,0,',','.') }}
            </div>

        </div>
    @empty
        <p class="text-center text-gray-500">Keranjang kosong</p>
    @endforelse

</div>

@endsection
