<x-app-layout>
    @section('content')
        <div class="relative h-64 overflow-hidden shadow-lg mb-12 rounded-lg">
            <img src="{{ asset('storage/images/admin.jpg') }}" alt="Header background"
                class="absolute inset-0 w-full h-full object-cover brightness-75">
            <div class="relative z-10 flex flex-col items-center justify-center h-full text-white text-center">
                <h1 class="text-5xl font-bold">{{ __('messages.admin_dashboard') }}</h1>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">

            {{-- Contact Messages --}}
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.contact_messages') }}</h2>

                @if($messages->isEmpty())
                    <p class="text-gray-500 italic">{{ __('messages.no_contact_messages') }}</p>
                @else
                    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-400 text-left text-gray-600 uppercase tracking-wider">
                                <tr>
                                    <th class="px-6 py-3">Name</th>
                                    <th class="px-6 py-3">Email</th>
                                    <th class="px-6 py-3">Message</th>
                                    <th class="px-6 py-3">Date</th>
                                    <th class="px-6 py-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-gray-800">
                                @foreach($messages as $message)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $message->name }}</td>
                                        <td class="px-6 py-4">{{ $message->email }}</td>
                                        <td class="px-6 py-4">{{ $message->message }}</td>
                                        <td class="px-6 py-4">{{ $message->created_at->format('Y-m-d H:i') }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this message?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition duration-200">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- Newsletter Subscriptions --}}
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.newsletter_subscriptions') }}</h2>

                @if($subscriptions->isEmpty())
                    <p class="text-gray-500 italic">{{ __('messages.no_subscriptions') }}</p>
                @else
                    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-300 text-left text-gray-600 uppercase tracking-wider">
                                <tr>
                                    <th class="px-6 py-3">Email</th>
                                    <th class="px-6 py-3">Date</th>
                                    <th class="px-6 py-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-gray-800">
                                @foreach($subscriptions as $sub)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $sub->email }}</td>
                                        <td class="px-6 py-4">{{ $sub->created_at->format('Y-m-d H:i') }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <form action="{{ route('admin.subscriptions.destroy', $sub->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this subscription?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition duration-200">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
  
</x-app-layout>
