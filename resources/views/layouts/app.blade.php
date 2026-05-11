<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Custom Styles -->
        <link rel="stylesheet" href="{{ asset('style.css') }}">
    </head>
    <body class="font-sans antialiased min-h-screen" style="background: var(--bg-main); color: var(--text-primary);">
        @include('layouts.header', ['fixed' => true])
        <div class="min-h-screen flex flex-col">
            <!-- Page Heading -->
            @isset($header)
                <header style="background: var(--bg-card); border-bottom: 1px solid var(--border); box-shadow: var(--shadow-sm);">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1 pt-4">
                {{ $slot }}
            </main>
            @include('layouts.footer', ['fixed' => true])
        </div>
        <script src="{{ asset('script.js') }}"></script>
    </body>
</html>
