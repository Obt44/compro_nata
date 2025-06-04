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

    {{-- Debug Section - Hanya tampil untuk admin
    @auth
        @if (auth()->user()->is_admin ?? false)
            <div class="fixed bottom-0 left-0 right-0 bg-black bg-opacity-80 text-white p-4 text-xs overflow-auto" style="z-index: 50; max-height: 200px;">
                <h4 class="font-bold mb-2">Debug Info Slideshow:</h4>
                <ul>
                    @php
                        $dbSlides = App\Models\Slide::orderBy('position')->get();
                    @endphp
                    @foreach ($dbSlides as $slide)
                        <li class="mb-1">
                            <strong>Slide {{ $slide->position }}:</strong> 
                            Path DB: {{ $slide->image_path ?? 'Tidak ada' }} | 
                            URL: {{ asset('storage/' . $slide->image_path) }} | 
                            File exists: {{ file_exists(public_path('storage/' . $slide->image_path)) ? 'Ya' : 'Tidak' }}
                        </li>
                    @endforeach
                </ul>
                <p class="mt-2">Jumlah slides aktif: {{ count($slides) }}</p>
            </div>
        @endif
    @endauth --}}
</section>
