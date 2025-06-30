<x-app-layout>
    <div class="relative h-64 overflow-hidden shadow-lg mb-8">
        <img src="{{ asset('storage/images/prof4.jpg') }}" alt="Header background"
            class="absolute inset-0 w-full h-full object-cover brightness-75">
        <div class="relative z-10 flex flex-col items-center justify-center h-full text-white text-center">
            <h1 class="text-5xl font-bold">{{ __('messages.discover_title') }}</h1>
            <p class="mt-2 text-xl">{{ __('messages.discover_subtitle') }}</p>
        </div>
    </div>
    {{-- {{ session('locale') }} --}}
    <div class="max-w-6xl mx-auto px-4 py-6">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
            <form method="GET" action="{{ route('professionals.index', ['lang' => app()->getLocale()]) }}"
                class="w-full sm:w-auto flex-grow">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="{{ __('messages.search_placeholder') }}"
                        oninput="if (this.value === '') this.form.submit()"
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
            </form>

            <button type="button" onclick="document.getElementById('filterModal').classList.remove('hidden')"
                class="bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-700 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                </svg>
                {{ __('messages.filter_button') }}
            </button>
        </div>

        <div id="filterModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
            <div class="bg-white w-full max-w-2xl mx-auto rounded-lg shadow-lg p-6 relative">
                <button class="absolute top-2 right-3 text-gray-500 hover:text-black text-2xl"
                    onclick="document.getElementById('filterModal').classList.add('hidden')">&times;</button>
                <form method="GET" action="{{ route('professionals.index', ['lang' => app()->getLocale()]) }}">

                    <h2 class="text-lg font-bold mb-4 text-center">Filter by Categories</h2>
                    <div class="mb-4 grid grid-cols-2 sm:grid-cols-3 gap-2 max-h-48 overflow-y-auto">
                        @foreach($allCategories as $category)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="categories[]" value="{{ $category->slug }}" {{ request()->input('categories') && in_array($category->slug, request()->input('categories')) ? 'checked' : '' }} class="form-checkbox text-blue-600">
                                <span class="text-sm">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="mt-4 border-t pt-4">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="remote_only" value="1" {{ request('remote_only') ? 'checked' : '' }} class="form-checkbox text-blue-600">
                            <span class="text-sm text-gray-700">{{ __('messages.only_remote') }}</span>
                        </label>
                    </div>

                    <div class="mt-4 border-t pt-4">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="verified_only" value="1" {{ request('verified_only') ? 'checked' : '' }} class="form-checkbox text-green-600">
                            <span class="text-sm text-gray-700">{{ __('messages.only_verified') }}</span>
                        </label>

                    </div>

                    <div class="flex justify-between mt-4">
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">{{ __('messages.apply_filters') }}</button>
                        <button type="button" onclick="resetFilters()"
                            class="text-red-500 hover:underline text-sm">{{ __('messages.reset_filters') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function resetFilters() {
                document.querySelectorAll('#filterModal input[type=checkbox]').forEach(cb => cb.checked = false);
            }
        </script>

        @if($professionals->count())
            <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($professionals as $user)
                    <li class="relative border rounded-lg p-5 shadow-xl bg-white hover:shadow-md transition fade-in-up">
                        @if($user->is_verified)
                            <div class="absolute top-2 right-2 bg-green-200 text-black text-[13px] px-1.5 py-0.5 rounded-full font-semibold shadow flex items-center gap-1"
                                style="animation: pulse 2s infinite;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                </svg>
                                {{ __('messages.verified_badge') }}
                            </div>
                        @endif

                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-20 h-20 rounded-full">
                        @endif

                        <a href="{{ route('profile.show', ['slug' => $user->slug, 'lang' => app()->getLocale()]) }}"
                            class="block text-xl font-semibold text-blue-700 hover:underline">
                            {{ $user->name }}
                        </a>


                        @if($user->bio)
                            <p class="text-gray-600 mt-2 text-sm">{{ Str::limit($user->bio, 100) }}</p>
                        @endif

                        <div class="mt-3 flex flex-wrap gap-1">
                            @foreach($user->categories as $cat)
                                <span class="bg-slate-800 text-white text-sm px-2 py-1 rounded">{{ $cat->name }}</span>
                            @endforeach
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="mt-8">
                {{ $professionals->appends(['lang' => app()->getLocale()])->links() }}

            </div>
        @else
            <p class="text-gray-600">{{ __('messages.no_results') }}</p>
        @endif
    </div>

    <div class="mt-12 bg-gray-50 p-6 rounded">
        <h2 class="text-xl font-semibold text-center mb-4">{{ __('messages.testimonials_title') }}</h2>
        <div class="max-w-6xl mx-auto px-4 py-6 grid sm:grid-cols-2 md:grid-cols-3 gap-6 text-sm text-gray-600">
            <blockquote>“Super easy to use — I quickly found what I needed.” — Maria</blockquote>
            <blockquote>“As a professional, it helped me reach new clients fast.” — Nick</blockquote>
            <blockquote>“The best platform to connect with trusted professionals.” — Eleni</blockquote>
        </div>
    </div>
</x-app-layout>