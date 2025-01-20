<x-guest-layout>
    <div class="flex min-h-screen items-center justify-center bg-gray-100 px-4 py-8 overflow-y-auto">
        <!-- Form Area -->
        <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg space-y-6">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Welcome Back</h2>
                <p class="text-sm text-gray-500">Log in to your account</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email Address')" class="text-gray-700" />
                    <x-text-input id="email" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
                    <x-text-input id="password" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 focus:ring-offset-gray-800" name="remember">
                        <span class="ms-2 text-sm text-gray-600">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline">Forgot your password?</a>
                    @endif
                </div>

                <div class="mt-6">
                    <x-primary-button class="w-full inline-flex justify-center items-center bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200">
                        {{ __('Log in') }}
                    </x-primary-button>                    
                </div>

                <div class="mt-4 text-center text-sm text-gray-600">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Sign up</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
