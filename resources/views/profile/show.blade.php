<x-app-layout>
    <!-- Custom CSS για το animation του verified badge -->
    <style>
        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }
    </style>

    <!-- Header με background εικόνα και τίτλο -->
    <div class="relative h-64 rounded-lg overflow-hidden shadow-lg mb-8 ">
        <img src="{{ asset('storage/images/profile1.jpg') }}" alt="{{ __('messages.header_background') }}"
            class="absolute inset-0 w-full h-full object-cover brightness-75">

        @php
            // Παίρνει το όνομα της κύριας κατηγορίας του χρήστη
            $primaryCategoryName = $user->categories->first()->name ?? __('messages.professional');
        @endphp

        <div class="relative z-10 flex flex-col items-center justify-center h-full text-white text-center px-4">
            <h1 class="text-5xl font-bold">{{ $user->name }} — {{ $primaryCategoryName }}</h1>
            <p class="mt-2 text-xl max-w-3xl">
                {{ __('messages.found_expert', ['category' => strtolower($primaryCategoryName)]) }}
            </p>
        </div>
    </div>

    <div class="max-w-2xl mx-auto p-6 m-6 md:p-8 bg-white rounded-lg shadow-md">
        {{-- Avatar & Name --}}
        <div class="flex flex-col sm:flex-row items-center sm:items-start space-y-4 sm:space-y-0 sm:space-x-6 mb-8">
            @if($user->avatar)
                <!-- Εμφάνιση avatar αν υπάρχει -->
                <img src="{{ asset('storage/' . $user->avatar) }}"
                    alt="{{ __('messages.avatar_of', ['name' => $user->name]) }}" title="{{ $user->name }}"
                    class="w-24 h-24 rounded-full object-cover border-2 border-gray-300" />
            @else
                <!-- Εμφάνιση αρχικού γράμματος αν δεν υπάρχει avatar -->
                <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-indigo-400 to-blue-500 text-white flex items-center justify-center text-3xl font-semibold uppercase border-2 border-gray-300"
                    title="{{ $user->name }}">
                    {{ substr($user->name, 0, 1) }}
                </div>
            @endif

            <div class="flex flex-col text-center sm:text-left">
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
                    {{ $user->name }}
                    @if($user->is_verified)
                        <!-- Verified badge με animation -->
                        <span
                            class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full"
                            style="animation: pulse 2s infinite;">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ __('messages.verified') }}
                        </span>
                    @endif
                </h1>

                @if($user->bio)
                    <!-- Εμφάνιση βιογραφικού -->
                    <p class="text-gray-600 mt-2 whitespace-pre-line max-w-xl">{{ $user->bio }}</p>
                @endif

                @if($user->categories->count())
                    <!-- Εμφάνιση κατηγοριών -->
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach($user->categories as $category)
                            <span class="bg-indigo-100 text-indigo-700 text-xs px-3 py-1 rounded-full font-medium">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Links --}}
        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">{{ __('messages.links') }}</h2>

            @if($links->count())
                <!-- Εμφάνιση λίστας links -->
                <ul class="space-y-3">
                    @foreach($links as $link)
                        <li
                            class="p-3 border rounded hover:bg-blue-50 hover:shadow transition duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.828 10.172a4 4 0 015.657 5.657l-1.414 1.414a4 4 0 01-5.657 0l-1.414-1.414" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.172 13.828a4 4 0 01-5.657-5.657l1.414-1.414a4 4 0 015.657 0l1.414 1.414" />
                            </svg>
                            <a href="{{ Str::startsWith($link->url, ['http://', 'https://']) ? $link->url : 'https://' . $link->url }}"
                                target="_blank" class="text-blue-600 hover:underline font-medium" rel="noopener noreferrer">
                                {{ $link->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <!-- Μήνυμα αν δεν υπάρχουν links -->
                <p class="text-gray-600 mb-4">{{ __('messages.no_links_contact', ['email' => $user->email]) }}</p>
            @endif
        </section>

        {{-- Contact Details --}}
        <section class="space-y-3 mt-8 border-t pt-4">
            @if($user->public_email)
                <!-- Εμφάνιση email με δυνατότητα αντιγραφής -->
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-gray-700">{{ __('messages.email') }}:</span>
                    <a href="mailto:{{ $user->public_email }}" class="text-blue-600 underline">{{ $user->public_email }}</a>
                    <button onclick="copyEmail('{{ $user->public_email }}')" aria-label="{{ __('messages.copy_email') }}"
                        class="text-sm text-gray-500 hover:text-blue-600">
                        <!-- SVG icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                        </svg>
                    </button>
                </div>
            @endif

            @if($user->phone)
                <!-- Εμφάνιση τηλεφώνου -->
                <p><span class="font-semibold text-gray-700">{{ __('messages.phone') }}:</span> {{ $user->phone }}</p>
            @endif
            @if($user->remote)
                <!-- Εμφάνιση remote work -->
                <p class="text-gray-600 mt-2  italic text-md"><i class="fa-solid fa-satellite-dish"></i>Available for remote
                    work</p>
            @endif
            <!-- Εμφάνιση χώρας -->
            @php
                $countries = ['GR' => 'Greece', 'UK' => 'England', 'DE' => 'Germany', 'CH' => 'Switzerland', 'AT' => 'Austria', 'OTHER' => 'Οther Countries'];
            @endphp
            <p class="text-gray-600 mt-2 text-sm italic ">
                {{ __('messages.country') }}: {{ $countries[$user->country] ?? $user->country ?? '-' }}
            </p>
        </section>

        {{-- Contact Button --}}
        @if($user->public_email)
            <!-- Κουμπί επικοινωνίας -->
            <a href="mailto:{{ $user->public_email }}"
                class="inline-block mt-6 bg-slate-800 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors duration-300">
                {{ __('messages.contact') }} {{ $user->name }}
            </a>
        @endif
    </div>

    <!-- Toast notification για αντιγραφή email -->
    <div id="toast"
        class="fixed bottom-6 right-6 bg-green-600 text-white px-4 py-2 rounded shadow-lg opacity-0 pointer-events-none transform translate-x-20 transition-all duration-300 flex items-center gap-3 max-w-xs">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
        <span>{{ __('messages.email_copied') }}</span>
        <button aria-label="{{ __('messages.close_toast') }}" onclick="hideToast()"
            class="ml-auto focus:outline-none hover:text-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- JS για αντιγραφή email και εμφάνιση toast --}}
    <script>
        const toast = document.getElementById('toast');
        let toastTimeout;

        function showToast() {
            clearTimeout(toastTimeout);
            toast.classList.remove('opacity-0', 'pointer-events-none', 'translate-x-20');
            toast.classList.add('opacity-100', 'translate-x-0');
            toastTimeout = setTimeout(hideToast, 3500);
        }

        function hideToast() {
            toast.classList.add('translate-x-20', 'opacity-0');
            toast.classList.remove('opacity-100');
            setTimeout(() => {
                toast.classList.add('pointer-events-none');
            }, 300);
        }

        function copyEmail(email) {
            navigator.clipboard.writeText(email).then(() => {
                showToast();
            });
        }
    </script>

</x-app-layout>