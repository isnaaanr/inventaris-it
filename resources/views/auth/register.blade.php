<x-guest-layout>
    <div class="flex min-h-screen items-center justify-center bg-gradient-to-r from-gray-900 via-gray-800 to-gray-700 px-4 py-8 overflow-y-auto relative">

        <!-- Parallax Effect Background SVG -->
        <div class="absolute inset-0 overflow-hidden blur-3xl">
            <svg class="absolute top-0 left-0 w-full h-full text-gray-500 opacity-25" viewBox="0 0 1463 678" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill="url(#gradient)" fill-opacity=".3" d="M-28.45 318.029C-28.45 318.029 74.74 438.588 318.18 482.485C561.62 526.382 742.27 367.2 942.27 412.857C1142.27 458.515 1245.98 580.019 1463 600.005C1463 600.005 1450.66 201.56 1243.02 144.473C1035.38 87.3873 859.58 173.678 798.868 287.64C738.157 401.601 833.233 487.248 742.27 505.366C651.307 523.484 523.876 451.771 417.39 398.549C310.905 345.326 162.627 302.035 0 258.789L-28.45 318.029Z" />
                <defs>
                    <linearGradient id="gradient" x1="0" x2="1" y1="0" y2="1">
                        <stop offset="0%" stop-color="#FF00A3" />
                        <stop offset="100%" stop-color="#5800FF" />
                    </linearGradient>
                </defs>
            </svg>
        </div>

        <!-- Form Area -->
        <div class="w-full max-w-md bg-gray-800 p-8 rounded-xl shadow-xl space-y-6 relative z-10">
            <div class="text-center mb-6">
                <h2 class="text-3xl font-semibold text-white tracking-wide">Create Account</h2>
                <p class="text-sm text-gray-400">Register a new account</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" class="text-gray-300" />
                    <x-text-input id="name" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                  type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-500" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" class="text-gray-300" />
                    <x-text-input id="email" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                  type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" class="text-gray-300" />
                    <x-text-input id="password" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                  type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-300" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                  type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-500" />
                </div>

                <div class="flex items-center justify-between mt-6">
                    <a href="{{ route('login') }}" class="text-sm text-indigo-400 hover:underline">
                        {{ __('Already registered?') }}
                    </a>
                    <x-primary-button class="ms-4 bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 rounded-full shadow-md transform hover:scale-110 transition-all duration-300 ease-in-out hover:shadow-2xl focus:ring-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
