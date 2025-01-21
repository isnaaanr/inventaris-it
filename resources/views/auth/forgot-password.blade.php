<x-guest-layout>
    <div class="flex min-h-screen items-center justify-center bg-gradient-to-r from-gray-900 via-gray-800 to-gray-700 px-4 py-8 relative">
        
        <!-- Parallax Effect Background SVG -->
        <div class="absolute inset-0 overflow-hidden blur-3xl opacity-20">
            <svg class="absolute top-0 left-0 w-full h-full text-gray-500" viewBox="0 0 1463 678" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill="url(#darkGradient)" fill-opacity=".3" d="M-28.45 318.029C-28.45 318.029 74.74 438.588 318.18 482.485C561.62 526.382 742.27 367.2 942.27 412.857C1142.27 458.515 1245.98 580.019 1463 600.005C1463 600.005 1450.66 201.56 1243.02 144.473C1035.38 87.3873 859.58 173.678 798.868 287.64C738.157 401.601 833.233 487.248 742.27 505.366C651.307 523.484 523.876 451.771 417.39 398.549C310.905 345.326 162.627 302.035 0 258.789L-28.45 318.029Z" />
                <defs>
                    <linearGradient id="darkGradient" x1="1.21209" x2="1.91299" y1="0.2" y2="1" gradientUnits="userSpaceOnUse">
                        <stop offset="0%" stop-color="#111827" />
                        <stop offset="100%" stop-color="#374151" />
                    </linearGradient>
                </defs>
            </svg>
        </div>

        <!-- Form Container -->
        <div class="w-full max-w-md bg-gray-900 p-8 rounded-xl shadow-2xl backdrop-blur-md bg-opacity-90 space-y-6">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-semibold text-white">Forgot Password</h2>
                <p class="text-sm text-gray-400">Enter your email to reset your password</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Form -->
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-300" />
                    <x-text-input id="email" class="block mt-1 w-full bg-gray-800 border-gray-700 text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                        type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
                </div>

                <div class="flex items-center justify-end mt-6">
                    <x-primary-button class="w-full bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-gray-800 rounded-full shadow-md transform hover:scale-105 transition-all duration-300 ease-in-out focus:ring-4">
                        {{ __('Send Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
