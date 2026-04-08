@extends('layouts.main')

@section('container')
<div class="relative min-h-screen bg-white">
    <!-- Hero Section -->
    <div class="relative h-[400px] md:h-[500px] overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('img/backgrounds/about-hero.png') }}')">
            <div class="absolute inset-0 bg-linear-to-r from-black/60 to-black/20"></div>
        </div>
        <div class="relative h-full flex items-center max-w-screen-2xl mx-auto px-6 md:px-20">
            <div class="max-w-2xl text-white">
                <h1 class="text-3xl md:text-6xl font-bold mb-4 md:mb-6 animate-fade-in-up">Menciptakan Kenangan Melalui Souvenir Terbaik</h1>
                <p class="text-base md:text-xl text-gray-200 mb-6 md:mb-8 leading-relaxed">Souvenir Oke Boss hadir untuk memastikan setiap momen berharga Anda memiliki kenang-kenangan yang berkesan, elegan, dan fungsional.</p>
                <div class="flex gap-4">
                    <a href="#kisah-kami" class="px-6 py-3 md:px-8 md:py-4 bg-pink-oke-boss text-white rounded-full font-semibold hover:bg-pink-oke-boss/90 transition shadow-lg text-sm md:text-base">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Kisah Kami -->
    <section id="kisah-kami" class="py-12 md:py-24 max-w-screen-2xl mx-auto px-6 md:px-20">
        <div class="grid md:grid-cols-2 gap-8 md:gap-16 items-center">
            <div class="relative mb-8 md:mb-0">
                <div class="absolute -top-4 -left-4 w-24 h-24 bg-pink-oke-boss/10 rounded-full blur-2xl"></div>
                <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1513151233558-d860c5398176?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80" alt="Souvenir Gallery" class="w-full">
                </div>
                <div class="absolute -bottom-8 -right-8 w-48 h-48 bg-pink-oke-boss/20 rounded-full blur-3xl"></div>
            </div>
            <div>
                <span class="text-pink-oke-boss font-bold tracking-widest uppercase mb-2 md:mb-4 block text-sm md:text-base">Siapa Kami?</span>
                <h2 class="text-2xl md:text-4xl font-bold mb-4 md:mb-8 text-gray-900 leading-tight">Membangun Kepercayaan Sejak Awal Melalui Kualitas</h2>
                <div class="space-y-4 md:space-y-6 text-base md:text-lg text-gray-600 leading-relaxed">
                    <p>
                        <span class="font-bold text-pink-oke-boss">Souvenir Oke Boss</span> bukan sekadar toko souvenir. Kami adalah mitra terpercaya yang memahami betapa pentingnya setiap detail dalam acara spesial Anda. Baik itu pernikahan yang khidmat, ulang tahun yang meriah, hingga seminar perusahaan yang profesional.
                    </p>
                    <p>
                        Kami lahir dari visi untuk menyederhanakan proses pencarian hadiah yang bermakna. Dengan kurasi produk yang ketat—mulai dari peralatan makan estetik hingga perlengkapan rumah premium—kami memastikan setiap barang yang Anda pesan memiliki nilai keindahan dan fungsionalitas yang tinggi.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stat/Highlight -->
    <section class="bg-gray-50 py-12 md:py-20 border-y border-gray-100">
        <div class="max-w-screen-2xl mx-auto px-6 md:px-20 grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8 text-center">
            <div>
                <div class="text-2xl md:text-4xl font-bold text-pink-oke-boss mb-1 md:mb-2">1000+</div>
                <div class="text-[10px] md:text-sm text-gray-500 font-medium tracking-tight uppercase">Acara</div>
            </div>
            <div>
                <div class="text-2xl md:text-4xl font-bold text-pink-oke-boss mb-1 md:mb-2">500+</div>
                <div class="text-[10px] md:text-sm text-gray-500 font-medium tracking-tight uppercase">Produk</div>
            </div>
            <div>
                <div class="text-2xl md:text-4xl font-bold text-pink-oke-boss mb-1 md:mb-2">100%</div>
                <div class="text-[10px] md:text-sm text-gray-500 font-medium tracking-tight uppercase">Kualitas</div>
            </div>
            <div>
                <div class="text-2xl md:text-4xl font-bold text-pink-oke-boss mb-1 md:mb-2">24/7</div>
                <div class="text-[10px] md:text-sm text-gray-500 font-medium tracking-tight uppercase">Layanan</div>
            </div>
        </div>
    </section>

    <!-- Visi & Misi -->
    <section class="py-12 md:py-24 bg-white relative overflow-hidden">
        <div class="max-w-screen-2xl mx-auto px-6 md:px-20">
            <div class="text-center mb-10 md:mb-16">
                <h2 class="text-2xl md:text-4xl font-bold mb-3 md:mb-4">Misi Menuju Kesempurnaan</h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-sm md:text-base">Kami berdedikasi untuk memberikan yang terbaik bagi setiap pelanggan kami melalui standar kualitas yang tak tertandingi.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-6 md:gap-8">
                <div class="group p-6 md:p-10 bg-white rounded-3xl border border-gray-100 hover:border-pink-oke-boss/30 hover:shadow-2xl hover:shadow-pink-oke-boss/10 transition duration-500">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-pink-100 rounded-2xl flex items-center justify-center mb-6 md:mb-8 group-hover:scale-110 transition duration-500">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold mb-3 md:mb-4 text-gray-900">Visi Kami</h3>
                    <p class="text-gray-600 text-base md:text-lg leading-relaxed">Menjadi pusat penyedia souvenir terlengkap dan terpercaya di Indonesia yang memberikan nilai tambah bagi setiap momen spesial pelanggan melalui kualitas produk dan layanan yang unggul.</p>
                </div>

                <div class="group p-6 md:p-10 bg-white rounded-3xl border border-gray-100 hover:border-pink-oke-boss/30 hover:shadow-2xl hover:shadow-pink-oke-boss/10 transition duration-500">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-6 md:mb-8 group-hover:scale-110 transition duration-500">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold mb-3 md:mb-4 text-gray-900">Misi Kami</h3>
                    <ul class="space-y-3 md:space-y-4">
                        <li class="flex items-start gap-3">
                            <span class="mt-1.5 w-1.5 h-1.5 bg-green-500 rounded-full shrink-0"></span>
                            <span class="text-gray-600 text-base md:text-lg">Menghadirkan produk berkualitas dengan bahan premium yang awet.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1.5 w-1.5 h-1.5 bg-green-500 rounded-full shrink-0"></span>
                            <span class="text-gray-600 text-base md:text-lg">Memberikan layanan konsultasi produk yang responsif dan solutif.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1.5 w-1.5 h-1.5 bg-green-500 rounded-full shrink-0"></span>
                            <span class="text-gray-600 text-base md:text-lg">Menjamin ketepatan waktu dalam pengerjaan dan keamanan pengiriman.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-12 md:py-24 bg-gray-50 overflow-hidden">
        <div class="max-w-screen-2xl mx-auto px-6 md:px-20 relative">
            <div class="text-center mb-10 md:mb-16">
                <h2 class="text-2xl md:text-4xl font-bold mb-3 md:mb-4">Keunggulan Oke Boss</h2>
                <p class="text-gray-500 text-sm md:text-base">Alasan mengapa ribuan pelanggan mempercayakan momen mereka pada kami.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6 md:gap-8">
                <!-- Card 1 -->
                <div class="bg-white p-8 md:p-10 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 border border-transparent hover:border-pink-oke-boss/20 group text-center md:text-left">
                    <div class="text-3xl md:text-4xl mb-4 md:mb-6">📦</div>
                    <h4 class="text-lg md:text-xl font-bold mb-2 md:mb-3">Koleksi Lengkap</h4>
                    <p class="text-gray-500 text-sm md:text-base leading-relaxed">Mulai dari peralatan makan minimalis hingga tas premium yang dapat dipersonalisasi sesuai kebutuhan Anda.</p>
                </div>
                <!-- Card 2 -->
                <div class="bg-white p-8 md:p-10 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 border border-transparent hover:border-pink-oke-boss/20 group text-center md:text-left">
                    <div class="text-3xl md:text-4xl mb-4 md:mb-6">💰</div>
                    <h4 class="text-lg md:text-xl font-bold mb-2 md:mb-3">Harga Kompetitif</h4>
                    <p class="text-gray-500 text-sm md:text-base leading-relaxed">Dapatkan kualitas ekspor dengan harga yang tetap terjangkau untuk pesanan skala besar maupun kecil.</p>
                </div>
                <!-- Card 3 -->
                <div class="bg-white p-8 md:p-10 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 border border-transparent hover:border-pink-oke-boss/20 group text-center md:text-left">
                    <div class="text-3xl md:text-4xl mb-4 md:mb-6">🚚</div>
                    <h4 class="text-lg md:text-xl font-bold mb-2 md:mb-3">Pengiriman Aman</h4>
                    <p class="text-gray-500 text-sm md:text-base leading-relaxed">Garansi pengiriman ke seluruh Indonesia dengan sistem pengemasan standar tinggi yang aman dari benturan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-12 md:py-24 max-w-screen-2xl mx-auto px-6 md:px-20">
        <div class="relative rounded-3xl md:rounded-4xl overflow-hidden bg-pink-oke-boss p-8 md:p-20 text-center text-white">
            <div class="absolute inset-0 bg-linear-to-br from-pink-oke-boss to-purple-800 opacity-90"></div>
            <div class="relative z-10 max-w-3xl mx-auto">
                <h2 class="text-2xl md:text-5xl font-bold mb-4 md:mb-6 leading-tight">Mari Wujudkan Momen Impian Anda Bersama Kami</h2>
                <p class="text-base md:text-xl text-pink-100 mb-8 md:mb-10 leading-relaxed text-balance">Konsultasikan kebutuhan souvenir acara Anda sekarang juga secara gratis dengan tim ahli kami.</p>
                <a href="https://wa.me/6285780007175?text=Halo%20Admin%20Souvenir%20Oke%20Boss%2C%20saya%20ingin%20bertanya%20seputar%20produk." target="_blank" class="inline-flex items-center gap-2 px-6 py-4 md:px-10 md:py-5 bg-white text-pink-oke-boss rounded-full font-bold text-base md:text-lg hover:shadow-2xl hover:scale-105 transition-all duration-300 group">
                    Hubungi Kami Sekarang
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </section>
</div>

<style>
    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fade-in-up {
        animation: fade-in-up 0.8s ease-out forwards;
    }
</style>
@endsection
