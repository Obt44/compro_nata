<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $product->title }} - Nata Tech</title>

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
            <!-- Breadcrumb -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ url('/produk') }}" class="text-gray-700 hover:text-blue-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Produk
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2">{{ $product->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Product Detail -->
            <article class="bg-white rounded-lg shadow-md overflow-hidden">
                @if ($product->featured_image)
                    <img src="{{ asset('storage/' . $product->featured_image) }}" alt="{{ $product->title }}"
                        class="w-full h-96 object-cover">
                @endif
                <div class="p-8">
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        {{ $product->published_at ? $product->published_at->format('d M Y') : $product->created_at->format('d M Y') }}
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->title }}</h1>
                    <div class="prose max-w-none">
                        {!! $product->content !!}
                    </div>
                </div>
            </article>

            <!-- Related Products -->
            @if ($relatedProducts->count() > 0)
                <div class="mt-16">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8">Produk Terkait</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ($relatedProducts as $related)
                            <a href="{{ route('products.show', $related->slug) }}"
                                class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col hover:shadow-lg transition-shadow duration-300">
                                @if ($related->featured_image)
                                    <img src="{{ asset('storage/' . $related->featured_image) }}"
                                        alt="{{ $related->title }}" class="w-full h-48 object-cover">
                                @else
                                    <img src="https://via.placeholder.com/800x450" alt="{{ $related->title }}"
                                        class="w-full h-48 object-cover">
                                @endif
                                <div class="p-4 flex flex-col flex-grow">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $related->title }}</h3>
                                    <p class="text-gray-600 text-sm">
                                        {{ $related->meta_description ?? Str::limit(strip_tags($related->content), 80) }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </main>

    {{-- Include Footer Partial --}}
    @include('partials.footer')

    {{-- Include WhatsApp Floating Button --}}
    @include('partials.whatsapp', [
        'wa_number' => \App\Models\Content::where('type', 'contact')->first()->wa_number ?? null,
    ])

</body>

</html>
