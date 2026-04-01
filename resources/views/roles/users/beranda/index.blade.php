@extends('layouts.main')
@section('container')


<div class="min-h-screen">
    <div id="default-carousel" class="relative w-full h-64 md:h-96" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative h-full overflow-hidden z-0">
            <!-- Item 1 -->
            <div class="duration-700 ease-in-out absolute inset-0 transition-transform transform translate-x-0 z-0" data-carousel-item="active">
                <img src="https://cdn.pixabay.com/photo/2015/06/23/19/31/keychain-819037_1280.jpg" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Slide 1">
            </div>
            <!-- Item 2 -->
            <div class="hidden duration-700 ease-in-out absolute inset-0 transition-transform transform translate-x-full z-0" data-carousel-item>
                <img src="https://cdn.pixabay.com/photo/2020/03/26/04/02/asia-4969162_1280.jpg" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Slide 2">
            </div>
            <!-- Item 3 -->
            <div class="hidden duration-700 ease-in-out absolute inset-0 transition-transform transform translate-x-full z-0" data-carousel-item>
                <img src="https://cdn.pixabay.com/photo/2023/11/19/00/30/paris-8397488_1280.jpg" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Slide 3">
            </div>
            <!-- Item 4 -->
            <div class="hidden duration-700 ease-in-out absolute inset-0 transition-transform transform translate-x-full z-0" data-carousel-item>
                <img src="https://cdn.pixabay.com/photo/2016/02/24/05/16/art-1219118_1280.jpg" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Slide 4">
            </div>
            <!-- Item 5 -->
            <div class="hidden duration-700 ease-in-out absolute inset-0 transition-transform transform translate-x-full z-0" data-carousel-item>
                <img src="https://cdn.pixabay.com/photo/2017/10/04/19/27/mancis-2817318_1280.jpg" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Slide 5">
            </div>
        </div>

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/30 z-10"></div>

        <!-- Slogan -->
        <div class="absolute inset-0 flex items-center justify-center z-20 pointer-events-none">
            <div class="text-center text-white">
                <h1 class="text-2xl md:text-5xl font-bold mb-1 text-pink-oke-boss-light">Kenang-kenangan Terbaik</h1>
                <p class="text-sm md:text-xl">
                    <span class="block md:inline">Ciptakan momen istimewa dengan</span>
                    <span class="block md:inline">souvenir pilihan kami</span>
                </p>
            </div>
        </div>

        <!-- Slider indicators -->
        <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
            <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4" data-carousel-slide-to="3"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5" data-carousel-slide-to="4"></button>
        </div>
        <!-- Slider controls -->
        <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-pink-oke-boss/30 group-hover:bg-pink-oke-boss/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                <svg class="w-5 h-5 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7"/></svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-pink-oke-boss/30 group-hover:bg-pink-oke-boss/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                <svg class="w-5 h-5 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>
</div>


@push('scripts')

@endpush

@endsection
