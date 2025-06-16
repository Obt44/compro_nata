<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $article->title }} - Nata Tech</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js for mobile menu toggle --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* NYT Style Overrides */
        .nyt-border-bottom {
            border-bottom: 1px solid #e2e2e2;
        }

        .nyt-caption {
            font-size: 0.85rem;
            color: #666;
        }

        .nyt-dropcap:first-letter {
            float: left;
            font-size: 5rem;
            line-height: 0.65;
            margin: 0.1em 0.1em 0.1em 0;
        }

        .nyt-section-label {
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.8rem;
            color: #666;
        }
    </style>
</head>

<body class="font-sans antialiased bg-white">
    {{-- Include Navbar Partial --}}
    @include('partials.navbar')

    <main class="pt-8">
        <!-- NYT Style Header with Logo -->
        <div class="border-b border-gray-200 pb-4 max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div class="nyt-section-label">INSIGHT & ARTIKEL</div>
                <div class="text-center">
                    <div class="text-3xl font-bold">Nata Tech</div>
                </div>
                <div class="text-right nyt-section-label">
                    {{ $article->published_at ? $article->published_at->format('d F Y') : $article->created_at->format('d F Y') }}
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">
            <!-- Article Title -->
            <div class="mb-8 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">{{ $article->title }}</h1>
                @if ($article->meta_description)
                    <p class="text-xl text-gray-600 mt-4 mb-6 italic">{{ $article->meta_description }}</p>
                @endif
            </div>

            <!-- Author Info -->
            <div class="flex justify-center mb-8 nyt-border-bottom pb-6">
                <div class="text-center">
                    <div class="text-sm text-gray-500 mb-1">Oleh</div>
                    <div class="font-semibold">Tim Redaksi Nata Tech</div>
                </div>
            </div>

            <!-- Featured Image with NYT Style -->
            @if ($article->featured_image)
                <figure class="mb-10">
                    <div class="aspect-w-16 aspect-h-9 overflow-hidden">
                        <img class="w-full h-auto object-cover" src="{{ asset('storage/' . $article->featured_image) }}"
                            alt="{{ $article->title }}">
                    </div>
                    <figcaption class="nyt-caption mt-2 text-center">{{ $article->title }}</figcaption>
                </figure>
            @endif

            <!-- Article Content with NYT Style -->
            <div class="text-lg leading-relaxed text-gray-800 mb-12">
                <div
                    class="nyt-dropcap prose prose-lg max-w-none prose-headings:font-serif prose-headings:font-normal prose-p:text-base prose-p:leading-relaxed">
                    {!! $article->content !!}
                </div>
            </div>

            <!-- Article Footer -->
            <div class="border-t border-gray-200 pt-8 pb-12">
                <div class="flex justify-between items-center">
                    <a href="/insight" class="text-gray-600 hover:text-gray-900 font-medium nyt-section-label">
                        ← KEMBALI KE DAFTAR ARTIKEL
                    </a>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 10.054 10.054 0 01-3.127 1.184 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Articles with NYT Style -->
        <div class="bg-gray-50 py-12">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-8 pb-2 border-b border-gray-300">Artikel Terkait</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach ($relatedArticles as $relatedArticle)
                        <div class="bg-white">
                            <div class="aspect-w-16 aspect-h-9 mb-4">
                                @if ($relatedArticle->featured_image)
                                    <img class="object-cover w-full h-48"
                                        src="{{ asset('storage/' . $relatedArticle->featured_image) }}"
                                        alt="{{ $relatedArticle->title }}">
                                @else
                                    <img class="object-cover w-full h-48" src="https://via.placeholder.com/800x450"
                                        alt="{{ $relatedArticle->title }}">
                                @endif
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 leading-tight">
                                {{ $relatedArticle->title }}</h3>
                            <p class="text-sm text-gray-500 mb-2">
                                {{ $relatedArticle->published_at ? $relatedArticle->published_at->format('d F Y') : $relatedArticle->created_at->format('d F Y') }}
                            </p>
                            <a href="/insight/{{ $relatedArticle->slug }}"
                                class="text-gray-900 hover:text-gray-700 text-sm font-medium nyt-section-label">BACA
                                ARTIKEL →</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>

    {{-- Include Footer Partial --}}
    @include('partials.footer')

</body>

</html>
