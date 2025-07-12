<x-app-layout>
    <div class="relative h-64 md:h-80 overflow-hidden shadow mb-12">
        <img src="{{ asset('storage/images/prof3.jpg') }}" alt="Banner"
            class="absolute inset-0 w-full h-full object-cover brightness-75">
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 to-transparent"></div>
        <div
            class="relative z-10 flex flex-col items-center justify-center h-full text-white text-center px-6 md:px-12">
            <h1 class="text-5xl font-bold mb-4">{{ __('messages.join_title') }}</h1>
            <p class="text-xl max-w-3xl">{{ __('messages.join_subtitle') }}</p>
         @php
    $btnClass = 'inline-flex items-center px-6 py-2 text-white text-lg font-semibold rounded-xl transition';
@endphp

@guest
    <a href="{{ route('register', ['lang' => app()->getLocale()]) }}"
       class="{{ $btnClass }} bg-slate-800 hover:bg-slate-900 mt-3">
            {{-- <i class="fa-solid fa-screwdriver-wrench pr-1 " style="color: #dee4ed;"></i> --}}
        {{ __('messages.join_cta') }}
    </a>
@endguest

@auth
    <a href="{{ route('profile.edit', ['lang' => app()->getLocale()]) }}"
       class="{{ $btnClass }} bg-gray-800 hover:bg-gray-700 mt-3 ">
        <i class="fa-solid fa-screwdriver-wrench pr-1 " style="color: #dee4ed;"></i>
        {{ __('messages.my_profile') }}
    </a>
@endauth

        </div>
    </div>

    <div class="max-w-6xl mx-auto px-6 space-y-10">
        <!-- How It Works Section -->
        <section class="text-center">
            <h2 class="text-4xl font-bold mb-8">{{ __('messages.join_how_it_works_title') }}</h2>


            <div class="grid md:grid-cols-3 gap-10">
                <div>
                    <div class="text-5xl text-red-600 mb-4">1️⃣</div>
                    <h3 class="text-xl font-semibold mb-2">{{ __('messages.join_step_1_title') }}</h3>
                    <p class="text-gray-600">{{ __('messages.join_step_1_desc') }}</p>
                </div>
                <div>
                    <div class="text-5xl text-red-600 mb-4">2️⃣</div>
                    <h3 class="text-xl font-semibold mb-2">{{ __('messages.join_step_2_title') }}</h3>
                    <p class="text-gray-600">{{ __('messages.join_step_2_desc') }}</p>
                </div>
                <div>
                    <div class="text-5xl text-red-600 mb-4">3️⃣</div>
                    <h3 class="text-xl font-semibold mb-2">{{ __('messages.join_step_3_title') }}</h3>
                    <p class="text-gray-600">{{ __('messages.join_step_3_desc') }}</p>
                </div>
            </div>
        </section>




        <!-- Demo Profiles -->
<section>
    <h2 class="text-3xl font-bold mb-6 text-center">{{ __('messages.join_demo_title') }}</h2>

    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8">
        @foreach ($randomUsers as $user)
            <a href="{{ url('/u/' . $user->slug) }}"
               class="block bg-white rounded shadow hover:shadow-lg hover:-translate-y-1 transition-transform p-4 text-center">
                <img src="{{ asset('storage/' . $user->avatar) ?? asset('storage/images/default-avatar.jpg') }}"
                     alt="{{ $user->name }}"
                     class="mx-auto rounded mb-3 w-32 h-32 object-cover">
                <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                <p class="text-gray-600">{{ optional($user->categories->first())->name ?? 'Professional' }}</p>
            </a>
        @endforeach
    </div>
</section>



        <!-- FAQ Section -->
        <section class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold mb-6 text-center">{{ __('messages.join_faq_title') }}</h2>
            <dl class="space-y-6 text-gray-700">
                <div>
                    <dt class="font-semibold">{{ __('messages.join_faq_q1') }}</dt>
                    <dd>{{ __('messages.join_faq_a1') }}</dd>
                </div>
                <div>
                    <dt class="font-semibold">{{ __('messages.join_faq_q2') }}</dt>
                    <dd>{{ __('messages.join_faq_a2') }}</dd>
                </div>
                <div>
                    <dt class="font-semibold">{{ __('messages.join_faq_q3') }}</dt>
                    <dd>{{ __('messages.join_faq_a3') }}</dd>
                </div>
                <div>
                    <dt class="font-semibold">{{ __('messages.join_faq_q4') }}</dt>
                    <dd>{{ __('messages.join_faq_a4') }}</dd>
                </div>
            </dl>
        </section>
    </div>
</x-app-layout>