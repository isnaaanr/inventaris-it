<x-guest-layout>
    <div class="flex min-h-screen items-center justify-center bg-gradient-to-r from-gray-900 via-gray-800 to-gray-700 px-4 py-8 overflow-y-auto relative">

        <!-- Parallax Effect Background SVG -->
        <div class="absolute inset-0 overflow-hidden blur-3xl">
            <svg class="absolute top-0 left-0 w-full h-full text-yellow-500" viewBox="0 0 1463 678" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill="url(#d1e554d4-7f5e-4a4d-b7e4-bc6b431b0d1c)" fill-opacity=".3" d="M-28.45 318.029C-28.45 318.029 74.74 438.588 318.18 482.485C561.62 526.382 742.27 367.2 942.27 412.857C1142.27 458.515 1245.98 580.019 1463 600.005C1463 600.005 1450.66 201.56 1243.02 144.473C1035.38 87.3873 859.58 173.678 798.868 287.64C738.157 401.601 833.233 487.248 742.27 505.366C651.307 523.484 523.876 451.771 417.39 398.549C310.905 345.326 162.627 302.035 0 258.789L-28.45 318.029Z" />
                <defs>
                    <linearGradient id="d1e554d4-7f5e-4a4d-b7e4-bc6b431b0d1c" x1="1.21209" x2="1.91299" y1="0.2" y2="1" gradientUnits="userSpaceOnUse">
                        <stop offset="0%" stop-color="#FFD700" />
                        <stop offset="100%" stop-color="#FFEA00" />
                    </linearGradient>
                </defs>
            </svg>            
        </div>

        <!-- Form Area -->
        <div class="w-full max-w-md bg-gray-800 p-8 rounded-xl shadow-xl space-y-6 animate__animated animate__fadeIn animate__fast">
            <div class="text-center mb-6">
                <h2 class="text-3xl font-semibold text-white tracking-wide mb-2">
                    Welcome Back
                </h2>
                <p class="text-sm text-gray-400">Log in to your account</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-6">
                    <x-input-label for="email" :value="__('Email Address')" class="text-gray-300" />
                    <x-text-input id="email" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm transition-all duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <x-input-label for="password" :value="__('Password')" class="text-gray-300" />
                    <x-text-input id="password" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm transition-all duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-6">
                    <label for="remember_me" class="inline-flex items-center text-gray-300">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-600 text-indigo-600 shadow-sm focus:ring-indigo-500 focus:ring-offset-gray-800" name="remember">
                        <span class="ms-2 text-sm text-gray-400">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-400 hover:underline">Forgot your password?</a>
                    @endif
                </div>

                <div class="mt-6">
                    <x-primary-button class="w-full inline-flex justify-center items-center bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 rounded-full shadow-md transform hover:scale-110 transition-all duration-300 ease-in-out hover:shadow-2xl focus:ring-4">
                        <span class="flex items-center justify-center">Log in</span>
                    </x-primary-button>
                </div>

                <div class="mt-4 text-center text-sm text-gray-400">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-indigo-400 hover:underline">Sign up</a>
                </div>
            </form>
        </div>
        
    </div>
</x-guest-layout>
