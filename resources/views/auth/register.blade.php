<x-guest-layout>
        <div class="max-w-lg mx-auto px-2 py-6">
        <h1 class="text-2xl font-bold text-center mb-6">Register</h1>
    <form method="POST" action="{{ route('register') }}" class="max-w-lg mx-auto px-4">
        @csrf

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
        <div class="mb-4">
            <label for="bio" class="block mb-1 font-medium text-gray-700">Bio</label>
            <textarea name="bio" id="bio" rows="3" 
                class="block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('bio') }}</textarea>
        </div>

        <!-- Public Email -->
        <div class="mb-4">
            <label for="public_email" class="block mb-1 font-medium text-gray-700">Public Email</label>
            <input type="email" name="public_email" id="public_email" value="{{ old('public_email') }}"
                class="block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        </div>

        <!-- Phone -->
        <div class="mb-4">
            <label for="phone" class="block mb-1 font-medium text-gray-700">Phone</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                class="block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        </div>

        <div>

            <!-- country -->
    <label for="country" class="block font-semibold">{{ __('messages.country') }}</label>
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
</div>


        {{-- <!-- Categories in 2 columns -->
        <div class="mb-4">
            <label class="block mb-2 font-semibold">Επιλέξτε κατηγορίες:</label>
            <div class="grid grid-cols-2 gap-4 max-h-48 overflow-y-auto border border-gray-300 rounded p-3">
                @foreach($categories as $category)
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                            {{ (is_array(old('categories')) && in_array($category->id, old('categories'))) ? 'checked' : '' }}
                            class="form-checkbox h-5 w-5 text-indigo-600">
                        <span class="text-gray-700">{{ $category->name }}</span>
                    </label>
                @endforeach
            </div>
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

        <div class="flex items-center justify-end mt-4 space-x-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button>
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
     </div>
</x-guest-layout>
