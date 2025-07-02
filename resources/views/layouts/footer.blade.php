<footer class="bg-[#22252E] text-gray-200 py-8 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Logo & description -->
        <div>
            <a href="{{ url('/') }}" class="text-white text-2xl font-bold mb-3 inline-block">
                <i class="fa-solid fa-paperclip mr-2"></i>{{ config('app.name', 'MySite') }}
            </a>
            <p class="text-gray-400 text-sm max-w-xs">
                {{ __('messages.footer_description') }}

            </p>
             <p class="mt-5  text-sm text-gray-100">
        <a href="{{ route('terms', ['lang' => app()->getLocale()]) }}" class="underline hover:text-blue-600">{{ __('messages.terms_of_use') }}</a> |
        <a href="{{ route('privacy', ['lang' => app()->getLocale()]) }}"class="underline hover:text-blue-600">{{ __('messages.privacy_policy') }}</a>
    </p>
        </div>

        <!-- Quick Links -->
        <div>
            <h3 class="text-white font-semibold mb-4">{{ __('messages.quick_links') }}</h3>
            <ul>
                 <a href="{{ url('home/?lang=' . app()->getLocale()) }}"  class="hover:underline">{{ __('messages.home') }}</a></li>



                <li><a href="{{ route('professionals.index', ['lang' => app()->getLocale()]) }}"
                        class="hover:underline">{{ __('messages.find_professionals') }}</a></li>
                @auth
                    <li><a href="{{ route('profile.edit') }}" class="hover:underline">{{ __('messages.my_profile') }}</a>
                    </li>
                @endauth
                <li><a href="{{ route('contact', ['lang' => app()->getLocale()]) }}" class="hover:underline">{{ __('messages.contact_us') }}</a></li>
            </ul>
        </div>

        <!-- Newsletter -->
        <div>
            <h3 class="text-white font-semibold mb-4">{{ __('messages.newsletter_title') }}</h3>
            <form method="POST" action="{{ route('newsletter.subscribe') }}" class="flex flex-col sm:flex-row gap-2">
                @csrf
                <input type="email" name="email" required placeholder="{{ __('messages.email_placeholder') }}"
                    class="w-full px-3 py-2 rounded-md text-gray-900 focus:outline-none" />
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">{{ __('messages.subscribe') }}</button>
            </form>
            
            @if(session('newsletter_status'))
                <p class="mt-2 text-sm text-green-400">{{ session('newsletter_status') }}</p>
            @endif
        </div>
        
    </div>

    <div class="mt-8 border-t border-gray-700 pt-4 text-center text-gray-500 text-sm">
        &copy; {{ date('Y') }} {{ config('app.name', 'MySite') }}. {{ __('messages.all_rights_reserved') }}
    </div>
</footer>