<x-app-layout>

  
@section('content')

      <div class="relative h-64 overflow-hidden shadow-lg mb-8">
        <img src="{{ asset('storage/images/admin.jpg') }}" alt="Header background"
            class="absolute inset-0 w-full h-full object-cover brightness-75">
        <div class="relative z-10 flex flex-col items-center justify-center h-full text-white text-center">
            <h1 class="text-5xl font-bold">{{ __('messages.admin_dashboard') }}</h1>
         
        </div>
    </div>
<div class="max-w-7xl mx-auto px-4 py-6">


    {{-- Contact Messages --}}
    <div class="mb-10">
        <h2 class="text-xl font-semibold mb-4">{{ __('messages.contact_messages') }}</h2>
        @if($messages->isEmpty())
            <p class="text-gray-600">{{ __('messages.no_contact_messages') }}</p>
        @else
            <table class="w-full table-auto border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Message</th>
                        <th class="px-4 py-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $message)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $message->name }}</td>
                            <td class="px-4 py-2">{{ $message->email }}</td>
                            <td class="px-4 py-2">{{ $message->message }}</td>
                            <td class="px-4 py-2">{{ $message->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Newsletter Subscriptions --}}
    <div>
        <h2 class="text-xl font-semibold mb-4">{{ __('messages.newsletter_subscriptions') }}</h2>
        @if($subscriptions->isEmpty())
            <p class="text-gray-600">{{ __('messages.no_subscriptions') }}</p>
        @else
            <table class="w-full table-auto border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscriptions as $sub)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $sub->email }}</td>
                            <td class="px-4 py-2">{{ $sub->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
</x-app-layout>
