@extends('layouts.main')

@section('container')
<div class="min-h-[80vh] bg-[#fffaf5] py-12 px-4">
    <div class="mx-auto grid max-w-5xl overflow-hidden rounded-[2rem] border border-orange-100 bg-white shadow-[0_30px_80px_rgba(251,146,60,0.12)] lg:grid-cols-[0.9fr_1.1fr]">
        <div class="bg-[radial-gradient(circle_at_bottom_right,_rgba(251,146,60,0.18),_transparent_34%),linear-gradient(160deg,_#fffaf5,_#ffffff_55%,_#fff1e6)] p-8 md:p-12">
            <span class="inline-flex rounded-full bg-white px-4 py-2 text-xs font-bold uppercase tracking-[0.3em] text-orange-500 shadow-sm">Daftar Akun</span>
            <h1 class="mt-6 text-3xl font-black leading-tight text-gray-900 md:text-4xl">Buat akun user untuk cek pesanan kapan saja.</h1>
            <p class="mt-4 text-sm leading-7 text-gray-600 md:text-base">
                Akun ini dipakai untuk login pelanggan. Setelah checkout, pesanan otomatis masuk ke halaman tracking akunmu.
            </p>
        </div>

        <div class="p-8 md:p-12">
            <h2 class="text-2xl font-black text-gray-900">Registrasi User</h2>
            <p class="mt-2 text-sm text-gray-500">Isi data berikut untuk membuat akun pelanggan baru.</p>

            <form action="{{ route('register.store') }}" method="POST" class="mt-8 grid gap-5">
                @csrf
                <div>
                    <label for="name" class="mb-2 block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-orange-400 focus:outline-none" placeholder="Nama lengkap">
                    @error('name')
                        <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold text-gray-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-orange-400 focus:outline-none" placeholder="nama@email.com">
                    @error('email')
                        <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-orange-400 focus:outline-none" placeholder="Minimal 8 karakter">
                    @error('password')
                        <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-gray-700">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:border-orange-400 focus:outline-none" placeholder="Ulangi password">
                </div>

                <button type="submit" class="mt-2 w-full rounded-2xl bg-orange-500 px-4 py-3 text-sm font-bold text-white transition hover:bg-orange-600">
                    Buat Akun
                </button>
            </form>

            <div class="mt-6 rounded-2xl bg-gray-50 px-4 py-4 text-sm text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-bold text-pink-600 hover:text-pink-500">Login di sini</a>
            </div>
        </div>
    </div>
</div>
@endsection
