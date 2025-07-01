<?php

// ProfileController.php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function show($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $links = $user->links()->orderBy('order')->get();

        return view('profile.show', compact('user', 'links'));
    }

public function updateProfile(Request $request)
{
    $user = auth()->user();

    $data = $request->validate([
        'bio' => 'nullable|string',
        'avatar' => 'nullable|image|max:2048',
        'categories' => 'nullable|array',
        'categories.*' => 'exists:categories,id',
        'public_email' => 'nullable|email|max:255',
        'phone' => 'nullable|string|max:50',
           'remote' => 'sometimes|boolean',
        'links' => 'nullable|array',
        'links.*.id' => 'nullable|exists:links,id',
        'links.*.title' => 'required_with:links.*.url|string|max:255',
        'links.*.url' => 'required_with:links.*.title|url|max:255',
          'country' => 'nullable|string|max:255',
    ]);

    if ($request->hasFile('avatar')) {
        $path = $request->file('avatar')->store('avatars', 'public');
        $data['avatar'] = $path;
    }

    $user->update($data);

    // Sync categories
    $user->categories()->sync($request->categories ?? []);
$user->remote = $request->has('remote') ? true : false;
$user->save();
    // Handle links
    $existingLinkIds = $user->links()->pluck('id')->toArray();
    $submittedLinkIds = collect($request->links ?? [])->pluck('id')->filter()->toArray();

    // Delete removed links
    $linksToDelete = array_diff($existingLinkIds, $submittedLinkIds);
    if (!empty($linksToDelete)) {
        $user->links()->whereIn('id', $linksToDelete)->delete();
    }

    // Update or create links
    foreach ($request->links ?? [] as $linkData) {
        if (!empty($linkData['id'])) {
            // Update existing link
            $link = $user->links()->where('id', $linkData['id'])->first();
            if ($link) {
                $link->update([
                    'title' => $linkData['title'],
                    'url' => $linkData['url'],
                ]);
            }
        } else {
            // Create new link
            if (!empty($linkData['title']) && !empty($linkData['url'])) {
                $user->links()->create([
                    'title' => $linkData['title'],
                    'url' => $linkData['url'],
                ]);
            }
        }
    }

    return redirect()->route('profile.edit')->with('success', 'Profile updated.');
}

}
