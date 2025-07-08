<nav class="bg-[#eaeaea] text-black p-1 border-b border-gray-200" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Αριστερό μέρος: Logo + Menu -->
            <div class="flex items-center space-x-10 ">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center space-x-2">
                    <a href="{{ url('/?lang=' . app()->getLocale()) }}" class="inline-flex items-center">
                        {{-- <i class="fa-solid fa-paperclip text-2xl text-gray-600"></i> --}}
                        <img src="{{ asset('storage/icons/paperclip.png') }}" alt="{{ __('messages.logo_alt') }}"
                            class="h-10 w-auto ml-2">
                        <img src="{{ asset('storage/images/back.png') }}" alt="{{ __('messages.logo_alt') }}"
                            class="h-10 w-auto ">
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden sm:flex sm:space-x-2">
                    <a href="{{ url('home/?lang=' . app()->getLocale()) }}"
                        class="inline-flex text-base  items-center px-1 pt-1 border-b-2 border-transparent  text-gray-800 hover:border-stone-500 hover:text-gray-700">
                        <i class="fa-solid fa-house-chimney mr-1 text-sm"></i>
                        {{ __('messages.home') }}
                    </a>

                    <a href="{{ route('professionals.index', ['lang' => app()->getLocale()]) }}"
                        class="inline-flex text-base  items-center px-1 pt-1 border-b-2 border-transparent  text-gray-800 hover:border-stone-500 hover:text-gray-700">
                        <i class="fa-solid fa-user-doctor mr-1"></i>
                        {{ __('messages.find_professionals') }}
                    </a>

                    @auth
                        <a href="{{ route('profile.edit', ['lang' => app()->getLocale()]) }}"
                            class="inline-flex text-base  items-center px-1 pt-1 border-b-2 border-transparent text-gray-800 hover:border-stone-500 hover:text-gray-700">
                            <i class="fa-solid fa-address-card mr-1"></i>
                            {{ __('messages.my_profile') }}
                        </a>
                    @endauth

                    <a href="{{ route('contact', ['lang' => app()->getLocale()]) }}"
                        class="inline-flex text-base  items-center px-1 pt-1 border-b-2 border-transparent  text-gray-800 hover:border-stone-500 hover:text-gray-700">
                        <i class="fa-solid fa-address-card mr-1"></i>
                        {{ __('messages.contact') }}
                    </a>

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.index', ['lang' => app()->getLocale()]) }}"
                                class="inline-flex text-base  items-center px-1 pt-1 border-b-2 border-transparent font-medium text-gray-800 hover:border-stone-500 hover:text-gray-700">
                                <i class="fa-solid fa-user-tie"></i>
                                {{ __('messages.admin') }}
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Δεξί μέρος: User info + Language switcher -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-4">
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" type="button"
                            class="max-w-xs bg-white flex items-center text-base rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            id="user-menu-button" :aria-expanded="open.toString()" aria-haspopup="true">
                            <span class="sr-only">{{ __('messages.open_user_menu') }}</span>
                            <div class="flex items-center space-x-2 p-1">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar"
                                        class="w-8 h-8 rounded-full">
                                @else
                                    <div
                                        class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-700 text-sm">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span class="px-3 font-medium">{{ Auth::user()->name }}</span>
                            </div>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition
                            class="z-50 origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5"
                            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <a href="{{ route('profile.edit', ['lang' => app()->getLocale()]) }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                {{ __('messages.edit_profile') }}
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    {{ __('messages.logout') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth

                @guest
                    <div class="flex space-x-2">
                         <a href="{{ route('login', ['lang' => app()->getLocale()]) }}"
                            class="inline-block px-5 py-1.5 text-[#1b1b18] hover:border-[#19140035] rounded-sm text-base  leading-normal">
                            {{ __('messages.login') }}
                        </a>
                        @if (Route::has('register'))
                           <a href="{{ route('register', ['lang' => app()->getLocale()]) }}"
                                class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] text-[#1b1b18] rounded-sm text-base  leading-normal">
                                {{ __('messages.register') }}
                            </a>
                        @endif
                    </div>
                @endguest

                <!-- Language switcher -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex items-center text-sm text-gray-800 hover:text-gray-900 focus:outline-none">
                        <i class="fa-solid fa-earth-americas"></i>
                        <span class="ml-1 ">{{ strtoupper(app()->getLocale()) }}</span>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-24 bg-white border rounded shadow-md z-20">
                        <a href="?lang=en"
                            class="block px-4 py-2 text-gray-700 hover:bg-blue-500 hover:text-white cursor-pointer rounded-t-md">
                            {{ __('messages.language_english') }}
                        </a>
                        <a href="?lang=de"
                            class="block px-4 py-2 text-gray-700 hover:bg-blue-500 hover:text-white cursor-pointer rounded-b-md">
                            {{ __('messages.language_german') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                    class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                    aria-controls="mobile-menu" :aria-expanded="mobileMenuOpen.toString()">
                    <span class="sr-only">{{ __('messages.open_main_menu') }}</span>
                    <svg :class="{ 'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" class="block h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg :class="{ 'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" class="hidden h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileMenuOpen" id="mobile-menu" class="sm:hidden" @click.away="mobileMenuOpen = false" x-transition>




         <div class="flex items-center space-x-2 p-1"> 
    @if(Auth::check())
        @if(Auth::user()->avatar)
            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar"
                class="w-8 h-8 rounded-full">
        @else
            <div
                class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-700 text-sm">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        @endif
        <span class="px-3 font-medium">{{ Auth::user()->name }}</span>
    @endif
</div>






        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.index', ['lang' => app()->getLocale()]) }}"
                        class="inline-flex text-base items-center px-1 pt-1 border-b-2 border-transparent font-medium text-gray-800 hover:border-stone-500 hover:text-gray-700">
                        <i class="fa-solid fa-user-tie"></i>
                        {{ __('messages.admin') }}
                    </a>
                @endif
            @endauth
            <a href="{{ url('home/?lang=' . app()->getLocale()) }}"
                class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
                {{ __('messages.home') }}
            </a>

            <a href="{{ route('professionals.index', ['lang' => app()->getLocale()]) }}"
                class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
                {{ __('messages.find_professionals') }}
            </a>


            @auth
                <a href="{{ route('profile.edit', ['lang' => app()->getLocale()]) }}"
                    class="block pl-3 pr-4 py-2 border-l-4 border-indigo-500 text-base font-medium text-indigo-700 bg-indigo-50">
                    {{ __('messages.my_profile') }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
                        {{ __('messages.logout') }}
                    </button>
                </form>
            @endauth

            <a href="{{ route('contact') }}"
                class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
                {{ __('messages.contact') }}
            </a>

            @guest
                <a href="{{ route('login', ['lang' => app()->getLocale()]) }}"
                    class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
                    {{ __('messages.login') }}
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register', ['lang' => app()->getLocale()]) }}"
                        class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
                        {{ __('messages.register') }}
                    </a>
                @endif
            @endguest
        </div>

        <!-- Language switcher for mobile -->
        <div class="border-t border-gray-200 mt-4 pt-4 px-4">
            <p class="text-gray-600 text-sm mb-2 font-semibold">{{ __('messages.language_switcher') }}</p>
            <div class="flex space-x-4">
                {{-- <i class="fa-solid fa-earth-americas"></i> --}}
                <a href="?lang=en"
                    class="px-3 py-1 rounded border border-gray-300 hover:bg-blue-500 hover:text-white transition">
                    EN
                </a>
                <a href="?lang=de"
                    class="px-3 py-1 rounded border border-gray-300 hover:bg-blue-500 hover:text-white transition">
                    DE
                </a>
                {{-- <a href="?lang=el"
                    class="px-3 py-1 rounded border border-gray-300 hover:bg-blue-500 hover:text-white transition">
                    GR
                </a> --}}
            </div>
        </div>
    </div>

</nav>