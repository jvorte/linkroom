<x-app-layout>
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-md shadow-md">
        <div class="flex items-center space-x-6 mb-8">
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-24 h-24 rounded-full object-cover border-2 border-gray-300">
            @else
                <div class="w-24 h-24 rounded-full bg-gray-300 flex items-center justify-center text-gray-700 text-3xl font-semibold uppercase border-2 border-gray-300">
                    {{ substr($user->name, 0, 1) }}
                </div>
            @endif

            <div class="flex flex-col">
                <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                @if($user->bio)
                    <p class="text-gray-600 mt-2 whitespace-pre-line max-w-xl">{{ $user->bio }}</p>
                @endif
            </div>
        </div>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">Links</h2>

            @if($links->count())
                <ul class="space-y-3">
                    @foreach($links as $link)
                        <li class="p-3 border rounded hover:shadow hover:border-blue-500 transition duration-200">
                            <a href="{{ Str::startsWith($link->url, ['http://', 'https://']) ? $link->url : 'https://' . $link->url }}" target="_blank" class="text-blue-600 hover:underline font-medium">
                                {{ $link->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-600 mb-4">Ο επαγγελματίας δεν έχει προσθέσει σελίδα. Μπορείτε να επικοινωνήσετε μέσω email:</p>
                <p class="text-blue-700 underline">{{ $user->email }}</p>
            @endif
        </section>

        <section class="space-y-2">
            @if($user->public_email)
                <p><strong>Email:</strong> <a href="mailto:{{ $user->public_email }}" class="text-blue-600 underline">{{ $user->public_email }}</a></p>
            @endif

            @if($user->phone)
                <p><strong>Τηλέφωνο:</strong> {{ $user->phone }}</p>
            @endif
        </section>

        <div class="mt-10">
            <a href="{{ route('dashboard') }}" class="inline-block text-blue-600 hover:underline font-semibold">
                ← Επεξεργασία προφίλ
            </a>
        </div>
    </div>
</x-app-layout>
