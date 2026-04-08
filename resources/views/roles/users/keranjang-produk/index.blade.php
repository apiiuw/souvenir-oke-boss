@extends('layouts.main')

@section('container')

<div class="max-w-5xl min-h-screen mx-auto py-10 px-8 md:px-20">

    <div class="flex items-center gap-4 mb-6">
        <a href="javascript:history.back()" class="p-2 border rounded-full hover:bg-gray-100 text-gray-700 bg-white" title="Kembali">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h1 class="text-2xl font-bold">Keranjang</h1>
    </div>

    @forelse ($cart->items as $item)
        <div class="flex flex-wrap md:flex-nowrap items-center gap-4 border-b py-4">

            <img src="{{ asset('storage/' . $item->product->images->first()->image) }}"
                 class="w-20 h-20 object-cover rounded">

            <div class="flex-1">
                <h3 class="font-semibold">{{ $item->product->name }}</h3>
                <p class="text-sm text-gray-500">
                    Rp {{ number_format($item->product->price,0,',','.') }}
                </p>
                <p class="text-sm text-gray-500">
                    Variasi: {{ $item->variant->name ?? '-' }} | Warna: {{ $item->color->name ?? '-' }}
                </p>
            </div>

            <div class="flex items-center gap-2 border rounded-md p-1">
                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="m-0">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="action" value="decrease">
                    <button type="submit" class="w-6 h-6 flex justify-center items-center rounded-sm bg-gray-100 hover:bg-gray-200 transition-all ease-in-out duration-300 cursor-pointer" title="Kurangi">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                        </svg>
                    </button>
                </form>

                <span class="w-6 text-center text-sm font-semibold">{{ $item->qty }}</span>

                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="m-0">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="action" value="increase">
                    <button type="submit" class="w-6 h-6 flex justify-center items-center rounded-sm bg-gray-100 hover:bg-gray-200 transition-all ease-in-out duration-300 cursor-pointer" title="Tambah">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                </form>
            </div>

            <div class="w-24 md:w-32 text-right font-bold text-pink-oke-boss">
                Rp {{ number_format($item->product->price * $item->qty,0,',','.') }}
            </div>

            <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="m-0 ml-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded transition-all ease-in-out duration-300 cursor-pointer" title="Hapus">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </form>

        </div>
    @empty
        <div class="text-center py-20">
            <p class="text-gray-500 mb-4">Keranjang Anda kosong, belum ada produk yang ditambahkan.</p>
            <a href="{{ route('produk') }}" class="inline-block px-6 py-2 bg-pink-oke-boss text-white rounded font-bold hover:bg-opacity-90 transition">Mulai Belanja</a>
        </div>
    @endforelse

    @if($cart->items->count() > 0)
        @php
            $totalQty = 0;
            $totalPrice = 0;
            foreach($cart->items as $item) {
                $totalQty += $item->qty;
                $totalPrice += $item->product->price * $item->qty;
            }
        @endphp
        
        <div class="flex justify-between items-center py-6 mb-20 text-lg md:text-xl">
            <span class="font-bold text-gray-700">Total ({{ $totalQty }} Produk):</span>
            <span class="font-bold text-pink-oke-boss">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
        </div>

        <!-- Floating Checkout Box -->
        <div class="fixed bottom-12 md:bottom-[10%] left-4 right-4 md:left-1/2 md:-translate-x-1/2 md:w-[600px] md:right-auto bg-white rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.15)] border border-gray-100 z-50 p-4 md:p-5 flex justify-between items-center">
            <div>
                <p class="text-xs md:text-sm text-gray-500 mb-1">Total Pembayaran</p>
                <p class="font-bold text-lg md:text-xl text-pink-oke-boss leading-none">Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
            </div>
            <a href="{{ route('checkout.index') }}" class="px-5 py-3 md:px-8 md:py-3 bg-pink-oke-boss hover:bg-pink-oke-boss/80 text-white font-bold rounded-xl shadow-md hover:bg-opacity-90 transition inline-flex items-center gap-2">
                <span class="hidden md:inline">Checkout Sekarang</span>
                <span class="md:hidden">Checkout</span>
                ({{ $totalQty }})
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>
    @endif

</div>

@push('scripts')
@if(session('success_delete'))
<script>
    Swal.fire({
        title: 'Berhasil!',
        text: '{{ session('success_delete') }}',
        icon: 'success',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        iconColor: '#ec4899'
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        title: 'Oops!',
        text: '{{ session('error') }}',
        icon: 'error',
        confirmButtonColor: '#ec4899'
    });
</script>
@endif
@endpush

@endsection
