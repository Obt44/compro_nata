<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Nata Tech - Company Profile</title> {{-- Updated Title --}}

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Alpine.js for mobile menu toggle --}}
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">

        {{-- Include Navbar Partial --}}
        @include('partials.navbar')

        {{-- Include Hero Section Partial --}}
        @include('partials.hero')

        {{-- You can add more sections/partials here as needed --}}

        {{-- Element untuk me-render komponen React --}}
        <div id="react-example-component"></div>

        {{-- Include Footer Partial --}}
        @include('partials.footer')
        
    </body>
</html>
