<x-guest-layout>
    <div class="max-w-lg mx-auto px-2 py-6">
        <h1 class="text-2xl font-bold text-center mb-6">Register</h1>
        <form method="POST" action="{{ route('register') }}" class="max-w-lg mx-auto px-4">
            @csrf

            {{-- <div class="mt-6 text-center">
                <a href="{{ route('auth.google') }}"
                    class="px-4 py-2 inline-flex items-center justify-center gap-2 mx-auto bg-white border border-gray-300 rounded shadow hover:bg-gray-100">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                        focusable="false">
                        <path fill="#4285F4"
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h6.13a5.24 5.24 0 0 1-2.26 3.44v2.86h3.66c2.14-1.97 3.38-4.88 3.38-8.31z" />
                        <path fill="#34A853"
                            d="M12 23c2.43 0 4.48-.8 5.97-2.17l-3.66-2.86c-1.02.68-2.34 1.08-3.99 1.08-3.06 0-5.65-2.07-6.58-4.84H2.56v3.04A11 11 0 0 0 12 23z" />
                        <path fill="#FBBC05"
                            d="M5.42 14.21a6.57 6.57 0 0 1 0-4.42V6.75H2.56a11 11 0 0 0 0 10.5l2.86-3.04z" />
                        <path fill="#EA4335"
                            d="M12 5.44c1.33 0 2.52.46 3.46 1.36l2.6-2.6C16.46 2.85 14.42 2 12 2A11 11 0 0 0 2.56 6.75l2.86 3.04c.93-2.77 3.52-4.84 6.58-4.84z" />
                        <path fill="none" d="M0 0h24v24H0z" />
                    </svg>
                    Register with Google
                </a>
            </div> --}}


            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name"
                    class="block mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email"
                    class="block mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Bio -->
            {{-- <div class="mb-4">
                <label for="bio" class="block mb-1 font-medium text-gray-700">Bio</label>
                <textarea name="bio" id="bio" rows="3"
                    class="block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('bio') }}</textarea>
            </div> --}}

            <!-- Public Email -->
            {{-- <div class="mb-4">
                <label for="public_email" class="block mb-1 font-medium text-gray-700">Public Email</label>
                <input type="email" name="public_email" id="public_email" value="{{ old('public_email') }}"
                    class="block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div> --}}

            <!-- Phone -->
            {{-- <div class="mb-4">
                <label for="phone" class="block mb-1 font-medium text-gray-700">Phone</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                    class="block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div> --}}

            <div>

                <!-- country -->
                {{-- <label for="country" class="block font-semibold">{{ __('messages.country') }}</label>
                <select name="country" id="country" required class="w-full border rounded px-3 py-2">
                    <option value="">{{ __('messages.select_country') }}</option>
                    <option value="UK">England</option>
                    <option value="GR">Greece</option>
                    <option value="CH">Switzerland</option>
                    <option value="DE">Germany</option>
                    <option value="AT">Austria</option>
                    <option value="OTHER">Οther Countries</option>
                    <!-- πρόσθεσε όσες χώρες θέλεις -->
                </select>
                @error('country') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div> --}}




            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password"
                    class="block mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation"
                    class="block mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>


            <div class="mt-4">
                <label class="inline-flex items-start">
                    <input type="checkbox" name="consent" required class="mt-1">
                    <span class="ml-2 text-sm text-gray-700">
                        {{ __('messages.i_consent_to_data_processing') }}
                         <a href="{{ route('privacy', ['lang' => app()->getLocale()]) }}"class="underline hover:text-blue-600">{{ __('messages.privacy_policy') }}</a>.
                    </span>
                </label>
                @error('consent')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>




            <div class="flex items-center justify-end mt-4 space-x-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button>
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>