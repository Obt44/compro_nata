<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Insight - Nata Tech</title>

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
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Insight & Artikel</h1>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">Temukan informasi terbaru seputar teknologi dan transformasi digital.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($articles as $article)
                        <article class="bg-white rounded-lg shadow-md overflow-hidden h-full flex flex-col">
                            <div class="aspect-w-16 aspect-h-9">
                                @if($article->featured_image)
                                    <img class="object-cover w-full h-40" src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}">
                                @else
                                    <img class="object-cover w-full h-40" src="https://via.placeholder.com/800x450" alt="{{ $article->title }}">
                                @endif
                            </div>
                            <div class="p-4 flex flex-col flex-grow">
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ $article->title }}</h3>
                                <p class="text-gray-600 mb-4 flex-grow line-clamp-3">{{ $article->meta_description ?? Str::limit(strip_tags($article->content), 80) }}</p>
                                <a href="/insight/{{ $article->slug }}" class="text-blue-600 hover:text-blue-800 font-medium mt-auto">Baca selengkapnya →</a>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <p class="text-gray-500 text-lg">Belum ada artikel yang dipublikasikan.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination Links -->
                <div class="mt-10">
                    {{ $articles->links() }}
                </div>
            </div>
        </main>

        {{-- Include Footer Partial --}}
        @include('partials.footer')
        
    </body>
</html>