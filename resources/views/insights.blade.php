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
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">Temukan informasi terbaru seputar teknologi dan
                    transformasi digital.</p>
            </div>

            <div class="flex flex-col md:flex-row gap-8">
                <!-- Sidebar -->
                <div class="w-full md:w-1/4">
                    <div class="bg-white rounded-lg shadow-md p-6 md:sticky md:top-24">
                        <!-- Search Form -->
                        <form action="{{ route('insights.index') }}" method="GET" class="mb-8">
                            <div class="mb-4">
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari
                                    Artikel</label>
                                <div class="relative">
                                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="Cari artikel...">
                                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Date Range Filter -->
                            <div class="space-y-4">
                                <h3 class="font-medium text-gray-900">Filter Waktu</h3>
                                <div class="space-y-2">
                                    <label for="start_date" class="block text-sm text-gray-600">Dari Tanggal</label>
                                    <input type="date" id="start_date" name="start_date"
                                        value="{{ request('start_date') }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div class="space-y-2">
                                    <label for="end_date" class="block text-sm text-gray-600">Sampai Tanggal</label>
                                    <input type="date" id="end_date" name="end_date"
                                        value="{{ request('end_date') }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>

                            <!-- Categories -->
                            @if (isset($categories) && count($categories) > 0)
                                <div class="mt-8">
                                    <h3 class="font-medium text-gray-900 mb-4">Kategori</h3>
                                    <div class="space-y-2">
                                        @foreach ($categories as $category)
                                            <div class="flex items-center">
                                                <input type="checkbox" id="category_{{ $category->id }}"
                                                    name="categories[]" value="{{ $category->id }}"
                                                    {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}
                                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                <label for="category_{{ $category->id }}"
                                                    class="ml-2 text-sm text-gray-700">
                                                    {{ $category->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <button type="submit"
                                class="w-full mt-6 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Terapkan Filter
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="w-full md:w-3/4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($articles as $article)
                            <article class="bg-white rounded-lg shadow-md overflow-hidden h-full flex flex-col">
                                <div class="aspect-w-16 aspect-h-9">
                                    @if ($article->featured_image)
                                        <img class="object-cover w-full h-48"
                                            src="{{ asset('storage/' . $article->featured_image) }}"
                                            alt="{{ $article->title }}">
                                    @else
                                        <img class="object-cover w-full h-48" src="https://via.placeholder.com/800x450"
                                            alt="{{ $article->title }}">
                                    @endif
                                </div>
                                <div class="p-4 flex flex-col flex-grow">
                                    @if ($article->category)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 mb-4">
                                            {{ $article->category->name }}
                                        </span>
                                    @endif
                                    <div class="flex items-center text-sm text-gray-500 mb-2">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                        {{ $article->title }}</h3>
                                    <p class="text-gray-600 mb-4 flex-grow line-clamp-3">
                                        {{ $article->meta_description ?? Str::limit(strip_tags($article->content), 150) }}
                                    </p>
                                    <a href="/insight/{{ $article->slug }}"
                                        class="text-blue-600 hover:text-blue-800 font-medium mt-auto">Baca selengkapnya
                                        →</a>
                                </div>
                            </article>
                        @empty
                            <div class="col-span-full bg-white rounded-lg shadow-md p-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada artikel</h3>
                                <p class="mt-2 text-gray-500">Belum ada artikel yang dipublikasikan atau sesuai dengan
                                    filter yang dipilih.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-10">
                        {{ $articles->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- Include Footer Partial --}}
    @include('partials.footer')

    @include('partials.whatsapp', [
        'wa_number' => \App\Models\Content::where('type', 'contact')->first()->wa_number ?? null,
    ])
</body>

</html>
