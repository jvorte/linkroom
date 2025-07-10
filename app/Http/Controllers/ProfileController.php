<?php

// ProfileController.php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\User;
use OpenAI;



use Smalot\PdfParser\Parser as PdfParser;
use PhpOffice\PhpWord\IOFactory as WordIOFactory;
use OpenAI\Client as OpenAIClient;

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

    // Διαγραφή φακέλου με όλα τα CV αρχεία
    $folderPath = 'cvs/' . $user->id;
    if (Storage::disk('public')->exists($folderPath)) {
        Storage::disk('public')->deleteDirectory($folderPath);
    }

    // Διαγραφή avatar αν υπάρχει
    if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
        Storage::disk('public')->delete($user->avatar);
    }

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
            'is_active' => 'nullable|boolean',
            'lang' => 'nullable|string',
        ]);

        // Χειρισμός avatar
 if ($request->hasFile('avatar')) {
    // Διαγραφή παλιού avatar αν υπάρχει
    if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
        Storage::disk('public')->delete($user->avatar);
    }

    // Αποθήκευση νέου avatar
    $path = $request->file('avatar')->store('avatars', 'public');
    $data['avatar'] = $path;
}

        // Ορισμός boolean πεδίων με ασφάλεια
        $data['is_active'] = $request->boolean('is_active');
        $data['remote'] = $request->has('remote');

        $user->update($data);

        // Sync categories
        $user->categories()->sync($request->categories ?? []);

        // Handle links
        $existingLinkIds = $user->links()->pluck('id')->toArray();
        $submittedLinkIds = collect($request->links ?? [])->pluck('id')->filter()->toArray();

        // Διαγραφή links που αφαιρέθηκαν
        $linksToDelete = array_diff($existingLinkIds, $submittedLinkIds);
        if (!empty($linksToDelete)) {
            $user->links()->whereIn('id', $linksToDelete)->delete();
        }

        if ($request->hasFile('cv')) {
            $request->validate([
                'cv' => 'file|mimes:pdf,doc,docx|max:2048',
            ]);

            // Διαγραφή παλιού αν υπάρχει
            if ($user->cv_path) {
                Storage::disk('public')->delete($user->cv_path);
            }

            $cvPath = $request->file('cv')->store('cvs/' . auth()->id(), 'public');

            $user->cv_path = $cvPath;
            $user->save(); // αποθηκεύει την αλλαγή στο DB
        }


        // Ενημέρωση ή δημιουργία links
        foreach ($request->links ?? [] as $linkData) {
            if (!empty($linkData['id'])) {
                $link = $user->links()->where('id', $linkData['id'])->first();
                if ($link) {
                    $link->update([
                        'title' => $linkData['title'],
                        'url' => $linkData['url'],
                    ]);
                }
            } else {
                if (!empty($linkData['title']) && !empty($linkData['url'])) {
                    $user->links()->create([
                        'title' => $linkData['title'],
                        'url' => $linkData['url'],
                    ]);
                }
            }
        }

        // Πάρε το lang από το request για το redirect
        $lang = $request->input('lang', app()->getLocale());

        return redirect()->route('profile.edit', ['lang' => $lang])
            ->with('status', 'profile-updated');
    }





    public function deleteCv(Request $request)
    {
        $user = auth()->user();

        if ($user->cv_path) {
            // Διαγραφή του αρχείου
            Storage::disk('public')->delete($user->cv_path);

            // Διαγραφή του φακέλου αν είναι άδειος
            $folderPath = dirname($user->cv_path); // πχ "cvs/14"
            $filesInFolder = Storage::disk('public')->files($folderPath);

            if (empty($filesInFolder)) {
                Storage::disk('public')->deleteDirectory($folderPath);
            }

            $user->cv_path = null;
            $user->save();
        }

        $lang = $request->input('lang', app()->getLocale());

        return redirect()->route('profile.edit', ['lang' => $lang])
            ->with('status', 'cv-deleted');
    }

public function downloadCv()
{
    $user = auth()->user();

    if (!$user->cv_path || !Storage::disk('public')->exists($user->cv_path)) {
        abort(404, 'File not found.');
    }

    $extension = pathinfo($user->cv_path, PATHINFO_EXTENSION);
    $downloadName = 'cv.' . $extension;

    return Storage::disk('public')->download($user->cv_path, $downloadName);
}





public function generateBioFromCv(Request $request)
{
    $user = auth()->user();

    

    // Φόρτωσε το path του ανέβασμένου CV
    $cvPath = storage_path('app/public/' . $user->cv_path);

    if (!file_exists($cvPath)) {
        return response()->json(['error' => 'No CV found for user.'], 404);
    }

    // Ανάγνωση περιεχομένου ανάλογα με τύπο αρχείου
    $extension = pathinfo($cvPath, PATHINFO_EXTENSION);

    try {
        if (strtolower($extension) === 'pdf') {
            $parser = new PdfParser();
            $pdf = $parser->parseFile($cvPath);
            $text = $pdf->getText();
        } elseif (in_array(strtolower($extension), ['doc', 'docx'])) {
            $phpWord = WordIOFactory::load($cvPath);
            $text = '';
            foreach ($phpWord->getSections() as $section) {
                $elements = $section->getElements();
                foreach ($elements as $element) {
                    if (method_exists($element, 'getText')) {
                        $text .= $element->getText() . "\n";
                    }
                }
            }
        } else {
            return response()->json(['error' => 'Unsupported CV format.'], 400);
        }

        if (trim($text) === '') {
            return response()->json(['error' => 'CV text is empty or could not be extracted.'], 400);
        }

    } catch (\Exception $e) {
        return response()->json(['error' => 'Error reading CV: ' . $e->getMessage()], 500);
    }

    // Δημιουργία πελάτη OpenAI
$openai = OpenAI::client(env('OPENAI_API_KEY'));


    // Prompt για σύντομο bio
  $prompt = "Please create a short professional bio written in the first person, as if the person is describing themselves, based on the following CV text :\n\n" . $text;


    try {
        $response = $openai->chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ],
            'max_tokens' => 300,
            'temperature' => 0.7,
        ]);

        $bio = trim($response->choices[0]->message->content ?? '');

        if (!$bio) {
            return response()->json(['error' => 'Failed to generate bio.'], 500);
        }

    } catch (\Exception $e) {
        return response()->json(['error' => 'OpenAI API error: ' . $e->getMessage()], 500);
    }

    return response()->json(['bio' => $bio]);
}




}
