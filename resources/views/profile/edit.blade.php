<x-app-layout>

    <div class="relative h-64 overflow-hidden shadow-lg mb-8">
        <img src="{{ asset('storage/images/prof10.jpg') }}" alt="Header background" class="absolute inset-0 w-full h-full object-cover brightness-75">
        <div class="relative z-10 flex flex-col items-center justify-center h-full text-white text-center">
            <h1 class="text-5xl font-bold">{{ __('messages.profile') }}</h1>
            <p class="mt-2 text-xl">{{ __('messages.discover_profile') }}</p>
        </div>
    </div>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-3xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
