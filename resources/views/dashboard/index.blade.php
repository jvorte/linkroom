@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
    </div>
@endif

<x-app-layout>
    <div class="max-w-md mx-auto p-4" x-data="linkManager()" x-init="init()">
        <a href="{{ route('profile.show', auth()->user()->slug) }}" target="_blank" class="text-blue-600 hover:underline">
    Δες το δημόσιο προφίλ σου
</a>


        <h1 class="text-2xl font-bold mb-4">Your Links</h1>

        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        {{-- Form to Add Link --}}
        <form method="POST" action="{{ route('dashboard.links.store') }}" class="mb-6">
            @csrf
            <input type="text" name="title" placeholder="Title" required class="w-full mb-2 p-2 border rounded" />
            <input type="url" name="url" placeholder="URL" required class="w-full mb-2 p-2 border rounded" />
            <input type="number" name="order" placeholder="Order (προαιρετικό)" class="w-full mb-2 p-2 border rounded" value="0" />
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Link</button>
        </form>

        {{-- List of Links --}}
        <ul x-ref="list" class="space-y-3">
            @foreach($links as $link)
 


                <li data-id="{{ $link->id }}" class="flex justify-between items-center p-2 border rounded cursor-move">
                    <div>
                        <strong>{{ $link->title }}</strong>
                       <a href="{{ $link->url }}" target="_blank" class="text-blue-600 underline ml-2">Visit</a>
                    </div>

                    <div class="flex space-x-2">
                        <a href="#"
                           @click.prevent="editLink({{ $link->id }}, '{{ addslashes($link->title) }}', '{{ addslashes($link->url) }}', {{ $link->order }})"
                           class="text-yellow-600 hover:underline cursor-pointer">Edit</a>

                        <form method="POST" action="{{ route('dashboard.links.destroy', $link) }}" onsubmit="return confirm('Delete this link?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
        <label class="block mt-4 mb-2 font-semibold">Δημόσιο Email</label>
<input type="email" name="public_email" class="w-full p-2 border rounded"
       value="{{ old('public_email', auth()->user()->public_email) }}">

<label class="block mt-4 mb-2 font-semibold">Τηλέφωνο Επικοινωνίας</label>
<input type="text" name="phone" class="w-full p-2 border rounded"
       value="{{ old('phone', auth()->user()->phone) }}">


        {{-- Modal for Editing --}}
        <div x-show="open"
             style="display: none;"
             class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">

            <div class="bg-white p-6 rounded shadow w-full max-w-md" x-cloak>
                <form :action="`/dashboard/links/${id}`" method="POST">
                    @csrf
                    @method('PUT')

                    <h2 class="text-xl font-bold mb-4">Edit Link</h2>

                    <input type="text" name="title" x-model="title" required class="w-full mb-3 p-2 border rounded" />
                    <input type="url" name="url" x-model="url" required class="w-full mb-3 p-2 border rounded" />
                    <input type="number" name="order" x-model="order" placeholder="Order" class="w-full mb-3 p-2 border rounded" />

                    <div class="flex justify-end space-x-3">
                        <button type="button" @click="open = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Profile Form --}}
        <form method="POST" action="{{ route('dashboard.profile.update') }}" enctype="multipart/form-data" class="mt-8">
            @csrf
            @method('PUT')
            
<label class="block mt-4 mb-2 font-semibold">Κατηγορίες</label>
<div class="grid grid-cols-2 gap-2">
    @foreach($allCategories as $category)
        <label class="flex items-center space-x-2">
            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                   @if(auth()->user()->categories->contains($category->id)) checked @endif>
            <span>{{ $category->name }}</span>
        </label>
    @endforeach
</div>

            <label class="block mb-2 font-semibold">Bio</label>
            <textarea name="bio" rows="3" class="w-full p-2 border rounded">{{ old('bio', auth()->user()->bio) }}</textarea>

            <label class="block mt-4 mb-2 font-semibold">Avatar</label>
            <input type="file" name="avatar" accept="image/*" />

            @if(auth()->user()->avatar)
                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" class="w-20 h-20 rounded-full mt-4">
            @endif

            <button type="submit" class="mt-4 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Update Profile</button>
        </form>
    </div>
    

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        function linkManager() {
            return {
                open: false,
                id: null,
                title: '',
                url: '',
                order: 0,

                init() {
                    let el = this.$refs.list;
                    Sortable.create(el, {
                        animation: 150,
                        onEnd: () => {
                            let order = [];
                            el.querySelectorAll('li').forEach((item, index) => {
                                order.push({
                                    id: item.dataset.id,
                                    order: index
                                });
                            });

                            fetch('/dashboard/links/reorder', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({order: order})
                            }).catch(() => alert('Error saving order.'));
                        }
                    });
                },

                editLink(id, title, url, order) {
                    this.id = id;
                    this.title = title;
                    this.url = url;
                    this.order = order;
                    this.open = true;
                }
            };
        }
    </script>
</x-app-layout>
