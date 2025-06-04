<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Portal Berita - Nata Tech</title>

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
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Portal Berita</h1>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">Semua artikel dan berita terbaru dari Nata Tech</p>
                </div>

                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    @forelse($articles as $article)
                        <article class="border-b border-gray-200 last:border-b-0 hover:bg-gray-50 transition-colors duration-200">
                            <a href="/insight/{{ $article->slug }}" class="block p-6">
                                <div class="flex flex-col md:flex-row md:items-center">
                                    <div class="md:w-1/4 mb-4 md:mb-0 md:mr-6">
                                        @if($article->featured_image)
                                            <img class="w-full h-48 md:h-32 object-cover rounded-lg" src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}">
                                        @else
                                            <img class="w-full h-48 md:h-32 object-cover rounded-lg" src="https://via.placeholder.com/800x450" alt="{{ $article->title }}">
                                        @endif
                                    </div>
                                    <div class="md:w-3/4">
                                        <div class="flex items-center text-sm text-gray-500 mb-2">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}
                                        </div>
                                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $article->title }}</h3>
                                        <p class="text-gray-600 mb-4">{{ $article->meta_description ?? Str::limit(strip_tags($article->content), 150) }}</p>
                                        <span class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                                            Baca selengkapnya
                                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </article>
                    @empty
                        <div class="text-center py-12">
                            <p class="text-gray-500 text-lg">Belum ada artikel yang dipublikasikan.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination Links -->
                <div class="mt-10">
                    {{ $articles->links() }}
                </div>
                
                <!-- Kembali ke Insight -->
                <div class="mt-8 text-center">
                    <a href="{{ url('/insight') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                        <svg class="mr-2 -ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Insight
                    </a>
                </div>
            </div>
        </main>

        {{-- Include Footer Partial --}}
        @include('partials.footer')
        
    </body>
</html>