<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }} | Souvenir Oke Boss</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Icon -->
        <link rel="icon" type="image/png" href="{{ asset('img/icon/logo.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('img/icon/logo.png') }}">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white text-[#1b1b18] min-h-screen">
        @include('partials.navbar')
        @yield('container')
        @include('partials.footer')

        @stack('scripts')
        <script>

        </script>
    </body>
</html>
