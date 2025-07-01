<x-app-layout>
    <div class="relative h-80 md:h-96 overflow-hidden shadow mb-12">
        <img src="{{ asset('storage/images/prof3.jpg') }}" alt="Banner" class="absolute inset-0 w-full h-full object-cover brightness-75">
        <div class="absolute inset-0 bg-gradient-to-b from-black/50 to-transparent"></div>
        <div class="relative z-10 flex flex-col items-center justify-center h-full text-white text-center px-6 md:px-12">
            <h1 class="text-5xl font-bold">{{ __('messages.welcome_title') }}</h1>
            <p class="mt-3 text-xl">{{ __('messages.welcome_subtitle') }}</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        <!-- Section 1 -->
        <div class="text-center">
            <h2 class="text-3xl font-semibold text-gray-900">{{ __('messages.section_discover_title') }}</h2>
            <p class="mt-2 text-lg text-gray-600">{{ __('messages.section_discover_sub') }}</p>
        </div>

        <!-- Section 2 -->
        <div class="grid md:grid-cols-3 gap-8 text-center">
            <div class="p-6 bg-white rounded shadow hover:shadow-lg hover:-translate-y-1 transition-transform duration-300">
                <i class="fa-solid fa-magnifying-glass text-3xl text-blue-600 mb-3"></i>
                <h3 class="font-bold text-xl mb-1">{{ __('messages.card_search') }}</h3>
                <p class="text-sm text-gray-600">{{ __('messages.card_search_text') }}</p>
            </div>

            <div class="p-6 bg-white rounded shadow hover:shadow-lg hover:-translate-y-1 transition-transform duration-300">
                <i class="fa-solid fa-user-check text-3xl text-blue-600 mb-3"></i>
                <h3 class="font-bold text-xl mb-1">{{ __('messages.card_verify') }}</h3>
                <p class="text-sm text-gray-600">{{ __('messages.card_verify_text') }}</p>
            </div>

            <div class="p-6 bg-white rounded shadow hover:shadow-lg hover:-translate-y-1 transition-transform duration-300">
                <i class="fa-solid fa-globe text-3xl text-blue-600 mb-3"></i>
                <h3 class="font-bold text-xl mb-1">{{ __('messages.card_connect') }}</h3>
                <p class="text-sm text-gray-600">{{ __('messages.card_connect_text') }}</p>
            </div>
        </div>

        <!-- CTA -->
        <div class="text-center m-12 ">
            <a href="{{ route('professionals.index') }}"
               aria-label="{{ __('messages.explore_now') }}"
               class="inline-block bg-slate-800 hover:bg-slate-900 text-white text-lg font-semibold py-2 px-6 rounded-md transition">
                {{ __('messages.explore_now') }}
            </a>
        </div>
    </div>
</x-app-layout>
