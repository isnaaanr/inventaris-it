<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('Inventory-IT', 'Inventory IT') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        {{-- Icon --}}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
        <link rel="icon" href="{{ asset('inventory.png') }}" type="image/x-icon">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    </head>
    <body>
        <div class="min-h-screen">
            
            <!-- Navbar -->
            <nav class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 shadow-lg mb-5 border-b border-gray-700 backdrop-blur-lg bg-opacity-90">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center gap-x-4">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                                <i class="fas fa-boxes text-yellow-400 text-2xl"></i>
                                <span class="text-xl font-bold text-white tracking-wide">Inventory IT</span>
                            </a>
                        </div>
            
                        <!-- Navigation Links -->
                        <div class="hidden md:flex space-x-6">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-white hover:text-yellow-400 transition-all duration-300 ease-in-out transform hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11M9 21V3m4 10h4m-4 6h4" />
                                </svg>
                                Dashboard
                            </a>
                            @if(Route::has('barang'))
                            <a href="{{ route('barang') }}" class="flex items-center gap-2 text-white hover:text-yellow-400 transition-all duration-300 ease-in-out transform hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 21V8H8v13m0 0H4a2 2 0 01-2-2V5a2 2 0 012-2h16a2 2 0 012 2v13a2 2 0 01-2 2H8z" />
                                </svg>
                                Barang
                            </a>
                            @endif
                            @if(Route::has('peminjaman.index'))
                            <a href="{{ route('peminjaman.index') }}" class="flex items-center gap-2 text-white hover:text-yellow-400 transition-all duration-300 ease-in-out transform hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16s2 0 4-2 4 0 8-4m4 0s2 0 4-2m-6 6s2 0 4-2" />
                                </svg>
                                Peminjaman
                            </a>
                            @endif
                            @if(Route::has('riwayat'))
                            <a href="{{ route('riwayat') }}" class="flex items-center gap-2 text-white hover:text-yellow-400 transition-all duration-300 ease-in-out transform hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16v-4a2 2 0 012-2h4a2 2 0 012 2v4m-8 0h8m-8 0a2 2 0 012-2h4a2 2 0 012 2" />
                                </svg>
                                Riwayat
                            </a>
                            @endif
                        </div>
            
                        <!-- User Dropdown -->
                        <div class="hidden md:flex items-center space-x-4">
                            <span class="text-white font-semibold">{{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}" onsubmit="return confirmLogout(event);">
                                @csrf
                                <button type="submit" class="text-white font-bold hover:text-red-500 transition-all duration-300 ease-in-out transform hover:scale-110">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
            
            

            <!-- Page Heading -->
            {{-- @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow-md">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset --}}

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script>
            document.getElementById('menu-toggle').addEventListener('click', () => {
                const menu = document.getElementById('mobile-menu');
                menu.classList.toggle('hidden');
            });

            function confirmLogout(event) {
            return confirm("Apakah Anda yakin ingin logout?");
        }
        </script>
    </body>
</html>
