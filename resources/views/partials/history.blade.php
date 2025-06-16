<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Sejarah Kami</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Perjalanan panjang kami dalam memberikan layanan terbaik kepada pelanggan
            </p>
        </div>

        <div class="max-w-4xl mx-auto relative pl-16">
            <!-- Vertical Line (Timeline) - Left Aligned -->
            <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-blue-200"></div>

            @forelse($histories->sortBy('year') as $history)
                <div class="relative mb-12 last:mb-0">
                    <!-- Year Circle - Aligned with the line -->
                    <div
                        class="absolute left-1 top-0 -ml-18 w-15 h-10 rounded-full bg-blue-500 border-4 border-white flex items-center justify-center text-white font-bold text-sm shadow-md">
                        {{ $history->year }}
                    </div>

                    <div class="ml-12">
                        <div class="bg-white rounded-lg shadow-lg group relative overflow-hidden p-6 transition-all duration-300 ease-in-out"
                            x-data="{ isHovered: false, cardHeight: '150px' }" @mouseenter="isHovered = true; cardHeight = '400px';"
                            @mouseleave="isHovered = false; cardHeight = '150px';" :style="`height: ${cardHeight};`">

                            <!-- Text Content Layer -->
                            <div class="absolute inset-0 p-6 flex flex-col j transition-opacity duration-300 z-10"
                                :class="isHovered && {{ $history->image ? 'true' : 'false' }} ? 'opacity-0' : 'opacity-100'">
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $history->title }}</h3>
                                <p class="text-gray-600">{{ $history->description }}</p>
                            </div>

                            @if ($history->image)
                                <!-- Image Content Layer -->
                                <div class="absolute inset-0 p-6 flex items-center justify-center transition-opacity duration-300 z-20"
                                    :class="isHovered ? 'opacity-100' : 'opacity-0'">
                                    <img src="{{ asset('storage/' . $history->image) }}" alt="{{ $history->title }}"
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-600">Belum ada sejarah yang ditambahkan.</p>
            @endforelse
        </div>
    </div>
</section>
