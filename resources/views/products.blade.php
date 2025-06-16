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

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if ($products->count() > 0)
                    @foreach ($products as $product)
                        <a href="{{ route('products.show', $product->slug) }}"
                            class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col hover:shadow-lg transition-shadow duration-300">
                            @if ($product->featured_image)
                                <img src="{{ asset('storage/' . $product->featured_image) }}"
                                    alt="{{ $product->title }}" class="w-full h-48 object-cover">
                            @else
                                <img src="{{ asset('images/placeholder_product.jpg') }}" alt="{{ $product->title }}"
                                    class="w-full h-48 object-cover">
                            @endif
                            <div class="p-6 flex flex-col flex-grow">
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $product->title }}</h3>
                                <p class="text-gray-600 mb-4 flex-grow">{{ $product->meta_description }}</p>
                                <div class="mt-auto">
                                    <span class="inline-flex items-center text-blue-600 hover:text-blue-700">
                                        Detail Produk
                                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    <!-- Tampilan default jika belum ada produk -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                        <img src="{{ asset('images/SPBE.png') }}" alt="Jasa Konsultasi TI"
                            class="w-full h-48 object-cover">
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Jasa Konsultasi TI</h3>
                            <p class="text-gray-600 mb-4 flex-grow">Menyediakan bimbingan, saran, dan solusi terkait
                                teknologi
                                informasi bagi mitra seperti pendampingan evaluasi SPBE, manajemen data, manajemen
                                risiko,
                                dan layanan jasa konsultasi TI lainnya.</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                        <img src="{{ asset('images/placeholder_product_2.jpg') }}" alt="Tata Kelola & Manajemen TI"
                            class="w-full h-48 object-cover">
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Tata Kelola & Manajemen TI</h3>
                            <p class="text-gray-600 mb-4 flex-grow">Menyediakan jasa penyusunan masterplan IT,
                                arsitektur dan peta
                                rencana SPBE, masterplan smart city, pedoman dan kebijakan, rencana aksi, manajemen TI,
                                dan
                                layanan tata kelola dan manajemen lainnya.</p>
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

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $portfolios = \App\Models\Content::where('type', 'portfolio')
                        ->where('status', 'published')
                        ->orderBy('published_at', 'desc')
                        ->take(3)
                        ->get();
                @endphp

                @forelse($portfolios as $portfolio)
                    <a href="{{ route('portfolio.show', $portfolio->slug) }}"
                        class="bg-white rounded-lg shadow-md overflow-hidden h-full flex flex-col hover:shadow-lg transition-shadow duration-300">
                        <div class="relative">
                            @if ($portfolio->partner_logo)
                                <div
                                    class="absolute top-2 left-2 z-10 bg-white/90 backdrop-blur-sm p-1.5 rounded-md shadow-sm">
                                    <img src="{{ asset('storage/' . $portfolio->partner_logo) }}" alt="Partner Logo"
                                        class="h-6 w-auto">
                                </div>
                            @endif
                            @if ($portfolio->featured_image)
                                <img class="object-cover w-full h-40"
                                    src="{{ asset('storage/' . $portfolio->featured_image) }}"
                                    alt="{{ $portfolio->title }}">
                            @else
                                <img class="object-cover w-full h-40" src="https://via.placeholder.com/800x450"
                                    alt="{{ $portfolio->title }}">
                            @endif
                        </div>
                        <div class="p-4 flex flex-col flex-grow">
                            <div class="flex items-center text-sm text-gray-500 mb-2">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                {{ $portfolio->published_at ? $portfolio->published_at->format('d M Y') : $portfolio->created_at->format('d M Y') }}
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ $portfolio->title }}
                            </h3>
                            <p class="text-gray-600 mb-4 flex-grow line-clamp-3">
                                {{ $portfolio->meta_description ?? Str::limit(strip_tags($portfolio->content), 80) }}
                            </p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg">Belum ada portfolio yang dipublikasikan.</p>
                    </div>
                @endforelse
            </div>

            @if ($portfolios->count() > 0)
                <div class="text-center mt-8">
                    <a href="{{ route('portfolio') }}"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Lihat Semua Portfolio
                        <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </main>

    {{-- Include Footer Partial --}}
    @include('partials.footer')

    @include('partials.whatsapp', [
        'wa_number' => \App\Models\Content::where('type', 'contact')->first()->wa_number ?? null,
    ])
</body>

</html>
