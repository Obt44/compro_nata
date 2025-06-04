<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Produk - Nata Tech</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js for mobile menu toggle --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-gray-50">
    {{-- Include Navbar Partial --}}
    @include('partials.navbar')

    <main class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Produk & Layanan</h1>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">Solusi teknologi terbaik untuk membantu bisnis Anda
                    berkembang di era digital.</p>
            </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @if($products->count() > 0)
                    @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                        @if($product->featured_image)
                            <img src="{{ asset('storage/' . $product->featured_image) }}" alt="{{ $product->title }}" class="w-full h-48 object-cover">
                        @else
                            <img src="{{ asset('images/placeholder_product.jpg') }}" alt="{{ $product->title }}" class="w-full h-48 object-cover">
                        @endif
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $product->title }}</h3>
                            <p class="text-gray-600 mb-4 flex-grow">{{ $product->meta_description }}</p>
                            @if(strip_tags($product->content) != $product->meta_description)
                                <div class="mt-2">
                                    {!! $product->content !!}
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- Tampilan default jika belum ada produk -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                        <img src="{{ asset('images/SPBE.png') }}" alt="Jasa Konsultasi TI" class="w-full h-48 object-cover">
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Jasa Konsultasi TI</h3>
                            <p class="text-gray-600 mb-4 flex-grow">Menyediakan bimbingan, saran, dan solusi terkait teknologi
                                informasi bagi mitra seperti pendampingan evaluasi SPBE, manajemen data, manajemen risiko,
                                dan layanan jasa konsultasi TI lainnya.</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                        <img src="{{ asset('images/placeholder_product_2.jpg') }}" alt="Tata Kelola & Manajemen TI" class="w-full h-48 object-cover">
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Tata Kelola & Manajemen TI</h3>
                            <p class="text-gray-600 mb-4 flex-grow">Menyediakan jasa penyusunan masterplan IT, arsitektur dan peta
                                rencana SPBE, masterplan smart city, pedoman dan kebijakan, rencana aksi, manajemen TI, dan
                                layanan tata kelola dan manajemen lainnya.</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                        <img src="{{ asset('images/placeholder_product_3.jpg') }}" alt="Pengembangan Perangkat Lunak" class="w-full h-48 object-cover">
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Pengembangan Perangkat Lunak</h3>
                            <p class="text-gray-600 mb-4 flex-grow">Layanan pembuatan, pengujian, dan pemeliharaan aplikasi atau
                                sistem perangkat lunak sesuai dengan kebutuhan mitra.</p>
                            <ul class="text-gray-600 space-y-2">
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Analisis Kebutuhan
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Rekomendasi Solusi
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Pendampingan Implementasi
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-20">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Portofolio Layanan</h1>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">Produk yang telah kami buat</p>
            </div>
        </div>
        
    </main>

    {{-- Include Footer Partial --}}
    @include('partials.footer')
    
</body>

</html>
