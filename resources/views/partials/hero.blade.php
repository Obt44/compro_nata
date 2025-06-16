@php
    use Illuminate\Support\Facades\Storage;
@endphp

<section class="relative w-full h-[calc(100vh-64px)] flex items-center justify-center p-4 sm:p-6 lg:p-8"
    x-data="{
        currentSlide: 0,
        slides: [
            @php
$slideImages = [];
            // Cek apakah ada slide dari database
            $dbSlides = App\Models\Slide::orderBy('position')->get();
            
            if ($dbSlides->count() > 0) {
                foreach ($dbSlides as $slide) {
                    if ($slide->image_path) {
                        // Pastikan path gambar benar dan lengkap
                        $imagePath = $slide->image_path;
                        // Jika path tidak dimulai dengan 'slides/', tambahkan prefix
                        if (!str_starts_with($imagePath, 'slides/')) {
                            $imagePath = 'slides/' . $imagePath;
                        }
                        $slideImages[] = "'" . asset('storage/' . $imagePath) . "'";
                    }
                }
            }
            
            // Jika tidak ada slide dari database, gunakan default
            if (empty($slideImages)) {
                $slideImages = [
                    "'" . asset('images/image 5.png') . "'",
                    "'" . asset('images/hero-background.jpg') . "'",
                    "'" . asset('images/vision.png') . "'"
                ];
            }
            
            echo implode(",\n        ", $slideImages); @endphp
        ],
        autoSlideInterval: null,
    
        init() {
            this.startAutoSlide();
        },
    
        startAutoSlide() {
            this.autoSlideInterval = setInterval(() => {
                this.nextSlide();
            }, 7000);
        },
    
        stopAutoSlide() {
            clearInterval(this.autoSlideInterval);
        },
    
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.slides.length;
        },
    
        prevSlide() {
            this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
        }
    }">
    <div class="absolute inset-0 overflow-hidden">
        {{-- Background Image Slideshow --}}
        <div class="relative w-full h-full">
            <template x-for="(slide, index) in slides" :key="index">
                <img :src="slide"
                    class="absolute top-0 left-0 w-full h-full object-cover transition-opacity duration-1000 ease-in-out pointer-events-none"
                    :class="{ 'opacity-100': currentSlide === index, 'opacity-0': currentSlide !== index }"
                    style="z-index: 1;">
            </template>
        </div>
    </div>

    {{-- Navigation Buttons --}}
    <div class="absolute inset-x-0 bottom-1 flex justify-between items-center px-4" style="z-index: 20;">
        <a href="{{ route('admin.slides.index') }}"
            class="bg-black bg-opacity-30 hover:bg-opacity-50 text-white rounded-full p-2 focus:outline-none transition-all duration-300"
            title="Kelola Slideshow">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                </path>
            </svg>
        </a>
    </div>

    <div
        class="relative w-full h-[85vh] max-w-[1920px] mx-auto flex flex-col justify-end text-left px-2 sm:px-10 lg:px-10 py-8 sm:py-8 lg:py-8 rounded-lg bg-transparent border-[9px] border-blue-500 overflow-hidden z-10">
        <!-- Blur di bagian bawah (TETAP) -->
        <div
            class="absolute bottom-0 left-0 w-full h-[15%] bg-blue-900/30 backdrop-blur-md pointer-events-none z-0 [clip-path:polygon(0% 0%, 100% 0%, 0% 100%)]">
            <!-- Teks tetap di atas blur -->
            <blockquote class="relative z-10 text-white text-l font-semibold leading-snug px-6 sm:px-8 lg:px-10 py-4">
                <p>"Solusi digital yang bikin proses bisnis lebih mudah,<br>cepat, dan efisien."</p>
            </blockquote>
        </div>

        <!-- Tombol segitiga di POJOK KANAN BAWAH -->
        <button @click="nextSlide(); stopAutoSlide(); startAutoSlide();"
            class="absolute bottom-0 right-0 w-15 h-15 flex items-center justify-center bg-blue-500 hover:bg-black/50 transition-all duration-300 cursor-pointer focus:outline-none z-0"
            aria-label="Next slide" style="clip-path: polygon(100% 100%, 0% 100%, 100% 0%);">
            <!-- Panah ke kanan -->
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg" style="margin-left: 20px; margin-top: 20px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
</section>

{{-- Section Produk, Insight, dan Carousel Logo Mitra --}}
<div class="bg-gray-50 w-full py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Produk --}}
        <div class="mb-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Produk & Layanan</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Solusi teknologi terbaik untuk mengoptimalkan bisnis
                    Anda</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($products ?? [] as $product)
                    <a href="{{ route('products.show', $product->slug) }}" class="group block">
                        <div
                            class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 transform group-hover:scale-105 group-hover:shadow-xl">
                            <div class="relative overflow-hidden">
                                @if ($product->featured_image)
                                    <img src="{{ asset('storage/' . $product->featured_image) }}"
                                        alt="{{ $product->title }}"
                                        class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110">
                                @else
                                    <img src="https://via.placeholder.com/800x450" alt="{{ $product->title }}"
                                        class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110">
                                @endif
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                            </div>
                            <div class="p-6">
                                <h3
                                    class="text-xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors duration-300">
                                    {{ $product->title }}</h3>
                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    {{ $product->meta_description ?? Str::limit(strip_tags($product->content), 120) }}
                                </p>
                                <div class="flex items-center text-blue-600 font-semibold group-hover:text-blue-700">
                                    <span>Pelajari Lebih Lanjut</span>
                                    <svg class="ml-2 w-4 h-4 transition-transform duration-300 group-hover:translate-x-1"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('products') }}"
                    class="inline-flex items-center px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg transition-all duration-300 transform hover:scale-105">
                    Lihat Semua Produk
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>
        </div>

        {{-- Insight --}}
        <div class="mb-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Insight & Berita</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Informasi terkini dan wawasan mendalam tentang
                    teknologi dan industri</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @if ($insight_popular)
                    <a href="{{ route('insights.show', $insight_popular->slug) }}" class="group block">
                        <div
                            class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 transform group-hover:scale-105 group-hover:shadow-xl relative">
                            <span
                                class="absolute top-4 right-4 bg-red-500 text-white text-xs px-3 py-1 rounded-full flex items-center z-10 shadow-lg">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 3v12m0 0l3-3m-3 3l-3-3" />
                                </svg>
                                Hot
                            </span>
                            <div class="relative overflow-hidden">
                                @if ($insight_popular->featured_image)
                                    <img src="{{ asset('storage/' . $insight_popular->featured_image) }}"
                                        alt="{{ $insight_popular->title }}"
                                        class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110">
                                @else
                                    <img src="https://via.placeholder.com/800x450"
                                        alt="{{ $insight_popular->title }}"
                                        class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110">
                                @endif
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                            </div>
                            <div class="p-6">
                                <h3
                                    class="text-xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors duration-300 line-clamp-2">
                                    {{ $insight_popular->title }}
                                </h3>
                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    {{ $insight_popular->meta_description ?? Str::limit(strip_tags($insight_popular->content), 120) }}
                                </p>
                                <div class="flex items-center text-blue-600 font-semibold group-hover:text-blue-700">
                                    <span>Baca Selengkapnya</span>
                                    <svg class="ml-2 w-4 h-4 transition-transform duration-300 group-hover:translate-x-1"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                @endif
                @foreach ($insight_latest ?? [] as $article)
                    <a href="{{ route('insights.show', $article->slug) }}" class="group block">
                        <div
                            class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 transform group-hover:scale-105 group-hover:shadow-xl relative">
                            <span
                                class="absolute top-4 right-4 bg-blue-500 text-white text-xs px-3 py-1 rounded-full flex items-center z-10 shadow-lg">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="2" fill="none" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l2 2" />
                                </svg>
                                New
                            </span>
                            <div class="relative overflow-hidden">
                                @if ($article->featured_image)
                                    <img src="{{ asset('storage/' . $article->featured_image) }}"
                                        alt="{{ $article->title }}"
                                        class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110">
                                @else
                                    <img src="https://via.placeholder.com/800x450" alt="{{ $article->title }}"
                                        class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110">
                                @endif
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                            </div>
                            <div class="p-6">
                                <h3
                                    class="text-xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors duration-300 line-clamp-2">
                                    {{ $article->title }}
                                </h3>
                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    {{ $article->meta_description ?? Str::limit(strip_tags($article->content), 120) }}
                                </p>
                                <div class="flex items-center text-blue-600 font-semibold group-hover:text-blue-700">
                                    <span>Baca Selengkapnya</span>
                                    <svg class="ml-2 w-4 h-4 transition-transform duration-300 group-hover:translate-x-1"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('insights.index') }}"
                    class="inline-flex items-center px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg transition-all duration-300 transform hover:scale-105">
                    Lihat Lebih Banyak Insight
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>
        </div>

        {{-- Carousel Logo Mitra --}}
        <div class="mb-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Mitra Kami</h2>
                <p class="text-lg text-gray-600">Dipercaya oleh perusahaan terkemuka</p>
            </div>
            <div class="overflow-x-auto">
                <div class="flex items-center justify-center gap-8 py-4 min-w-max">
                    @foreach ($partner_logos ?? [] as $logo)
                        <div class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition-shadow duration-300">
                            <img src="{{ asset('storage/' . $logo) }}" alt="Logo Mitra"
                                class="h-16 w-auto object-contain grayscale hover:grayscale-0 transition-all duration-300">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.whatsapp', [
    'wa_number' => \App\Models\Content::where('type', 'contact')->first()->wa_number ?? null,
])
