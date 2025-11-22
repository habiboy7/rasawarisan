<div class="py-8">
    <div class="flex items-center w-full mb-10 md:mb-20">
        <div class="flex-grow h-px bg-zinc-300"></div>
        <span class="mx-4 md:mx-6 font-bricolage text-orange-500 text-2xl md:text-3xl lg:text-4xl whitespace-nowrap">Makanan Favorit</span>
        <div class="flex-grow h-px bg-zinc-300"></div>
    </div>

    <div class="relative max-w-7xl mx-auto">
        {{-- Layout Grid --}}
        <div class="flex flex-col md:flex-row gap-4 md:gap-6">
            {{-- Gambar Besar Kiri --}}
            @if (isset($pageFoods[0]))
            {{-- {{ route('food.detail', ['slug' => $pageFoods[0]['slug']]) }} --}}
                <a href="#" 
                   wire:key="0-{{ $pageFoods[0]['name'] }}"
                   class="flex-shrink-0 w-full md:w-[45%] lg:w-[480px] rounded-2xl overflow-hidden shadow-lg relative group cursor-pointer transition-shadow duration-300 hover:shadow-2xl">
                    <img src="{{ asset($pageFoods[0]['image']) }}" 
                         alt="{{ $pageFoods[0]['name'] }}" 
                         class="object-cover w-full h-[400px] md:h-[500px] transition-transform duration-300 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent group-hover:from-black/80 transition-all duration-300"></div>
                    <div class="absolute bottom-6 left-6 text-white">
                        <h3 class="text-3xl md:text-4xl font-bricolage font-bold mb-2 group-hover:text-orange-300 transition-colors duration-300">{{ $pageFoods[0]['name'] }}</h3>
                        <p class="text-base md:text-lg mb-2">{{ $pageFoods[0]['location'] }}</p>
                        <p class="text-sm flex items-center gap-2">
                            <flux:icon name="heart" class="w-4 h-4 fill-white text-white group-hover:text-red-500 group-hover:fill-red-500 transition-colors duration-300" /> 
                            {{ number_format($pageFoods[0]['likes']) }} Suka
                        </p>
                    </div>
                </a>
            @endif

            {{-- Grid 2x2 Kanan --}}
            <div class="flex-1 grid grid-cols-2 gap-4 md:gap-6">
                @foreach (array_slice($pageFoods, 1, 4) as $index => $food)
                    <div wire:key="{{ $index + 1 }}-{{ $food['name'] }}"
                        class="rounded-2xl overflow-hidden shadow-lg relative group cursor-pointer">
                        <img src="{{ asset($food['image']) }}" 
                             alt="{{ $food['name'] }}" 
                             class="object-cover w-full h-[190px] md:h-[238px] transition-transform duration-300 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <h3 class="text-lg font-bricolage md:text-2xl font-bold mb-1 group-hover:text-orange-300 transition-colors duration-300">{{ $food['name'] }}</h3>
                            <p class="text-xs md:text-sm mb-1">{{ $food['location'] }}</p>
                            <p class="text-xs flex items-center gap-1">
                                <flux:icon name="heart" class="w-3 h-3 fill-white text-white group-hover:text-red-500 group-hover:fill-red-500 transition-colors duration-300" /> 
                                {{ number_format($food['likes']) }} Suka
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Tombol Next --}}
        @if ($totalPages > 1)
            <button wire:click="nextPage"
                class="absolute top-1/2 -translate-y-1/2 -right-4 md:-right-6 bg-orange-500 hover:bg-orange-600 text-white p-3 md:p-4 rounded-full shadow-xl transition-all duration-300 hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        @endif
    </div>

    {{-- Indikator --}}
    @if ($totalPages > 1)
        <div class="flex justify-center mt-8 gap-2">
            @for ($i = 0; $i < $totalPages; $i++)
                <div class="w-12 h-1 rounded-full transition-all duration-300 {{ $i == $currentPage ? 'bg-orange-500' : 'bg-gray-300' }}">
                </div>
            @endfor
        </div>
    @endif
</div>