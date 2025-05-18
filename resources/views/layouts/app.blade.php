<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-[#CAE9FF] to-[#A6D4FF] min-h-screen flex flex-col">
        <div class="flex-1">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white/80 shadow rounded-b-2xl mx-auto max-w-7xl mt-6">
                    <div class="py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="max-w-7xl mx-auto mt-8 p-6 md:p-10 bg-white/80 rounded-2xl shadow-lg">
                {{ $slot }}
            </main>
        </div>
        <footer class="h-[20vh] relative mt-10">
            <img src="/img/footer.jpg" alt=""
                class="object-center object-cover w-full h-full absolute blur-sm brightness-75">
            <div class="h-full w-full bg-[#00000075] z-10 relative grid grid-cols-2 text-white text-xl pt-10">
                <div class="text-right p-4 border-r-4 border-white h-2/3 pt-7">
                    @auth
                    <a href="{{ url('/dashboard') }}" class="hover:underline">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="hover:underline">Log in</a> <br>
                    <a href="{{ route('register') }}" class="hover:underline">Register</a>
                    @endauth
                </div>
                <div class="p-4 h-2/3">
                    <h2 class="text-2xl font-bold">Contact</h2>
                    <ul>
                        <li>Tel: 06 1234 4567 89</li>
                        <li>Email: windkracht12@mail.com</li>
                    </ul>
                </div>
            </div>
        </footer>
    </body>
</html>