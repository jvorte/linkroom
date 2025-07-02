<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('messages.update_password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('messages.ensure_your_account') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
           <x-input-label for="current_password" :value="__('messages.current_password')" />
            <x-text-input id="current_password" name="current_password" type="password"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-400"
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div>
           <x-input-label for="password" :value="__('messages.new_password')" />
            <x-text-input id="password" name="password" type="password"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-400"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
           <x-input-label for="password_confirmation" :value="__('messages.confirm_password')" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-400"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit -->
        <div class="flex items-center gap-4">
         <x-primary-button>{{ __('messages.save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
            <p x-data="{ show: true }" x-show="show" x-transition
   x-init="setTimeout(() => show = false, 2000)"
   class="text-sm text-gray-600">{{ __('messages.saved') }}</p>
            @endif
        </div>
    </form>
</section>
