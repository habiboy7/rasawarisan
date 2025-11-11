<x-layouts.app :title="__('Home')">

    <!-- Hero Section -->
    <div class="text-center px-4">
        <h1
            class="mt-5 font-bricolage font-semibold text-4xl sm:text-6xl md:text-7xl lg:text-8xl xl:text-[116px] leading-[0.9] tracking-[-0.04em]">
            Menjaga Rasa,<br>Mengangkat Warisan.
        </h1>

        <!-- Decorative Images - Hidden on mobile, visible on large screens with absolute positioning -->
        <div class="hidden xl:block">
            <img src="{{ asset('images/gambar1.png') }}" alt="gambar1" class="absolute left-[162px] top-[330px]" />
            <img src="{{ asset('images/gambar2.png') }}" alt="gambar2" class="absolute left-[430px] top-[280px]" />
            <img src="{{ asset('images/gambar3.png') }}" alt="gambar3" class="absolute left-[730px] top-[300px]" />

            <!-- Hover Image and Label -->
            <div class="group">
                <img src="{{ asset('images/gambar4.png') }}" alt="gambar4"
                    class="absolute left-[1120px] top-[290px]" />
                <div
                    class="flex flex-col bg-[#FFCCB7] px-6 py-2 text-black rounded-tr-[8px] rounded-br-[8px] rounded-bl-[8px]
                           absolute left-[1280px] top-[380px] rotate-[-4.67deg]
                           opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <p class="text-lg font-semibold">Gudeg</p>
                    <p class="text-md">Yogyakarta</p>
                </div>
            </div>
        </div>

        <!-- Decorative Images Grid for smaller screens -->
        <div class="xl:hidden mt-8 grid grid-cols-2 gap-4 max-w-lg mx-auto">
            <img src="{{ asset('images/gambar1.png') }}" alt="gambar1" class="w-full rounded-lg" />
            <img src="{{ asset('images/gambar2.png') }}" alt="gambar2" class="w-full rounded-lg" />
            <img src="{{ asset('images/gambar3.png') }}" alt="gambar3" class="w-full rounded-lg" />
            <div class="relative">
                <img src="{{ asset('images/gambar4.png') }}" alt="gambar4" class="w-full rounded-lg" />
                <div class="absolute bottom-2 left-2 bg-[#FFCCB7] px-4 py-1 rounded-lg ">
                    <p class="text-sm font-semibold">Gudeg</p>
                    <p class="text-xs">Yogyakarta</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="mt-20 md:mt-32 lg:mt-50 mb-15 md:mb-25 lg:mb-40 flex flex-col justify-center items-center px-4">
        <div class="flex flex-col sm:flex-row w-full max-w-3xl bg-zinc-100 rounded-xl p-2 gap-2 sm:gap-0">
            <input name="search" type="text" required autofocus autocomplete="off" placeholder="Cari Lokasi..."
                class="w-full bg-transparent px-4 py-3 text-zinc-700 placeholder-zinc-400 focus:outline-none" />
            <button
                class="bg-orange-500 hover:bg-orange-600 font-medium px-10 py-3 rounded-lg transition-colors whitespace-nowrap">
                Cari
            </button>
        </div>

        <div class="mt-6 md:mt-10 flex flex-col sm:flex-row justify-center items-center gap-4 sm:gap-10">
            <flux:button variant="primary" icon="map-pin" class="py-4 md:py-6 text-lg md:text-xl w-full sm:w-auto">
                Lihat Map
            </flux:button>
            <flux:link color="orange" href="#" class="text-lg md:text-xl">
                Terdekat
            </flux:link>
        </div>
    </div>

    <!-- About Section -->
    <div class="flex flex-col items-center mb-20 md:mb-32 lg:mb-50 px-4">
        <div class="flex items-center w-full mb-10 md:mb-20">
            <div class="flex-grow h-px bg-zinc-300"></div>
            <span
                class="mx-4 md:mx-6 font-bricolage text-orange-500 text-2xl md:text-3xl lg:text-4xl whitespace-nowrap">Tentang
                Kami</span>
            <div class="flex-grow h-px bg-zinc-300"></div>
        </div>

        <div class="flex flex-col md:flex-row gap-4 md:gap-6 w-full max-w-7xl">
            <div class="flex-[2] overflow-hidden rounded-2xl h-64 md:h-96 lg:h-auto">
                <img src="{{ asset('images/gambar6.png') }}" alt="RasaWarisan" class="object-cover w-full h-full">
            </div>

            <div class="flex-[1] overflow-hidden rounded-2xl h-64 md:h-96 lg:h-auto">
                <img src="{{ asset('images/gambar7.png') }}" alt="RasaWarisan" class="object-cover w-full h-full">
            </div>
        </div>

        {{-- Stats --}}
        <div class="container mx-auto pt-16">
            <!-- Header Section -->
            <div class="grid md:grid-cols-2 gap-12 items-center mb-24">
                <!-- Left Side - Title -->
                <div>
                    <h1 class="text-6xl mb-2">
                        <span class="text-black dark:text-white">Apa Itu</span>
                    </h1>
                    <h2
                        class="text-7xl font-bricolage tracking-[-0.04em] bg-gradient-to-r from-orange-500 to-[#FFCEB8] bg-clip-text text-transparent">
                        RasaWarisan
                    </h2>
                </div>

                <!-- Right Side - Description -->
                <div>
                    <p class="text-black dark:text-white text-xl leading-relaxed mb-8">
                        RasaWarisan hadir untuk mengenalkan cita rasa khas Indonesia dan mendukung UMKM kuliner
                        lokal agar terus tumbuh, dikenal, dan dicintai.
                    </p>
                    <flux:link variant="primary" color="orange" href="#" class="text-xl">
                        Gabung Sekarang
                    </flux:link>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="grid md:grid-cols-3 gap-10">
                <!-- Pengguna Terdaftar -->
                <div class="text-center p-8">
                    <div
                        class="font-bricolage font-semibold text-6xl bg-gradient-to-r from-orange-500 to-[#FFCEB8] bg-clip-text text-transparent">
                        4000+
                    </div>
                    <div class=" text-lg font-medium">
                        Pengguna Terdaftar
                    </div>
                </div>

                <!-- Total Mitra -->
                <div class="text-center p-8 ">
                    <div
                        class="font-bricolage font-semibold text-6xl bg-gradient-to-r from-orange-500 to-[#FFCEB8] bg-clip-text text-transparent">
                        2500+
                    </div>
                    <div class="text-lg font-medium">
                        Total Mitra
                    </div>
                </div>

                <!-- Acara Terlaksana -->
                <div class="text-center p-8 ">
                    <div
                        class="font-bricolage font-semibold text-6xl bg-gradient-to-r from-orange-500 to-[#FFCEB8] bg-clip-text text-transparent">
                        100+
                    </div>
                    <div class="text-lg font-medium">
                        Acara Terlaksana
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Favorit Food Section -->
    <div class="mb-15 md:mb-25 lg:mb-40">
        @livewire('favorite-foods', ['favoriteFoods' => $favoriteFoods])
    </div>

    <!-- Favorit Restaurant Section -->
    <div class="mb-15 md:mb-25 lg:mb-40">
        @livewire('favorite-restaurant', ['favoriteRestaurant' => $favoriteRestaurant])
    </div>

    <!-- Features Section -->
    <div class="mb-15 md:mb-25 lg:mb-40">
        <div class="text-center mb-10">
            <div class="flex items-center w-full mb-5 md:mb-10">
                <div class="flex-grow h-px bg-zinc-300"></div>
                <span
                    class="mx-4 md:mx-6 font-bricolage text-orange-500 text-2xl md:text-3xl lg:text-4xl whitespace-nowrap">Fitur</span>
                <div class="flex-grow h-px bg-zinc-300"></div>
            </div>
            <h2
                class="text-7xl font-bricolage tracking-[-0.04em] bg-gradient-to-r from-orange-500 to-[#FFCEB8] bg-clip-text text-transparent mb-6">
                Jelajah, Kenali & Dukung</h2>
            <p class="text-black dark:text-white text-2xl max-w-4xl mx-auto leading-relaxed">
                Temukan lokasi kuliner khas, kenali resepnya lewat AI, dan tumbuh bersama komunitas UMKM lokal.
            </p>
        </div>

        {{-- Feature Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto">
            {{-- Card 1 - Jelajah Kuliner --}}
            <div class="bg-zinc-100 rounded-2xl p-10 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-orange-500 rounded-2xl mb-8">
                    <svg class="w-10 h-10 text-white" xmlns="http://www.w3.org/2000/svg" width="512" height="512"
                        viewBox="0 0 512 512">
                        <circle cx="256" cy="192" r="32" fill="currentColor" />
                        <path fill="currentColor"
                            d="M256 32c-88.22 0-160 68.65-160 153c0 40.17 18.31 93.59 54.42 158.78c29 52.34 62.55 99.67 80 123.22a31.75 31.75 0 0 0 51.22 0c17.42-23.55 51-70.88 80-123.22C397.69 278.61 416 225.19 416 185c0-84.35-71.78-153-160-153m0 224a64 64 0 1 1 64-64a64.07 64.07 0 0 1-64 64" />
                    </svg>
                </div>
                <h3 class="text-2xl tracking-[0.04rem] font-bricolage font-bold text-black mb-4">Jelajah Kuliner</h3>
                <p class="text-black text-base leading-relaxed mb-8">
                    Temukan makanan khas dari berbagai daerah Indonesia dengan mudah lewat peta interaktif.
                </p>
                <a href="#"
                    class="inline-flex items-center space-x-2 bg-orange-200 hover:bg-orange-300 text-gray-800 font-semibold px-6 py-3 rounded-xl transition duration-300">
                    <span>Coba</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>

            {{-- Card 2 - Kenali Resepmu --}}
            <div class="bg-zinc-100 rounded-2xl p-10 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-orange-500 rounded-2xl mb-8">
                    <svg class="w-10 h-10 text-white" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24">
                        <g fill="none">
                            <path
                                d="m12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z" />
                            <path fill="currentColor"
                                d="M9.107 5.448c.598-1.75 3.016-1.803 3.725-.159l.06.16l.807 2.36a4 4 0 0 0 2.276 2.411l.217.081l2.36.806c1.75.598 1.803 3.016.16 3.725l-.16.06l-2.36.807a4 4 0 0 0-2.412 2.276l-.081.216l-.806 2.361c-.598 1.75-3.016 1.803-3.724.16l-.062-.16l-.806-2.36a4 4 0 0 0-2.276-2.412l-.216-.081l-2.36-.806c-1.751-.598-1.804-3.016-.16-3.724l.16-.062l2.36-.806A4 4 0 0 0 8.22 8.025l.081-.216zM19 2a1 1 0 0 1 .898.56l.048.117l.35 1.026l1.027.35a1 1 0 0 1 .118 1.845l-.118.048l-1.026.35l-.35 1.027a1 1 0 0 1-1.845.117l-.048-.117l-.35-1.026l-1.027-.35a1 1 0 0 1-.118-1.845l.118-.048l1.026-.35l.35-1.027A1 1 0 0 1 19 2" />
                        </g>
                    </svg>
                </div>
                <h3 class="text-2xl tracking-[0.04rem] font-bricolage font-bold text-black mb-4">Kenali Resepmu</h3>
                <p class="text-gray-600 text-base leading-relaxed mb-8">
                    Gunakan teknologi AI untuk mengenali dan mempelajari resep dari foto makanan khas Indonesia.
                </p>
                <a href="#"
                    class="inline-flex items-center space-x-2 bg-orange-200 hover:bg-orange-300 text-gray-800 font-semibold px-6 py-3 rounded-xl transition duration-300">
                    <span>Coba</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>

            {{-- Card 3 - Berkembang Bersama --}}
            <div class="bg-zinc-100 rounded-2xl p-10 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-orange-500 rounded-2xl mb-8">
                    <svg class="h-10 w-10 text-white" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
                        <path fill="currentColor"
                            d="M357.57 223.94a79.48 79.48 0 0 0 56.58-23.44l77-76.95c6.09-6.09 6.65-16 .85-22.39a16 16 0 0 0-23.17-.56l-68.63 68.58a12.29 12.29 0 0 1-17.37 0c-4.79-4.78-4.53-12.86.25-17.64l68.33-68.33a16 16 0 0 0-.56-23.16A15.62 15.62 0 0 0 440.27 56a16.7 16.7 0 0 0-11.81 4.9l-68.27 68.26a12.29 12.29 0 0 1-17.37 0c-4.78-4.78-4.53-12.86.25-17.64l68.33-68.31a16 16 0 0 0-.56-23.16A15.62 15.62 0 0 0 400.26 16a16.73 16.73 0 0 0-11.81 4.9L311.5 97.85a79.5 79.5 0 0 0-23.44 56.59v8.23a16 16 0 0 1-4.69 11.33l-35.61 35.62a4 4 0 0 1-5.66 0L68.82 36.33a16 16 0 0 0-22.58-.06C31.09 51.28 23 72.47 23 97.54c-.1 41.4 21.66 89 56.79 124.08l85.45 85.45A64.8 64.8 0 0 0 211 326a64 64 0 0 0 16.21-2.08a16.2 16.2 0 0 1 4.07-.53a15.93 15.93 0 0 1 10.83 4.25l11.39 10.52a16.12 16.12 0 0 1 4.6 11.23v5.54a47.73 47.73 0 0 0 13.77 33.65l90.05 91.57l.09.1a53.29 53.29 0 0 0 75.36-75.37L302.39 269.9a4 4 0 0 1 0-5.66L338 228.63a16 16 0 0 1 11.32-4.69Z" />
                        <path fill="currentColor"
                            d="M211 358a97.32 97.32 0 0 1-68.36-28.25l-13.86-13.86a8 8 0 0 0-11.3 0l-85 84.56c-15.15 15.15-20.56 37.45-13.06 59.29a31 31 0 0 0 1.49 3.6C31 484 50.58 496 72 496a55.68 55.68 0 0 0 39.64-16.44L225 365.66a4.69 4.69 0 0 0 1.32-3.72v-.26a4.63 4.63 0 0 0-5.15-4.27A97 97 0 0 1 211 358" />
                    </svg>
                </div>
                <h3 class="text-2xl tracking-[0.04rem] font-bricolage font-bold text-black mb-4">Berkembang Bersama</h3>
                <p class="text-gray-600 text-base leading-relaxed mb-8">
                    Gabung sebagai mitra UMKM dan perluas jangkauan bisnis bersama Rasa Warisan.
                </p>
                <a href="#"
                    class="inline-flex items-center space-x-2 bg-orange-200 hover:bg-orange-300 text-gray-800 font-semibold px-6 py-3 rounded-xl transition duration-300">
                    <span>Coba</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="mb-15 md:mb-25 lg:mb-40">
        @livewire('contact-form')
    </div>

</x-layouts.app>
