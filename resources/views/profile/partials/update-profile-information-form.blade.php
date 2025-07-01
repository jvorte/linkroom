<section>
    <header>
        <a href="{{ route('profile.show', auth()->user()->slug) }}" target="_blank" class="text-blue-600 hover:underline">
            {{ __('messages.view_public_profile') }}
        </a>

        <h2 class="mt-2 text-lg font-medium text-gray-900">
            {{ __('messages.profile_information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('messages.update_profile') }}
        </p>
    </header>

    <form method="post" enctype="multipart/form-data" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        {{-- Avatar --}}
        <div>
            
            <label class="block mb-2 font-semibold">{{ __('messages.avatar') }}</label>
                @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-20 h-20 m-1 rounded-full">
            @endif
            <input type="file" name="avatar" accept="image/*" class="mb-4 border border-gray-300 rounded px-3 py-2">

        
        </div>

        {{-- Name --}}
        <div>
            <x-input-label for="name" :value="__('messages.name')" />
            <x-text-input id="name" name="name" type="text"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-400"
                :value="old('name', $user->name)" required  autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Links --}}
        <section>
            <h2 class="text-lg font-semibold mb-2">{{ __('messages.links') }}</h2>

            <div id="links-wrapper" class="space-y-3">
                @foreach($user->links as $index => $link)
                    <div class="flex space-x-2 items-center">
                        <input type="hidden" name="links[{{ $index }}][id]" value="{{ $link->id }}">
                        <input type="text" name="links[{{ $index }}][title]" value="{{ $link->title }}"
                            placeholder="{{ __('messages.title_placeholder') }}" class="border border-gray-300 rounded px-3 py-2 w-1/3" required>
                        <input type="url" name="links[{{ $index }}][url]" value="{{ $link->url }}"
                            placeholder="{{ __('messages.url_placeholder') }}" class="border border-gray-300 rounded px-3 py-2 w-2/3" required>
                        <button type="button" onclick="this.parentNode.remove()" class="text-red-600 font-bold">×</button>
                    </div>
                @endforeach
            </div>

            <button type="button" id="add-link-btn"
                class="inline-flex items-center mt-2 px-4 py-2 bg-slate-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                +{{ __('messages.add_link') }}
            </button>
        </section>

        <script>
            document.getElementById('add-link-btn').addEventListener('click', function () {
                const container = document.getElementById('links-wrapper');
                const index = container.children.length;
                const div = document.createElement('div');
                div.classList.add('flex', 'space-x-2', 'items-center', 'mt-2');
                div.innerHTML = `
                    <input type="text" name="links[${index}][title]" placeholder="{{ __('messages.title_placeholder') }}" class="border border-gray-300 rounded px-3 py-2 w-1/3" required>
                    <input type="url" name="links[${index}][url]" placeholder="{{ __('messages.url_placeholder') }}" class="border border-gray-300 rounded px-3 py-2 w-2/3" required>
                    <button type="button" onclick="this.parentNode.remove()" class="text-red-600 font-bold">×</button>
                `;
                container.appendChild(div);
            });
        </script>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('messages.email')" />
            <x-text-input id="email" name="email" type="email"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-400"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        {{-- Public Email --}}
        <div>
            <x-input-label for="public_email" :value="__('messages.public_email')" />
            <x-text-input id="public_email" name="public_email" type="email"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-400"
                :value="old('public_email', $user->public_email)" />
            <x-input-error class="mt-2" :messages="$errors->get('public_email')" />
        </div>

        {{-- Phone --}}
        <div>
            <x-input-label for="phone" :value="__('messages.phone')" />
            <x-text-input id="phone" name="phone" type="text"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-400"
                :value="old('phone', $user->phone)" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        {{-- Bio --}}
        <div>
            <x-input-label for="bio" :value="__('messages.bio')" />
            <textarea id="bio" name="bio" rows="3"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-400">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>
        {{-- Remote work --}}
<div class="flex items-center mt-4">
    <input type="checkbox" id="remote" name="remote" value="1" {{ old('remote', $user->remote) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
    <label for="remote" class="ml-2 block text-sm text-gray-700">
        {{ __('messages.remote_available') }}
    </label>
</div>


        {{-- Categories --}}
        <div>
            <x-input-label for="categories" :value="__('messages.categories')" />
            <select name="categories[]" id="categories" multiple
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-400">
                @foreach(App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}"
                        {{ $user->categories->contains($category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('categories')" />
        </div>

        {{-- Submit --}}
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('messages.save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('messages.saved') }}</p>
            @endif
        </div>
    </form>
</section>
