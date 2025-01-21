<x-guest-layout>
    <div class="relative min-h-screen bg-gradient-to-r from-gray-900 via-black to-gray-900 flex flex-col items-center justify-center px-4 py-8 text-white overflow-hidden">
        
        <!-- Background Blur Effect -->
        <div class="absolute inset-0 bg-gray-900 opacity-40 backdrop-blur-2xl"></div>

        <!-- SVG Background Animation -->
        <svg class="absolute top-0 left-0 w-full h-full opacity-10">
            <circle cx="8%" cy="15%" r="100" fill="white" class="opacity-20 animate-random-1" />
            <circle cx="45%" cy="25%" r="140" fill="white" class="opacity-10 animate-random-2" />
            <circle cx="80%" cy="40%" r="90" fill="white" class="opacity-15 animate-random-3" />
            <circle cx="20%" cy="75%" r="110" fill="white" class="opacity-10 animate-random-4" />
            <circle cx="70%" cy="85%" r="130" fill="white" class="opacity-20 animate-random-5" />
        </svg>

        <!-- Container -->
        <div class="relative w-full max-w-3xl bg-black bg-opacity-60 text-white p-10 rounded-xl shadow-2xl overflow-hidden transform transition duration-500 ease-in-out hover:scale-105 hover:shadow-[0px_0px_30px_rgba(255,255,255,0.3)]">
            
            <!-- Animated Background Gradient -->
            <div class="absolute inset-0 bg-gradient-to-r from-gray-700 to-gray-800 opacity-20 blur-3xl"></div>

            <!-- Floating Glow Effect -->
            <div class="absolute -top-16 left-20 w-40 h-40 bg-indigo-500 rounded-full opacity-20 blur-3xl animate-random-1"></div>
            <div class="absolute bottom-16 right-28 w-50 h-50 bg-purple-500 rounded-full opacity-20 blur-3xl animate-random-2"></div>
            <div class="absolute top-32 right-10 w-35 h-35 bg-pink-500 rounded-full opacity-20 blur-3xl animate-random-3"></div>

            <!-- Content -->
            <div class="relative z-10 text-center">
                <h1 class="text-5xl font-bold leading-tight mb-6 text-white drop-shadow-glow animate__animated animate__fadeIn animate__delay-1s">
                    Welcome to Inventory IT FKUI
                </h1>
                <p class="text-xl mb-8 text-gray-300 animate__animated animate__fadeIn animate__delay-2s">
                    Tempat terbaik untuk mengelola inventaris Anda dengan mudah dan cepat.
                </p>

                <div class="flex justify-center space-x-8 mt-8">
                    <!-- Login Button -->
                    <a href="{{ route('login') }}" class="px-8 py-4 border-2 border-white text-white rounded-full text-xl font-medium shadow-xl hover:bg-white hover:text-black transform hover:scale-110 transition duration-300 ease-in-out hover:shadow-[0px_0px_20px_rgba(255,255,255,0.5)]">
                        Log In
                    </a>

                    <!-- Register Button -->
                    <a href="{{ route('register') }}" class="px-8 py-4 border-2 border-white text-white rounded-full text-xl font-medium shadow-xl hover:bg-white hover:text-black transform hover:scale-110 transition duration-300 ease-in-out hover:shadow-[0px_0px_20px_rgba(255,255,255,0.5)]">
                        Sign Up
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer / Additional Text -->
        <div class="absolute bottom-10 text-white text-sm">
            <p>&copy; 2025 Inventory IT | All Rights Reserved</p>
        </div>
    </div>

    <!-- Tailwind Blob Animation -->
    <style>
        @keyframes random-1 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(10px, -20px); }
        }
        @keyframes random-2 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-15px, 25px); }
        }
        @keyframes random-3 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20px, -10px); }
        }
        @keyframes random-4 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-10px, 30px); }
        }
        @keyframes random-5 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(15px, -15px); }
        }

        .animate-random-1 { animation: random-1 6s infinite ease-in-out; }
        .animate-random-2 { animation: random-2 7s infinite ease-in-out; }
        .animate-random-3 { animation: random-3 5s infinite ease-in-out; }
        .animate-random-4 { animation: random-4 8s infinite ease-in-out; }
        .animate-random-5 { animation: random-5 6.5s infinite ease-in-out; }

        .drop-shadow-glow {
            text-shadow: 0px 0px 10px rgba(255, 255, 255, 0.6);
        }
    </style>

</x-guest-layout>
