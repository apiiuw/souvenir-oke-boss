@extends('layouts.main')

@section('container')
<div class="min-h-[80vh] bg-[#fff8fb] py-12 px-4">
    <div class="mx-auto grid max-w-5xl overflow-hidden rounded-[2rem] border border-pink-100 bg-white shadow-[0_30px_80px_rgba(236,72,153,0.12)] lg:grid-cols-[1.15fr_0.85fr]">
        <div class="bg-[radial-gradient(circle_at_top_left,_rgba(236,72,153,0.24),_transparent_38%),linear-gradient(135deg,_#fff1f7,_#ffffff_58%,_#ffe4ef)] p-8 md:p-12">
            <span class="inline-flex rounded-full bg-white px-4 py-2 text-xs font-bold uppercase tracking-[0.3em] text-pink-600 shadow-sm">Akun Pelanggan</span>
            <h1 class="mt-6 max-w-md text-3xl font-black leading-tight text-gray-900 md:text-4xl">Masuk untuk pantau pesanan dan progres pengiriman.</h1>
            <p class="mt-4 max-w-xl text-sm leading-7 text-gray-600 md:text-base">
                Setelah login, user bisa melihat daftar pesanan, status terbaru, dan detail alamat pengiriman dalam satu halaman akun.
            </p>

            <div class="mt-8 grid gap-4 sm:grid-cols-2">
                <div class="rounded-3xl border border-white/80 bg-white/80 p-5 backdrop-blur">
                    <p class="text-sm font-bold text-gray-900">Status real-time</p>
                    <p class="mt-2 text-sm text-gray-600">Lihat pesanan sedang menunggu, diproses, dikirim, atau sudah selesai.</p>
                </div>
                <div class="rounded-3xl border border-white/80 bg-white/80 p-5 backdrop-blur">
                    <p class="text-sm font-bold text-gray-900">Riwayat tersimpan</p>
                    <p class="mt-2 text-sm text-gray-600">Semua order yang dibuat saat login akan otomatis masuk ke akun user.</p>
                </div>
            </div>
        </div>

        <div class="p-8 md:p-12">
            <div class="max-w-md">
                <h2 class="text-2xl font-black text-gray-900">Login User</h2>
                <p class="mt-2 text-sm text-gray-500">Masukkan email dan password akun pelangganmu.</p>

                @if(session('success'))
                    <div class="mt-6 rounded-2xl border border-green-100 bg-green-50 px-4 py-3 text-sm text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('login.authenticate') }}" method="POST" class="mt-8 space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-gray-700">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" placeholder="nama@email.com">
                        @error('email')
                            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-gray-700">Password</label>
                        <input id="password" name="password" type="password" required class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-pink-oke-boss focus:outline-none" placeholder="Minimal 8 karakter">
                    </div>

                    <label class="flex items-center gap-3 text-sm text-gray-600">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-pink-oke-boss focus:ring-pink-oke-boss">
                        Ingat saya di perangkat ini
                    </label>

                    <button type="submit" class="w-full rounded-2xl bg-pink-oke-boss px-4 py-3 text-sm font-bold text-white transition hover:bg-pink-600">
                        Masuk ke Akun
                    </button>
                </form>

                <div class="mt-6 rounded-2xl bg-gray-50 px-4 py-4 text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-bold text-pink-600 hover:text-pink-500">Daftar di sini</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
