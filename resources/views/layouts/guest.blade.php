<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    
    <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-cover bg-center"
         style="background-image: url('img/Captura de pantalla 2025-11-10 202814.png');"> 
         <div class="absolute inset-0 bg-gradient-to-b from-black/70 to-black/90"></div>

        <div class="relative z-10 flex flex-col items-center">
            
            <div>
                <a href="/" class="flex flex-col items-center">
                    <img src="{{ asset('img/vikingo sin fondo tex. blanco.png') }}" alt="logo" class="h-32 w-32 ">
                    <h1 class="text-4xl font-bold text-white mt-2"> Mi Tienda
                    </h1>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white/90 shadow-md overflow-hidden sm:rounded-lg backdrop-blur-sm">
                {{ $slot }}
            </div>

        </div>
    </div>
</body>

</html>