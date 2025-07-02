<x-app-layout>


        <div class="relative h-60 md:h-66 overflow-hidden shadow mb-12">
        <img src="{{ asset('storage/images/3.jpg') }}" alt="Banner" class="absolute inset-0 w-full h-full object-cover brightness-75">
        <div class="absolute inset-0 bg-gradient-to-b from-black/50 to-transparent"></div>
        <div class="relative z-10 flex flex-col items-center justify-center h-full text-white text-center px-6 md:px-12">
            <h1 class="text-5xl font-bold">{{ __('messages.welcome_title') }}</h1>
            <p class="mt-3 text-xl">{{ __('messages.welcome_subtitle') }}</p>
        </div>
    </div>

        <div class="max-w-3xl mx-auto px-4 py-6">
        
    <h1 class="text-2xl font-bold mb-4">{{ __('messages.privacy_policy') }}</h1>
    <p>{!! nl2br(e(__('messages.privacy_policy_full'))) !!}</p>
    
    </div>   

</x-app-layout>
