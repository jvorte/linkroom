<x-guest-layout>
    <div class="max-w-md mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-center mb-6">Log in</h1>
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                              type="password"
                              name="password"
                              required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button class="ms-3">
                    {{ __('Log in') }}
                </x-primary-button> 
            </div>
        </form>

<div class="mt-6 text-center">
    <a href="{{ route('auth.google') }}"
       class="px-4 py-2 inline-flex items-center justify-center gap-2 mx-auto bg-white border border-gray-300 rounded shadow hover:bg-gray-100">
        <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h6.13a5.24 5.24 0 0 1-2.26 3.44v2.86h3.66c2.14-1.97 3.38-4.88 3.38-8.31z"/>
            <path fill="#34A853" d="M12 23c2.43 0 4.48-.8 5.97-2.17l-3.66-2.86c-1.02.68-2.34 1.08-3.99 1.08-3.06 0-5.65-2.07-6.58-4.84H2.56v3.04A11 11 0 0 0 12 23z"/>
            <path fill="#FBBC05" d="M5.42 14.21a6.57 6.57 0 0 1 0-4.42V6.75H2.56a11 11 0 0 0 0 10.5l2.86-3.04z"/>
            <path fill="#EA4335" d="M12 5.44c1.33 0 2.52.46 3.46 1.36l2.6-2.6C16.46 2.85 14.42 2 12 2A11 11 0 0 0 2.56 6.75l2.86 3.04c.93-2.77 3.52-4.84 6.58-4.84z"/>
            <path fill="none" d="M0 0h24v24H0z"/>
        </svg>
        Login with Google
    </a>
</div>


    </div>
</x-guest-layout>
