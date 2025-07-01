<x-app-layout>

    <div class="relative h-64 overflow-hidden shadow-lg mb-8">
        <img src="{{ asset('storage/images/contact.jpg') }}" alt="Header background"
            class="absolute inset-0 w-full h-full object-cover brightness-75">
        <div class="relative z-10 flex flex-col items-center justify-center h-full text-white text-center">
            <h1 class="text-5xl font-bold">{{ __('messages.contact') }}</h1>
            <p class="mt-2 text-xl">{{ __('messages.contact_subtitle') }}</p>
        </div>
    </div>

<div class="max-w-3xl mx-auto px-4 py-2">
    <p class="mb-6  text-gray-700 text-md italic">
     <i class="fa-solid fa-comment"></i>   {{ __('messages.contact_intro') }}
    </p>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-4 rounded mb-4 shadow">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('contact.submit') }}" class="space-y-4">
        @csrf

            <div>
                <label for="name" class="block font-semibold">{{ __('messages.name') }}</label>
                <input type="text" name="name" id="name"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ old('name') }}" required>
                @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block font-semibold">{{ __('messages.email') }}</label>
                <input type="email" name="email" id="email"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ old('email') }}" required>
                @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="message" class="block font-semibold">{{ __('messages.message') }}</label>
                <textarea name="message" id="message" rows="5"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>{{ old('message') }}</textarea>
                @error('message') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded font-semibold transition">
                {{ __('messages.send') }}
            </button>
        </form>
    </div>

</x-app-layout>
