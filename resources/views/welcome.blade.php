<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Juegos Vikingos - Punto de Venta</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-900 selection:bg-red-500 selection:text-white">

        @if (Route::has('login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-400 hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-400 hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Iniciar Sesión</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-400 hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Registrarse</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center flex-col items-center">
                <img src="/img/vikingo sin fondo tex. blanco.png" alt="logo" class="h-32 w-32">
                <h1 class="text-5xl font-bold text-white">Juegos Vikingos</h1>
                <p class="mt-2 text-2xl text-gray-400">Punto de Venta TCG</p>
            </div>

            <div class="mt-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                    
                    <div class="scale-100 p-6 bg-gray-800/50 bg-gradient-to-t from-gray-700/50 to-transparent rounded-lg shadow-2xl shadow-gray-500/20 flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <img src="https://p4.wallpaperbetter.com/wallpaper/983/423/759/magic-the-gathering-trading-card-games-wallpaper-preview.jpg" alt="Magic: The Gathering" class="h-40 w-full object-cover rounded-lg">
                            <h2 class="mt-4 text-xl font-semibold text-white">Magic: The Gathering</h2>
                            <p class="mt-2 text-gray-400">Gestiona tu inventario del TCG más popular.</p>
                        </div>
                    </div>

                    <div class="scale-100 p-6 bg-gray-800/50 bg-gradient-to-t from-gray-700/50 to-transparent rounded-lg shadow-2xl shadow-gray-500/20 flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <img src="https://img.asmedia.epimg.net/resizer/v2/WDTLSQ65NBFEJFOZCFBFA4W24Y.jpg?auth=7e6187835c997de37c74b2d968bc8fe2e293e20afb8205e6ffddef849c87437c&width=644&height=362&smart=true" alt="Pokémon TCG" class="h-40 w-full object-cover rounded-lg">
                            <h2 class="mt-4 text-xl font-semibold text-white">Pokémon TCG</h2>
                            <p class="mt-2 text-gray-400">Registra tus ventas de cartas Pokémon.</p>
                        </div>
                    </div>

                    <div class="scale-100 p-6 bg-gray-800/50 bg-gradient-to-t from-gray-700/50 to-transparent rounded-lg shadow-2xl shadow-gray-500/20 flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <img src="https://blog.myl.cl/wp-content/uploads/2025/08/image-5-1024x572.png" alt="Mitos y Leyendas" class="h-40 w-full object-cover rounded-lg">
                            <h2 class="mt-4 text-xl font-semibold text-white">Mitos y Leyendas</h2>
                            <p class="mt-2 text-gray-400">Control de stock para Mitos y Leyendas.</p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">
                <div class="text-center text-sm text-gray-500 sm:text-left">
                    Juegos Vikingos &copy; {{ date('Y') }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
