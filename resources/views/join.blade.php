<x-app-layout>
    <div class="relative h-64 md:h-80 overflow-hidden shadow mb-12">
        <img src="{{ asset('storage/images/prof3.jpg') }}" alt="Banner"
            class="absolute inset-0 w-full h-full object-cover brightness-75">
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 to-transparent"></div>
        <div
            class="relative z-10 flex flex-col items-center justify-center h-full text-white text-center px-6 md:px-12">
            <h1 class="text-5xl font-bold mb-4">{{ __('messages.join_title') }}</h1>
            <p class="text-xl max-w-3xl">{{ __('messages.join_subtitle') }}</p>
            <a href="{{ route('register', ['lang' => app()->getLocale()]) }}"
                class="mt-8 bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-xl text-xl font-semibold transition">
                {{ __('messages.join_cta') }}
            </a>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-6 space-y-16">
        <!-- How It Works Section -->
        <section class="text-center">
            <h2 class="text-4xl font-bold mb-8">{{ __('messages.join_how_it_works_title') }}</h2>

            {{-- carousel area --}}
            <div x-data="carousel()" x-init="init()"
                class="relative mb-5 h-64 md:h-64 max-w-4xl mx-auto rounded-lg shadow-lg overflow-hidden">
                <!-- Carousel Slides -->
                <template x-for="(image, index) in images" :key="index">
                    <div x-show="current === index" x-transition:enter="transition-opacity duration-700"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition-opacity duration-700" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" class="absolute inset-0 w-full h-full bg-center bg-cover"
                        :style="`background-image: url('${image.src}')`">
                        <div
                            class="bg-black bg-opacity-40 h-full flex items-center justify-center text-white text-2xl font-semibold">
                            <span x-text="image.caption"></span>
                        </div>
                    </div>
                </template>

                <!-- Navigation Buttons -->
                <button @click="prev()"
                    class="absolute left-3 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 hover:bg-opacity-75 text-white rounded-full p-2 z-10">
                    <i class="fa-solid fa-arrow-left" style="color: #e6e6e6;"></i>
                </button>
                <button @click="next()"
                    class="absolute right-3 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 hover:bg-opacity-75 text-white rounded-full p-2 z-10">
                    <i class="fa-solid fa-arrow-right" style="color: #e4e7ec;"></i>
                </button>

                <!-- Indicators -->
                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex space-x-2 z-10">
                    <template x-for="(image, index) in images" :key="index">
                        <button @click="goTo(index)" :class="current === index ? 'bg-red-600' : 'bg-gray-300'"
                            class="w-3 h-3 rounded-full"></button>
                    </template>
                </div>
            </div>

            <script>
                function carousel() {
                    return {
                        current: 0,
                        images: [
                            { src: '{{ asset("storage/images/1.jpg") }}', caption: '' },
                            { src: '{{ asset("storage/images/2.jpg") }}', caption: '' },
                            { src: '{{ asset("storage/images/4.jpg") }}', caption: '' },
                        ],
                        init() {
                            this.startAutoSlide();
                        },
                        startAutoSlide() {
                            setInterval(() => {
                                this.next();
                            }, 5000);
                        },
                        prev() {
                            this.current = (this.current === 0) ? this.images.length - 1 : this.current - 1;
                        },
                        next() {
                            this.current = (this.current === this.images.length - 1) ? 0 : this.current + 1;
                        },
                        goTo(index) {
                            this.current = index;
                        }
                    }
                }
            </script>

            {{-- end carousel area --}}

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
        {{-- <section>
            <h2 class="text-3xl font-bold mb-6 text-center">{{ __('messages.join_demo_title') }}</h2>
            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8">
                <a href="/u/alex-smith"
                    class="block bg-white rounded shadow hover:shadow-lg hover:-translate-y-1 transition-transform p-4 text-center">
                    <img src="{{ asset('storage/images/face1.jpg') }}" alt="Alex Smith"
                        class="mx-auto rounded mb-3 w-32 h-32 object-cover">
                    <p class="font-semibold text-gray-800">Alex Smith</p>
                    <p class="text-gray-600">UX Designer</p>
                </a>
                <a href="/u/elena-georgiou"
                    class="block bg-white rounded shadow hover:shadow-lg hover:-translate-y-1 transition-transform p-4 text-center">
                    <img src="{{ asset('storage/images/face2.jpg') }}" alt="Antoine E. King"
                        class="mx-auto rounded mb-3 w-32 h-32 object-cover">
                    <p class="font-semibold text-gray-800">Antoine E. King</p>
                    <p class="text-gray-600">Electrician</p>
                </a>
                <a href="/u/kostas-marinakis"
                    class="block bg-white rounded shadow hover:shadow-lg hover:-translate-y-1 transition-transform p-4 text-center">
                    <img src="{{ asset('storage/images/face3.jpg') }}" alt="Kristen J. Greenwood"
                        class="mx-auto rounded mb-3 w-32 h-32 object-cover">
                    <p class="font-semibold text-gray-800">Kristen J. Greenwood</p>
                    <p class="text-gray-600">Web Developer</p>
                </a>
            </div>
        </section> --}}

        <!-- FAQ Section -->
        <section class="max-w-3xl mx-auto">
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