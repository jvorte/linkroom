<section>
    <header>
        <a href="{{ route('profile.show', auth()->user()->slug) }}" target="_blank" class="text-blue-600 hover:underline">
            View your public profile
        </a>

        <h2 class="mt-2 text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form method="post" enctype="multipart/form-data" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        {{-- Avatar --}}
        <div>
            <label class="block mb-2 font-semibold">Avatar</label>
            <input type="file" name="avatar" accept="image/*" class="mb-4 border border-gray-300 rounded px-3 py-2">

            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-20 h-20 rounded-full">
            @endif
        </div>

        {{-- Name --}}
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-400"
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Links --}}
        <section>
            <h2 class="text-lg font-semibold mb-2">Σύνδεσμοι</h2>

            <div id="links-wrapper" class="space-y-3">
                @foreach($user->links as $index => $link)
                    <div class="flex space-x-2 items-center">
                        <input type="hidden" name="links[{{ $index }}][id]" value="{{ $link->id }}">
                        <input type="text" name="links[{{ $index }}][title]" value="{{ $link->title }}"
                            placeholder="Τίτλος" class="border border-gray-300 rounded px-3 py-2 w-1/3" required>
                        <input type="url" name="links[{{ $index }}][url]" value="{{ $link->url }}"
                            placeholder="URL" class="border border-gray-300 rounded px-3 py-2 w-2/3" required>
                        <button type="button" onclick="this.parentNode.remove()" class="text-red-600 font-bold">×</button>
                    </div>
                @endforeach
            </div>

            <button type="button" id="add-link-btn"
                class="inline-flex items-center mt-2 px-4 py-2 bg-slate-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                +Your WebSite
            </button>
        </section>

        <script>
            document.getElementById('add-link-btn').addEventListener('click', function () {
                const container = document.getElementById('links-wrapper');
                const index = container.children.length;
                const div = document.createElement('div');
                div.classList.add('flex', 'space-x-2', 'items-center', 'mt-2');
                div.innerHTML = `
                    <input type="text" name="links[${index}][title]" placeholder="Τίτλος" class="border border-gray-300 rounded px-3 py-2 w-1/3" required>
                    <input type="url" name="links[${index}][url]" placeholder="URL" class="border border-gray-300 rounded px-3 py-2 w-2/3" required>
                    <button type="button" onclick="this.parentNode.remove()" class="text-red-600 font-bold">×</button>
                `;
                container.appendChild(div);
            });
        </script>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-400"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        {{-- Public Email --}}
        <div>
            <x-input-label for="public_email" :value="__('Public Email (Optional)')" />
            <x-text-input id="public_email" name="public_email" type="email"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-400"
                :value="old('public_email', $user->public_email)" />
            <x-input-error class="mt-2" :messages="$errors->get('public_email')" />
        </div>

        {{-- Phone --}}
        <div>
            <x-input-label for="phone" :value="__('Phone (Optional)')" />
            <x-text-input id="phone" name="phone" type="text"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-400"
                :value="old('phone', $user->phone)" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        {{-- Bio --}}
        <div>
            <x-input-label for="bio" :value="__('Short Bio')" />
            <textarea id="bio" name="bio" rows="3"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-400">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        {{-- Categories --}}
        <div>
            <x-input-label for="categories" :value="__('Categories')" />
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
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
