<div class="py-10">
    <div class="flex items-center w-full mb-10 md:mb-20">
        <div class="flex-grow h-px bg-zinc-300"></div>
        <span class="mx-4 md:mx-6 font-bricolage text-orange-500 text-2xl md:text-3xl lg:text-4xl whitespace-nowrap">Restoran
            Favorit</span>
        <div class="flex-grow h-px bg-zinc-300"></div>
    </div>
    {{-- Layout Container --}}
    <div class="relative max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row gap-6 md:gap-6">

            {{-- Gambar Besar Kiri --}}
            @if (isset($pageRestaurant[0]))
                {{-- <a href="{{ route('food.detail', ['slug' => $favoriteFoods[0]['slug']]) }}"  --}}
                <a href="#" wire:key="0-{{ $pageRestaurant[0]['name'] }}"
                    class="flex-shrink-0 w-full md:w-[48%] lg:w-[580px] rounded-2xl overflow-hidden shadow-lg relative group cursor-pointer transition-all duration-300 hover:shadow-2xl">
                    <img src="{{ asset($pageRestaurant[0]['image']) }}" alt="{{ $pageRestaurant[0]['name'] }}"
                        class="object-cover w-full h-[450px] md:h-[650px] transition-transform duration-500 group-hover:scale-105">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent group-hover:from-black/85 transition-all duration-300">
                    </div>

                    {{-- Info Makanan --}}
                    <div class="absolute bottom-8 left-8 text-white">
                        <p class=" text-lg font-medium mb-3">Terfavorit di {{ $pageRestaurant[0]['region_selected'] }}
                        </p>
                        <h3
                            class="text-4xl font-bricolage md:text-5xl font-semibold mb-2 group-hover:text-orange-300 transition-colors duration-300">
                            {{ $pageRestaurant[0]['name'] }}
                        </h3>
                        <p class="text-base md:text-lg mb-3 text-gray-200">
                            {{ $pageRestaurant[0]['location'] }}
                        </p>
                        <p class="text-sm md:text-base flex items-center gap-2">
                            <flux:icon name="heart"
                                class="w-5 h-5 fill-current text-white group-hover:text-red-500 group-hover:fill-red-500 transition-colors duration-300" />
                            <span class="font-semibold">{{ number_format($pageRestaurant[0]['likes']) }} Suka</span>
                        </p>
                    </div>
                </a>
            @endif

            {{-- Grid 2 Card Kanan --}}
            <div class="flex-1 flex flex-col gap-6 md:gap-8">
                @foreach (array_slice($pageRestaurant, 1, 2) as $index => $rest)
                    {{-- <a href="{{ route('food.detail', ['slug' => $food['slug']]) }}" --}}
                    <a href="#" wire:key="{{ $index + 1 }}-{{ $rest['name'] }}"
                        class="rounded-3xl overflow-hidden shadow-lg relative group cursor-pointer transition-all duration-300 hover:shadow-2xl">

                        {{-- Background Image --}}
                        <img src="{{ asset($rest['image']) }}" alt="{{ $rest['name'] }}"
                            class="object-cover w-full h-[280px] md:h-[310px] transition-transform duration-500 group-hover:scale-105">
                        {{-- Gradient Overlay --}}
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent group-hover:from-black/85 transition-all duration-300">
                        </div>
                        {{-- Info Makanan --}}
                        <div class="absolute inset-0 p-8 md:p-10 flex flex-col justify-end">
                            {{-- Badge --}}
                            <p class="text-white text-lg">Terfavorit di {{ $rest['region_selected'] }}
                            </p>


                            {{-- Nama Makanan --}}
                            <h3 class="text-3xl md:text-4xl font-bricolage font-bold text-white mb-2 group-hover:text-orange-300 transition-colors duration-300">
                                {{ $rest['name'] }}
                            </h3>

                            {{-- Lokasi --}}
                            <p class="text-base md:text-lg text-white/90 mb-3">
                                {{ $rest['location'] }}
                            </p>

                            {{-- Likes --}}
                            <p class="text-sm md:text-base flex items-center gap-2 text-white">
                                <flux:icon name="heart"
                                    class="w-5 h-5 fill-current text-white group-hover:text-red-500 group-hover:fill-red-500 transition-colors duration-300" />
                                <span class="font-semibold">{{ number_format($rest['likes']) }} Suka</span>
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Tombol Next --}}
        @if ($totalPages > 1)
            <button wire:click="nextPage"
                class="absolute top-1/2 -translate-y-1/2 -right-4 md:-right-6 bg-orange-500 hover:bg-orange-600 text-white p-3 md:p-4 rounded-full shadow-xl transition-all duration-300 hover:scale-110 z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        @endif
    </div>

    {{-- Indikator Pagination --}}
    @if ($totalPages > 1)
        <div class="flex justify-center mt-8 gap-2">
            @for ($i = 0; $i < $totalPages; $i++)
                <button wire:click="goToPage({{ $i }})"
                    class="w-12 h-1 rounded-full transition-all duration-300 {{ $i == $currentPage ? 'bg-orange-500' : 'bg-gray-300 hover:bg-gray-400' }}">
                </button>
            @endfor
        </div>
    @endif
</div>
