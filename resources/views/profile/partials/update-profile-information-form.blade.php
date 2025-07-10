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
    </header><form method="post" action="{{ route('profile.update', ['lang' => app()->getLocale()]) }}" enctype="multipart/form-data" class="mt-6 space-y-6">
  @csrf
    @method('put')
    <input type="hidden" name="lang" value="{{ app()->getLocale() }}">
    
    <!-- checkbox is_active -->
    <div class="flex items-center space-x-4 mt-4">
        <span class="text-gray-700">{{ __('messages.active_profile') }}</span>
        <label for="is_active" class="relative inline-flex items-center cursor-pointer">
            <input type="hidden" name="is_active" value="0" />
            <input type="checkbox" id="is_active" name="is_active" value="1"
                class="sr-only peer"
                {{ old('is_active', $user->is_active) ? 'checked' : '' }} />
            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300
                peer-checked:bg-blue-600 transition-colors duration-300"></div>
            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full shadow
                peer-checked:translate-x-5 transform transition-transform duration-300"></div>
        </label>
    </div>
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
 {{-- Country --}}
<div>
    <x-input-label for="country" :value="__('messages.country')" />
    <select id="country" name="country" required
        class="mt-1 p-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-400">
        <option value="">{{ __('messages.select_country') }}</option>
        <option value="UK" {{ old('country', $user->country) === 'UK' ? 'selected' : '' }}>England</option>
        <option value="GR" {{ old('country', $user->country) === 'GR' ? 'selected' : '' }}>Greece</option>
        <option value="CH" {{ old('country', $user->country) === 'CH' ? 'selected' : '' }}>Switzerland</option>
        <option value="DE" {{ old('country', $user->country) === 'DE' ? 'selected' : '' }}>Germany</option>
        <option value="AT" {{ old('country', $user->country) === 'AT' ? 'selected' : '' }}>Austria</option>
        <option value="OTHER" {{ old('country', $user->country) === 'OTHER' ? 'selected' : '' }}>Other Countries</option>
    </select>
    <x-input-error class="mt-2" :messages="$errors->get('country')" />
</div>


        {{-- Short CV --}}
        <div>
           <x-input-label for="bio" :value="__('messages.bio')" />
<p class="text-sm text-gray-500 mb-1">{{ __('messages.bio_helper') }}</p>

<textarea id="bio" name="bio" rows="18"
    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-400">{{ old('bio', $user->bio) }}</textarea>
 <x-input-error class="mt-2" :messages="$errors->get('bio')" />
    <p id="cv-bio-status" class="mt-2 text-sm" role="alert"></p>
        </div>

        {{-- Upload your CV --}}


    <div class="mb-4 p-4 border border-gray-300 rounded-lg bg-gray-50">
    <label class="block text-sm font-medium text-gray-700">{{ __('messages.upload_cv') }}</label>
<div class="flex items-center space-x-3 mt-1">
  <input type="file" name="cv" accept=".pdf,.doc,.docx"
         class="block w-full text-sm text-gray-600 border border-gray-300 rounded p-2" />
  
  @if($user->cv_path)
    <a href="{{ route('profile.delete_cv', ['lang' => app()->getLocale()]) }}"
       onclick="return confirm('Are you sure you want to delete your resume?')"
       class="text-red-600 hover:underline text-sm flex items-center">
      <i class="fa-solid fa-trash"></i>
    </a>
  @endif
</div>


    <div class="flex items-center gap-4 mt-4">
        <x-primary-button>{{ __('messages.save', ['lang' => app()->getLocale()]) }}</x-primary-button>
        @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition
               x-init="setTimeout(() => show = false, 2000)"
               class="text-sm text-gray-600">{{ __('messages.saved') }}</p>
        @endif

            <button id="generate-bio-cv-btn" type="button"
    class=" px-4 py-1 bg-green-600 text-white rounded hover:bg-green-700 flex items-center justify-center gap-2"
    aria-live="polite">
    <svg id="btn-spinner" class="animate-spin h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
    </svg>
    <span id="btn-text">Generate short CV from your CV</span>
</button>
    

</div>
</div>


<script>
document.getElementById('generate-bio-cv-btn').addEventListener('click', async () => {
    const btn = document.getElementById('generate-bio-cv-btn');
    const spinner = document.getElementById('btn-spinner');
    const btnText = document.getElementById('btn-text');
    const status = document.getElementById('cv-bio-status');
    const bioTextarea = document.getElementById('bio');

    btn.disabled = true;
    spinner.classList.remove('hidden');
    btnText.textContent = 'Generating bio from your CV... ⏳';
    status.textContent = '';
    status.className = 'mt-2 text-sm';

    try {
        const response = await fetch('{{ route('profile.generate_bio_from_cv') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            }
        });
        const data = await response.json();

        if (data.bio) {
            bioTextarea.value = data.bio;
            status.textContent = '✅ Bio generated! You can edit it before saving.';
            status.classList.add('text-green-600', 'font-semibold');
            // Αυτόματο scroll στο bio
            bioTextarea.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else if (data.error) {
            status.textContent = `⚠️ ${data.error}`;
            status.classList.add('text-red-600', 'font-semibold');
        } else {
            status.textContent = '⚠️ Failed to generate bio.';
            status.classList.add('text-red-600', 'font-semibold');
        }
    } catch (err) {
        status.textContent = '⚠️ Error generating bio.';
        status.classList.add('text-red-600', 'font-semibold');
        console.error(err);
    } finally {
        btn.disabled = false;
        spinner.classList.add('hidden');
        btnText.textContent = '📝 Generate Bio from CV';
    }
});
</script>




    

        {{-- Remote work --}}
<div class="flex items-center mt-4">
    <input type="checkbox" id="remote" name="remote" value="1" {{ old('remote', $user->remote) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
    <label for="remote" class="ml-2 block text-sm text-gray-700">
        {{ __('messages.remote_available') }}
    </label>
</div>


        {{-- Categories --}}
  {{-- Main Category --}}
<div>
    <x-input-label for="main_category" :value="__('messages.main_category')" />
    <select id="main_category" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-400">
        <option value="">{{ __('messages.select_main_category') }}</option>
        @foreach(App\Models\Category::whereNull('parent_id')->get() as $mainCategory)
            <option value="{{ $mainCategory->id }}">{{ $mainCategory->name }}</option>
        @endforeach
    </select>
</div>

{{-- Subcategories --}}
<div class="mt-4">
    <x-input-label for="subcategories" :value="__('messages.subcategories')" />
    <select id="subcategories" name="categories[]"  multiple size="7"
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-400">
        {{-- Εμφάνιση αποθηκευμένων υποκατηγοριών --}}
        @foreach($user->categories as $cat)
            @if($cat->parent_id !== null)
                <option value="{{ $cat->id }}" selected>{{ $cat->name }}</option>
            @endif
        @endforeach
    </select>
    <x-input-error class="mt-2" :messages="$errors->get('categories')" />
</div>

{{-- AJAX Script --}}
<script>
document.getElementById('main_category').addEventListener('change', function () {
    const mainCategoryId = this.value;
    const subcategorySelect = document.getElementById('subcategories');
    subcategorySelect.innerHTML = ''; // Καθαρισμός

    if (!mainCategoryId) return;

    fetch(`/categories/${mainCategoryId}/subcategories`)
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) {
                const option = document.createElement('option');
                option.disabled = true;
                option.textContent = "{{ __('messages.no_subcategories') }}";
                subcategorySelect.appendChild(option);
                return;
            }

            data.forEach(sub => {
                const option = document.createElement('option');
                option.value = sub.id;
                option.textContent = sub.name;
                subcategorySelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error loading subcategories:', error);
        });
});
</script>



        {{-- Submit --}}
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('messages.save', ['lang' => app()->getLocale()]) }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('messages.saved') }}</p>
            @endif
        </div>
    </form>
</section>
